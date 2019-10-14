<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Exceptions\InternalException;
use App\Exceptions\InvalidRequestException;
use App\Models\Order;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payByAlipay(Order $order, Request $request)
    {
        // 判断订单是否属于当前用户
        $this->authorize('own', $order);

        // 订单已支付或者已关闭
        if($order->paid_at || $order->closed){
            throw new InternalException('订单状态不正确');
        }

        // 调用支付宝的网页支付
        return app('alipay')->web([
            'out_trade_no' => $order->no, // 订单编号，需保证在商户端不重复
            'total_amount' => $order->total_amount, // 订单金额，单位元，支持小数点后两位
            'subject' => '支付 Laravel Shop 的订单：' . $order->no, // 订单标题
        ]);
    }

    // 前端回调页面
    public function alipayReturn()
    {
        //校验提交的参数是否合法

//        $data = app('alipay')->verify();
//        dd($data);
        try{
            app('alipay')->verify();
        } catch (\Exception $e) {
            return view('pages.error', ['msg' => '数据不正确']);
        }
        return view('pages.success', ['msg' => '付款成功']);
    }

    // 服务器端回调，注意此回调在公网可以访问的前提下才有效
    public function alipayNotify()
    {
        // 校验输入参数
        $data = app('alipay')->verify();

        // \Log::debug('Alipay notify', $data->all());

        // 如果订单状态不是成功或者结束，则不走后面的逻辑
        // 所有交易状态参照：https://docs.open.alipay.com/59/103672
        if(!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])){

            //返回数据给支付宝，支付宝得到这个返回之后就认为我们已经处理好这笔订单，不会再发生这笔订单的回调了。
            //如果我们返回其他数据给支付宝，支付宝就会每隔一段时间就发送一次服务器端回调，直到我们返回了正确的数据为准。
            return app('alipay')->success();
        }

        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
        $order = Order::where('no', $data->out_trade_no)->first();
        // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
        if (!$order) {
            return 'fail';
        }

        // 如果这笔订单的状态已经是已支付
        if($order->paid_at){
            return app('alipay')->success();
        }

        $order->update([
            'paid_at' => Carbon::now(),
            'payment_method' => 'alipay',
            'payment_no' => $data->trade_no, // 支付宝订单号
        ]);

        $this->afterPaid($order);

        return app('alipay')->success();
    }


    public function payByWechat(Order $order, Request $request)
    {
        // 校验权限
        $this->authorize('owm', $order);

        // 检验订单状态
        if($order->paid_at || $order->closed) {
            throw new InvalidRequestException('订单状态不正确');
        }

        // scan 方法为拉起微信扫码支付 （返回json对象）
        $wechatOrder = app('wechat_pay')->scan([
            'out_trade_no' => $order->no,  // 商户订单流水号，与支付宝 out_trade_no 一样
            'total_fee' => $order->total_amount * 100, // 与支付宝不同，微信支付的金额单位是分。
            'body'      => '支付 Laravel Shop 的订单：'.$order->no, // 订单描述
        ]);

        // 把要转换的字符串作为 QrCode 的构造函数参数
        $qrCode = new QrCode($wechatOrder->code_url);

        // 将生成的二维码图片数据以字符串形式输出，并带上相应的响应类型
        return response($qrCode->writeString(), 200, ['Content-Type' => $qrCode->getContentType()]);
    }

    // 微信支付只有服务端回调，没有前端回调
    public function wechatNotify()
    {
        // 校验回调参数是否正确
        $data = app('wechat_pay')->verify();

        // 找到对应的订单
        $order = Order::where('no', $data->out_trade_no)->first();

        // 订单不存在则告知微信支付
        if (!$order) {
            return 'fail';
        }

        // 订单已经支付
        if($order->paid_at){
            // 告知微信支付此订单已处理
            return app('wechat_pay')->success();
        }

        // 将订单标记为已经支付
        $order->update([
            'paid_at' => Carbon::now(),
            'payment_method' => 'wechat',
            'payment_no' => $data->transaction_id,
        ]);

        $this->afterPaid($order);

        return app('wechat_pay')->success();
    }

    protected function afterPaid(Order $order){
        event(new OrderPaid($order));
    }

    public function wechatRefundNotify(Request $request)
    {

        $data = app('wechat_pay')->verify(null, true);

        // 给微信的失败响应
        $failXml = '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[FAIL]]></return_msg></xml>';
        // 没有找到对应的订单，原则上不可能发生，保证代码健壮性
        if(!$order = Order::where('no', $data['out_trade_no'])->first()) {
            return $failXml;
        }

        if($data['refund_status'] === 'SUCCESS'){
            // 退款成功，将订单退款状态改为退款成功
            $order->update([
                'refund_status' => Order::REFUND_STATUS_SUCCESS,
            ]);
        } else {

            $extra = $order->extra;
            $extra['refund_failed_code'] = $data['refund_status'];

            // 退款失败，将具体状态存入extra字段，并将退款状态改为失败
            $order->update([
                'refund_status' => Order::REFUND_STATUS_FAILED,
                'extra' => $extra
            ]);
        }

        return app('wechat_pay')->success();
    }
}

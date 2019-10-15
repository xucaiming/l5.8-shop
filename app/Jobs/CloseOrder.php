<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order, $delay)
    {
        $this->order = $order;
        $this->delay($delay); // 设置延迟执行时间
    }

    public function handle()
    {
        // 判断对应的订单是否已支付
        if($this->order->paid_at){
            return;
        }

        // 通过事务执行sql
        \DB::transaction(function(){
            // 将订单的closed字段标记为true，即关闭订单
            $this->order->update(['closed' => true]);

            // 循环遍历订单中的商品SKU，将订单中的数量加回到SKU库存中去
            foreach ($this->order->items as $item){
                $item->productSku->addStock($item->amount);
            }

            // 将对应优惠券的用量减少
            if ($this->order->couponCode) {
                $this->order->couponCode->changeUsed(false);
            }
        });
    }
}

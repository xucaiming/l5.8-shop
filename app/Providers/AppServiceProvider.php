<?php

namespace App\Providers;

use App\Http\ViewComposers\CategoryTreeComposer;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Yansongda\Pay\Pay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //往容器中注入一个名为alipay的单例对象
        $this->app->singleton('alipay', function(){
            $config = config('pay.alipay');

            //notify_url 代表服务器端回调地址，return_url 代表前端回调地址
//            $config['notify_url'] = route('payment.alipay.notify'); // 注意要是公网可以访问的地址
            $config['notify_url'] = 'http://requestbin.net/r/wkhwn8wk'; // 可在http://requestbin.net模拟接收 然后在转到本地请求
            $config['return_url'] = route('payment.alipay.return');

            // 判断当前项目运行环境是否为线上环境
            if(app()->environment() !== 'production'){
                $config['mode'] = 'dev';
                $config['log']['level'] = Logger::DEBUG;
            } else {
                $config['log']['level'] = Logger::WARNING;
            }

            // 调用 Yansongda\Pay 来创建一个支付宝支付对象
            return Pay::alipay($config);
        });

        $this->app->singleton('wechat_pay', function(){
            $config = config('pay.wechat');
            $config['notify_url'] = 'http://*****'; // 公网可以访问的地址
            if(app()->environment() !== 'production'){
                $config['log']['level'] = Logger::DEBUG;
            } else {
                $config['log']['level'] = Logger::WARNING;
            }
            // 调用 Yansongda\Pay 来创建一个微信支付对象
            return Pay::wechat($config);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 当laravel渲染products.index 和 products.show模板时，就会使用CategoryTreeComposer这个来注入类目树变量
        // 同时laravel还支持通配符，例如products.*即代表渲染products目录下的模板时都执行这个ViewCompose
        \View::composer(['products.index', 'products.show'], CategoryTreeComposer::class);
    }
}

<?php

namespace App\Jobs;

use App\Models\CrowdfundingProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;

class RefundCrowdfundingOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $crowdfunding;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CrowdfundingProduct $crowdfunding)
    {
        $this->crowdfunding = $crowdfunding;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 如果众筹的状态不是失败则不执行退款，原则上不会发生，这里只是增加健壮性
        if($this->crowdfunding->status !== CrowdfundingProduct::STATUS_FAIL){
            return;
        }

        $orderService = app(OrderService::class);
        // 查询出所有参与了此众筹的订单
        Order::query()
            // 订单类型为众筹商品订单
            ->where('type', Order::TYPE_CROWDFUNDING)
            // 已支付的订单
            ->whereNotNull('paid_at')
            ->whereHas('items', function($query) use ($crowdfunding){
                // 包含了当前商品
                $query->where('product_id', $crowdfunding->product_id);
            })
            ->get()
            ->each(function(Order $order) use ($orderService){
                //调用退款逻辑
                $orderService->refundOrder($order);
            });
    }
}

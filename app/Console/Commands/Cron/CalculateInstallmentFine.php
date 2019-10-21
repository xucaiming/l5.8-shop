<?php

namespace App\Console\Commands\Cron;
use App\Models\InstallmentItem;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Installment;

class CalculateInstallmentFine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:calculate-installment-fine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算分期付款逾期费';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        InstallmentItem::query()
            ->with(['installment'])
            ->whereHas('installment', function($query){
                // 对应的分期状态为还款中
                $query->where('status', Installment::STATUS_REPAYING); // 对应的分期状态为还款中
            })
            ->where('due_date', '<=', Carbon::now()) // 还款截止日期在当前时间之前
            ->whereNull('paid_at') //尚未还款
            ->chunkById(1000, function($items){
                 // 遍历查询出来的还款计划
                foreach($items as $item){
                     // 通过Carbon对象的diffInDays 直接得到逾期天数
                    $overdueDays = Carbon::now()->diffInDays($items->due_date);
                    // 本金与手续费之和
                    $base = big_number($items->base)->add($items->fee)->getValue();
                    // 计算逾期费
                    $fine = big_number($base)
                            ->multiply($overdueDays)
                            ->multiply($items->installment->fine_rate)
                            ->divide(100)
                            ->getValue();

                    // 避免逾期费高于本金与手续费之和，使用 compareTo 方法来判断
                    // 如果 $fine 大于 $base，则 compareTo 会返回 1，相等返回 0，小于返回 -1
                    $fine = big_number($fine)->compareTo($base) === 1 ? $base : $fine;
                    $item->update([
                        'fine' => $fine,
                    ]);
                }
            });
    }
}

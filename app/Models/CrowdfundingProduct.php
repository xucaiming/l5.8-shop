<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrowdfundingProduct extends Model
{
    // 定义众筹的3种状态
    const STATUS_FUNDING = 'funding';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';

    public static $statusMap = [
        self::STATUS_FUNDING => '众筹中',
        self::STATUS_SUCCESS => '众筹成功',
        self::STATUS_FAIL => '众筹失败',
    ];

    protected $fillable = [
        'total_amount', 'target_amount', 'user_count', 'status', 'end_at'
    ];

    // end_at会自动转换为Carbon类型
    protected $dates = ['end_at'];

    // 不需要created_at 和 updated_at 字段
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 定义一个名为percent的访问器，返回当前众筹进展
    public function getPercentAttribute()
    {
        $value = $this->attributes['total_amount'] / $this->attributes['target_amount'];

        return floatval(number_format($value * 100, 2, '.', ''));
    }
}

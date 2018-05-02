<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;
    protected $guarded = ['_token'];

    public static function log($time,$content)
    {
        //首先创建一个新模型实例
        $log = new Log;
        //给这个模型添加属性
        $log->log_time = $time;
        $log->log_content = $content;
        //... 其它更多属性
        $log->save();
    }
}

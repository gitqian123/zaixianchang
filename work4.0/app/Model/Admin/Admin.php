<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'a_id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;
}

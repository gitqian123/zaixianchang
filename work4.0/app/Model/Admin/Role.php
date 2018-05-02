<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'role_id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;
    //关联Role_Node模型
    public static  function delRoleByRoleId($role_ids){
        return self::destroy($role_ids);
    }




}

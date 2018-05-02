<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class RoleNode extends Model
{
    protected $table = 'node_role';
    /**
     * 指定主键。
     */
    protected $primaryKey = '';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;
    //根据角色ID查询对应的权限ID
    public static function getNodeIdByRoleId($role_id){
        if (is_array($role_id)){
            return  self::whereIn("role_id",$role_id)->lists("node_id")->all();
        }else{
            return  self::where("role_id",$role_id)->lists("node_id")->all();
        }

    }
    public  static  function delRoleNodeByRoleId($role_id){
        self::where("role_id",$role_id)->delete();
    }

}

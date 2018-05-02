<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    /**
     * 与模型关联的数据表。
     */
    protected $table = 'node';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'node_id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;
    protected $guarded = ['_token'];

    //获取所有权限
//    public static function getNode(){
//      return  self::all();
//
//    }
    public static function getNode($left=0){
        if($left==1){
            return  self::where("node_show",0)->get();
        }else{
            return  self::all();

        }

    }
    //获取所有排序后的权限(递归的执行顺序)
    public static function getNodeOrder($node,$pid=0,$level=1){
        static $tmp;
        foreach ($node as $key=>$val){
            if ($val->node_pid==$pid){
                $val->level=$level;
                $tmp[]=$val;
                self::getNodeOrder($node,$val->node_id,$level+1);

            }
        }
        return $tmp;
    }

    public static function getCurrentNodes($left=0){
        $role_id=explode(',',session("admin")->role_id);
        //$role_id=[37];
        $node_id=RoleNode::getNodeIdByRoleId($role_id);
        $node_id=array_unique($node_id);
        if ($left==1){
            return self::where("node_show",0)->whereIn("node_id",$node_id)->get();
        }
       return self::whereIn("node_id",$node_id)->get();
    }

    //获取父子结构的权限(递归的返回值)
    public static function getNodeTree($node,$pid=0){
        $arr=[];
        foreach ($node as $key=>$val){
            if ($val->node_pid==$pid){
                $son=self::getNodeTree($node,$val->node_id);
                if(!empty($son))$val->son=$son;
                $arr[]=$val;
            }
        }

        return $arr;
    }

    //给出一个ID值找出他后代的ID值
    public static function getChildren($node,$node_id){
        static  $temp=[];
        foreach ($node as $key=>$val){
            if ($val->node_pid==$node_id){
                array_push($temp,$val->node_id);
                self::getChildren($node,$val->node_id);

            }
        }
        return $temp;
    }

    //根据角色ID查询权限名称
    public static function getNodeNameByRoleId($role_id){
        $node_id=RoleNode::getNodeIdByRoleId($role_id);
        //dd($node_id);
        $node_name=Node::whereIn("node_id",$node_id)->lists("node_name")->all();
        //dd($node_name);
        return implode(",",$node_name);
    }

    //根据多角色ID查询权限名称
    public static function getNodeNameByRoleIds($role_id){
        $nodeArr=[];
        foreach ($role_id as $val){
            $nodeStr=self::getNodeNameByRoleId($val);
            $nodeArr=array_merge($nodeArr,explode(",",$nodeStr));
            $nodeArr=array_unique($nodeArr);
        }
        return implode(",",$nodeArr);
    }
    //根据id获取pid
    public static function getNodePid($id=null){
        return Node::select('node_pid')->where("node_pid",$id)->first();
    }


}

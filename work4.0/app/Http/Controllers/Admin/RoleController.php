<?php

namespace App\Http\Controllers\Admin;

use App\Http\Middleware\adminLoginMiddleware;
use App\Model\Admin\Node;
use App\Model\Admin\Role;
use App\Model\Admin\RoleNode;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends CommonController
{
    //角色添加
    public function add(){
      if(request()->isMethod('get')){
          $node=Node::getNode();
          $nodeTree=Node::getNodeTree($node);
          // dd($nodeTree);
          return view('admin/roleAdd',compact('nodeTree'));
      }
      if (request()->isMethod('post')){
            $roleObj=new Role();
            $roleObj->role_name=request()->input("role_name")?request()->input("role_name"):"";
            $roleObj->role_status=request()->input("role_status")?request()->input("role_status"):"";
            $roleObj->role_desc=request()->input("role_desc")?request()->input("role_desc"):"";
            //dd($roleObj);
            if($roleObj->role_name && $roleObj->role_status && request()->input("node_id"))
            {
                $role=$roleObj->save();
            }else{
                return redirect()->back();
            }
            if ($role&& request()->input("node_id")){
                $data=[];
                foreach (request()->input("node_id")as $key=>$val){
                    $data[]=['role_id'=>$roleObj->role_id,'node_id'=>$val];
                }
                RoleNode::insert($data);
            }
            return redirect("admin/roleLists");
      }else{
          return redirect()->back()->with("添加角色失败");
      }
    }
    //角色展示
    protected function lists(){
        $roles=Role::orderBy("role_status","asc")->get();
        //dd($roles);exit();
        foreach ($roles as $k=>$v){
            $roles[$k]->node=Node::getNodeNameByRoleId($v->role_id);
        }
        //dd($roles);
        return view('admin/roleLists',compact("roles"));
    }

    //角色修改
    protected function update($role_id=null){
      if(request()->isMethod('get')){
          $role_id=$_GET['id']?base64_decode($_GET['id']):"";
          $role_id=(int)$role_id;
          if(is_int($role_id)){
              //根据角色ID获取单个角色信息
              $role=Role::find($role_id);
              //根据角色ID获取对应的权限
              $roleNode=RoleNode::getNodeIdByRoleId($role_id);
              //dd($roleNode);
              //获取所有权限
              $node=Node::getNode();
              //循环所有权限和角色ID对应的权限对比
              foreach ($node as $key=>$val){
                  $node[$key]->checked=in_array($val->node_id,$roleNode)?1:0;
              }
              $nodeTree=Node::getNodeTree($node);
              return view('admin/roleUpdate',compact("nodeTree","role",'role_id'));
          }
          //dd($nodeTree);
          return redirect()->back();
      }

      if (request()->isMethod('post')){
          //根据角色id更新角色信息
          $role_id=request()->input('id');
          //dd($role_id);
          if(isset($role_id))//判断角色id是否存在
          {
              $roleObj=Role::find($role_id);
              $roleObj->role_name=request()->input('role_name');
              $roleObj->role_status=request()->input('role_status');
              $roleObj->role_desc=request()->input('role_desc');
              $role=$roleObj->save();
              if ($role)
              {
                  //根据角色id先删除下原来的权限在添加新的权限
                  RoleNode::where('role_id',$role_id)->delete();
                  $node_id=request()->input('node_id');
                  if ($node_id)
                  {
                      $data=[];
                      foreach ($node_id as $key=>$val)
                      {
                          $data[]=['role_id'=>$roleObj->role_id,'node_id'=>$val];
                      }
                      RoleNode::insert($data);
                  }
                  return redirect('admin/roleLists');
              }else
              {
                  return redirect()->back()->with("修改角色失败");
              }

          }
          return redirect()->back();
      }
    }

    //角色删除
    protected function delete(){
      /* $role_id=Role::where('role_id',34)->delete();
       var_dump($role_id);
       if($role_id){
           RoleNode::where("role_id",34)->delete();
           echo "ok";
       }
       exit;*/
        //先查询该角色有没有被管理员拥有
//         if(true){
//             //删除不了,给出提示
//         }else{
             //先把role表的单条数据清掉
        $id=$_GET['id']?base64_decode($_GET['id']):"";
        $role_id=(int)$id;
        if(is_int($role_id)){
            if(Role::delRoleByRoleId($role_id)){
                RoleNode::delRoleNodeByRoleId($role_id);
                return redirect('admin/roleLists');
            }
            return redirect()->back();
        }
        //exit;
//         }
        //select * from  admin where role_id like "%2%";
       /* if ( DB::table('role')->where("role_id",$role_id)->delete()){
            if (DB::table('node_role')->where("role_id",$role_id)->delete()){
                return redirect('admin/roleLists');
            }else{
                return redirect()->back()->with("修改角色失败");
            }
        }*/







    }
}

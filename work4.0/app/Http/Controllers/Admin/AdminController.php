<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Admin;
use App\Model\Admin\Node;
use App\Model\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class AdminController extends CommonController
{
    //管理员显示
    protected function lists(){
        $admin=Admin::select('a_id','a_name','a_time','a_status','role_id','role_name','a_phone')->where('a_status',1)->orwhere('a_status',0)->get();
        //dd($admin);
        //$admin=[];
        foreach ($admin as $key=>$val){
            $admin[$key]->node=Node::getNodeNameByRoleIds(explode(",",$val->role_id));
           //Node::getNodeNameByRoleIds(explode(",",$val->role_id));
           //array_push($admin,$val);

        }
        //var_dump($admin);
        return view('admin/adminlists',compact("admin"));

    }

    //管理员添加
    protected function add(){
        if (request()->isMethod('get')){
            $role=Role::select('role_id','role_name','role_status','role_desc')->where('role_status',1)->get();
//            var_dump($role);die;
            return view('admin/adminadd',compact('role'));
        }
        if (request()->isMethod('post')){
            $a_name=request()->input('a_name');
            if(Admin::where('a_name','=',$a_name)->first()){
                return redirect()->back();
            }
            $data=new Admin();
            $data->a_name=request()->input('a_name');
            $data->a_password=md5(md5(request()->input('a_password')));
            $data->a_status=request()->input('a_status');
            $data->a_phone=request()->input('a_phone');
            $data->a_time=time();
            $data->role_id=implode(',',request()->input('role_id'));
            $data->role_name=request()->input('role_name');
            //dd($data);exit();
           //$admin=DB::table('admin')->insert(['a_name'=>"$a_name",'a_password'=>"$a_password",'a_time'=>time()]);
           if ($data->save()){
               return redirect('admin/adminlists');
           }else{
               return back();
           }
        }



    }
    //管理员删除
    protected function delete($id=null)
    {
        $id=request()->get('admin_id');
        //$id=$_GET['id']? base64_decode($_GET['id']):"";
        $admin=DB::table('admin')->where('a_id',$id)->update(['a_status'=>2]);
        if($admin){
            return json_encode(1);
        }else{
            return json_encode(2);
        }

    }

    //管理员修改
    protected function update()
    {
        if(request()->isMethod('get')){
            $id=$_GET['id']? base64_decode($_GET['id']):"";
            $data=DB::table("admin")->where('a_id',$id)->first();
            //$data=decrypt($data->a_password);
            //print_r($data);exit;
            return view('admin/adminupdate',compact('data'));
        }
        if (request()->isMethod('post')){
            //dd(request()->all());
            $a_name=request()->input("a_name");
            $a_id=request()->input("a_id");
            $a_phone=request()->input("a_phone");
            $a_status=request()->input("a_status");
            if($a_name && $a_phone &&  $a_id)
            {
                $a_password=md5(md5((request()->input("a_password"))));
                $update=DB::table("admin")->where('a_id',$a_id)->update(["a_name"=>$a_name,"a_password"=>$a_password,"a_phone"=>$a_phone,"a_status"=>$a_status]);
                if($update){
                    return redirect("admin/adminlists");
                }else{
                    return back();
                }
            }
            return back();

        }


    }

    //重新赋权
    protected function setnode($a_id=null)
    {
        if (request()->isMethod('get')){
            $a_id=$_GET['id']? base64_decode($_GET['id']):"";
            $a_id=(int)$a_id;
            //dd($a_id);
            if(is_int($a_id)){
                //查出所有的角色
                $role=Role::where('role_status',1)->get();
                //echo $admin_id;
                //dd($role);
                //根据管理员ID产出对应的管理员名称.角色ID.角色名称
                $admin=Admin::select("a_name","role_id","role_name")->where("a_id",$a_id)->first();
                $a_name=$admin->a_name;
//            dd($admin);
                foreach ($role as $key=>$val){
                    if (in_array($val->role_id,explode(',',$admin->role_id))){
                        $role[$key]->checked=1;
                    }else{
                        $role[$key]->checked=0;
                    }
                }
                //dd($role);
                return view('admin/adminsetnode',compact("role",'a_name','a_id'));
            }
        }

        if (request()->isMethod('post')){
            $role_id=implode(',',request()->input('role_id'));
            $role_name=request()->input('role_name');
            $a_id=base64_decode(request()->input('ids'));
            $a_id=(int)$a_id;
            //dd($role_id);
            $update=DB::table("admin")->where('a_id',$a_id)->update(["role_id"=>$role_id,"role_name"=>$role_name]);
            if($update){
                return redirect("admin/adminlists");
            }else{
                return back();
            }
        }

    }



}

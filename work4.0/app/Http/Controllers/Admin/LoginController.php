<?php

namespace App\Http\Controllers\Admin;
use App\Model\Admin\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //登录验证
    protected function login(Request $request){
        if($request->isMethod("GET")){
            return view('admin/login');
        }
        if($request->isMethod("POST")){
            $rules=[
                'a_name'=>'required|regex:/[a-z]{3,10}/',
                'a_password'=>'required|between:3,10',
            ];
            $msg=[
                'a_name.required'=>"用户名不能为空",
                'a_name.regex'=>'用户名必须是3-10位的小写字母',
                'a_password.required'=>'用户密码不能为空',
                'a_password.between'=>'用户密码必须3-10位',
//                'code.required'=>'验证码不能为空',
            ];
            $this->validate(request(),$rules,$msg);
            $a_name=$request->input('a_name');
            $a_password=md5(md5($request->input('a_password')));
            //dd($a_password);
            $admin=DB::table("admin")->select('a_name','a_id','a_time','a_status','role_id','role_name')
                ->where("a_name",$a_name)->where("a_password",$a_password)->first();
            if($admin && $admin->a_status==1 ){
                Cookie::queue("admin",$admin->a_name,24*60*60);//设置cookie时间为24小时
                $request->session()->put("admin",$admin,24*60*60);
                $time=date("Y-m-d H:i:s",time());//时间
                $content=session()->get('admin')->a_name."在".$time."登录"."ip地址为".$_SERVER['REMOTE_ADDR'];//内容
                Log::log($time,$content);//添加日志
                return redirect('admin/indexlists');
            }else{
                return redirect()->back()->withInput(['a_name'=>$a_name])->with(['msg'=>'登录失败']);
            }
        }
    }
    //退出登录
    protected function logout(){
        $admin_cookie = Cookie::queue(Cookie::forget("admin"));
        if($admin_cookie==null  ){
            $time=date("Y-m-d H:i:s",time());//时间
            $content=session()->get('admin')->a_name."在".$time."退出"."ip地址为".$_SERVER['REMOTE_ADDR'];//内容
            Log::log($time,$content);//添加日志
            return  redirect('admin/adminlogin');
        }else{
            return redirect()->back();
        }
        //session()
    }

}

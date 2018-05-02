<?php

namespace App\Http\Middleware;

use Closure;

class adminLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //处理七天免登陆
//        if($request->cookie("admin")!=null && session("admin")==null){
//            session()->put("admin",$request->cookie('admin'));
//        }
        //处理非法登录
        if (session()->has("admin") && $request->cookie('admin')){
            return $next($request);
        }else{
            return redirect('admin/adminlogin')->with('msg','请先登录');
        }
    }
}

<?php

namespace App\Http\Middleware;

use App\Model\Admin\Node;
use Closure;
use Illuminate\Support\Facades\DB;

class NodeCheckMiddleware
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
        //获取当前操作的控制器和方法
       $accessInfo=$this->getCurrentAction(request()->route()->getActionName());
       //当用户名为超级管理员时不用检查权限
       if (in_array(session("admin")->a_name,config("admin.superadmin",["admin"]))){
           return $next($request);
       };
        //当控制器为指定控制器时不用检查权限
       if(in_array($accessInfo["controller_name"],config("admin.commoncontroller",[]))){
           return $next($request);
       }
        //获取当前用户拥有的所有权限
      $currentNodes=$this->getCurrentNodes();
     // echo strlen($accessInfo['access']);
      if (!in_array($accessInfo['access'],$currentNodes)){
          return redirect("admin/indexlists");
      }
        return $next($request);

    }
    //获取当前用户拥有的所有权限
    public function getCurrentNodes(){
        $mynode=Node::getCurrentNodes();
        $currentNodes=[];
        foreach ($mynode as $key=>$val){
            array_push($currentNodes,$val->node_controller."@".$val->node_action);
        }
       return $currentNodes;
    }
//获取当前操作的控制器和方法
    public function getCurrentAction($path){
        $arr=explode("@",$path);
        $controller_name=basename($arr[0]);
        return ["method_name"=>$arr[1],"controller_name"=>$controller_name,"access"=>$controller_name."@".$arr[1]];
    }


}

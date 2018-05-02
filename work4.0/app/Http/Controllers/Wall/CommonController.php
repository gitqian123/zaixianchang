<?php

namespace App\Http\Controllers\Wall;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{

    public function __construct()
    {
//        $memcache = new Memcache;             //创建一个memcache对象
//        $memcache->connect('localhost', 11211) or die ("Could not connect"); //连接Memcached服务器
    }
    protected function Name()
    {
        $name=session()->get("admin");
        if($name){
            $name=$name->a_name;
            return $name;
        }
        return redirect("admin/adminlogin");
    }
    //返回数据
    protected function callback($status,$All,$count)
    {
        $data['status']=$status;
        $data['data']=$All;
        $data['number']=$count;
        $data['message']="success";
        return json_encode($data);
    }

}
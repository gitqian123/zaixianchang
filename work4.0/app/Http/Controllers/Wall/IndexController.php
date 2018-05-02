<?php

namespace App\Http\Controllers\Wall;

use App\Model\Wall\Signin;
use Illuminate\Support\Facades\Cache;

class IndexController extends CommonController
{
    //不断刷新接口
    protected function index()
    {
        //$name="admin";
        $name=$this->Name();
        $signin="signin_".$name;
        //Cache::forget('signin');//删除缓存
        //缓存不存在
        if(!Cache::get($signin))
        {
            //return 1;
            $All=Signin::GetSignin($name);
            Cache::put($signin,$All,60*24);//存入缓存
            $num=count(Cache::get($signin));
            return $this->callback(200,$All,$num);
        }
        //return 2;
        $num=count(Cache::get($signin));//统计缓存的长度
        $count=Signin::CountSignin($name);//数据库取出来的长度
        //return json_encode(Signin::GetSignin($name));die;
        if($num <= $count)
        {
            $cache=Cache::get($signin);
            $All=Signin::GetSignin($name);
            //给出新签到的信息
            foreach($All as $k=>$v)
            {
                if(in_array($v, $cache))
                {
                    unset($All[$k]);
                }
            }
            //num与count 相等且信息相同
            if($All==[])
            {
                return $this->callback(200,[],$count);
            }
            $data=[];
            foreach($All as $key=>$val)
            {
                $data[]=$val;
            }
            // return json_encode($data);die;
            $call=array_merge_recursive($cache,$All);
            //return json_encode($call);die;
            Cache::put($signin,$call,60*24);//存入缓存
            //print_r($All);die;
            return $this->callback(200,$data,$count);
        }
        if($num-$count>25){
            Cache::forget($signin);//删除缓存
            $All=Signin::GetSignin($name);
            Cache::put($signin,$All,60*24);//存入缓存
            $num=count(Cache::get($signin));
            return $this->callback(200,$All,$num);
        }
//        $array=[];
//        //return json_encode(Cache::get('signin'));die;
//       return $this->callback(200,$array,$count);

    }
    //总数接口
    protected function GetSigninAll()
    {
        //$name="admin";
        $name=$this->Name();
        $signin="signin_".$name;
        $All=Signin::GetSignin($name);
        $count=Signin::CountSignin($name);
        Cache::forget($signin);//删除缓存
        Cache::put($signin,$All,60*24);//存入缓存
        return $this->callback(200,$All,$count);

    }


}
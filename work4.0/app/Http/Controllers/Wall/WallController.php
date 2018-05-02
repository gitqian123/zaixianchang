<?php

namespace App\Http\Controllers\Wall;
use App\Model\Wall\Signin;
use App\Model\Wall\Wall;
use Illuminate\Support\Facades\Cache;

class WallController extends CommonController
{
    protected function lists()
    {
        //$name="admin";
        $name=$this->Name();
        $cache="wall_".$name;
        //Cache::forget('wall');//删除缓存
        //缓存不存在
        if(!Cache::get($cache))
        {
            $All=Wall::GetWall($name);
            foreach($All as $k=>$v)
            {
                $All[$k]['wall_content']=base64_decode($v['wall_content']);
            }
            Cache::put($cache,$All,60*24);//存入缓存
           // return 1;
            return $this->callbacks(200,$All);
        }
        $wall=Cache::get($cache);
        //return json_encode($wall);
        $All=Wall::GetWall($name);
        if($All==[])
        {
            return $this->callbacks(200,[]);
        }
        //return json_encode($All);
        $arr=[];
        foreach($All as $key=>$val)
        {
            $All[$key]['wall_content']=base64_decode($val['wall_content']);
            $arr[]=$All[$key];
        }
        Cache::put($cache,$arr,60*24);//存入缓存
        foreach($arr as $k=>$v)
        {
            if(in_array($v,$wall))
            {
                unset($arr[$k]);
            }
        }
        //return json_encode($arr);
        if($arr==[])
        {
            return $this->callbacks(200,[]);
        }
        $data=[];
        foreach($arr as $a=>$b)
        {
            $data[]=$b;
        }
        //return json_encode($data);
        return $this->callbacks(200,$data);
        //var_dump($wall);die;
       // return $this->callbacks(200,$wall);

    }

    private function callbacks($status,$All)
    {
        $data['message']="success";
        $data['status']=$status;
        $data['data']=$All;
        return json_encode($data);
    }
}
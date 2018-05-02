<?php

namespace App\Http\Controllers\Wall;
use App\Model\Admin\Prize;
use App\Model\Admin\Winning;
use App\Model\Wall\Signin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PrizeController extends CommonController
{
    /**
     * 获取不是内定抽奖人的信息
     **/
    protected function prizes()
    {
        //header("Access-Control-Allow-Origin:*");
        $admin=$this->Name();
        //$admin="admin";
        $prizeLists=Signin::NotPrizeDefault($admin);
        $prizesAll["status"]=200;
        $prizesAll["message"]="success";
        $prizesAll["data"]=$prizeLists;
        return json_encode($prizesAll);
    }
    /**
     * 获取奖品的信息
     **/
    protected function lists()
    {
        //header("Access-Control-Allow-Origin:*");
        $admin=$this->Name();
       // $admin="admin";
        $prizeLists=Prize::Prize($admin);
        foreach($prizeLists as $k=>$v)
        {
            $sign_prize=DB::table("sign_prize")->select("sign_id")->where("prize_id",$v['id'])->get();
            $sign_prize=json_decode(json_encode($sign_prize),true);
            $prizeLists[$k]["prize_sign"]=$sign_prize;
            foreach($prizeLists[$k]["prize_sign"] as $key=>$val)
            {
                $signin=DB::table("huyu_signin")->select("signin_nickname","signin_headimgurl","signin_openid")->where("id",$val['sign_id'])->get();
                $signin=json_decode(json_encode($signin),true);
                foreach($signin as $m=>$n)
                {
                    $prizeLists[$k]["prize_sign"][$key]=$n;
                }
            }
        }
        $prizeAll["status"]=200;
        $prizeAll["message"]="success";
        $prizeAll["data"]=$prizeLists;
        return json_encode($prizeAll);
    }
    /**
     * 添加中奖的信息
     **/
    protected  function prizeWinn(Request $request)
    {
        if($request->isMethod("post"))
        {
            $all=file_get_contents('php://input');
            //return $all;
//            Cache::put('prizeWinn',$all,60);//存入缓存
//            $cache=Cache::get('prizeWinn');
//            return $cache;
            $prizeWinn=json_decode($all,true);
            //$winning_admin="admin";
            $winning_admin=session()->get("admin");
            if($winning_admin){ $winning_admin=$winning_admin->a_name;}
//            return $winning_admin;
            $winning_time=time();
            $winn=[];
            foreach($prizeWinn['prize_sign'] as $key=>$val)
            {
               // return $val["signin_openid"];
                $winn=Winning::Winn($val['signin_nickname'],$val['signin_headimgurl'],$prizeWinn['prize_img'],$winning_admin,$prizeWinn['prize_name'],$winning_time,$val['signin_openid']);
                $id=DB::table("huyu_signin")->where("signin_openid",$val["signin_openid"])->value("id");
                //return json_encode($id);
                DB::table("sign_prize")->where("sign_id",$id)->delete();
                DB::table("huyu_signin")->where("signin_openid",$val['signin_openid'])->where("signin_headimgurl",$val['signin_headimgurl'])->update(['signin_default'=>1]);
            }
            if($winn)
            {
                $data["status"]=200;
                $data["message"]="success";
                return json_encode($data);
            }
            $data["status"]=201;
            $data["message"]="failed";
            return json_encode($data);
        }

    }

    /***
     *   获取中奖名单
     **/
    protected function getWinn()
    {
        $name=$this->Name();
        $All=Winning::getWinn($name);
        $prizeIdImg=Prize::PrizeNameImg($name);
        //var_dump($prizeIdImg);
        $arr=[];
        $data=[];
        $winn=[];
        foreach($All as $key=>$val)
        {
            $arr[$key]["prize_name"]=$val['winning_name'];
            $arr[$key]["prize_img"]=$val['winning_img'];
        }
        //var_dump($arr);
        foreach($prizeIdImg as $k=>$v) if(!in_array($v, $arr)) unset($prizeIdImg[$k]);
        foreach($prizeIdImg as $m=>$n){
            $data[]=$n;
        }
        //var_dump($data);
        foreach($data as $e=>$w){
            foreach($All as $p=>$z){
                if($z['winning_name']==$w["prize_name"])
                {
                    if($z['winning_img']==$w["prize_img"])
                    {
//                        $data[$e]["data"][]["winng_user"]=$z["winning_user"];
//                        $data[$e]["data"][]["winning_userimg"]=$z["winning_userimg"];
                        $data[$e]["date"][$p]["winning_user"]=$z["winning_user"];
                        $data[$e]["date"][$p]["winning_userimg"]=$z["winning_userimg"];
//                        $winn[$p]["winning_user"]=$z["winning_user"];
//                        $winn[$p]["winning_userimg"]=$z["winning_userimg"];
                        //$data[$e]["data"]=$winn;
                    }
                }
            }

        }
        foreach($data as $d=>$t)
        {
            $data[$d]["date"]=[$t["date"]];
            foreach($t["date"] as $a=>$b)
            {
                $data[$d]["winn"][]=$b;
                unset( $data[$d]["date"]);
            }
        }
        $winn["status"]=200;
        $winn["message"]="success";
        $winn["data"]=$data;
        return json_encode($winn);
//        $temp=[];
//        foreach ($arr as $v){
//            $v=join(',',$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
//            $temp[]=$v;
//        }
//        $temp=array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
//        foreach ($temp as $k => $v){
//            $temp[$k]=explode(',',$v);   //再将拆开的数组重新组装
//        }
//
//        return $temp;
        //return json_encode($ff);
        //print_r($data);die;

    }
}
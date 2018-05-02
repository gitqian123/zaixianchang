<?php

namespace App\Http\Controllers\Mobile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MobileSignController extends Controller
{
    //进入手机端授权登录
    protected function index()
    {
        if(!isset($_GET["vcode"]))
        {
            return "活动未开始";
        }
        $vcode=$_GET["vcode"];
        if($vcode=="")
        {
            return "活动未开始";
        }
        Cache::put("vcode",$_GET["vcode"],20);
//        $vcode=Cache::get("vcode");
//        dd($vcode);
        $this->mobSign();
    }

    //微信登录授权 已签到过的
    protected function mobSign()
    {
        $vcode=Cache::get("vcode");
        $Ip=$_SERVER['SERVER_NAME'];
        header("Content-type: text/html; charset=utf-8"); //注明编码格式
        // 回调地址
        $url = urlencode("http://".$Ip."/mobile/mobSign");
        $url2 = urlencode("http://".$Ip."/mobile/weixinShow?vcode=".$vcode);//URL编码
        //获取到网页授权的access_token
        $appid = "wxb08105797302f979";//填写公众号或服务号、测试号的appid
        $appsecret = "2a4c57ce38b7c6b69aafe6f99e745092";//填写对应的secriet
        // 先进行静默授权，判断openid是否和数据库相匹配，如匹配则直接登录，否则进行复杂授权。
        if (!isset($_GET['code'])) {
            header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$url.'&response_type=code&scope=snsapi_base&state=123#wechat_redirect');
            exit;
        } else {
            $code = $_GET['code'];//获取code
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
            $res = $this->https_request($url);//请求接口返回数据
            $res = (json_decode($res, true));
            $openid = $res['openid'];//输出openid
            $ip=$_SERVER['SERVER_NAME'];
            //连接数据库，进行mysql数据匹配
            $id = DB::table("huyu_signin")->select("id", "signin_openid","signin_adminer")->where("signin_adminer",$vcode)->where("signin_openid", $openid)->first();
            if ($id) {
                header('Location:/sign_mob?vcode='.$id->signin_adminer.'&signin_openid='.$id->signin_openid);
                exit;
            } else {
                //获取用户微信信息
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$url2."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
                header('location:'.$url);
                exit;
            }
        }

    }

    //未签到 获取用户信息
    protected function mobSignShow(Request $request)
    {
        $vcode=$request->get("vcode");
        header("Content-type: text/html; charset=utf-8"); //注明编码格式
        // 公众号的id和secret
        $appid = "wxb08105797302f979";//填写公众号或服务号、测试号的appid
        $appsecret = "2a4c57ce38b7c6b69aafe6f99e745092";//填写对应的secriet
        $code = $_GET['code'];//获取code
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $res = $this->https_request($url);//请求接口返回数据
        $res=(json_decode($res, true));
        $openid = $res['openid'];
        $access_token = $res['access_token'];
        $url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->https_request($url);//请求接口返回数据
        $res=(json_decode($res, true));
        $_SESSION = $res;
        $time=time();
        $ip=$_SERVER['SERVER_NAME'];
//        $admin=session()->get("admin");
//        if(isset($admin)){  $name=$admin->a_name;}else{$name="";}
       // $vcode=Cache::get("vcode");
       // dd($vcode);
        $config=DB::table("signin_config")->select("signin_audit")->where("signin_adminer",$vcode)->first();
        if($config)
        {
            if($config->signin_audit==1){
                $insert=DB::table("huyu_signin")
                    ->insert(["signin_nickname"=>$res['nickname'],"signin_openid"=>$openid,"signin_headimgurl"=>$res['headimgurl'],"signin_time"=>$time,"signin_adminer"=>$vcode]);
            }else{
                $insert=DB::table("huyu_signin")
                    ->insert(["signin_nickname"=>$res['nickname'],"signin_status"=>0,"signin_openid"=>$openid,"signin_headimgurl"=>$res['headimgurl'],"signin_time"=>$time,"signin_adminer"=>$vcode]);
            }

            if($insert)
            {
              //  header('Location:http://192.168.1.172:8082?vcode='.$id->signin_adminer.'&signin_openid='.$id->signin_openid);
                header('Location:/sign_mob?vcode='.$vcode.'&signin_openid='.$openid);
                exit;
//                $user["signin_nickname"]=$res['nickname'];
//                $user["openid"]=$openid;
//                $user["headimgurl"]=$res['headimgurl'];
//                $data["status"]=200;
//                $data["message"]="签到成功";
//                $data["data"]=$user;
//                return json_encode($data);
            }
        }

        header('Location:/sign_mob?vcode='.$vcode);
        exit;
    }

    // cURL函数简单封装
    protected function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    protected function show()
    {

    }
}
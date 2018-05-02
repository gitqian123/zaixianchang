<?php

namespace App\Model\Wall;
use Illuminate\Database\Eloquent\Model;
class Signin extends Model
{
    protected $table = 'huyu_signin';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;

    /**
     * GetSignin 获取审核通过的信息
    **/
    public static function GetSignin($name)
    {
        $signin=self::select("signin_nickname","signin_headimgurl","signin_openid","signin_adminer")
            ->where("signin_status",1)->where("signin_adminer",$name)->orderBy("signin_time","desc")->get()->toArray();
        return $signin;
    }
    /**
     * CountSignin 统计审核通过的长度
     **/
    public static function CountSignin($name)
    {
        return self::select("id")->where("signin_status",1)->where("signin_adminer",$name)->count();
    }
    /**
     * NotPrizeDefault 不是抽奖内定人的名单
     **/
    public static function NotPrizeDefault($name)
    {
        return self::select("signin_nickname","signin_headimgurl","signin_openid")
            ->where("signin_status",1)->where("signin_adminer",$name)->where("signin_default",0)->get()->toArray();
    }

    /**
     * 手机端
     * Openid
     **/
    public static function Openid($name,$openid)
    {
        return self::select("signin_nickname","signin_headimgurl")->where("signin_adminer",$name)->where("signin_openid",$openid)->first();
    }

}

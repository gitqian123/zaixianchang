<?php

namespace App\Model\Admin;
use Illuminate\Database\Eloquent\Model;

class Winning extends Model
{
    protected $table = 'huyu_winning';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;
    public static function GetWinningAll($adminName)
    {
       return self::select("id","winning_user","winning_name","winning_img","winning_userimg","winning_time","winning_status")
            ->where("winning_admin",$adminName)->get();
    }
    public static function WinningDel($id,$adminName)
    {
        return self::where("winning_admin",$adminName)->where("id",$id)->delete();
    }

    /**
     * 添加大屏幕中奖名单
    **/
    public static function Winn($winning_user,$winning_userimg,$winning_img,$winning_admin,$winning_name,$winning_time,$openid)
    {
        return self::insert(['winning_user'=>$winning_user,"winning_time"=>$winning_time,"winning_userimg"=>$winning_userimg,"winning_img"=>$winning_img,"winning_admin"=>$winning_admin,"winning_name"=>$winning_name,"winning_openid"=>$openid]);
    }
    /**
     * 获取大屏幕中奖名单
     **/
    public static function getWinn($admin)
    {
        return self::select("winning_user","winning_name","winning_img","winning_userimg")->where("winning_admin",$admin)->get()->toArray();
    }

}

<?php

namespace App\Model\Wall;
use Illuminate\Database\Eloquent\Model;
class Wall extends Model
{
    protected $table = 'huyu_wall';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;

    /**
     * GetWall 获取审核通过的信息
     **/
    public static function GetWall($name)
    {
        $wall=self::join('huyu_signin','huyu_wall.wall_openid','=','huyu_signin.signin_openid')
            ->select("huyu_signin.signin_headimgurl","huyu_wall.wall_content","huyu_wall.wall_nickname","huyu_wall.wall_openid")
            ->where("huyu_wall.wall_status",1)->where("huyu_wall.wall_admin",$name)->orderBy("huyu_wall.wall_time","desc")
            ->where('huyu_signin.signin_adminer','=',$name)
            ->get()->toArray();
        return $wall;
    }

    /**
     * getWallFirst 获取审核通过的信息
     **/
    public static function getWallFirst($openid,$name)
    {
        $content=self::select("wall_content")->where("wall_openid",$openid)->where("wall_admin",$name)->where("wall_status",1)->get()->toArray();
        return $content;
    }

    /**
     * AddWall 手机端 添加用户消息内容
     **/
    public static function AddWall($content,$signin_openid,$vcode,$signin_nickname,$wall_status,$time)
    {
        $Add=self::insert(["wall_content"=>$content,"wall_openid"=>$signin_openid,"wall_admin"=>$vcode,"wall_nickname"=>$signin_nickname,"wall_status"=>$wall_status,"wall_time"=>$time]);
        return $Add;
    }

}

<?php

namespace App\Model\Mobile;
use Illuminate\Database\Eloquent\Model;
class VoteUser extends Model
{
    protected $table = 'vote_option_user';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;

    /**
     * AddVote 添加投票结果
     **/
    public static function AddVote($openid,$name,$option_id,$vote_id)
    {
        self::insert(["openid"=>$openid,"admin"=>$name,"option_id"=>$option_id,"vote_id"=>$vote_id]);
    }
    /**
     * GetVote 获取投票的信息
     **/
    public static function GetVote($name)
    {
        $vote=self::select("vote_title","id","vote_status")
            ->where("vote_show",1)->where("vote_admin",$name)->orderBy("id","asc")->get()->toArray();
        return $vote;
    }



}

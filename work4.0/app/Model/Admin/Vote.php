<?php

namespace App\Model\Admin;
use Illuminate\Database\Eloquent\Model;
class Vote extends Model
{
    protected $table = 'huyu_vote';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;

    public static function GetVote($Admin)
    {
        return self::select("id","vote_title","vote_time","vote_status","vote_show")->where("vote_admin",$Admin)->get();
    }
    public static function GetVoteFirstDel($id,$Admin)
    {
        return self::where("id",$id)->where("vote_admin",$Admin)->delete();
    }
    public static function UpdateStatus($id,$status)
    {
       return self::where("id",$id)->update(["vote_status"=>$status]);
    }
    public static function UpdateShow($id,$show)
    {
        return self::where("id",$id)->update(["vote_show"=>$show]);
    }
    public static function GetVoteUpdate($id)
    {
        return self::select("id","vote_title","vote_options")->where("id",$id)->first();
    }
    /**
     * 手机端 getVoteId
    **/
    public static function getVoteId($Admin)
    {
        return self::select("id","vote_title")->where("vote_show",1)->where("vote_status",1)->where("vote_admin",$Admin)->get();
    }

}

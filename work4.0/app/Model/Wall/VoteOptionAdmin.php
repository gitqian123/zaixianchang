<?php

namespace App\Model\Wall;
use Illuminate\Database\Eloquent\Model;
class VoteOptionAdmin extends Model
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
     * 手机端 getVoteId_OptionId
     **/
    public static function getVoteId_OptionId($Admin,$openid)
    {
        return self::select("vote_id","option_id")->where("admin",$Admin)->where("openid",$openid)->get()->toArray();
    }

}

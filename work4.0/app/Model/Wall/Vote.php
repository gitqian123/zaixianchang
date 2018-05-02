<?php

namespace App\Model\Wall;
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

<?php

namespace App\Model\Wall;
use Illuminate\Database\Eloquent\Model;
class VoteRes extends Model
{
    protected $table = 'huyu_voteresults';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;

    /**
     * GetVoteRes 获取投票结果的信息
     **/
    public static function GetVoteRes($id)
    {
        $voteRes=self::select("voteresults_res","id","voteresults_content")
            ->where("voteresults_rounds",$id)->orderBy("voteresults_res","desc")->get()->toArray();
        return $voteRes;
    }

}

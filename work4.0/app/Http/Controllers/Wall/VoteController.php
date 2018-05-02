<?php

namespace App\Http\Controllers\Wall;
use App\Model\Wall\Vote;
use App\Model\Wall\VoteRes;
use Illuminate\Support\Facades\DB;

class VoteController extends CommonController
{
    protected function lists()
    {
       // $name="admin";
        $name=$this->Name();
        $voteAll=$this->GetVotes($name);
       // return $voteAll;
        $data["status"]=200;
        $data['message']="success";
        $data['data']=$voteAll;
        return json_encode($data);


    }
    protected function GetVotes($name)
    {
        $voteAll=Vote::GetVote($name);
        foreach($voteAll as $k=>$v)
        {
            $voteRes=VoteRes::GetVoteRes($v["id"]);
            $num=DB::table('huyu_voteresults')
                ->where('voteresults_rounds','=',$v["id"])
                ->groupBy('voteresults_rounds')
                ->select(DB::raw("sum(voteresults_res) as num"))
                ->first();
            if($num){
                $voteAll[$k]["num"]=$num->num;
            }else{
                $voteAll[$k]["num"]=0;
            }
            $voteAll[$k]["options"]=$voteRes;
        }
        return $voteAll;
    }

}
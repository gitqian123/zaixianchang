<?php

namespace App\Http\Controllers\Mobile;
use App\Http\Controllers\Controller;
use App\Model\Mobile\VoteUser;
use App\Model\Wall\VoteOptionAdmin;
use Illuminate\Http\Request;
use App\Model\Admin\Vote;
use App\Model\Wall\VoteRes;
use Illuminate\Support\Facades\DB;

class MobileVoteController extends Controller
{
    /**
     *  获取用户投票的信息
     **/
    protected  function voteAll(Request $request)
    {
        $name=$request->get("vcode");
        $openid=$request->get("signin_openid");
        $voteAll=Vote::getVoteId($name);//获取投票ID
      //  return json_encode($voteAll);
        $VoteId_OptionId=VoteOptionAdmin::getVoteId_OptionId($name,$openid);//获取用户投票ID
        //return json_encode($VoteId_OptionId);
        $arr=[];
        $data=[];
        if(isset($voteAll))
        {
            foreach($VoteId_OptionId as $a=>$b)
            {
                $arr["vote_id"][]=$b["vote_id"];
            }
          //  return json_encode($arr);

            //($VoteId_OptionId);
            foreach($voteAll as $k=>$v)
            {
                if(isset($arr["vote_id"]))
                {
                    if(!in_array($v['id'],$arr["vote_id"]))
                    {
                        $voteRes=VoteRes::GetVoteRes($v["id"]);
                        foreach($voteRes as $key=>$val)
                        {
                            unset($val['voteresults_res']);
                            $voteRes[$key]=$val;
                        }
                        $voteAll[$k]["options"]=$voteRes;
                    }
                    if(!isset($v['options']))
                    {
                        unset($voteAll[$k]);
                    }

                }else{
                    $voteRes=VoteRes::GetVoteRes($v["id"]);
                    foreach($voteRes as $key=>$val)
                    {
                        unset($val['voteresults_res']);
                        $voteRes[$key]=$val;
                    }
                    $voteAll[$k]["options"]=$voteRes;
                    if(!isset($v['options']))
                    {
                        unset($voteAll[$k]);
                    }
                }


            }
            foreach($voteAll as $a=>$b)
            {
                $data[]=$b;
            }
        }
        return $this->Data(200,$data);
    }

    /**
     * 添加用户投票信息
    **/
    protected function addVote(Request $request)
    {
        if($request->isMethod("post"))
        {
            $vote=file_get_contents('php://input');
            $vote=json_decode($vote,true);
            foreach($vote["vote"] as $k=>$v)
            {
                VoteUser::AddVote($vote["signin_openid"],$vote["vcode"],$v["optionid"],$v["voteid"]);
                DB::table('huyu_voteresults')->where("id",$v["optionid"])->increment('voteresults_res',1);
            }
            return $this->Data(200,[]);
        }

    }

    /**
     *  获取投票信息
    **/
    protected function getVote(Request $request)
    {
        $name=$request->get("vcode");
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

    /**
     *  返回状态
     **/
    protected function Data($status,$arr)
    {
        $data["status"]=$status;
        $data["message"]="success";
        $data["data"]=$arr;
        return json_encode($data);
    }

}
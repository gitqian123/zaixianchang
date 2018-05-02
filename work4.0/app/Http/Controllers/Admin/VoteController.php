<?php
namespace App\Http\Controllers\Admin;
use App\Model\Admin\Vote;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
class VoteController extends CommonController
{
    protected function AdminName()
    {
        $adminName=session()->get("admin");
        return $adminName->a_name;
    }
    public function voteLists(Request $request)
    {
        if($request->isMethod("post"))
        {
            $vote_name_all=$request->input("vote_name")?$request->input("vote_name"):"";
            $vote_title=$request->input("vote_title")?$request->input("vote_title"):"";
            //dd($vote_title);
            if($vote_name_all==""|| $vote_title==""){
                return redirect()->back();
            }
            $vote_options=json_encode($vote_name_all);
            $voteSet=DB::table("huyu_vote")->insertGetId(["vote_title"=>$vote_title,"vote_options"=>$vote_options,"vote_admin"=>$this->AdminName(),"vote_time"=>time()]);
            //dd($voteSet);
            if(is_int($voteSet))
            {
                foreach($vote_name_all as $key=>$val)
                {
                    DB::table("huyu_voteresults")->insert(["voteresults_title"=>$vote_title,"voteresults_res"=>0,"voteresults_rounds"=>$voteSet,"voteresults_content"=>$val,"voteresults_admin"=>$this->AdminName()]);
                }
            }
        }

        $VoteAll=Vote::GetVote($this->AdminName());
        return view("admin/vote/votelists",compact("VoteAll"));
    }

    //投票删除
    protected function voteDel(Request $request)
    {
        $vote_id=$request->get("votedel")?$request->get("votedel"):"";
        $idDel=Vote::GetVoteFirstDel($vote_id,$this->AdminName());
        if($idDel)
        {
            $res=DB::table("huyu_voteresults")->where("voteresults_admin",$this->AdminName())->where("voteresults_rounds",$vote_id)->delete();
            if($res!=0)
            {
                $data['status']=1;
                return json_encode($data);
            }
        }
        $data['status']=0;
        return json_encode($data);
    }

    //修改投票状态 开启、关闭
    protected function voteStatus(Request $request)
    {
        $update_id=$request->get("voteupdate");
        $updateStatus=$request->get("votestatus");
        $st=Vote::UpdateStatus($update_id,$updateStatus);
        return $st;
    }

    //修改投票显示 开启、关闭
    protected function voteShow(Request $request)
    {
        $vote_show=$request->get("vote_show");
        $show_id=$request->get("show_id");
        $show=Vote::UpdateShow($show_id,$vote_show);
        return $show;
    }

    //获取修改投票设置
    protected function voteUpdate(Request $request)
    {
        $id=$request->get("voteupdate");
        $UpdateId = Vote::GetVoteUpdate($id);
        $UpdateId=json_decode($UpdateId,true);
        //dd($UpdateId);
        foreach($UpdateId as $key=>$val)
        {
            $options=$UpdateId['vote_options'];
            $options=json_decode($options,true);
        }
        //$UpdateId['vote_options']=$options;
        $data["status"]=1;
        $data['content']=$options;
        $data['title']=$UpdateId['vote_title'];
        $data['id']=$UpdateId['id'];
        return json_encode($data);
    }

    //修改
    protected function voteUpdates(Request $request)
    {
        if($request->isMethod("post"))
        {
            $vote_name_all=$request->input("vote_name_Update")?$request->input("vote_name_Update"):"";
            $vote_title=$request->input("vote_title_update")?$request->input("vote_title_update"):"";
            $vote_id=$request->input("vote_id");
            if($vote_name_all=="" && $vote_title==""){
                return redirect()->back();
            }
            $vote_options=json_encode($vote_name_all);
            $voteSet=DB::table("huyu_vote")->where("id",$vote_id)->update(["vote_title"=>$vote_title,"vote_options"=>$vote_options,"vote_admin"=>$this->AdminName(),"vote_time"=>time()]);
            if(is_int($voteSet))
            {
                //先删除再添加
                DB::table("huyu_voteresults")->where("voteresults_rounds",$vote_id)->where('voteresults_admin',$this->AdminName())->delete();
                foreach($vote_name_all as $key=>$val)
                {
                    DB::table("huyu_voteresults")->insert(["voteresults_title"=>$vote_title,"voteresults_res"=>0,"voteresults_rounds"=>$vote_id,"voteresults_content"=>$val,"voteresults_admin"=>$this->AdminName()]);
                }
                return redirect()->back();
            }
            return redirect()->back();
        }
    }


}
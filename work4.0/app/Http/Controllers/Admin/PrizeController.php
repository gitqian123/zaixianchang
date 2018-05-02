<?php
namespace App\Http\Controllers\Admin;
use App\Model\Admin\Prize;
use App\Model\Admin\Role;
use App\Model\Admin\Winning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
class PrizeController extends CommonController
{
    protected function prizeSet(Request $request)
    {
        $session=session()->get("admin");
        if($request->isMethod('POST')){
            $prizename=$request->input("prizeimgname");
            $file=$request->file("prizeimg");
            $path="sign_pc/upload";
            if($prizename){
                $imgpath=$this->upload($file,"prizeimg",$path);
                if( $imgpath){
                    $imgpath="upload".$imgpath;
                    $prizeselect=$request->input("prizeselect");
                    DB::table("huyu_prize")->insert(['prize_name'=>$prizename,"prize_img"=>$imgpath,"prize_grouping"=>$prizeselect,"prize_time"=>time(),"prize_adminer"=>$session->a_name]);
                }
                return redirect()->back();
            }
           return redirect()->back();
        }
        $prizeall=Prize::PrizeAll($session->a_name);
       // dd($prizeall);
        return view('admin/prize/prizeset',compact("prizeall"));
    }

    //奖品删除
    protected function prizeDel(Request $request)
    {
        $session=session()->get("admin");
        $prizedel=$request->get('prizedel');
        $del=Prize::PrizeDel($session->a_name,$prizedel);
        if($del){
            $data['status']=1;
            $data['content']="操作成功";
            return json_encode($data);
        }
    }
    //奖品修改查询
    protected function prizeUpdate(Request $request)
    {
        if($request->isMethod("post"))
        {
            $session=session()->get("admin");
            $id=$request->get("prizeupdate");
            $firset=Prize::PrizeFirst($session->a_name,$id);
            return json_encode($firset);
//            return view('admin/prize/prizeset',compact("firset"));
        }

    }
    //奖品修改
    protected function prizeUpdates(Request $request)
    {
        $session=session()->get("admin");
        if($request->isMethod("post"))
        {
            $prizename=$request->input("prizeimgnames")?$request->input("prizeimgnames"):"";
            $id=$request->input("upid")?$request->input("upid"):"";
            $file=$request->file("prizeimgs");
            if($prizename){
                $imgpath=$this->upload($file);
                if($imgpath){
                    $prizeselect=$request->input("prizeselects");
                    $prize_time=time();
                    $prize_grouping=$prizeselect;
                    $up=DB::table("huyu_prize")->where('id',$id)->where("prize_adminer",$session->a_name)
                        ->update(['prize_name'=>$prizename,"prize_img"=>$imgpath,"prize_time"=>$prize_time,"prize_grouping"=>$prize_grouping]);
                    if ($up){
                        return redirect("admin/prizeset");
                    }else{
                        return back();
                    }
                }
                return back();
            }
        }

    }
    //奖品状态修改
    protected function PrizeStatus(Request $request)
    {
        $session=session()->get("admin");
        $prize_status=$request->input("prizestatus");
        $id=$request->input("prizedel_id")?$request->input("prizedel_id"):"";
        DB::table("huyu_prize")->where('id',$id)->where("prize_adminer",$session->a_name)->update(["prize_status"=>$prize_status]);
        return json_encode($prize_status);
    }
    //中奖信息
    protected function PrizeWinning(Request $request)
    {
        $adminName=session()->get("admin");
        if($request->isMethod("post"))
        {
            $del=$request->input("winningdel");
            $winningdel=Winning::WinningDel($del,$adminName->a_name);
            if($winningdel)
            {
                $data['status']=1;
                return json_encode($data);
            }
            $data['status']=0;
            return json_encode($data);
        }
        $winningall=Winning::GetWinningAll($adminName->a_name);
        return view("admin/prize/prizewinning",compact("winningall"));
    }

    /**
    * 设置内定
     **/
    protected  function setDefault(Request $request)
    {
        if($request->isMethod("post"))
        {
            $sign_id=$request->get("sign_id");
            $prize_id=$request->get("prize_id");
            $admin=session()->get('admin');
            $admin=$admin->a_name;
            $sign_prize_select=DB::table("sign_prize")->select("id")->where("admin",$admin)->where("prize_id",$prize_id)->where("sign_id",$sign_id)->first();
            if($sign_prize_select)//重复中奖
            {
                return redirect()->back();
            }
            $sign_prize=DB::table("sign_prize")->insert(["sign_id"=>$sign_id,"prize_id"=>$prize_id,"admin"=>$admin]);
            if($sign_prize)
            {
                DB::table("huyu_signin")->where("id",$sign_id)->where("signin_adminer",$admin)->update(["signin_default"=>1]);
            }
        }
        $session=session()->get('admin');
        $users=DB::table('huyu_signin')->select('id','signin_nickname','signin_headimgurl','signin_status','signin_time')
            ->where('signin_adminer',$session->a_name)->where('signin_status',1)->where('signin_default',0)->paginate(10);
        if($users){
            $prize=Prize::PrizeIdName($session->a_name);
            return view('admin/prize/prizedefal',compact("users","prize"));
        }
        $users=null;
        return view('admin/prize/prizedefal',compact("users"));
    }

    /**
     * 内定名单显示
     **/
    protected  function DefaultShow(Request $request)
    {
        if($request->isMethod("post"))
        {
            $sign_prize_id=$request->get("sign_prize_id")?$request->get("sign_prize_id"):"";
            $sign_id=$request->get("defal")?$request->get("defal"):"";
            $del=DB::table("sign_prize")->delete(["id"=>$sign_prize_id]);
            if($del)
            {
                $update=DB::table("huyu_signin")->where("id",$sign_id)->update(['signin_default'=>0]);
                if($update)
                {
                    $data['status']=1;
                    $data['del']=$sign_prize_id;
                    return json_encode($data);
                }
                $data['status']=0;
                return json_encode($data);
            }
            $data['status']=0;
            return json_encode($data);

        }
        $admin=session()->get('admin');
        $admin=$admin->a_name;
        $All=DB::table("sign_prize")->select("id","sign_id","prize_id")->where("admin",$admin)->get();
        $All=json_decode(json_encode($All),true);
        $data=[];
        $arr=[];
        foreach($All as $k=>$v)
        {
            $arr[]=DB::table('huyu_signin')->select("id","signin_nickname","signin_headimgurl")->where("id",$v['sign_id'])->first();
            $arr=json_decode(json_encode($arr),true);
            foreach($arr as $key=>$val)
            {
                if($v['sign_id']==$val['id'])
                {
                    $data[]=Prize::PrizeIdNameImg($admin,$v['prize_id']);
                    if($data)
                    {
                        foreach($data as $m=>$n)
                        {
                            $arr[$key]['prize_name']=$n['prize_name'];
                            $arr[$key]['prize_img']=$n['prize_img'];
                            $arr[$key]['sign_prize_id']=$v['id'];
                        }
                    }
                }
            }

        }
        return view("admin/prize/prizeshow",compact("arr"));
    }


}
<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class SigninController extends CommonController
{
    //签到展示
    public function signinLists(Request $request)
    {
        $session=session()->get('admin');
        if($session){
            $signinconfig=DB::table('signin_config')->select('signin_audit')->where('signin_adminer',$session->a_name)->first();//先从签到设置表取签到信息
            if($signinconfig==null){ //如果签到设置里没信息插入一条信息，默认
                DB::table('signin_config')->insert(['signin_adminer'=>$session->a_name]);
                $users=DB::table('huyu_signin')->select('id','signin_nickname','signin_headimgurl','signin_status','signin_time')
                    ->where('signin_adminer',$session->a_name)->where('signin_status',1)->get();
               // dd($users);
                $audit=1;
                return view('admin/signin/signinlists',compact("audit",'users'));
            }
            $audit=$signinconfig->signin_audit;
            $users=DB::table('huyu_signin')->select('id','signin_nickname','signin_headimgurl','signin_status','signin_time')
                ->where('signin_adminer',$session->a_name)->where('signin_status',1)->paginate(10);
           if($users){
               return view('admin/signin/signinlists',compact("audit","users"));
           }
            $users=null;
            return view('admin/signin/signinlists',compact("audit","users"));
        }
    }

    //签到审核
    protected function signinMode(Request $request){
        $session=session()->get('admin');
        $audit=$request->get('displaymode');
        //查询签到设置表里是否有值
        $signinconfig=DB::table('signin_config')->select('id')->where('signin_adminer',$session->a_name)->first();
        if($signinconfig)
        {
            $id=DB::table('signin_config')->where('signin_adminer',$session->a_name)->update(['signin_audit'=>$audit]);
            if($id){
                return json_encode(1);
            }
            returnjson_encode(0);
        }
        $id=DB::table('signin_config')->insert(['signin_adminer'=>$session->a_name,'signin_audit'=>$audit]);
        if($id){
            return json_encode(1);
        }
        return json_encode(0);
    }

    //拒绝签到\批量
    protected function signinFalses(Request $request)
    {
        $id=$request->get('signinfal');
        return $this->SigninAll($id,$stat=0);
    }

    //通过签到显示、分页
    protected function signinTrue(Request $request){
        //$signintrue=$request->get("signintrue");
        $session=session()->get('admin');
        $p=$request->get('p')?(int)$request->get('p'):1;
        //return $p;
        $start=($p-1)*10;
        $SigninTrueAll=DB::table('huyu_signin')->select('id','signin_nickname','signin_headimgurl','signin_status','signin_time')
            ->where('signin_adminer',$session->a_name)->where('signin_status',0)->offset($start)->limit(10)->get();
        //return $SigninTrueAll;
        $SigninTrueAll=json_decode(json_encode($SigninTrueAll),true);
        $All=[];
        foreach($SigninTrueAll as $k=>$v){
            $v['signin_time']=date('Y-m-d H:i:s', $v['signin_time']);
            $All[]=$v;
        }

        $str="";
        foreach($All as $key=>$val){
           $str.="<tr signinlists=\"".$val['id']."\">
           <td><input type='checkbox' class='siginCheckbox2' value=\"".$val['id']."\" name='signins2[]'></td>
           <td>".$val['signin_nickname']."</td>
           <td > <img src=\"".$val['signin_headimgurl']."\" class=\"img-circle \" style=\"width:60px;height:60px;\"/></td>
           <td>".$val['signin_time']."</td>
           <td>
                <div class='am-btn-toolbar'>
                    <div class='am-btn-group am-btn-group-xs'>
                        <button class='signint'>通过</button>
                    </div>
                </div>
            </td>
           </tr>";
        }
        $SigninAll=DB::table('huyu_signin')->select('id')->where('signin_adminer',$session->a_name)->where('signin_status',0)->get();
        $pagesum=count($SigninAll);
        $pagesum=ceil($pagesum/10);//总页数
        $data["status"]=1;
        $data["date"]=$str;
        $data["pagesum"]=$pagesum;
        return  json_encode($data);
        //return view('admin/signin/signinlists',compact("SigninTrueAll"));
    }
    //通过签到/批量
    protected function signinTrues(Request $request)
    {
        $id=$request->get('signint');
        return $this->SigninAll($id,1);
    }

    protected  function SigninAll($id,$stat){
        $session=session()->get('admin');
        $data=[];
        if(is_array($id)){
           // $signin_id=implode(",",$id);
//            var_dump($id);die;
            foreach($id as $key=>$val){
                $signin_all=DB::table('huyu_signin')->where('id',$val)->where('signin_adminer',$session->a_name)->update(['signin_status'=>$stat]);
            }
            if($signin_all){
                $data['status']=1;
                $data['content']=$id;
                return json_encode($data);
            }
            $data=[];
            $data['status']=0;
            return json_encode($data);
        }
        $up=DB::table('huyu_signin')->where('id',$id)->where('signin_adminer',$session->a_name)->update(['signin_status'=>$stat]);
        if($up){
            $data['status']=1;
            $data['content']=$id;
            return json_encode($data);
        }
        $data['status']=0;
        return json_encode($data);
    }
}
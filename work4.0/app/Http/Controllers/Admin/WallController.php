<?php
/**
 * Created by PhpStorm.
 * User: Mloong
 * Date: 2018/3/29
 * Time: 21:12
 */
namespace App\Http\Controllers\Admin;
use App\Model\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
class WallController extends CommonController
{
    public function wallLists()
    {
        $session=session()->get('admin');
        if($session){
            $wallconfig=DB::table('wall_config')->select('wall_status')->where('wall_admin',$session->a_name)->first();//先从签到设置表取签到信息
            if($wallconfig==null){ //如果签到设置里没信息插入一条信息，默认
                DB::table('wall_config')->insert(['wall_admin'=>$session->a_name]);
                $walls=DB::table('huyu_wall')->select('id','wall_content','wall_nickname','wall_status','wall_time')
                    ->where('wall_admin',$session->a_name)->where('wall_status',1)->get();
                // dd($users);
                $audit=1;
                return view('admin/wall/walllists',compact("audit",'walls'));
            }
            $audit=$wallconfig->wall_status;
           // dd($session->a_name);
            $walls=DB::table('huyu_wall')->select('id','wall_nickname','wall_content','wall_status','wall_time')
                ->where('wall_status',1)->where('wall_admin',$session->a_name)->paginate(10);
            //dd($walls);
            if($walls){
                return view('admin/wall/walllists',compact("audit","walls"));
            }
            $walls=null;
            return view('admin/wall/walllists',compact("audit","walls"));
        }
    }

    //消息审核
    protected function wallMode(Request $request){
        $session=session()->get('admin');
        $audit=$request->get('displaymode');
        //查询签到设置表里是否有值
        $wallconfig=DB::table('wall_config')->select('id')->where('wall_admin',$session->a_name)->first();
        if($wallconfig)
        {
            $id=DB::table('wall_config')->where('wall_admin',$session->a_name)->update(['wall_status'=>$audit]);
            if($id){
                return json_encode(1);
            }
            return json_encode(0);
        }
        $id=DB::table('wall_config')->insert(['wall_admin'=>$session->a_name,'wall_status'=>$audit]);
        if($id){
            return json_encode(1);
        }
        return json_encode(0);
    }

    //拒绝消息\批量
    protected function wallFalses(Request $request)
    {
        $id=$request->get('wallfal');
        return $this->WallAll($id,$stat=0);
    }
    //通过消息/批量
    protected function wallTrues(Request $request)
    {
        $id=$request->get('wallt');
        return $this->WallAll($id,1);
    }
    //
    protected  function WallAll($id,$stat){
        $session=session()->get('admin');
        $data=[];
        if(is_array($id)){
            // $signin_id=implode(",",$id);
           //var_dump($id);die;
            foreach($id as $key=>$val){
                $wall_all=DB::table('huyu_wall')->where('id',$val)->where('wall_admin',$session->a_name)->update(['wall_status'=>$stat]);
            }
            if($wall_all){
                $data['status']=1;
                $data['content']=$id;
                return json_encode($data);
            }
            $data=[];
            $data['status']=0;
            return json_encode($data);
        }
        $up=DB::table('huyu_wall')->where('id',$id)->where('wall_admin',$session->a_name)->update(['wall_status'=>$stat]);
        if($up){
            $data['status']=1;
            $data['content']=$id;
            return json_encode($data);
        }
        $data['status']=0;
        return json_encode($data);
    }

    //通过签到显示、分页
    protected function wallTrue(Request $request){
        //$signintrue=$request->get("signintrue");
        $session=session()->get('admin');
        $p=$request->get('p')?(int)$request->get('p'):1;
        //return $p;
        $start=($p-1)*10;
        $WallTrueAll=DB::table('huyu_wall')->select('id','wall_nickname','wall_content','wall_status','wall_time')
            ->where('wall_admin',$session->a_name)->where('wall_status',0)->offset($start)->limit(10)->get();
        //return $SigninTrueAll;
        $WallTrueAll=json_decode(json_encode($WallTrueAll),true);
        $All=[];
        foreach($WallTrueAll as $k=>$v){
            $v['wall_time']=date('Y-m-d H:i:s', $v['wall_time']);
            $All[]=$v;
        }

        $str="";
        foreach($All as $key=>$val){
            $str.="<tr walllists=\"".$val['id']."\">
           <td><input type='checkbox' class='wallsCheckbox2' value=\"".$val['id']."\" name='wall2[]'></td>
           <td>".base64_decode($val['wall_content'])."</td>
           <td>".$val['wall_nickname']."</td>
           <td>".$val['wall_time']."</td>
           <td>
                <div class='am-btn-toolbar'>
                    <div class='am-btn-group am-btn-group-xs'>
                        <button class='wallt'>通过</button>
                    </div>
                </div>
            </td>
           </tr>";
        }
        $WallAll=DB::table('huyu_wall')->select('id')->where('wall_admin',$session->a_name)->where('wall_status',0)->get();
        $pagesum=count($WallAll);
        $pagesum=ceil($pagesum/10);//总页数
        $data["status"]=1;
        $data["date"]=$str;
        $data["pagesum"]=$pagesum;
        return  json_encode($data);
        //return view('admin/signin/signinlists',compact("SigninTrueAll"));
    }
}
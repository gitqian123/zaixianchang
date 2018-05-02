<?php

namespace App\Http\Controllers\Mobile;
use App\Http\Controllers\Controller;
use App\Model\Wall\Signin;
use App\Model\Wall\Wall;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileWallController extends Controller
{
    /**
    * 获取用户消息内容记录
     ***/
    protected function getWall(Request $request)
    {
        $openid=$request->get("signin_openid");
        $vcode=$request->get("vcode");
//        $data["openid"]=$openid;
//        $data["vcode"]=$vcode;
//        return json_encode($data);
        $content=Wall::getWallFirst($openid,$vcode);
        $arr=[];
        foreach($content as $key=>$val)
        {
            $arr[]=base64_decode($val["wall_content"]);
        }
        $data['status']=200;
        $data["message"]="success";
        $data["data"]=$arr;
        return json_encode($data);
    }

    /**
     * 添加用户的消息内容
     ***/
    protected function postWall(Request $request)
    {
        if($request->isMethod("post"))
        {
            $Wall=file_get_contents('php://input');
            $Wall=json_decode($Wall,true);
            $new=base64_encode($Wall['new']);
            $wall_status=DB::table("wall_config")->where("wall_admin", $Wall['vcode'])->value("wall_status");
            $signin_nickname=Signin::Openid($Wall["vcode"],$Wall["signin_openid"]);
            $id=Wall::AddWall($new,$Wall["signin_openid"],$Wall["vcode"],$signin_nickname->signin_nickname,$wall_status,time());
            if($id)
            {
                $data['status']=200;
                $data["message"]="success";
                return json_encode($data);
            }
            $data['status']=201;
            $data["message"]="success";
            return json_encode($data);

        }

    }


}
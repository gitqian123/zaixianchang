<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{

    public function __construct()
    {
        if (in_array(session("admin")->a_name,config("admin.superadmin",["admin"]))){
            $myNode=Node::getNode(1);
        }else{
            $myNode=Node::getCurrentNodes(1);
        }
//        dd($myNode);
        $leftNav=Node::getNodeTree($myNode);
        return view()->share("leftNav",$leftNav);
    }
    /**
     * 图片上传
     * @param file //验证文件类型
     * @param imgName //图片名称
     * @param path  //保存路径
     **/
    protected function upload($file=null,$imgName,$path){
        if($file  ){
            $file->getClientOriginalExtension();
            $file->getRealPath();
            $type=$file->getClientMimeType();
            $image=substr($type,0,strpos($type, '/'));
            if($image!="image")
            {
                return false;
            }
            $destinationPath = public_path($path."/") . date('Y-m-d', time());
            $picturefile = '/' . date('Y-m-d', time()) . '/' . uniqid() . "." . $file->getClientOriginalExtension();
            request()->file($imgName)->move($destinationPath, $picturefile);
            return $picturefile;
        }
    }


}

<?php

namespace App\Http\Controllers\Admin;
use App\Model\Admin\Node;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NodeController extends CommonController
{
    //权限添加
    protected function add()
    {
        if (request()->isMethod('get')){
            $node=Node::getNode();
            //dd($node1);
            $except=[".","..","LoginController.php","IndexController.php","CommonController.php"];
            $nodes=Node::getNodeOrder($node);
            $files=scandir(app_path("Http/Controllers/Admin"));
            $controllers=[];
            foreach ($files as $val){
                if (!in_array($val,$except)){
                    array_push($controllers,trim($val,".php"));
                }
            }
            //dd($files);
            return view('admin/nodeAdd',compact("nodes","controllers"));
        }
        if (request()->isMethod('post')){
            $Node = Node ::create(request()->all());
            $a=$Node->save();
            //dd($Node);
            if ($a){
                return redirect("admin/nodeLists");
            }else{
                return back();
            }
        }
    }

    //权限展示
    protected function lists(){
        $node=Node::getNode();
        $nodes=Node::getNodeOrder($node);
        //dd($nodes);
        return view('admin/nodeLists',compact("nodes"));

    }

    //权限修改
    protected function update(Request $request)
    {
       if(request()->isMethod("GET"))
       {
           $id=$_GET['id']?base64_decode($_GET['id']):"";
           $id=(int)$id;
           if(is_int($id)){
               if(Node::getNodePid($id)){
                    return redirect()->back();
               }
               $node=Node::getNode();
               //dd($node);
               $except=[".","..","LoginController.php","IndexController.php","CommonController.php"];
               $nodes=Node::getNodeOrder($node);
               $files=scandir(app_path("Http/Controllers/Admin"));
               $controllers=[];
               foreach ($files as $val){
                   if (!in_array($val,$except)){
                       array_push($controllers,trim($val,".php"));
                   }
               }
               //dd($files);
               return view('admin/nodeUpdate',compact("nodes","controllers","id"));
           }
           return redirect()->back();

        }
         if(request()->isMethod("POST"))
         {
            $node_id=$request->input('node_id');
            $node_id=(int)$node_id;
            if(is_int($node_id) && $node_id!="")
            {
                $delnodeid=DB::table('node')->where('node_id',$node_id)->delete();//删除权限的内容
                if($delnodeid){
                   DB::table('node_role')->where('node_id', $node_id)->delete();//删除角色和权限的内容

                        $Node = Node ::create(request()->except("id"));
                        $a=$Node->save();//添加权限
                        //dd($Node);
                        if ($a)
                        {
                            return redirect("admin/nodeLists");
                        }
                        return redirect()->back();
                }
                return redirect()->back();
            }
             return redirect()->back();
        }

    }
    //权限删除
    protected function delete(){
        $id=$_GET['id']?base64_decode($_GET['id']):"";
        $id=(int)$id;
        if(is_int($id))
        {
            $node_id=DB::table('node')->select('node_id')->where("node_pid",$id)->first();
            if($node_id)
            {
                return redirect()->back()->with('delnode',"该权限下有子权限，删除失败");
            }
            $delnodeid=DB::table('node')->where('node_id',$id)->delete();//删除权限的内容
            if($delnodeid)
            {
                DB::table('node_role')->where('node_id', $id)->delete();//删除角色和权限的内容
                return redirect('admin/nodeLists');
            }
            return redirect()->back();
        }
    }
}

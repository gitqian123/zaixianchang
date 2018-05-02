<?php
namespace App\Http\Controllers\Admin;

use App\Index;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\Tests\Node\SelectorNodeTest;

///include_once base_path()."/public/phpqrcode/phpqrcode.php";
class IndexController extends CommonController
{
    //显示后台首页
    public function lists(){

        if (request()->isMethod('get')){
            $admin=session()->get("admin");
            if($admin){$name=$admin->a_name;}else{$name="";}
            $Ip=$_SERVER['SERVER_NAME'];
            //$this->erWeiMa();
            return view('admin/index',compact("name","Ip"));
        }
//        if (request()->isMethod('post')){
//            $file=request()->file("a_img");
//            //dd($file) ;
//
//        }
    }
    protected function file(){
        if (request()->hasFile('file') && request()->file('file')->isValid()){
         return 1;

        }

    }

    protected function erWeiMa()
    {
        // 定义png图片的头部
       /// header('Content-type: image/png');
        // 引入类文件
//        $value = 'http://www.36tvtvcom.cn';
//        // 定义logo文件的路径
//        $logo = 'http://thirdwx.qlogo.cn/mmopen/vi_32/m1JBZH56oZLJk3fia16VEc4UOaWBexv0dgRbVCiaZ8ibKXADv6jfl6KsxOhUlSbSicu3rWnvAhTB4zeoyyytjlMwFQ/132';
//        // 定义不带logo二维码文件的生成路径
//        $QR = 'xiangyang.png';
//        // 定义带logo二维码文件的生成路径
//        $logoQR = 'xiangyanglog.png';
//        // 定义容错等级
//        $errorCorrectionLevel = 'L';
//        // 定义生成的二维码大小
//        $matrixPointSize = 11;
//        \QRcode::png($value, $QR, $errorCorrectionLevel, $matrixPointSize, 2);
//        if ($logo !== FALSE) {
//            $QR = imagecreatefromstring(file_get_contents($QR));
//            $logo = imagecreatefromstring(file_get_contents($logo));
//            $QR_width = imagesx($QR);
//            $QR_height = imagesy($QR);
//            $logo_width = imagesx($logo);
//            $logo_height = imagesy($logo);
//            $logo_qr_width = $QR_width / 5;
//            $scale = $logo_width / $logo_qr_width;
//            $logo_qr_height = $logo_height / $scale;
//            $from_width = ($QR_width - $logo_qr_width) / 2;
//            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
//        }
//        imagepng($QR);
//        //如果需要生成到文件
//        imagepng($QR, $logoQR);
    }
}

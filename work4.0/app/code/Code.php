<?php
namespace App\code;
/**
 * 验证码的封装类
 * @param $w int 验证码图像的宽
 * @param $h int 验证码图像的高
 * @param $cn int 验证码的位数
 * @return $img resource 返回验证码图像资源
 */
class Code{
    //定义属性
    private $width; //验证码图像的宽
    private $height;//验证码图像的高
    private $count;//验证码位数
    //构造函数，初始化私有属性
    function __construct($w,$h,$cn){
        $this->width=$w;
        $this->height=$h;
        $this->count=$cn;
        //echo $this->count;//验证传值
    }
    //得到随机字符，并存入session
    function getCode(){
        $string="0123456789abcdefghijklmnopqrstuvwxyz";
        //如果要使用大写字母，可以使用函数来转换
        //$stringU=strtoupper($string);
        $code="";
        for($i=0;$i<$this->count;$i++){
            $code.=$string[rand(0, strlen($string)-1)];
        }
        session()->put('verify',$code); //被其它页面调用来进行验证
        return $code; //得到验证码字符串
    }
    //生成图像
    function getCheckCode(){
        header("content-type:image/gif");//修改http协议的头，回复给浏览器的数据是一个图片
        $img=imagecreate($this->width, $this->height); //创建画布
        $bgcolor=imagecolorallocate($img, 255, 255, 255); //图像背景色
        $strColor=imagecolorallocate($img, 255, 0, 0);//验证码字符颜色
        $fontfile="simsunb.ttf";//字体文件文件路径
        $size=20; //字体大小
        $angle=rand(-5, 5); //字体倾斜角度
        //糙点元素的颜色
        $color=imagecolorallocate($img, 100, 100, 100);
        //调用糙点函数
        $this->createPix($img, $color);
        //调用干扰线
        $this->createLine($img,$color);     
        //写入字符到图像
        imagettftext($img, $size, $angle, 5, 50, $strColor, $fontfile, $this->getCode());
        //输出图像
        imagegif($img);
        //销毁内存中的缓存
        imagedestroy($img);
    }
    //对图像添加糙点
    function createPix($image,$color){
        for($i=0;$i<200;$i++){
            imagesetpixel($image, rand(0, $this->width), rand(0, $this->height), $color);
        }
    }
    //添加干扰线
    function createLine($image,$color){
        for($i=0;$i<10;$i++){
            imageline( $image,rand(0, $this->width), rand(0, $this->height),rand(0, $this->width), rand(0, $this->height), $color);
        }
    }
}
//调用方法如下
//$builder = new Code(100,80,4);
//$builder->getCheckCode();
//实例化类的时候自动调用构造函数

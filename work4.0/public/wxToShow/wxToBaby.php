<?php

//获取到网页授权的access_token
$appid = "wxb08105797302f979";//填写公众号或服务号、测试号的appid
$secret = "2a4c57ce38b7c6b69aafe6f99e745092";//填写对应的secriet

if(isset($_SESSION['openId'])){
    $openid = $_SESSION['openId'];
}else{
    $code = $_GET['code'];
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code ";

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $res = curl_exec($ch);
    curl_close($ch);
    $json_obj = json_decode($res,true);
    $openid = $json_obj['openid'];
    $_SESSION['openId'] = $openid;
}
    echo '微信用户：'.$openid.'<br/>';
    echo '$json_obj 返回信息：';
    var_dump($json_obj);

    getUserInfo($json_obj);
/**
 * @param $json_obj
 * 根据用户openid 获取其所有信息
 */
function getUserInfo($json_obj){
    $access_token = $json_obj['access_token'];
    $openid = $json_obj['openid'];
    $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $res = curl_exec($ch);
    curl_close($ch);

//解析json
    $user_obj = json_decode($res,true);
    var_dump($user_obj);
    echo 'Name:'.$user_obj['nickname'];
}


?>

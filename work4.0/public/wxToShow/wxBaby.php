<?php
 function getBaseInfo(){
	 
	 $appid = "wxb08105797302f979";
	 $redirect_uri = urlencode("http://106.14.134.23/wxToShow/wxToBaby.php");
	 $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
	 header('location:'.$url);
}
getBaseInfo();

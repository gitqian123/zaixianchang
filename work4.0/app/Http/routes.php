<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//####################################前台页面##############################################


Route::any('/','Admin\\LoginController@login');

//Route::group(['prefix'=>'mobile','namespace'=>'Mobile'],function() {
//    Route::any('index', 'IndexController@index');//首页
//
//});

//Route::get('mobile/weixinShow', function () {
//    return view('welcome');
//});
//Route::get('mobile/weiXin', [
//    'as' => 'weiXin', 'mobSignShow' =>  'MobileSignController@mobSignShow'
//]);

/**
 * 大屏幕路由
***/
Route::group(['prefix'=>'wall','namespace'=>'Wall','middleware'=>'cors'],function() {
    Route::get('index', 'IndexController@index');//首页签到
    Route::get('getAll', 'IndexController@GetSigninAll');//签到总数
    Route::get('wall', 'WallController@lists');//上墙
    Route::any('vote', 'VoteController@lists');//投票
    Route::any('prize', 'PrizeController@lists');//抽奖 奖品信息
    Route::any('prizeWinn', 'PrizeController@PrizeWinn');//添加中奖信息
    Route::any('getWinn', 'PrizeController@getWinn');//获取中奖信息
    Route::get('getPrizes', 'PrizeController@prizes');//获取抽奖人的信息

});


/**
 * 手机端
 ***/
Route::group(['prefix'=>'mobile','namespace'=>'Mobile','middleware'=>'cors'],function() {
    Route::any('mobSign/{vcode?}', 'MobileSignController@mobSign');//手机端签到
    Route::any('weixinShow', 'MobileSignController@mobSignShow');//微信获取用户信息
    Route::any('index', 'MobileSignController@index');//入口
    Route::get('getWall', 'MobileWallController@getWall');//获取消息内容
    Route::any('postWall', 'MobileWallController@postWall');//添加消息内容
    Route::get('vote', 'MobileVoteController@getVote');//获取投票信息
    Route::get('voteAll', 'MobileVoteController@voteAll');//获取用户投票信息
    Route::any('addVote', 'MobileVoteController@addVote');//添加用户投票信息


});


//######################后台页面########################
//后台登录
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    Route::any('adminlogin','LoginController@login');
    Route::any('adminlogout','LoginController@logout');

});
//后台首页路由组
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'checklogin'],function (){
    Route::any('indexlists','IndexController@lists');
    Route::any('indexfile','IndexController@file');

});
//后台管理员路由组
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'check'],function (){
    Route::any('adminlists','AdminController@lists');
    Route::any('adminadd','AdminController@add');
    Route::any('admindelete/{id?}','AdminController@delete')->where("id","\d+");
    Route::any('adminupdate/{id?}','AdminController@update')->where("id","\d+");
    Route::any('adminsetnode/{id?}','AdminController@setnode')->where("id","\d+");

//后台权限路由组

    Route::any('nodeLists','NodeController@lists');
    Route::any('nodeAdd','NodeController@add');
    Route::any('nodeDelete/{id?}','NodeController@delete')->where("id","\d+");
    Route::any('nodeUpdate/{id?}','NodeController@update');

//后台角色路由组

    Route::any('roleLists','RoleController@lists');
    Route::any('roleAdd','RoleController@add');
    Route::any('roleDelete/{id?}','RoleController@delete')->where("id","\d+");
    Route::any('roleUpdate/{id?}','RoleController@update')->where("id","\d+");


});

//后台首页
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'check'],function (){

    //签到设置
    Route::any('signinlists','SigninController@SigninLists');//签到展示
    Route::post('signinmode','SigninController@SigninMode');//签到审核
    Route::post('signinfalses','SigninController@SigninFalses');//拒绝签到/批量
    Route::post('signintrue','SigninController@SigninTrue');//通过签到显示、分页
    Route::post('signintrues','SigninController@SigninTrues');//通过签到


    //消息上墙
    Route::any('walllists','WallController@wallLists');//消息展示
    Route::post('wallmode','WallController@wallMode');//消息审核
    Route::post('wallfalses','WallController@wallFalses');//拒绝消息/批量
    Route::post('walltrue','WallController@wallTrue');//通过消息显示、分页
    Route::post('walltrues','WallController@wallTrues');//xiaoxi通过

    //抽奖设置
    Route::any('prizeset','PrizeController@prizeSet');//抽奖设置
    Route::post('prizedel','PrizeController@prizeDel');//奖品删除
    Route::post('prizeupdate','PrizeController@prizeUpdate');//奖品修改查询
    Route::post('prizeupdates','PrizeController@prizeUpdates');//奖品修改
    Route::any('prizewinning','PrizeController@PrizeWinning');//中奖信息
    Route::post('prizestatus','PrizeController@PrizeStatus');//奖品状态
    Route::any('prizedefal','PrizeController@setDefault');//设置内定
    Route::any('prizeshow','PrizeController@DefaultShow');//内定名单显示

    //投票设置
    Route::any('votelists','VoteController@voteLists');//投票添加
    Route::post('votedel','VoteController@voteDel');//投票删除
    Route::post('votestatus','VoteController@voteStatus');//投票开启/关闭状态
    Route::post('voteupdate','VoteController@voteUpdate');//获取修改投票设置信息
    Route::post('vote_update_all','VoteController@voteUpdates');//修改投票设置
    Route::post('vote_show','VoteController@voteShow');//投票显示修改



//网站设置
    Route::any('config','ConfigController@config');
//增加网络设置
    Route::any('configadd','ConfigController@configadd');
//删除网络设置
    Route::any('configdel/{id}','ConfigController@configdel');
//更改网络设置
    Route::any('confup/{id}','ConfigController@confup');
//更改网络设置提交
    Route::any('confups','ConfigController@confups');
});




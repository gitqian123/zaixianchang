<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConfigController extends CommonController
{
    //后台网站设置页面
    public function config()
    {
        $res = DB::table('config')->get();
        return view('Admin.config.index',['res'=>$res]);
    }



}

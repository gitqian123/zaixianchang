<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return json_encode(2);
    }

}

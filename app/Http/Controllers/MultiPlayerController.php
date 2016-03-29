<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use LRedis;

class MultiPlayerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendMessage(){
        $redis = LRedis::connection();
        $redis->publish('message', Request::input('message'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Socket;
use Illuminate\Http\Request ;
use App\Http\Requests;
use Session;
use App\Helpers\Helper;
use Input;

class MessageController extends Controller
{

    public function getMessagesList()
    {

        $abstract = new Socket();
        $abstract->connectTcp();
        $request = 'GET MESSAGE ' . Session::get('userId') . ':' . Session::get('password') . "\n";
        $run = $abstract->run($request);
        $abstract->close();
        
        return Helper::formatMessageReturn($run);
    }

    public function sendMessage()
    {

        $receiverId = Input::get('user');
        $message = Input::get('message');
        
        $abstract = new Socket();
        $abstract->connectUdp();
        $request = 'SEND MESSAGE ' . Session::get('userId') . ':' . Session::get('password') . ':' . $receiverId . ':' . $message . "\n";
        
        $run = $abstract->send($request);
        $abstract->close();
    }
}

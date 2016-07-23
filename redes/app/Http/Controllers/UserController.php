<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Socket;
use App\Http\Requests;
use Session;
use App\Helpers\Helper;

class UserController extends Controller
{

    public function getUserList()
    {
        $abstract = new Socket();

        $abstract->connectTcp();
        $request = 'GET USERS '.Session::get('userId').':'.Session::get('password')."\n";
        $run = $abstract->run($request);
        $abstract->close();

        return Helper::formatUserReturn($run);

    }
}

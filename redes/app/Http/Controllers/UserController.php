<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\User;
use Session;

class UserController extends Controller
{

    public function getUserList()
    {
        if (Session::get('userId') == null) {
            return Redirect::to('login');
        }
        $user = new User;
        return $user->getUserList();
    }
}

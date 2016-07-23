<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Socket;
use App\Http\Requests;
use View;
use Input;
use Session;

class ChatController extends Controller
{

    public function chatHome()
    {
        // show the form
        return View::make('chat');

    }
}

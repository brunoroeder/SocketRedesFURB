<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request ;
use App\Http\Requests;
use Session;

use App\Message;

use Input;

class MessageController extends Controller
{

    public function getMessagesList()
    {
        if (Session::get('userId') == null) {
            return Redirect::to('login');
        }
        $message = new Message;
        return $message->getMessagesList();
    }

    public function sendMessage()
    {
        if (Session::get('userId') == null) {
            return Redirect::to('login');
        }
        $receiverId = Input::get('user');
        $messageText = Input::get('message');
        $message = new Message;
        $message->sendMessage($receiverId, $messageText);
    }
}

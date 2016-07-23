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

class LoginController extends Controller
{

    public function showLogin()
    {
        // show the form
        return View::make('login');

    }

    public function doLogin()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'userId'    => 'required|numeric',
            'password' => 'required|alphaNum'
        );
        $validator = Validator::make(Input::all(), $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $abstract = new Socket();

            $abstract->connectTcp();
            $request = 'GET USERS ' . Input::get('userId') .':'  . Input::get('password') ."\n";
            $run = $abstract->run($request);
            // $abstract->close();

    
            if ($run == '"Usu\u00e1rio inv\u00e1lido!\r\n"') {
                return Redirect::back()->withInput()->withErrors(array('password' => 'Erro na senha!'));
            }
         

            Session::put('userId', Input::get('userId'));
            Session::put('password', Input::get('password'));
            return Redirect::to('chat');
        }
    }

    public function doLogout()
    {
        Session::forget('userId');
        Session::forget('password');
    }
}

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('listusers', 'UserController@getUserList');
Route::get('messagelist', 'MessageController@getMessagesList');
// Route::get('messagesend/{message}/{receiverId}', 'MessageController@sendMessage');

Route::post('messagesend', 'MessageController@sendMessage');


// route to show the login form
Route::get('login', array('uses' => 'LoginController@showLogin'));

// route to logout
Route::get('logout', array('uses' => 'LoginController@doLogout'));

// route to process the form
Route::post('login', array('uses' => 'LoginController@doLogin'));


Route::get('chat', array('uses' => 'ChatController@chatHome'));
Route::post('chat', array('uses' => 'ChatController@chatHome'));

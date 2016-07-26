<?php

use App\Http\Session;
use App\Socket;

namespace App;

class User
{

    public function getUserList()
    {
        $abstract = new Socket();

        $abstract->connectTcp();
        $request = 'GET USERS ' . \Session::get('userId') . ':' . \Session::get('password') . "\n";
        $run = $abstract->sendTcp($request);
        $abstract->close();

        if ($run == '"Usu\u00e1rio inv\u00e1lido!\r\n"') {
            return "userNotValid";
        }

        return self::formatUserReturn($run);
    }

    public static function formatUserReturn($data)
    {
        $data = explode(':', $data);
        $temp = array();
        $result = array();
        $i = 1;
        foreach ($data as $key => $value) {
            $value = Socket::utf8Ansi($value);
            $temp[] = str_replace('"', '', $value);
            if (($i % 3) == 0) {
                $temp[0] = "<input name'username' type='hidden' id='username-" . $temp[0] ."' value='" .  $temp[1] . "'><input type='radio' name='userid' id='$temp[0]' value='$temp[0]' />(" . $temp[0] . ") ";
                $temp[2] = ' | vitórias: '.$temp[2] . '<br/>';
                $result[] = $temp;
                $temp = array();
                $i = 0;
            }
            $i++;
        }

        $result[] = array("<input type='radio' name='userid' id='0' value='0' />", "Todos", "" );
        return json_encode($result);
    }
}

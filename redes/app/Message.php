<?php

use App\Socket;

namespace App;

class Message
{

    public function getMessagesList()
    {
        $abstract = new Socket();
        $abstract->connectTcp();
        $request = 'GET MESSAGE ' . \Session::get('userId') . ':' . \Session::get('password') . "\n";
        $run = $abstract->sendTcp($request);
        $abstract->close();
        
        return self::formatMessageReturn($run);
    }

    public function sendMessage($receiverId, $message)
    {
        $abstract = new Socket();
        $abstract->connectUdp();
        $request = 'SEND MESSAGE ' . \Session::get('userId') . ':' . \Session::get('password') . ':' . $receiverId . ':' . $message . "\n";
    
        $abstract->sendUdp($request);
        $abstract->close();
    }


    public static function formatMessageReturn($data)
    {
        $data = substr($data, 1);
        $data = substr($data, 0, -5);
        $result = explode(':', $data);

      
        if (empty($result[0])) {
            return json_encode('');
        }
        
        $result[1] = ': '. Socket::utf8Ansi($result[1]) . "<br/>";
        
        return json_encode($result);
    }
}

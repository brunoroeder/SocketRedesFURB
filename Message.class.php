<?php
require_once 'AbstractClass.class.php';

class Message
{
    public $userId = null;
    public $password = null;

    public function getMessagesList()
    {
        // $socket = new AbstractClass();

        $abstract = AbstractClass::getInstance();
        $abstract->connect();
        $request = 'GET MESSAGE '.$abstract->userId.':'.$abstract->password."\n";
        $run = $abstract->run($request);
        $abstract->close();
        return json_encode($run);
    }

    public function sendMessage($message, $receiverId)
    {
        $abstract = AbstractClass::getInstance();

        // $socket->connect();
        $request = 'SEND MESSAGE '.$abstract->userId.':'.$abstract->password.':'.$receiverId.':'.$message."\n";

        $run = $abstract->send($request);
        var_dump($run);
    }
}

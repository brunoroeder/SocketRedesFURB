<?php

require_once 'AbstractClass.class.php';

class User
{
    public function getUserList()
    {
        $abstract = AbstractClass::getInstance();
        $abstract->connect();
        $request = 'GET USERS '.$abstract->userId.':'.$abstract->password."\n";
        $run = $abstract->run($request);
        $abstract->close();
        return json_encode($run);
    }

    public function login($userId, $password)
    {
        $data = AbstractClass::getInstance();
        $data->userId = $userId;
        $data->password = $password;
    }
}

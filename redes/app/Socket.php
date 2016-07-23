<?php

namespace App;

class Socket
{
    const SERVER = "larc.inf.furb.br";
    const PORT_TCP = 1012;
    const PORT_UDP = 1011;

    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;

    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;
    private static $instance;

    private $socket = null;
    
    public function connectTcp()
    {
        try {
            if ($this->socket == null) {
                $timeout = array('sec'=>1,'usec'=>500000);

                $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
                socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, $timeout);
                socket_connect($this->socket, self::SERVER, self::PORT_TCP);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function connectUdp()
    {
        try {
            if ($this->socket == null) {
                $timeout = array('sec'=>1,'usec'=>500000);
                $this->socket = socket_create(AF_INET, SOCK_DGRAM, 0);
                socket_connect($this->socket, self::SERVER, self::PORT_UDP);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function run($request)
    {
        try {
            socket_send($this->socket, $request, strlen($request), 0);
            $out = socket_read($this->socket, 2048);
            return json_encode($out);
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function close()
    {
        socket_close($this->socket);
        $this->socket = null;
    }

    public function send($input)
    {
        socket_send($this->socket, $input, strlen($input), 0);
        $this->socket;

        
        // $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        // socket_set_option($this->socket, SOL_SOCKET, SO_BROADCAST, 1);
        // socket_sendto($this->socket, $input, strlen($input), 0, self::, $port);
        // var_dump(socket_strerror(socket_last_error($this->socket)));

    }
}

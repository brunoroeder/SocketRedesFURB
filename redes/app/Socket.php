<?php

namespace App;

class Socket
{
    const SERVER = "larc.inf.furb.br";
    const PORT_TCP = 1012;
    const PORT_UDP = 1011;

    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;

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

    public function sendTcp($request)
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

    public function sendUdp($input)
    {
        socket_send($this->socket, $input, strlen($input), 0);
        $this->socket;

    }

    
    public static function utf8Ansi($valor = '')
    {

        $utf8_ansi2 = array(
        "\u00c0" =>"À",
        "\u00c1" =>"Á",
        "\u00c2" =>"Â",
        "\u00c3" =>"Ã",
        "\u00c4" =>"Ä",
        "\u00c5" =>"Å",
        "\u00c6" =>"Æ",
        "\u00c7" =>"Ç",
        "\u00c8" =>"È",
        "\u00c9" =>"É",
        "\u00ca" =>"Ê",
        "\u00cb" =>"Ë",
        "\u00cc" =>"Ì",
        "\u00cd" =>"Í",
        "\u00ce" =>"Î",
        "\u00cf" =>"Ï",
        "\u00d1" =>"Ñ",
        "\u00d2" =>"Ò",
        "\u00d3" =>"Ó",
        "\u00d4" =>"Ô",
        "\u00d5" =>"Õ",
        "\u00d6" =>"Ö",
        "\u00d8" =>"Ø",
        "\u00d9" =>"Ù",
        "\u00da" =>"Ú",
        "\u00db" =>"Û",
        "\u00dc" =>"Ü",
        "\u00dd" =>"Ý",
        "\u00df" =>"ß",
        "\u00e0" =>"à",
        "\u00e1" =>"á",
        "\u00e2" =>"â",
        "\u00e3" =>"ã",
        "\u00e4" =>"ä",
        "\u00e5" =>"å",
        "\u00e6" =>"æ",
        "\u00e7" =>"ç",
        "\u00e8" =>"è",
        "\u00e9" =>"é",
        "\u00ea" =>"ê",
        "\u00eb" =>"ë",
        "\u00ec" =>"ì",
        "\u00ed" =>"í",
        "\u00ee" =>"î",
        "\u00ef" =>"ï",
        "\u00f0" =>"ð",
        "\u00f1" =>"ñ",
        "\u00f2" =>"ò",
        "\u00f3" =>"ó",
        "\u00f4" =>"ô",
        "\u00f5" =>"õ",
        "\u00f6" =>"ö",
        "\u00f8" =>"ø",
        "\u00f9" =>"ù",
        "\u00fa" =>"ú",
        "\u00fb" =>"û",
        "\u00fc" =>"ü",
        "\u00fd" =>"ý",
        "\u00ff" =>"ÿ");

        return strtr($valor, $utf8_ansi2);

    }
}

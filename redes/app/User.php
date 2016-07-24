<?php

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
            $value = self::utf8Ansi($value);
            $temp[] = str_replace('"', '', $value);
            if (($i % 3) == 0) {
                $temp[0] = "<input type='radio' name='userid' id='$temp[0]' value='$temp[0]' />";
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

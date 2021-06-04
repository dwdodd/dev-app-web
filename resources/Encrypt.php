<?php

class Encrypt
{
    public static function datum($action='encrypt',$string=false)
    {
        $action = trim($action);
        $output = false;

        $myKey = 'W?HuLpEwNbDf#%7+2*9j(ñ';
        $myIV = '¡¿~Ñq3=6"dkQA)!u7a^&8q';
        
        $encrypt_method = 'AES-256-CBC';

        $secret_key = hash('sha256',$myKey);
        $secret_iv = substr(hash('sha256',$myIV),0,16);

        if($action && ($action == 'encrypt' || $action == 'decrypt') && $string ){

            $string = trim(strval($string));

            if($action == 'encrypt'){
                $output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
            }

            if ($action == 'decrypt'){
                $output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
            }
        }
        return $output;
    }
}
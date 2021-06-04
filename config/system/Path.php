<?php

require_once('urlEnv.php');

class Path
{
    public static function _path($uri)
    {
        $info = explode('/', rtrim($uri,'/'));
        array_shift($info);
        return (object)[
            'path' => PATH,
            'info' => $info
        ];
    }

    public static function isGreaterThan($info)
    {
        if(count($info) > 2 ){
            header('location: '.PATH.'aviso/'.$info[2]);
        }
    }
}
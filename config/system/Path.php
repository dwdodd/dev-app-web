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

    public static function isGreaterThan($info, $n)
    {
        if(count($info) > $n ){
            header('location: '.PATH.'aviso/'.$info[$n]);
        }
    }

    public static function ifDiferent($info, $position, $str)
    {
        if($info[$position] != $str ){
            header('location: '.PATH.'aviso/'.$info[$position]);
        }
    }
}
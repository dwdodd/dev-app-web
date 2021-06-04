<?php

require_once('urlEnv.php');

class BaseUrl
{
    public static function url()
    {
        return '//'.$_SERVER['HTTP_HOST'].PATH;
    }

    public static function logout()
    {
        header('location: //'.$_SERVER['HTTP_HOST'].PATH);
    }

    public static function header_location()
    {
        return header('location: ' . PATH);
    }
}
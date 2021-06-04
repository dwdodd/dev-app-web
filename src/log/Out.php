<?php

require_once '../../../system/BaseUrl.php';

class Out
{
    public function __construct()
    {
        session_start();
        session_destroy();
        BaseUrl::logout();
        exit;
    }
}
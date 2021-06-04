<?php

require_once 'BaseUrl.php';

class NoSessionAllowed
{
    public function __construct()
    {
        if(!@$_SESSION) session_start();

        if(!@$_SESSION['id-session']) {
            session_destroy();
            BaseUrl::header_location();
            exit;
        };
    }
}
new NoSessionAllowed;
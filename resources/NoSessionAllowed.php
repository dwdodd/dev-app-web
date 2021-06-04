<?php

require_once 'HeaderLocation.php';

class NoSessionAllowed
{
    public function __construct()
    {
        if(!@$_SESSION) session_start();

        if(!@$_SESSION['id-session']) {
            session_destroy();
            HeaderLocation::header_location();
            exit;
        };
    }
}
new NoSessionAllowed;
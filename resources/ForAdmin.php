<?php

class ForAdmin
{
    public function __construct()
    {
        if( @$_SESSION['idtipousuario'] != 1 ){
            session_start();
            session_destroy();
            header('location: /solucion').exit;
        }
    }
}
new ForAdmin;

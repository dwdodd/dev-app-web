<?php

session_start();
define('PATH_TO', '../../../');

require_once PATH_TO . 'config/system/Path.php';

$info = Path::_path($_SERVER['REQUEST_URI']);
        Path::isGreaterThan($info->info);

require_once PATH_TO . 'config/layout/Template.php';

$content = file_get_contents('elements/home.php');
Template::html('Usuarios', $content);

/*
if($_SESSION['idtipousuario'] == 1){

    $content = file_get_contents('elements/home.php');
    Template::html('Usuarios', $content);

}
else{
    session_destroy();
    Template::header_location();
}
*/
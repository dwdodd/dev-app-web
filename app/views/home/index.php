<?php

define('PATH_TO', '../../../');

$files = [
    PATH_TO .'config/system/Path.php', 
    PATH_TO .'config/system/NoSessionAllowed.php',
    PATH_TO .'config/layout/Template.php'
];
foreach($files as $file) require_once($file);

$info = Path::_path($_SERVER['REQUEST_URI']);
        Path::isGreaterThan($info->info, 2);
        Path::ifDiferent($info->info, 'inicio');

$content = file_get_contents('elements/home.php');
Template::html('Dashboard', $content);

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
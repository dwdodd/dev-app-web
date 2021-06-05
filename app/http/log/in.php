<?php

define('PATH_TO', '../../../');

$files = [
    //PATH_TO .'resources/CryptoJsAes.php', 
    PATH_TO .'src/log/In.php'
];
foreach($files as $file) require_once($file);

$_POST = json_decode(file_get_contents("php://input"), true);

$email     = CryptoJsAes::decrypt(@$_POST['correo']);
$password  = CryptoJsAes::decrypt(@$_POST['clave']);
$token     = @$_POST['token'];

session_start();

if( $token != $_SESSION['token'] ){
    session_destroy();
    exit(json_encode([
        'code' => 2,
        'status' => 'error',
        'error' => 'No estas autenticado.'
    ]));
}

unset($token, $_SESSION['token']);

new In($email, $password);
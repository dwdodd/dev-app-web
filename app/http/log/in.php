<?php

//require_once '../../../resources/CryptoJsAes.php';
require_once '../../../src/log/In.php';

$_POST = json_decode(file_get_contents("php://input"), true);

// $email     = CryptoJsAes::decrypt(@$_POST['correo']);
// $password  = CryptoJsAes::decrypt(@$_POST['clave']);

$email     = @$_POST['correo'];
$password  = @$_POST['clave'];
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
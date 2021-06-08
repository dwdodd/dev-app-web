<?php

if(!isset($_SESSION)) session_start();
define('PATH_TO', '../../../');

$files = [
    PATH_TO .'resources/CryptoJsAes.php',
    PATH_TO .'src/log/In.php'
];
foreach($files as $file) require_once($file);

$_POST = json_decode(file_get_contents("php://input"), true);

$email     = CryptoJsAes::decrypt(@$_POST['email']);
$password  = CryptoJsAes::decrypt(@$_POST['passwd']);
$token     = @$_POST['token'];

if( $token != $_SESSION['token'] ){
    exit(json_encode([
        'code' => 2,
        'status' => 'error',
        'error' => 'No estas autenticado.'
    ]));
}

unset($token, $_SESSION['token']);

In::access($email, $password);
<?php

define('PATH_TO', '../../../');

ini_set("memory_limit","128M");

require_once PATH_TO . 'resources/Encrypt.php';
// require_once PATH_TO . 'PHPMailer/PHPMailer.php';
// require_once PATH_TO . 'PHPMailer/SMTP.php';

$forward = str_replace(' ','+',$_GET['forward']);

$decrypt_data = Encrypt::datum('decrypt', $forward);

$data = explode('III', $decrypt_data);

$datum = (object)[
    'user'  => $data[2],
    'email' => $data[3]
];

$body  = "Hola $datum->user <br>";
$body .= "Sigue este vínculo para activar tu cuenta.<br>";
$body .= "El enlace estará vigente por un espacio de 30 minutos.<br>";
$body .= "https://".$_SERVER['HTTP_HOST']."/api/web/email/confirm.php?follow_link=$forward";

$headers  = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$subject = utf8_decode("Correo de Confirmación");

if(mail($datum->email,$subject,$body,$headers)){
    $content = file_get_contents('../view/forwared.php');
    exit($content);
}
else {
    exit("Mensaje: No se logro enviar el correo.");
}

// try {
//     //Server settings
//     $mail = new PHPMailer(true);
//     $mail->SMTPDebug = 0;
//     $mail->isSMTP();
//     $mail->Host       = PHPMailer::OWNERHOST;
//     $mail->SMTPAuth   = true;
//     $mail->Username   = PHPMailer::OWNERMAIL;
//     $mail->Password   = PHPMailer::OWNERPASS;
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//     $mail->Port       = PHPMailer::OWNERPORT;

//     //Recipients
//     $mail->setFrom(PHPMailer::OWNERMAIL, PHPMailer::OWNERUSER);
//     $mail->addAddress($datum->email);

//     // Content
//     $mail->isHTML(true);
//     $mail->Subject = utf8_decode("Reenvío de Confirmación");
//     $mail->Body = $body;

//     // Sending
//     if( $mail->send() ){
//         $content = file_get_contents('../view/forwared.php');
//         exit($content);
//     }
// }
// catch (Exception $e) {
//     echo "Mensaje: No se logro enviar el correo. Error: {$mail->ErrorInfo}";
// }
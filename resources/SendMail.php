<?php

require_once 'library/PHPMailer/PHPMailer.php';
require_once 'library/PHPMailer/SMTP.php';

$_POST = json_decode(file_get_contents("php://input"), true);

$data = <<<DATA
Nombre: $name<br>
Correo: $email<br>
Teléfono: $phone<br>
Asunto: $subject<br>
Mensaje: $message
DATA;

try {
    //Server settings
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = PHPMailer::OWNERHOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = PHPMailer::OWNERMAIL;
    $mail->Password   = PHPMailer::OWNERPASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = PHPMailer::OWNERPORT;

    //Recipients
    $mail->setFrom(PHPMailer::OWNERMAIL, PHPMailer::OWNERUSER);
    $mail->addAddress(PHPMailer::OWNERMAIL);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $data;

    // Sending
    $mail->send();

    echo 1;
}
catch (Exception $e) {
    echo "Mensaje: No se logro enviar el correo. Error: {$mail->ErrorInfo}";
}
<?php

session_start();

require("database/db.php");

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
)->data[0];

$user_name = $user->USU_NOME;
$user_email = $user->USU_EMAIL;

// Importando as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Carregando o autoloader do composer
require 'vendor/autoload.php';

// Instância da classe
$mail = new PHPMailer(true);

try {
    // Configurações do servidor
    $mail->isSMTP();        //Devine o uso de SMTP no envio
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true; //Habilita a autenticação SMTP
    $mail->Username   = 'freecommercegroup@gmail.com';
    $mail->Password   = 'rqnqmzriuicpxmhf';

    // Criptografia do envio SSL também é aceito
    $mail->SMTPSecure = 'tls';

    // Informações específicadas pelo Google
    $mail->Port = 587;

    // Remetente
    $mail->setFrom('freecommercegroup@gmail.com', 'free-Commerce');

    // Destinatário
    $mail->addAddress($user_email, $user_name);

    // Conteúdo da mensagem
    $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
    $mail->CharSet = 'UTF-8'; // Aceitando caracteres especiais
    $mail->Subject = 'Confirmação de compra';
    $mail->Body    = '<strong>Sua compra foi realizada com sucesso!</strong>';
    $mail->AltBody = 'Sua compra foi realizada com sucesso!';

    // Enviar
    $mail->send();

    header("location: views/completed_purchase_page.php");
    exit;
}

catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
<?php

session_start();

require("database/db.php");

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
)->data[0];

$product_name = $_GET["product_name"];
$product_price = $_GET["product_price"];
$seller = $_GET["seller"];

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
    // $mail->Body    = '<strong>Sua compra foi realizada com sucesso!</strong>';

    $mail->AddEmbeddedImage("images/order_email/header.png", "header", "header.png");
    $mail->AddEmbeddedImage("images/order_email/footer.png", "footer", "footer.png");

    $mail->Body = '
        <div style="font-family: Franklin Gothic Medium;">
            <div style="width: 70%; margin: auto;">
                <div style="width: 100%; margin-top: 2%;">
                    <img src="cid:header" style="width: 100%;">
                </div>
                <div style="width: 100%; position: relative; background-color: white; margin-top: 2%; margin-bottom: 2%; border-radius: 10px; padding-bottom: 2%;">
                    <div style="background-color: white; width: 70%; padding-top: 2%; padding-bottom: 2%; margin: auto;">
                        <div style="text-align: center;">
                            <h1 style="color: black;">Olá, ' . $user_name . '!</h1>
                            <p style="color: black;">Seu pedido foi realizado com sucesso!</p>
                            <p style="color: black;">Aqui está o resumo do seu pedido:</p>
                        </div>
                        
                        <div style="background-color: rgb(227, 253, 227); padding: 5%; border-radius: 10px;">
                            <div>
                                <h1 style="color: #fc5d02;">' . $product_name . '</h1>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                </div>
                                <p style="color: black;">Vendido por <strong>' . $seller . '</strong></p>
                                <p style="color: black;">Valor do item:</p>
                                <div>
                                    <p style="color: black;">R$</p>
                                    <p style="font-size: 25px; margin-top: 7%; color: black;"><strong>' . $product_price . '</strong></p>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <h3 style="color: #fc5d02;"><strong>Total:</strong></h3>
                                    <p style="color: #45a351; font-size: 40px; margin-top: 7%; margin-bottom: 0;">R$ ' . $product_price . '</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 100%; margin-bottom: 2%;">
                    <img src="cid:footer" style="width: 100%;">
                </div>
            </div>
        </div>
    ';
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
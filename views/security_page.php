<?php 
session_start();

require ("../database/db.php");

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
execute_array: [$_SESSION["user_id"]],
fetch_object: true,
)->data[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/security_profile.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/menu.css">
    <title>Segurança</title>
</head>
    <body>
        <?php include "header_page.php" ?>

<div class="public-info-container">
        <div class="menu">
            <?php include("menu.php") ?>
        </div>

    <div class="content">
        <h3 class="main-title"> Segurança </h3>

        <form action="../security.php" method="POST" class="form-public-info">
            <div>
                <label class="title">E-mail atual</label>
                <input class="field" name="email" type="text" value="<?= $user->USU_EMAIL ?>">
        
                <label class="title">Telefone</label>
                <input class="field" name="telefone" type="text" value="<?= $user->USU_TELEFONE ?>">
            </div>
            <div>
                <button class="btn"> Alterar </button>
            </div>  
        </form>

        <form action="../security_password.php" method="POST" class="form-public-info">

        <?php if(isset($_GET['feedback'])): ?>
            <div <?= $_GET['feedback'] == "sucesso" ? "class='sucesso'" : "class='erro'" ?>>
                <?= $_GET['msg'] ?>
            </div>
        <?php endif ?>
        
                <div>
                    <label class="title"> Senha atual </label>
                    <input class="field" name="senha_atual" type="password" placeholder="********">
                </div>
            <div>
                <label class="title"> Nova senha </label>
                <input class="field" name="nova_senha" type="password" placeholder="********">

                <label class="title"> Confirme sua senha </label>
                <input class="field" name="confirme_senha" type="password" placeholder="********">
            </div>

                <div>
                    <button class="btn">Salvar alterações</button>
                <div>
        </form>
    </div>
</div>
</body>
</html>
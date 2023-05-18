<?php

session_start();

require("../database/db.php");

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
    <title>Informações públicas</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/public_informations.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/menu.css">
</head>
<body>
    <?php include("header_page.php") ?>

    <div class="public-info-container">
        <div class="menu">
            <?php include("menu.php") ?>
        </div>
        <div class="content">
            <h3 class="main-title">Informações públicas</h3>

            <form action="../public_informations_update.php" method="POST" class="form-public-info">
                <label class="title">Nome:</label>
                <input class="field" name="name" type="text" value="<?= $user->USU_NOME ?>">

                <label class="title">Apelido:</label>
                <input class="field" name="nickname" type="text" value="<?= $user->USU_APELIDO ?>">

                <label class="title">Nascimento:</label>
                <input class="field" name="birthday" type="date" value="<?= $user->USU_NASCIMENTO ?>">

                <label class="title">Descrição:</label>
                <textarea class="field-description" name="description" rows="10"><?= $user->USU_DESCRICAO ?? '' ?></textarea>

                <button class="btn">Salvar alterações</button>
            </form>
        </div>
    </div>
</body>
</html>
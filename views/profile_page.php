<?php 

session_start();

require("../database/db.php");

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
}

$all_products = stmt(
    prepare: "
        SELECT * FROM FCM_PRODUTOS
        JOIN FCM_CATEGORIAS ON CAT_CODIGO = PRO_CAT_CODIGO
        JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
    ",
    fetch_object: true
)->data;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/profile.css">
     <link rel="stylesheet" href="../css/header.css">
    <title> Perfil </title>
</head>
<body>
   
    <?php include "header_page.php" ?>

    <div class="Container_all">
        <div class="Container_header">
            <div class="img_header">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/800px-Placeholder_view_vector.svg.png">
            </div>
        <div class="grup">
            <div class="grup_unfollow">
                <img class="img_unfollow" src="../images/img_vendor/profiletwo.png" alt="">
                <p class="text_unfollow"> Seguidores: </p>
            </div>

            <div class="grup_unfollow">
                <img class="img_unfollow" src="../images/img_vendor/profile.png" alt="">
                <p class="text_unfollow"> Seguindo: </p>
            </div>

            <div class="grup_unfollow">
                <img class="img_unfollow" src="../images/img_vendor/cesta.png" alt="">
                <p class="text_unfollow"> Produtos: </p>
            </div>

            <p class="title_text">Descrição:</p>
            <textarea class="textarea" name="description" id="" cols="5" rows="5"></textarea>
            
            <button class="button"> Salvar informação </button> 

            <div class="quest_seller">
                <a href="seller_page.php"> Quer vender seus produtos? <br> <span class="name_left"> Clique aqui </span> </a>
            </div>
        </div>
    </div>    
</body>
</html>
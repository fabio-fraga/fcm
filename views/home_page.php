<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
}

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
    <link rel="stylesheet" href="../css/home.css">
    <title> Free-Commerce</title>
</head>
<body>
    <div class="bemvindo_topo">
        <h1>Bem-vindo(a), <?= $_SESSION["user_name"] ?>!</h1>
    </div>
<header>

    <div class="container">
        <div class="tamanho_pesquisa">
            <input type="text" id="txtBusca" placeholder="Oq Você Procura?....."/>
        </div>
       

        <div class="tamanho_link">
            <a href="cart_page.php"><img src="../images/img_home/cart.png" alt="CarrinhoDeCompras"> </a>

            <a  href="profile_page.php?user_id=<?= $_SESSION["user_id"] ?>"> <img class="tamanho_img" src="../images/img_home/perfil.png" alt="Perfil"></a>
        
            <a href="notification.php"> <img class="tamanho_img" src="../images/img_home/sino.png" alt="notificação"> </a>
        </div>
    </div>

    <div>
        <img class="tamanho_logo" src="../images/logo.png" alt="logo">
    </div>

<div class="itens">
    <div class="link_itens">
         <a href="category_page.php"> <span class="tamanho_itens"> Categorias </span> </a>
    </div>

    <div class="link_itens">
        <a href="fresh_page.php"> <span class="tamanho_itens"> Fresquinhos </span> </a>
    </div>

    <div class="link_itens">
        <a  href="seller_page.php?user_id=<?= $_SESSION["user_id"] ?>"> <span class="tamanho_itens"> Venda seus produtos </span> </a>
    </div>
</div>

    <div class="largura_button">
        <button class="tamanho_button">
            <a style="text-decoration: none;" href="../logout.php">Sair</a>
        </button>
    </div>
</body>
</html>


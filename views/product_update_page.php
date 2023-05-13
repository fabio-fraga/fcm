<?php 

require("../database/db.php");

$product_id = $_GET["product_id"];

$product = stmt(
    prepare: "SELECT * FROM FCM_PRODUTOS WHERE PRO_CODIGO = ?",
    execute_array: [$product_id],
    fetch_object:  true
)->data[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/product_update.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Atualização</title>
</head>
<body>
  
    <?php include "header_page.php" ?>
    
    <div class="nome_header">
        <h1> Atualize seus produtos </h1>
    </div>
    
<div class="container2">
    <div class="product_img">
        <img src="../images/coxinha.jpg" alt="">
    </div>

    <form action="../product_update.php" method='POST'>
        <div class="product_edit">
            <label class="product" for="product"> produto: </label>
            <input name="name" type="text" id="product" value="<?= $product->PRO_NOME ?>">

            <label class="product" for="value"> Valor: </label>
            <input name="value" type="number" id="value" value="<?= $product->PRO_VALOR ?>">

            <label class="product" for="quantity"> Quantidade: </label>
            <input name="amount" type="number" id="quantity" value="<?= $product->PRO_QUANTIDADE_DISPONIVEL ?>">
            
            <input type="hidden" name="id" value="<?= $product->PRO_CODIGO?>">
            <button class="button">Alterar</button>
        </div>
    </form>
</div>   
</body>
</html>

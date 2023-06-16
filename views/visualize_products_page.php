<?php

session_start();

require("../database/db.php");
require("../functions/functions.php");

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
    exit;
}

$categories = stmt(
    prepare:"
        SELECT * FROM FCM_CATEGORIAS ORDER BY CAT_CODIGO
    ",
    fetch_object: true
)->data;

$seller_products = stmt(
    prepare: "
        SELECT * FROM FCM_PRODUTOS WHERE PRO_CMT_CODIGO = ?
    ",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.co" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/visualize.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/menu_products_page.css">
    <title>Atualize seus produtos</title>
</head>
<body>

    <?php include "header_page.php" ?>

    <div class="menu">
        <?php include("menu_products_page.php") ?>
    </div>

<div class="Container_grid2">
    <div class="Container_2">
        <?php if ($seller_products->row_count > 0): ?>
            <h2 class="name_container2">Seus produtos</h2>
            <p class="namee_container2"> Atualize ou apague seus produtos com apenas um Click </p>
            <table class="tl_container2">
                <thead>
                    <tr>
                        <th class="cont_top">Nome do produto</th>
                        <th class="cont_top">Valor</th>
                        <th class="cont_top" >Quantidade</th>
                        <th class="cont_top" > atualizar</th>
                        <th class="cont_top" > Deletar </th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php foreach ($seller_products->data as $product): ?>
                        <tr>
                            
                            <td class="cont_left"> <input type="text" name="nome" value="<?= $product->PRO_NOME ?>"> </td> 
                            <td class="cont_center"> <input type="text" name="valor" value="<?= $product->PRO_VALOR ?>"></td>
                            <td class="cont_center"> <input type="text" name="quantidade" value="<?= $product->PRO_QUANTIDADE_DISPONIVEL ?>"></td>
                            
                            <td class="cont_center">
                                <a href="product_update_page.php?product_id=<?= $product->PRO_CODIGO?>"> <span class="green">&#9998;</span></a> 
                            </td>

                            <td class="tamanho_lixin">
                                <a href="../product_delete.php?product_id=<?= $product->PRO_CODIGO ?>" onclick="return confirm('Você tem certeza que deseja excluir este produto?')"> <img class="mine-trash" src="../images/img_seller/lixoverde.png" alt=""></a> 
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
        <?php endif ?>
    </div>
</div>
</body>
</html>
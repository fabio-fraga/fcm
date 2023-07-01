<?php

session_start();

require("../database/db.php");

$all_products = stmt(
    prepare: "
        SELECT * FROM FCM_VENDAS
        JOIN FCM_PRODUTOS ON PRO_CODIGO = VEN_PRO_CODIGO
        JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
        WHERE VEN_USU_CODIGO = ?
        ORDER BY VEN_DATA DESC
    ",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
)->data;

?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/orders.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/menu.css">
</head>
<body>
    <?php include("header_page.php") ?>

    <div class="orders-container">
        <div class="menu">
            <?php include("menu.php") ?>
        </div>
        <div class="content">
            <h3 class="main-title">Seus pedidos</h3>

            <div class="products-container">     
                <?php foreach ($all_products as $key => $product): ?>
                    <div class="grid-item">
                        <div class="item-container" onclick="window.location='product_page.php?product_id=<?= $product->PRO_CODIGO ?>'">
                            <div class="date">#<?= sizeof($all_products) - $key . ' - ' . date_format(date_create($product->VEN_DATA), "d/m/Y") ." às " . explode(' ', $product->VEN_DATA)[1]?></div>
                            <div class="img-container">
                                <?php
                                $product_images = stmt(
                                    prepare: "
                                        SELECT * FROM FCM_PRODUTOS_FOTOS
                                        WHERE PFT_PRO_CODIGO = ?
                                    ",
                                    execute_array: [$product->PRO_CODIGO],
                                    fetch_object: true
                                )->data;
                                ?>
                                <img class="img-item" src="<?= "../" . $product_images[0]->PFT_CAMINHO ?>">
                            </div>
                            <div class="seller">
                                <span><a href=""><?= $product->CMR_NOME ?></a></span>
                            </div>
                            <div class="title"><?= $product->PRO_NOME ?></div>
                            <div><?=$product->VEN_PRO_QUANTIDADE ?> unidade(s)</div>
                            Total: <div class="price">R$ <?= number_format($product->PRO_VALOR * $product->VEN_PRO_QUANTIDADE, 2, ',', '.') ?></div>
                            <?php
                                $product_sales = stmt("
                                    SELECT 
                                    COALESCE(SUM(VEN_PRO_QUANTIDADE), 0) AS PRO_SALES
                                    FROM FCM_VENDAS
                                    WHERE
                                    VEN_PRO_CODIGO = ?
                                ",
                                execute_array: [$product->PRO_CODIGO],
                                fetch_object: true
                                )->data[0]->PRO_SALES;
                            ?>
                            <div class="sales"><?= $product_sales == 0 ? "Nenhuma venda" : $product_sales . " vendido(s)"?></div>
                            <div class="rating">
                                <?php
                                
                                $product_avg = stmt(
                                    prepare: "
                                        SELECT AVG(AVA_NOTA) AS PRO_MEDIA_DE_NOTAS
                                        FROM FCM_AVALIACOES_DOS_PRODUTOS
                                        WHERE AVA_PRO_CODIGO = ?
                                            ",
                                    execute_array: [$product->PRO_CODIGO],
                                    fetch_object: true
                                )->data[0]->PRO_MEDIA_DE_NOTAS; 
                                
                                ?>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= $product_avg): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="14" height="14" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" stroke="#ffca0f" width="14" height="14" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <?php endif ?>
                                <?php endfor ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>
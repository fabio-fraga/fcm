<?php

session_start();

require("database/db.php");

$product_id = $_GET["product_id"];
$amount = $_GET["amount"];

if (!isset($_GET["product_id"]) || !isset($_GET["amount"])) {
    $user_products = stmt(
        prepare: "
            SELECT * FROM FCM_CARRINHO_DE_COMPRAS
            JOIN FCM_PRODUTOS ON PRO_CODIGO = CDC_PRO_CODIGO
            WHERE CDC_USU_CODIGO = ?
        ",
        execute_array: [$_SESSION["user_id"]],
        fetch_object: true
    )->data;
} else {
    $user_products = stmt(
        prepare: "
            SELECT * FROM FCM_PRODUTOS
            WHERE PRO_CODIGO = ?
        ",
        execute_array: [$product_id],
        fetch_object: true
    )->data;
}

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d G:i:s");

foreach ($user_products as $product) {  
    stmt(
        prepare: "
            INSERT INTO FCM_VENDAS (VEN_PRO_CODIGO, VEN_USU_CODIGO, VEN_DATA, VEN_PRO_QUANTIDADE)
            VALUES (?, ?, ?, ?)
        ",
        execute_array: [$product->PRO_CODIGO, $_SESSION["user_id"], $date, $amount ?? $product->CDC_QUANTIDADE]
    );
    
    stmt(
        prepare: "
            UPDATE FCM_PRODUTOS
            SET PRO_QUANTIDADE_DISPONIVEL = PRO_QUANTIDADE_DISPONIVEL - ?
            WHERE PRO_CODIGO = ?
        ",
        execute_array: [$amount ?? $product->CDC_QUANTIDADE, $product->PRO_CODIGO]
    );

    stmt(
        prepare: "DELETE FROM FCM_CARRINHO_DE_COMPRAS WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ? AND CDC_SELECIONADO = ?",
        execute_array: [$product->PRO_CODIGO, $_SESSION["user_id"], 1]
    );
}

$seller = stmt(
    prepare: "
        SELECT CMR_NOME
        FROM FCM_PRODUTOS
        JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
        WHERE PRO_CODIGO = ?
    ",
    execute_array: [$product_id],
    fetch_object: true
)->data[0]->CMR_NOME;

$product_name = $product->PRO_NOME;
$product_price = number_format($product->PRO_VALOR, 2, ',', '.');

header("location: send_email.php?product_name=" . $product_name . "&product_price=" . $product_price . "&seller=" . $seller);

?>
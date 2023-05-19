<?php 

session_start();

require("database/db.php");

$product_id = $_GET["product_id"];
$amount = $_GET["amount"];
$key = $_GET["key"];

$product_exist = stmt(
    prepare: "SELECT * FROM FCM_CARRINHO_DE_COMPRAS WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
    execute_array: [$product_id, $_SESSION["user_id"]]
)->row_count;

if ($product_exist) {
    header('location: views/home_page.php?err=Este produto já está no seu carrinho de compras!&key=' . $key);
    exit;
}

stmt(
    prepare: "INSERT INTO FCM_CARRINHO_DE_COMPRAS (CDC_PRO_CODIGO, CDC_USU_CODIGO, CDC_QUANTIDADE, CDC_SELECIONADO) VALUES (?, ?, ?, ?)",
    execute_array: [$product_id, $_SESSION["user_id"], $amount, 0]
);

header('location: views/home_page.php');

?>
<?php 

session_start();

require("database/db.php");

$product_amount = stmt(
    prepare: "SELECT CDC_QUANTIDADE FROM FCM_CARRINHO_DE_COMPRAS WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
    execute_array: [$_GET["product_id"], $_SESSION["user_id"]],
    fetch_object: true
)->data[0]->CDC_QUANTIDADE;

if ($_GET["action"] == "diminuir" && $_GET["product_id"] && $product_amount > 1) {
    stmt(
        prepare: "UPDATE FCM_CARRINHO_DE_COMPRAS SET CDC_QUANTIDADE = CDC_QUANTIDADE - 1 WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
        execute_array: [$_GET["product_id"], $_SESSION["user_id"]]
    );    
}

if ($_GET["action"] == "aumentar") {
    stmt(
        prepare: "UPDATE FCM_CARRINHO_DE_COMPRAS SET CDC_QUANTIDADE = CDC_QUANTIDADE + 1 WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
        execute_array: [$_GET["product_id"], $_SESSION["user_id"]]
    );
}

if (isset($_POST["selected"]) && $_POST["selected"] == 0) {
    stmt(
        prepare: "UPDATE FCM_CARRINHO_DE_COMPRAS SET CDC_SELECIONADO = 0 WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
        execute_array: [$_POST["product_id"], $_SESSION["user_id"]]
    );
}

if (isset($_POST["selected"]) && $_POST["selected"] == 1) {
    stmt(
        prepare: "UPDATE FCM_CARRINHO_DE_COMPRAS SET CDC_SELECIONADO = 1 WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
        execute_array: [$_POST["product_id"], $_SESSION["user_id"]]
    );
}

header('location: views/cart_page.php');

?>
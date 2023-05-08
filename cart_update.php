<?php 

session_start();

require("database/db.php");

if($_GET["action"] == "diminuir"){
    stmt(
        prepare: "UPDATE FCM_CARRINHO_DE_COMPRAS SET CDC_QUANTIDADE = CDC_QUANTIDADE - 1 WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
        execute_array: [$_GET["product_id"], $_SESSION["user_id"]]
    );
    
}
if($_GET["action"] == "aumentar"){
    stmt(
        prepare: "UPDATE FCM_CARRINHO_DE_COMPRAS SET CDC_QUANTIDADE = CDC_QUANTIDADE + 1 WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
        execute_array: [$_GET["product_id"], $_SESSION["user_id"]]
    );
}

header('location: views/cart_page.php');

?>
<?php 

session_start();

require("database/db.php");

stmt(
    prepare: "DELETE FROM FCM_CARRINHO_DE_COMPRAS WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?",
    execute_array: [$_GET["product_id"], $_SESSION["user_id"]]
);

header('location: views/cart_page.php');


?>
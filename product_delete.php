<?php 

session_start();

require("database/db.php");

$product_id = $_GET["product_id"];

stmt("
    DELETE FROM FCM_CARRINHO_DE_COMPRAS WHERE CDC_PRO_CODIGO = ? AND CDC_USU_CODIGO = ?
    ",
    [$product_id, $_SESSION["user_id"]]
);

stmt("
    DELETE FROM FCM_PRODUTOS WHERE PRO_CODIGO = ? AND PRO_CMT_CODIGO = ?
    ",
    [$product_id, $_SESSION["user_id"]]
);

header("location: views/products_page.php");

?>
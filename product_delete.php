<?php 

require("database/db.php");

$product_id = $_GET["product_id"];

stmt("
    DELETE FROM FCM_PRODUTOS WHERE PRO_CODIGO = ?
    ",
    [$product_id]
);

header("location: views/products_page.php");

?>
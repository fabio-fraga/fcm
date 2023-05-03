<?php

session_start();

require("database/db.php");
require("functions/functions.php");

$name = $_POST["name"];
$price = $_POST["price"];
$amount = $_POST["amount"];
$category = $_POST["category"];

stmt(
    prepare:"
        INSERT INTO FCM_PRODUTOS (PRO_NOME, PRO_VALOR, PRO_QUANTIDADE_DISPONIVEL, PRO_CAT_CODIGO, PRO_CMT_CODIGO)
        VALUES (?, ?, ?, ?, ?)
    ",
    execute_array: [$name, $price, $amount, $category, $_SESSION["user_id"]]
);

header("location: views/products_page.php");

?>
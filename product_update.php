<?php

require("database/db.php");

$name = $_POST['name'];
$value = $_POST['value'];
$amount = $_POST['amount'];
$product_id = $_POST['id'];

stmt(
    prepare: "UPDATE FCM_PRODUTOS SET PRO_NOME = ?, PRO_VALOR = ?, PRO_QUANTIDADE_DISPONIVEL = ? WHERE PRO_CODIGO = ?",
    execute_array: [$name, $value, $amount, $product_id]
);

header("location: views/product_update_page.php?product_id=" . $product_id);

?>
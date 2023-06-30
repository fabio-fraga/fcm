<?php

session_start();

require("database/db.php");

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

$product_id = $dbh->lastInsertId();

for ($i = 0; $i < sizeof($_POST["images"]); $i++) {
    list(, $img) = explode(';', $_POST["images"][$i]);
    
    list(, $img) = explode(',', $img);
    
    $img = base64_decode($img);

    $img_name = (time() + $i) . ".jpg";

    if (!file_exists("images/products")) {
        mkdir("images/products");
    }

    $path = "images/products/" . $img_name;

    file_put_contents($path, $img);

    stmt(
        prepare: "
            INSERT INTO FCM_PRODUTOS_FOTOS
            (PFT_CAMINHO, PFT_PRO_CODIGO)
            VALUES(?, ?)
        ",
        execute_array: [$path, $product_id]
    );
}

?>
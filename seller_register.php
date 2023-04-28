<?php

session_start();

require("database/db.php");
require("functions/functions.php");

$seller = $_POST["seller"];
$street = $_POST["street"];
$locality = $_POST["locality"];
$federative_unit = $_POST["federative_unit"];

if (has_only_spaces($seller) === true) {
    header("location: views/seller_page.php?err=O campo não pode conter somente caracteres em branco!");
    exit;
}

if (empty($seller) === true) {
    header("location: views/seller_page.php?err=Preencha o campo!");
    exit;
}

$federative_unit_id = stmt(
    prepare: "SELECT * FROM FCM_UNIDADES_FEDERATIVAS WHERE UNF_NOME = ?",
    execute_array: [$federative_unit],
    fetch_object: true
    )->data[0]->UNF_CODIGO;

    stmt(
        prepare: "
        INSERT INTO FCM_LOCALIDADES (LOC_NOME, LOC_UNF_CODIGO)
        VALUES (?, ?)
        ",
        execute_array: [$locality, $federative_unit_id]
    );
    
    $locality_id = $dbh->lastInsertId();
    
    stmt(
        prepare:"
        INSERT INTO FCM_LOGRADOUROS (LOG_NOME, LOG_LOC_CODIGO)
        VALUES (?, ?)
        ",
        execute_array: [$street, $locality_id]
    );

$street_id = $dbh->lastInsertId();

stmt(
    prepare: "
        INSERT INTO FCM_COMERCIOS (CMR_NOME, CMR_USU_CODIGO, CMR_LOG_CODIGO)
        VALUES (?, ?, ?)
    ",
    execute_array: [$seller, $_SESSION["user_id"], $street_id]
);

header("location: views/seller_page.php")

?>
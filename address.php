<?php 

session_start();

require('database/db.php');

$street = $_POST["street"];
$number = $_POST["number"] ?: null;
$complement = $_POST["complement"] ?: null;
$locality = $_POST["locality"];
$federative_unit = $_POST["federative_unit"];



//armazena o valor do código da unidade federativa
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
    prepare:"
        INSERT INTO FCM_LOGRADOUROS_DOS_USUARIOS (LDU_USU_CODIGO, LDU_LOG_CODIGO, LDU_NUMERO, LDU_COMPLEMENTO)
        VALUES (?, ?, ?, ?)
    ",
    execute_array: [$_SESSION['user_id'], $street_id, $number, $complement]
);

header("location: views/address_page.php");

?>
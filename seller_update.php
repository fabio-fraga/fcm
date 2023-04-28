<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
    exit;
}

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

$locality_id = $_SESSION["locality_id"];

stmt(
    prepare: "
        UPDATE FCM_LOCALIDADES
        SET
        LOC_NOME = ?,
        LOC_UNF_CODIGO = ?
        WHERE LOC_CODIGO = ?
    ",
    execute_array: [$locality, $federative_unit_id, $locality_id]
);

$street_id = $_SESSION["street_id"];

stmt(
    prepare:"
        UPDATE FCM_LOGRADOUROS
        SET
        LOG_NOME = ?,
        LOG_LOC_CODIGO = ?
        WHERE LOG_CODIGO = ?
    ",
    execute_array: [$street, $locality_id, $street_id]
);

stmt(
    prepare: "
        UPDATE FCM_COMERCIOS
        SET
        CMR_NOME = ?
        WHERE CMR_USU_CODIGO = ?
    ",
    execute_array: [$seller, $_SESSION["user_id"]]
);

header("location: views/seller_page.php"); 

?>

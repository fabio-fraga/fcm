<?php

session_start();

require("database/db.php");

$street_id = $_GET["street_id"];

$addresses_count = stmt(
    prepare: "
        SELECT * FROM FCM_LOGRADOUROS_DOS_USUARIOS
        JOIN FCM_LOGRADOUROS ON LDU_LOG_CODIGO = LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        JOIN FCM_UNIDADES_FEDERATIVAS ON UNF_CODIGO = LOC_UNF_CODIGO
        JOIN FCM_PAISES ON PAIS_CODIGO = UNF_PAIS_CODIGO
        WHERE LDU_USU_CODIGO = ?
    ",
    execute_array: [$_SESSION['user_id']],
    fetch_object: true
)->row_count;

if ($addresses_count == 1) {
    header("location: views/address_page.php?error_delete=Você deve ter ao menos um endereço cadastrado!");
    exit;
}

stmt(
    prepare: "
        DELETE FCM_LOGRADOUROS_DOS_USUARIOS, FCM_LOGRADOUROS, FCM_LOCALIDADES
        FROM FCM_LOGRADOUROS_DOS_USUARIOS
        JOIN FCM_LOGRADOUROS ON LOG_CODIGO = LDU_LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        WHERE LDU_USU_CODIGO = ? AND LOG_CODIGO = ?
    ",
    execute_array: [$_SESSION['user_id'], $street_id]
);

header("location: views/address_page.php");

?>

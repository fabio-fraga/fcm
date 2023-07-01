<?php

session_start();

require("database/db.php");

$locality_id = $_POST["locality_id"];
$street_id = $_POST["street_id"];

$cep = $_POST["cep"];
$street = $_POST["street"];
$number = intval($_POST["number"]) ?: null;
$complement = $_POST["complement"] ?: null;
$locality = $_POST["locality"];
$federative_unit = $_POST["federative_unit"];

stmt(
    prepare: "
        UPDATE FCM_LOCALIDADES
        SET LOC_NOME = ?,
        LOC_UNF_CODIGO = (
            SELECT UNF_CODIGO
            FROM FCM_UNIDADES_FEDERATIVAS
            WHERE UNF_NOME = ?
        )
        WHERE LOC_CODIGO = ?
    ",
    execute_array: [$locality, $federative_unit, $locality_id]
);

stmt(
    prepare: "
        UPDATE FCM_LOGRADOUROS
        SET LOG_NOME = ?
        WHERE LOG_CODIGO = ?
    ",
    execute_array: [$street, $street_id]
);

stmt(
    prepare: "
        UPDATE FCM_LOGRADOUROS_DOS_USUARIOS
        SET LDU_NUMERO = ?,
        LDU_COMPLEMENTO = ?,
        LDU_CEP = ?
        WHERE LDU_USU_CODIGO = ? AND LDU_LOG_CODIGO = ?
    ",
    execute_array: [$number, $complement, $cep, $_SESSION["user_id"], $street_id]
);

header("Location: views/address_page.php")

?>

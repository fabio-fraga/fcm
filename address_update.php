<?php

require("db.php");

$street = $_POST["street"];
$number = $_POST["number"];
$complement = $_POST["complement"];
$federative_unit = $_POST["federative_unit"];

stmt(
    prepare: "
        UPDATE FCM_LOGRADOUROS_DOS_USUARIOS
        SET LDU_NUMERO = ?, LDU_COMPLEMENTO = ?
        WHERE LDU_USU_CODIGO = ?
    ",
    execute_array: [$number, $complement, $_SESSION['user_id']]
);


?>
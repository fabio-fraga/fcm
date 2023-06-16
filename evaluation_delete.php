<?php

session_start();

require("database/db.php");

$product_id = $_GET['product_id'];

stmt(
    prepare: "
        DELETE FROM FCM_AVALIACOES_DOS_PRODUTOS
        WHERE
        AVA_PRO_CODIGO = ? AND
        AVA_USU_CODIGO = ?
    ",
    execute_array: [$product_id, $_SESSION['user_id']]
);

?>
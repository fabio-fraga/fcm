<?php

session_start();

require("database/db.php");

$product_id = $_POST['product_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d G:i:s");

stmt(
    prepare: "
        UPDATE FCM_AVALIACOES_DOS_PRODUTOS
        SET
        AVA_DATA = ?,
        AVA_NOTA = ?,
        AVA_COMENTARIO = ?
        WHERE
        AVA_PRO_CODIGO = ? AND
        AVA_USU_CODIGO = ?
    ",
    execute_array: [$date, $rating, $comment, $product_id, $_SESSION['user_id']]
);

?>
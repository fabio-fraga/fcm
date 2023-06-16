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
        INSERT INTO FCM_AVALIACOES_DOS_PRODUTOS (AVA_PRO_CODIGO, AVA_USU_CODIGO, AVA_DATA, AVA_NOTA, AVA_COMENTARIO)
        VALUES (?, ?, ?, ?, ?)
    ",
    execute_array: [$product_id, $_SESSION['user_id'], $date, $rating, $comment]
);

?>
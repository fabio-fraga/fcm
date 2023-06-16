<?php

session_start();

require("../database/db.php");

$product_id = $_GET["product_id"];

$user_evaluated = stmt(
    prepare: "
        SELECT *
        FROM FCM_AVALIACOES_DOS_PRODUTOS
        WHERE AVA_PRO_CODIGO = ?
        AND AVA_USU_CODIGO = ?
    ",
    execute_array: [$product_id, $_SESSION['user_id']],
    fetch_object: true
)->row_count;

$user_bought = stmt(
    prepare: "
        SELECT *
        FROM FCM_VENDAS
        WHERE VEN_PRO_CODIGO = ? AND
        VEN_USU_CODIGO = ?
    ",
    execute_array: [$product_id, $_SESSION['user_id']],
    fetch_object: true
)->row_count;

$product_avg = stmt(
    prepare: "
        SELECT AVG(AVA_NOTA) AS PRO_MEDIA_DE_NOTAS
        FROM FCM_AVALIACOES_DOS_PRODUTOS
        WHERE AVA_PRO_CODIGO = ?
    ",
    execute_array: [$product_id],
    fetch_object: true
)->data[0]->PRO_MEDIA_DE_NOTAS;

if ($user_evaluated > 0) {
    $user_evaluated = true;
} else {
    $user_evaluated = false;
}

if ($user_bought > 0) {
    $user_bought = true;
} else {
    $user_bought = false;
}

$evaluations = stmt(
    prepare: "
        SELECT AVA_DATA, AVA_NOTA, AVA_COMENTARIO, USU_NOME, USU_APELIDO, USU_FOTO
        FROM FCM_AVALIACOES_DOS_PRODUTOS, FCM_USUARIOS
        WHERE AVA_PRO_CODIGO = ?
        AND AVA_USU_CODIGO = USU_CODIGO
        ORDER BY FIELD(AVA_USU_CODIGO, ?) DESC, AVA_DATA DESC
    ",
    execute_array: [$product_id, $_SESSION['user_id']],
    fetch_object: true
)->data;

$data = [
    "product_avg" => $product_avg,
    "user_bought" => $user_bought,
    "user_evaluated" => $user_evaluated,
    "evaluations" => $evaluations
];

$data = json_encode($data, JSON_PRETTY_PRINT);

header("Content-Type: application/json");

echo $data;

?>
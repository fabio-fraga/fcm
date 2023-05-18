<?php

session_start();

$name = $_POST["name"];
$birthday = $_POST["birthday"];
$nickname = $_POST["nickname"];
$description = $_POST["description"];

require("database/db.php");

stmt(
    prepare: "
        UPDATE FCM_USUARIOS
        SET
        USU_NOME = ?,
        USU_NASCIMENTO = ?,
        USU_APELIDO = ?,
        USU_DESCRICAO = ?
        WHERE USU_CODIGO = ?
    ",
    execute_array: [$name, $birthday, $nickname, $description, $_SESSION["user_id"]]
);

header("location: views/public_informations_page.php"); 

?>
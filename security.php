<?php 
session_start();

require ("database/db.php");

$email = $_POST["email"];
$telefone = $_POST['telefone'];

stmt(
    prepare: "UPDATE FCM_USUARIOS SET USU_EMAIL = ?, USU_TELEFONE = ? WHERE USU_CODIGO = ?",
    execute_array: [$email, $telefone, $_SESSION['user_id']]
);

header("location: views/security_page.php");
?> 
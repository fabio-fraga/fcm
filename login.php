<?php

session_start();

require("database/db.php");
require("functions/functions.php");

$email = $_POST["email"];
$password = sha1($_POST["password"]);

$required_fields = [$email, $_POST["password"]];

foreach ($required_fields as $required_field) {
    if (empty($required_field) === true || has_only_spaces($required_field) === true) {
        header("location: views/login_page.php?err=Preencha todos os campos obrigatórios!");
        exit;
    }
}

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_EMAIL = ?",
    execute_array: [$email],
    fetch_object: true
);

if ($user->row_count === 0) {
    header("location: views/login_page.php?err=Usuário não cadastrado!");
} else {
    if ($user->data[0]->USU_SENHA !== $password) {
        header("location: views/login_page.php?err=Senha incorreta!");
    } else {
        $_SESSION["user_id"] = $user->data[0]->USU_CODIGO;
        $_SESSION["user_name"] = $user->data[0]->USU_NOME;
        header("location: views/home_page.php");
    }
}

?>

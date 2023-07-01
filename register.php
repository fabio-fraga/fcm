<?php

require("database/db.php");
require("functions/functions.php");

$name = $_POST["name"];
$cpf = $_POST["cpf"];
$birthday = $_POST["birthday"];
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$phone_number = $_POST["phone_number"];
$password = $_POST["password"];

$cep = $_POST["cep"];
$house_number = $_POST["house_number"] ?: null;
$complement = $_POST["complement"] ?: null;
$street = $_POST["street"];
$locality = $_POST["locality"];
$federative_unit = $_POST["federative_unit"];

$users = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS",
    fetch_object: true
)->data;

$cpfs = [];
$emails = [];

foreach ($users as $user) {
    array_push($emails, $user->USU_EMAIL);
    array_push($cpfs, $user->USU_CPF);
}

$errors = '';

if (in_array($cpf, $cpfs)) {
    $errors .= "register_errors[]=CPF já cadastrado!&";
}

if (in_array($email, $emails)) {
    $errors .= "register_errors[]=E-mail já cadastrado!&";
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $errors .= "register_errors[]=Insira um e-mail válido!&";
}

if (strlen(filter_var($cpf, FILTER_SANITIZE_NUMBER_INT)) !== 11) {
    $errors .= "register_errors[]=O CPF precisa ter 11 dígitos numéricos!&";
}

if (strlen(filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT)) !== 11) {
    $errors .= "register_errors[]=O número de celular precisa ter 11 dígitos numéricos!&";
}

if (strlen($password) < 8 || strlen($password) > 45) {
    $errors .= "register_errors[]=A senha deve ter de 8 a 45 caracteres!&";
}

if (has_only_spaces($_POST["complement"]) === true) {
    $errors .= "register_errors[]=O campo complemento não pode conter somente caracteres em branco!&";
}

$required_fields = [$name, $cpf, $email, $phone_number, $password, $street, $locality, $federative_unit];

foreach ($required_fields as $required_field) {
    if (empty($required_field) === true || has_only_spaces($required_field) === true) {
        $errors .= "register_errors[]=Preencha todos os campos obrigatórios!&";
    }
}

$errors = $errors[strlen($errors) - 1] == '&' ? $errors = rtrim($errors, '&') : $errors;

if (strlen($errors) > 0) {
    header("location: views/user_register_page.php?$errors");
    exit;
}

$federative_unit_id = stmt(
    prepare: "SELECT * FROM FCM_UNIDADES_FEDERATIVAS WHERE UNF_NOME = ?",
    execute_array: [$federative_unit],
    fetch_object: true
)->data[0]->UNF_CODIGO;

stmt(
    prepare: "
        INSERT INTO FCM_LOCALIDADES (LOC_NOME, LOC_UNF_CODIGO)
        VALUES (?, ?)
    ",
    execute_array: [$locality, $federative_unit_id]
);

$locality_id = $dbh->lastInsertId();

stmt(
    prepare:"
        INSERT INTO FCM_LOGRADOUROS (LOG_NOME, LOG_LOC_CODIGO)
        VALUES (?, ?)
    ",
    execute_array: [$street, $locality_id]
);

$street_id = $dbh->lastInsertId();

stmt(
    prepare: "
        INSERT INTO FCM_USUARIOS (USU_CPF, USU_NOME, USU_NASCIMENTO, USU_EMAIL, USU_TELEFONE, USU_SENHA)
        VALUES (?, ?, ?, ?, ?, ?)
    ",
    execute_array: [$cpf, $name, $birthday, $email, $phone_number, sha1($password)]
);

$user_id = $dbh->lastInsertId();

stmt(
    prepare:"
        INSERT INTO FCM_LOGRADOUROS_DOS_USUARIOS (LDU_USU_CODIGO, LDU_LOG_CODIGO, LDU_NUMERO, LDU_COMPLEMENTO, LDU_CEP)
        VALUES (?, ?, ?, ?, ?)
    ",
    execute_array: [$user_id, $street_id, $house_number, $complement, $cep]
);

header("location: views/login_page.php");

?>

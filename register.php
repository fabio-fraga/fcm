<?php

require("database/db.php");
require("functions/functions.php");

$name = $_POST["name"];
$cpf = $_POST["cpf"];
$birthday = $_POST["birthday"];
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$phone_number = $_POST["phone_number"];
$password = $_POST["password"];

$street = $_POST["street"];
$house_number = $_POST["house_number"] ?: "S/N";
$neighborhood = $_POST["neighborhood"];
$city = $_POST["city"];
$state = $_POST["state"];
$cep = !empty($_POST["cep"]) ? ". CEP: " . substr_replace($_POST["cep"], '-', 5, 0) . "." : '.';
$complement = !empty($_POST["complement"]) ? " Complemento: {$_POST["complement"]}." : '';
$adress = "{$street}, {$house_number}, {$neighborhood}, {$city} - {$state}{$cep}{$complement}";

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

$errors = [];

if (in_array($cpf, $cpfs)) {
    array_push($errors, "CPF já cadastrado!");
}

if (in_array($email, $emails)) {
    array_push($errors, "E-mail já cadastrado!");
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    array_push($errors, "Insira um e-mail válido!");
}

if (strlen(filter_var($cpf, FILTER_SANITIZE_NUMBER_INT)) !== 11) {
    array_push($errors, "O CPF precisa ter 11 dígitos numéricos!");
}

if (strlen(filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT)) !== 11) {
    array_push($errors, "O número de celular precisa ter 11 dígitos numéricos!");
}

if (strlen($password) < 8 || strlen($password) > 45) {
    array_push($errors, "A senha deve ter de 8 a 45 caracteres!");
}

if (has_only_spaces($_POST["cep"]) === true) {
    array_push($errors, "O campo CEP não pode conter somente caracteres em branco!");
}

if (has_only_spaces($_POST["complement"]) === true) {
    array_push($errors, "O campo complemento não pode conter somente caracteres em branco!");
}

$required_fields = [$name, $cpf, $email, $phone_number, $password, $street, $neighborhood, $city, $state];

foreach ($required_fields as $required_field) {
    if (empty($required_field) === true || has_only_spaces($required_field) === true) {
        array_push($errors, "Preencha todos os campos obrigatórios!");
        break;
    }
}

if (sizeof($errors) > 0) {
    $errors = json_encode($errors);
    header("location: views/user_register_page.php?register_errors={$errors}");
    exit;
}

stmt(
    prepare: "
        INSERT INTO FCM_USUARIOS(USU_CPF, USU_NOME, USU_NASCIMENTO, USU_EMAIL, USU_CELULAR, USU_ENDERECO, USU_SENHA)
        VALUES(?, ?, ?, ?, ?, ?, ?)
    ",
    execute_array: [$cpf, $name, $birthday, $email, $phone_number, $adress, sha1($password)]
);

header("location: views/login_page.php");

?>

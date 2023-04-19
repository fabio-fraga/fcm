<?php

session_start();

require("database/db.php");
require("functions/functions.php");

$name = $_POST["name"];
$birthday = $_POST["birthday"];
$phone_number = $_POST["phone_number"];
$password = $_POST["password"];

$street = $_POST["street"];
$house_number = $_POST["house_number"] ?: "S/N";
$neighborhood = $_POST["neighborhood"];
$city = $_POST["city"];
$state = $_POST["state"];
$cep = strpos($_POST["cep"], '-') ? $_POST["cep"] : substr_replace($_POST["cep"], '-', 5, 0);
$cep = !empty($_POST["cep"]) ? ". CEP: " . $cep . "." : '.';
$complement = !empty($_POST["complement"]) ? " Complemento: {$_POST["complement"]}." : '';
$adress = "{$street}, {$house_number}, {$neighborhood}, {$city} - {$state}{$cep}{$complement}";

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
)->data[0];

$errors = [];

if ($user->USU_SENHA !== sha1($password)) {
    array_push($errors, "Senha incorreta!");
}

if (strlen(filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT)) !== 11) {
    array_push($errors, "O número de celular precisa ter 11 dígitos numéricos!");
}

if (has_only_spaces($_POST["cep"]) === true) {
    array_push($errors, "O campo CEP não pode conter somente caracteres em branco!");
}

if (has_only_spaces($_POST["complement"]) === true) {
    array_push($errors, "O campo complemento não pode conter somente caracteres em branco!");
}

$required_fields = [$name, $phone_number, $password, $street, $neighborhood, $city, $state];

foreach ($required_fields as $required_field) {
    if (empty($required_field) === true || has_only_spaces($required_field) === true) {
        array_push($errors, "Preencha todos os campos obrigatórios!");
        break;
    }
}

if (sizeof($errors) > 0) {
    $errors = json_encode($errors);
    header("location: views/profile_page.php?register_errors={$errors}");
    exit;
}

stmt("
    UPDATE FCM_USUARIOS
    SET
    USU_NOME = ?,
    USU_NASCIMENTO = ?,
    USU_CELULAR = ?,
    USU_ENDERECO = ?
    WHERE USU_CODIGO = ?
    ",
    [$name, $birthday, $phone_number, $adress, $_SESSION["user_id"]]
);

header("location: views/profile_page.php"); 

?>

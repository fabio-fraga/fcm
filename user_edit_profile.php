<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
    exit;
}

require("database/db.php");
require("functions/functions.php");

$name = $_POST["name"];
$birthday = $_POST["birthday"];
$phone_number = $_POST["phone_number"];
$password = $_POST["password"];

$house_number = $_POST["house_number"] ?: null;
$complement = $_POST["complement"] ?: null;
$street = $_POST["street"];
$locality = $_POST["locality"];
$federative_unit = $_POST["federative_unit"];

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

if (has_only_spaces($_POST["complement"]) === true) {
    array_push($errors, "O campo complemento não pode conter somente caracteres em branco!");
}

$required_fields = [$name, $phone_number, $password, $street, $locality, $federative_unit];

foreach ($required_fields as $required_field) {
    if (empty($required_field) === true || has_only_spaces($required_field) === true) {
        array_push($errors, "Preencha todos os campos obrigatórios!");
    }
}

if (sizeof($errors) > 0) {
    $errors = json_encode($errors);
    header("location: views/profile_page.php?register_errors={$errors}");
    exit;
}

// ---------------------------------------------------------------------------------------------

$federative_unit_id = stmt(
    prepare: "SELECT * FROM FCM_UNIDADES_FEDERATIVAS WHERE UNF_NOME = ?",
    execute_array: [$federative_unit],
    fetch_object: true
)->data[0]->UNF_CODIGO;

$locality_id = $_SESSION["locality_id"];

stmt(
    prepare: "
        UPDATE FCM_LOCALIDADES
        SET
        LOC_NOME = ?,
        LOC_UNF_CODIGO = ?
        WHERE LOC_CODIGO = ?
    ",
    execute_array: [$locality, $federative_unit_id, $locality_id]
);

$street_id = $_SESSION["street_id"];

stmt(
    prepare:"
        UPDATE FCM_LOGRADOUROS
        SET
        LOG_NOME = ?,
        LOG_LOC_CODIGO = ?
        WHERE LOG_CODIGO = ?
    ",
    execute_array: [$street, $locality_id, $street_id]
);

stmt(
    prepare: "
        UPDATE FCM_USUARIOS
        SET
        USU_NOME = ?,
        USU_NASCIMENTO = ?,
        USU_TELEFONE = ?
        WHERE USU_CODIGO = ?
    ",
    execute_array: [$name, $birthday, $phone_number, $_SESSION["user_id"]]
);

$user_id = $_SESSION["user_id"];

stmt(
    prepare:"
        UPDATE FCM_LOGRADOUROS_DOS_USUARIOS
        SET
        LDU_NUMERO = ?,
        LDU_COMPLEMENTO = ?
        WHERE LDU_USU_CODIGO = ?
    ",
    execute_array: [$house_number, $complement, $user_id]
);

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$user_id],
    fetch_object: true
)->data[0];

$_SESSION["user_name"] = $user->USU_NOME;

header("location: views/profile_page.php"); 

?>

<?php

require("../database/db.php");

$search = $_GET["search"];

$data = stmt(
    prepare: "SELECT * FROM FCM_PRODUTOS WHERE PRO_NOME LIKE ?",
    execute_array: ["%$search%"],
    fetch_object: true
)->data;

$data = json_encode($data, JSON_PRETTY_PRINT);

header("Content-Type: application/json");

echo $data;

?>
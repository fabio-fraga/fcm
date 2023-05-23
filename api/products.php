<?php

require("../database/db.php");

$id = $_GET["id"];

$data = stmt(
    prepare: "SELECT * FROM FCM_PRODUTOS",
    fetch_object: true
)->data;

$data = json_encode($data, JSON_PRETTY_PRINT);

header("Content-Type: application/json");

echo $data;

?>
<?php

session_start();

require("database/db.php");

list(, $img) = explode(';', $_POST["img"]);

list(, $img) = explode(',', $img);

$img = base64_decode($img);

$img_name = time() . ".jpg";

if (!file_exists("images/users")) {
    mkdir("images/users");
}

$path = "images/users/" . $img_name;

file_put_contents($path, $img);

stmt(
    prepare: "
        UPDATE FCM_USUARIOS
        SET USU_FOTO = ?
        WHERE USU_CODIGO = ?
    ",
    execute_array: [$path, $_SESSION["user_id"]]
);

?>
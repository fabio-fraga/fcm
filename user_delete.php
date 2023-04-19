<?php

session_start();

require("database/db.php");

$user_id = $_GET["user_id"];

stmt(
    prepare: "DELETE FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$user_id]
);

session_destroy();

header("location: views/welcome_page.php");

?>

<?php 

require("database/db.php");

$user_id = $_GET["user_id"];

stmt(
    prepare: "DELETE FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$user_id]
);

header("location: views/welcome_page.php");

?>

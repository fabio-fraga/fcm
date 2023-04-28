<?php

session_start();

require("database/db.php");

$user_id = $_GET["user_id"];

stmt(
    prepare: "
        DELETE FCM_LOGRADOUROS_DOS_USUARIOS, FCM_USUARIOS, FCM_LOGRADOUROS, FCM_LOCALIDADES FROM FCM_LOGRADOUROS_DOS_USUARIOS
        JOIN FCM_USUARIOS ON USU_CODIGO = LDU_USU_CODIGO
        JOIN FCM_LOGRADOUROS ON LOG_CODIGO = LDU_LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        WHERE LDU_USU_CODIGO = ?;
    ",
    execute_array: [$user_id]
);

session_destroy();

header("location: views/welcome_page.php");

?>

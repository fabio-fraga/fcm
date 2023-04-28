<?php

session_start();

require("database/db.php");

$user_id = $_GET["user_id"];

stmt(
    prepare: "
        DELETE FCM_COMERCIOS, FCM_LOGRADOUROS, FCM_LOCALIDADES FROM FCM_COMERCIOS
        JOIN FCM_LOGRADOUROS ON LOG_CODIGO = CMR_LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        WHERE CMR_USU_CODIGO = ?;
    ",
    execute_array: [$user_id]
);

header("location: views/home_page.php");

?>

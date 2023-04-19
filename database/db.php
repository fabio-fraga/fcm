<?php

require("db_connection.php");

function stmt($prepare, $execute_array = null, $fetch_object = false) {
    global $dbh;
    
    $stmt = $dbh->prepare($prepare);

    if ($execute_array === null) {
        $execute = $stmt->execute();
    } else {
        $execute = $stmt->execute($execute_array);
    }
    
    return (object) [
        "execute" => $execute, 
        "row_count" => $stmt->rowCount(),
        "data" => $fetch_object === true ? $stmt->fetchAll(PDO::FETCH_CLASS) : false
    ];
}

?>
<?php

//Após inserir o usuário e senha, salve este arquivo como db_connection.php

//Insira o usuário do seu Banco de Dados
$user = "";
//Insira a senha de usuário do seu Banco de Dados
$pass = "";

$dbh = new PDO("mysql:host=localhost;dbname=FCM", $user, $pass);

?>

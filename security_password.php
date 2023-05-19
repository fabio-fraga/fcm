<?php 
session_start();

require ("database/db.php");

$senha_atual = $_POST["senha_atual"];
$nova_senha = $_POST['nova_senha'];
$confirme_senha = $_POST['confirme_senha'];

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
execute_array: [$_SESSION["user_id"]],
fetch_object: true,
)->data[0]->USU_SENHA;


if (sha1($senha_atual) == $user) {
    if ($nova_senha == $confirme_senha) {
        stmt(
            prepare: "
                UPDATE FCM_USUARIOS
                SET
                USU_SENHA = ?
                WHERE USU_CODIGO = ?
            ",
            execute_array: [sha1($nova_senha), $_SESSION["user_id"]]
        );
        header("location: views/security_page.php?feedback=sucesso&msg=Senha alterada com sucesso!");
        exit;
    } else {
        header("location: views/security_page.php?feedback=erro&msg=Senhas não são iguais!");
        exit;
    }
} else {
    header("location: views/security_page.php?feedback=erro&msg=Senha atual incorreta!");
    exit;
}
?> 
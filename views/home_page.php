<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
</head>
<body>
    <h1>Bem-vindo, <?= $_SESSION["user_name"] ?>!</h1>
    
    <div>
        <button>
             <a style="text-decoration: none;" href="profile_page.php?user_id=<?= $_SESSION["user_id"] ?>">Perfil</a>
        </button>
    </div>

    <div>
        <button>
            <a style="text-decoration: none;"
                href="../user_delete.php?user_id=<?= $_SESSION["user_id"] ?>"
                onclick="return confirm('Essa ação não poderá ser desfeita! Clique em OK para prosseguir.')"
            >
                    Apagar Conta 
            </a>
        </button>
    </div>
        
    <div>
        <button>
            <a style="text-decoration: none;" href="../logout.php">Sair</a>
        </button>
    </div>
</body>
</html>


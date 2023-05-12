<?php

session_start();

if (isset($_SESSION["user_id"])) {
    header("location: home_page.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/login-register.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/welcome.css">
    <title>free-Commerce - Login</title>
</head>
<body>
 
    <div class="container">

        <div class="main" >           
            <div class="logo-container"> 
                <a href="../index.php">
                    <img class="logo" src="../images/logo.png" alt="logo">
                </a>
            </div>
            
            <div class="div-form">
    
                <form class="form-login" action="../login.php" method="POST">
    
                    <h1 class="name-login">Faça o seu login</h1>
    
                    <?php if(isset($_GET['err'])): ?>
                        <div>
                            <?= $_GET['err'] ?>
                        </div>
                    <?php endif ?>
                    
                    <div>
                        <input class="input-login" type="text" name="email" id="email" placeholder="E-mail" required>
                    </div>
    
                    <div>
                        <input class="input-login" type="password" name="password" id="senha" minlength="8" maxlength="45" placeholder="Senha" required>
                    </div>
    
                    <div class="div-forgot-password">
                        <p class="forgot-password">
                            <a href="">Esqueceu sua senha?</a>
                        </p>
                    </div>
    
                    <div>
                        <div class="button">
                            <button class="btn-login">Entrar</button>
                        </div>
                    <div>
    
                    <div class="register">
                        <p class="p-register">
                            É novo no free-Commerce? 
                            <a href="user_register_page.php">Crie sua conta!</a>
                        </p>
                    </div>
                       
                </form>
    
            </div>
        </div>

    </div>

</body>
</html>
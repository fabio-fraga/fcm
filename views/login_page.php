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
    <link rel="stylesheet" href="4index.css">
    <link rel="shortcut icon" href="../1tela/logo.png" type="image/x-icon">
    <title>free-Commerce - Login</title>
    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
}

body{
    background-color: rgb(196, 241, 128);
}

.nometopocadastro{
    position: absolute;
    left: 42%;
    margin-top: 10px;
    margin-bottom: 59px;
    font-family: fantasy;
    color: rgba(92, 88, 88, 0.774);

}

.nomeformulario{
    font-family: fantasy;
    color: orangered;
    padding-top: 20px;
}

.imgcadastro{
    width: 30px;
    padding-top: 15px;
    padding-bottom: 15px;
}

.larguracadastro{
    position: absolute;
    top: 50px;
    left: 38%;
    
}

.larguraespaçocadastro{
   background: #ffffff85;
    width: 340px;
    height: 600px;
    text-align: center;
    border-radius: 20px;
    position: absolute;
}

.nomecadastro{
    width: 90%;
    padding-bottom: 2px;
    margin-top: 15px;
    margin-bottom: 3px;
    bottom: 14%;
    cursor: pointer;
    border-radius: 10px;
   
}


.button {
    position: absolute;
    height: 50px;
    padding-top: 4%;
    left: 50%;
    display: flex;
    justify-content: center;
    

}

.tamanhobutton{
    position: absolute;
    width: 180px;
    height: 90%;
    border-radius: 20px;
    cursor: pointer;
    background-color: green;
    color: white;
    font-family: fantasy;  
    
}

.label{
   font-family: fantasy;
   color: rgba(92, 88, 88, 0.774);
}
    </style>
</head>
<body>

<p class="nometopocadastro"> Entre e veja as novidades </p>

    <div class=larguracadastro>

    <div class="larguraespaçocadastro">

        <h1 class="nomeformulario">Login</h1>
    <nav>
        <a href=""><img class="imgcadastro"src="google.png" alt=""> </a>
       <a href=""> <img class="imgcadastro"src="" alt="">   </a>
        <a href=""><img class="imgcadastro" src="" alt=""> </a>
    </nav>
        <form action="../login.php" method="POST">
            <?php if(isset($_GET['err'])): ?>
                <div>
                    <?= $_GET['err'] ?>
                </div>
            <?php endif ?>
            
            <div>
                <label class="label"for="email"> Seu E-email </label>
            <input class="nomecadastro" type="text" name="email" id="email" required>
            </div>

            <div>
                <label class="label"for="senha"> Sua senha </label>
            <input class="nomecadastro" type="password" name="password" id="senha" minlength="8" maxlength="45" required>
            </div>
            <div>
            <div class="button">
            <button class="tamanhobutton"> Entrar </button>
            </div>
        <div>
</div>
</html>
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
    <link rel="stylesheet" href="1index.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<!-- link da fonte montserrat do google fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>free-Commerce</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }

        @media screen and (max-width: 768px) {
            .larguraheader{
                width: 100%;
            }

        }
        body {
            background-color: rgb(196, 241, 128);
        }

        .logohead {
            position: absolute;
            width: 55%;
            height: 55%;
            margin-left: 10%;
        }

        .imgheader{
            position: absolute;
            width: 150px;
            height: 90px;
            margin-left: 10%;
            top: 2%; 
        }

        .larguraheader {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding-top: 60px;
        }

        .larguranomeheader {
            position: absolute;
            display: flex;
            gap: 130px;
            right: 7%;
        }

        .nomeheader {
            display: flex;
            font-family: 'Montserrat', sans-serif;
            color: rgb(255, 80, 16);
            font-size: 20px;
        }

        .nomemain {
            display: flex;
            font-family: 'Montserrat', sans-serif;
            position: absolute;
            margin-left: 8%;
            padding: 20px;
            bottom: 100px;
            font-size: 40px;
        }

        .orange {
            color: orangered;
        }

        .black {
            color: black;
        }

        .green {
            color: green
        }

        .bordaultimonome {
            position: absolute;
            border: 1px solid rgb(245, 125, 13);
            border-radius: 20px;
            margin-top:35%;
            margin-left: 9%;
            width: 400px;
            background-color: orangered
        }

        .ultimonomemain {
            border-radius: 20px;
            font-family: 'Montserrat', sans-serif;
            justify-content: center;
            display: flex;
            font-size:large;
            color: white;
        }

        .imgmain1 {
            position: absolute;
            height: 75%;
            margin-left: 57%;
            margin-top: 3%;
        }

        .imgmain2{
        position: absolute;
        height: 65%;
        margin-left: 54%;
        margin-top: 7%;
        }
    </style>
</head>
<body>
    <header>
        
        <div class="logoheader">
        <img class="imgheader" src="/images/logo.png" alt="">
        </div>

        
        <div class="larguraheader">

    <nav class="larguranomeheader">
        <a class="nomeheader" href="">Quem somos?</a>
        <a class="nomeheader" href="">Serviços</a>
        <a class="nomeheader" href="login_page.php">Login </a>
        <a class="nomeheader" href="user_register_page.php">Cadastre-se</a>
    </nav>
    </div>
</div>
    </header>
    <main>

    <div class="larguramain" >
        
        <div class="nomemain">
        <h1> <span class="orange"> Inovando </span> <br clas="alturaimg">
           <span class="black"> sua forma de </span> <br>
          <span class="green"> comprar </span> <span class="black"> e </span> <br>
           <span class="green"> vender. </span> 
        </h1>
        </div>
            
        <div class="imgmain">
        <img class="imgmain1" src="/images/camada.png" alt="">
        <img class="imgmain2" src="/images/senhora.png" alt="">
        </div>

        <nav class="bordaultimonome">
        <a class="ultimonomemain" href="/views/user_register_page.php"> <h2> Cadastre-se </h2> </a>
        </nav>
</div>
    </main>
</body>
</html>
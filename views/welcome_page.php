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
<link rel="stylesheet" href="../css/welcome.css">
    <title>free-Commerce</title>

</head>
<body>
    <header>
        <div class="logoheader">
            <img class="imgheader" src="/images/logo.png" alt="">
        </div>
        
        <div class="larguraheader">
            <nav class="larguranomeheader">
                <a class="nomeheader" href="aboutwe_page.php">Quem somos?</a>
                <a class="nomeheader" href="">Serviços</a>
                <a class="nomeheader" href="login_page.php">Login </a>
                <a class="nomeheader" href="user_register_page.php">Cadastre-se</a>
            </nav>
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

        

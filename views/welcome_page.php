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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<!-- link da fonte montserrat do google fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/welcome.css">
    <title>free-Commerce</title>

</head>
<body>
    <div class="larguratop">
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
    </div>

        <div class="larguramain" >        
            <div class="nomemain">
                <h1> <span class="orange"> Inovando </span> <br>
                    <span class="black"> sua forma</span>  <br>
                    <span class="green">de comprar</span> <br> 
                    <span class="black"> <span class="left"> e </span> <span class="green"> vender. </span> </span> <br>
                </h1>
                <button class="bordaultimonome">
                    <a class="ultimonomemain" href="home_page.php"> <h2> Veja os produtos </h2> </a>
                </button>
            </div>
            
            <div class="imgmain">
                <img class="imgmain1" src="/images/camada.png" alt="">
                <img class="imgmain2" src="/images/senhora.png" alt="">
            </div>

        </div>

        <div class="lugardovideo">

            <div class="nomeinfo">
                <h1> <span class="orange">informações </span> <span class="black">para sua</span> <span class="green">utilidade</span></h1>
            </div>

            <div class="nomevideo1">
                <p> Saiba como ultlizar a plataforma através do nosso tutorial em video,
                    Em menos de 4minutos você ira ficar por dentro de tudo, de uma forma 
                    rapida, simples, e legal, <br>
                    <strong> <span class="black-left"> Assista e fique por dentro de tudo!!! </span> </strong>
                </p>
            </div>

            <div class="ajustevideo">
                <video class="tamanhovideo" src="" controls></video> 
            </div> 
        </div>
</body>
</html>

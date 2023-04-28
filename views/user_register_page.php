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
    <link rel="stylesheet" href="5index.css">
    <link rel="shortcut icon" href="../1tela/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/login-register.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title> Seu Cadastro</title>

</head>
<body>

    <div class="container">

        <div class="main"> 
            <div class="logo-container"> 
                <div class="logo-position-2">
                    <a href="../index.php">
                        <img class="logo" src="../images/logo.png" alt="logo">
                    </a>
                </div> 
            </div>
            
            <div class="div-form">
                
    
                <form action="../register.php" method="POST">
    
                    <h1 class="name-login">Faça o seu cadastro</h1>
    
                    <?php foreach (json_decode($_GET["register_errors"]) as $err): ?>
                        <div><?= $err ?></div>
                    <?php endforeach ?>
                    
                    <div>
                        <input class="input-login" type="text" name="name" id="nome" placeholder="Nome completo" required>
                    </div>
    
                    <div>
                        <input class="input-login" type="text" name="birthday" id="nascimento" placeholder="Nascimento" onfocus="(this.type='date')" required>
                    </div>
    
                    <div>
                        <input class="input-login" type="text" name="cpf" id="cpf" minlength="11" maxlength="11" placeholder="CPF" required>
                    </div>
    
                    <div>
                        <input class="input-login" type="text" name="email" id="email" placeholder="E-mail" required>
                    </div>
    
                    <div>
                        <input class="input-login" type="text" name="phone_number" id="telefone" minlength="11" maxlength="11" placeholder="Celular" required>
                    </div>
                    
                    <div>
                        <input class="input-login" type="password" name="password" minlength="8" maxlength="45" placeholder="Senha" required>    
                    </div>
                    
            </div>
                    <div class="adress">
                        <legend class="adress-title"><strong>Endereço</strong></legend>
                        
                        <input class="input-adress" id="cep" type="text" name="cep" placeholder="CEP">
                        <input class="input-adress" id="street" type="text" name="street" placeholder="Rua" required>
                        <input class="input-adress" id="houseNumber" type="number" name="house_number" placeholder="N°">
                        <input class="input-adress" id="complement" type="text" name="complement" placeholder="Complemento">
                        <input class="input-adress" id="locality" type="text" name="locality" placeholder="Localidade" required>
    
                        <div class="state">
                            <select class="select-state" id="federal_unit" name="federal_unit" required>
                                <option value="UF" selected disabled>UF</option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AP">AP</option>
                                <option value="AM">AM</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MT">MT</option>
                                <option value="MS">MS</option>
                                <option value="MG">MG</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PR">PR</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                                <option value="DF">DF</option>
                            </select>
                        </div>
                        
                    </div>
    
                    <div>
                        <div class="button">
                            <button class="btn-login">Finalizar</button>
                        </div>
                    <div>
    
                    <div class="register">
                        <p class="p-register">
                            Já tem uma conta no free-Commerce?
                            <a href="login_page.php">Faça login!</a>
                        </p>
                    </div>
                    
                </form>
    
        </div>

    </div>

    <script>
    let inputCep = document.querySelector("#cep")

    inputCep.addEventListener("input", function() {
        if (this.value.length === 8) {
            getAdress(this.value)
        } else {
            document.querySelector("#street").value = ''
            document.querySelector("#complement").value = ''
            document.querySelector("#locality").value = ''
            document.querySelector("#federal_unit").value = "UF"
        }
    })

    async function getAdress(cep) {
        
        let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`).then((res) => res.json())
        
        if (typeof response["erro"] !== undefined && response["erro"] !== true) {
            document.querySelector("#street").disabled = true
            document.querySelector("#street").value = response["logradouro"]
            document.querySelector("#complement").value = response["complemento"]
            document.querySelector("#locality").disabled = true
            document.querySelector("#locality").value = response["localidade"]
            document.querySelector("#federal_unit").disabled = true
            document.querySelector("#federal_unit").value = response["uf"]   
        }
    }
    </script>
</body>
</html>



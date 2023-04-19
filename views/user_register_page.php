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
    <title> Seu Cadastro</title>
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

<p class="nometopocadastro"> Preencha as informações abaixo: </p>

    <div class=larguracadastro>

        <div class="larguraespaçocadastro">
            
        <h1 class="nomeformulario"> Ficha de cadastro </h1>
    <nav>
        <a href=""><img class="imgcadastro"src="google.png" alt=""> </a>
        <a href=""> <img class="imgcadastro"src="" alt="">   </a>
        <a href=""><img class="imgcadastro" src="" alt=""> </a>
    </nav>
    
    <?php foreach (json_decode($_GET["register_errors"]) as $err): ?>
        <div><?= $err ?></div>
    <?php endforeach ?>
    
    <form action="../register.php" method="POST">

            <div>
                <label class="label" for="nome"> Nome completo</label>
                <input class="nomecadastro" type="text" name="name" id="nome" required>
            </div>

            <div>
                <label class="label" for="nascimento">Nascimento</label>
                <input class="nomecadastro" type="date" name="birthday" id="nascimento" required>
            </div>

            <div>
                <label class="label" for="cpf"> Seu CPF</label>
                <input class="nomecadastro" type="text" name="cpf" id="cpf" minlength="11" maxlength="11" required>
            </div>

            <div>
                <label class="label"for="email"> Seu E-email </label>
            <input class="nomecadastro" type="text" name="email" id="email" required>
            </div>

            <div>
                <label class="label"for="telefone"> Seu telefone </label>
                <input class="nomecadastro" type="text" name="phone_number" id="telefone" minlength="11" maxlength="11" required>
            </div>
            
            <div>
                <label class="label" for="">Senha</label>
                <input class="nomecadastro" type="password" name="password" minlength="8" maxlength="45" required>
            </div>
            
            <div>
                <legend class="">Endereço</legend>
                
                <input id="cep" type="text" name="cep" placeholder="CEP">
                <input id="street" class="nomecadastro" type="text" name="street" placeholder="Rua" required>
                <input id="houseNumber" class="nomecadastro" type="number" name="house_number" placeholder="N°">
                <input id="complement" class="nomecadastro" type="text" name="complement" placeholder="Complemento">
                <input id="neighborhood" class="nomecadastro" type="text" name="neighborhood" placeholder="Bairro" required>
                <input id="city" class="nomecadastro" type="text" name="city" placeholder="Cidade" required>

                <select id="state" name="state" required>
                    <option value="Estado" selected disabled>Estado</option>
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
            
            <!-- <div>
                <label class="label"for="1"> Com oque você trabalha </label>
            <select class="nomecadastro"  name="trabalha" id="1" required>
                <option value=""> ----Escolha----</option>
                <option value="cl"> Sou Cliente </option>
                <option value="vt"> Vestuários </option>
                <option value="cç"> Calçados</option>
                <option value="cm"> Cosmeticos </option>
                <option value="cd">  Alimentos </option>
                <option value="ft"> Frutas </option>
                <option value="lg"> Legumes </option>
                <option value="bj"> Bijuterias </option>
                <option value="tc"> Tecnologias </option>
                <option value="pp"> Papelarias </option>
            </select>
            </div>

            <div>
                <label class="label" for="2"> Em qual cidade você mora </label>
            <select class="nomecadastro" type="text" name="mora" id="2" required>
                <option value="">---Escolha---</option>
                <option value="al"> Abreu e Lima</option>
                <option value="ig"> Igarassu </option>
                <option value="cr"> Cruz de rebouças</option>
                <option value="pt"> Paulista</option>
                <option value="rf"> Recife </option>
                <option value="gn"> Goiana</option>
            </select>
            </div>

            <div>
                <label class="label"for="3"> Qual cidade você trabalha</label>
                <select class="nomecadastro" type="text" name="cidade" id="3" required>
            <option value="">---Escolha---</option>
                <option value="al"> Abreu e Lima</option>
                <option value="ig"> Igarassu </option>
                <option value="cr"> Cruz de rebouças</option>
                <option value="pt"> Paulista</option>
                <option value="rf"> Recife </option>
                <option value="gn"> Goiana</option>
            </select>
        </div> -->


        <div>
            <div class="button">
                <button class="tamanhobutton"> Finalizar </button>
            </div>
        <div>

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
                document.querySelector("#neighborhood").value = ''
                document.querySelector("#city").value = ''
                document.querySelector("#state").value = "Estado"
            }
        })

        async function getAdress(cep) {
            
            let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`).then((res) => res.json())
            
            if (typeof response["erro"] !== undefined && response["erro"] !== true) {
                document.querySelector("#street").value = response["logradouro"]
                document.querySelector("#complement").value = response["complemento"]
                document.querySelector("#neighborhood").value = response["bairro"]
                document.querySelector("#city").value = response["localidade"]
                document.querySelector("#state").value = response["uf"]   
            }
        }
    </script>
</body>
</html>



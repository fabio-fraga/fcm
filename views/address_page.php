<?php

session_start();

require("../database/db.php");

$addresses = stmt(
    prepare: "
        SELECT * FROM FCM_LOGRADOUROS_DOS_USUARIOS
        JOIN FCM_LOGRADOUROS ON LOG_CODIGO = LDU_LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        JOIN FCM_UNIDADES_FEDERATIVAS ON UNF_CODIGO = LOC_UNF_CODIGO
        JOIN FCM_PAISES ON PAIS_CODIGO = UNF_PAIS_CODIGO
        WHERE LDU_USU_CODIGO = ?
    ",
    execute_array: [$_SESSION['user_id']],
    fetch_object: true
)->data;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações públicas</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/address.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/menu.css">
</head>
<body>
    <?php include("header_page.php") ?>

    <div class="public-info-container">
        <div class="menu">
            <?php include("menu.php") ?>
        </div>
        <div class="content">
            <h3 class="main-title">Informações públicas</h3>

            <form action="../address.php" method="POST" class="form-public-info">
                <label class="title">CEP:</label>
                <input id="cep" class="field" name="cep" type="number">

                <label class="title">Rua:</label>
                <input id="street" class="field" name="street" type="text">
                
                <label class="title">Número:</label>
                <input id="houseNumber" class="field" name="number" type="text">

                <label class="title">Complemento:</label>
                <input id="complement" class="field" name="complement" type="text">

                <label class="title">Localidade:</label>
                <input id="locality" class="field" name="locality" type="text">

                <label class="title">UF:</label>
                <select class="field" id="federative_unit" name="federative_unit" required>
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

                <button class="btn">Salvar</button>
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
            document.querySelector("#federative_unit").value = "UF"
        }
    })

    async function getAdress(cep) {
        
        let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`).then((res) => res.json())
        
        if (typeof response["erro"] !== undefined && response["erro"] !== true) {
            document.querySelector("#street").value = response["logradouro"]
            document.querySelector("#complement").value = response["complemento"]
            document.querySelector("#locality").value = response["localidade"]
            document.querySelector("#federative_unit").value = response["uf"]   
        }
    }
    </script>    
</body>
</html>
<?php

session_start();

require("../database/db.php");

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
}

$seller = stmt(
    prepare: "
        SELECT * FROM FCM_COMERCIOS
        JOIN FCM_LOGRADOUROS ON LOG_CODIGO = CMR_LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        JOIN FCM_UNIDADES_FEDERATIVAS ON UNF_CODIGO = LOC_UNF_CODIGO
        JOIN FCM_PAISES ON PAIS_CODIGO = UNF_PAIS_CODIGO
        WHERE CMR_USU_CODIGO = ?
    ",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
);

$_SESSION["federative_unit_id"] = $seller->data[0]->UNF_CODIGO;
$_SESSION["locality_id"] = $seller->data[0]->LOC_CODIGO;
$_SESSION["street_id"] = $seller->data[0]->LOG_CODIGO;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/seller.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Vendedor</title>
</head>
<body>

    <?php include "header_page.php" ?>
    
<div class="container_top">
    <div class="container_form1">
        <h3 class="name_form1">Olá, <?= $_SESSION["user_name"] ?>!</h3>
        <p class="name_p1"> Crie sua lojinha e comece a vender no Free-commerce</p>
    
        <?php if ($seller->row_count === 0): ?>
            <p class="name_p3">Complete o cadastro para que possa começar <br> <span class="name_p3_left"> a vender seus produtos! É rapidinho </span> </p>
        <?php else: ?>
            <p class="name_p2">Seus dados:</p>
        <?php endif ?>
    
        <?php if ($seller->row_count === 0): ?>
            <form action="../seller_register.php" method="POST">
        <?php else: ?>
            <form action="../seller_update.php" method="POST">
        <?php endif ?>
    
        <?php if (isset($_GET['err'])): ?>
            <div>
                <?= $_GET['err'] ?>
            </div>
        <?php endif ?>
        
        <div class="nickname">
            <label for="">Nome da loja:</label>
            <input type="text" name="seller" value="<?= $seller->data[0]->CMR_NOME ?: '' ?>" placeholder="Negócio ou apelido">
        </div>

        <div class="adress">
            <div class="padding_adress">
                <label class="adress-title">Endereço:</label> 
                <input class="input-adress" id="cep" type="text" name="cep" placeholder="CEP">
            </div>

            <div class="padding_adress">
                <input class="input-adress" id="street" type="text" name="street" placeholder="Rua" value="<?= $seller->data[0]->LOG_NOME ?: '' ?>" required>
            </div>

            <div class="padding_adress">
                <input class="input-adress" id="locality" type="text" name="locality" placeholder="Localidade" value="<?= $seller->data[0]->LOC_NOME ?: '' ?>" required>
            </div>
        </div>

            <div class="state">
                <select class="select-state" id="federative_unit" name="federative_unit" required>
                    <option value="UF" <?=($seller->data[0]->UNF_NOME === 'Selecione')?'selected':''?> selected disabled>UF</option>
                    <option value="AC" <?=($seller->data[0]->UNF_NOME === 'AC')?'selected':''?>>AC</option>
                    <option value="AL" <?=($seller->data[0]->UNF_NOME === 'AL')?'selected':''?>>AL</option>
                    <option value="AP" <?=($seller->data[0]->UNF_NOME === 'AP')?'selected':''?>>AP</option>
                    <option value="AM" <?=($seller->data[0]->UNF_NOME === 'AM')?'selected':''?>>AM</option>
                    <option value="BA" <?=($seller->data[0]->UNF_NOME === 'BA')?'selected':''?>>BA</option>
                    <option value="CE" <?=($seller->data[0]->UNF_NOME === 'CE')?'selected':''?>>CE</option>
                    <option value="ES" <?=($seller->data[0]->UNF_NOME === 'ES')?'selected':''?>>ES</option>
                    <option value="GO" <?=($seller->data[0]->UNF_NOME === 'GO')?'selected':''?>>GO</option>
                    <option value="MA" <?=($seller->data[0]->UNF_NOME === 'MA')?'selected':''?>>MA</option>
                    <option value="MT" <?=($seller->data[0]->UNF_NOME === 'MT')?'selected':''?>>MT</option>
                    <option value="MS" <?=($seller->data[0]->UNF_NOME === 'MS')?'selected':''?>>MS</option>
                    <option value="MG" <?=($seller->data[0]->UNF_NOME === 'MG')?'selected':''?>>MG</option>
                    <option value="PA" <?=($seller->data[0]->UNF_NOME === 'PA')?'selected':''?>>PA</option>
                    <option value="PB" <?=($seller->data[0]->UNF_NOME === 'PB')?'selected':''?>>PB</option>
                    <option value="PR" <?=($seller->data[0]->UNF_NOME === 'PR')?'selected':''?>>PR</option>
                    <option value="PE" <?=($seller->data[0]->UNF_NOME === 'PE')?'selected':''?>>PE</option>
                    <option value="PI" <?=($seller->data[0]->UNF_NOME === 'PI')?'selected':''?>>PI</option>
                    <option value="RJ" <?=($seller->data[0]->UNF_NOME === 'RJ')?'selected':''?>>RJ</option>
                    <option value="RN" <?=($seller->data[0]->UNF_NOME === 'RN')?'selected':''?>>RN</option>
                    <option value="RS" <?=($seller->data[0]->UNF_NOME === 'RS')?'selected':''?>>RS</option>
                    <option value="RO" <?=($seller->data[0]->UNF_NOME === 'RO')?'selected':''?>>RO</option>
                    <option value="RR" <?=($seller->data[0]->UNF_NOME === 'RR')?'selected':''?>>RR</option>
                    <option value="SC" <?=($seller->data[0]->UNF_NOME === 'SC')?'selected':''?>>SC</option>
                    <option value="SP" <?=($seller->data[0]->UNF_NOME === 'SP')?'selected':''?>>SP</option>
                    <option value="SE" <?=($seller->data[0]->UNF_NOME === 'SE')?'selected':''?>>SE</option>
                    <option value="TO" <?=($seller->data[0]->UNF_NOME === 'TO')?'selected':''?>>TO</option>
                    <option value="DF" <?=($seller->data[0]->UNF_NOME === 'DF')?'selected':''?>>DF</option>
                </select>
            </div>                   

        <?php if ($seller->row_count === 0): ?>
            <button class="alt"> Finalizar cadastro</button>
        <?php else: ?>
            <button class="alt">Alterar</button>
        <?php endif ?>
            </form>
    </div> 

    <div class="container_form2">
        <div class="name_product1">
            <p> Você terá acesso à sua área de produtos <br>
             onde podera visalizar e editar informações. <br>
            <span class="mao"> Clique aqui 👇🏻 </span> <br> </p>
        <a href="products_page.php"> <img src="../images/img_seller/product.gif" alt=""></a> 
        </div>
        
        <div class="name_product2">
                <p> Para apaguar sua conta de vendedor <br>
                  <span class="mao"> Clique aqui👇🏻 </span> </p>
            <?php if ($seller->row_count > 0): ?>
                        <a
                        href="../seller_delete.php?user_id=<?= $_SESSION["user_id"] ?>" 
                        onclick="return confirm('Essa ação não poderá ser desfeita! Clique em OK para prosseguir.')">
                        <img src="../images/img_seller/lixo.gif" alt="lixo"> </a>
            </div>
        </div> 
    </div>    
</div>      
    <?php endif ?>

    <script>
    let inputCep = document.querySelector("#cep")

    inputCep.addEventListener("input", function() {
        if (this.value.length === 8) {
            getAdress(this.value)
        } else {
            document.querySelector("#street").value = ''
            document.querySelector("#locality").value = ''
            document.querySelector("#federative_unit").value = "UF"
        }
    })

    async function getAdress(cep) {
        
        let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`).then((res) => res.json())
        
        if (typeof response["erro"] !== undefined && response["erro"] !== true) {
            document.querySelector("#street").value = response["logradouro"]
            document.querySelector("#locality").value = response["localidade"]
            document.querySelector("#federative_unit").value = response["uf"]   
        }
    }
    </script>
</body>
</body>
</html>
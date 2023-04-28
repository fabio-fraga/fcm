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
    <title>Vendedor</title>
</head>
<body>
    <h1>Olá, <?= $_SESSION["user_name"] ?>!</h1>

    <?php if ($seller->row_count === 0): ?>
        <p>Complete o cadastro para que possa começar a vender seus produtos! É rapidinho ;)</p>
    <?php else: ?>
        <p>Seus dados:</p>
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
        
        <div>
            <label for="">Negócio ou apelido:</label>
            <input type="text" name="seller" value="<?= $seller->data[0]->CMR_NOME ?: '' ?>" placeholder="Negócio ou apelido">
        </div>

        <div class="adress">
            <legend class="adress-title">Endereço</legend>
                        
            <input class="input-adress" id="cep" type="text" name="cep" placeholder="CEP">
            <input class="input-adress" id="street" type="text" name="street" placeholder="Rua" value="<?= $seller->data[0]->LOG_NOME ?: '' ?>" required>
            <input class="input-adress" id="locality" type="text" name="locality" placeholder="Localidade" value="<?= $seller->data[0]->LOC_NOME ?: '' ?>" required>
    
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
        </div>

        <?php if ($seller->row_count === 0): ?>
            <button>Finalizar cadastro</button>
        <?php else: ?>
            <button>Alterar</button>
        <?php endif ?>
    </form>

    <button>    
        <a style="text-decoration: none;" href="home_page.php">Voltar</a>
    </button>
    
    <?php if ($seller->row_count > 0): ?>
        <div>
            <button>
                <a style="text-decoration: none;"
                    href="../seller_delete.php?user_id=<?= $_SESSION["user_id"] ?>"
                    onclick="return confirm('Essa ação não poderá ser desfeita! Clique em OK para prosseguir.')"
                >
                        Apagar conta de vendedor
                </a>
            </button>
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
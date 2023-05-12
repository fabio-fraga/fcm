<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
    exit;
}

require("../database/db.php");

$user = stmt(
    prepare: "
        SELECT * FROM FCM_USUARIOS
        JOIN FCM_LOGRADOUROS_DOS_USUARIOS ON LDU_USU_CODIGO = ?
        JOIN FCM_LOGRADOUROS ON LOG_CODIGO = LDU_LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        JOIN FCM_UNIDADES_FEDERATIVAS ON UNF_CODIGO = LOC_UNF_CODIGO
        JOIN FCM_PAISES ON PAIS_CODIGO = UNF_PAIS_CODIGO;
    ",
    execute_array: [$_SESSION['user_id']],
    fetch_object: true
)->data[0];

$_SESSION["federative_unit_id"] = $user->UNF_CODIGO;
$_SESSION["locality_id"] = $user->LOC_CODIGO;
$_SESSION["street_id"] = $user->LOG_CODIGO;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/profile.css">
    <title>Perfil</title>
</head>
<body>
<div>
    <h2>Editar dados:</h2>

    <?php foreach (json_decode($_GET["register_errors"]) as $err): ?>
        <div><?= $err ?></div>
    <?php endforeach ?>

    <form action="../user_edit_profile.php" method="POST">

        <?php if(isset($_GET['err'])): ?>
            <div>
                <?= $_GET['err'] ?>
            </div>
        <?php endif ?>
                
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="name" id="nome" value="<?= $user->USU_NOME ?>" required>
        </div>

        <div>
            <label class="label" for="nascimento">Nascimento</label>
            <input class="nomecadastro" type="date" name="birthday" value="<?= $user->USU_NASCIMENTO ?>" required>
        </div>
                
        <div>
            <label class="label" for="telefone">Telefone:</label>
            <input type="text" name="phone_number" id="telefone" minlength="11" maxlength="11" value="<?= $user->USU_TELEFONE ?>" required>
        </div>

        
        <div>
            <label for="">CEP:</label>
            <input id="cep" type="text" name="cep" value="">
        </div>
                
        <div>
            <label for="">Logradouro:</label>
            <input id="street" type="text" name="street" value="<?= $user->LOG_NOME ?>" required>
        </div>
                
        <div>
            <label for="">Complemento:</label>
            <input id="complement" type="text" name="complement" value="<?= $user->LDU_COMPLEMENTO ?>" required>
        </div>
                
        <div>
            <label for="">Número da residência:</label>
            <input id="houseNumber" type="text" name="house_number" value="<?= $user->LDU_NUMERO ?>" required>
        </div>
                
        <div>
            <label for="">Cidade:</label>
            <input id="locality" type="text" name="locality" value="<?= $user->LOC_NOME ?>" required>
        </div>
                
        <select id="federative_unit" name="federative_unit" required>
            <option value="UF" <?=($user->UNF_NOME === 'Selecione')?'selected':''?> disabled>UF</option>
            <option value="AC" <?=($user->UNF_NOME === 'AC')?'selected':''?>>AC</option>
            <option value="AL" <?=($user->UNF_NOME === 'AL')?'selected':''?>>AL</option>
            <option value="AP" <?=($user->UNF_NOME === 'AP')?'selected':''?>>AP</option>
            <option value="AM" <?=($user->UNF_NOME === 'AM')?'selected':''?>>AM</option>
            <option value="BA" <?=($user->UNF_NOME === 'BA')?'selected':''?>>BA</option>
            <option value="CE" <?=($user->UNF_NOME === 'CE')?'selected':''?>>CE</option>
            <option value="ES" <?=($user->UNF_NOME === 'ES')?'selected':''?>>ES</option>
            <option value="GO" <?=($user->UNF_NOME === 'GO')?'selected':''?>>GO</option>
            <option value="MA" <?=($user->UNF_NOME === 'MA')?'selected':''?>>MA</option>
            <option value="MT" <?=($user->UNF_NOME === 'MT')?'selected':''?>>MT</option>
            <option value="MS" <?=($user->UNF_NOME === 'MS')?'selected':''?>>MS</option>
            <option value="MG" <?=($user->UNF_NOME === 'MG')?'selected':''?>>MG</option>
            <option value="PA" <?=($user->UNF_NOME === 'PA')?'selected':''?>>PA</option>
            <option value="PB" <?=($user->UNF_NOME === 'PB')?'selected':''?>>PB</option>
            <option value="PR" <?=($user->UNF_NOME === 'PR')?'selected':''?>>PR</option>
            <option value="PE" <?=($user->UNF_NOME === 'PE')?'selected':''?>>PE</option>
            <option value="PI" <?=($user->UNF_NOME === 'PI')?'selected':''?>>PI</option>
            <option value="RJ" <?=($user->UNF_NOME === 'RJ')?'selected':''?>>RJ</option>
            <option value="RN" <?=($user->UNF_NOME === 'RN')?'selected':''?>>RN</option>
            <option value="RS" <?=($user->UNF_NOME === 'RS')?'selected':''?>>RS</option>
            <option value="RO" <?=($user->UNF_NOME === 'RO')?'selected':''?>>RO</option>
            <option value="RR" <?=($user->UNF_NOME === 'RR')?'selected':''?>>RR</option>
            <option value="SC" <?=($user->UNF_NOME === 'SC')?'selected':''?>>SC</option>
            <option value="SP" <?=($user->UNF_NOME === 'SP')?'selected':''?>>SP</option>
            <option value="SE" <?=($user->UNF_NOME === 'SE')?'selected':''?>>SE</option>
            <option value="TO" <?=($user->UNF_NOME === 'TO')?'selected':''?>>TO</option>
            <option value="DF" <?=($user->UNF_NOME === 'DF')?'selected':''?>>DF</option>
        </select>
                        
        <div>
            <label for="">Digite sua senha para continuar: </label>
            <input type="password" name="password" required>
        </div>

        <button>Alterar</button>
        
        <button>
            <a style="text-decoration: none;"
                    href="../user_delete.php?user_id=<?= $_SESSION["user_id"] ?>"
                    onclick="return confirm('Essa ação não poderá ser desfeita! Clique em OK para prosseguir.')"
                >
                        Apagar Conta 
            </a>
        </button>
    </form>

    <button>    
        <a style="text-decoration: none;" href="home_page.php">Voltar</a>
    </button>

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
                document.querySelector("#street").value = response["logradouro"]
                document.querySelector("#complement").value = response["complemento"]
                document.querySelector("#locality").value = response["localidade"]
                document.querySelector("#federal_unit").value = response["uf"]   
            }
        }
    </script>
</body>
</html>
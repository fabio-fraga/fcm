<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
    exit;
}

require("../database/db.php");

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$_SESSION['user_id']],
    fetch_object: true
)->data[0];

$delimiters = [',', '.'];

$adress = str_replace($delimiters, ',', $user->USU_ENDERECO);

$adress_array = explode(',', $adress);

$street = trim($adress_array[0]);
$house_number = trim($adress_array[1]);
$neighborhood = trim($adress_array[2]);
$city = trim(explode(' - ', $adress_array[3])[0]);
$state = trim(explode(' - ', $adress_array[3])[1]);
$cep = trim(explode(': ', $adress_array[4])[1]);
$complement = trim(explode(': ', $adress_array[5])[1]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <input type="text" name="phone_number" id="telefone" minlength="11" maxlength="11" value="<?= $user->USU_CELULAR ?>" required>
        </div>

        
        <div>
            <label for="">CEP:</label>
            <input id="cep" type="text" name="cep" value="<?= $cep ?>" required>
        </div>
                
        <div>
            <label for="">Logradouro:</label>
            <input id="street" type="text" name="street" value="<?= $street ?>" required>
        </div>
                
        <div>
            <label for="">Complemento:</label>
            <input id="complement" type="text" name="complement" value="<?= $complement ?>" required>
        </div>

        <div>
            <label for="">Bairro:</label>
            <input id="neighborhood" class="nomecadastro" type="text" name="neighborhood" value="<?= $neighborhood ?>" required>
        </div>
                
        <div>
            <label for="">Número da residência:</label>
            <input id="houseNumber" type="text" name="house_number" value="<?= $house_number ?>" required>
        </div>
                
        <div>
            <label for="">Cidade:</label>
            <input id="city" type="text" name="city" value="<?= $city ?>" required>
        </div>
                
        <select id="state" name="state" required>
            <option value="Estado" <?=($state === 'Selecione')?'selected':''?> disabled>Estado</option>
            <option value="AC" <?=($state === 'AC')?'selected':''?>>AC</option>
            <option value="AL" <?=($state === 'AL')?'selected':''?>>AL</option>
            <option value="AP" <?=($state === 'AP')?'selected':''?>>AP</option>
            <option value="AM" <?=($state === 'AM')?'selected':''?>>AM</option>
            <option value="BA" <?=($state === 'BA')?'selected':''?>>BA</option>
            <option value="CE" <?=($state === 'CE')?'selected':''?>>CE</option>
            <option value="ES" <?=($state === 'ES')?'selected':''?>>ES</option>
            <option value="GO" <?=($state === 'GO')?'selected':''?>>GO</option>
            <option value="MA" <?=($state === 'MA')?'selected':''?>>MA</option>
            <option value="MT" <?=($state === 'MT')?'selected':''?>>MT</option>
            <option value="MS" <?=($state === 'MS')?'selected':''?>>MS</option>
            <option value="MG" <?=($state === 'MG')?'selected':''?>>MG</option>
            <option value="PA" <?=($state === 'PA')?'selected':''?>>PA</option>
            <option value="PB" <?=($state === 'PB')?'selected':''?>>PB</option>
            <option value="PR" <?=($state === 'PR')?'selected':''?>>PR</option>
            <option value="PE" <?=($state === 'PE')?'selected':''?>>PE</option>
            <option value="PI" <?=($state === 'PI')?'selected':''?>>PI</option>
            <option value="RJ" <?=($state === 'RJ')?'selected':''?>>RJ</option>
            <option value="RN" <?=($state === 'RN')?'selected':''?>>RN</option>
            <option value="RS" <?=($state === 'RS')?'selected':''?>>RS</option>
            <option value="RO" <?=($state === 'RO')?'selected':''?>>RO</option>
            <option value="RR" <?=($state === 'RR')?'selected':''?>>RR</option>
            <option value="SC" <?=($state === 'SC')?'selected':''?>>SC</option>
            <option value="SP" <?=($state === 'SP')?'selected':''?>>SP</option>
            <option value="SE" <?=($state === 'SE')?'selected':''?>>SE</option>
            <option value="TO" <?=($state === 'TO')?'selected':''?>>TO</option>
            <option value="DF" <?=($state === 'DF')?'selected':''?>>DF</option>
        </select>
                        
        <div>
            <label for="">Digite sua senha para continuar: </label>
            <input type="password" name="password" required>
        </div>

        <button>Alterar</button>

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
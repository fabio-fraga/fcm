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
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endereços</title>
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
            <h3 class="main-title">Cadastrar endereço</h3>

            <form action="../address_create.php" method="POST" class="form-public-info">
                <label class="title">CEP:</label>
                <input oninput="getAddress(this.value)" id="cep" class="field" name="cep" type="number" maxlength="8">

                <label class="title">Rua:</label>
                <input id="street" class="field" name="street" type="text" required>
                
                <label class="title">Número:</label>
                <input id="number" class="field" name="number" type="text">

                <label class="title">Complemento:</label>
                <input id="complement" class="field" name="complement" type="text">

                <label class="title">Localidade:</label>
                <input id="locality" class="field" name="locality" type="text" required>

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

                <?php if (isset($_GET["error_create"])): ?>
                    <p class="error"><?= $_GET["error_create"] ?></p>
                <?php endif ?>

                <button class="btn">Salvar</button>
            </form>
            
            <h3 class="main-title">Seus endereços</h3>

            <?php if (isset($_GET["error_delete"])): ?>
                    <p class="error"><?= $_GET["error_delete"] ?></p>
                <?php endif ?>

            <?php foreach ($addresses->data as $key => $address): ?>
                <div id="address-<?= $address->LOG_CODIGO ?>" class="address-card">
                    <form id="form-update-<?= $key ?>" action="../address_update.php" method="POST">
                        <div class="btns">
                            <span class="btn-card edit" onclick="updateAddress(<?= $address->LOG_CODIGO ?>, <?= $key ?>, 'update')"><span class="green">&#9998;</span></span>
                            <span class="btn-card delete" onclick="window.location='../address_delete.php?street_id=<?= $address->LOG_CODIGO ?>'"><img class="img-btncard-delete"src="../images/img_seller/lixoverde.png" alt=""></span>
                            <span class="btn-card save">&#10004;</span>
                            <span class="btn-card cancel" onclick="updateAddress(<?= $address->LOG_CODIGO ?>, <?= $key ?>, 'cancel')">&#10006;</span>
                        </div>
                        <div class="address-title">Endereço <?= $key + 1 ?>:</div>
                        <div class="cep">
                            CEP: <input oninput="getAddress(this.value, <?= $address->LOG_CODIGO ?>)" class="field cep-input" type="number" maxlength="8" disabled>
                        </div>
                        <div class="street-number">
                            Rua: <input class="field street-input" name="street" type="text" value="<?= $address->LOG_NOME ?>" required disabled>
                            Número: <input class="field number-input" name="number" type="number" value="<?= $address->LDU_NUMERO ?>" disabled>
                        </div>
                        <div class="complement">
                            Complemento: <input class="field complement-input" name="complement" type="text" value="<?= $address->LDU_COMPLEMENTO ?>" disabled>
                        </div>
                        <div class="locality">
                            Localidade: <input class="field locality-input" name="" type="locality" value="<?= $address->LOC_NOME ?>" required disabled>
                        </div>
                        <div class="uf-country">
                            UF: <select class="field uf-select" id="federative_unit" name="federative_unit" required disabled>
                                <option value="UF" selected disabled>UF</option>
                                <option value="AC" <?= $address->UNF_NOME == "AC" ? "selected" : '' ?>>AC</option>
                                <option value="AL" <?= $address->UNF_NOME == "AL" ? "selected" : '' ?>>AL</option>
                                <option value="AP" <?= $address->UNF_NOME == "AP" ? "selected" : '' ?>>AP</option>
                                <option value="AM" <?= $address->UNF_NOME == "AM" ? "selected" : '' ?>>AM</option>
                                <option value="BA" <?= $address->UNF_NOME == "BA" ? "selected" : '' ?>>BA</option>
                                <option value="CE" <?= $address->UNF_NOME == "CE" ? "selected" : '' ?>>CE</option>
                                <option value="ES" <?= $address->UNF_NOME == "ES" ? "selected" : '' ?>>ES</option>
                                <option value="GO" <?= $address->UNF_NOME == "GO" ? "selected" : '' ?>>GO</option>
                                <option value="MA" <?= $address->UNF_NOME == "MA" ? "selected" : '' ?>>MA</option>
                                <option value="MT" <?= $address->UNF_NOME == "MT" ? "selected" : '' ?>>MT</option>
                                <option value="MS" <?= $address->UNF_NOME == "MS" ? "selected" : '' ?>>MS</option>
                                <option value="MG" <?= $address->UNF_NOME == "MG" ? "selected" : '' ?>>MG</option>
                                <option value="PA" <?= $address->UNF_NOME == "PA" ? "selected" : '' ?>>PA</option>
                                <option value="PB" <?= $address->UNF_NOME == "PB" ? "selected" : '' ?>>PB</option>
                                <option value="PR" <?= $address->UNF_NOME == "PR" ? "selected" : '' ?>>PR</option>
                                <option value="PE" <?= $address->UNF_NOME == "PE" ? "selected" : '' ?>>PE</option>
                                <option value="PI" <?= $address->UNF_NOME == "PI" ? "selected" : '' ?>>PI</option>
                                <option value="RJ" <?= $address->UNF_NOME == "RJ" ? "selected" : '' ?>>RJ</option>
                                <option value="RN" <?= $address->UNF_NOME == "RN" ? "selected" : '' ?>>RN</option>
                                <option value="RS" <?= $address->UNF_NOME == "RS" ? "selected" : '' ?>>RS</option>
                                <option value="RO" <?= $address->UNF_NOME == "RO" ? "selected" : '' ?>>RO</option>
                                <option value="RR" <?= $address->UNF_NOME == "RR" ? "selected" : '' ?>>RR</option>
                                <option value="SC" <?= $address->UNF_NOME == "SC" ? "selected" : '' ?>>SC</option>
                                <option value="SP" <?= $address->UNF_NOME == "SP" ? "selected" : '' ?>>SP</option>
                                <option value="SE" <?= $address->UNF_NOME == "SE" ? "selected" : '' ?>>SE</option>
                                <option value="TO" <?= $address->UNF_NOME == "TO" ? "selected" : '' ?>>TO</option>
                                <option value="DF" <?= $address->UNF_NOME == "DF" ? "selected" : '' ?>>DF</option>
                            </select>
                            País: <span class="country"><?= $address->PAIS_NOME ?></span>
                        </div>
                    </form>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <script>
        let inputStreetRegister = document.querySelector("#street");
        let inputNumberRegister = document.querySelector("#number")
        let inputComplementRegister = document.querySelector("#complement")
        let inputLocalityRegister = document.querySelector("#locality")
        let inputFederativeUnitRegister = document.querySelector("#federative_unit")

        const elAddresses = Array.from(document.querySelectorAll(".address-card"))
        const addresses = []
        
        for (let i in elAddresses) {
            addresses.push([])
            addresses[i].push(elAddresses[i].querySelector(".street-input").value)
            addresses[i].push(elAddresses[i].querySelector(".number-input").value)
            addresses[i].push(elAddresses[i].querySelector(".complement-input").value)
            addresses[i].push(elAddresses[i].querySelector(".locality-input").value)
            addresses[i].push(elAddresses[i].querySelector(".uf-select").value)
        }

        async function getAddress(cep, id = false) {
            let address = id ? document.querySelector(`#address-${id}`) : null
            let street = id ? address.querySelector(".street-input") : inputStreetRegister
            let number = id ? address.querySelector(".number-input") : inputNumberRegister
            let complement = id ? address.querySelector(".complement-input") : inputComplementRegister
            let locality = id ? address.querySelector(".locality-input") : inputLocalityRegister
            let uf = id ? address.querySelector(".uf-select") : inputFederativeUnitRegister
            
            if (cep.length == 8) {
                let response = await fetch(`https://viacep.com.br/ws/${cep}/json/`).then((res) => res.json())

                if (typeof response["erro"] !== undefined && response["erro"] !== true) {        
                    street.value = response["logradouro"]
                    complement.value = response["complemento"]
                    locality.value = response["localidade"]
                    uf.value = response["uf"]
                }
            } else {
                    street.value = ''
                    number.value = ''
                    complement.value = ''
                    locality.value = ''
                    uf.value = ''
            }
        }

        function updateAddress(id, key, action = false) {
            let address = document.querySelector(`#address-${id}`)
            let cep = address.querySelector(".cep-input")
            let street = address.querySelector(".street-input")
            let number = address.querySelector(".number-input")
            let complement = address.querySelector(".complement-input")
            let locality = address.querySelector(".locality-input")
            let uf = address.querySelector(".uf-select")

            let addressData = [street, number, complement, locality, uf]

            let btnEdit = address.querySelector(".edit")
            let btnDelete = address.querySelector(".delete")
            let btnSave = address.querySelector(".save")
            let btnCancel = address.querySelector(".cancel")   
            
            cep.disabled = !cep.disabled
            cep.style.cursor = cep.disabled ? "not-allowed" : "text"
            
            for (let i in addressData) {
                addressData[i].disabled = !addressData[i].disabled
                addressData[i].style.cursor = cep.disabled ? "not-allowed" : addressData[i].classList[1] == "uf-select" ? "pointer" : "text"
            }

            if (cep.disabled) {
                btnEdit.style.display = "block"
                btnDelete.style.display = "block"
                btnSave.style.display = "none"
                btnCancel.style.display = "none"
            } else {
                btnEdit.style.display = "none"
                btnDelete.style.display = "none"
                btnSave.style.display = "block"
                btnSave.onclick = () => document.querySelector(`#form-update-${key}`).submit()
                btnCancel.style.display = "block"
            }

            if (key !== false && action == "cancel") {
                for (let i in addressData) {
                    addressData[i].value = addresses[key][i]
                }
            }
        }

        let clicks = 0

        function formSubmit(id) {
            let form = document.querySelector(`#form-update-${id}`)
    
            if (clicks == 1) {
                form.submit()
                clicks = 0
            } else {
                clicks++
            }
            console.log(clicks)
        }
    </script>    
</body>
</html>
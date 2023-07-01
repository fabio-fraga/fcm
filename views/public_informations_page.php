<?php

session_start();

require("../database/db.php");

$user = stmt(
    prepare: "SELECT * FROM FCM_USUARIOS WHERE USU_CODIGO = ?",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true,
)->data[0];

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
    <link rel="stylesheet" href="../css/public_informations.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../croppie/croppie.css" /> 
</head>
<body>
    <?php include("header_page.php") ?>

    <div class="public-info-container">
        <div class="menu">
            <?php include("menu.php") ?>
        </div>
        <div class="content">
            <h3 class="main-title">Informações públicas</h3>
            <p id="img-path"><?= $user->USU_FOTO === null ? 'images/user_default_photo.png' : $user->USU_FOTO?></p>
            <div class="img-upload">
                <label id="img=" class="label-img" for="file-input" onmouseover="uploadBackground()" onmouseout="removeUploadBackground()">
                    <button class="btn-upload" type="button" style="background-image: url(../<?= $user->USU_FOTO === null ? 'images/user_default_photo.png' : $user->USU_FOTO ?>)"></button>
                </label>
                <input id="file-input" class="file-input" type="file" name="img"/>
            </div>

            <div>
                <div id="preview"></div>
                <div class="btns-container">
                    <button class="btn-submit-img">Alterar imagem</button>
                    <button class="btn-cancel-update" onclick="cancelUpdate()">Cancelar</button>
                </div>  
            </div>

            <form action="../public_informations_update.php" method="POST" class="form-public-info">
                <label class="title">Nome:</label>
                <input class="field" name="name" type="text" value="<?= $user->USU_NOME ?>">

                <label class="title">Apelido:</label>
                <input class="field" name="nickname" type="text" value="<?= $user->USU_APELIDO ?>">

                <label class="title">Nascimento:</label>
                <input class="field" name="birthday" type="date" value="<?= $user->USU_NASCIMENTO ?>">

                <label class="title">Descrição:</label>
                <textarea class="field-description" name="description" rows="10"><?= $user->USU_DESCRICAO ?? '' ?></textarea>

                <button class="btn">Salvar alterações</button>
            </form>
        </div>
    </div>

    <script src="../croppie/croppie.js"></script>
    <script>
        function cancelUpdate() {
            document.querySelector(".img-upload").style.display = "flex"
            document.getElementById("preview").style.display = "none"
            document.querySelector(".btn-submit-img").style.display = "none"
            document.querySelector(".btn-cancel-update").style.display = "none"
        }

        let resize = new Croppie(document.getElementById("preview"),{
            enableExif: true,
            enableOrientation: true,
            viewport: { width: 100, height: 100, type: 'circle' },
            boundary: { width: 200, height: 200, type: 'circle' }
        });

        let imgUploaded = document.getElementById("file-input")

        imgUploaded.addEventListener("change", () => {
            document.querySelector(".img-upload").style.display = "none"
            document.getElementById("preview").style.display = "block"
            document.querySelector(".btn-submit-img").style.display = "block"
            document.querySelector(".btn-cancel-update").style.display = "block"

            let reader = new FileReader()

            reader.onload = function (e) {
                resize.bind({
                    url: e.target.result
                })
            }

            reader.readAsDataURL(imgUploaded.files[0])
        })
        
        let btnSubmitImg = document.querySelector(".btn-submit-img")

        btnSubmitImg.addEventListener("click", () => {
            resize.result({
                type: 'canvas',
                size: 'viewport'
            }).then((img) => {
                let formData = new FormData()
                
                formData.append("img", img)

                fetch("../upload_user_img.php", {
                    method: "POST",
                    enctype: "multipart/form-data",
                    body: formData
                })

                setTimeout(() => {
                    window.location.reload();
                }, 300);

            });
        })

        function uploadBackground() {
            document.querySelector('.btn-upload').style.backgroundImage = "url('../images/upload_icon.png')"
            document.querySelector('.btn-upload').style.backgroundSize = "60%"
            document.querySelector('.btn-upload').style.backgroundColor = "#45A351"
        }

        function removeUploadBackground() {
            document.querySelector('.btn-upload').style.backgroundImage = `url(../${document.getElementById('img-path').innerHTML})`
            document.querySelector('.btn-upload').style.backgroundSize = "cover"
            document.querySelector('.btn-upload').style.backgroundColor = "#edffd6"
        }
    </script>
    <script src="../js/main.js"></script>
</body>
</html>
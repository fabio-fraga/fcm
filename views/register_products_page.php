<?php

session_start();

require("../database/db.php");
require("../functions/functions.php");

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
    exit;
}

$categories = stmt(
    prepare:"
        SELECT * FROM FCM_CATEGORIAS ORDER BY CAT_CODIGO
    ",
    fetch_object: true
)->data;

$seller_products = stmt(
    prepare: "
        SELECT * FROM FCM_PRODUTOS WHERE PRO_CMT_CODIGO = ?
    ",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.co" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/register_products.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/menu_products.css">
    <link rel="stylesheet" href="../croppie/croppie.css" />
    <title>Meus produtos</title>
</head>
<body>

    <?php include "header_page.php" ?>

    <div class="menu">
        <?php include("menu_products.php") ?>
    </div>

    <div class="Container_grid">
        <h2 class="nameh1_form">Cadastre seus produtos</h2>
            
        <div class="Container">
            <div class="carousel-container">
                <button class="btn-carousel" onclick="changeImgPreview('preview')">
                    <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                        <path d="m1394.006 0 92.299 92.168-867.636 867.767 867.636 867.636-92.299 92.429-959.935-960.065z" fill-rule="evenodd"/>
                    </svg>
                </button>

                    <div class="preview"></div>

                <button class="btn-carousel" onclick="changeImgPreview('next')">
                    <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                        <path d="M526.299 0 434 92.168l867.636 867.767L434 1827.57l92.299 92.43 959.935-960.065z" fill-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <form class="form">
                <?php if (isset($_GET['err'])): ?>
                    <div>
                        <?= $_GET['err'] ?>
                    </div>
                <?php endif ?>

                <div class="choice" >
                    <label for="">Imagens: <span class="max-10">(Até 10)</span> <span class="required">*</label>
                    <input class="images-upload" type="file" accept="image/*" multiple>
                    <div class="warning">A primeira foto adicionada será a principal.</div>
                </div>

                <div class="choice">
                    <label for="">Nome do produto: <span class="required">*</span></label>
                    <input type="text" name="name" placeholder="Nome do produto">
                </div>
            
                <div class="choice" >
                    <label for="">Valor do produto: <span class="required">*</span></label>
                    <input type="number" name="price" placeholder="Valor do produto">
                </div>
            
                <div class="choice" >
                    <label for="">Quantidade do produto: <span class="required">*</span></label>
                    <input type="number" name="amount" placeholder="Quantidade do produto">
                </div>

                <div class="choice" >
                    <label for="">Categoria: <span class="required">*</span></label>
                    <select class="category" name="category">
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie->CAT_CODIGO ?>"><?= $categorie->CAT_NOME ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="choice">
                    <label for="">Descrição do produto  <span class="required">*</span></label>
                    <textarea class="description" type="text" name="description" placeholder="Descrição do produto" rows="10"></textarea>
                </div>
                <button class="button">Cadastrar</button>
            </form>
        </div>
    </div>

<script src="../croppie/croppie.js"></script>

<script>
    let form = document.querySelector(".form")
    let carousel = document.querySelector(".preview")
    let imgFiles = document.querySelector(".images-upload")
    let btnPreview = document.querySelectorAll(".btn-carousel")[0]
    let btnNext = document.querySelectorAll(".btn-carousel")[1]
    let items = undefined
    
    let resize = []
    
    imgFiles.addEventListener("change", () => {

        if (imgFiles.files.length > 10) {
            imgFiles.value = ''
            alert("Você só pode cadastrar até 10 imagens!")
            return
        }

        if (imgFiles.files.length == 0) {
            btnPreview.style.display = "none"
            btnNext.style.display = "none"
        } else {
            btnPreview.style.display = "block"
            btnNext.style.display = "block"
        }

        while (carousel.firstChild) {
            carousel.removeChild(carousel.firstChild)
        }

        for (let i = 0; i < imgFiles.files.length; i++) {
            let div = document.createElement("div")
            div.classList.add("item-container")
            carousel.appendChild(div)
            
            if (i > 0) {
                div.style.visibility = "hidden"
                div.style.width = "0"
                div.style.height = "0"
            }

            resize[i] = new Croppie(div, {
                enableExif: true,
                enableOrientation: true,
                viewport: { width: 200, height: 200 },
                boundary: { width: 300, height: 300 }
            })

            let reader = new FileReader()
            
            reader.onload = (e) => {
                resize[i].bind({
                    url: e.target.result,
                })
            }
            
            reader.readAsDataURL(imgFiles.files[i])
        }

        items = document.querySelectorAll(".item-container")
    })

    form.addEventListener("submit", async (e) => {
        e.preventDefault()

        let formData = new FormData(form)
        
        for (let i = 0; i < imgFiles.files.length; i++) {            
            let resizedImg = await resizeImg(i)
            
            formData.append("images[]", resizedImg)
        }

        fetch("../product_register.php", {
            method: "POST",
            enctype: "multipart/form-data",
            body: formData
        })
        .then((res) => {
            if (res.status != 200) {
                alert("Erro ao cadastrar produto! Se o problema persistir, tente novamente mais tarde.")
            } else {
                alert("Produto cadastrado com sucesso!")
                window.location.reload();
            }
        })

    })
    
    function resizeImg(i) {
        return resize[i].result({
            type: "canvas",
            size: "viewport"
        })
    }

    function changeImgPreview(direction) {
        if (items.length == 1) {
                return
        }

        let index = 0

        for (let i = 0; i < items.length; i++) {
            if (items[i].style.visibility != "hidden") {
                index = i
                break
            }
        }
        
        if (direction == "preview") {
            if (index == 0) {
                items[items.length - 1].style.visibility = "visible"
                items[items.length - 1].style.width = "100%"
                items[items.length - 1].style.height = "100%"
                items[index].style.visibility = "hidden"
                items[index].style.width = "0"
                items[index].style.height = "0"
            } else {
                items[index - 1].style.visibility = "visible"
                items[index - 1].style.width = "100%"
                items[index - 1].style.height = "100%"
                items[index].style.visibility = "hidden"
                items[index].style.width = "0"
                items[index].style.height = "0"
            }
        } else {
            if (index == items.length - 1) {
                items[0].style.visibility = "visible"
                items[0].style.width = "100%"
                items[0].style.height = "100%"
                items[index].style.visibility = "hidden"
                items[index].style.width = "0"
                items[index].style.height = "0"
            } else {
                items[index + 1].style.visibility = "visible"
                items[index + 1].style.width = "100%"
                items[index + 1].style.height = "100%"
                items[index].style.visibility = "hidden"
                items[index].style.width = "0"
                items[index].style.height = "0"
            }
        }
    }
</script>
<script src="../js/main.js"></script>
</body>
</html>


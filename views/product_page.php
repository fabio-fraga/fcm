<?php

require("../database/db.php");

$product = stmt(
    prepare: "
        SELECT * FROM FCM_PRODUTOS
        JOIN FCM_CATEGORIAS ON CAT_CODIGO = PRO_CAT_CODIGO
        JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
        WHERE PRO_CODIGO = ?
    ",
    execute_array: [$_GET["product_id"]],
    fetch_object: true
)->data[0];

$product_sales = stmt(
    prepare: "
        SELECT 
        COALESCE(SUM(VEN_PRO_QUANTIDADE), 0) AS PRO_SALES
        FROM FCM_VENDAS
        WHERE
        VEN_PRO_CODIGO = ?
    ",
    execute_array: [$product->PRO_CODIGO],
    fetch_object: true
)->data[0]->PRO_SALES;

$product_images = stmt(
    prepare: "
        SELECT * FROM FCM_PRODUTOS_FOTOS
        WHERE PFT_PRO_CODIGO = ?
    ",
    execute_array: [$_GET["product_id"]],
    fetch_object: true
)->data;

$product_avg = stmt(
    prepare: "
        SELECT AVG(AVA_NOTA) AS PRO_MEDIA_DE_NOTAS
        FROM FCM_AVALIACOES_DOS_PRODUTOS
        WHERE AVA_PRO_CODIGO = ?
    ",
    execute_array: [$product->PRO_CODIGO],
    fetch_object: true
)->data[0]->PRO_MEDIA_DE_NOTAS;

$evaluations_amount = stmt(
    prepare: "
        SELECT COUNT(*) AS PRO_QUANTIDADE_DE_AVALIACOES
        FROM FCM_AVALIACOES_DOS_PRODUTOS
        WHERE AVA_PRO_CODIGO = ?
    ",
    execute_array: [$_GET["product_id"]],
    fetch_object: true
)->data[0]->PRO_QUANTIDADE_DE_AVALIACOES;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product->PRO_NOME ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/product.css">
</head>
<body>
    <?php include("header_page.php") ?>
    
    <main>
        <div class="main-container">
            <div class="product-container">
                <div class="carousel">
                    <div class="previous" onclick="changeImg('preview')">
                        <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                            <path d="m1394.006 0 92.299 92.168-867.636 867.767 867.636 867.636-92.299 92.429-959.935-960.065z" fill-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="imgs-product">
                        <?php foreach($product_images as $image): ?>
                            <img class="item-carousel" src="<?= "../" . $image->PFT_CAMINHO ?>">
                        <?php endforeach ?>
                    </div>
                    <div class="next" onclick="changeImg('next')">
                        <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                            <path d="M526.299 0 434 92.168l867.636 867.767L434 1827.57l92.299 92.43 959.935-960.065z" fill-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
    
                <div class="data-product">
                    <div class="data-grid">
                        <div class="product-title"><?= $product->PRO_NOME ?></div>
                        <div class="evaluations">
                            <div>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= $product_avg): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <?php endif ?>
                                <?php endfor ?>
                            </div>
                            <span class="reviews-average"><?= $product_avg ?></span>
                            <span class="reviews-amount">(<?= $evaluations_amount ?>)</span>
                        </div>
                        <div class="sales" style="color: black;"><?= $product_sales == 0 ? "Nenhuma venda" : $product_sales . " vendido(s)"?></div>
                        <div class="seller">
                            Vendido por <span><a href=""><?= $product->CMR_NOME ?></a></span>
                        </div>
                        <div>
                            Quantidade disponível: <strong id="amount-available-<?= $product->PRO_CODIGO ?>" class="product_amount"><?= $product->PRO_QUANTIDADE_DISPONIVEL ?></strong>
                        </div>
                        <div class="price-container">
                            <span class="coin">R$</span>
                            <span class="price"><?= number_format($product->PRO_VALOR, 2, ',', '.') ?></span>
                        </div>
                        <?php if ($product->PRO_QUANTIDADE_DISPONIVEL > 0): ?>
                            <div>
                                <button id="btn-amount-decrease-<?= $product->PRO_CODIGO ?>" onclick="changeAmount(<?= $product->PRO_CODIGO ?>, 'decrease')" class="btn-diau" style="cursor: pointer">-</button>
                                <span id="item-amount-<?= $product->PRO_CODIGO ?>" class="amount">1</span>
                                <button id="btn-amount-increase-<?= $product->PRO_CODIGO ?>" onclick="changeAmount(<?= $product->PRO_CODIGO ?>, 'increase')" class="btn-diau" style="cursor: pointer">+</button>
                            </div>
                        <?php endif ?>
                        <div class="payment">
                            <a class="payment-link" href="">Ver formas de pagamento</a>
                        </div>
                        <?php if (isset($_GET["err"]) && $_GET["product_id"] == $product->PRO_CODIGO): ?>
                            <div class="err">
                                <?= $_GET["err"] ?>
                            </div>
                        <?php endif ?>
                        <?php  if (isset($_SESSION["user_id"])): ?>
                            <div>
                                <button id="btn-add-cart-<?= $product->PRO_CODIGO ?>" class="add-cart" onclick="window.location='../cart_add.php?product_id=<?= $product->PRO_CODIGO ?>&amount=' + document.querySelector(`#item-amount-<?= $product->PRO_CODIGO ?>`).innerHTML">Adicionar ao carrinho</button>
                            </div>
                            <div>
                                <button id="btn-buy-now-<?= $product->PRO_CODIGO ?>" class="buy-now" onclick="window.location='checkout_page.php?product_id=<?= $product->PRO_CODIGO ?>&amount=' + document.getElementById(`item-amount-<?= $product->PRO_CODIGO ?>`).innerHTML">Comprar agora</button>
                            </div>
                        <?php else: ?>
                            <div>
                                <button id="btn-add-cart-<?= $product->PRO_CODIGO ?>" class="add-cart" onclick="window.location='login_page.php'">Adicionar ao carrinho</button>
                            </div>
                            <div>
                                <button id="btn-buy-now-<?= $product->PRO_CODIGO ?>" class="buy-now" onclick="window.location='login_page.php'">Comprar agora</button>
                            </div>
                        <?php endif ?>
                    </div>
                
                    <div class="heart">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45067 13.9082L11.4033 20.4395C11.6428 20.6644 11.7625 20.7769 11.9037 20.8046C11.9673 20.8171 12.0327 20.8171 12.0963 20.8046C12.2375 20.7769 12.3572 20.6644 12.5967 20.4395L19.5493 13.9082C21.5055 12.0706 21.743 9.0466 20.0978 6.92607L19.7885 6.52734C17.8203 3.99058 13.8696 4.41601 12.4867 7.31365C12.2913 7.72296 11.7087 7.72296 11.5133 7.31365C10.1304 4.41601 6.17972 3.99058 4.21154 6.52735L3.90219 6.92607C2.25695 9.0466 2.4945 12.0706 4.45067 13.9082Z" stroke="#45a351"/>
                        </svg>
                    </div>
                                
                </div>
            </div>
            
            <div class="description-container">
                <h4 class="description-title">Descrição do produto</h4>
                <div class="description-content"><?= $product->PRO_DESCRICAO ?: "O vendedor não fez uma descrição do produto." ?></div>
            </div>
            
            <div class="evaluation-add-container">
                <form id="send-evaluation">
                    <input type="hidden" name="product_id" value="<?= $product->PRO_CODIGO ?>">
                    <div>
                        <h4 class="evaluate-title">Avaliar produto</h4>
                        <p>Este produto merece quantos estrelas?<span class="required">*</span></p>
                        <div class="stars">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="24" height="24" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                        </div>
                        <div class="rating">
                            <input class="rating-range" type="range" name="rating" min="1" max="5" value="1">
                        </div>
                        <span>Adicionar comentário:</span>
                        <textarea class="insert-comment" name="comment" maxlength="512"></textarea>
                        <h6 class="comment-characters">0/512</h6>
                        
                        <div class="btn-save-comment-container">
                            <button class="btn-save-comment">Concluir</button>
                        </div>
                    </div>
                </form>

            </div>
            
            <div class="evaluations-container"></div>
        </div>
    </main>

    <script>
        let urlParams = new URLSearchParams(window.location.search)
        let productId = urlParams.get("product_id");
        
        getEvaluations(productId)

        let editMode = false

        let starsContainer = document.querySelector(".stars")
        let inputRating = document.querySelector(".rating-range")
        
        inputRating.addEventListener("input", (e) => {
            while (starsContainer.firstChild) {
                starsContainer.removeChild(starsContainer.firstChild)
            }

            for (i = 0; i < e.target.value; i++) {
                starsContainer.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="24" height="24" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>`
            }
        })

        let evaluationAddContainer = document.querySelector(".evaluation-add-container")
        let evaluationForm = document.querySelector("#send-evaluation")

        evaluationForm.addEventListener("submit", (e) => {
            e.preventDefault()

            let formData = new FormData(evaluationForm)

            let path = ''

            if (editMode) {
                path = "../evaluation_edit.php"
            } else {
                path = "../evaluation_add.php"
            }
            
            fetch(path, {
                method: "POST",
                body: formData
            })
            
            evaluationAddContainer.style.display = "none"
            evaluationsContainer.style.display = "grid"
            
            getEvaluations(productId)

            editMode = false
        })
        
        let insertComment = document.querySelector(".insert-comment")
        let commentCharacters = document.querySelector(".comment-characters")

        insertComment.addEventListener("input", (e) => {
            commentCharacters.innerHTML = `${e.target.value.length}/512`
        })

        document.addEventListener("DOMContentLoaded", () => {
            let productAmount = document.querySelectorAll(".product_amount")
                    
            for (i = 0; i < productAmount.length; i++) {
                productAmountId = productAmount[i].id.split("-")[2]
                if (parseInt(productAmount[i].innerHTML) == 0) {
                    let productBuyButton = document.querySelector(`#btn-buy-now-${productAmountId}`)
                    let addCartButton = document.querySelector(`#btn-add-cart-${productAmountId}`)
        
                    productBuyButton.setAttribute("disabled", '');
                    productBuyButton.style.cursor = "not-allowed"
                    productBuyButton.style.backgroundColor = "#bac1bb"
                    addCartButton.setAttribute("disabled", '');
                    addCartButton.style.cursor = "not-allowed"
                    addCartButton.style.backgroundColor = "#bac1bb"
                }
            }
        })

        let evaluationsContainer = document.querySelector(".evaluations-container")

        async function getEvaluations(productId) {
            let response = await fetch(`../api/evaluations.php?product_id=${productId}`).then(res => res.json())
            
            let reviewsAmount = document.querySelector(".reviews-amount")
            reviewsAmount.innerHTML = `(${response.evaluations.length})`

            let reviewsAverage = document.querySelector(".reviews-average")
            reviewsAverage.innerHTML = response.product_avg != null ? response.product_avg.toFixed(1) : parseFloat(0).toFixed(1)

            let evaluationData = document.querySelector(".evaluations").children[0]

            while (evaluationData.firstChild) {
                evaluationData.removeChild(evaluationData.firstChild)
            }

            for (let i = 1; i <= 5; i++) {
                if (i <= response.product_avg) {
                    evaluationData.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>`
                } else {
                    evaluationData.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" fill="#fff" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>`
                }
            }


            if (response.user_bought === true) {
                if (response.user_evaluated === false) {
                    evaluationAddContainer.style.display = "block"
                } else {
                    evaluationAddContainer.style.display = "none"
                }
            } else {
                evaluationAddContainer.style.display = "none"
            }

            while (evaluationsContainer.firstChild) {
                evaluationsContainer.removeChild(evaluationsContainer.firstChild)
            }
            
            let evaluationsTitle = document.createElement("h4")
            evaluationsTitle.classList.add("evaluations-title")
            evaluationsTitle.innerHTML = "Avaliações"
            
            evaluationsContainer.appendChild(evaluationsTitle)

            if (response.evaluations.length == 0) {
                let p = document.createElement("p")
                
                p.innerHTML = "Este produto ainda não possui avaliações."
                
                evaluationsContainer.appendChild(p)
            }

            for (let i in response.evaluations) {
                let evaluationContainer = document.createElement("div")
                evaluationContainer.id = `evaluation-${i}`
                evaluationContainer.classList.add("evaluation-container")

                let authorImageContainer = document.createElement("div")
                authorImageContainer.classList.add("author-image-container")

                let authorImage = document.createElement("img")
                authorImage.classList.add("author-image")
                authorImage.src = response.evaluations[i].USU_FOTO != null ? `../${response.evaluations[i].USU_FOTO}` : "../images/user_default_photo.png"

                authorImageContainer.appendChild(authorImage)

                let evaluation = document.createElement("div")
                evaluation.classList.add("evaluation")

                let authorName = document.createElement("p")
                authorName.classList.add("author-name")
                authorName.innerHTML = response.evaluations[i].USU_NOME

                let evaluationData = document.createElement("p")
                evaluationData.classList.add("evaluation-date")
                let date = response.evaluations[i].AVA_DATA.split(' ')
                evaluationData.innerHTML = `Em ${date[0].replaceAll('-', '/')} às ${date[1]}`

                let productStars = document.createElement("div")
                productStars.classList.add("product-stars")
                
                for (let k = 0; k < response.evaluations[i].AVA_NOTA; k++) {
                    productStars.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>`
                }
                
                let comment = document.createElement("div")
                comment.classList.add("comment")
                comment.innerHTML = response.evaluations[i].AVA_COMENTARIO

                evaluation.appendChild(authorName)
                evaluation.appendChild(evaluationData)
                evaluation.appendChild(productStars)
                evaluation.appendChild(comment)

                evaluationContainer.appendChild(authorImageContainer)
                evaluationContainer.appendChild(evaluation)

                if (response.user_evaluated && evaluationContainer.id == "evaluation-0") {
                    let actionsContainer = document.createElement("div")
                    actionsContainer.classList.add("actions-container")

                    let editBtn = document.createElement("button")
                    editBtn.classList.add("edit-btn")
                    editBtn.innerHTML = "&#9998;"
                    editBtn.onclick = () => editEvaluation(i, response.evaluations[i].AVA_NOTA, response.evaluations[i].AVA_COMENTARIO)

                    let deleteBtn = document.createElement("button")
                    deleteBtn.classList.add("delete-btn")
                    deleteBtn.innerHTML = "&#10006;"
                    deleteBtn.onclick = () => deleteEvaluation(productId)

                    actionsContainer.appendChild(editBtn)
                    actionsContainer.appendChild(deleteBtn)

                    evaluationContainer.appendChild(actionsContainer)
                }

                evaluationsContainer.appendChild(evaluationContainer)
            }
        }

        function changeAmount(itemId, action) {
            let itemAmount = parseInt(document.querySelector(`#item-amount-${itemId}`).innerHTML)
            let itemMaximumAmount = parseInt(document.querySelector(`#amount-available-${itemId}`).innerHTML)

            if (itemAmount > 1 && action == "decrease") {
                document.querySelector(`#item-amount-${itemId}`).innerHTML = itemAmount - 1
            } else if (itemAmount < itemMaximumAmount && action == "increase") {
                document.querySelector(`#item-amount-${itemId}`).innerHTML = itemAmount + 1
            }         
        }

        let evaluateTitle = document.querySelector(".evaluate-title")
        let ratingRange = document.querySelector(".rating-range")
        let commentEvaluation = document.querySelector(".insert-comment")
        
        function editEvaluation(id, rating, comment) {
            let evaluation = document.querySelector(`#evaluation-${id}`)

            editMode = true

            if (evaluationsContainer.childNodes.length == 2) {
                evaluationsContainer.style.display = "none"
            } else {
                evaluation.style.display = "none"
            }
            
            evaluateTitle.innerHTML = "Editar avaliação"

            ratingRange.value = rating

            commentEvaluation.innerHTML = comment

            commentCharacters.innerHTML = `${comment.length}/512`

            while (starsContainer.firstChild) {
                starsContainer.removeChild(starsContainer.firstChild)
            }

            for (let i = 0; i < rating; i++) {
                starsContainer.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="24" height="24" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>`
            }

            evaluationAddContainer.style.display = "block"
        }

        function deleteEvaluation(id) {
            confirm("Tem certeza que deseja excluir sua avaliação? Esta ação não poderá ser desfeita!")

            fetch(`../evaluation_delete.php?product_id=${id}`)

            getEvaluations(id)

            evaluateTitle.innerHTML = "Avaliar produto"

            ratingRange.value = 1

            commentEvaluation.value = ''

            commentCharacters.innerHTML = "0/512"

            while (starsContainer.firstChild) {
                starsContainer.removeChild(starsContainer.firstChild)
            }

            starsContainer.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="24" height="24" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>`

            evaluationAddContainer.style.display = "block"
        }

        function changeImg(direction) {
            let item = document.querySelectorAll(".item-carousel")

            let index = 0

            for (let i = 0; i < item.length; i++) {
                if (item[i].style.display != "none") {
                    index = i
                    break
                }
            }
            
            if (direction == "preview") {
                if (index == 0) {
                    item[item.length - 1].style.display = "block"
                    item[index].style.display = "none"
                } else {
                    item[index - 1].style.display = "block"
                    item[index].style.display = "none"
                }
            } else {
                if (index == item.length - 1) {
                    item[0].style.display = "block"
                    item[index].style.display = "none"
                } else {
                    item[index + 1].style.display = "block"
                    item[index].style.display = "none"
                }
            }
        }
    </script>
</body>
</html>
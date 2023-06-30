<?php

session_start();

require("../database/db.php");

$search = $_GET["search"];

if (isset($_GET["search"])) {
    $all_products = stmt(
        prepare: "
            SELECT * FROM FCM_PRODUTOS
            JOIN FCM_CATEGORIAS ON CAT_CODIGO = PRO_CAT_CODIGO
            JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
            JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
            WHERE UPPER (PRO_NOME) LIKE ?
        ",
        execute_array:[strtoupper("%$search%")],
        fetch_object: true
    )->data;
} else {
    $all_products = stmt(
        prepare: "
            SELECT * FROM FCM_PRODUTOS
            JOIN FCM_CATEGORIAS ON CAT_CODIGO = PRO_CAT_CODIGO
            JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
            JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
        ",
        fetch_object: true
    )->data;
}

$all_places = stmt(
    prepare: "SELECT * FROM FCM_LOCALIDADES LIMIT 3",
    fetch_object: true
)->data;

$places = [];

foreach ($all_places as $place) {
    if (!in_array($place->LOC_NOME, $places)) {
        array_push($places, $place->LOC_NOME);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>free-Commerce</title>
</head>
<body>
    
    <?php include "header_page.php"?>

    <div class="main-container">
        <div class="filters-container">
            <div class="filters">
                <h2 class="filter-title">Filtros</h2>
    
                <div class="filter-ratings">
                    <h4 class="filter-title">Avaliações dos clientes</h4>
    
                    <?php for ($i = 1; $i < 6; $i++): ?>
                        <div>
                            <a href="">
                                <?php for ($j = 0; $j < 5; $j++): ?>
                                    <?php if ($j < $i): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <?php endif ?>
                                <?php endfor ?>
                            </a>
                        </div>
                    <?php endfor ?>
                </div>
    
                <div class="filter-locales">
                    <h4 class="filter-title">Regiões</h4>
                    <?php foreach ($places as $place): ?>
                        <div>
                            <input type="checkbox"> <?= $place ?>
                        </div>
                    <?php endforeach ?>
                </div>
    
                <div class="filter-prices">
                    <h4 class="filter-title">Preço</h4>
                    <div>
                        <input type="checkbox"> Até R$ 20,00
                    </div>
                    <div>
                        <input type="checkbox"> Até R$ 50,00
                    </div>
                    <div>
                        <input type="checkbox"> Até R$ 100,00
                    </div>
                    <div>
                        <input type="checkbox"> Até R$ 1.000,00
                    </div>
                    <div>
                        <input type="checkbox"> Acima de R$ 1.000,00
                    </div>           
                </div>
    
                <div class="filter-promotions">
                    <h4 class="filter-title">Promoções</h4>
                    <a class="promotions-link" href="">Confira as ofertas disponíveis</a>
                </div>
            </div>
        </div>

        <div class="products-container">     
            <?php foreach ($all_products as $key => $product): ?>
                <div class="grid-item" onclick="openModal(<?= $product->PRO_CODIGO ?>)">
                    <div class="item-container">
                        <div class="img-container">
                            <?php
                            $product_images = stmt(
                                prepare: "
                                    SELECT * FROM FCM_PRODUTOS_FOTOS
                                    WHERE PFT_PRO_CODIGO = ?
                                ",
                                execute_array: [$product->PRO_CODIGO],
                                fetch_object: true
                            )->data;
                            ?>
                            <img class="img-item" src="<?= "../" . $product_images[0]->PFT_CAMINHO ?>">
                        </div>
                        <div class="seller" onclick="document.querySelectorAll('.grid-item')[<?= $key ?>].onclick = false">
                            <span><a href=""><?= $product->CMR_NOME ?></a></span>
                        </div>
                        <div class="title"><?= $product->PRO_NOME ?></div>
                        <div class="price">R$ <?= number_format($product->PRO_VALOR, 2, ',', '.') ?></div>
                        <?php
                            $product_sales = stmt("
                                SELECT 
                                COALESCE(SUM(VEN_PRO_QUANTIDADE), 0) AS PRO_SALES
                                FROM FCM_VENDAS
                                WHERE
                                VEN_PRO_CODIGO = ?
                            ",
                            execute_array: [$product->PRO_CODIGO],
                            fetch_object: true
                            )->data[0]->PRO_SALES;
                        ?>
                        <div class="sales"><?= $product_sales == 0 ? "Nenhuma venda" : $product_sales . " vendido(s)"?></div>
                        <div class="rating">

                            <?php
                                    
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
                                execute_array: [$product->PRO_CODIGO],
                                fetch_object: true
                            )->data[0]->PRO_QUANTIDADE_DE_AVALIACOES;
                                                                        
                            ?>

                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <= $product_avg): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                <?php endif ?>
                            <?php endfor ?>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div id="modal-<?= $product->PRO_CODIGO ?>" class="modal">
                    <div class="modal-content">
                        <div class="carousel">
                            <div class="previous" onclick="changeImg('preview', <?= $key ?>)">
                                <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m1394.006 0 92.299 92.168-867.636 867.767 867.636 867.636-92.299 92.429-959.935-960.065z" fill-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="imgs-product">
                                <?php foreach ($product_images as $product_image): ?>
                                    <img id="item-carousel-<?= $key ?>" class="item-carousel" src="<?= "../" . $product_image->PFT_CAMINHO ?>">
                                <?php endforeach ?>
                            </div>
                            <div class="next" onclick="changeImg('next', <?= $key ?>)">
                                <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M526.299 0 434 92.168l867.636 867.767L434 1827.57l92.299 92.43 959.935-960.065z" fill-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="data-product">
            
                            <div class="data-grid">
                                <div class="modal-product-title"><?= $product->PRO_NOME ?></div>
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
                                    <span class="reviews-average"><?= number_format($product_avg, 1, '.') ?></span>
                                    <span class="reviews-amount">(<?= $evaluations_amount ?>)</span>
                                    <a class="evaluations-link" href="product_page.php?product_id=<?= $product->PRO_CODIGO ?>">Ver avaliações</a>
                                </div>
                                <div class="sales" style="color: black;"><?= $product_sales == 0 ? "Nenhuma venda" : $product_sales . " vendido(s)"?></div>
                                <div class="modal-seller">
                                    Vendido por <strong><?= $product->CMR_NOME ?></strong>
                                </div>
                                <div>
                                    Quantidade disponível: <strong id="amount-available-<?= $product->PRO_CODIGO ?>" class="product_amount"><?= $product->PRO_QUANTIDADE_DISPONIVEL ?></strong>
                                </div>
                                <div class="price-container">
                                    <span class="coin">R$</span>
                                    <span class="modal-price"><?= number_format($product->PRO_VALOR, 2, ',', '.') ?></span>
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
                                    <div id="err-<?= $product->PRO_CODIGO ?>" class="err">
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
                            
                            <span class="close-modal" onclick="closeModal(<?= $product->PRO_CODIGO ?>)">
                                &#128473;
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <script>  
        function openModal(id) {
            let modal = document.querySelector(`#modal-${id}`);
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
        }

        function closeModal(id) {
            let modal = document.querySelector(`#modal-${id}`);
            modal.style.display = "none";
            document.body.style.overflow = "auto";
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

            let urlParams = new URLSearchParams(window.location.search);

            let err = urlParams.get("err");
            let productId = urlParams.get("product_id");

            if (err != null && productId != null) {
                openModal(productId)
            }
        })

        function changeImg(direction, id) {
            let item = document.querySelectorAll("#item-carousel-" + id)

            if (item.length == 1) {
                return
            }

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
    <script src="../js/main.js"></script>
</body>
</html>
<?php  

session_start();

require("../database/db.php");

if (!isset($_SESSION["user_id"])) {
    header("location: login_page.php");
}


$cart = stmt(
    prepare: "
        SELECT * FROM FCM_CARRINHO_DE_COMPRAS
        JOIN FCM_PRODUTOS ON PRO_CODIGO = CDC_PRO_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = PRO_CMT_CODIGO
        WHERE CDC_USU_CODIGO = ?;
    ",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
);

$soma = 0;

foreach ($cart->data as $product) {
    if ($product->CDC_SELECIONADO == 1) {
        $soma += $product->PRO_VALOR * $product->CDC_QUANTIDADE;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Meu carrinho</title>
</head>
<body>

    <?php include "header_page.php"?>

    <div class="main">
        <div class="main-container">
            <div class="title">
                <div class="product-title">Produtos</div>
                <div>Preço unitário</div>
                <div>Quantidade</div>
                <div>Preço total</div>
                <div>Ações</div>
            </div>

            <?php if ($cart->row_count == 0): ?>
                <div class="empty-cart">
                    <div>
                        &#128722;
                    </div>
                    <h6>Carrinho vazio!</h6>
                </div>
            <?php endif ?>
    
            <?php foreach($cart->data as $product): ?>
    
            <div class="first-line">
                <p>
                    <?= $product->CMR_NOME ?>
                </p>
            </div>
    
            <div class="second-line">
                <div class="product">
                    <div>
                        <form action="../cart_update.php" method="POST">
                            <input type="hidden" name="selected" value="<?= $product->CDC_SELECIONADO == 0 ? 1 : 0 ?>">
                            <input type="hidden" name="product_id" value="<?= $product->PRO_CODIGO ?>">
                            <input class="checkbox" type="checkbox" onclick="this.form.submit()" <?= $product->CDC_SELECIONADO == 1 ? "checked" : '' ?>>
                        </form>
                    </div>
                    <div>
                        <img class="img-item" src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/100px-Placeholder_view_vector.svg.png">
                    </div>
                    <div>
                        <?= $product->PRO_NOME ?>
                    </div>
                </div>
                <div> R$ <?= number_format( $product->PRO_VALOR , 2, ',', '.') ?></div>
                <div>
                    <a href="../cart_update.php?action=diminuir&product_id=<?= $product->PRO_CODIGO ?>"><button class="btn-diau" style="cursor: pointer">-</button></a>
                    <span id="<?= $product->CDC_PRO_CODIGO?>"><?= $product->CDC_QUANTIDADE ?></span>
                    <a href="../cart_update.php?action=aumentar&product_id=<?= $product->PRO_CODIGO ?>"><button class="btn-diau" style="cursor: pointer">+</button></a>
                </div>
                <div> R$ <?= number_format( $product->PRO_VALOR * $product->CDC_QUANTIDADE , 2, ',', '.')  ?></div>
                <div class="btn-delete">  
                    <a href="../cart_delete.php?product_id=<?= $product->CDC_PRO_CODIGO ?>"  onclick="return confirm('Tem certeza que deseja retirar esse item do carrinho?')">

                        <svg fill="#fff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                            width="20" height="20" viewBox="0 0 41.336 41.336"
                            xml:space="preserve">
                            <g>
                                <path d="M36.335,5.668h-8.167V1.5c0-0.828-0.672-1.5-1.5-1.5h-12c-0.828,0-1.5,0.672-1.5,1.5v4.168H5.001c-1.104,0-2,0.896-2,2
                                    s0.896,2,2,2h2.001v29.168c0,1.381,1.119,2.5,2.5,2.5h22.332c1.381,0,2.5-1.119,2.5-2.5V9.668h2.001c1.104,0,2-0.896,2-2
                                    S37.438,5.668,36.335,5.668z M14.168,35.67c0,0.828-0.672,1.5-1.5,1.5s-1.5-0.672-1.5-1.5v-21c0-0.828,0.672-1.5,1.5-1.5
                                    s1.5,0.672,1.5,1.5V35.67z M22.168,35.67c0,0.828-0.672,1.5-1.5,1.5s-1.5-0.672-1.5-1.5v-21c0-0.828,0.672-1.5,1.5-1.5
                                    s1.5,0.672,1.5,1.5V35.67z M25.168,5.668h-9V3h9V5.668z M30.168,35.67c0,0.828-0.672,1.5-1.5,1.5s-1.5-0.672-1.5-1.5v-21
                                    c0-0.828,0.672-1.5,1.5-1.5s1.5,0.672,1.5,1.5V35.67z"/>
                            </g>
                        </svg>

                    </a>
                </div>
                
            </div>
            <?php endforeach ?>        
        </div>
    
    </div>
    <div class="footer">
            <div class="total">
                Total: R$ <?= number_format( $soma , 2, ',', '.') ?> 
                <div>
                    <button onclick="window.location='../checkout.php'" class="button">Continuar</button>
                </div>
            </div>            
    </div>       
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let checkboxes = document.querySelectorAll(".checkbox")
            let btn = document.querySelector(".button")
            let counter_selected_checkboxes = 0

            for (i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    counter_selected_checkboxes++
                }
            }

            if (document.querySelector(".first-line") == null || counter_selected_checkboxes == 0) {
                btn.setAttribute("disabled", '');
                btn.style.cursor = "not-allowed"
                btn.style.backgroundColor = "#bac1bb"
            }
        })
    </script>
</body>
</html>
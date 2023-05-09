<?php  

session_start();

require("../database/db.php");

$cart = stmt(
    prepare: "
        SELECT * FROM FCM_CARRINHO_DE_COMPRAS
        JOIN FCM_PRODUTOS ON PRO_CODIGO = CDC_PRO_CODIGO
        JOIN FCM_USUARIOS ON USU_CODIGO = CDC_USU_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
        WHERE CDC_USU_CODIGO = ?;
    ",
    execute_array: [$_SESSION["user_id"]],
    fetch_object: true
)->data;

$soma = 0;

foreach ($cart as $product) {
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
    <title>Meu carrinho</title>
</head>
<body>
    <div class="back-button">
    <button>
        <a href="home_page.php">Voltar</a>
    </button>
    </div>
    <div class="container">
        <div class="title">
            <div class="product-title">Produtos</div>
            <div>Preço unitário</div>
            <div>quantidade</div>
            <div>Preço total</div>
            <div>Ações</div>
        </div>

        <?php foreach($cart as $product): ?>

        <div class="first-line">
            <p>
                <?= $product->CMR_NOME ?>
            </p>
        </div>

        <div class="second-line">
            <div class="product">
                <form action="../cart_update.php" method="POST">
                    <input type="hidden" name="selected" value="<?= $product->CDC_SELECIONADO == 0 ? 1 : 0 ?>">
                    <input type="hidden" name="product_id" value="<?= $product->PRO_CODIGO ?>">
                    <input type="checkbox" onclick="this.form.submit()" <?= $product->CDC_SELECIONADO == 1 ? "checked" : '' ?>>
                    <?= $product->PRO_NOME ?>
                </form>
            </div>
            <div><?= $product->PRO_VALOR ?></div>
            <div>
                <a href="../cart_update.php?action=diminuir&product_id=<?= $product->PRO_CODIGO ?>"><button style="cursor: pointer">-</button></a>
                <span id="<?= $product->CDC_PRO_CODIGO?>"><?= $product->CDC_QUANTIDADE ?></span>
                <a href="../cart_update.php?action=aumentar&product_id=<?= $product->PRO_CODIGO ?>"><button style="cursor: pointer">+</button></a>
            </div>
            <div><?= $product->PRO_VALOR * $product->CDC_QUANTIDADE ?></div>
            <div>  <a href="../cart_delete.php?product_id=<?= $product->CDC_PRO_CODIGO ?>">Remover</a></div>
            
        </div>
        <?php endforeach ?>        
    </div>

    
        <footer>
            <div class="total">
                <h2>Total: <?= $soma ?></h2>
            </div>
            
        </footer>
  
</body>
</html>
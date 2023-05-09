<?php  

session_start();

require("../database/db.php");

$cart = stmt(
    prepare: "
        SELECT * FROM FCM_CARRINHO_DE_COMPRAS
        JOIN FCM_PRODUTOS ON PRO_CODIGO = CDC_PRO_CODIGO
        JOIN FCM_USUARIOS ON USU_CODIGO = ?
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
    <title>Meu carrinho</title>
</head>
<body>
    <button>
        <a href="home_page.php">Voltar</a>
    </button>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>nome</th>
                <th>preço</th>
                <th>quantidade</th>
                <th>total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cart as $product): ?>
                <tr>
                    <td>
                        <form action="../cart_update.php" method="POST">
                            <input type="hidden" name="selected" value="<?= $product->CDC_SELECIONADO == 0 ? 1 : 0 ?>">
                            <input type="hidden" name="product_id" value="<?= $product->PRO_CODIGO ?>">
                            <input type="checkbox" onclick="this.form.submit()" <?= $product->CDC_SELECIONADO == 1 ? "checked" : '' ?>>
                        </form>
                    </td>
                    <td><?= $product->PRO_NOME ?></td>
                    <td><?= $product->PRO_VALOR ?></td>
                    <td>
                        <a href="../cart_update.php?action=diminuir&product_id=<?= $product->PRO_CODIGO ?>"><button style="cursor: pointer">-</button></a>
                        <span id="<?= $product->CDC_PRO_CODIGO?>"><?= $product->CDC_QUANTIDADE ?></span>
                        <a href="../cart_update.php?action=aumentar&product_id=<?= $product->PRO_CODIGO ?>"><button style="cursor: pointer">+</button></a>
                    </td>
                    <td><?= $product->PRO_VALOR * $product->CDC_QUANTIDADE ?></td>
                    <td>
                        <a href="../cart_delete.php?product_id=<?= $product->CDC_PRO_CODIGO ?>">Remover</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <footer>
        <h2>Total: <?= $soma ?></h2>
    </footer>
</body>
</html>
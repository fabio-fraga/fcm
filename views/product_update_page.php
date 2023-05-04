<?php 

require("../database/db.php");

$product_id = $_GET["product_id"];

$product = stmt(
    prepare: "SELECT * FROM FCM_PRODUTOS WHERE PRO_CODIGO = ?",
    execute_array: [$product_id],
    fetch_object:  true
)->data[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização</title>
</head>
<body>
    <form action="../product_update.php" method='POST'>
        Produto: <input name="name" type="text" value="<?= $product->PRO_NOME ?>">
        Valor: <input name="value" type="number" value="<?= $product->PRO_VALOR ?>">
        Quantidade: <input name="amount" type="number" value="<?= $product->PRO_QUANTIDADE_DISPONIVEL ?>">
        <input type="hidden" name="id" value="<?= $product->PRO_CODIGO?>">
        <button>Alterar</button>

    </form>
    <a href="products_page.php">Voltar</a>

</body>
</html>
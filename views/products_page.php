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
    <link rel="stylesheet" href="../css/products.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.co" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Meus produtos</title>
</head>
<body>
    <header>
        <h1>Meus produtos</h1>
    </header>

    <p>Cadastre produtos:</p>

    <form action="../product_register.php" method="POST">
        <?php if (isset($_GET['err'])): ?>
            <div>
                <?= $_GET['err'] ?>
            </div>
        <?php endif ?>

        <div>
            <label for="">Nome do produto:</label>
            <input type="text" name="name" placeholder="Nome do produto">
        </div>
    
        <div>
            <label for="">Valor do produto:</label>
            <input type="number" name="price" placeholder="Valor do produto">
        </div>
    
        <div>
            <label for="">Quantidade do produto:</label>
            <input type="number" name="amount" placeholder="Quantidade do produto">
        </div>

        <div>
            <label for="">Categoria:</label>
            <select name="category">
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?= $categorie->CAT_CODIGO ?>"><?= $categorie->CAT_NOME ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <button>Cadastrar</button>

    </form>

    <?php if ($seller_products->row_count > 0): ?>
        <h1>Seus produtos</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($seller_products->data as $product): ?>
                    <tr>
                        <td><?= $product->PRO_NOME ?></td>
                        <td><?= $product->PRO_VALOR ?></td>
                        <td><?= $product->PRO_QUANTIDADE_DISPONIVEL ?></td>
                        <td>
                            <a href="product_update_page.php?product_id=<?= $product->PRO_CODIGO?>">atualizar</a>
                        </td>
                        <td>
                            <a style="text-decoration: none; color: red" href="../product_delete.php?product_id=<?= $product->PRO_CODIGO ?>" onclick="return confirm('Você tem certeza que deseja excluir este produto?')">&#128465;</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    
                </tbody>
            </table>
            <?php endif ?>
</body>
</html>


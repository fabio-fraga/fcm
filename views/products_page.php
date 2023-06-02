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
    <link rel="stylesheet" href="../css/products.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Meus produtos</title>
</head>
<body>

    <?php include "header_page.php" ?>

<div class="Container_grid">
    <div class="Container">
        <h2 class="nameh1_form">Cadastre seus produtos</h2>

    <form  class="form" action="../product_register.php" method="POST">
        <?php if (isset($_GET['err'])): ?>
            <div>
                <?= $_GET['err'] ?>
            </div>
        <?php endif ?>

        <div class="choice">
            <label for="">Nome do produto:</label>
            <input type="text" name="name" placeholder="Nome do produto">
        </div>
    
        <div class="choice" >
            <label for="">Valor do produto:</label>
            <input type="number" name="price" placeholder="Valor do produto">
        </div>
    
        <div class="choice" >
            <label for="">Quantidade do produto:</label>
            <input type="number" name="amount" placeholder="Quantidade do produto">
        </div>

        <div class="choice" >
            <label for="">Categoria:</label>
            <select  class="category" name="category">
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?= $categorie->CAT_CODIGO ?>"><?= $categorie->CAT_NOME ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <button class="button">Cadastrar</button>
    </form>
    </div>
</div>

<div class="Container_grid2">
    <div class="Container_2">
        <?php if ($seller_products->row_count > 0): ?>
            <h2 class="name_container2">Seus produtos</h2
            >
            <table class="tl_container2">
                <thead>
                    <tr>
                        <th class="cont_left">Nome do produto</th>
                        <th class="cont_center">Valor</th>
                        <th class="cont_center" >Quantidade</th>
                        <th class="cont_center" > Editar </th>
                        <th class="cont_center" > Deletar </th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php foreach ($seller_products->data as $product): ?>
                        <tr>
                            <td class="cont_left"><?= $product->PRO_NOME ?></td>
                            <td class="cont_center"><?= $product->PRO_VALOR ?></td>
                            <td class="cont_center"><?= $product->PRO_QUANTIDADE_DISPONIVEL ?></td>
                            
                            <td class="cont_center">
                                <a href="product_update_page.php?product_id=<?= $product->PRO_CODIGO?>">atualizar</a> 
                            </td>

                            <td class="tamanho_lixin">
                                <a href="../product_delete.php?product_id=<?= $product->PRO_CODIGO ?>" onclick="return confirm('Você tem certeza que deseja excluir este produto?')"> <img class="lixin" src="../images/img_seller/lixoverde.png" alt=""></a> 
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
        <?php endif ?>
    </div>
</div>
</body>
</html>


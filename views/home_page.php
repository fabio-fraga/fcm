<?php

session_start();

require("../database/db.php");

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
}

$all_products = stmt(
    prepare: "
        SELECT * FROM FCM_PRODUTOS
        JOIN FCM_CATEGORIAS ON CAT_CODIGO = PRO_CAT_CODIGO
        JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
    ",
    fetch_object: true
)->data;

$all_places = stmt(
    prepare: "SELECT * FROM FCM_LOCALIDADES",
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
    <title>free-Commerce</title>
</head>
<body>
    <header>
        
        <div class="container">
            <div class="lugar_img">
                   <img class="tamanho_logo" src="../images/logo.png" alt="logo">
            </div>

                <div class="tamanho_pesquisa">
                    <form action="">
                        <input type="text" id="txtBusca" placeholder="Oq Você Procura no Free-Commerce?"/>
                        <span class="lupa">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 17L21 21" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="#323232" stroke-width="2"/>
                            </svg>
                        </span>
                    </form>
                        
                </div>

                <div class="tamanho_link">
                    <a  href="cart_page.php"> <img class="tamanho_img" src="../images/img_home/cart.png" alt="CarrinhoDeCompras"> </a>
                    
                    <a href="notification.php"> <img class="tamanho_img" src="../images/img_home/sino.png" alt="notificação"> </a>
                    
                    <div id="icon-dropdown" onclick="showDropdown()"> <img class="tamanho_img" src="../images/img_home/perfil.png" alt="Perfil"></div>
                    
                    <div class="itens_dropdown" id="itens-dropdown">  
                        <ul class="list">
                            <li ><a href="profile_page.php?user_id=<?= $_SESSION["user_id"] ?>"> Perfil </a></li>
                            <li ><a href="seller_page.php?user_id=<?= $_SESSION["user_id"] ?>"> Venda seus produtos</a></li>
                            <li> <a href="../logout.php"> Sair da conta </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="bemvindo_topo">
            <h5 class="lugar-bemvindo_topo">Bem-vindo(a), <?= $_SESSION["user_name"] ?>!</h5>
        </div>
        
    <script>

        let dropdown = document.getElementById("itens-dropdown")

        function showDropdown(){
            if (dropdown.style.display == 'block'){
                dropdown.style.display = 'none'
            }else{
                dropdown.style.display = 'block'
            }
        }
    </script>

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
                <div class="grid-item" onclick="openModal(<?= $key ?>)">
                    <div class="item-container">
                        <div class="img-container">
                            <img class="img-item" src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/800px-Placeholder_view_vector.svg.png">
                        </div>
                        <div class="seller">
                            <span><?= $product->CMR_NOME ?></span>
                        </div>
                        <div class="title"><?= $product->PRO_NOME ?></div>
                        <div class="price">R$ <?= number_format($product->PRO_VALOR, 2, ',', '.') ?></div>
                        <div class="sales">10 vendidos</div>
                        <div class="rating">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div id="<?= $key ?>" class="modal">
                    <div class="modal-content">
                        <div class="carousel">
                            <div class="previous">
                                <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m1394.006 0 92.299 92.168-867.636 867.767 867.636 867.636-92.299 92.429-959.935-960.065z" fill-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="imgs-product">
                                <img class="item-carousel" src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/800px-Placeholder_view_vector.svg.png">
                            </div>
                            <div class="next">
                                <svg fill="#45a351" width="36" height="36" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M526.299 0 434 92.168l867.636 867.767L434 1827.57l92.299 92.43 959.935-960.065z" fill-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="data-product">
            
                            <div class="data-grid">
                                <div class="modal-product-title"><?= $product->PRO_NOME ?></div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                </div>
                                <div class="modal-seller">
                                    Vendido por <strong><?= $product->CMR_NOME ?></strong>
                                </div>
                                <div class="price-container">
                                    <span class="coin">R$</span>
                                    <span class="modal-price"><?= number_format($product->PRO_VALOR, 2, ',', '.') ?></span>
                                </div>
                                <div>
                                    <a class="payment" href="">Ver formas de pagamento</a>
                                </div>
                                <div>
                                    <a href="../cart_add.php?product_id=<?= $product->PRO_CODIGO ?>">
                                        <button class="add-cart">Adicionar ao carrinho</button>
                                    </a>
                                </div>
                                <div>
                                    <button class="buy-now">Comprar agora</button>
                                </div>
                            </div>
            
                            <div class="heart">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.45067 13.9082L11.4033 20.4395C11.6428 20.6644 11.7625 20.7769 11.9037 20.8046C11.9673 20.8171 12.0327 20.8171 12.0963 20.8046C12.2375 20.7769 12.3572 20.6644 12.5967 20.4395L19.5493 13.9082C21.5055 12.0706 21.743 9.0466 20.0978 6.92607L19.7885 6.52734C17.8203 3.99058 13.8696 4.41601 12.4867 7.31365C12.2913 7.72296 11.7087 7.72296 11.5133 7.31365C10.1304 4.41601 6.17972 3.99058 4.21154 6.52735L3.90219 6.92607C2.25695 9.0466 2.4945 12.0706 4.45067 13.9082Z" stroke="#45a351"/>
                                </svg>
                            </div>
                            
                            <span class="close-modal" onclick="closeModal(<?= $key ?>)">
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
            let modal = document.getElementById(id);
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
        }

        function closeModal(id) {
            let modal = document.getElementById(id);
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    </script>
</body>
</html>


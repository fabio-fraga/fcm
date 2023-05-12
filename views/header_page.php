<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
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
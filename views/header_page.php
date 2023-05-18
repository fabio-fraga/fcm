<header> 
    <div class="container">
        <div class="lugar_img">
            <a href="/">
                <img class="tamanho_logo" src="../images/logo.png" alt="logo">
            </a>
        </div>

        <div class="tamanho_pesquisa">
                <form class="search-form" action="">
                    <input type="text" id="txtBusca" placeholder="O que está procurando?"/>
                    <span class="lupa">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="stroke-lens" d="M17 17L21 21" stroke="#fc5d02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path class="stroke-lens" d="M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="#fc5d02" stroke-width="2"/>
                        </svg>
                    </span>
                </form>     
        </div>

        <div class="tamanho_link">
            <a  href="cart_page.php"> <img class="tamanho_img" src="../images/img_home/cart.png" alt="CarrinhoDeCompras"> </a>
                    
            <a href="notification.php"> <img class="tamanho_img" src="../images/img_home/sino.png" alt="notificação"> </a>
                    
            <div class="dropdown">
                <img class="tamanho_img" src="../images/img_home/perfil.png" alt="Perfil">
                <div class="dropdown-content">
                    <span class="dropdown-username">Olá, <?= $_SESSION["user_name"] ?>!</span>
                    <a class="dropdown-link" href="account_page.php">Sua conta</a>
                    <a class="dropdown-link" href="profile_page.php?user_id=<?= $_SESSION["user_id"] ?>"> Perfil </a>
                    <a class="dropdown-link" href="seller_page.php?user_id=<?= $_SESSION["user_id"] ?>"> Venda seus produtos</a>
                    <a class="dropdown-link" href="../logout.php"> Sair da conta </a>
                </div>
            </div>
        </div>
    </div>
</header>

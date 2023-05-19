<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra finalizada</title>
    <link rel="stylesheet" href="../css/completed_purchase.css">
    <script>
        setTimeout(() => {
            document.querySelector(".msg").innerHTML = "Compra finalizada! Estamos te redirecionando para a página inicial!"
        }, 5000);

        setTimeout(() => {
            window.location.href = "home_page.php"
        }, 10000);
    </script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div>
                <img src="../images/logo.png" alt="logo" width="200px">
            </div>
            <div class="msg-container">
                <h1 class="msg">Finalizando compra, aguarde!</h1>
            </div>
            <div class="progress">
                <div class="color"></div>
            </div>
        </div>
    </div>

</body>
</html>
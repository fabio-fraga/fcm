<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: welcome_page.php");
    exit;
}

require("../database/db.php");

$user = stmt(
    prepare: "
        SELECT * FROM FCM_USUARIOS
        JOIN FCM_LOGRADOUROS_DOS_USUARIOS ON LDU_USU_CODIGO = ?
        JOIN FCM_LOGRADOUROS ON LOG_CODIGO = LDU_LOG_CODIGO
        JOIN FCM_LOCALIDADES ON LOC_CODIGO = LOG_LOC_CODIGO
        JOIN FCM_UNIDADES_FEDERATIVAS ON UNF_CODIGO = LOC_UNF_CODIGO
        JOIN FCM_PAISES ON PAIS_CODIGO = UNF_PAIS_CODIGO;
    ",
    execute_array: [$_SESSION['user_id']],
    fetch_object: true
)->data[0];

$product = stmt(
    prepare: "
        SELECT * FROM FCM_PRODUTOS
        JOIN FCM_CATEGORIAS ON CAT_CODIGO = PRO_CAT_CODIGO
        JOIN FCM_USUARIOS ON USU_CODIGO = PRO_CMT_CODIGO
        JOIN FCM_COMERCIOS ON CMR_USU_CODIGO = USU_CODIGO
        WHERE PRO_CODIGO = ?
    ",
    execute_array: [$_GET['product_id']],
    fetch_object: true
)->data[0];

$total = $product->PRO_VALOR * $_GET['amount'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar compra</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/checkout.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <?php include "header_page.php"?>

    <h3 class="main-title">Finalizar Compra</h3>
    
    <div class="checkout-container">
        <div class="address-payment">
            <h4 class="address-title">Endereço de entrega:</h4>
            <div>
                <div>
                    <?= $user->USU_NOME ?>
                </div>
                <div>
                    <?= $user->LOG_NOME ?>, <?= $user->LDU_NUMERO ?>
                </div>
                <div>
                    <?= $user->LDU_COMPLEMENTO ?>
                </div>
                <div>
                    <?= $user->LOC_NOME ?>, <?= $user->UNF_NOME ?>, <?= $user->PAIS_NOME ?>
                </div>
            </div>

            <hr class="division-line">

            <h4 class="payment-title">Forma de Pagamento:</h4>

            <abbr title="Opção indisponível">       
                <h5>Cartão de crédito</h5>
                <div class="credit-card">
                    <input class="input-radio" type="radio" disabled>
                    <svg width="49" height="49" viewBox="0 0 49 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M33.4403 42.5922C33.092 41.2425 35.3594 41.6398 36.2901 41.6398C37.2264 41.6398 39.4761 41.2997 39.7018 42.1485C40.0635 43.5095 37.7319 43.1137 36.8611 43.1137C35.6528 43.1137 33.6393 43.3633 33.4403 42.5922ZM44.5532 48.8716H14.1092C12.4175 48.8455 11.3761 47.9657 11.359 46.2117C11.3439 44.6543 11.2697 38.8068 11.4055 38.0254L11.4066 36.8424C11.4285 33.9098 11.4093 30.9688 11.4082 28.0354C11.4068 24.0167 13.1987 24.5158 16.6908 24.5158C22.5633 24.5158 28.436 24.5199 34.3086 24.5154L36.6707 24.5165L44.4932 24.5153C45.0172 24.7886 45.1816 24.7005 45.6593 25.135C46.8345 26.2039 46.4993 27.5885 46.4993 29.6528C46.4993 31.6465 46.6426 46.3339 46.3823 47.1687C46.014 48.3499 45.1249 48.5431 44.5532 48.8716ZM13.9553 42.5922C13.684 41.4043 15.1684 41.6398 16.0248 41.6398C16.8558 41.6399 18.3968 41.3802 18.5931 42.14C18.9094 43.3636 17.3255 43.1138 16.5006 43.1137C15.65 43.1137 14.1313 43.3639 13.9553 42.5922ZM20.4282 42.4971C20.2929 41.3828 21.8269 41.6398 22.6848 41.6398H28.9641C29.8263 41.6398 31.4438 41.3465 31.6046 42.2401C31.812 43.3932 30.2125 43.1138 29.3448 43.1137H23.0653C22.2037 43.1137 20.5383 43.4043 20.4282 42.4971ZM14.643 31.7439L14.6387 30.2764C14.7028 29.3951 14.3918 28.1217 15.1514 27.8309C15.5244 27.6879 17.4215 27.7743 17.9792 27.7551L19.4643 27.7569C20.0427 27.7703 21.9199 27.6765 22.3174 27.8306C23.0011 28.096 22.7642 29.4527 22.7775 30.2769L22.7769 31.7523C22.7424 34.7297 23.1833 34.2585 18.784 34.2585C13.9255 34.2585 14.7738 34.6292 14.643 31.7438V31.7439ZM41.0898 29.3774C42.975 29.2997 43.891 29.1009 43.9087 30.408C43.9323 32.1422 44.1889 32.6736 42.3811 32.665C41.4336 32.6604 35.1065 32.7922 34.8274 32.5562L34.4342 32.5351C34.2095 32.1003 34.1517 32.2344 34.1358 31.6529C34.0746 29.426 34.1133 29.3812 35.8142 29.3856C37.5202 29.3899 39.4055 29.4576 41.0898 29.3774Z" fill="#0068AE"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M38.2431 17.0891C38.7283 16.9242 39.1914 17.3141 39.141 17.8444C39.0954 18.3265 38.5816 18.5207 38.2127 18.7321C37.7577 18.9931 36.2011 19.9776 35.8455 20.0769C35.29 20.2316 34.8317 19.8681 34.8884 19.3026C34.9422 18.7658 35.3848 18.685 35.8131 18.4252C36.3914 18.0745 37.639 17.2944 38.2431 17.0892V17.0891ZM36.497 14.3191C37.0083 14.0895 37.4991 14.3782 37.5225 14.9118C37.5465 15.4644 37.1639 15.6009 36.7428 15.8345C35.9845 16.2555 35.2564 16.6777 34.5103 17.1224C33.7629 17.568 33.0723 17.9755 32.284 18.4143C31.6961 18.7415 30.6501 19.443 30.0964 19.6595C29.3147 19.9652 28.2746 18.9867 29.8194 18.1388L34.2746 15.5562C34.9417 15.1686 35.7827 14.6401 36.497 14.3191ZM3.18093 24.9537L9.90595 36.6286C10.0013 36.8023 10.0313 36.8522 10.1204 36.9817C10.1829 37.0727 10.1408 37.0294 10.2433 37.1497L10.4576 37.3596L11.4068 36.8425C11.4287 33.91 11.4095 30.969 11.4084 28.0355C11.407 24.0168 13.1989 24.516 16.691 24.516C22.5635 24.516 28.4362 24.52 34.3088 24.5156L39.0353 21.7424C41.6859 20.2444 40.1784 18.2478 39.3581 16.785C38.8632 15.9024 34.1398 7.90198 33.9192 7.28583L33.8516 7.30764L3.18066 24.9536L3.18093 24.9537Z" fill="#FDC100"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.56337 22.1662L32.1871 4.50127L32.1931 4.45008C32.0572 4.01624 31.2423 2.71446 30.9646 2.2502C30.4274 1.35222 30.3538 0.921384 29.44 0.409058L14.888 8.82177C11.6076 10.7103 7.70619 13.0697 4.45032 14.8434C3.51395 15.3534 0.908954 16.7622 0.459966 17.4181C0.236778 17.7442 0.0914255 18.1365 0.0410156 18.5441V19.1789C0.0791495 19.479 0.172656 19.7731 0.328979 20.0411C0.734609 20.7373 1.16962 21.4603 1.56311 22.166L1.56337 22.1662Z" fill="#FDC100"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.56348 22.1661C1.69603 22.3704 1.7868 22.5908 1.92575 22.8208C2.08077 23.078 2.18838 23.2883 2.343 23.5456C2.63828 24.0367 2.86982 24.5026 3.1809 24.9536L33.8518 7.30762C33.7338 7.03193 32.512 4.79326 32.1872 4.50125L1.56348 22.1661Z" fill="#004A84"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M46.5107 48.8718C47.0914 48.8216 47.5738 48.6654 48.0209 48.2339C48.5476 47.7257 48.7102 47.2391 48.7537 46.5972V44.8758V28.5114V26.79C48.7102 26.1481 48.5476 25.6615 48.0209 25.1533C47.1454 24.3084 46.1051 24.5154 44.4932 24.5154C45.0171 24.7888 45.1815 24.7006 45.6593 25.1351C46.8345 26.204 46.4992 27.5886 46.4992 29.6529C46.4992 31.6466 46.6425 46.334 46.3822 47.1688C46.0139 48.35 45.1249 48.5432 44.5531 48.8718H46.5106H46.5107Z" fill="#004A84"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M33.9189 7.28594C34.1395 7.90196 38.8629 15.9025 39.3579 16.7851C40.1781 18.2479 41.6855 20.2446 39.035 21.7425L34.3085 24.5157L36.6706 24.5167C36.8827 24.2251 39.8983 22.5867 40.3623 22.3084C42.0407 21.3019 43.8799 20.5131 42.0993 17.5646L35.5494 6.24823C35.1603 6.69421 34.4458 6.89507 33.9189 7.28607V7.28594Z" fill="#FE9900"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M34.8275 32.5562C36.1121 32.3904 38.6604 32.534 40.0959 32.5361C41.2598 32.5378 41.6521 32.7722 41.6602 31.4639C41.6674 30.2576 41.8667 29.9819 41.0896 29.3774C39.4054 29.4576 37.5201 29.3899 35.8141 29.3856C34.1132 29.3812 34.0744 29.426 34.1357 31.6529C34.1516 32.2344 34.2093 32.1003 34.4341 32.5351L34.8273 32.5562H34.8275Z" fill="#9AE4FF"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7765 31.7522L14.6426 31.7437C14.7733 34.629 13.925 34.2585 18.7836 34.2585C23.1829 34.2585 22.742 34.7298 22.7765 31.7522Z" fill="#FDC100"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.4283 42.4971C20.5384 43.4043 22.2038 43.1137 23.0654 43.1137H29.3449C30.2125 43.1138 31.8119 43.3932 31.6047 42.2401C31.444 41.3466 29.8265 41.6398 28.9642 41.6398H22.6849C21.827 41.6398 20.293 41.3828 20.4283 42.4971Z" fill="#F0ECE9"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6387 30.2764L14.643 31.7438L22.7769 31.7523L22.7774 30.2769L19.4548 30.2765L19.4643 27.757L17.979 27.7551L17.9565 30.2729L14.6387 30.2764Z" fill="#FE9900"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M36.4975 14.3189C35.7832 14.6399 34.9421 15.1684 34.275 15.556L29.8198 18.1387C28.275 18.9865 29.3151 19.9651 30.0968 19.6593C30.6506 19.4428 31.6966 18.7414 32.2844 18.4141C33.0727 17.9753 33.7632 17.5679 34.5107 17.1223C35.2568 16.6776 35.9849 16.2555 36.7432 15.8343C37.1643 15.6007 37.5469 15.4641 37.5229 14.9117C37.4995 14.3779 37.0087 14.0893 36.4975 14.3189Z" fill="#003165"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M33.4404 42.5922C33.6394 43.3631 35.6529 43.1137 36.8612 43.1137C37.7319 43.1137 40.0637 43.5095 39.7019 42.1484C39.4762 41.2997 37.2265 41.6398 36.2902 41.6398C35.3593 41.6398 33.0919 41.2425 33.4404 42.5922Z" fill="#F0ECE9"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M34.8271 32.5562C35.1061 32.7922 41.4333 32.6604 42.3808 32.665C44.1886 32.6736 43.932 32.1422 43.9084 30.408C43.8906 29.1009 42.9747 29.2997 41.0895 29.3774C41.8665 29.9819 41.6672 30.2576 41.66 31.4639C41.6519 32.7722 41.2596 32.5378 40.0958 32.5361C38.6603 32.534 36.1119 32.3905 34.8273 32.5562H34.8271Z" fill="#55CBFB"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M29.4404 0.409026C30.3542 0.921353 30.4277 1.35219 30.965 2.25016C31.2426 2.71443 32.0576 4.01621 32.1935 4.45005C32.7438 4.22503 33.3485 3.76063 33.9122 3.50427C33.8326 3.13612 33.4163 2.54335 33.217 2.18617C32.995 1.78929 32.733 1.26443 32.4606 0.944599C32.0668 0.48229 31.4506 0.197984 30.7764 0.158936H30.454C30.1174 0.178525 29.7731 0.259102 29.4406 0.409026H29.4404Z" fill="#FE9900"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7777 30.2769C22.7644 29.4526 23.0013 28.096 22.3176 27.8306C21.9201 27.6765 20.0429 27.7703 19.4645 27.7569L19.4551 30.2764L22.7777 30.2769Z" fill="#FDC100"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6396 30.2764L17.9574 30.273L17.98 27.7553C17.4224 27.7744 15.5252 27.688 15.1522 27.831C14.3927 28.1218 14.7038 29.3953 14.6395 30.2765L14.6396 30.2764Z" fill="#FDC100"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9555 42.5922C14.1315 43.3639 15.6502 43.1136 16.5008 43.1136C17.3256 43.1138 18.9095 43.3636 18.5933 42.1399C18.397 41.3802 16.856 41.6399 16.025 41.6397C15.1687 41.6397 13.6842 41.4044 13.9555 42.5922Z" fill="#F0ECE9"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32.1925 4.4502L32.1865 4.50139C32.5113 4.7934 33.733 7.03207 33.8511 7.30776L33.9187 7.28595C34.4456 6.89495 35.1601 6.69396 35.5492 6.24811L34.7627 4.82579C34.6049 4.5501 34.1162 3.63228 33.9112 3.50443C33.3476 3.76078 32.7429 4.22518 32.1925 4.4502Z" fill="#003165"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M38.2423 17.0891C37.6382 17.2943 36.3906 18.0743 35.8123 18.4251C35.384 18.685 34.9415 18.7657 34.8876 19.3024C34.8309 19.8679 35.2891 20.2315 35.8447 20.0767C36.2003 19.9775 37.7569 18.9931 38.2119 18.732C38.5807 18.5206 39.0946 18.3264 39.1401 17.8442C39.1906 17.3141 38.7275 16.924 38.2423 17.089V17.0891Z" fill="#003165"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4572 37.3595C10.5044 37.492 10.3826 37.3759 10.5819 37.5683C10.644 37.6284 10.7429 37.6839 10.8059 37.7244C11.0409 37.8758 11.147 37.9174 11.4052 38.0254L11.4062 36.8423L10.457 37.3595H10.4572Z" fill="#FE9A00"/>
                    </svg>
                    <div>
                        <div>
                            Banco do Brasil Gold Visa
                        </div>
                        <div>
                            Terminado em 0357
                        </div>
                    </div>
                </div>
                
                <h5>Boleto</h5>
                <div class="boleto">
                    <input class="input-radio" type="radio" disabled>
                    <svg fill="#000000" width="65" height="50" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M0 2.53h2.49v10.95H0zm11 0h2.49v10.95H11zm-6.02 0h1.24v10.95H4.98zm2.49 0h1.24v10.95H7.47zm7.29 0H16v10.95h-1.24z"/></svg>
                    Vencimento em 3 dias úteis. A data de entrega será alterada devido ao tempo de processamento do boleto.
                </div>
                
                <h5>Pix</h5>
                <div class="pix">
                    <input class="input-radio" type="radio" disabled>
                    <svg width="55" height="55" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26.8119 28.8308C29.9759 27.6139 32.3931 31.1353 34.6809 33.3907C36.211 34.8992 39.7583 38.8573 41.3815 39.6895C42.5387 40.283 45.9238 40.7863 47.1858 40.2075C47.2015 40.2002 50.0234 37.4732 50.4214 37.0792C52.5509 34.9708 54.3554 32.2998 54.6804 28.3564C55.0112 24.3425 53.3635 20.653 51.3771 18.6598C47.422 14.6915 48.0023 14.5518 45.6165 14.6331C44.7201 14.6635 43.559 14.7042 42.7024 14.8576C38.6556 15.5815 32.6176 25.9157 28.4405 26.4303C25.6273 26.7773 23.268 23.5133 20.7949 21.0309C19.4609 19.692 15.7033 15.7119 13.8237 15.012C12.5764 14.5479 8.89335 14.2572 7.73525 14.7665C7.4206 14.9047 5.00441 17.4272 4.52706 17.9183C2.6735 19.8277 0.541081 22.6512 0.308284 26.6293C-0.100949 33.6137 3.62724 36.2946 6.87855 39.6086C7.75975 40.5065 7.65193 40.4236 9.30013 40.3893C10.297 40.3687 11.5384 40.4329 12.4926 40.3491C17.0716 39.9492 22.7632 30.3869 26.8124 28.8299L26.8119 28.8308Z" fill="#28BBAC"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M44.3601 11.8989C43.745 10.9672 41.7885 9.22833 40.8529 8.33194C39.5385 7.07337 38.6544 6.21618 37.2948 4.78166C31.6601 -1.16324 23.2917 -1.28968 17.5257 4.67335C16.2318 6.01181 11.371 10.6678 10.7314 11.8847C16.7714 11.9881 17.4144 14.0989 20.3487 16.8185C21.8714 18.23 26.7547 23.6025 27.7286 23.6887C29.0842 23.8088 31.0392 21.3946 31.7631 20.6315C32.9756 19.3538 34.0832 18.3393 35.332 17.0836C37.9599 14.442 38.968 12.4257 44.3606 11.8989H44.3601Z" fill="#28BBAC"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6851 43.2079C12.9131 45.4432 15.3287 47.8962 17.6513 50.1737C23.6908 56.0955 31.4525 56.3847 37.3842 50.2829C38.5403 49.0935 39.8077 47.9638 40.9482 46.74C41.9691 45.6447 43.5217 44.2395 44.3083 43.1299C39.4583 42.5203 38.8819 41.5651 35.1601 37.8183C34.1142 36.765 32.6802 35.3222 31.6167 34.2543C30.9129 33.547 29.0559 30.9574 27.5651 31.3725C27.0642 31.5117 20.9482 37.7521 20.2273 38.5269C16.2967 42.7516 15.5419 42.6845 10.6846 43.2079H10.6851Z" fill="#28BBAC"/>
                    </svg>
                    O código Pix gerado para o pagamento é válido por 30 minutos após a finalização do pedido.
                </div>
            </abbr>
            <div class="pick-up">
                <input class="input-radio" type="radio" checked>
                <h5>Simulação</h5>
            </div>
        </div>
        <div class="item-resume">
            <div class="item-card">
                
                <div class="data-grid">
                    <h5 class="resume-title">Resumo do pedido</h5>
                    <div class="product-title"><?= $product->PRO_NOME ?></div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffca0f" stroke="#ffca0f" width="18" height="18" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
                    </div>
                    <div class="seller">
                        Vendido por <strong><?= $product->CMR_NOME ?></strong>
                    </div>
                    <div class="price-container">
                        <div>
                            Valor do item:
                        </div>
                        <span class="coin">R$</span>
                        <span class="price"><?= number_format($product->PRO_VALOR, 2, ',', '.') ?></span>
                    </div>
                    <div class="total">
                        <div class="total-title">
                            Total:
                        </div>
                        <div class="total-value">
                            <?= 'R$ ' . number_format($total, 2, ',', '.') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button id="btn-buy-now-<?= $key ?>" class="buy-now" onclick="window.location='../checkout.php?product_id=<?= $product->PRO_CODIGO ?>&amount=' + <?= $_GET['amount'] ?>">Finalizar Compra</button>
            </div>
        </div>
    </div>


</body>
</html>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua conta</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/account.css">
</head>
<body>
    <?php include "header_page.php"?>

    <div class="account-container">
        <div class="orders" onclick="window.location='orders_page.php'">
            <div class="card-icon">
                <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M47.0997 57.3828V42.7832L52.4317 39.9903C52.4317 40.6147 52.3445 44.1703 52.5125 44.6065C52.6341 44.9221 53.0765 45.3223 53.4472 45.3223C53.7463 45.3223 57.5735 43.1878 58.1098 42.8756C58.6104 42.5842 58.7557 42.5131 58.7864 41.7748L58.7792 36.4354C59.3423 36.3041 61.2278 35.1452 61.8668 34.8259C62.2775 34.6205 62.5997 34.4723 62.9685 34.2773V49.1307C62.5019 49.2394 61.4542 49.8051 60.979 50.061L47.0995 57.3825L47.0997 57.3828ZM29.1992 33.8965L31.1764 34.9662C32.0283 35.4716 44.3642 42.5218 44.9414 42.6563V57.129C44.5309 57.0334 43.338 56.2326 42.9357 55.961C42.593 55.7295 42.3475 55.5961 41.9967 55.3767C41.6331 55.1493 41.342 54.9272 40.9999 54.723L31.2828 48.571C30.8949 48.3166 30.6514 48.1994 30.265 47.9383C29.8731 47.6735 29.6734 47.4643 29.1992 47.3537V33.8967V33.8965ZM30.3418 32.1192C31.3079 31.8941 35.0102 29.3828 35.5538 29.572C35.7608 29.6441 36.0049 29.8474 36.187 29.9547L48.5983 36.714C49.1139 37.0273 50.9285 37.8944 51.162 38.213C50.8988 38.5722 50.3998 38.7045 49.9948 38.9502C49.5426 39.2246 49.1675 39.4016 48.6962 39.6828L46.0837 41.1329C42.5901 39.2844 37.8512 36.4509 34.2366 34.4448C33.5572 34.0679 32.9789 33.7374 32.2998 33.3347C31.786 33.0299 30.6128 32.4897 30.3415 32.1193L30.3418 32.1192ZM56.7481 36.6894C56.7481 41.3527 57.1859 41.1147 55.6917 41.8537C55.1819 42.1059 54.8886 42.2442 54.4629 42.5292C54.4629 41.2597 54.4527 39.9858 54.4668 38.7168C54.4841 37.1546 54.2912 37.5043 52.68 36.568L47.6515 33.8524C44.6653 32.3489 40.7593 30.1206 37.5782 28.4375C37.7656 28.1817 39.4832 27.1351 39.9383 27.2195L55.6904 35.8429C56.2964 36.164 56.7483 36.3276 56.7483 36.6894H56.7481ZM42.1484 25.7715C43.0586 25.5595 45.4997 23.8672 46.084 23.8672C46.3839 23.8672 53.8766 27.9508 55.0242 28.6378C55.3964 28.8606 55.6524 28.9492 56.027 29.1586L58.9914 30.7644C59.5088 31.0422 61.7313 32.1972 61.9531 32.5001C61.3641 32.6372 59.6302 33.7251 58.9501 34.0674C58.4878 34.3001 58.2747 34.4008 57.8905 34.6582L57.4272 34.3599C57.2076 34.244 57.1479 34.2268 56.9287 34.0965L42.1484 25.7713V25.7715ZM27.2949 31.9922V47.9883C27.2949 48.6829 27.7174 48.7532 28.1578 49.0297L35.2414 53.4987C36.418 54.2717 45.6638 60.1757 46.084 60.1757C46.5 60.1757 50.1898 58.0616 50.864 57.7194C51.752 57.2688 52.4009 56.8856 53.2782 56.452C53.7599 56.2139 53.9816 56.0654 54.4223 55.8187C54.8748 55.5655 55.2304 55.4308 55.6909 55.183L59.2464 53.2795C59.7454 53.0303 59.9716 52.8486 60.4705 52.5993C61.3088 52.1804 65 50.4369 65 49.7656V32.2461C65 31.4593 62.6556 30.5748 61.7528 30.0343C61.2843 29.7537 61.0107 29.6228 60.5126 29.3704C58.0315 28.1133 54.6936 26.0834 52.2218 24.8389C51.2279 24.3385 46.405 21.5822 46.0842 21.5822C45.7364 21.5822 44.0903 22.5044 43.6703 22.7231C43.2609 22.9362 42.9645 23.1453 42.5302 23.3605L37.7297 25.9232C37.2934 26.189 36.944 26.324 36.4773 26.5751C36.0311 26.8155 35.8217 26.972 35.3357 27.2108L29.3999 30.4153C28.8275 30.7581 27.2952 31.2716 27.2952 31.9924L27.2949 31.9922Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M34.7853 14.9805H13.5841C13.5841 12.8744 14.4151 11.1191 15.6906 9.85066C18.4218 7.13504 19.2061 8.5724 19.2966 6.09348C19.37 4.08587 21.4627 2.03138 23.9943 2.03138C25.9274 2.03138 27.2986 2.7098 28.2575 4.11578C29.7201 6.26034 28.1117 7.15008 29.994 7.96528C32.6834 9.12988 34.7855 11.8072 34.7855 14.9805H34.7853ZM23.2326 0H24.2612C26.2347 0.0132579 27.4069 0.191108 29.2957 2.06177C30.2039 2.96137 31.1036 4.45257 31.1036 6.22073C32.7984 6.61555 34.718 8.85566 35.6741 10.2832L46.0841 10.283C47.2681 10.2815 48.4961 10.0977 48.4961 11.2987V19.0428C48.4961 20.4397 46.4649 20.4911 46.4649 19.1699V12.3144H36.5625C36.785 12.7779 36.9434 13.8832 36.9434 14.5996C36.9434 16.402 37.2367 17.1386 35.293 17.1386H13.0762C10.9098 17.1386 11.444 15.6612 11.5554 13.8407C11.5973 13.1593 11.7923 12.9571 11.8067 12.3145H2.03138V62.9688H46.338V61.9533C46.338 60.5904 48.3692 60.5904 48.3692 61.9533C48.3692 63.0312 48.6612 65.0002 47.6075 65.0002H0.888768C0.29604 65.0002 0 64.7041 0 64.1114V11.2988C0 10.0301 1.30381 10.2828 2.53906 10.2832H12.8222C13.7529 8.52421 15.182 7.34393 16.8517 6.44158C17.8218 5.91725 16.9711 4.89218 18.4606 2.84528C19.4505 1.48457 21.3304 0 23.2325 0L23.2326 0Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.87119 50.5273H12.4415V55.6055H7.87119V50.5273ZM5.71289 50.0195V56.2402C5.71289 56.9959 5.95735 57.6367 6.72858 57.6367H13.711C14.0167 57.6367 14.4727 57.1807 14.4727 56.875V49.3847C14.4727 48.7296 13.9441 48.369 13.3302 48.369H7.1095C5.99729 48.369 5.71305 48.9165 5.71305 50.0195H5.71289Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.87119 37.1973H12.4415V42.2754H7.87119V37.1973ZM5.71289 36.5625V42.9102C5.71289 43.6659 5.95735 44.3066 6.72858 44.3066H13.5841C14.1766 44.3066 14.4727 44.0106 14.4727 43.4178V36.0545C14.4727 35.4618 14.1766 35.1659 13.5841 35.1659H6.72858C5.95735 35.1659 5.71289 35.8066 5.71289 36.5623V36.5625Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.87119 23.8672H12.4415V29.0723H7.87119V23.8672ZM5.71289 23.3594V29.5801C5.71289 30.4351 5.86617 31.1035 6.72858 31.1035H13.5841C14.1766 31.1035 14.4727 30.8076 14.4727 30.2147V22.8515C14.4727 22.2588 14.1766 21.9628 13.5841 21.9628H6.72858C5.95735 21.9628 5.71289 22.6037 5.71289 23.3592V23.3594Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3437 7.99811V7.36334C22.3437 5.41232 25.8983 5.41232 25.8983 7.36334C25.8983 8.34944 25.6768 9.52148 24.248 9.52148C23.3542 9.52148 22.3437 8.84306 22.3437 7.99811ZM20.3125 7.23642C20.3125 8.55219 20.3119 9.37904 21.4186 10.4468C23.923 12.8623 27.9416 11.0581 28.0341 7.73327C28.125 4.46486 24.0582 2.46631 21.4836 4.8529C20.9424 5.35444 20.3125 6.24903 20.3125 7.23658V7.23642Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2502 26.4063C16.2502 27.2176 16.6044 27.5489 17.5197 27.5489H30.9767C32.9502 27.5489 32.4496 25.5177 31.6114 25.5177H17.1388C16.546 25.5177 16.25 25.8135 16.25 26.4063H16.2502Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.25 53.9552H29.7071C30.5702 53.9552 30.973 51.924 29.3262 51.924H16.7578C15.1768 51.924 15.3014 53.9552 16.25 53.9552Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.123 39.7363C16.123 40.3992 16.5591 40.752 16.8847 40.752H25.3905C26.7032 40.752 26.5705 38.7208 25.1367 38.7208H17.2657C16.6516 38.7208 16.123 39.0814 16.123 39.7365V39.7363Z" fill="black"/>
                </svg>
            </div>
            <div class="card-information">
                <h3>
                    Seus pedidos
                </h3>
                <p class="information-content">
                    Rastrear, devolver ou comprar produtos novamente.
                </p>
            </div>
        </div>
        <!-- Nome, nascimento, foto, apelido, descrição -->
        <div class="public-informations" onclick="window.location='public_informations_page.php'">
            <div class="card-icon">
                <svg fill="#000000" width="62" height="62" viewBox="0 -2.93 32.537 32.537" xmlns="http://www.w3.org/2000/svg">
                    <g transform="translate(-481.391 -197.473)">
                        <path d="M512.928,224.152a.991.991,0,0,1-.676-.264,21.817,21.817,0,0,0-29.2-.349,1,1,0,1,1-1.322-1.5,23.814,23.814,0,0,1,31.875.377,1,1,0,0,1-.677,1.736Z"/>
                        <path d="M498.191,199.473a7.949,7.949,0,1,1-7.949,7.95,7.959,7.959,0,0,1,7.949-7.95m0-2a9.949,9.949,0,1,0,9.95,9.95,9.949,9.949,0,0,0-9.95-9.95Z"/>
                    </g>
                </svg>
            </div>
            <div class="card-information">
                <h3>
                    Informações públicas
                </h3>
                <p class="information-content">
                    Gerenciar e alterar as suas Informações públicas.
                </p>
            </div>
        </div>
        <!-- E-mail, telefone, senha -->
        <div class="security" onclick="window.location='security_page.php'">
            <div class="card-icon">
                <svg width="62" height="70" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.74375 10.6602L10.4596 9.46401C15.0113 8.55225 20.2798 7.21883 24.5135 5.56171C25.6638 5.11151 26.6533 4.78813 27.7877 4.31328C31.5841 2.72363 30.4494 2.72103 32.5876 3.60911L37.3889 5.52279C42.4664 7.46534 49.7855 9.35729 55.2864 10.1062C56.4852 10.2694 58.1525 10.4037 59.2569 10.6602C59.2569 15.593 59.5843 28.7617 58.7685 33.8271C57.5303 41.5156 54.7147 48.0659 49.8239 54.0343C49.0043 55.0346 46.3737 57.8782 45.2993 58.8215C41.8745 61.8279 38.9358 63.6144 34.8433 65.6267C34.4499 65.82 31.3023 67.1288 31.0007 67.1288L27.2576 65.6643C26.1496 65.1914 24.6873 64.4347 23.7231 63.8551C23.1599 63.5165 22.6757 63.2171 22.1114 62.8635C21.8147 62.6774 21.6487 62.6089 21.3412 62.4007C12.4201 56.3505 5.7859 46.896 3.66886 36.2633C2.56056 30.6968 2.74408 27.1017 2.74408 21.3249C2.74408 17.77 2.74408 14.2151 2.74408 10.6602H2.74375ZM0.000325398 9.01964V29.2554C0.000325398 36.2604 2.88791 45.5921 6.83075 51.433L9.67863 55.4307C9.92105 55.7534 9.94058 55.7489 10.181 56.0236C10.416 56.2918 10.4316 56.3693 10.6672 56.633C10.8868 56.8789 10.9685 56.9217 11.1898 57.2058C12.8125 59.2882 16.8484 62.6598 18.9281 64.122C21.4047 65.8635 24.6791 67.7068 27.6097 68.8676C28.3184 69.1485 30.2617 70.0003 31 70.0003C33.2856 70.0003 40.8736 65.6676 43.0719 64.122C47.0935 61.2943 48.8816 59.3784 51.8193 56.0236C52.0793 55.7268 52.1375 55.6765 52.3799 55.3518C53.0216 54.4917 53.6256 53.7473 54.237 52.8277C56.0286 50.1317 57.8408 47.0319 58.9621 44.0014C60.5116 39.8134 62.0003 34.6588 62.0003 28.9819V9.01964C62.0003 7.71023 59.1707 7.77186 58.4086 7.67747C56.8877 7.48967 55.5659 7.3129 54.1036 7.04628C47.2204 5.79168 41.2188 4.23057 34.7418 1.46157C30.1162 -0.516012 31.8249 -0.444979 27.3555 1.42135C21.132 4.01974 14.7415 5.92921 8.0344 7.04693C7.26158 7.17569 0.980098 7.89187 0.544065 8.19449C0.357938 8.3239 0 8.74135 0 9.01964H0.000325398Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8323 45.7993V29.9391C17.8323 28.0378 18.9426 26.9311 20.85 26.9311H41.151C43.0584 26.9311 44.1687 28.0378 44.1687 29.9391V45.7993C44.1687 47.7007 43.0584 48.8074 41.151 48.8074H20.85C18.9426 48.8074 17.8323 47.7007 17.8323 45.7993ZM26.7482 22.6924C26.7482 19.9477 29.4386 17.6559 32.6691 18.8414C34.1159 19.3723 35.2525 20.998 35.2525 22.6924V24.1964H26.7482V22.6924ZM21.1243 23.6496V24.1964C19.3158 24.1964 17.9634 24.4005 16.6283 25.731C16.0634 26.294 15.0889 27.9249 15.0889 28.9819V46.7565C15.0889 48.9634 17.6755 51.542 19.8898 51.542H42.1112C44.3252 51.542 46.9121 48.9637 46.9121 46.7565V29.2554C46.9121 26.6719 44.4287 24.1964 41.8369 24.1964H40.8766C40.8766 20.071 39.5978 16.121 35.7123 14.1674C32.5901 12.5979 29.613 12.523 26.4732 14.0773C25.2065 14.7043 24.6559 15.2797 23.6947 16.23C21.8702 18.0334 21.1247 20.9412 21.1247 23.6496H21.1243Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.2969 35.2715C27.2969 36.3029 27.3512 37.1537 28.1514 37.9746C29.0309 38.877 28.8113 38.5075 28.8061 40.1932C28.8028 41.259 28.6779 42.0657 29.1002 42.7715C30.2235 44.6475 32.7239 43.908 33.14 42.3262C33.2979 41.7267 33.1954 39.3473 33.1954 38.553C35.8565 37.1495 34.9639 31.8531 31.1379 31.8531C29.8184 31.8531 28.8262 32.4292 28.1374 33.2378C27.7131 33.7357 27.2969 34.542 27.2969 35.2715Z" fill="black"/>
                </svg>
            </div>
            <div class="card-information">
                <h3>
                    Segurança
                </h3>
                <p class="information-content">
                    Gerenciar configurações de senha, e-mail, número de celular, entre outras.
                </p>
            </div>
        </div>
        <div class="cards" onclick="window.location=''">
            <div class="card-icon">
                <svg width="64" height="59" viewBox="0 0 64 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49998 40.8276L27.9474 34.6024C28.8312 34.3513 29.624 34.1421 30.4852 33.8848L45.5003 29.7432C45.6006 30.957 49.3753 43.3522 49.3753 44.3545C49.3753 44.8173 45.1637 45.8042 44.5982 45.9647L12.0152 55.0764C10.972 55.3856 10.3428 55.6356 9.49999 55.5649L6.47425 44.6323C6.26525 43.8581 5.51865 41.5111 5.49998 40.8276V40.8276ZM55.5004 33.6479C54.6415 33.6479 52.9484 33.2451 52.1005 33.0431C49.8355 32.5039 49.2173 32.8019 49.9003 29.8941C51.0297 25.0852 50.005 25.3347 54.9074 26.3099C58.2472 26.9743 57.7317 26.9529 56.9074 31.1609C56.6951 32.2445 56.6163 33.6479 55.5004 33.6479ZM3.87498 35.4113C3.83779 34.9602 3.70438 34.6207 3.58081 34.1963C3.36198 33.4447 2.62501 30.8795 2.62501 30.373C2.62501 29.8693 3.12251 29.8621 3.51104 29.7543L7.23555 28.7209C15.2656 26.3411 23.9826 24.1289 32.0809 21.7631C33.3478 21.393 41.5527 19.0367 42.1253 19.0367C42.6822 19.0367 42.9214 20.4917 43.1515 21.4035C43.2664 21.8588 43.3852 22.2797 43.5275 22.7882C43.6381 23.1838 43.8341 23.7009 43.8754 24.2011C39.4116 25.249 33.599 27.1803 28.9015 28.3841C24.1021 29.6141 18.6443 31.3764 13.9257 32.5653L8.92786 33.9531C8.04278 34.2046 7.25312 34.4145 6.38958 34.6703C5.7279 34.8664 4.43758 35.1395 3.87503 35.4115L3.87498 35.4113ZM0 30.247C0 31.6836 0.550249 32.8401 0.925581 34.3527L3.94726 45.2894C4.64753 47.7916 5.23944 50.1047 5.94598 52.5963C6.8016 55.6135 7.05742 59.2841 11.4853 57.9432L40.0531 49.9498C41.952 49.4103 49.714 47.4868 50.8259 46.6978C52.8484 45.2628 51.6526 42.3206 51.1109 40.4644C51.0005 40.0861 50.8426 39.5884 50.7504 39.1901C53.1828 39.3941 56.5517 41.4737 58.3572 38.6678C58.896 37.8305 59.9845 31.6925 60.3265 30.1976L61.5006 24.4528L45.7504 21.1779C45.7072 20.6541 45.1061 18.5226 44.7947 17.9843C43.2742 15.3557 40.5341 16.63 37.8899 17.4137C37.2524 17.6026 36.6472 17.7517 35.9281 17.9561C33.0836 18.7643 34.4416 18.6528 31.6778 18.1019C29.7291 17.7135 17.1305 14.8799 16.2502 14.8799C16.1022 15.1907 15.9856 16.0516 15.9001 16.4165C15.7638 16.9982 15.6747 17.4602 15.5527 18.0819L14.5257 22.967C14.2223 24.3251 14.9367 23.868 10.5994 25.0567C8.48798 25.6354 6.54241 26.1661 4.4292 26.7746C2.86774 27.2242 0.000100383 27.6157 0.000100383 30.247H0Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18 8.07805L60.2994 17.0977C61.078 17.2786 62.4632 17.651 63.2504 17.651C63.2884 15.9305 63.9435 14.1652 64.0004 12.6087V12.2021C63.9661 11.3058 63.6861 10.4902 62.9094 9.80721C61.8928 8.91348 56.3693 8.01109 54.9683 7.73236C45.9645 5.94125 36.5057 3.67244 27.5322 1.87364C25.7183 1.5101 23.142 0.772339 21.3751 0.772339C20.0394 0.772339 18.9096 2.04813 18.6573 3.32402C18.4983 4.12829 18.4382 4.77592 18.3049 5.61407C18.163 6.5069 18.0001 7.09379 18.0001 8.078L18 8.07805Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7504 52.5418C12.2271 52.5418 15.8745 51.511 16.5192 51.3012C18.4496 50.673 17.4541 48.895 16.8032 46.5685C15.8671 43.223 15.956 43.8938 11.926 44.9093C8.40394 45.7966 9.10356 45.9688 10.1261 49.896C10.3786 50.8659 10.573 52.5419 11.7504 52.5419L11.7504 52.5418Z" fill="black"/>
                </svg>
            </div>
            <div class="card-information">
                <h3>
                    Cartões
                </h3>
                <p class="information-content">
                    Gerenciar ou adicionar formas de pagamento.
                </p>
            </div>
        </div>
        <div class="adresses" onclick="window.location='address_page.php'">
            <div class="card-icon">
                <svg width="62" height="55" viewBox="0 0 62 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.1322 36.5785C19.1322 35.8655 19.6209 35.6214 20.3433 35.6214H29.6674C30.5331 35.6214 30.8785 35.9626 30.8785 36.8177V52.9666H19.1324V36.5785H19.1322ZM-0.000549396 54.1532V53.7426C0.090437 53.3262 0.470615 52.9668 1.21047 52.9668H5.8119V31.3154C4.53745 31.9195 2.44455 31.3939 1.31299 30.3767C0.353358 29.514 -0.000549396 28.2949 -0.000549396 27.0092C-0.000549396 24.9411 1.65643 23.7572 2.75425 22.673L20.3734 5.26807C21.5534 4.10237 22.6749 2.91451 23.883 1.79692C26.5293 -0.651159 31.4175 -0.58301 34.1196 1.91655C36.1127 3.76057 39.023 6.7646 41.0805 8.79682C41.6954 9.40404 42.2214 9.92391 42.8363 10.5313C43.2601 10.9499 44.3197 11.7369 44.3197 12.4154C44.3197 12.8878 43.7699 13.3723 43.2298 13.3723C42.6181 13.3723 37.2281 7.74252 36.721 7.24164C35.6029 6.13712 33.0944 3.4519 31.8436 2.72927C31.3125 2.42249 30.2559 2.00833 29.4252 2.00833C26.7913 2.00833 25.9588 2.50182 24.188 4.25111L4.63122 23.5701C4.0571 24.1372 3.57462 24.6212 2.99581 25.1843C0.24443 27.8613 3.54237 30.6569 5.7647 29.2355L22.1292 13.1033C23.2486 11.9973 24.2794 10.9793 25.3988 9.87348C28.8304 6.48335 28.6461 6.08058 30.3031 7.72015L35.9944 13.3425C36.6798 14.0194 38.0226 15.1013 38.0226 15.7649C38.0226 16.2375 37.4728 16.7217 36.9327 16.7217C36.1644 16.7217 30.1892 10.0115 28.9406 9.18567C28.3125 9.60131 14.3016 23.587 13.047 24.8261C12.6852 25.1835 7.8702 29.7159 7.8702 30.1193V52.9671H17.0733V36.8181C17.0733 35.1429 18.3281 33.708 19.7375 33.708H30.2725C32.1839 33.708 32.9368 35.6197 32.9368 37.5359V52.9673H41.6554C43.5093 52.9673 43.2351 55.0008 41.8976 55.0008H1.08894C0.483003 55.0008 0.0923593 54.5997 -0.000976562 54.1536L-0.000549396 54.1532Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M48.3155 52.9665C47.5445 52.9665 47.0233 52.9378 46.5018 52.1263C43.5029 47.4581 35.8427 33.1698 35.8427 28.8028C35.8427 26.5117 36.0074 25.2232 37.0202 23.1476C37.1631 22.8549 37.3799 22.5087 37.5428 22.2283C39.0136 19.6992 42.1237 17.4509 45.1541 16.8279C49.3809 15.959 53.4249 17.0386 56.3377 19.9209C58.5808 22.1401 60.0613 25.0827 60.0613 28.3243C60.0613 31.2722 57.8858 35.8228 56.7407 38.5612C56.4958 39.1473 56.2403 39.5115 55.9953 40.0976C54.7576 43.0602 52.6961 46.3191 51.3033 49.0993L49.6427 52.0046C49.376 52.4536 49.0466 52.9663 48.3153 52.9663L48.3155 52.9665ZM61.9992 27.4198V28.5625C61.8537 31.6522 60.5613 34.7204 59.0064 38.2873L51.2625 53.007C50.286 54.694 47.8403 55.5675 45.8401 54.2155C44.7466 53.4764 42.6216 49.4447 41.86 48.099L39.2333 43.2774C37.1351 39.1285 33.7842 32.8103 33.7842 27.9656C33.7842 26.9675 33.9807 25.8916 34.2007 25.0277C34.6648 23.2039 35.8198 20.8381 37.084 19.5025L38.7799 17.8286C39.4728 17.2157 41.0142 16.2038 41.8619 15.8489C44.5923 14.7056 45.5125 14.5682 48.5575 14.5682C52.1338 14.5682 55.4847 16.3272 57.8514 18.6654C58.5024 19.3084 58.9033 19.6802 59.4332 20.4522C61.144 22.9448 61.8915 25.204 61.9987 27.42L61.9992 27.4198Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M40.9296 28.6832C40.9296 24.5109 43.9715 21.5059 48.1953 21.5059C51.7681 21.5059 54.9765 24.5548 54.9765 28.6832C54.9765 32.1949 51.8933 35.382 47.7109 35.382C44.1929 35.382 40.9296 32.166 40.9296 28.6832ZM38.8711 28.4439C38.8711 34.445 45.2055 39.3256 51.6218 36.6138C57.091 34.3022 59.0528 26.7835 54.3428 22.1321C53.6619 21.4594 52.6145 20.7113 51.7066 20.3102C49.2376 19.2192 46.7886 19.234 44.2829 20.2726C41.1438 21.5738 38.8711 25.0232 38.8711 28.4439Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.9799 43.9949C19.9799 44.9108 19.7966 46.0286 21.0698 46.0286C22.4997 46.0286 22.2688 42.9185 21.312 42.9185C20.661 42.9185 19.9801 43.001 19.9801 43.9951L19.9799 43.9949Z" fill="black"/>
                </svg>
            </div>
            <div class="card-information">
                <h3>
                    Endereços
                </h3>
                <p class="information-content">
                    Alterar e gerenciar seus endereços.
                </p>
            </div>
        </div>
        <div class="favorites" onclick="window.location=''">
            <div class="card-icon">
                <svg width="62" height="59" viewBox="0 0 62 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.0129153 17.6996C0.0129153 17.6996 -0.795708 26.22 10.3837 40.0417C14.9097 45.6332 21.9518 51.5814 30.9487 58.9804C30.9879 59.0078 31.0233 59.0078 31.0507 58.9804C40.0477 51.5853 47.0898 45.6332 51.6157 40.0417C62.7951 26.224 61.9865 17.6996 61.9865 17.6996H61.9787C61.9826 17.5741 61.9826 17.4526 61.9826 17.3271C61.9826 7.75975 54.2182 0 44.6364 0C39.1017 0 34.1714 2.58789 30.9958 6.62265C27.8202 2.59181 22.8899 0 17.3552 0C7.77728 0 0.00898996 7.75583 0.00898996 17.3271C0.00898996 17.4526 0.0129153 17.5781 0.0129153 17.6996Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M30.9995 14.1001L34.3243 24.3811L45.1426 24.3615L36.3773 30.6979L39.7413 40.9671L30.9995 34.5993L22.2617 40.9671L25.6218 30.6979L16.8564 24.3615L27.6787 24.3811L30.9995 14.1001Z" fill="white" stroke="white" stroke-width="2.66397" stroke-miterlimit="22.9256" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="card-information">
                <h3>
                    Favoritos
                </h3>
                <p class="information-content">
                    Veja os produtos que você favoritou.
                </p>
            </div>
        </div>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>
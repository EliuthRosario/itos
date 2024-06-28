<?php

session_start();

define("KEY_TOKEN","KTW-tbfs.3762#");
define("MONEDA","$");

define("CLIENT_ID","AbVk6AbkFJjjdDluSZa3mc7UrwpSJIF1gSbaexBdLcLrcELbq-UagOdLG-DJEvpwtaTdLKAMuTJ0hdyw");
define("CURRENCY", "USD");

define("EMAIL", "heliuth8@outlook.es");
define("PASSWORD", "Eliuth2023#");
// &currency=USD

define("SITE_URL","http://localhost/AlmacenItos/view/cliente");

$numCart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $numCart = count($_SESSION['carrito']['productos']);
}

?>
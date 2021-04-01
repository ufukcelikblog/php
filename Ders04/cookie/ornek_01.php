<?php
$isim = "deneme";
$deger = "Benim Adım UFUK";
$zaman = time() + 10;
$yol = "/";
$site = "localhost";
$https = false; // HTTPS ile kullanılır
$_http = true; //veri sadece HTTP üzerinden sunucu üzerinden

setcookie($isim, $deger, $zaman, $yol, $site, $https, $_http);
?>
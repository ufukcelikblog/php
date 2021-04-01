<?php
$dosya = fopen("yenidosya.txt", "a") or die("Doşaya oluşturulamadı");
$metin = "abcdef";
fwrite($dosya, $metin);
$metin = "12345";
fwrite($dosya, $metin);
fclose($dosya);
?>
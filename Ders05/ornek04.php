<?php
$dosya_isim = "deneme.txt";
$icerik = file($dosya_isim, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

print_r($icerik);
?>
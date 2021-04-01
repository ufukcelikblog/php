<?php
$dosya_isim = "deneme.txt";
$dosya = fopen($dosya_isim, "r");
echo "Açılan: ";
echo ftell($dosya) . "\n";

fseek($dosya, 2);
echo "Arama 2: ";
echo ftell($dosya) . "\n";

echo "son: ";
fseek($dosya, 0, SEEK_END);
echo ftell($dosya) . "\n";
?>
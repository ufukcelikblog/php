<!DOCTYPE html>
<html>
<body>
<?php
// while döngüsü ile sayıları basamaklarına ayırma
$sayi = 123456;
$kalan = $sayi;
$basamak = 0;

while($kalan > 0) {
	$basamak++;
	$kalan = intdiv($kalan, 10);
}
echo "Basamak Sayısı : " . $basamak;
?>
</body>
</html>

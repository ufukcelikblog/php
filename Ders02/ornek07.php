<!DOCTYPE html>
<html>
<body>
<?php
// Diziler (array)
for($i=0; $i<10; $i++){
	$dizi[$i] = rand(1,5); // 1-5 arasında rastgele sayı
}
foreach($dizi as $sayi) {
	echo "$sayi <br>";
}
print_r($dizi);
echo "<br><br>";
var_dump($dizi);
?>
</body>
</html>

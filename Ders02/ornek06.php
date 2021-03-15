<!DOCTYPE html>
<html>
<body>
<?php
// Diziler (array)
$arabalar = array("BMW","Fiat","Honda");
foreach($arabalar as $a) {
	echo "$a <br>";
}
$personel = array("Ali"=>35, "Ayşe"=>24, "Cem"=>43);
foreach($personel as $isim=>$yas) {
	echo "$isim = $yas <br>";
}	
?>
</body>
</html>

<!DOCTYPE html>
<html>
<body>
<?php
$yc = 5; // global değişken
$k = 3;

function alan($r) {
	// global değişken
	global $k;
	echo "k değişkeni : " . $k . "<br>"; 
	// buradakiler local değişken
	echo "yc değişkeni : " . $yc . "<br>";
	$alan = pi()*$r*$r;
	echo "Alan = " . $alan . "<br>";
}
echo "alan değişkeni : " . $alan . "<br>";
alan($yc);

echo "k = " . $GLOBALS['k'] . "<br>";

define("SITE_ADI", "www.ufukcelik.com.tr");
echo SITE_ADI . "<br>";

$urun = "masa";
$$urun = "iphone";
echo $urun . " - " . $masa;

?>
</body>
</html>

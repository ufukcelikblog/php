<!DOCTYPE html>
<html>
<body>
<?php
$sayi = 6;
$faktoryel = 1;
for($k=2; $k<=$sayi; $k++) {
	$faktoryel *= $k;
}
echo $sayi . " faktöryel : " . $faktoryel;
?>
</body>
</html>

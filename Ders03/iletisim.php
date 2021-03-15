<html>
<head>
<style>
	.bos {color: #FF0000; }
</style>
</head>
<body>
<?php
$isim = $eposta = $mesaj = "";
$isimHata = $epostaHata = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["isim"])) {
		$isimHata = "İsim bilgisi gereklidir";
	} else {
		$isim = veriTest($_POST["isim"]);
		if(!preg_match("/^[a-zA-Z-' ]*$/", $isim)) {
			$isimHata="Sadece karakter yazınız";
		}

	}
	if(empty($_POST["eposta"])) {
		$epostaHata = "Lütfen e-postanızı yazınız";
	} else {
		$eposta = veriTest($_POST["eposta"]);
		if(!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
			$epostaHata ="Geçersiz e-posta";
		}
	}
}

function veriTest($veri) {
	$veri = trim($veri);
	$veri = stripslashes($veri);
	$veri = htmlspecialchars($veri);
	return $veri;
}
?>

<form method="POST" 
	action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
İSİM: <input type="text" name="isim">
<span class="bos">* <?php echo $isimHata; ?></span><br>
E-POSTA <input type="text" name="eposta">
<span class="bos">* <?php echo $epostaHata; ?></span><br>
MESAJ: <textarea name="mesaj" rows="5" cols="40"></textarea><br>
<input type="submit" value="GÖNDER">
</form>
<?php
echo "BİLGİLER<br>";
echo $isim . "<br>";
echo $eposta . "<br>";
echo $mesaj . "<br>";
?>
</body>
</html>
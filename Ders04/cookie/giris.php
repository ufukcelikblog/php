<?php
	$kad = $_POST["kullanici"];
	$sfr = $_POST["sifre"];
	if($kad == "ufuk" AND $sfr == "123") {
		setcookie("login", "tamam", time()+10);
		echo "Giriş başarılı<br>";
		echo "<a href='mesaj.php'>Gizli Mesajı Göster</a>";
	} else {
		echo "HATALI GİRİŞ !!!<br>";
		echo "<a href='login.php'>Giriş Yap</a>";
	}
?>
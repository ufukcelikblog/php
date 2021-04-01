<?php
	if(@$_COOKIE["login"] == "tamam") {
		echo "İşte gizli mesaj<br>";
		echo "Dünya yuvarlıktır<br>";
		echo "<a href='cikis.php'>ÇIKIŞ YAP</a>";
	} else {
		echo "Lütfen giriş yapınız<br>";
		echo "<a href='giris.php'>GİRİŞ YAP</a>";
	}
?>
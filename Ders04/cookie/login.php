<html>
	<head><title>Login</title></head>
	<body>
	<?php
		if(@$_COOKIE["login"]=="tamam") {
			echo "Giriş başarılı<br>";
			echo "<a href='mesaj.php'>Gizli Mesajı Görüntüle</a><br>";
			echo "<a href='cikis.php'>ÇIKIŞ YAP</a><br>";
		} else {
		?>
			<form action="giris.php" method="POST">
				Kullanıcı: <input type="text" name="kullanici">
				Şifre: <input type="password" name="sifre">
				<input type="submit" value="GİRİŞ YAP">
			</form>
		<?php
		}
	?>
	</body>
</html>



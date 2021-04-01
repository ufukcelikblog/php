<?php
session_start();
$hata = "";
if($_POST) { // formdan bilgi geldi
	$kad = $_POST["kullanici"];
	$sfr = $_POST["sifre"];
	if($kad == "ufuk" AND $sfr == "123") {
		// oturum başlat
		$_SESSION["login"] = "tamam";
		header("Location: index.php");
	} else {
		$hata = "Girilen bilgiler yanlıştır";
	}
}
// çıkış işlemi
if(isset($_GET["islem"]) && $_GET["islem"] == "cikis") {
	session_destroy();
	header("Location: index.php");
}
?>
<html>
<head><title>Session</title><head>
<body>
	<?php 
	if(isset($_SESSION["login"])) {
		// oturum açılmış durumda login ekranını göstermiyoruz
	?>
		<p>Merhaba <h2>HOŞ GELDİNİZ</h2></p>
		<a href="?islem=cikis">ÇIKIŞ YAP</a>
	<?php
	} else {
		// oturum açılmamış, login ekranını gösteriyoruz.
		?>
		<h2><?php echo $hata; ?></h2>
		<form action="index.php" method="POST">
			Kullanıcı: <input type="text" name="kullanici">
			Şifre: <input type="password" name="sifre">
			<input type="submit" value="GİRİŞ YAP">
		</form>
		<?php 
	}
	?>
</body>
</html>
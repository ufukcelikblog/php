<?php
$sunucu = "localhost";
$veritabani = "uyelik";
$kullanici = "root";
$sifre = "";

try {
	$bag = new PDO("mysql:host=$sunucu;dbname=$veritabani", $kullanici, $sifre);
	// PDO hata modlarını ayarlama
	$bag->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Bağlantı başarılı";
	//$bag = null;
} catch(PDOException $hata) {
	echo "Bir hata oluştu: " . $hata->getMessage();
}
<?php
	echo readfile("deneme.txt");
	
	$dosya = "deneme.txt";
	$yeni_dosya = "deneme_kopya.txt";
	copy($dosya, $yeni_dosya);
	
	rename($dosya, "dosyalar/yeni_deneme.txt");
	
	unlink("dosyalar/yeni_deneme.txt")
?>
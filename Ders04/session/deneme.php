<?php
	session_start();
	$_SESSION["isim"] = "Ufuk ÇELİK";
	print_r($_SESSION);
	
	session_destroy(); // oturum sonlandırma
?>
<?php
session_start();
if($_SESSION["login"] != "tamam") {
   header('location:uyelik.php');
}

require "veritabani.php";
if($_SESSION["admin"] == "evet") {
	$sorgu = $bag -> exec("DELETE FROM uye WHERE id = '{$_GET["id"]}' AND tur = '0'");
} else {
	echo "<script>alert('Silme yetkiniz YOK!')</script>";
}
header('location:index.php');

?>

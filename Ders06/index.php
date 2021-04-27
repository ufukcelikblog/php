<?php
session_start();
if($_SESSION["login"] == "tamam") {
	echo "Burası anasayfa";
} else {
	header('location:uyelik.php');
}
?>
<?php
session_start();
if($_SESSION["login"] != "tamam") {
   header('location:uyelik.php');
}

require "veritabani.php";
if($_SESSION["admin"] == "evet") {
	$sorgu = $bag -> exec("DELETE FROM uye WHERE id = '{$_GET["id"]}'");
    echo "<script>alert('Kayıt silinmiştir!')</script>";
} else {
	echo "<script>alert('Silme yetkiniz YOK!')</script>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<title>Silme İşlemi</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h2 class="text-center">SİLME İŞLEMİ</h2>
			<h3 class="text-center">Merhaba 
				<?php echo($_SESSION['ad'] . " " . $_SESSION['soyad']); ?>
			</h3>
            <a href="index.php"><button class="btn btn-primary btn-xs">ANASAYFA</button></a>
		</div>
      </div>   
   </body>
</html>   
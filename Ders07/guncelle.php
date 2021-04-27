<?php
session_start();
if($_SESSION["login"] != "tamam") {
   header('location:uyelik.php');
}
require "veritabani.php";

if(isset($_GET["id"])) {
	$sorgu = $bag->query("SELECT * FROM uye WHERE id = '{$_GET['id']}' ") -> fetch(PDO::FETCH_ASSOC);
	//print_r($sorgu);
}

if(isset($_POST["guncelle"])) {
	$id = $_POST["id"];
	$ad = $_POST["ad"];
	$soyad = $_POST["soyad"];
	$eposta = $_POST["eposta"];
	$sifre = $_POST["sifre"];
	$sorgu = $bag->prepare("UPDATE uye SET ad=:yad, soyad=:ysoyad, eposta=:yeposta, sifre=:ysifre WHERE id='{$id}'");
	$sonuc = $sorgu->execute(array("yad"=>$ad, "ysoyad"=>$soyad, "yeposta"=>$eposta, "ysifre"=>$sifre));
	if($sonuc) {
		header('location:index.php');
	} else {
		echo "<script>alert('HATA !!!')</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Üyelik İşlemleri</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h2 class="text-center">ÜYELİK İŞLEMLERİ</h2>
		</div>
		<div class="card mb-4">
           	<div class="card-header">
          		<i class="fas fa-table mr-1"></i>
           		Üye Güncelleme
           	</div>
			<div class="card-body">
				<div class="well well-lg">
					<form class="form-horizontal" action="" method="post">
						
						<input class="form-control" type="hidden" name="id" value="<?php echo $sorgu['id']; ?>">
					
						<div class="form-group">
							<label class="control-label col-sm-2" for="ad">Ad:</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="ad" value="<?php echo $sorgu['ad']; ?>">	
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="ad">Soyad:</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="soyad" value="<?php echo $sorgu['soyad']; ?>">	
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="eposta">E-posta:</label>
							<div class="col-sm-10">
								<input class="form-control" type="email" name="eposta" value="<?php echo $sorgu['eposta']; ?>">		
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="sifre">Şifre:</label>
							<div class="col-sm-10">
								<input class="form-control" type="password" name="sifre" value="<?php echo $sorgu['sifre']; ?>">	
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-success" name="guncelle">GÜNCELLE</button>
						</div>	
					</form>					
				</div>
			</div>
		</div>
	</div>
</body>
</html>








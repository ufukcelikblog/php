<?php
session_start();
require "veritabani.php";

if(isset($_POST["kayit"])) {
	$ad = $_POST["ad"];
	$soyad = $_POST["soyad"];
	$eposta = $_POST["eposta"];
	$sifre = $_POST["sifre"];
	
	$sorgu = $bag->prepare("SELECT id FROM uye WHERE eposta = ?");
	$sorgu->execute([$eposta]);
	if($sorgu->rowCount() > 0) {
		echo "<script>alert('Bu e-posta ile daha önce kayıt olunmuş')</script>";
	} else {
		$sorgu = $bag->prepare("INSERT INTO uye(ad, soyad, eposta, sifre) VALUES(?,?,?,?)");
		$sorgu->execute(array($ad, $soyad, $eposta, $sifre));
		echo "<script>alert('Kayıt başarılı. Giriş yapabilirsiniz...')</script>";
	}
}

if(isset($_POST["giris"])) {
	$eposta = $_POST["eposta"];
	$sifre = $_POST["sifre"];
	$sorgu = $bag->prepare("SELECT * FROM uye WHERE eposta = ? AND sifre = ?");
	$sonuc = $sorgu->execute(array($eposta, $sifre));
	if($sonuc) {
		echo "<script>alert('Giriş Başarılı')</script>";
		$_SESSION["login"] = "tamam";
		if($sonuc["tur"] == "1") {
			$_SESSION["admin"] = "evet";
		} else {
			$_SESSION["admin"] = "hayır";
		}
		header("Location: index.php");
	} else {
		echo "<script>alert('Hatalı e-posta veya şifre !')</script>";
	}
}

if(isset($_POST["unutma"])) {
	$eposta = $_POST["eposta"];
	$sorgu = $bag->prepare("SELECT sifre FROM uye WHERE eposta = ?");
	$sorgu->execute([$eposta]);
	$unutulanSifre = $sorgu->fetch(PDO::FETCH_ASSOC);
	if($sorgu->rowCount() > 0) {
		$konu = "Şifreniz hakkında";
		$mesaj = "Unuttuğunuz şifreniz : " . $unutulanSifre;
		mail($eposta, $konu, $mesaj, "From: $eposta");
		echo "<script>alert('Şifreniz e-posta adresinze gönderilmiştir.')</script>";
	} else {
		echo "<script>alert('Hatalı e-posta veya şifre !')</script>";
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
			<ul class="nav nav-tabs nav-justified">
				<li>
					<a data-toggle="tab" href="#kayit">
						<h3>Kayıt Ol</h3>
					</a>
				</li>
				<li class="active">
					<a data-toggle="tab" href="#giris">
						<h3>Giriş Yap</h3>
					</a>
				</li>
				<li>
					<a data-toggle="tab" href="#unutma">
						<h3>Şifremi Unuttum</h3>
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="kayit" class="tab-pane fade">
					<div class="well well-lg">
						<form class="form-horizontal" action="" method="post">
							<div class="form-group">
								<label class="control-label col-sm-2" for="ad">Ad:</label>
								<div class="col-sm-10">
									<input class="form-control" type="text" name="ad" placeholder="adınızı yazınız" required>	
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="ad">Soyad:</label>
								<div class="col-sm-10">
									<input class="form-control" type="text" name="soyad" placeholder="soyadınızı yazınız" required>	
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="eposta">E-posta:</label>
								<div class="col-sm-10">
									<input class="form-control" type="email" name="eposta" placeholder="geçerli bir e-posta yazınız" required>	
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="sifre">Şifre:</label>
								<div class="col-sm-10">
									<input class="form-control" type="password" name="sifre" placeholder="şifrenizi yazınız" required>	
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-success" name="kayit">KAYDOL</button>
							</div>	
						</form>
					</div>
				</div>
				
            <div id="giris" class="tab-pane fade in active">
               <div class="well well-lg">
                  <form class="form-horizontal" action="" method="post">
                     <div class="form-group">
                        <label class="control-label col-sm-2" for="eposta">E-posta:</label>
                        <div class="col-sm-10">
                           <input class="form-control" type="email" name="eposta" placeholder="e-posta adresinizi yazınız" required>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="control-label col-sm-2" for="sifre">Şifre:</label>
                        <div class="col-sm-10">
                           <input class="form-control" type="password" name="sifre" placeholder="şifrenizi yazınız" required>	
                        </div>
                     </div>
                     <div class="form-actions">
                        <button type="submit" class="btn btn-success" name="giris">GİRİŞ</button>
                     </div>
                  </form>
               </div>
            </div>

            <div id="unutma" class="tab-pane fade">
               <div class="well well-lg">
                  <form class="form-horizontal" action="" method="post">
                     <div class="form-group">
                        <label class="control-label col-sm-2" for="eposta">E-posta:</label>
                        <div class="col-sm-10">
                           <input class="form-control" type="email" name="eposta" placeholder="kayıtlı olduğunuz e-posta adresinizi yazınız" required>	
                        </div>
                     </div>
                     <div class="form-actions">
                        <button type="submit" class="btn btn-success" name="unutma">GÖNDER</button>
                     </div>
                  </form>
               </div>
				
			</div>
			
			
			
		</div>
	</body>
</html>
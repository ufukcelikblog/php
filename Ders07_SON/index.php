<?php
session_start();
if($_SESSION["login"] != "tamam") {
	header('location:uyelik.php');
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
	<title>Üyelik İşlemleri</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h2 class="text-center">ÜYELER</h2>
			<h3 class="text-center">Merhaba 
				<?php echo($_SESSION['ad'] . " " . $_SESSION['soyad']); ?>
			</h3>
		</div>
		<div class="card mb-4">
			<div class="card-header">
				<i class="fas fa-table mr-1"></i>
				Üyeler Tablosu
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="loginTable" width="100%" cellspacing="0">
						<thead>
							<tr>
							   <th>ID</th>
							   <th>AD</th>
							   <th>SOYAD</th>
							   <th>E-POSTA</th>
							   <th colspan="2">İŞLEM</th>
							</tr>
							<tr>
								<td><?php print $_SESSION["id"]; ?></td>
								<td><?php print $_SESSION["ad"]; ?></td>
								<td><?php print $_SESSION["soyad"]; ?></td>
								<td><?php print $_SESSION["eposta"]; ?></td>
								<td>
									<a href="guncelle.php?id=<?php echo $_SESSION['id']; ?>">
										<button class="btn btn-primary btn-xs">GÜNCELLE</button>
									</a>
								</td>
								<td>
									<a href="sil.php?id=<?php echo $_SESSION['id']; ?>">
										<button class="btn btn-danger btn-xs" onClick="return confirm('Silmek istediğinize emin misiniz?');">SİL</button>
									</a>
								</td>
							</tr>
						</thead>
					</table>
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
							   <th>ID</th>
							   <th>AD</th>
							   <th>SOYAD</th>
							   <th>E-POSTA</th>
							   <?php
								if($_SESSION["admin"]=="evet"){
									?>
									<th colspan="2">İŞLEM</th>
									<?php
								}
							   ?>
							</tr>
						</thead>
						<tfoot>
							<tr>
							   <th>ID</th>
							   <th>AD</th>
							   <th>SOYAD</th>
							   <th>E-POSTA</th>
							   <?php
								if($_SESSION["admin"]=="evet"){
									?>
									<th colspan="2">İŞLEM</th>
									<?php
								}
							   ?>
							</tr>
						</tfoot>
						<tbody>						
						<?php
						require "veritabani.php";
						$sorgu = $bag->query("SELECT * FROM uye WHERE id<>{$_SESSION['id']}", PDO::FETCH_ASSOC);
						foreach($sorgu as $satir) {
						?>
							<tr>
								<td><?php print $satir["id"]; ?></td>
								<td><?php print $satir["ad"]; ?></td>
								<td><?php print $satir["soyad"]; ?></td>
								<td><?php print $satir["eposta"]; ?></td>
								<?php
							   		if($_SESSION['admin']=="evet") { 
										?>
										<td>
											<a href="guncelle.php?id=<?php echo $satir['id']; ?>">
												<button class="btn btn-primary btn-xs">GÜNCELLE</button>
											</a>
										</td>
										<td>
											<a href="sil.php?id=<?php echo $satir['id']; ?>">
												<button class="btn btn-danger btn-xs" onClick="return confirm('Silmek istediğinize emin misiniz?');">SİL</button>
											</a>
										</td>
										<?php 
									}
								?>	
							</tr>
						<?php
						}
						?>
						</tbody>	
					</table>
                    <a href="cikis.php"><button class="btn btn-primary btn-xs">ÇIKIŞ</button></a>
				</div>
           </div>
        </div>
      </div>   
   </body>
</html>   

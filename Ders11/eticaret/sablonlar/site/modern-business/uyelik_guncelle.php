<?php
if ($_SESSION["login"] != "tamam") {
  header("Location: index.php?sayfa=uyelik");
} else {
  $mesaj = "";
  if (isset($_POST["guncelle"])) {
    $id = $_SESSION["id"];
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $sifre = $_POST["sifre"];

    $sorgu = $bag->prepare("UPDATE uye SET ad=:yad, soyad=:ysoyad, sifre=:ysifre WHERE id='{$id}'");
    $sonuc = $sorgu->execute(array("yad" => $ad, "ysoyad" => $soyad, "ysifre" => $sifre));
    if ($sonuc) {
      $mesaj = "Güncelleme Başarılı";
      $_SESSION["login"] = "tamam";
      $_SESSION["ad"] = $ad;
      $_SESSION["soyad"] = $soyad;
      $_SESSION["sifre"] = $sifre;
    } else {
      $mesaj = "Güncellemede bir sorun oluştu!";
    }
  }
  ?>
  <!-- Page Heading/Breadcrumbs -->
  <h1 class="mt-4 mb-3">E-Ticaret Sitesi
    <small><?php echo $baslik; ?></small>
  </h1>

  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="index.php">Anasayfa</a>
    </li>
    <li class="breadcrumb-item active">
      Üyelik Güncelleme
    </li>
  </ol>
  <?php
  if ($mesaj != "") {
    ?>
    <div class="alert alert-primary text-center alert-dismissible fade show" role="alert">
      <strong>MESAJ : </strong> <?php echo $mesaj; ?>
    </div>
    <?php
    if ($mesaj == "Güncelleme Başarılı") {
      ?>
      <script>
        setInterval(
                function () {
                  window.location.href = "index.php?sayfa=uyelik_bilgileri";
                }, 2000
                );
      </script>
      <?php
    }
  }
  ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          Üye #<?php echo $_SESSION["id"]; ?> Bilgi Güncelleme
        </div>
        <div class="card-body">
          <div class="border border-lg rounded shadow-sm">
            <form class="form-horizontal" action="" method="post">
              <div class="p-4 border-bottom">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="ad">Ad:</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="text" name="ad" value="<?php echo $_SESSION["ad"]; ?>" required>	
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="ad">Soyad:</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="text" name="soyad" value="<?php echo $_SESSION["soyad"]; ?>" required>	
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="sifre">Şifre:</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="password" name="sifre" value="<?php echo $_SESSION["sifre"]; ?>" required>	
                  </div>
                </div>
              </div>
              <div class="form-actions bg-light p-4 small">
                <button type="submit" class="btn btn-success btn-block" name="guncelle">GÜNCELLE</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>


  <?php
}
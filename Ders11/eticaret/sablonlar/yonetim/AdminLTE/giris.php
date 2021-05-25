<?php
if ($_SESSION["admin_login"] == "tamam") {
  header("Location: index.php?sayfa=anasayfa");
} else {
  $mesaj = "";
  if (isset($_POST["giris"])) {
    $eposta = $_POST["eposta"];
    $sifre = $_POST["sifre"];
    $sorgu = $bag->prepare("SELECT * FROM uye WHERE tur = 'admin' AND eposta = ? AND sifre = ?");
    $sorgu->execute(array($eposta, $sifre));
    $sonuc = $sorgu->fetch();
    if ($sonuc) {
      $mesaj = "Giriş Başarılı";
      $_SESSION["admin_login"] = "tamam";
      $_SESSION["admin_id"] = $sonuc["id"];
      $_SESSION["admin_ad"] = $sonuc["ad"];
      $_SESSION["admin_soyad"] = $sonuc["soyad"];
    } else {
      $mesaj = "Hatalı e-posta veya şifre girdiniz! Belki de yönetici değilsiniz!!!";
    }
  }
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Giriş</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=anasayfa">Anasayfa</a></li>
              <li class="breadcrumb-item active">Giriş</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
      if ($mesaj != "") {
        ?>
        <div class="alert alert-primary text-center fade show" role="alert">
          <strong>MESAJ : </strong> <?php echo $mesaj; ?>
        </div>
        <?php
        if ($mesaj == "Giriş Başarılı") {
          ?>
          <script>
            setInterval(
                    function () {
                      window.location.href = "index.php";
                    }, 2000
                    );
          </script>
          <?php
        }
      }
      ?>                        
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Üye Giriş</h3>
        </div>
        <form class="form-horizontal" action="" method="post">
          <div class="card-body">
            <div class="form-group">
              <label class="control-label col-sm-2" for="eposta">E-posta:</label>
              <div class="col-sm-12">
                <input class="form-control" type="email" name="eposta" placeholder="e-posta adresinizi yazınız" required>	
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="sifre">Şifre:</label>
              <div class="col-sm-12">
                <input class="form-control" type="password" name="sifre" placeholder="şifrenizi yazınız" required>	
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <div class="form-actions">
              <button type="submit" class="btn btn-primary btn-block" name="giris">GİRİŞ</button>
            </div>
          </div>
        </form>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
}



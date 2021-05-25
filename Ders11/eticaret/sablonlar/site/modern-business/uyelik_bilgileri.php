<?php
if ($_SESSION["login"] != "tamam") {
  header("Location: index.php?sayfa=uyelik");
} else {
  ?>
  <!-- Page Heading/Breadcrumbs -->
  <h1 class="mt-4 mb-3">E-Ticaret Sitesi
    <small>Üyelik Bilgileri</small>
  </h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">
      <a href="index.php">Anasayfa</a>
    </li>
    <li class="breadcrumb-item active">Üyelik Bilgileri</li>
  </ol>

  <div class="card">
    <div class="card-header">
      Üye #<?php echo $_SESSION["id"]; ?> Bilgileri
    </div>
    <div class="card-body">
      <div class="border border-lg rounded-lg shadow-sm">
        <div class="p-4 border-bottom">
          <div class="form-group row bg-white p-3 shadow-sm">
            <label class="col-form-label col-sm-2">AD</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" value="<?php echo $_SESSION["ad"]; ?>" disabled>	
            </div>
          </div>
          <div class="form-group row bg-white p-3 shadow-sm">
            <label class="col-form-label col-sm-2">SOYAD</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" value="<?php echo $_SESSION["soyad"]; ?>" disabled>	
            </div>
          </div>
          <div class="form-group row bg-white p-3 shadow-sm">
            <label class="col-form-label col-sm-2">E-POSTA</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" value="<?php echo $_SESSION["eposta"]; ?>" disabled>	
            </div>
          </div>
          <div class="form-group row bg-white p-3 shadow-sm">
            <label class="col-form-label col-sm-2">ŞİFRE</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" value="<?php echo $_SESSION["sifre"]; ?>" disabled>	
            </div>
          </div>
        </div>  
        <div class="bg-light p-4 small">
          <a href="index.php?sayfa=uyelik_guncelle" class="btn btn-warning btn-block" role="button">Üyelik Güncelle</a>
        </div>
      </div>
    </div>
  </div>


  <?php
}
?>

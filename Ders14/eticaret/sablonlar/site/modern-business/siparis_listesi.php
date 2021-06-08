<?php
if (!isset($_SESSION["login"])) {
  header("Location: index.php?sayfa=uyelik");
} else {
  $uye_id = $_SESSION['id'];
  ?>
  <!-- Page Content-->
  <div class="container">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">E-Ticaret
      <small><?php echo $baslik; ?></small>
    </h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Anasayfa</a>
      </li>
      <li class="breadcrumb-item active">Sipariş Listesi</li>
    </ol>
    <div class="row">
      <div class="col-md-12 ">
        <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <div class="col-md-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Siparişler Tablosu</h3>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Tarih</th>
                        <th>Ürün</th>
                        <th>Adet</th>
                        <th>Fiyat</th>
                        <th>Toplam</th>
                        <th>Durum</th>
                        <th>Kargo Firması</th>
                        <th>Kargo Takip</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $kayitlar = $bag->query("SELECT * FROM siparis WHERE uye_id='{$uye_id}' ORDER BY tarih DESC", PDO::FETCH_ASSOC);
                      foreach ($kayitlar as $kayit):
                        $urun_id = $kayit['urun_id'];
                        $urun_isim = $bag->query("SELECT isim FROM urun WHERE id='{$kayit['urun_id']}'")->fetchColumn();
                        $urun_adet = $kayit['adet'];
                        $urun_fiyat = $bag->query("SELECT fiyat FROM urun WHERE id='{$kayit['urun_id']}'")->fetchColumn();
                        $urun_toplam_fiyat = $urun_adet * $urun_fiyat;
                        ?>
                        <tr>
                          <td><?= $kayit['tarih'] ?></td>
                          <td><a href="index.php?sayfa=urun_inceleme&id=<?= $urun_id ?>"><?= $urun_isim ?></a></td>
                          <td><?= $urun_adet ?></td>
                          <td><?= $urun_fiyat ?></td>
                          <td><?= $urun_toplam_fiyat ?></td>
                          <td><?= $kayit['durum'] ?></td>
                          <td><?= $kayit['kargo_firma'] ?></td>
                          <td><?= $kayit['kargo_takip'] ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a href="?sayfa=anasayfa" class="btn btn-primary float-right">Alışverişe Devam Et</a>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </div>
  </div>
  <?php
}
?>

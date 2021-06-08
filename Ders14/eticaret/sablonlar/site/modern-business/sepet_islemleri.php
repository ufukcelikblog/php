<?php
if (!isset($_SESSION["login"])) {
  header("Location: index.php?sayfa=uyelik");
} else {
  $mesaj = "";
  $id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
  $islem = (isset($_GET['islem']) && $_GET['islem'] != '') ? $_GET['islem'] : '';

  switch ($islem) {
    case "silme":
      $sorgu = "DELETE FROM sepet WHERE id = '{$id}'";
      $silme = $bag->prepare($sorgu);
      $silme->execute();
      if ($silme->rowCount() > 0) {
        $mesaj = "Silme işlemi gerçekleşti";
      } else {
        $mesaj = "Silme işleminde problem oldu!!!";
      }
      break;
    case "temizleme":
      $sorgu = "DELETE FROM sepet WHERE uye_id = '{$_SESSION["id"]}'";
      $silme = $bag->prepare($sorgu);
      $silme->execute();
      if ($silme->rowCount() > 0) {
        $mesaj = "Sepet Temizlendi";
      } else {
        $mesaj = "Temizleme işleminde problem oldu!!!";
      }
      break;
  }
  ?>
<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">E-Ticaret
  <small>Sitesi</small>
</h1>

<ol class="breadcrumb">
  <li class="breadcrumb-item active">
    <a href="index.php">Anasayfa</a>
    <li class="breadcrumb-item active">Sepet İşlemleri</li>
  </li>
</ol>

  <!-- Page Content-->
  <div class="container">
    <?php
    if ($mesaj != "") {
      ?>
      <div class="alert alert-warning text-center fade show" role="alert">
        <strong>MESAJ : </strong> <?php echo $mesaj; ?>
      </div>
      <?php
    }
    ?>
    <div class="row">
      <div class="col-md-12 ">
        <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <div class="col-md-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Alışveriş Sepeti</h3>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Ürün</th>
                        <th>Adet</th>
                        <th>Fiyat</th>
                        <th>Toplam</th>
                        <th>İşlem</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $kayitlar = $bag->query("SELECT * FROM sepet WHERE uye_id='{$_SESSION['id']}'", PDO::FETCH_ASSOC);
                      $sepetToplamAdet = 0;
                      $sepetToplamFiyat = 0;
                      foreach ($kayitlar as $kayit):
                        $urun_id = $kayit['urun_id'];
                        $urun_isim = $bag->query("SELECT isim FROM urun WHERE id='{$kayit['urun_id']}'")->fetchColumn();
                        $urun_adet = $kayit['adet'];
                        $sepetToplamAdet += $urun_adet;
                        $urun_fiyat = $bag->query("SELECT fiyat FROM urun WHERE id='{$kayit['urun_id']}'")->fetchColumn();
                        $urun_toplam_fiyat = $urun_adet * $urun_fiyat;
                        $sepetToplamFiyat += $urun_toplam_fiyat;
                        ?>
                        <tr>
                          <td>
                            <a href="index.php?sayfa=urun_inceleme&id=<?= $urun_id ?>"><?= $urun_isim ?></a>
                          </td>
                          <td>
                            <button type="button" class="btn btn-xs" onclick="sepetAdetAzalt(<?= $kayit['id'] ?>, <?= $urun_fiyat ?>)">
                              <i class="fas fa-minus"></i>
                            </button>
                      <input type="text" id="sepet_<?= $kayit['id'] ?>_adet" value="<?= $urun_adet ?>" size="2" disabled>
                        <button type="button" class="btn btn-xs" onclick="sepetAdetCogalt(<?= $kayit['id'] ?>, <?= $urun_fiyat ?>)">
                          <i class="fas fa-plus"></i>
                        </button>
                        </td>
                        <td id="sepet_<?= $kayit['id'] ?>_fiyat"><?= $urun_fiyat ?></td>
                        <td id="sepet_<?= $kayit['id'] ?>_toplam_fiyat"><?= $urun_toplam_fiyat ?></td>
                        <td>
                          <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-sil" data-href="?sayfa=sepet_islemleri&islem=silme&id=<?= $kayit['id'] ?>">
                            <i class="fas fa-trash"></i>
                            KALDIR
                          </button>
                        </td>
                        </tr>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="row">
                    <div class="col-lg-5 col-md-5 mb-5">
                      <a href="?sayfa=anasayfa" class="btn btn-primary">Alışverişe Devam Et</a>
                      <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-temizle" data-href="?sayfa=sepet_islemleri&islem=temizleme">
                        <i class="fas fa-trash"></i>
                        Sepeti Temizle
                      </button>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4">
                      <h4>Toplam Fiyat: <b id="sepetToplamFiyat"><?= $sepetToplamFiyat ?></b></h4>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3">
                      <a href="?sayfa=siparis_islemleri" class="btn btn-success float-md-none">Sipariş Ver</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <div class="modal fade" id="modal-sil">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Sepetten Ürün Çıkartmak</h4>
            </div>
            <div class="modal-body">
              <p>Sepetten ürünü çıkartmak istediğinize emin misiniz?</p>
              <p>Bu işlem geri alınamaz!</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                <i class="fas fa-undo"></i>
                Vazgeç
              </button>
              <a href="#" id="modalLink">
                <button type="button" class="btn btn-outline-light">
                  <i class="fas fa-trash"></i>
                  SİL
                </button>
              </a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="modal-temizle">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Sepeti Temizleme</h4>
            </div>
            <div class="modal-body">
              <p>Sepeti temizleyip tüm ürünleri çıkartmak istediğinize emin misiniz?</p>
              <p>Bu işlem geri alınamaz!</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                <i class="fas fa-undo"></i>
                Vazgeç
              </button>
              <a href="#" id="modalLink">
                <button type="button" class="btn btn-outline-light">
                  <i class="fas fa-trash"></i>
                  TEMİZLE
                </button>
              </a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
  </div>
  <?php
}
?>

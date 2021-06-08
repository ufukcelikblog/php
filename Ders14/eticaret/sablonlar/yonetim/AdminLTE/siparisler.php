<?php
if (!isset($_SESSION["admin_login"])) {
  header("Location: index.php?sayfa=giris");
} else {
  if (isset($_POST["kargo"])) {
    $siparis_id = $_POST["siparis_id"];
    $siparis_durum = $_POST["siparis_durum"];
    $kargo_firma = isset($_POST["kargo_firma"]) ? $_POST["kargo_firma"] : "";
    $kargo_takip = isset($_POST["kargo_takip"]) ? $_POST["kargo_takip"] : "";
    $sorgu = $bag->prepare("UPDATE siparis SET durum=:d, kargo_firma=:f, kargo_takip=:t WHERE id='{$siparis_id}'");
    $sorgu->execute(array("d" => $siparis_durum, "f" => $kargo_firma, "t" => $kargo_takip));
  }
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Anasayfa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
              <li class="breadcrumb-item">Siparişler</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
      $tarihler = $bag->query("SELECT DATE(tarih) AS gun FROM siparis GROUP BY gun")->fetchAll(PDO::FETCH_ASSOC);
      foreach ($tarihler as $tarih):
        ?>
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= $tarih["gun"] ?> Tarihindeki Siparişler</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Aç/Kapat">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Saat</th>
                  <th>Üye</th>
                  <th>Ürün</th>
                  <th>Adet</th>
                  <th>Tutar</th>
                  <th>Durum</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $kayitlar = $bag->query("SELECT * FROM siparis WHERE DATE(tarih)='{$tarih["gun"]}'", PDO::FETCH_ASSOC);
                foreach ($kayitlar as $kayit):
                  $saat = $bag->query("SELECT TIME(tarih) FROM siparis WHERE id='{$kayit['id']}'")->fetchColumn();
                  $uye = $bag->query("SELECT CONCAT(ad, ' ', soyad) AS isim FROM uye WHERE id='{$kayit['uye_id']}'")->fetchColumn();
                  $urun_isim = $bag->query("SELECT isim FROM urun WHERE id='{$kayit['urun_id']}'")->fetchColumn();
                  $urun_adet = $kayit['adet'];
                  $urun_fiyat = $bag->query("SELECT fiyat FROM urun WHERE id='{$kayit['urun_id']}'")->fetchColumn();
                  $urun_toplam_fiyat = $urun_adet * $urun_fiyat;
                  ?>
                  <tr data-widget="expandable-table" aria-expanded="false">
                    <td><?= $kayit["id"] ?></td>
                    <td><?= $saat ?></td>
                    <td><?= $uye ?></td>
                    <td><?= $urun_isim ?></td>
                    <td><?= $urun_adet ?></td>
                    <td><?= $urun_toplam_fiyat ?></td>
                    <td><?= $kayit['durum'] ?></td>
                  </tr>
                  <tr class="expandable-body">
                    <td colspan="7">
                <div class="content">
                  <form action="?sayfa=siparisler" method="post">
                    <input type="hidden" id="siparis_id" name="siparis_id" value="<?= $kayit['id'] ?>">
                      <div class="row">
                        <div class="col-md-3 mb-3">
                          <label for="siparis_durum">Durum</label>
                          <select name="siparis_durum" class="form-control">
                            <option value="Onay Bekliyor" <?= $kayit['durum'] == "Onay Bekliyor" ? "selected" : "" ?>>Onay Bekliyor</option>
                            <option value="Onaylandı" <?= $kayit['durum'] == "Onaylandı" ? "selected" : "" ?>>Onaylandı</option>
                            <option value="Kargoya Verildi" <?= $kayit['durum'] == "Kargoya Verildi" ? "selected" : "" ?>>Kargoya Verildi</option>
                          </select>
                          <small class="text-muted">Sipariş Durum Bilgisi</small>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="kargo_firma">Kargo Firması</label>
                          <input type="text" class="form-control" id="kargo_firma" name="kargo_firma" placeholder="<?= $kayit['kargo_firma'] ?>">
                            <small class="text-muted">Kargo Firma Bilgisi</small>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="kargo_takip">Kargo Takip Numarası</label>
                          <input type="text" class="form-control" id="kargo_takip" name="kargo_takip" placeholder="<?= $kayit['kargo_takip'] ?>">
                            <small class="text-muted">Kargo Takip Numarası Bilgisi</small>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="kargo_takip">İşlem</label>
                          <button class="btn btn-secondary btn-block" type="submit" name="kargo">
                            <i class="fas fa-edit"></i>
                            GÜNCELLE
                          </button>
                          <small class="text-muted">Sipariş Bilgileri Güncelleme</small>
                        </div>
                      </div>                        
                  </form>
                </div>
                </td>
                </tr>
                <?php
              endforeach;
              ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <?php
      endforeach;
      ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
}
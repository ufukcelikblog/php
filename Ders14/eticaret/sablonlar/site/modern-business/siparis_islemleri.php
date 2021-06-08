<?php
if (!isset($_SESSION["login"])) {
  header("Location: index.php?sayfa=uyelik");
} else {
  $uye_id = $_SESSION['id'];
  if (isset($_POST["siparis"])) {
    $adres_id = $_POST["adres_id"];
    $kayitlar = $bag->query("SELECT * FROM sepet WHERE uye_id='{$uye_id}'", PDO::FETCH_ASSOC);
    foreach ($kayitlar as $kayit):
      $sorgu = $bag->prepare("INSERT INTO siparis(uye_id, adres_id, urun_id, adet) VALUES(?,?,?,?)");
      $sorgu->execute(array($uye_id, $adres_id, $kayit['urun_id'], $kayit['adet']));
    endforeach;
    $sorgu = "DELETE FROM sepet WHERE uye_id = '{$uye_id}'";
    $silme = $bag->prepare($sorgu);
    $silme->execute();
    header("Location: index.php?sayfa=siparis_listesi");
  }
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
      <li class="breadcrumb-item active">Sipariş İşlemleri</li>
    </ol>
    <?php
    $sepetAdet = $bag->query("SELECT COUNT(*) FROM sepet WHERE uye_id='{$uye_id}'")->fetchColumn();
    if ($sepetAdet > 0) {
      ?>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Sepetiniz</span>
          </h4>
          <ul class="list-group mb-3">
            <?php
            $kayitlar = $bag->query("SELECT * FROM sepet WHERE uye_id='{$uye_id}'", PDO::FETCH_ASSOC);
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
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0"><?= $urun_isim ?></h6>
                  <small class="text-muted"><?= $urun_fiyat ?> TL x <?= $urun_adet ?> Adet</small>
                </div>
                <span class="text-muted"><?= $urun_toplam_fiyat ?> TL</span>
              </li>
              <?php
            endforeach;
            ?>
            <li class="list-group-item list-group-item-warning d-flex justify-content-between">
              <span>Toplam <?= $sepetToplamAdet ?> Ürün</span>
              <strong><?= $sepetToplamFiyat ?> TL</strong>
            </li>
          </ul>
        </div>
        <div class="col-md-8 order-md-1">
          <?php
          $sorgu = "SELECT COUNT(*) FROM adres WHERE uye_id = '{$uye_id}'";
          $adet = $bag->query($sorgu)->fetchColumn();
          if ($adet > 0) {
            ?>
            <h4 class="mb-3">Adres Bilgileri</h4>
            <form action="?sayfa=siparis_islemleri" method="post" class="needs-validation">
              <?php
              $sorgu = "SELECT * FROM adres WHERE uye_id = '{$uye_id}'";
              $kayitlar = $bag->query($sorgu, PDO::FETCH_ASSOC);
              foreach ($kayitlar as $kayit):
                ?>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="adres_id" id="adres_<?= $kayit["id"] ?>" value="<?= $kayit["id"] ?>" required>
                    <label class="form-check-label" for="adres_<?= $kayit["id"] ?>">
                      <?php
                      echo $kayit["adres"] . " " . $kayit["sehir"] . " / " . $kayit["ilce"] . " " . $kayit["postakodu"];
                      ?>
                    </label>
                    &nbsp;
                    <a href="index.php?sayfa=adres_islemleri&islem=guncellemeBaslat&id=<?= $kayit['id'] ?>&adres=<?= $kayit['adres'] ?>&sehir=<?= $kayit['sehir'] ?>&ilce=<?= $kayit['ilce'] ?>&postakodu=<?= $kayit['postakodu'] ?>" class="btn btn-light btn-xs">                   
                      <i class="fas fa-edit"></i>
                    </a>
                </div>
                <?php
              endforeach;
              ?>
              <a href="index.php?sayfa=adres_islemleri" class="btn btn-secondary btn-xs">              
                <i class="fas fa-address-book"></i> Yeni Adres Girişi
              </a>

              <hr class="mb-4">

              <h4 class="mb-3">Ödeme</h4>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="cc-isim">Kredi kartı üzerindeki isim</label>
                  <input type="text" class="form-control" id="cc-isim" name="cc-isim" placeholder="" required>
                    <small class="text-muted">Kredi kartı üzerindeki tam isim</small>
                    <div class="invalid-feedback">
                      Kredi kartı üzerindeki isimi yazınız
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cc-no">Kredi kartı numarası</label>
                  <input type="text" class="form-control" id="cc-no" placeholder="" required>
                    <div class="invalid-feedback">
                      Kredi numarasını yazınız
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label for="cc-gecerlilik">Geçerlilik Süresi</label>
                  <input type="text" class="form-control" id="cc-gecerlilik" name="cc-gecerlilik" placeholder="AA/YY" required>
                    <div class="invalid-feedback">
                      Kredi kartı geçerlilik süresini yazınız
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="cc-cvv">CVV</label>
                  <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required>
                    <div class="invalid-feedback">
                      3 haneli güvenlik kodunu yazınız
                    </div>
                </div>
              </div>
              <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" type="submit" name="siparis">Siparişi Tamamla</button>
            </form>
            <?php
          } else {
            ?>
            <div class="alert alert-danger" role="alert">
              Adres bilgileriniz bulunamadı. Lütfen bir adres girişi yapınız.
            </div>
            <a href="index.php?sayfa=adres_islemleri">
              <button class="btn btn-secondary btn-xs">
                <i class="fas fa-search"></i> Yeni Adres Girişi
              </button>
            </a>
            <?php
          }
          ?>
        </div>
      </div>
      <?php
    } else {
      ?>
      <div class="alert alert-danger" role="alert">
        Sepetiniz BOŞ. Lütfen sepete ürün ekleyin.
      </div>
      <a href="index.php?sayfa=anasayfa">
        <button class="btn btn-secondary btn-xs">
          <i class="fas fa-search"></i> Alışverişe Devam Et
        </button>
      </a>
      <?php
    }
    ?>
  </div>
  <?php
}
?>

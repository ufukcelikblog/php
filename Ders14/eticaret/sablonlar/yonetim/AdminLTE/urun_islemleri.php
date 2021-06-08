<?php
if (!isset($_SESSION["admin_login"])) {
  header("Location: index.php?sayfa=giris");
} else {
  $mesaj = "";
  $buttonText = "EKLE";
  $islemBaslik = "Yeni Ürün";
  $islem = (isset($_GET['islem']) && $_GET['islem'] != '') ? $_GET['islem'] : '';
  $id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
  $kategori_id = (isset($_GET['kategori_id']) && $_GET['kategori_id'] != '') ? $_GET['kategori_id'] : '';
  $isim = (isset($_GET['isim']) && $_GET['isim'] != '') ? $_GET['isim'] : '';
  $fiyat = (isset($_GET['fiyat']) && $_GET['fiyat'] != '') ? $_GET['fiyat'] : '';
  $durum = (isset($_GET['durum']) && $_GET['durum'] != '') ? $_GET['durum'] : '';
  $aciklama = (isset($_GET['aciklama']) && $_GET['aciklama'] != '') ? $_GET['aciklama'] : '';

  switch ($islem) {
    case "silme":
      $sorgu = "DELETE FROM urun WHERE id = '{$id}'";
      $silme = $bag->prepare($sorgu);
      $silme->execute();
      if ($silme->rowCount() > 0) {
        $mesaj = "Silme işlemi gerçekleşti";
      } else {
        $mesaj = "Silme işleminde problem oldu!!!";
      }
      break;
    case "ekleme":
      $islemBaslik = "Yeni Ürün";
      $sorgu = "SELECT COUNT(*) FROM urun WHERE isim='{$isim}' AND kategori_id='{$kategori_id}'";
      $adet = $bag->query($sorgu)->fetchColumn();
      if ($adet > 0) {
        $mesaj = "Bu ürün daha önce oluşturulmuş!!!";
      } else {
        $sorgu = $bag->prepare("INSERT INTO urun(kategori_id, isim, fiyat, durum, aciklama) VALUES(?,?,?,?,?)");
        $sorgu->execute(array($kategori_id, $isim, $fiyat, $durum, $aciklama));
        $mesaj = "Yeni bir ürün eklendi...";
      }
      break;
    case "guncellemeBaslat":
      if ($id != '' && $kategori_id != '' && $isim != '' && $fiyat != '' && $durum != '' && $aciklama != '') {
        $islem = "guncellemeYap";
        $islemBaslik = "Ürün Güncelleme";
        $buttonText = "GÜNCELLE";
      } else {
        $mesaj = "Güncelleme için veriler eksik !!!";
      }
      break;
    case "guncellemeYap":
      $sorgu = $bag->prepare("UPDATE urun SET kategori_id=:k, isim=:i, fiyat=:f, durum=:d, aciklama=:a WHERE id='{$id}'");
      $sonuc = $sorgu->execute(array("k" => $kategori_id, "i" => $isim, "f" => $fiyat, "d" => $durum, "a" => $aciklama));
      if ($sonuc) {
        $mesaj = "Güncelleme işlemi gerçekleşti";
      } else {
        $mesaj = "Güncelleme işleminde bir hata oluştu";
      }
      $islem = "ekleme";
      $islemBaslik = "Yeni Ürün";
      unset($id, $kategori_id, $isim, $fiyat, $durum, $aciklama);
      break;
    default :
      $buttonText = "EKLE";
      $islemBaslik = "Yeni Ürün";
      $islem = "ekleme";
      break;
  }
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ürün İşlemleri</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=anasayfa">Anasayfa</a></li>
              <li class="breadcrumb-item"><a href="index.php?sayfa=urun_islemleri">Ürün İşlemleri</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php
        if ($mesaj != "") {
          ?>
          <div class="alert alert-warning text-center fade show" role="alert">
            <strong>MESAJ : </strong> <?php echo $mesaj; ?>
          </div>
          <?php
        }
        ?>
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><?php echo $islemBaslik; ?></h3>
            </div>
            <!-- form start -->
            <form class="form-horizontal" method="get" action="">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="hidden" name="sayfa" class="form-control" value="urun_islemleri"/>
                      <input type="hidden" name="islem" class="form-control" value="<?php echo $islem; ?>"/>
                      <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>"/>  
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kategori</label>
                      <div class="col-sm-10">
                        <select name="kategori_id" class="form-control">
                          <?php
                          $kategoriler_AZ = $bag->query("SELECT * FROM kategori ORDER BY ust_id, id", PDO::FETCH_ASSOC);
                          foreach ($kategoriler_AZ as $kayit):
                            $secilmeDurum = $kayit["id"] == $kategori_id ? "selected" : "";
                            ?>
                            <option value="<?= $kayit["id"] ?>" <?= $secilmeDurum ?>><?= $kayit["ust_isim"] . " > " . $kayit["isim"] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">İsim</label>
                      <div class="col-sm-10">
                        <input type="text" name="isim" class="form-control"
                        <?php
                        if ($islem == "guncellemeYap") {
                          echo 'value="' . $isim . '"';
                        } else {
                          echo 'placeholder="Ürün ismi giriniz" required';
                        }
                        ?>                               
                               >
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Satış Fiyat</label>
                      <div class="col-sm-10">
                        <input type="text" name="fiyat" class="form-control"
                        <?php
                        if ($islem == "guncellemeYap") {
                          echo 'value="' . $fiyat . '"';
                        } else {
                          echo 'placeholder="Satış fiyatı değerini giriniz..." required';
                        }
                        ?>                               
                               >
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Durum</label>
                      <div class="col-sm-10">
                        <select name="durum" class="form-control">
                          <option value="Satışta" <?php echo $durum == "Satışta" ? "selected" : "" ?>>Satışta</option>
                          <option value="Beklemede" <?php echo $durum == "Beklemede" ? "selected" : "" ?>>Beklemede</option>
                          <option value="Stokta Yok" <?php echo $durum == "Stokta Yok" ? "selected" : "" ?>>Stokta Yok</option>
                          <option value="Kampanya" <?php echo $durum == "Kampanya" ? "selected" : "" ?>>Kampanya</option>
                        </select>
                      </div>
                    </div>
                    <!-- /.form-group -->                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Açıklama</label>
                      <textarea name="aciklama" rows="7" cols="10" class="form-control" required><?php echo $islem == "guncellemeYap" ? $aciklama : ""; ?></textarea>
                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block"><?php echo $buttonText; ?></button>
              </div>
              <!-- /.card-footer -->

            </form>    
            <!-- form finish -->
          </div> 
          <!-- /.card -->
        </div>
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Ürünler Tablosu</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 300px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th class="text-center">İŞLEMLER</th>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>İsim</th>
                    <th>Fiyat</th>
                    <th>Durum</th>
                    <th>Açıklama</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $urunler_ZA = $bag->query("SELECT * FROM urun ORDER BY id DESC", PDO::FETCH_ASSOC);
                  foreach ($urunler_ZA as $urun):
                    ?>
                    <tr>
                      <td class="text-center">
                        <a href="index.php?sayfa=urun_islemleri&islem=guncellemeBaslat&kategori_id=<?= $urun['kategori_id'] ?>&id=<?= $urun['id'] ?>&isim=<?= $urun['isim'] ?>&fiyat=<?= $urun['fiyat'] ?>&durum=<?= $urun['durum'] ?>&aciklama=<?= $urun['aciklama'] ?>">
                          <button class="btn btn-info btn-xs">
                            <i class="fas fa-pencil-alt"></i>
                            GÜNCELLEME
                          </button>
                        </a>
                        -
                        <a href="index.php?sayfa=urun_ozellikleri&urun_id=<?= $urun['id'] ?>&urun_isim=<?= $urun['isim'] ?>">
                          <button class="btn btn-secondary btn-xs">
                            <i class="fas fa-list"></i>
                            ÖZELLİKLER
                          </button>
                        </a>
                        -
                        <a href="index.php?sayfa=urun_resimleri&urun_id=<?= $urun['id'] ?>&urun_isim=<?= $urun['isim'] ?>">
                          <button class="btn btn-warning btn-xs">
                            <i class="fas fa-images"></i>
                            RESİMLER
                          </button>
                        </a>
                        -
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-sil">
                          <i class="fas fa-trash"></i>
                          SİL
                        </button>
                      </td>
                      <td><?= $urun["id"] ?></td>
                      <?php
                      $kayit = $bag->query("SELECT * FROM kategori WHERE id='{$urun["kategori_id"]}'")->fetch(PDO::FETCH_ASSOC);
                      $urun_kategori = $kayit["ust_isim"] . " > " . $kayit["isim"];
                      ?>
                      <td><?= $urun_kategori; ?></td>
                      <td><?= $urun["isim"] ?></td>
                      <td><?= $urun["fiyat"] ?></td>
                      <td><?= $urun["durum"] ?></td>
                      <td><?= $urun["aciklama"] ?></td>
                    </tr>
                    <?php
                  endforeach;
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <?php
              $sorgu = "SELECT COUNT(*) FROM urun";
              $adet = $bag->query($sorgu)->fetchColumn();
              echo "Toplam " . $adet . " ürün bulunmaktadır...";
              ?>
            </div>
          </div>
        </div>
      </div>        

      <!-- /.container-fluid -->
      <div class="modal fade" id="modal-sil">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Ürün Silme</h4>
            </div>
            <div class="modal-body">
              <p>Silmek istediğinize emin misiniz?</p>
              <p>Bu işlem geri alınamaz!</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                <i class="fas fa-undo"></i>
                Vazgeç
              </button>
              <a href="index.php?sayfa=urun_islemleri&islem=silme&id=<?= $urun['id'] ?>">
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
    </section>
  </div>
  <?php
}


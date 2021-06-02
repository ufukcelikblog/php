<?php
if ($_SESSION["login"] != "tamam") {
  header("Location: index.php?sayfa=giris");
} else {
  $mesaj = "";
  $buttonText = "EKLE";
  $islemBaslik = "Yeni Adres";
  $islem = (isset($_GET['islem']) && $_GET['islem'] != '') ? $_GET['islem'] : '';
  $id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
  $uye_id = $_SESSION["id"];
  $adres = (isset($_GET['adres']) && $_GET['adres'] != '') ? $_GET['adres'] : '';
  $sehir = (isset($_GET['sehir']) && $_GET['sehir'] != '') ? $_GET['sehir'] : '';
  $ilce = (isset($_GET['ilce']) && $_GET['ilce'] != '') ? $_GET['ilce'] : '';
  $postakodu = (isset($_GET['postakodu']) && $_GET['postakodu'] != '') ? $_GET['postakodu'] : '';

  switch ($islem) {
    case "silme":
      $sorgu = "DELETE FROM adres WHERE id = '{$id}'";
      $silme = $bag->prepare($sorgu);
      $silme->execute();
      if ($silme->rowCount() > 0) {
        $mesaj = "Silme işlemi gerçekleşti";
      } else {
        $mesaj = "Silme işleminde problem oldu!!!";
      }
      break;
    case "ekleme":
      $islemBaslik = "Yeni Adres";
      $sorgu = $bag->prepare("INSERT INTO adres(uye_id, adres, sehir, ilce, postakodu) VALUES(?,?,?,?,?)");
      $sorgu->execute(array($uye_id, $adres, $sehir, $ilce, $postakodu));
      $mesaj = "Yeni bir adres eklendi...";
      break;
    case "guncellemeBaslat":
      if ($id != '' && $adres != '' && $sehir != '' && $ilce != '' && $postakodu != '') {
        $islem = "guncellemeYap";
        $islemBaslik = "Özellik Güncelleme";
        $buttonText = "GÜNCELLE";
      } else {
        $mesaj = "Güncelleme için veriler eksik !!!";
      }
      break;
    case "guncellemeYap":
      $sorgu = $bag->prepare("UPDATE adres SET adres=?, sehir=?, ilce=?, postakodu=? WHERE uye_id='{$uye_id}'");
      $sonuc = $sorgu->execute(array($adres, $sehir, $ilce, $postakodu));
      if ($sonuc) {
        $mesaj = "Güncelleme işlemi gerçekleşti";
      } else {
        $mesaj = "Güncelleme işleminde bir hata oluştu";
      }
      $islem = "ekleme";
      $islemBaslik = "Yeni Adres";
      unset($id, $adres, $sehir, $ilce, $postakodu);
      break;      
    default :
      $buttonText = "EKLE";
      $islemBaslik = "Yeni Adres";
      $islem = "ekleme";
      break;
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
      <li class="breadcrumb-item active">Adres İşlemleri</li>
    </ol>
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
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Üye #<?= $uye_id ?> - <?= $islemBaslik ?></h3>
            </div>
            <!-- form start -->
            <form class="form-horizontal" method="get" action="">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="hidden" name="sayfa" class="form-control" value="adres_islemleri"/>
                      <input type="hidden" name="islem" class="form-control" value="<?php echo $islem; ?>"/>
                      <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>"/>  
                    </div>
                    <div class="mb-3">
                      <label for="adres">Adres</label>
                      <input type="text" name="adres" class="form-control"
                      <?php
                      if ($islem == "guncellemeYap") {
                        echo 'value="' . $adres . '"';
                      } else {
                        echo 'placeholder="Adres bilgisi giriniz" required';
                      }
                      ?>                               
                             >
                    </div>
                    <div class="row">
                      <div class="col-md-5 mb-3">
                        <label for="sehir">Şehir</label>
                        <input type="text" name="sehir" class="form-control"
                        <?php
                        if ($islem == "guncellemeYap") {
                          echo 'value="' . $sehir . '"';
                        } else {
                          echo 'placeholder="Şehir ismi giriniz" required';
                        }
                        ?>                               
                               >
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="ilce">İlçe</label>
                        <input type="text" name="ilce" class="form-control"
                        <?php
                        if ($islem == "guncellemeYap") {
                          echo 'value="' . $ilce . '"';
                        } else {
                          echo 'placeholder="İlçe bilgisi giriniz..." required';
                        }
                        ?>                               
                               >
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="postakodu">Posta Kodu</label>
                        <input type="text" name="postakodu" class="form-control"
                        <?php
                        if ($islem == "guncellemeYap") {
                          echo 'value="' . $postakodu . '"';
                        } else {
                          echo 'placeholder="Posta Kodu giriniz" required';
                        }
                        ?>                               
                               >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block"><?php echo $buttonText; ?></button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Adresler Tablosu</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 300px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th class="text-center">İŞLEMLER</th>
                    <th>ID</th>
                    <th>Adres</th>
                    <th>Şehir</th>
                    <th>İlçe</th>
                    <th>Posta Kodu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $adresler = $bag->query("SELECT * FROM adres WHERE uye_id = '{$uye_id}'", PDO::FETCH_ASSOC);
                  foreach ($adresler as $kayit):
                    ?>
                    <tr>
                      <td class="text-center">
                        <a href="index.php?sayfa=adres_islemleri&islem=guncellemeBaslat&id=<?= $kayit['id'] ?>&adres=<?= $kayit['adres'] ?>&sehir=<?= $kayit['sehir'] ?>&ilce=<?= $kayit['ilce'] ?>&postakodu=<?= $kayit['postakodu'] ?>">
                          <button class="btn btn-info btn-xs">
                            <i class="fas fa-pencil-alt"></i>
                            GÜNCELLEME
                          </button>
                        </a>
                        -
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-sil" data-href="index.php?sayfa=adres_islemleri&islem=silme&id=<?= $kayit['id'] ?>">
                          <i class="fas fa-trash"></i>
                          SİL
                        </button>
                      </td>
                      <td><?= $kayit["id"] ?></td>
                      <td><?= $kayit["adres"] ?></td>
                      <td><?= $kayit["sehir"] ?></td>
                      <td><?= $kayit["ilce"] ?></td>
                      <td><?= $kayit["postakodu"] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <?php
              $sorgu = "SELECT COUNT(*) FROM adres WHERE uye_id = '{$uye_id}'";
              $adet = $bag->query($sorgu)->fetchColumn();
              echo "Toplam " . $adet . " adres bulunmaktadır...";
              ?>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
        <div class="modal fade" id="modal-sil">
          <div class="modal-dialog">
            <div class="modal-content bg-danger">
              <div class="modal-header">
                <h4 class="modal-title">Adres Silme</h4>
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
      </div>
    </div>  
  </div>
  <!-- /.container -->
  <?php
}
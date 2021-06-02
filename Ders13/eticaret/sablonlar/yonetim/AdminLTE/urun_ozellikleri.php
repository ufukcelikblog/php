<?php
if ($_SESSION["admin_login"] != "tamam") {
  header("Location: index.php?sayfa=giris");
} else {
  $mesaj = "";
  $buttonText = "EKLE";
  $islemBaslik = "Yeni Özellik";
  $islem = (isset($_GET['islem']) && $_GET['islem'] != '') ? $_GET['islem'] : '';
  $id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
  $urun_id = (isset($_GET['urun_id']) && $_GET['urun_id'] != '') ? $_GET['urun_id'] : '';
  $urun_isim = (isset($_GET['urun_isim']) && $_GET['urun_isim'] != '') ? $_GET['urun_isim'] : '';
  $ozellik = (isset($_GET['ozellik']) && $_GET['ozellik'] != '') ? $_GET['ozellik'] : '';
  $bilgi = (isset($_GET['bilgi']) && $_GET['bilgi'] != '') ? $_GET['bilgi'] : '';

  switch ($islem) {
    case "silme":
      $sorgu = "DELETE FROM urun_ozellik WHERE id = '{$id}'";
      $silme = $bag->prepare($sorgu);
      $silme->execute();
      if ($silme->rowCount() > 0) {
        $mesaj = "Silme işlemi gerçekleşti";
      } else {
        $mesaj = "Silme işleminde problem oldu!!!";
      }
      break;
    case "ekleme":
      $islemBaslik = "Yeni Özellik";
      $sorgu = "SELECT COUNT(*) FROM urun_ozellik WHERE ozellik='{$ozellik}' AND urun_id='{$urun_id}'";
      $adet = $bag->query($sorgu)->fetchColumn();
      if ($adet > 0) {
        $mesaj = "Bu özellik daha önce oluşturulmuş!!!";
      } else {
        $sorgu = $bag->prepare("INSERT INTO urun_ozellik(urun_id, ozellik, bilgi) VALUES(?,?,?)");
        $sorgu->execute(array($urun_id, $ozellik, $bilgi));
        $mesaj = "Yeni bir özellik eklendi...";
      }
      break;
    case "guncellemeBaslat":
      if ($id != '' && $urun_id != '' && $ozellik != '' && $bilgi != '') {
        $islem = "guncellemeYap";
        $islemBaslik = "Özellik Güncelleme";
        $buttonText = "GÜNCELLE";
      } else {
        $mesaj = "Güncelleme için veriler eksik !!!";
      }
      break;
    case "guncellemeYap":
      $sorgu = $bag->prepare("UPDATE urun_ozellik SET urun_id=:u, ozellik=:o, bilgi=:b WHERE id='{$id}'");
      $sonuc = $sorgu->execute(array("u" => $urun_id, "o" => $ozellik, "b" => $bilgi));
      if ($sonuc) {
        $mesaj = "Güncelleme işlemi gerçekleşti";
      } else {
        $mesaj = "Güncelleme işleminde bir hata oluştu";
      }
      $islem = "ekleme";
      $islemBaslik = "Yeni Özellik";
      break;
    default :
      $buttonText = "EKLE";
      $islemBaslik = "Yeni Özellik";
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
            <h1>Ürün Özellikleri</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=anasayfa">Anasayfa</a></li>
              <li class="breadcrumb-item"><a href="index.php?sayfa=urun_islemleri">Ürün İşlemleri</a></li>
              <li class="breadcrumb-item">Ürün Özellikleri</li>
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
              <h3 class="card-title">Ürün #<?= $urun_id ?> - <?= $islemBaslik ?></h3>
            </div>
            <!-- form start -->
            <form class="form-horizontal" method="get" action="">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="hidden" name="sayfa" class="form-control" value="urun_ozellikleri"/>
                      <input type="hidden" name="islem" class="form-control" value="<?php echo $islem; ?>"/>
                      <input type="hidden" name="urun_id" class="form-control" value="<?php echo $urun_id; ?>"/>  
                      <input type="hidden" name="urun_isim" class="form-control" value="<?php echo $urun_isim; ?>"/>  
                      <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>"/>  
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Ürün</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?= $urun_isim ?>" class="form-control" disabled>
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">İsim</label>
                      <div class="col-sm-10">
                        <input type="text" name="ozellik" class="form-control"
                        <?php
                        if ($islem == "guncellemeYap") {
                          echo 'value="' . $ozellik . '"';
                        } else {
                          echo 'placeholder="Özellik ismi giriniz" required';
                        }
                        ?>                               
                               >
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Bilgi</label>
                      <div class="col-sm-10">
                        <input type="text" name="bilgi" class="form-control"
                        <?php
                        if ($islem == "guncellemeYap") {
                          echo 'value="' . $bilgi . '"';
                        } else {
                          echo 'placeholder="Özellik bilgisi giriniz..." required';
                        }
                        ?>                               
                               >
                      </div>
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
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Özellikler Tablosu</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 300px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th class="text-center">İŞLEMLER</th>
                    <th>ID</th>
                    <th>Ürün</th>
                    <th>Özellik</th>
                    <th>Bilgi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ozellikler_ZA = $bag->query("SELECT * FROM urun_ozellik WHERE urun_id = '{$urun_id}' ORDER BY id DESC", PDO::FETCH_ASSOC);
                  foreach ($ozellikler_ZA as $kayit):
                    ?>
                    <tr>
                      <td class="text-center">
                        <a href="index.php?sayfa=urun_ozellikleri&islem=guncellemeBaslat&urun_id=<?= $kayit['urun_id'] ?>&urun_isim=<?= $urun_isim ?>&id=<?= $kayit['id'] ?>&ozellik=<?= $kayit['ozellik'] ?>&bilgi=<?= $kayit['bilgi'] ?>">
                          <button class="btn btn-info btn-xs">
                            <i class="fas fa-pencil-alt"></i>
                            GÜNCELLEME
                          </button>
                        </a>
                        -
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-sil" 
                                data-href="index.php?sayfa=urun_ozellikleri&islem=silme&id=<?= $kayit['id'] ?>">
                          <i class="fas fa-trash"></i>
                          SİL
                        </button>
                      </td>
                      <td><?= $kayit["id"] ?></td>
                      <td><?= $urun_isim; ?></td>
                      <td><?= $kayit["ozellik"] ?></td>
                      <td><?= $kayit["bilgi"] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <?php
              $sorgu = "SELECT COUNT(*) FROM urun_ozellik WHERE urun_id = '{$urun_id}'";
              $adet = $bag->query($sorgu)->fetchColumn();
              echo "Toplam " . $adet . " özellik bulunmaktadır...";
              ?>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
        <div class="modal fade" id="modal-sil">
          <div class="modal-dialog">
            <div class="modal-content bg-danger">
              <div class="modal-header">
                <h4 class="modal-title">Özellik Silme</h4>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
}
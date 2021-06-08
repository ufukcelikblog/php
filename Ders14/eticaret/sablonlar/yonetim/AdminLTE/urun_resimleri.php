<?php
if (!isset($_SESSION["admin_login"])) {
  header("Location: index.php?sayfa=giris");
} else {
  $mesaj = "";
  $buttonText = "EKLE";
  $islemBaslik = "Yeni Resim";
  $islem = (isset($_GET['islem']) && $_GET['islem'] != '') ? $_GET['islem'] : '';
  $id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
  $urun_id = (isset($_GET['urun_id']) && $_GET['urun_id'] != '') ? $_GET['urun_id'] : '';
  $urun_isim = (isset($_GET['urun_isim']) && $_GET['urun_isim'] != '') ? $_GET['urun_isim'] : '';

  switch ($islem) {
    case "silme":
      $sorgu = "DELETE FROM urun_resim WHERE id = '{$id}'";
      $silme = $bag->prepare($sorgu);
      $silme->execute();
      if ($silme->rowCount() > 0) {
        $mesaj = "Silme işlemi gerçekleşti";
      } else {
        $mesaj = "Silme işleminde problem oldu!!!";
      }
      break;
    case "ekleme":
      $islemBaslik = "Yeni Resim";
      if ($_FILES) {
        $veri = file_get_contents($_FILES['veri']['tmp_name']);
        $tip = $_FILES['veri']['type'];
        if (substr($tip, 0, 5) == "image") {
          $sorgu = $bag->prepare("INSERT INTO urun_resim(urun_id, veri) VALUES(?,?)");
          $sorgu->execute(array($urun_id, $veri));
          $mesaj = "Yeni bir resim eklendi...";
        } else {
          $mesaj = "Dosya türü resim olmalıdır!";
        }
      } else {
        $mesaj = "Bir resim seçilmedi!";
      }
      break;
    case "guncellemeBaslat":
      if ($id != '') {
        $islem = "guncellemeYap";
        $islemBaslik = "Resim Güncelleme";
        $buttonText = "GÜNCELLE";
      } else {
        $mesaj = "Güncelleme için veriler eksik !!!";
      }
      break;
    case "guncellemeYap":
      if ($_FILES) {
        $veri = file_get_contents($_FILES['veri']['tmp_name']);
        $tip = $_FILES['veri']['type'];
        if (substr($tip, 0, 5) == "image") {
          $sorgu = $bag->prepare("UPDATE urun_resim SET urun_id=:u, veri=:v WHERE id='{$id}'");
          $sonuc = $sorgu->execute(array("u" => $urun_id, "v" => $veri));
          if ($sonuc) {
            $mesaj = "Güncelleme işlemi gerçekleşti";
          } else {
            $mesaj = "Güncelleme işleminde bir hata oluştu";
          }
        } else {
          $mesaj = "Dosya türü resim olmalıdır!";
        }
      } else {
        $mesaj = "Bir resim seçilmedi!";
      }
      $islem = "ekleme";
      $islemBaslik = "Yeni Resim";
      break;
    default :
      $buttonText = "EKLE";
      $islemBaslik = "Yeni Resim";
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
            <h1>Ürün Resimleri</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="?sayfa=anasayfa">Anasayfa</a></li>
              <li class="breadcrumb-item"><a href="?sayfa=urun_islemleri">Ürün İşlemleri</a></li>
              <li class="breadcrumb-item">Ürün Resimleri</li>
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
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ürün #<?= $urun_id ?> - <?= $islemBaslik ?></h3>
              </div>
              <!-- form start -->
              <form class="form-horizontal" method="post" enctype="multipart/form-data" 
                    action="?sayfa=urun_resimleri&islem=<?= $islem ?>&id=<?= $id ?>&urun_id=<?= $urun_id ?>&urun_isim=<?= $urun_isim ?>">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Ürün</label>
                        <div class="col-sm-10">
                          <input type="text" value="<?= $urun_isim ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <!-- /.form-group -->
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Resim Dosyası</label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" name="veri" onchange="resimGoster(this);">
                            </div>
                          </div>
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
          <div class="col-md-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Resim</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <?php
                    if ($islem == "guncellemeYap") {
                      $sorgu = "SELECT veri FROM urun_resim WHERE id='{$id}'";
                      $veri = $bag->query($sorgu)->fetchColumn();
                      $resim = "data:image;base64," . base64_encode($veri);
                    } else {
                      $resim = "https://via.placeholder.com/500x300";
                    }
                    ?>
                    <img id="onizlemeResim" src="<?= $resim ?>" width="500" height="300"alt="Ön İzleme"></img>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">

              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Resimler Tablosu</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 300px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th class="text-center">İŞLEMLER</th>
                    <th>ID</th>
                    <th>Ürün</th>
                    <th>Resim</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $resimler_AZ = $bag->query("SELECT * FROM urun_resim WHERE urun_id='{$urun_id}'", PDO::FETCH_ASSOC);
                  foreach ($resimler_AZ as $kayit):
                    ?>
                    <tr>
                      <td class="text-center">
                        <a href="?sayfa=urun_resimleri&islem=guncellemeBaslat&urun_id=<?= $urun_id ?>&urun_isim=<?= $urun_isim ?>&id=<?= $kayit['id'] ?>">
                          <button class="btn btn-info btn-xs">
                            <i class="fas fa-pencil-alt"></i>
                            GÜNCELLEME
                          </button>
                        </a>
                        -
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-sil" data-href="?sayfa=urun_resimleri&islem=silme&urun_id=<?= $urun_id ?>&urun_isim=<?= $urun_isim ?>&id=<?= $kayit['id'] ?>">
                          <i class="fas fa-trash"></i>
                          SİL
                        </button>
                      </td>
                      <td><?= $kayit["id"] ?></td>
                      <td><?= $urun_isim; ?></td>
                      <td><img src="data:image;base64,<?= base64_encode($kayit['veri']) ?>" width="100" height="50"></img></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <?php
              $sorgu = "SELECT COUNT(*) FROM urun_resim WHERE urun_id='{$urun_id}'";
              $adet = $bag->query($sorgu)->fetchColumn();
              echo "Toplam " . $adet . " resim bulunmaktadır...";
              ?>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
        <div class="modal fade" id="modal-sil">
          <div class="modal-dialog">
            <div class="modal-content bg-danger">
              <div class="modal-header">
                <h4 class="modal-title">Resim Silme</h4>
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
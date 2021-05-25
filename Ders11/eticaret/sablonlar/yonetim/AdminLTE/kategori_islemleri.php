<?php
if ($_SESSION["admin_login"] != "tamam") {
  header("Location: index.php?sayfa=giris");
} else {
  $mesaj = "";
  $islemBaslik = "Yeni Kategori";
  $buttonText = "EKLE";
  $islem = (isset($_GET['islem']) && $_GET['islem'] != '') ? $_GET['islem'] : '';
  $id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
  $isim = (isset($_GET['isim']) && $_GET['isim'] != '') ? $_GET['isim'] : '';
  $ust_id = (isset($_GET['ust_id']) && $_GET['ust_id'] != '') ? $_GET['ust_id'] : '';
  switch ($islem) {
    case "silme" :
      $sorgu = "DELETE FROM kategori WHERE id='{$id}'";
      $silme = $bag->prepare($sorgu);
      $silme->execute();
      if ($silme->rowCount() > 0) {
        $mesaj = "Silme işlemi gerçekleşti";
      } else {
        $mesaj = "Silme işleminde bir problem var!!!";
      }
      break;
    case "ekleme":
      $islemBaslik = "Yeni Kategori";
      $sorgu = "SELECT COUNT(*) FROM kategori WHERE isim='{$isim}' AND ust_id='{$ust_id}'";
      $adet = $bag->query($sorgu)->fetchColumn();
      if ($adet > 0) {
        $mesaj = "Bu kategori daha önce oluşturulmuş!!!";
      } else {
        $kayit = $bag->query("SELECT * FROM kategori WHERE id='{$ust_id}'")->fetch(PDO::FETCH_ASSOC);
        if ($kayit) {
          $ust_isim = $kayit["ust_isim"] . " > " . $kayit["isim"];
        } else {
          $ust_isim = " ";
        }
        $sorgu = $bag->prepare("INSERT INTO kategori(isim, ust_id, ust_isim) VALUES(?,?,?)");
        $sorgu->execute(array($isim, $ust_id, $ust_isim));
        $mesaj = "Yeni bir kategori eklendi...";
      }
      unset($id);
      unset($ust_id);
      unset($isim);
      break;
    case "guncellemeBaslat":
      if ($id != '' && $isim != '' && $ust_id != '') {
        $islem = "guncellemeYap";
        $islemBaslik = "Kategori Güncelleme";
        $buttonText = "GÜNCELLE";
      } else {
         $mesaj = "Güncelleme için veriler eksik !!!";
      }
      break;
    case "guncellemeYap":
      if ($id != '' && $isim != '' && $ust_id != '') {
        $kayit = $bag->query("SELECT * FROM kategori WHERE id='{$ust_id}'")->fetch(PDO::FETCH_ASSOC);
        $ust_isim = $kayit ? $kayit["ust_isim"] . " > " . $kayit["isim"] : " ";
        $sorgu = $bag->prepare("UPDATE kategori "
                . "SET isim=:yisim, ust_id=:yust_id, ust_isim=:yust_isim "
                . "WHERE id = '{$id}'");
        $sonuc = $sorgu->execute(array("yisim" => $isim, "yust_id" => $ust_id, "yust_isim" => $ust_isim));
        if ($sonuc) {
          $mesaj = "Güncelleme işlemi gerçekleşti";
        } else {
          $mesaj = "Güncelleme işleminde bir hata oluştu";
        }
      } else {
         $mesaj = "Güncelleme için veriler eksik !!!";
      }
      $islem = "ekleme";
      $islemBaslik = "Yeni Kategori";
      unset($id);
      unset($ust_id);
      unset($isim);
      break;
    default:
      $buttonText = "EKLE";
      $islemBaslik = "Yeni Kategori";
      $islem = "ekleme";
      break;
  }
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <?php
        if ($mesaj != "") {
          ?>
          <div class="alert alert-primary text-center fade show" role="alert">
            <strong>MESAJ : </strong> <?php echo $mesaj; ?>
          </div>
          <?php
        }
        ?>        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Kategori İşlemleri</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?sayfa=anasayfa">Anasayfa</a></li>
              <li class="breadcrumb-item active">Kategori İşlemleri</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?php echo $islemBaslik; ?></h3>
              </div>
              <!-- form start -->
              <form method="get" action="">  
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" name="sayfa" class="form-control" value="kategori_islemleri"/>
                    <input type="hidden" name="islem" class="form-control" value="<?= $islem ?>"/>
                    <input type="hidden" name="id" class="form-control" value="<?= $id ?>"/>  
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Üst Kategori</label>
                    <select name="ust_id" class="form-control">
                      <option value="0">YOK</option>
                      <?php
                      $kategoriler_AZ = $bag->query("SELECT * FROM kategori", PDO::FETCH_ASSOC);
                      foreach ($kategoriler_AZ as $kategori):
                        $secilmeDurum = $ust_id == $kategori["id"] ? "selected" : "";
                        ?>
                        <option value="<?= $kategori['id'] ?>" <?= $secilmeDurum ?> > <?= $kategori["ust_isim"] . " > " . $kategori["isim"] ?> </option>
                        <?php
                      endforeach;
                      ?>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>İsim</label>
                    <input type="text" name="isim" class="form-control" 
                    <?php
                    if ($islem == "guncellemeYap") {
                      echo 'value="' . $isim . '"';
                    } else {
                      echo "placeholder='kategori ismi giriniz' required";
                    }
                    ?>
                           />
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary btn-block"><?php echo $buttonText; ?></button>
                </div>
              </form>
              <!-- form end -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Kategoriler Tablosu</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th class="text-center">İŞLEMLER</th>
                      <th>ID</th>
                      <th>Üst Kategori</th>
                      <th>İsim</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $kategoriler_ZA = $bag->query("SELECT * FROM kategori ORDER BY id DESC", PDO::FETCH_ASSOC);
                    foreach ($kategoriler_ZA as $kategori):
                      ?>
                      <tr>
                        <td> 
                          <a href="index.php?sayfa=kategori_islemleri&islem=guncellemeBaslat&id=<?= $kategori['id'] ?>&isim=<?= $kategori['isim'] ?>&ust_id=<?= $kategori['ust_id'] ?>">
                            <button class="btn btn-info btn-xs">
                              <i class="fas fa-pencil-alt"></i>
                              GÜNCELLE
                            </button>
                          </a>
                          -                                                             
                          <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-sil">
                            <i class="fas fa-trash"></i>
                            SİL
                          </button>
                        </td>
                        <td><?= $kategori["id"] ?></td>
                        <td>
                          <?php
                          echo $kategori["ust_id"] == 0 ? "YOK" : $kategori["ust_isim"];
                          ?>
                        </td>
                        <td><?= $kategori["isim"] ?></td>
                      </tr>
                      <?php
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      <div class="modal fade" id="modal-sil">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Kategori Silme</h4>
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
              <a href="index.php?sayfa=kategori_islemleri&islem=silme&id=<?= $kategori['id'] ?>">
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

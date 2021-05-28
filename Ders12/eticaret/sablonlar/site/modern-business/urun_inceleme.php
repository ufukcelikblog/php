<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">E-Ticaret
  <small>Sitesi</small>
</h1>

<ol class="breadcrumb">
  <li class="breadcrumb-item active">
    <a href="index.php">Anasayfa</a>
    <li class="breadcrumb-item active">Ürün İnceleme</li>
  </li>
</ol>
<!-- Page Content-->
<div class="container">
  <div class="row">

    <div class="col-lg-3">
      <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
          <div class="sidebar-header">
            <h3>Kategoriler</h3>
          </div>
          <ul class="list-group list-group-collapse">
            <?php echo kategoriMenu(); ?>
          </ul>
        </nav>
      </div>
    </div>

    <div class="col-lg-9">
      <div class="row">
        <?php
        if (isset($_GET['id']) && $_GET['id'] != '') {
          $urun = $bag->query("SELECT * FROM urun WHERE id ='{$_GET['id']}'")->fetch();
          if ($urun) {
            ?>
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="carousel slide my-4" id="carouselExampleIndicators_<?= $urun['id'] ?>" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <?php
                    $sorgu = $bag->prepare("SELECT * FROM urun_resim WHERE urun_id ='{$urun['id']}'");
                    $sorgu->execute();
                    $kayitlar = $sorgu->fetchAll();
                    $no = 0;
                    foreach ($kayitlar as $kayit):
                      $aktifDurum = $no == 0 ? "active" : "";
                      ?>
                      <li class="<?= $aktifDurum ?>" data-target="#carouselExampleIndicators_<?= $urun['id'] ?>" data-slide-to="<?= $no ?>"></li>
                      <?php
                      $no++;
                    endforeach;
                    ?>
                  </ol>
                  <div class="carousel-inner" role="listbox">
                    <?php
                    $no = 0;
                    foreach ($kayitlar as $kayit):
                      $aktifDurum = $no == 0 ? "active" : "";
                      ?>
                      <div class="carousel-item <?= $aktifDurum ?>">
                        <img class="d-block img-fluid" src="data:image;base64,<?= base64_encode($kayit['veri']) ?>" width="1000"></img>
                      </div>
                      <?php
                      $no++;
                    endforeach;
                    ?>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators_<?= $urun['id'] ?>" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Önceki</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators_<?= $urun['id'] ?>" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Sonraki</span>
                  </a>
                </div>
                <div class="card-body">
                  <h4 class="card-title"><a href="#!"><?= $urun['isim'] ?></a></h4>
                  <h5><?= $urun['fiyat'] ?> TL</h5>
                  <p class="card-text"><?= $urun['aciklama'] ?></p>
                  <small class="text-muted"><?= $urun['durum'] ?></small>
                </div>
                <div class="card-footer" data-id="<?= $urun['id'] ?>">
                  <a href="index.php?sayfa=sepet_islemleri">
                    <button class="btn btn-secondary btn-xs">
                      <i class="fas fa-search"></i> SEPETİ GÖSTER
                    </button>
                  </a>
                  <button class="sepet-ekle btn btn-secondary btn-xs float-lg-right" onclick="sepet_ekle(<?= $urun['id'] ?>)">
                    <i class="fas fa-shopping-basket"></i> SEPETE EKLE
                  </button>
                </div>
              </div>
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Özellikler</h3>
                </div>
                <div class="card-body table-responsive p-0" style="height: 300px;">
                  <table class="table table-head-fixed text-nowrap">
                    <tbody>
                      <?php
                      $ozellikler_ZA = $bag->query("SELECT * FROM urun_ozellik WHERE urun_id = '{$urun['id']}'", PDO::FETCH_ASSOC);
                      foreach ($ozellikler_ZA as $kayit):
                        ?>
                        <tr>
                          <td><?= $kayit["ozellik"] ?></td>
                          <td><?= $kayit["bilgi"] ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <?php
          } else {
            ?>
            <div class="alert alert-warning text-center fade show" role="alert">
              <strong>MESAJ : </strong> Ürün YOK...
            </div>
            <?php
          }
        } else {
          ?>
          <div class="alert alert-warning text-center fade show" role="alert">
            <strong>MESAJ : </strong> Ürün bulunamadı... !!!
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<div id="modal-container">

</div>

<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">E-Ticaret
  <small>Sitesi</small>
</h1>

<ol class="breadcrumb">
  <li class="breadcrumb-item active">
    <a href="index.php">Anasayfa</a>
  </li>
</ol>

<!-- Page Content-->
<div class="container">
  <div class="row">
    <div class="col-lg-3">
      <!-- Sidebar  -->
      <nav id="sidebar">
        <div class="sidebar-header">
          <h3>Kategoriler</h3>
        </div>
        <ul class="list-group list-group-collapse">
          <?php echo kategoriMenu(); ?>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <div class="row">
        <?php
        $kategoriIDler = isset($_GET['kategori']) ? urunKategoriler($_GET['kategori']) : urunKategoriler();
        $kategoriIDler = substr($kategoriIDler, 0, -1);
        $sorgu = "SELECT * FROM urun WHERE kategori_id IN (" . $kategoriIDler . ")";
        $urunler = $bag->query($sorgu)->fetchAll(PDO::FETCH_ASSOC);
        if ($urunler) {
          foreach ($urunler as $urun) {
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
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
                  <h4 class="card-title"><a href="#!"><?= $urun["isim"] ?></a></h4>
                  <h5><?= $urun["fiyat"] ?></h5>
                  <p class="card-text"><?= $urun["aciklama"] ?></p>
                  <small class="text-muted"><?= $urun['durum'] ?></small>
                </div>
                <div class="card-footer">
                  <a href="index.php?sayfa=urun_inceleme&id=<?= $urun['id'] ?>">
                    <button class="btn btn-secondary btn-xs">
                      <i class="fas fa-search"></i> İNCELE
                    </button>
                  </a>
                  <button class="btn btn-warning btn-xs float-right" onclick="sepet_ekle(<?= $urun['id'] ?>)">
                    <i class="fas fa-shopping-basket"></i> EKLE
                  </button>
                </div>
              </div>
            </div>

            <?php
          }
        } else {
          ?>
          <div class="alert alert-warning text-center fade show" role="alert">
            <strong>MESAJ : </strong> Aradığınız kategoride ürün bulunamadı
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
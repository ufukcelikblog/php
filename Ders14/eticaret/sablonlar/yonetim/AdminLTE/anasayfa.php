<?php
if (!isset($_SESSION["admin_login"])) {
  header("Location: index.php?sayfa=giris");
} else {
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
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <?php
            $bekleyenSiparisler = $bag->query("SELECT COUNT(*) FROM siparis WHERE durum='Onay Bekliyor'")->fetchColumn();
            ?>
            <div class="info-box-content">
              <span class="info-box-text">Onay Bekleyen Sipariş</span>
              <span class="info-box-number">
                <?= $bekleyenSiparisler ?>
                <small>ADET</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>
            <?php
            $toplamTutar = $bag->query("SELECT SUM(siparis.adet * urun.fiyat) FROM siparis, urun WHERE siparis.urun_id = urun.id")->fetchColumn();
            ?>
            <div class="info-box-content">
              <span class="info-box-text">Toplam Satış Tutarı</span>
              <span class="info-box-number">
                <?= $toplamTutar ?>
                <small>TL</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-blue elevation-1"><i class="fas fa-cogs"></i></span>
            <?php
            $urunSayisi = $bag->query("SELECT COUNT(*) FROM urun")->fetchColumn();
            ?>
            <div class="info-box-content">
              <span class="info-box-text">Toplam Ürün Sayısı</span>
              <span class="info-box-number">
                <?= $urunSayisi ?>
                <small>ADET</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
            <?php
            $uyeSayisi = $bag->query("SELECT COUNT(*) FROM uye WHERE tur='normal'")->fetchColumn();
            ?>
            <div class="info-box-content">
              <span class="info-box-text">Toplam Üye Sayısı</span>
              <span class="info-box-number">
                <?= $uyeSayisi ?>
                <small>ADET</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Raporlar</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
             <div class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">En İyi Ürünler</h3>
                </div>
                <div class="card-body">
                  <?php
                  $sorgu = "SELECT urun.isim, SUM(urun.fiyat * siparis.adet) AS harcama
                    FROM siparis, urun
                    WHERE siparis.urun_id = urun.id
                    GROUP BY urun.isim
                    ORDER BY harcama DESC
                    LIMIT 3";
                  $kayitlar = $bag->query($sorgu, PDO::FETCH_ASSOC);
                  foreach ($kayitlar as $kayit):
                    ?>
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                      <p class="text-warning text-xl">
                      <i class="fas fa-shopping-cart"></i>
                      </p>
                      <p class="d-flex flex-column text-right">
                        <span class="font-weight-bold">
                          <i class="fas fa-arrow-up text-primary"></i>
                           <?= $kayit['harcama'] ?>
                        </span>
                        <span class="text-muted"> <?= $kayit['isim'] ?></span>
                      </p>
                    </div>
                    <!-- /.d-flex -->
                    <?php
                  endforeach;
                  ?>
                </div>
              </div>
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">En İyi Müşteriler</h3>
                </div>
                <div class="card-body">
                  <?php
                  $sorgu = "SELECT CONCAT(uye.ad, ' ', uye.soyad) AS musteri, 
                      SUM(urun.fiyat * siparis.adet) AS harcama
                    FROM uye, siparis, urun
                    WHERE uye.id = siparis.uye_id
                    AND siparis.urun_id = urun.id
                    GROUP BY musteri
                    ORDER BY harcama DESC
                    LIMIT 3";
                  $kayitlar = $bag->query($sorgu, PDO::FETCH_ASSOC);
                  foreach ($kayitlar as $kayit):
                    ?>
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                      <p class="text-success text-xl">
                      <i class="fas fa-user-check"></i>
                      </p>
                      <p class="d-flex flex-column text-right">
                        <span class="font-weight-bold">
                          <i class="fas fa-arrow-up text-primary"></i>
                           <?= $kayit['harcama'] ?>
                        </span>
                        <span class="text-muted"> <?= $kayit['musteri'] ?></span>
                      </p>
                    </div>
                    <!-- /.d-flex -->
                    <?php
                  endforeach;
                  ?>
                </div>
              </div>
            </div>
            <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
}
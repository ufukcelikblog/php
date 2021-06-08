<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">E-Ticaret</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav">
        <li class="nav-item" id="sepet-bilgi">
          
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php
        if ($_SESSION["login"] != "tamam") {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?sayfa=uyelik">Üyelik</a>
          </li>
          <?php
        } else {
          ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUyelik" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION["ad"] . " " . $_SESSION["soyad"]; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="navbarDropdownUyelik">
              <a class="dropdown-item" href="index.php?sayfa=uyelik_bilgileri">
                <i class="fas fa-user-check fa-sm fa-fw mr-2 text-gray-400"></i>
                Üyelik Bilgileri
              </a>
              <a class="dropdown-item" href="index.php?sayfa=uyelik_guncelle">
                <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                Üyelik Güncelle
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="index.php?sayfa=adres_islemleri">
                <i class="fas fa-map fa-sm fa-fw mr-2 text-gray-400"></i>
                Adres İşlemleri
              </a>
              <a class="dropdown-item" href="index.php?sayfa=siparis_islemleri">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Sipariş İşlemleri
              </a>
              <a class="dropdown-item" href="index.php?sayfa=siparis_listesi">
                <i class="fas fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Sipariş Listesi
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="index.php?sayfa=cikis">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Çıkış Yap
              </a>
            </div>
          </li>
          <?php
        }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?sayfa=iletisim">İletişim</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


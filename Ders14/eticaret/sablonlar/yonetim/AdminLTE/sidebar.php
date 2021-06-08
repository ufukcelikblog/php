<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php?sayfa=anasayfa" class="brand-link">
    <img src="<?php echo YONETIM_SABLON; ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">E-Ticaret</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <?php
    if ($_SESSION["admin_login"] == "tamam") {
      ?>
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo YONETIM_SABLON; ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="index.php?sayfa=cikis" class="d-block">Yönetici Çıkış</a>
        </div>
      </div>
      <?php
    }
    ?>
    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Ara" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="index.php?sayfa=anasayfa" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Kontrol Panel
            <i class="right badge badge-danger">!</i>
            </p>
          </a>
        </li>
        <li class="nav-header">ANA MENÜ</li>
        <li class="nav-item">
          <a href="index.php?sayfa=kategori_islemleri" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Kategori İşlemleri</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?sayfa=urun_islemleri" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Ürün İşlemleri</p>
          </a>
        </li>
        <li class="nav-item">
            <a href="index.php?sayfa=siparisler" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Siparişler
              </p>
            </a>
          </li> 
        <li class="nav-header">ALT MENÜ</li>
        <li class="nav-item">
          <a href="index.php?sayfa=yardim" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Yardım</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>


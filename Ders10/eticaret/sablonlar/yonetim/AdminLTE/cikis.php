<?php
session_destroy();
$_SESSION[] = array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Çıkış</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
            <li class="breadcrumb-item active">Çıkış</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Çıkış</h3>
      </div>
      <div class="card-body">
        <div class='alert alert-success text-center'>Başarıyla ÇIKIŞ yaptınız</div>
        <script>
          setInterval(
                  function () {
                    window.location.href = "index.php?sayfa=anasayfa";
                  }, 2000
                  );
        </script>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        İyi günler
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
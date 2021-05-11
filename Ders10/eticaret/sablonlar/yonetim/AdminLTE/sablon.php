<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
  <?php
  require YONETIM_SABLON . '/head.php';
  ?>
  <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
  <div class="wrapper">
    <?php
    require YONETIM_SABLON . '/navbar.php';

    require YONETIM_SABLON . '/sidebar.php';

    require $icerik;

    require YONETIM_SABLON . '/footer.php';
    ?>
  </div>
  <!-- ./wrapper -->
  
  <!-- jQuery -->
  <script src="<?php echo YONETIM_SABLON; ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo YONETIM_SABLON; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo YONETIM_SABLON; ?>/plugins/select2/js/select2.full.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo YONETIM_SABLON; ?>/dist/js/adminlte.js"></script>
  </body>
</html>
<?php
ob_flush();
?>
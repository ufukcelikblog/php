<!DOCTYPE html>
<html lang="en">
  <?php
  require SITE_SABLON . '/head.php';
  ?>
  <body>
    <?php
    require SITE_SABLON . '/navigation.php';
    ?>
    <!-- Page Content -->
  <div class="container">
    <?php
    require $icerik;
    ?>
  </div>
  <!-- /.container -->

  <?php
  require SITE_SABLON . '/footer.php';
  ?>
</body>
</html>

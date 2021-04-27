<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <?php
  require 'head.php';
  ?>
  <body>
    <?php
    require 'navigation.php';
    ?>
    <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">E-Ticaret
      <small>Sitesi</small>
    </h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <a href="index.php">Anasayfa</a>
      </li>
    </ol>
  </div>
  <!-- /.container -->

  <?php
  require 'footer.php';
  ?>
</body>
</html>

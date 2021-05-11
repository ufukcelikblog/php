<?php
session_destroy();
?>

<div class="jumbotron">
  <div class='alert alert-success text-center'>Başarıyla ÇIKIŞ yaptınız</div>
  <script>
    setInterval(
            function () {
              window.location.href = "index.php";
            }, 2000
            );
  </script>
</div>
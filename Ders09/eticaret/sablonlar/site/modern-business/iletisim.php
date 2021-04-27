<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">E-Ticaret
  <small><?php echo $baslik; ?></small>
</h1>

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Anasayfa</a>
  </li>
  <li class="breadcrumb-item active">İletişim</li>
</ol>

<!-- Content Row -->
<div class="row">
  <!-- Contact Form -->
  <div class="col-lg-8 mb-4">
    <h3>Bir mesaj gönderin</h3>
    <form action="" method="post" id="iletisimFormu" validate>
      <div class="control-group form-group row">
        <label class="col-form-label col-sm-2">İSİM</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="isim" required data-validation-required-message="Lütfen tam isminizi yazınız.">
        </div>
      </div>
      <div class="control-group form-group row">
        <label class="col-form-label col-sm-2">E-POSTA</label>
        <?php
        $eposta = $_SESSION["login"] == "tamam" ? $_SESSION['eposta'] : "";
        ?>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="eposta" value="<?php echo $eposta; ?>" required data-validation-required-message="Lütfen geçerli bir e-posta yazınız.">
        </div>
      </div>
      <div class="control-group form-group">
        <div class="controls">
          <label>MESAJ</label>
          <textarea rows="5" cols="100" class="form-control" id="mesaj" required data-validation-required-message="Lütfen mesajınızı yazınız" maxlength="999" style="resize:none"></textarea>
        </div>
      </div>
      <div id="success"></div>
      <!-- For success/fail messages -->
      <button type="submit" class="btn btn-primary" id="sendMessageButton">GÖNDER</button>
    </form>
  </div>

  <!-- Contact Details Column -->
  <div class="col-lg-4 mb-4">
    <h3>İletişim Bilgileri</h3>
    <p>
      Bandırma Merkez
      <br>Balıkesir, 10200
      <br>
    </p>
    <p>
      <abbr title="Telefon">T</abbr>: (123) 456-7890
    </p>
    <p>
      <abbr title="Eposta">E</abbr>:
      <a href="mailto:iletisim@eticaret.com">iletisim@eticaret.com
      </a>
    </p>
  </div>
</div>
<!-- /.row -->

<div class="row">
  <!-- Map Column -->
  <div class="col-lg-12 mb-4">
    <!-- Embedded Google Map -->
    <iframe 
      style="width: 100%; height: 400px; border: 0;" 
      src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=40.3430371,27.9548787&amp;spn=56.506174,79.013672&amp;t=m&amp;z=14&amp;output=embed"></iframe>
  </div>
</div>
<!-- /.row -->

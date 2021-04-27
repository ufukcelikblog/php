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
      <li class="breadcrumb-item">
        <a href="index.php">Anasayfa</a>
      </li>
      <li class="breadcrumb-item active">İletişim</li>
    </ol>


    <!-- Content Row -->
    <div class="row">
      <!-- Map Column -->
      <div class="col-lg-8 mb-4">
        <!-- Embedded Google Map -->
        <iframe 
          style="width: 100%; height: 400px; border: 0;" 
          src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=40.3430371,27.9548787&amp;spn=56.506174,79.013672&amp;t=m&amp;z=14&amp;output=embed"></iframe>
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
          <a href="mailto:name@example.com">name@example.com
          </a>
        </p>
      </div>
    </div>
    <!-- /.row -->

    <!-- Contact Form -->
    <!-- In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Bir mesaj gönderin</h3>
        <form name="sentMessage" id="contactForm" novalidate>
          <div class="control-group form-group">
            <div class="controls">
              <label>Tam İsim:</label>
              <input type="text" class="form-control" id="name" required data-validation-required-message="Please enter your name.">
                <p class="help-block"></p>
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Telefon Numarası:</label>
              <input type="tel" class="form-control" id="phone" required data-validation-required-message="Please enter your phone number.">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>E-posta Adresi:</label>
              <input type="email" class="form-control" id="email" required data-validation-required-message="Please enter your email address.">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Mesaj:</label>
              <textarea rows="10" cols="100" class="form-control" id="message" required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none"></textarea>
            </div>
          </div>
          <div id="success"></div>
          <!-- For success/fail messages -->
          <button type="submit" class="btn btn-primary" id="sendMessageButton">Mesajı Gönder</button>
        </form>
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <?php
  require 'footer.php';
  ?>
</body>
</html>

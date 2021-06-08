<?php
session_start();
require_once("veritabani.php");

if (isset($_POST['urun_id'])) {
  $urun_id = $_POST['urun_id'];
  if ($_SESSION["login"] == "tamam") {
    $uye_id = $_SESSION["id"];
    $kayit = $bag->prepare("SELECT * FROM sepet WHERE uye_id=? AND urun_id=?");
    $kayit->execute(array($uye_id, $urun_id));
    if ($kayit->rowCount() > 0) { // bu ürün sepette var adeti değiştir
      $sorgu = $bag->prepare("UPDATE sepet SET adet=adet+1 WHERE uye_id=? AND urun_id=?");
      $sorgu->execute([$uye_id, $urun_id]);
      echo
      '<div class="modal fade" id="sepet-modal">
        <div class="modal-dialog">
          <div class="modal-content bg-warning">
            <div class="modal-header">
              <h4 class="modal-title">Sepet Güncellendi</h4>
            </div>
            <div class="modal-body">
              <p>Sepetinizdeki ürünün adeti güncellendi...</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                <i class="fas fa-undo"></i>
                Alışverişe Devam Et
              </button>
              <a href="index.php?sayfa=sepet_islemleri">
                <button type="button" class="btn btn-outline-light">
                  <i class="fas fa-shopping-basket"></i>
                  Sepeti Aç
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>';
    } else { // bu ürün sepette yok ekleyelim
      $sorgu = $bag->prepare("INSERT INTO sepet(uye_id, urun_id, adet) VALUES(?,?,?)");
      $sorgu->execute(array($uye_id, $urun_id, '1'));
      echo
      '<div class="modal fade" id="sepet-modal">
        <div class="modal-dialog">
          <div class="modal-content bg-success">
            <div class="modal-header">
              <h4 class="modal-title">Sepete Ekleme</h4>
            </div>
            <div class="modal-body">
              <p>Seçtiğiniz ürün sepete eklendi...</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                <i class="fas fa-undo"></i>
                Alışverişe Devam Et
              </button>
              <a href="index.php?sayfa=sepet_islemleri">
                <button type="button" class="btn btn-outline-light">
                  <i class="fas fa-shopping-basket"></i>
                  Sepeti Kontrol Et
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>';
    }
  } else {
    echo
    '<div class="modal fade" id="sepet-modal">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Login Hatası</h4>
            </div>
            <div class="modal-body">
              <p>Ürünü sepete eklemek için login olmalısınız!!!</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                <i class="fas fa-undo"></i>
                Siteye Devam Et
              </button>
              <a href="index.php?sayfa=uyelik">
                <button type="button" class="btn btn-outline-light">
                  <i class="fas fa-trash"></i>
                  Giriş Yap
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>';
  }
}

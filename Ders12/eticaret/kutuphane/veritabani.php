<?php

$sunucu = "localhost";
$veritabani = "eticaret";
$kullanici = "root";
$sifre = "mysql";

try {
  $bag = new PDO("mysql:host=$sunucu;dbname=$veritabani", $kullanici, $sifre);
  // PDO hata modlarını ayarlama
  $bag->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Bağlantı başarılı";
  //$bag = null;
} catch (PDOException $hata) {
  echo "Bir hata oluştu: " . $hata->getMessage();
}

function kategoriMenu($ustID = 0) {
  global $bag;
  $sorgu = "SELECT * FROM kategori WHERE ust_id='{$ustID}'";
  $kategoriler = $bag->query($sorgu)->fetchAll(PDO::FETCH_ASSOC);
  $sonuc = "";
  foreach ($kategoriler as $kategori) {
    $sonuc .= '<li class="list-group-item">';
    $sonuc .= '  <a href="?sayfa=anasayfa&kategori=' . $kategori['id'] . '">' . $kategori['isim'] . '</a>';
    if (altKategoriVar($kategori['id'])) {
      $sonuc .= '  <a href="#" data-toggle="#kategori_' . $kategori['id'] . '" class="list-down-btn">';
      $sonuc .= '    <span class="fas fa-chevron-down"></span>';
      $sonuc .= '  </a>';
      $sonuc .= '  <ul class="list-group" id="kategori_' . $kategori['id'] . '">';
      $sonuc .= kategoriMenu($kategori['id']);
      $sonuc .= '  </ul>';
    }
    $sonuc .= "</li>";
  }
  return $sonuc;
}

function altKategoriVar($ID = 0) {
  global $bag;
  $adet = $bag->query("SELECT COUNT(*) FROM kategori WHERE ust_id='{$ID}'")->fetchColumn();
  if ($adet > 0) {
    return true;
  } else {
    return false;
  }
}

function urunKategoriler($ID = 0) {
  global $bag;
  $sonuc = $ID . ",";
  $sorgu = "SELECT * FROM kategori WHERE ust_id='{$ID}'";
  $kategoriler = $bag->query($sorgu)->fetchAll(PDO::FETCH_ASSOC);
  foreach ($kategoriler as $kategori) {
    $sonuc .= $kategori['id'] . ",";
    $sonuc .= urunKategoriler($kategori['id']);
  }
  return $sonuc;
}
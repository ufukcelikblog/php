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
    $sonuc .= '<li>';
    $sonuc .= '<a href="#kategori_' . $kategori['id'] . '" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">' . $kategori['isim'] . '</a>';
    $sonuc .= '<ul id="kategori_' . $kategori["id"] . '">';
    $sonuc .= '<a href="?sayfa=anasayfa&kategori=' . $kategori['id'] . '">'  . $kategori['isim'] . ' Ürünleri</a>';
    $sonuc .= kategoriMenu($kategori['id']);
    $sonuc .= "</ul>";
    $sonuc .= "</li>";
  }
  return $sonuc;
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
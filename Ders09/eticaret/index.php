<?php
// Kullanıcı sitesi başlangıç
require_once 'kutuphane/ayarlar.php';
require_once 'kutuphane/oturum.php';
require_once 'kutuphane/veritabani.php';

$sayfa = (isset($_GET['sayfa']) && $_GET['sayfa'] != '') ? $_GET['sayfa'] : '';

switch($sayfa) {
  case 'uyelik' :
    $baslik = "Üyelik İşlemleri";
    $icerik = "uyelik.php";
    break;
  case 'uyelik_bilgileri' :
    $baslik = "Üyelik Bilgileri";
    $icerik = "uyelik_bilgileri.php";
    break;
  case 'uyelik_guncelle' :
    $baslik = "Üyelik Güncelleme";
    $icerik = "uyelik_guncelle.php";
    break;  
  case 'iletisim' :
    $baslik = "İletişim";
    $icerik = "iletisim.php";
    break;
  case 'cikis' :
    $baslik = "Çıkış";
    $icerik = "cikis.php";
    break;
  default :
    $baslik = "Anasayfa";
    $icerik = "anasayfa.php";
}

require_once SITE_SABLON . '/sablon.php';

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
  case 'sepet_islemleri' :
    $baslik = "Sepet İşlemleri";
    $icerik = "sepet_islemleri.php";
    break;
  case 'siparis_islemleri' :
    $baslik = "Sipariş İşlemleri";
    $icerik = "siparis_islemleri.php";
    break;
  case 'siparis_listesi' :
    $baslik = "Sipariş Listesi";
    $icerik = 'siparis_listesi.php';
    break;  
  case 'adres_islemleri' :
    $baslik = "Adres İşlemleri";
    $icerik = "adres_islemleri.php";
    break;
  case 'urun_inceleme' :
    $baslik = "Ürün İnceleme";
    $icerik = "urun_inceleme.php";
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

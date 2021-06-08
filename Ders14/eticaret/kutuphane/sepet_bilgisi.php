<?php
session_start();
require_once("veritabani.php");

if (isset($_SESSION["login"])) {
  $uye_id = $_SESSION["id"];
  $sorgu = "SELECT SUM(adet) FROM sepet WHERE uye_id='{$uye_id}'";
  $adet = $bag->query($sorgu)->fetchColumn();
  if ($adet > 0) {
    echo '<a class="nav-link" href="index.php?sayfa=sepet_islemleri">
            <i class="fas fa-shopping-cart text-gray-400"></i>
            <span class="badge badge-warning"> ' . $adet . ' </span>
          </a>';
  } else {
    echo '<i class="fas fa-shopping-cart text-gray-400"></i>
            <span class="badge badge-warning"> BOŞ </span>';
  }
} else {
    echo '<i class="fas fa-shopping-cart text-gray-400"></i>';
}

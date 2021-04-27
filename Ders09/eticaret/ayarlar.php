<?php

//DIRECTORY_SEPARATOR PHP'de önceden tanımlı bir değişkendir:
//(windows için \, Unix için /)
//defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

//defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'eticaret');

//defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT . DS . 'kutuphane');
defined('SITE_SABLON') ? null : define('SITE_SABLON', 'sablonlar/site/modern-business/');
defined('YONETIM_SABLON') ? null : define('YONETIM_SABLON', 'sablonlar/yonetim/');

require_once("kutuphane/oturum.php");
require_once("kutuphane/veritabani.php");


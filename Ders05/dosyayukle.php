<?php
$hedef_klasor = "dosyalar/";
$hedef_dosya = $hedef_klasor . basename($_FILES["yuklenecekDosya"]["name"]);
$yuklemeTamam = 1;
$resimDosyaTuru = strtolower(pathinfo($hedef_dosya, PATHINFO_EXTENSION));

if(isset($_POST["gonder"])) {
	$kontrol = getimagesize($_FILES["yuklenecekDosya"]["tmp_name"]);
	if($kontrol !== false) {
		echo "Dosya bir resimdir - " . $kontrol["mime"] . ".";
		$yuklemeTamam = 1;
	} else {
		echo "Bu bir resim değil";
		$yuklemeTamam = 0;
	}
}
if(file_exists($hedef_dosya)) {
	echo "Bu dosya zaten var";
	$yuklemeTamam = 0;
}
if($_FILES["yuklenecekDosya"]["size"] > 500000) {
	echo "Dosya çok büyük";
	$yuklemeTamam = 0;
}
if($resimDosyaTuru != "jpg" && $resimDosyaTuru != "png" && $resimDosyaTuru != "jpeg") {
	echo "Sadece JPG, JPEG, PNG dosyaları olabilir";
	$yuklemeTamam = 0;
}

if($yuklemeTamam == 0 ) {
	echo "Bu dosya yüklenemez";
} else {
	if(move_uploaded_file($_FILES["yuklenecekDosya"]["tmp_name"], $hedef_dosya)) {
		echo "Dosyanız yüklendi";
	} else {
		echo "Dosyanız yüklenemedi";
	}
}

?>
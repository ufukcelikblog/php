<?php
$dosya_isim = "deneme.txt";

if(file_exists($dosya_isim)) {
	// dosya açmak
	$dosya = fopen($dosya_isim, "r");
	
	//$icerik = fread($dosya, 10); 
	//echo $icerik . "<br>";
	// bir satır okur
	//echo fgets($dosya);
	
	while(!feof($dosya)) {
		echo fgetc($dosya) . "<br>";
	}
	
	fclose($dosya);
} else {
	echo "Dosya bulunamadı";
}


?>

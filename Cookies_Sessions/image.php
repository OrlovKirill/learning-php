<?php
	session_start();	
	$checker = substr(md5(rand(1,10)),0,4);
	$_SESSION['checker'] = $checker;
	$img = imagecreatefrompng(__DIR__.'/sertificates/cover.png');
 	$textColor = imagecolorallocate($img, 0, 0, 0);
    imagettftext($img, 60, 5, 430, 370, $textColor, __DIR__.'/fonts/arial.ttf', $checker);
	header('Content-type: image/png');
    imagePng($img);
    imagedestroy($img);
?>

<?php
	header("Content-type: image/png");

	$date = $_GET["date"];
	
	$baseImage  = imagecreatefrompng(dirname(__FILE__)."/baseDateIcon2.png");
	$iconSize 	= getimagesize(dirname(__FILE__)."/baseDateIcon2.png");
	
	$textColorOne 	= imagecolorallocate($baseImage, 55, 55, 55);
	$textColorTwo 	= imagecolorallocate($baseImage, 90, 90, 90);
	
	$baseFontSize = 11;
	
	$tinyFontSize 	= $baseFontSize;
	$fontSize 		= $baseFontSize + 1;
	$bigFontSize 	= $baseFontSize + 4;
	$hugeFontSize 	= $baseFontSize + 10;
	$fontAngle 		= 0;
	$fontFile 		= dirname(__FILE__)."/font/Verdana.ttf";
	$boldFontFile 	= dirname(__FILE__)."/font/VerdanaBold.ttf";
	
	$monthName 	= '-'.strtoupper(date("M", $date)).'-';
	$dayNumber 	= date('j', $date);
	$dayName 	= strtoupper(date('D', $date));
	
	$monthBox 	= imagettfbbox($tinyFontSize, $fontAngle, $boldFontFile, $monthName);
	$monthX 	= ($iconSize[0] - $monthBox[2]) / 2 - 3;
	imagettftext($baseImage, $tinyFontSize, $fontAngle, $monthX, 24, $textColorTwo, $boldFontFile, $monthName);
	
	$numberBox 	= imagettfbbox($hugeFontSize, $fontAngle, $boldFontFile, $dayNumber);
	$numberX 	= ($iconSize[0] - $numberBox[2]) / 2 - 3;
	imagettftext($baseImage, $hugeFontSize, $fontAngle, $numberX, 65, $textColorOne, $boldFontFile, $dayNumber);
	
	$nameBox 	= imagettfbbox($tinyFontSize, $fontAngle, $fontFile, $dayName);
	$nameX 		= ($iconSize[0] - $nameBox[2]) / 2 - 3;
	imagettftext($baseImage, $tinyFontSize, $fontAngle, $nameX, 90, $textColorTwo, $fontFile, $dayName);

	imagepng($baseImage);
	imagedestroy($baseImage);
?>
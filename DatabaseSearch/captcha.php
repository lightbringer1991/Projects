<?php
// Adapted for The Art of Web: www.the-art-of-web.com
// Please acknowledge use of this code by including this header.
// http://www.the-art-of-web.com/php/captcha/

// initialise image with dimensions of 120 x 30 pixels
$width = 120;
$height = 40;
$image = imagecreatetruecolor($width, $height) or die("Cannot initialize new GD image stream");

// set background to white and allocate drawing colours
$background = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
imagefill($image, 0, 0, $background);
$linecolor = imagecolorallocate($image, 0xCC, 0xCC, 0xCC);
$textcolor = imagecolorallocate($image, 0x33, 0x33, 0x33);

// draw random lines on canvas
for ($i = 0; $i < 6; $i++) {
	imagesetthickness($image, rand(1,3));
	imageline($image, 0, rand(0,$height), $width, rand(0,$height), $linecolor);
}

session_start();

// add random digits to canvas
$digit = '';
for($x = 15; $x <= 95; $x += 20) {
	$digit .= ($num = rand(0, 9));
	imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
}

// record digits in global variable
$_SESSION['digit'] = $digit;

// display image and clean up
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
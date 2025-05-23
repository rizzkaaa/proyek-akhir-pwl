<?php
session_start();

$captcha = rand(10000, 99999);
$_SESSION["captcha"] = $captcha;

header("Content-type: image/png");
$image = imagecreate(120,40);
$bg = imagecolorallocate($image,255,255,255);
$text = imagecolorallocate( $image, 0,0,0) ;
$line = imagecolorallocate( $image,200,200,200) ;

for($i = 0; $i < 3; $i++){
    imageline($image, 0, rand(0,40), 120, rand(0,40), $line);
}

imagestring($image,5,30,10, $captcha, $text);
imagepng( $image );
imagedestroy( $image );
?>
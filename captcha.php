<?php 
header("Content-type: image/png"); 
$string = "abcdefghijklmnopqrstuvwxyz0123456789"; 
$szesc_znakow = NULL;
for($i=0;$i<6;$i++){
    $pozycja_znaku = rand(0,strlen($string));
    $szesc_znakow .= $string[$pozycja_znaku];
}
 
$obrazek = ImageCreate(60, 20) or die("Serwer posiada biblioteke GD?");
//255, 255, 255 - czyli kolor bialy
$kolor_tla = ImageColorAllocate($obrazek, 255, 255, 255);
//0, 0, 0 - czyli kolor czarny
$kolor_tekstu = ImageColorAllocate($obrazek, 0, 0, 0);
ImageString($obrazek, 32, 5, 0, $szesc_znakow, $kolor_tekstu);
Imagepng($obrazek);
 
session_start();
$_SESSION['captcha'] = $szesc_znakow;
?>
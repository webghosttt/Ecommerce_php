<?php
// Create a simple image with text "COD"
$image = imagecreatetruecolor(300, 200);
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 102, 204);
$border_color = imagecolorallocate($image, 200, 200, 200);

// Fill background
imagefilledrectangle($image, 0, 0, 300, 200, $bg_color);

// Add border
imagerectangle($image, 0, 0, 299, 199, $border_color);

// Add text
$font_size = 5;
$text = "CASH ON DELIVERY";
$text_width = imagefontwidth($font_size) * strlen($text);
$text_height = imagefontheight($font_size);
$x = (300 - $text_width) / 2;
$y = (200 - $text_height) / 2;

imagestring($image, $font_size, $x, $y, $text, $text_color);

// Save the image
imagepng($image, './image/cod.png');
imagedestroy($image);

echo "COD image created successfully in image/cod.png";
?> 
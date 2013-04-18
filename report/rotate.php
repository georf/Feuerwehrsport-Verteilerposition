<?php
// File and rotation
$filename = 'verteiler.png';

for ($i = 225; $i < 360 + 225; $i++) {

// Load
$source = imagecreatefrompng($filename);

// Rotate
$rotate = imagerotate($source, $i, -1);
imagealphablending($rotate, true);
imagesavealpha($rotate, true);

// Output
imagepng($rotate, ($i - 225).'-'.$filename);
}

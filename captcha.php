<?php
session_start();

// Generate 3 random uppercase letters or numbers (excluding ambiguous ones)
$captcha_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Exclude O, I, 0, 1
$captcha = substr(str_shuffle($captcha_chars), 0, 3);
$_SESSION['captcha'] = $captcha;

// Create image
$img = imagecreatetruecolor(120, 40);

// Colors
$bg = imagecolorallocate($img, 240, 240, 240);
$fg = imagecolorallocate($img, 20, 20, 20);
$line_color = imagecolorallocate($img, 120, 120, 120);

// Fill background
imagefilledrectangle($img, 0, 0, 120, 40, $bg);

// Add random lines for noise
for ($i = 0; $i < 5; $i++) {
	imageline(
		$img,
		rand(0, 120), rand(0, 40),
		rand(0, 120), rand(0, 40),
		$line_color
	);
}

// Add each letter with random rotation and y-offset
for ($i = 0; $i < 3; $i++) {
	$letter = $captcha[$i];
	$angle = rand(-30, 30); // random rotation
	// Larger font size for TTF
	$font_size = rand(34, 38); // make font size slightly larger for TTF
	$x = 10 + $i * 37 + rand(-2, 2); // adjust x position for even larger letters
	$y = rand(34, 39); // adjust y position for better vertical centering
	if (function_exists('imagettftext')) {
		$font_file = __DIR__ . '/arial.ttf'; // You need to provide a TTF font file
		if (file_exists($font_file)) {
			imagettftext($img, $font_size, $angle, $x, $y, $fg, $font_file, $letter);
		} else {
			// fallback to imagestring if no TTF font
			imagestring($img, 5, $x, $y - 20, $letter, $fg);
		}
	} else {
		imagestring($img, 5, $x, $y - 20, $letter, $fg);
	}
}

// Output as PNG image
header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
?>
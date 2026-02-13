<?php
session_start();

class Captcha {
	private $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
	private $length = 3;
	private $code;
	private $img;
	private $different_levels = true;

	public function __construct($different_levels = true) {
		$this->different_levels = $different_levels;
		$this->generateCode();
		$_SESSION['captcha'] = $this->code;
		$this->createImage();
	}

	private function generateCode() {
		$this->code = substr(str_shuffle($this->chars), 0, $this->length);
	}

	private function createImage() {
		$this->img = imagecreatetruecolor(120, 40);
		$bg = imagecolorallocate($this->img, 240, 240, 240);
		$fg = imagecolorallocate($this->img, 20, 20, 20);
		$line_color = imagecolorallocate($this->img, 120, 120, 120);
		imagefilledrectangle($this->img, 0, 0, 120, 40, $bg);
		for ($i = 0; $i < 5; $i++) {
			imageline(
				$this->img,
				rand(0, 120), rand(0, 40),
				rand(0, 120), rand(0, 40),
				$line_color
			);
		}
		for ($i = 0; $i < $this->length; $i++) {
			$letter = $this->code[$i];
			$angle = rand(-30, 30);
			$font_size = rand(34, 38);
			$x = 10 + $i * 37 + rand(-2, 2);
			$y = $this->different_levels ? rand(34, 39) : 39;
			$use_ttf = function_exists('imagettftext') && file_exists(__DIR__ . '/arial.ttf');
			if ($use_ttf) {
				$font_file = __DIR__ . '/arial.ttf';
				imagettftext($this->img, $font_size, $angle, $x, $y, $fg, $font_file, $letter);
			} else {
				imagestring($this->img, 5, $x, $y - 20 + ($this->different_levels ? rand(-6, 6) : 0), $letter, $fg);
			}
		}
	}

	public function output() {
		header('Content-Type: image/png');
		imagepng($this->img);
		// imagedestroy($this->img); // Deprecated, can be omitted
	}
}

$captcha = new Captcha(true); // Set to false for aligned letters
$captcha->output();
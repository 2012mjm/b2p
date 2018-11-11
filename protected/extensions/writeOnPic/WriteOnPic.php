<?php
/**
 * This class is a writer on picture
 * 
 * @package    Write on picture
 * @author     Nabi KaramAliZadeh <info@nabi.ir>
 * @copyright  2008 (c) Nabi.ir
 * @license    http://www.gnu.org/copyleft/gpl.html
 * @version    1.1.0
 * @link       http://weblog.nabi.ir/post-27.html [documentation in persian]
 * @since      12 April 2008
 */
class WriteOnPic
{
	const TOP 		= 1;
	const RIGHT 	= 2;
	const BOTTOM 	= 3;
	const LEFT 		= 4;
	const CENTER	= 5;
	
	public $inputImage 		= null;						// input file name
	public $outputImage 	= null;						// output file name
	public $outputType 		= null;						// output file format: 			JPG, PNG, GIF, BMP
	public $text 			= null;						// text to write on image
	public $fontSize 		= 5;						// text size: 					1,2,3,4,5
	public $textColor 		= array(255, 255, 255);		// text color: RGB decimal
	public $borderFlag 		= true;						// flag of border: 				TRUE, FALSE
	public $borderColor 	= array(0, 0, 0);			// border color: 				RGB decimal
	public $backFlag 		= false;					// flag of background: 			TRUE, FALSE
	public $backColor 		= array(200, 200, 200);		// background color: 			RGB decimal
	public $marginH 		= 0;						// text horizonatal margin in pixels
	public $marginV 		= 0;						// text vertical margin in pixels
	public $alignH 			= self::LEFT;				// text horizonatal position, 	LEFT | CENTER | RIGHT
	public $alignV 			= self::BOTTOM;				// text vertical position, 		TOP | CENTER | BOTTOM
	public $quality 		= 85;						// quality out file, only for JPG format
	public $opacity 		= 60;						// text opacity: 				0-100
	public $show 			= false;					// show image: 					TRUE, FALSE
	public $save 			= false;					// save out file: 				TRUE, FALSE
	public $error 			= null;						// return error message
	
	function action()
	{
		// Set function to create image
		if (!$this->inputImage)
		{
			$this->error = 'Not found input file.';
			return false;
		}

		$pathinfo = pathinfo($this->inputImage);
		switch (strtolower($pathinfo['extension']))
		{
			case "png":
				$createFunc = "imagecreatefrompng";
			break;
			case "gif";
				$createFunc = "imagecreatefromgif";
			break;
			case "bmp";
				$createFunc = "imagecreatefrombmp";
			break;
			case "jpeg":
			case "jpg":
				$createFunc = "imagecreatefromjpeg";
			break;
		}

		if (!$this->outputImage) {
			$this->outputImage = $this->inputImage;
		}
		if(!$this->outputType) {
			$pathinfo = pathinfo($this->outputImage);
			$this->outputType = strtolower($pathinfo['extension']);
		}
		
		// Create image
		$im = @$createFunc($this->inputImage);
		
		if (!$im)
		{
			$this->error = 'Invalid format file.';
			return false;
		}
		
		// Create box
		$this->fontSize = intval($this->fontSize);
		if ($this->fontSize < 1) $this->fontSize = 1;
		if ($this->fontSize > 5) $this->fontSize = 5;
		$width = strlen($this->text) * ($this->fontSize + 4);
		$height = $this->fontSize + 12;
		
		$overlay_img = imagecreatetruecolor($width+2, $height+2);
		
		if ($this->backFlag)
		{
			$bgColor = imagecolorallocate($overlay_img, $this->backColor[0], $this->backColor[1], $this->backColor[2]);
		}
		else 
		{
			$bgColor = imagecolortransparent($overlay_img);
		}
		
		imagefill($overlay_img ,0 ,0 ,$bgColor);
		
		// Insert border
		if ($this->borderFlag)
		{
			$color = imagecolorallocate($overlay_img, $this->borderColor[0], $this->borderColor[1], $this->borderColor[2]);
			imagestring($overlay_img, $this->fontSize, 0, 0, $this->text, $color);
			imagestring($overlay_img, $this->fontSize, 2, 2, $this->text, $color);
			imagestring($overlay_img, $this->fontSize, 2, 0, $this->text, $color);
			imagestring($overlay_img, $this->fontSize, 0, 2, $this->text, $color);
		}
		
		// Insert text
		$color = imagecolorallocate($overlay_img, $this->textColor[0], $this->textColor[1], $this->textColor[2]);
		imagestring($overlay_img, $this->fontSize, 1, 1, $this->text, $color);
		
		// Get width and height box
		$overlay_w = ImageSX($overlay_img);
		$overlay_h = ImageSY($overlay_img);
		
		// Get width and height image
		$im_w = ImageSX($im);
		$im_h = ImageSY($im);
		
		// Set X text
		switch (strtoupper($this->alignH))
		{
			case self::CENTER:
				$x = ($im_w - $overlay_w) / 2;
			break;
			case self::RIGHT:
				$x = $im_w - $overlay_w - $this->marginH;
			break;
			case self::LEFT:
				$x = 0 + $this->marginH;
			break;
		}
		
		// Set Y text
		switch (strtoupper($this->alignV))
		{
			case self::CENTER:
				$y = ($im_h - $overlay_h) / 2;
			break;
			case self::BOTTOM:
				$y = $im_h - $overlay_h - $this->marginV;
			break;
			case self::TOP:
				$y = 0 + $this->marginV;
			break;
		}
		
		// Merge text box with image
		if(!imagecopymerge($im, $overlay_img, $x, $y, 0, 0, $overlay_w, $overlay_h, $this->opacity))
		{
			$this->error = 'Error Merge text box with image.';
			return false;
		}
		
		// Destroy text box
		if(!imagedestroy($overlay_img))
		{
			$this->error = 'Error Destroy text box.';
			return false;
		}
		
		// Save to disk
		if ($this->save)
		{
			switch ($this->outputType)
			{
				case "png":
					$result = imagepng($im, $this->outputImage);
				break;
				case "gif";
					$result = imagegif($im, $this->outputImage);
				break;
				case "bmp";
					$result = imagewbmp($im, $this->outputImage);
				break;
				case "jpeg":
				case "jpg":
					$result = imagejpeg($im, $this->outputImage, $this->quality);
				break;
			}
			
			if(!$result) {
				$this->error = 'Error Save to disk.';
				return false;
			}
		}
		
		// Show the image
		if ($this->show)
		{
			switch ($this->outputType)
			{
				case "png":
					header("Content-type: image/png");
					$result = imagepng($im);
				break;
				case "gif";
					header("Content-type: image/gif");
					$result = imagegif($im);
				break;
				case "bmp";
					header("Content-type: image/bmp");
					$result = imagewbmp($im);
				break;
				case "jpeg":
				case "jpg":
					header("Content-type: image/jpeg");
					$result = imagejpeg($im, null, $this->quality);
				break;
			}
			
			if(!$result) {
				$this->error = 'Error Show the image.';
				return false;
			}
		}
		
		// Destroy image
		if(!imagedestroy($im)) {
			$this->error = 'Error Destroy image.';
			return false;
		}
		return true;
	}
}
?>

<?php
/**
 * This example is for writer on picture class
 * 
 * @name       Example write on picture
 * @author     Nabi KaramAliZadeh <info@nabi.ir>
 * @copyright  2008 (c) Nabi.ir
 * @license    http://www.gnu.org/copyleft/gpl.html
 * @version    1.0.0
 * @link       http://weblog.nabi.ir/post-27.html [documentation in persian]
 * @since      12 April 2008
 */

require_once ('write_on_pic.class.php');

$base = 120;
$step = 25;

$objWriter = new Write_On_Pic();

$objWriter->inputImage 	= 'aquarius.jpeg';
$objWriter->inputType 	= 'jpg';
$objWriter->outputImage = 'aquarius2.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(255, 255, 255);
$objWriter->borderFlag	= true;
$objWriter->borderColor = array(0, 0, 0);
$objWriter->backFlag	= true;
$objWriter->backColor	= array(255, 0, 0);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 50;
$objWriter->show 		= false;
$objWriter->save 		= true;
$objWriter->Action();


$objWriter->inputImage 	= 'aquarius2.png';
$objWriter->inputType 	= 'png';
$objWriter->outputImage = 'aquarius3.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(255, 0, 255);
$objWriter->borderFlag	= true;
$objWriter->borderColor = array(0, 0, 0);
$objWriter->backFlag	= true;
$objWriter->backColor	= array(0, 0, 0);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 40;
$objWriter->show 		= false;
$objWriter->save 		= true;
$objWriter->Action();


$objWriter->inputImage 	= 'aquarius3.png';
$objWriter->inputType 	= 'png';
$objWriter->outputImage = 'aquarius4.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(0, 0, 0);
$objWriter->borderFlag	= false;
$objWriter->borderColor = array(0, 0, 0);
$objWriter->backFlag	= true;
$objWriter->backColor	= array(255, 255, 255);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 100;
$objWriter->show 		= false;
$objWriter->save 		= true;
$objWriter->Action();


$objWriter->inputImage 	= 'aquarius4.png';
$objWriter->inputType 	= 'png';
$objWriter->outputImage = 'aquarius5.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(255, 255, 255);
$objWriter->borderFlag	= true;
$objWriter->borderColor = array(0, 0, 0);
$objWriter->backFlag	= false;
$objWriter->backColor	= array(0, 0, 0);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 100;
$objWriter->show 		= false;
$objWriter->save 		= true;
$objWriter->Action();


$objWriter->inputImage 	= 'aquarius5.png';
$objWriter->inputType 	= 'png';
$objWriter->outputImage = 'aquarius6.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(51, 170, 230);
$objWriter->borderFlag	= false;
$objWriter->borderColor = array(0, 0, 0);
$objWriter->backFlag	= false;
$objWriter->backColor	= array(0, 0, 0);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 100;
$objWriter->show 		= false;
$objWriter->save 		= true;
$objWriter->Action();


$objWriter->inputImage 	= 'aquarius6.png';
$objWriter->inputType 	= 'png';
$objWriter->outputImage = 'aquarius7.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(0, 0, 0);
$objWriter->borderFlag	= true;
$objWriter->borderColor = array(255, 255, 255);
$objWriter->backFlag	= false;
$objWriter->backColor	= array(0, 0, 0);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 20;
$objWriter->show 		= false;
$objWriter->save 		= true;
$objWriter->Action();


$objWriter->inputImage 	= 'aquarius7.png';
$objWriter->inputType 	= 'png';
$objWriter->outputImage = 'aquarius8.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(0, 0, 0);
$objWriter->borderFlag	= true;
$objWriter->borderColor = array(255, 255, 255);
$objWriter->backFlag	= true;
$objWriter->backColor	= array(0, 0, 0);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 15;
$objWriter->show 		= false;
$objWriter->save 		= true;
$objWriter->Action();


$objWriter->inputImage 	= 'aquarius8.png';
$objWriter->inputType 	= 'png';
$objWriter->outputImage = 'aquarius9.png';
$objWriter->outputType 	= 'png';
$objWriter->text 		= 'http://weblog.nabi.ir/';
$objWriter->fontSize 	= 5;
$objWriter->textColor 	= array(0, 255, 0);
$objWriter->borderFlag	= true;
$objWriter->borderColor = array(0, 0, 0);
$objWriter->backFlag	= true;
$objWriter->backColor	= array(0, 255, 0);
$objWriter->marginH 	= 0;
$objWriter->marginV 	= $base += $step;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'TOP';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 45;
$objWriter->show 		= true;
$objWriter->save 		= true;
$objWriter->Action();

?>

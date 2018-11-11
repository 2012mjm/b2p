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
$objWriter->marginV 	= 170;
$objWriter->alignH 		= 'CENTER';	
$objWriter->alignV 		= 'BOTTOM';
$objWriter->quality 	= 90;
$objWriter->opacity 	= 50;
$objWriter->show 		= true;
$objWriter->save 		= true;

$return  = $objWriter->Action();

if (!$return)
{
	echo $objWriter->error;
}

?>

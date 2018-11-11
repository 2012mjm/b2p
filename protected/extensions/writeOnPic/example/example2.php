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
$objWriter->outputImage = 'aquarius2.jpg';
$objWriter->outputType 	= 'jpg';
$objWriter->text 		= 'Copyright (c) 2008';
$objWriter->fontSize 	= 3;
$objWriter->textColor 	= array(255, 255, 255);
$objWriter->borderFlag	= true;
$objWriter->borderColor = array(0, 0, 0);
$objWriter->backFlag	= false;
//$objWriter->backColor	= array(255, 0, 0);
$objWriter->marginH 	= 5;
$objWriter->marginV 	= 0;
$objWriter->alignH 		= 'RIGHT';	
$objWriter->alignV 		= 'BOTTOM';
$objWriter->quality 	= 85;
$objWriter->opacity 	= 30;
$objWriter->show 		= true;
$objWriter->save 		= true;

$return  = $objWriter->Action();

if (!$return)
{
	echo $objWriter->error;
}

?>

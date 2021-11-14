<?php 
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

//$cookie = new Cookie('ps');
 
$imgs=$_POST["img"];
 
//echo $img;
$pdf = new PDF();
	$pdf->img($imgs);
 
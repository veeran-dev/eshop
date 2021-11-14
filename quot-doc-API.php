<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');


$id_order = rtrim($_POST['order-id-1'],',');
	new Quotation($id_order."-quotation.rtf","application/rtf",$id_order);
 
?>
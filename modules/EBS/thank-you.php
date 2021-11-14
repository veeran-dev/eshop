<?php
/**
 * EBS payment module thank-you page
 *
 * @author Saradha
 * 
 */


/* SSL Management */
$useSSL = true;

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');
include(dirname(__FILE__).'/EBS.php');

$DR = $_GET['DR'];
$obj = new EBS();
$result = $obj->finalizeOrder($DR);

//echo $DR;
if($result == 0) {
	$smarty->display(dirname(__FILE__).'/thank-you.tpl');
}
else {
	Tools::redirect('index.php?controller=dash-index#/order/'.$result.'/thankyou');
}

include(dirname(__FILE__).'/../../footer.php');	

?>
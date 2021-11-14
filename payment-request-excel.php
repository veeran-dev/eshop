<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
$id_request = $_POST['id_request'];
new PaymentRequestExcel(implode(',', $id_request)); 
?>
<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

$from = $_POST['from'];
$to = $_POST['to'];

new FinanceMasterSalesReport($from,$to); 
?>
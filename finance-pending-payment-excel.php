<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
$id_group = $_POST['group_selection'];
$from = $_POST['fpp_from'];
$to = $_POST['fpp_to'];

new FinancePendingPayment($id_group,$from,$to); 
?>
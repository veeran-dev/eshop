<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
$id_group = $_POST['id_group'];
$id_month = $_POST['request_detail_month'];
$id_employee = $_POST['id_employee'];
 
$rmcustomerbills = new RmCustomerBills(); 
$rmcustomerbills->CustomerBillsExcel($id_group,$id_month,$id_employee); 
?>
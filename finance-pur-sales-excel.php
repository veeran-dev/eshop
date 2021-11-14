<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
$id_fc = $_POST['id_fc'];
$selected_month = $_POST['selected_month'];
$report_type = $_POST['report_type'];
$finance_bill = new FinanceBills(); 
$finance_bill->FinanceBillsExcel($id_fc,$selected_month,$report_type); 
?>
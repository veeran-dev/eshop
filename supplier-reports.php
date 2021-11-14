<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

$type = $_GET['type'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$id_group = $_GET['id_group'];

$context = Context::getContext();
$id_supplier = $context->cookie->s_id;

$reports = new SupplierReports(); 
$reports->generateExcelReport($type, $from_date, $to_date, $id_group, $id_supplier); 
?>
<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

$id_group = Tools::getValue('id_group');
$id_fc = Tools::getValue('id_fc');
$period = Tools::getValue('period');
$period = explode("-", $period);
$report = new WaterDeliveryReport(); 
$report->generateReport($id_group, $id_fc, $period[0], $period[1]);
?>
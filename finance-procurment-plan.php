<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

  
$procurement_excel = new FinanceProcurement(); 
$procurement_excel->downloadProcurementExcel(); 
?>
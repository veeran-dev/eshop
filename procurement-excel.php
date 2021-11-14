<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
$id_fc = $_POST['id_fc'];
  
$procurement_excel = new ProcurementExcel(); 
$procurement_excel->downloadProcurementExcel($id_fc); 
?>
<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
$id_quotation = rtrim($_POST['id-quotation'],',');
new ScnQuotationExcel($id_quotation); 
?>
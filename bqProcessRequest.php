<?php 

require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('BulkController')->processBulkRequest();
//echo $_POST['email'];
<?php 
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/override/controllers/front/PincodeController.php');

$pincodeController = new PincodeController();
echo $pincodeController->ajaxCall();
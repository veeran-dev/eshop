<?php
require(dirname(__FILE__).'/config/config.inc.php');

ControllerFactory::getController('FinanceLoginController')->run();

//echo $login_error;
?>
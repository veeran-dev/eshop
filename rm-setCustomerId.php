<?php
require(dirname(__FILE__).'/config/config.inc.php');
echo ControllerFactory::getController('DashCartController')->setCustomerId();
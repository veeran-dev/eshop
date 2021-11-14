<?php
require(dirname(__FILE__).'/config/config.inc.php');

ControllerFactory::getController('ScnLoginController')->run();

//echo $login_error;
?>
<?php

require(dirname(__FILE__).'/config/config.inc.php');

ControllerFactory::getController('EdgeController')->run();

//echo $login_error;
?>
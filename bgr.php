<?php
require(dirname(__FILE__).'/config/config.inc.php');

ControllerFactory::getController('BgrController')->run();

?>
<?php
require_once(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('DashCartController')->ajaxCall();

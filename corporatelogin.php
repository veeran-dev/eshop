<!--This is for cooperate user login-->
<?php 

require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('AuthController')->cop();

<!--This is for cooperate user new password change file-->
<!--This access the controller called copchangepwdController-->

<?php 

require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('copchangepwdController')->run();
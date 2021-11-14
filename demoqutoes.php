<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/controllers/DemoQutoes.php');

//ControllerFactory::getController('DemoQutoesController')->run();
$demoqutoes = new DemoQutoes();
echo $demoqutoes->ajaxCall();

?>
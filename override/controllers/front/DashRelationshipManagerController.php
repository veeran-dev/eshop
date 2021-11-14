<?php
class DashRelationshipManagerControllerCore extends DashController
{
public function ajaxReturn()
{
	$start_memory = memory_get_usage();
	$id_customer = Tools::getValue('id_customer');
	$getManagerDetails = new DashRelationshipManager();
	$getManagerDetails->getRelationshipManagerDetails($id_customer);
	/*$logger = new FileLogger();
	$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
	$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	*/
}
}
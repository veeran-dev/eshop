<?php
class DashSearchProductControllerCore extends DashController
{

public function ajaxReturn()
{	 
		$q=$_GET['q'];
		$mode=$_GET['mode'];
		$customerid = $_GET['id_customer'];
		$start_memory = memory_get_usage();
		$search = new CorporateUser();
		
		if($mode==1)
			$search->searchAll($q,$customerid);
		else
			$search->search($q,$customerid);
			
		/*$logger = new FileLogger();
		$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
		$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	*/
	}
}
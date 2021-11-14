<?php
class PincapCore extends ObjectModel
{
	public static function companies($id){
		$query ='SELECT grp.id_group, grp.name FROM '._DB_PREFIX_.'view_list list 
						LEFT JOIN '._DB_PREFIX_.'group_lang grp on grp.id_group=list.id_child AND grp.id_lang=1 
						WHERE grp.name != "" AND list.id_user='.$id.'';
		$logger = new FileLogger();
		$logger->setFilename("test.txt");
		$logger->logError($query);
		return Db::getInstance()->ExecuteS($query);
	}

	public static function getUsers($id){
		$query ='SELECT GROUP_CONCAT(cust.id_customer) as cus FROM '._DB_PREFIX_.'customer cust WHERE cust.id_default_group='.$id.'';
		$logger = new FileLogger();
		$logger->setFilename("test.txt");
		$logger->logError($query);
		$result = Db::getInstance()->ExecuteS($query);	
		$logger->logError($result);
		return $result[0]['cus'];
	}
}
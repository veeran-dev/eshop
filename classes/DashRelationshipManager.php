<?php
	
class DashRelationshipManager
{
	
	public function getRelationshipManagerDetails($id_customer)
	{
		$emp_customer_relation = new Customer($id_customer);
		$cus_relationship_id = $emp_customer_relation->id_relationship_manager;
		$relationshipManagerDetails=Db::getInstance()->executeS('SELECT `firstname`,`email`,`phone`,`lastname` FROM `'._DB_PREFIX_.'employee` WHERE id_employee = '.$cus_relationship_id.'');
		/*$relationshipManagerDetails=Db::getInstance()->executeS('SELECT ke.`firstname`,ke.`email`,ke.`phone`,ke.`lastname` FROM `'._DB_PREFIX_.'employee` AS ke,`'._DB_PREFIX_.'customer` AS kc WHERE kc.`id_customer`="'.$id_customer.'" 
		AND kc.`id_relationship_manager`=ke.`id_employee` ');*/
	echo Tools::jsonEncode($relationshipManagerDetails);

	}
}
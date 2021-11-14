<?php
Class State extends StateCore
{
	public function getstatesofcustomerWithCount($id_customer)
	{
		$customer = new Customer((int)($id_customer));
		
		if(Validate::isLoadedObject($customer)) 
		{
			$child_ids = $customer->getChildCustomers();

			$sql = 'SELECT DISTINCT st.`name`, COUNT(st.`id_state`) as count, st.`id_state`, ad.`id_address`, sfm.`id_fulfillment_centre`  
					FROM `'._DB_PREFIX_.'address` ad
					left JOIN `'._DB_PREFIX_.'state` st ON st.`id_state` = ad.`id_state`
					LEFT JOIN `'._DB_PREFIX_.'state_fc_mapping` sfm ON ad.`id_state` = sfm.`id_state`
					left join `'._DB_PREFIX_.'customer_address` kca on(kca.id_address = ad.id_address)
					WHERE kca.id_customer IN('.$child_ids.') AND ad.`deleted` = 0 AND ad.`active` = 1 GROUP BY st.`name`';

			return Db::getInstance()->ExecuteS($sql);
		}

		return array();
	}
	
	public function getaddresbystate($id_state)
	{
		global $cookie;

		$customer=new Customer((int)($cookie->id_customer));
		$ids=$customer->getChildCustomers();

		$sql='select ad.id_address from `'._DB_PREFIX_.'address` ad
					WHERE ad.id_state='.$id_state.' AND ad.id_customer IN('.$ids.') LIMIT 1';

		$result= Db::getInstance()->ExecuteS($sql);
		return $result;
	}

	public function getFcIdByState() {
		$sql = 'SELECT sfm.`id_fulfillment_centre` FROM `'._DB_PREFIX_.'state_fc_mapping` sfm WHERE sfm.`id_state` = '.$this->id;
		return Db::getInstance()->getValue($sql);
	}
}
?>
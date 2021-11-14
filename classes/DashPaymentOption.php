<?php
	
class DashPaymentOption
{
	public function getPaymentOptions($id_customer, $sources = false)//$source ->true = dot com / $csources->false = elite
	{
		/*$paymentoption = Db::getInstance()->ExecuteS('SELECT pg.`id_payment`, pm.`Payment_Name` AS name
													  FROM `'._DB_PREFIX_.'payment_group_map` pg 
													  LEFT JOIN `'._DB_PREFIX_.'payment_option_master` pm ON pg.`id_payment` = pm.`id_payment`
													  WHERE id_customer = "'.$id_customer.'"'); */
		$paymentoption=Db::getInstance()->ExecuteS('SELECT pg.id_payment,pom.Payment_Name AS payment_name
																	FROM `'._DB_PREFIX_.'payment_group_map` pg,`'._DB_PREFIX_.'payment_option_master` pom
																	WHERE pg.id_customer = "'.$id_customer.'" AND pom.id_payment = pg.id_payment  order by pg.id_payment asc');
		if(!$sources)
			echo Tools::jsonEncode($paymentoption);
		else
          return $paymentoption;
	}

	public function getAllPaymentOptions($id_customer) {
		if(isset($id_customer) && $id_customer) {
			$customer = new Customer(intval($id_customer));
			$role = $customer->getCustomerRole();
		}

		if($role == 3) {
			$where = 'WHERE pom.id_payment NOT IN(5)';
		}

		return Db::getInstance()->executeS('SELECT pom.`id_payment`, pom.`Payment_Name` AS name FROM `'._DB_PREFIX_.'payment_option_master` pom '.$where.'');
	}  

	public function checkPaymentOptions($id_customer, $id_payment)
	{
        $customer = new Customer($id_customer);

  		$option = Db::getInstance()->getValue('SELECT `id_payment` FROM `'._DB_PREFIX_.'payment_group_map` WHERE `id_customer`='.$customer->id.' AND `id_payment` = '.$id_payment.' AND `id_default_group` in('.$customer->id_default_group.',0)');
        
        if($option){
        	Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'payment_group_map` WHERE `id_customer`= '.$customer->id.' AND `id_payment` = '.$id_payment.' AND `id_default_group` IN('.$customer->id_default_group.',0)');	
        }
        else{
        	Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'payment_group_map` (`id_default_group`, `id_customer`, `id_payment`) VALUES('.$customer->id_default_group.', '.$customer->id.', '.$id_payment.')');	
        }
		
	}
}
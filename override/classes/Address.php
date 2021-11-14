<?php
class Address extends AddressCore
{
	public static function getAliasAddress($customerId)
	{
		return Db::getInstance()->ExecuteS('SELECT id_address, alias 
											FROM '._DB_PREFIX_.'address 
											WHERE id_customer = '.$customerId.' AND active =1');
	}

	public static function getParticularAddress($id_address)
	{				
		return Db::getInstance()->ExecuteS('SELECT cl.`name` AS country,address.`alias`,address.`firstname`,
										    address.`address1`,address.`postcode`,address.`city`, address.`id_state`,
											address.`phone_mobile`,address.`phone`,state.`name` AS state, address.`company`
											FROM '._DB_PREFIX_.'address AS address
											LEFT JOIN `'._DB_PREFIX_.'state` AS state ON state.`id_state`= address.`id_state`
											LEFT JOIN `'._DB_PREFIX_.'country_lang` AS cl ON cl.`id_country`=address.`id_country` 
											WHERE address.id_address='.$id_address.' 
											AND address.active=1 AND cl.`id_lang`=1');
		 
	}

	public static function getAddressById($id_address)
	{
		return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'address` a 
											WHERE a.`id_address` = '.$id_address.'');
	}

	public static function deleteAddress($address_id, $customerId)
	{
		$addressObj = new Address((int)($address_id));
		$addressObj->deleted = 1;
		if($addressObj->update()) {
			return 1;
		}
	}
 
	public static function getAddressId($customerId)
	{
		$result= Db::getInstance()->ExecuteS('SELECT id_address 
											  FROM '._DB_PREFIX_.'address 
											  WHERE id_customer = '.$customerId.' AND active =1 
											  ORDER BY id_address DESC LIMIT 1');
		return $result;
	}

	public function getstateByGroup($id_default_group)
	{
		$sql = 'SELECT DISTINCT(ka.`id_state`),ks.`name`  
				FROM `'._DB_PREFIX_.'address` ka
				JOIN `'._DB_PREFIX_.'customer` kc ON(kc.`id_customer`=ka.`id_customer`)
				LEFT JOIN `'._DB_PREFIX_.'state` ks ON(ks.`id_state`=ka.`id_state`)
				WHERE kc.`id_default_group`='.$id_default_group.'
				AND ka.`deleted`=0';

		$result= Db::getInstance()->ExecuteS($sql);

		return $result;
	}

	public static function getCustomerTagedAddress($id_customer)
	{ 
		return Db::getInstance()->ExecuteS('SELECT ca.`id_customer`,ca.`id_address` 
											FROM kob_address AS a
											LEFT JOIN kob_customer_address AS ca ON a.`id_address` = ca.`id_address`
											WHERE ca.`id_customer` = '.$id_customer.' AND a.`deleted` = 0 ');
	}

	public static function assignAddressToCustomer($id_customer, $id_address, $action)
	{
 		$check_for_parent = Customer::getParents($id_customer);
		$query;
 		
 		if($action == 0)//insert into customer_address
		{
  			/*$check_for_existing_address = Db::getInstance()->getValue('select count(id_address) from `'._DB_PREFIX_.'address`   WHERE `id_address` = '.(int)($id_address).' and deleted=1');
 			
 			if($check_for_existing_address == 1)
			{
  				//Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'address` SET `deleted` = 0 WHERE `id_address` = '.(int)($id_address));
			}*/

			if( sizeof($check_for_parent) == 0)
			{
				Db::getInstance()->ExecuteS('INSERT INTO `'._DB_PREFIX_.'customer_address` (`id_customer`,`id_parent`,`id_address`) VALUES ('.$id_customer.','.$id_customer.','.$id_address.')');
			}
			else
			{
				for($i = 0; sizeof($check_for_parent) > $i; $i++ )
				{
					if($check_for_parent[$i]['id_customer'])
					{
						Db::getInstance()->ExecuteS('INSERT INTO `'._DB_PREFIX_.'customer_address` (`id_customer`,`id_parent`,`id_address`) VALUES ('.$id_customer.','.$check_for_parent[$i]['id_customer'].','.$id_address.')');
					}
				}
			}

			$result = "1";
		}
		else//delete in custoemr_address
		{
  			//Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'address` SET `deleted`=1 WHERE `id_customer`= '.$id_customer.' AND  `id_address` = '.(int)($id_address));
			if( sizeof($check_for_parent) == 0)
			{
  				Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'customer_address` WHERE id_address = '.$id_address.' AND id_customer='.$id_customer.'');	
			}
			else
			{
				for($i = 0; sizeof($check_for_parent) > $i; $i++ )
				{
 					Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'customer_address` WHERE id_address = '.$id_address.' AND id_customer='.$id_customer.'');
 					/*Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'customer_address` WHERE id_address = '.$id_address.' AND id_customer='.$id_customer.' AND id_parent='.$check_for_parent[$i]['id_customer'].'');*/
  					//Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'address` SET `deleted`=1 WHERE `id_address` = '.(int)($id_address));
 				}
			}

			$result = "1";
		}

		return $result;
	}
	/*To update the address of corporate buyers from the corporateuserprofile.php*/
	public static function addressUpdate($alias, $address_id, $firstname, $company, $address1, $city, $state, $postcode, $phone_mobile)
	{
 		return (Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'address` SET
											`company` = "'.$company.'",
											`alias` = "'.$alias.'",
											`firstname`= "'.$firstname.'",
											`address1` = "'.$address1.'",
											`city`= "'.$city.'",
											`id_state`= "'.$state.'",
											`postcode`= "'.$postcode.'",
											`phone_mobile` = "'.$phone_mobile.'"
											WHERE `id_address` = '.(int)($address_id)));
		
	}

	/**
     * Check if the address is valid
     *
     * @param int $id_address Address id
     *
     * @return bool The address is valid
     */
    public static function isValid($id_address)
    {
        $id_address = (int)$id_address;
        $isValid = Db::getInstance()->getValue('
            SELECT `id_address` FROM '._DB_PREFIX_.'address a
            WHERE a.`id_address` = '.$id_address.' AND a.`deleted` = 0 AND a.`active` = 1
        ');

        return (bool)$isValid;
    }

    public static function getWaterDeliveryAddress($id_user){	    
	    $chn = explode(",",Configuration::get('KOB_FC_CHN_EMP'));
	    $bng = explode(",",Configuration::get('KOB_FC_BNG_EMP'));
	    $mum = explode(",",Configuration::get('KOB_FC_MUM_EMP'));
	    $hyd = explode(",",Configuration::get('KOB_FC_HYD_EMP'));
	    $del = explode(",",Configuration::get('KOB_FC_DEL_EMP'));

	    $fc = 0;
	    if (in_array($id_user, $bng))
		{
			$fc =1;
		}
		else if(in_array($id_user, $chn))
		{
			$fc =2;
		}
		else if(in_array($id_user, $hyd))
		{
			$fc =3;
		}
		else if(in_array($id_user, $mum))
		{
			$fc =4;
		}
		else if(in_array($id_user, $del))
		{
			$fc =6;
		}

        $sql ="select * from "._DB_PREFIX_."water_delivery_address kwda
                    LEFT JOIN "._DB_PREFIX_."address ka on ka.id_address = kwda.id_address
                    WHERE kwda.id_fc=".$fc."";
        return Db::getInstance()->ExecuteS($sql);
    }
}
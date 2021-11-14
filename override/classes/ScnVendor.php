<?php
class ScnVendorCore extends ObjectModel
{
	public function addVendor($vendorName,$tinNo,$cstNo,$website,$creditDays,$paymentMode,$replacement,$vendorComment)
	{
		Db::getInstance()->ExecuteS('INSERT INTO '.DB_PREFIX_.'`vendor`
										  (`name`,`tin`,`cst`,`id_payment`,`credit_days`,`website`,`replacement`,`comments`)
										  VALUES('.$vendorName.','.$tinNo.','.$cstNo.','.$paymentMode.','.$creditDays.','.$website.','.$replacement.','.$vendorComment);
										  return mysql_insert_id();
	}
	
	public function addVendorAddress($addressAlise,$address,$city,$state,$country,$pincode,$phone,$fax,$workingHours,$delivery,$workingDays,$addressComment)
	{
		Db::getInstance()->ExecuteS('INSERT INTO '.DB_PREFIX_.'`vendor_address`
		(`id_vendor`,`alise`,`address1`,`city`,`id_state`,`country`,`pincode`,`phone`,`fax`,`delivery`,`working_hour`,`working_days`,`comments`)
		VALUES(SELECT MAX(id_vendor) FROM '.DB_PREFIX_.'_vendor,'.$addressAlise.','.$address.','.$city.','.$state.','.$country.','.$pincode.','.$phone.','.$fax.','.$delivery.','.$workingHours.','.$workingDays.','.$addressComment);
		
		
	}
	/*public function setDefaultAddressPOC($id_vendor,$id_address,$id_poc)
	{
		Db::getInstance()->ExecuteS('UPDATE `'._DB_PREFIX_.'vendor` SET
		`id_default_address`= "'.$id_address.'",
		`id_default_poc` = "'.$id_poc.'"	
		WHERE `id_vendor` = '.$id_vendor);
 	}*/
	
}
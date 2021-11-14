<?php

class CartRule extends CartRuleCore
{
	/*Return the vouchers assign for perticular group*/
	Public static function getGroupCartRules($id_group)
	{
		
   		return Db::getInstance()->ExecuteS("SELECT * FROM `"._DB_PREFIX_."cart_rule_group` as crg left join "._DB_PREFIX_."cart_rule as cr on cr.`id_cart_rule` = crg.`id_cart_rule` where crg.`id_group` = ".$id_group." AND  cr.active = 1	AND cr.quantity > 0 AND cr.date_from < now() and cr.date_to > now() order by cr.minimum_amount asc ");
	}
	 
	 
	
}
?>
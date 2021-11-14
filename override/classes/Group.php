<?php
Class Group extends GroupCore
{

	public function addRMtoAllUsers($id_relationship_manager){
		$sql = "UPDATE `"._DB_PREFIX_."customer` set id_relationship_manager=".$id_relationship_manager." WHERE id_default_group=".$this->id."";
		return Db::getInstance()->ExecuteS($sql);
	}

	public static function getGroupById($id_group,$id_lang)
	{
		return Db::getInstance()->ExecuteS('SELECT g.*,gl.`name` 
											FROM `'._DB_PREFIX_.'group` g
											LEFT JOIN `'._DB_PREFIX_.'group_lang` gl ON g.`id_group` = gl.`id_group`
											WHERE g.`id_group` = '.$id_group.' AND gl.`id_lang` = '.$id_lang.'');
	}

	public static function getGroupByName($name)
	{
		return Db::getInstance()->ExecuteS('SELECT g.*,gl.`name` 
											FROM `'._DB_PREFIX_.'group` g
											LEFT JOIN `'._DB_PREFIX_.'group_lang` gl ON g.`id_group` = gl.`id_group`
											WHERE gl.`name` = "'.$name.'" AND gl.`id_lang` = 1');
	}

	public static function getGroupsName($name)
	{
		return Db::getInstance()->ExecuteS('SELECT g.`id_group` as id,gl.`name` 
											FROM `'._DB_PREFIX_.'group` g
											LEFT JOIN `'._DB_PREFIX_.'group_lang` gl ON g.`id_group` = gl.`id_group`
											WHERE gl.`name` like "%'.$name.'%" AND gl.`id_lang` = 1');
	}

	public  function updateNameToGroupLang($id_group,$id_lang,$group_name)
	{
		return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'group_lang` SET `name` = "'.$group_name.'"
										   WHERE `id_group` = '.$id_group.' AND `id_lang` = '.$id_lang.'');
	}

	public static function deleteCustomerFromGroup($id_customer,$id_group)
	{
		return Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'customer_group` WHERE `id_group` = '.(int)($id_group).' AND `id_customer` = '.(int)($id_customer).'');
	}

	public function getGroupForVerification($type = false,$id_lang,$id_group)
	{
 		 
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT g.`id_group`, g.`reduction`,g.`verification_document`,g.`verification_status`, g.`price_display_method`, gl.`name`
		FROM `'._DB_PREFIX_.'group` g
		LEFT JOIN `'._DB_PREFIX_.'group_lang` AS gl ON (g.`id_group` = gl.`id_group` AND gl.`id_lang` = '.(int)($id_lang).')
		 WHERE  g.id_group = '.$id_group.' ORDER BY g.`id_group` ASC');
	}
}
?>
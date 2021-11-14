<?php

class DealCore extends ObjectModel
{	
	public		$id_group;
	
	public		$id_specific_price;

	public 		$id_employee;

	public 		$date_add;

	public 		$date_upd;

	public 		$active=1;
	

	protected 	$table = 'deal';
	protected 	$identifier = 'id_deal';
	protected 	$fieldsRequired = array('id_group','id_specific_price','id_employee','active');
	protected 	$fieldsValidate = array('id_group' => 'isUnsignedId','id_specific_price'=>'isUnsignedId','id_employee'=> 'isUnsignedId','active'=>'isBool');

	public	function getFields()
	{
	 	parent::validateFields();

		$fields['id_group'] = (int)$this->id_group;
		$fields['id_specific_price'] = (int)$this->id_specific_price;
		$fields['id_employee'] = (int)$this->id_employee;
		$fields['date_add'] = pSQL($this->date_add);
		$fields['date_upd'] = pSQL($this->date_upd);
		$fields['active'] = (int)$this->active;
		return $fields;
	}
	public static function findGroup($id_group)
	{
		$sql='select * from `'._DB_PREFIX_.'deal` where id_group='.$id_group;
		$result=Db::getInstance()->ExecuteS($sql);
		return $result;
	}
	public static function findDeal($id_group)
	{
		/*$sql='SELECT kp.`price` as actualPrice,kd.*,kpl.*, ksp.* FROM `'._DB_PREFIX_.'deal` kd 
				JOIN `'._DB_PREFIX_.'specific_price` ksp ON(kd.`id_specific_price`=ksp.`id_specific_price`)
				JOIN `'._DB_PREFIX_.'product_lang` kpl ON(ksp.`id_product`=kpl.`id_product`)
				JOIN `'._DB_PREFIX_.'product` kp ON(ksp.`id_product`=kp.`id_product`)
				WHERE kd.`id_group`='.$id_group.' AND kpl.`id_lang`=1';*/
		$sql='select kpl.`name`,kpl.`link_rewrite`, kd.`id_deal`,kd.`active`,ksp.* from `'._DB_PREFIX_.'deal` kd 
				JOIN `'._DB_PREFIX_.'specific_price` ksp ON(kd.`id_specific_price`=ksp.`id_specific_price`)
				JOIN `'._DB_PREFIX_.'product_lang` kpl ON(ksp.`id_product`=kpl.`id_product`)
				where kpl.id_lang=1 AND kd.id_group='.$id_group.'';
		$result=Db::getInstance()->ExecuteS($sql);
		return $result;
	}
	public static function checkProductInDeal($id_group,$id_product)
	{
		$sql='SELECT * FROM `'._DB_PREFIX_.'deal` kd
						LEFT JOIN `'._DB_PREFIX_.'specific_price` ksp ON(kd.`id_specific_price`=ksp.`id_specific_price`)
						WHERE ksp.`id_group`='.$id_group.' AND ksp.`id_product`='.$id_product.' ';
		$result=Db::getInstance()->ExecuteS($sql);
		return $result;
	}
	public function Deactive()
	{
		global $cookie;
		$now=date('Y-m-d H:i:s');
		$sql='update `'._DB_PREFIX_.'deal` set active=0,date_upd="'.$now.'",id_employee='.$cookie->id_employee.'
					 where id_deal='.$this->id.' ';
		$result=Db::getInstance()->ExecuteS($sql);
		return $result;

	}
}

<?php
/*
Represents a relationship manager.
*
*  @author Karthik R <karthik@kobster.com>
*  @copyright  2014-2015 Kobster
*  @version  Release: $Revision: 14001 $
*/

class RelationshipManagerCore extends ObjectModel
{
	public 		$id_relationship_manager;

	/** @var string Secure key */
	public		$name;

	/** @var string protected note */
	public		$email;

	/** @var integer Gender ID */
	public		$phone;

	protected $tables = array ('relationship_manager');

 	protected 	$fieldsRequired = array('name', 'email', 'phone');
 	protected 	$fieldsValidate = array('name' => 'isName', 'email' => 'isEmail');
	protected 	$table = 'relationship_manager';
	protected 	$identifier = 'id_relationship_manager';

	public function getFields()
	{
		parent::validateFields();
		$fields['id_relationship_manager'] = (int)($this->id_relationship_manager);
		$fields['name'] = (int)$this->name;
		$fields['email'] = (int)$this->email;
		$fields['phone'] = (int)$this->phone;
		return $fields;
	}

	public static function getCustomerGroup($id_employee)
	{
		/*return Db::getInstance()->ExecuteS('
		SELECT `id_customer`, `firstname` AS "name", `email` AS email,`id_default_group` as default_group
		FROM `'._DB_PREFIX_.'customer`
		WHERE id_relationship_manager ='.$id_employee);*/
	
		return Db::getInstance()->ExecuteS('SELECT g.id_group, gl.name
		from `'._DB_PREFIX_.'group` as g
		left join `'._DB_PREFIX_.'customer` as c on g.id_group = c.id_default_group
		left join `'._DB_PREFIX_.'group_lang` as gl on gl.id_group = c.id_default_group
		WHERE gl.id_lang = 1 AND  c.id_relationship_manager ='.$id_employee.' group by g.id_group');
	}

	public static function getCustomerInGroup($id_group)
	{
		return Db::getInstance()->ExecuteS('SELECT c.`id_customer`, c.`firstname` AS "name", c.`email` AS email,
											c.`id_default_group` as default_group,rm.`name` as role
											FROM `'._DB_PREFIX_.'customer` as c
											LEFT JOIN  `'._DB_PREFIX_.'customer_role` as cr on c.id_customer = cr.id_customer
											LEFT JOIN '._DB_PREFIX_.'customer_group AS cg ON cg.id_customer = c.`id_customer`
											LEFT JOIN `'._DB_PREFIX_.'role_master` as rm on cr.id_role = rm.id_role
											WHERE c.active = 1  and cg.id_group = '.$id_group);
	}

	public static function getCustomerRateContractProducts($id_customer)
	{
		global $cookie;
		
		$result=  Db::getInstance()->ExecuteS('SELECT rc.`id_rate_contract` , rc.`id_customer`,rc.`id_product`,rc.`id_product_attribute`, pl.list_name,pl.id_pur_list, p.reference, plang.name,plang.link_rewrite,plang.description_short,rclm.active as purchaselist_active,	t.rate as tax_value	,p.`reference`						
											FROM `'._DB_PREFIX_.'rate_contract` as rc 
											left join '._DB_PREFIX_.'rate_contract_list_mapping as rclm
											on rc.id_rate_contract = rclm.id_rate_contract
											left join '._DB_PREFIX_.'product as p
											on p.id_product = rc.id_product
											left join '._DB_PREFIX_.'product_lang plang
											on plang.id_product = p.id_product											
											left join '._DB_PREFIX_.'purchase_list as pl
											on rclm.id_pur_list = pl.id_pur_list
											left join kob_tax_rule as tr on tr.id_tax_rules_group = p.id_tax_rules_group
											left join kob_tax as t on tr.id_tax = t.id_tax
											where rc.id_customer="'.$id_customer.'" AND p.discontinued = 0 AND  plang.id_lang=1 AND rc.active=1 AND p.active= 1 and 
											if((select count(id_tax) from kob_tax_rule where id_tax_rules_group = p.id_tax_rules_group and id_state = '.$cookie->id_state_vat.') != 0, tr.id_state ='.$cookie->id_state_vat.',tr.id_state =0) ');
		
 		for ($i = 0; $i < sizeof($products); ++$i)
		{
 			$products[$i]['per_month']='';
			$average_results = PurchaseList::getAverageQuantityPerOrder($products[$i]['id_product'],$id_customer);
 			$products[$i]['per_month'] = $average_results;
			$products[$i]['per_month'] = rtrim($products[$i]['per_month'], ', ');
		}
			
 		return $result;
											
	}
	
	public static function deleteRateContractProduct($id_pur_list,$id_rate_contract)
	{
 		if($id_pur_list !=0)
		{
 		       
		Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'rate_contract_list_mapping set active=0 where id_pur_list='.$id_pur_list.' and id_rate_contract='.$id_rate_contract);
		echo "1";
		}
		else
		{
 			Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'rate_contract_list_mapping set active=0 where  id_rate_contract='.$id_rate_contract);
			Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'rate_contract set active=0 where id_rate_contract='.$id_rate_contract);
			echo "2";
		}
	}

	public function isExistsListProduct($id_rate_contract,$id_pur_list,$type)
	{
		if($type == 0)
			$query = 1;
		else
			$query = 0;

		return Db::getInstance()->ExecuteS('SELECT a.`id_rate_contract`,a.`id_pur_list` 
											FROM '._DB_PREFIX_.'rate_contract_list_mapping a 
											WHERE a.`id_rate_contract` = '.(int)$id_rate_contract.' AND a.`id_pur_list` = '.(int)$id_pur_list.'
											AND a.`active` = '.(int)$query.'');
	}

	public function mapProductWithList($id_rate_contract,$id_pur_list)
	{

		if(RelationshipManager::isExistsListProduct($id_rate_contract,$id_pur_list,0))
		{
			//do nothing if exists in list and is active list
		}
		elseif(RelationshipManager::isExistsListProduct($id_rate_contract,$id_pur_list,1))
		{
			//activate list if list is in inactive status

			Db::getInstance()->ExecuteS('UPDATE `'._DB_PREFIX_.'rate_contract_list_mapping` a
										 SET a.`active` = 1 
										 WHERE a.`id_pur_list` = '.$id_pur_list.' AND a.`id_rate_contract` = '.$id_rate_contract.'');
		}
		else
		{
			//insert values if not exists

			Db::getInstance()->ExecuteS('INSERT INTO `'._DB_PREFIX_.'rate_contract_list_mapping`(`id_rate_contract`,`id_pur_list`)
										 VALUES('.$id_rate_contract.','.$id_pur_list.')');
		}
	}

	public function getRmByCompany($id_company)
	{
		return Db::getInstance()->ExecuteS('SELECT DISTINCT c.`id_relationship_manager` 
											FROM `'._DB_PREFIX_.'customer` c
											WHERE c.`id_default_group` = '.$id_company.'');
	}

	public function searchCustomer($query_string)
	{
		return Db::getInstance()->executeS('SELECT * from  `'._DB_PREFIX_.'customer` where firstname LIKE "%'.$query_string.'%" OR email LIKE "%'.$query_string.'%" and active = 1');
	}
}
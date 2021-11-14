<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14001 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class CorporateCore extends ObjectModel
{
	public 		$id_corporate;
	
	/** @var string Name */
	public 		$name;
	
	/** @var string e-mail */
	public 		$email_id;
	
	/** @var string phone no */
	public 		$mobile_no;
	
	/** @var string company name */
	public 		$company_name;
	
	protected 	$table = 'cor_landing';
	protected 	$identifier = 'id_landing_cor';

	public function getFields()
	{
		parent::validateFields();
		$fields['email_id'] = pSQL($this->email_id);
		$fields['name'] = pSQL($this->name);
		$fields['mobile_no'] = pSQL($this->mobile_no);
		$fields['company_name'] = pSQL($this->company_name);
		
		return $fields;
	}
	
	/**
	  * Check then return multilingual fields for database interaction
	  *
	  * @return array Multilingual fields
	  */
	public function getTranslationsFieldsChild()
	{
		parent::validateFieldsLang();
		return parent::getTranslationsFields(array('name', 'company_name'));
	}
	
	public function add()
	{
		$row = array('company_name' => $this->company_name, 'name' => $this->name, 'mobile_no' => $this->mobile_no, 
				'email_id' => $this->email_id);
				
		return Db::getInstance()->AutoExecute(_DB_PREFIX_.'cor_landing', $row, 'INSERT');
	}
}


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

class CorporateBankDetailsCore extends ObjectModel
{
	/** @var integer */
	 public $id;
	
	/** @var string */
	public $name;

	/** @var string */
	public $acc_no;

	/** @var string */
	public $ifsc_code;

	/** @var string */	
	public $logo;

	protected	$fieldsRequired = array ('name', 'ifsc_code', 'acc_no');	

	protected 	$table = 'bank_details';
	protected 	$identifier = 'id';
	
	public function getFields()
	{
		parent::validateFields();
		
		$fields['id'] = (int)($this->id);
		$fields['name'] = pSQL($this->name);
		$fields['acc_no'] = pSQL($this->acc_no);
		$fields['ifsc_code'] = pSQL($this->ifsc_code);
		$fields['logo'] = pSQL($this->logo);
		
		return $fields;
	}	

	public static function getAllBankDetails()
	{
		return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'bank_details`');
	}
}
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

class FeedbackCore extends ObjectModel
{
	public 		$id_feedback;
	
	/** @var string Name */
	public 		$name;
	
	/** @var string e-mail */
	public 		$email;

	/** @var string Organization name */
	public 		$message;
	
 	protected 	$fieldsRequired = array();
 	protected 	$fieldsSize = array('email' => 128);
 	protected 	$fieldsValidate = array('email' => 'isEmail');
 	protected 	$fieldsRequiredLang = array('name', 'email');
 	protected 	$fieldsSizeLang = array('name' => 32);
 	protected 	$fieldsValidateLang = array('name' => 'isGenericName', 'message' => 'isCleanHtml');
	
	protected 	$table = 'feedback';
	protected 	$identifier = 'id_feedback';

	public function getFields()
	{
		parent::validateFields();
		$fields['email'] = pSQL($this->email);
		$fields['name'] = pSQL($this->name);
		$fields['message'] = pSQL($this->message);
		
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
		return parent::getTranslationsFields(array('name', 'message'));
	}
	
	public function add()
	{
		$row = array('name' => $this->name, 'message' => $this->message, 'email' => $this->email);
		return Db::getInstance()->AutoExecute(_DB_PREFIX_.'feedback', $row, 'INSERT');
	}
}


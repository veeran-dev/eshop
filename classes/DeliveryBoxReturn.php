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
*  @version  Release: $Revision: 14007 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class DeliveryBoxReturnCore extends ObjectModel
{
	public 		$id_customer;

	/** @var integer Vendor ID */
	public		$box_returned;

	/** @var integer Vendor Bank ID */
	public		$points;

	protected $tables = array ('box_returned');

	protected 	$table = 'box_returned';
	protected 	$identifier = 'id_customer';

	public function getFields()
	{
		parent::validateFields();
		$fields['id_customer'] = (int)($this->id_customer);
		$fields['box_returned'] = (int)($this->box_returned);
		$fields['points'] = (int)($this->points);
		return $fields;
	}
}
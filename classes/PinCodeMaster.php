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

class PinCodeMasterCore extends ObjectModel
{
	/** @var integer Zone id which Pincode belongs */
	public 		$zone_id;

	/** @var integer Zone name which pincode belongs */
	public 		$zone_name;

	/** @var Zone state name */
	public 		$id_state;

	/** @var Zone pin code range start */
	public 		$zone_pin_start;

	/** @var zone pin code range end */
	public		$zone_pin_end;

	/** @var id_fulfillment_center */
	public		$id_fulfillment_center;

	public static $definition = array(
        'table' => 'pincode_master',
        'primary' => 'zone_id',
        'fields' => array(
            'zone_name' =>            array('type' => self::TYPE_STRING),
            'zone_pin_start' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'zone_pin_end' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_fulfillment_center' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            )
    );

 	protected 	$fieldsRequired = array('zone_id', 'zone_name', 'zone_pin_start', 'zone_pin_end');

	public function getFields()
	{
		parent::validateFields();
		$fields['zone_id'] = (int)($this->zone_id);
		$fields['zone_name'] = pSQL($this->zone_name);
		$fields['id_state'] = pSQL($this->id_state);
		$fields['zone_pin_start'] = (int)($this->zone_pin_start);
		$fields['zone_pin_end'] = (int)($this->zone_pin_end);
		$fields['id_fulfillment_center'] = (int)($this->id_fulfillment_center);
		return $fields;
	}

	public static function getZones($include_pan_india = false)
	{	
		$where = "";
		if(!$include_pan_india) {
			$where = 'WHERE zone_id NOT IN('.Configuration::get('PS_REGION_PAN_INDIA').')';
		}

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT `zone_id`, `zone_name`, `id_state`, `zone_pin_start`, `zone_pin_end`
		FROM `'._DB_PREFIX_.'pincode_master` '.$where.' ORDER BY `zone_id` ASC');
	}
	
	public static function checkProductAvailability($productid, $pincode)
	{
	
		if(((int)PinCodeMaster::checkProductZone($productid)) == 1)
			{$sql ='SELECT count(a.zone_id) as count FROM '._DB_PREFIX_.'pincode_master AS a LEFT JOIN '._DB_PREFIX_.'product_zone_mapping AS b ON b.zone_id = a.zone_id WHERE ("'.$pincode.'" BETWEEN a.zone_pin_start AND a.zone_pin_end ) AND b.product_id="'.$productid.'"';
			 
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
			
			$count = $result['count']; 
			
			if ($count == "" || $count == 0)
			{
				$result_status = 0;
			}
			else
			{
				$result_status= 1;
			}
		}
		else
		{	
			$result_status= 1;
		}
		
		return $result_status;
	}
	
	public static function checkProductZone($productid)
	{
		$zoneCheckSql ='SELECT count(zone_id) as count FROM '._DB_PREFIX_.'product_zone_mapping WHERE product_id="'.$productid.'"';
		
 		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($zoneCheckSql);
		
		$count = $result['count']; 
		
		if ($count == "" || $count == 0)
		{
			$result_status=0;
		}
		else
		{
			$result_status=1;
		}
 		return $result_status;
	}

	public static function checkCODAvailable($addressId)
	{
		$sql='SELECT cash_on_delivery FROM '._DB_PREFIX_.'pincode_master AS kpm WHERE ((SELECT postcode FROM '._DB_PREFIX_.'address AS ka WHERE id_address="'.$addressId.'") BETWEEN kpm.zone_pin_start AND kpm.zone_pin_end )';
	 return $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
	}
}


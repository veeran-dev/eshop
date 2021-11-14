<?php

class FulfillmentCentreCore extends ObjectModel
{
	/** @var integer Customer id  */
	//public		$id_fc;

	/** @var integer state id  */
	public		$id_state;

	/** @var integer cityname  */
	public		$city_name;

	/** @var integer order id  */
	public		$id_address;

	/** @var integer order id  */
	public		$id_employee;

	/** @var integer cst  */
	public		$cst;

	/** @var integer tin  */
	public		$tin;

	/** @var integer tin  */
	public		$gst;

		/** @var integer cst_date  */
	public		$lut;

	public 		$lut_date;

	/** @var integer cst_date  */
	public		$cst_date;

	public 		$lut_expiry;


	public static $definition = array(
        'table' => 'fulfillment_centre',
        'primary' => 'id_fulfillment_centre',
        'fields' => array(
            'id_state' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_address' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_employee' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'city_name' =>        array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
            'cst' =>        array('type' => self::TYPE_STRING,'required' => true),
            'tin' =>        array('type' => self::TYPE_STRING, 'required' => true),
            'gst' =>        array('type' => self::TYPE_STRING, 'required' => true),
            'lut' =>        array('type' => self::TYPE_STRING, 'required' => true),
            'lut_date' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'cst_date' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'lut_expiry' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        ),
    );

	public function getFcByAddressId($id_address)
	{

		$sql='select fc.id_fulfillment_centre from `'._DB_PREFIX_.'fulfillment_centre` fc
			join `'._DB_PREFIX_.'address` ad ON fc.id_state=ad.id_state
			where ad.id_address='.$id_address.'';
		$result=Db::getInstance()->getRow($sql);
		if(!$result)
		{
			$result=array('id_fulfillment_centre'=>1);
		}
		return $result;
	}

	public static function  getAllFCentres() {
		$sql = 'SELECT * FROM `'._DB_PREFIX_.'fulfillment_centre` WHERE active = 1';
		return Db::getInstance()->ExecuteS($sql);
	}

	public static function hasFc($id_fc) {
		$sql = 'SELECT * FROM `'._DB_PREFIX_.'fulfillment_centre` WHERE active = 1 and id_fulfillment_centre='.$id_fc.'';
		return Db::getInstance()->ExecuteS($sql);
	}

	public function getFcForGroup($id_default_group, $id_zone)
	{
		$sql='SELECT DISTINCT kfc.`city_name`, kfc.`id_fulfillment_centre` FROM `'._DB_PREFIX_.'fulfillment_centre` kfc
				JOIN `'._DB_PREFIX_.'address` ka ON(ka.`id_state`=kfc.`id_state`)
				JOIN `'._DB_PREFIX_.'customer` kc ON(kc.`id_customer`=ka.`id_customer`)
				WHERE kc.`id_default_group`='.$id_default_group.'
				AND kfc.id_fulfillment_centre = '.$id_zone.'
				AND ka.`active`=1
				AND ka.`deleted`=0
				AND kc.`deleted`=0
				AND kc.`active`=1';
		$result=Db::getInstance()->ExecuteS($sql);
		return $result;
	}

	public function getFcByState($id_state){
		return Db::getInstance()->getRow('SELECT fc.`id_fulfillment_centre`,fc.`city_name` FROM `'._DB_PREFIX_.'fulfillment_centre` fc
			  WHERE fc.`id_state` = '.$id_state.'');
	}

	public function getCities()
	{
		return Db::getInstance()->executeS('SELECT fc.`city_name` FROM `'._DB_PREFIX_.'fulfillment_centre` fc');
	}

	public function getStates()
	{
		return Db::getInstance()->executeS('SELECT s.`id_state`,s.`name` FROM `'._DB_PREFIX_.'fulfillment_centre` fc
																left join `'._DB_PREFIX_.'state` s on fc.id_state = s.id_state');
	}

	public static function getInvoicePrefix($id_fc)
	{
		return Db::getInstance()->executeS('SELECT UCASE(LEFT(s.`name`, 3)) as prefix FROM `'._DB_PREFIX_.'fulfillment_centre` fc
													left join `'._DB_PREFIX_.'state` s on fc.id_state = s.id_state
													WHERE fc.id_fulfillment_centre='.$id_fc.'');
	}

	public function getStateNameByFc() {
		global $cookie;

		$sql = 'SELECT s.`name` FROM `'._DB_PREFIX_.'state_fc_mapping` sfm
				LEFT JOIN `'._DB_PREFIX_.'state` s ON sfm.`id_state` = s.`id_state`
				WHERE sfm.`id_fulfillment_centre` = '.$this->id.' AND sfm.`id_state` = '.$cookie->id_state.'';

		return Db::getInstance()->getValue($sql);
	}

	public function getProductAvailable($id_product) 
	{
		$available = true;

		$pan_india = Db::getInstance()->getValue('SELECT IF(pzm.`zone_id` = 0, 1, 0) AS zone_id 
			FROM `'._DB_PREFIX_.'product_zone_mapping` pzm 
			WHERE pzm.`zone_id` = 0 AND pzm.`product_id` = '.$id_product.''
		);

		$available_in_specific_zone = Db::getInstance()->getValue('SELECT pzm.`zone_id`
			FROM `'._DB_PREFIX_.'product_zone_mapping` pzm 
			WHERE pzm.`zone_id` = '.$this->id.' AND pzm.`product_id` = '.$id_product);

		if(!$pan_india) {
			if(!$available_in_specific_zone) {
				$available = false;
			}
		}

		return $available;
	}

	public static function getProductAvailableZones($id_product) {
		$sql = 'SELECT IF(pzm.`zone_id` != '.Configuration::get('PS_REGION_PAN_INDIA').' , GROUP_CONCAT(fc.`city_name`), "Across India") AS available_regions
				FROM `'._DB_PREFIX_.'product_zone_mapping` pzm
				LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` fc ON pzm.`zone_id` = fc.`id_fulfillment_centre`
				WHERE pzm.`product_id` = '.$id_product.' 
				GROUP BY pzm.`product_id` ORDER BY fc.`city_name` ASC';
		return Db::getInstance()->getValue($sql);
	}

	public function getLutDetails($date){
		$sql ="SELECT lut_number, expiry from `"._DB_PREFIX_."fulfillment_centre_lut` where id_fulfillment_centre=".$this->id." AND start <='".$date."' AND expiry >='".$date."'";
		return Db::getInstance()->executeS($sql);
	}
}
<?php 
class WaterDeliveryCore extends ObjectModel
{
		/** @var integer state id  */
	public		$id_water_delivery;
	public 		$id_address;
	public 		$delivered;
	public 		$empty;
	public 		$date_add;
	public 		$id_employee;


	public static $definition = array(
        'table' => 'water_delivery_details',
        'primary' => 'id_water_delivery',
        'fields' => array(
            'id_address' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_employee' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'delivered' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'empty' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'date_add' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        ),
    );

    public static function getAllCustomerOrders($id_group, $id_fc, $month, $year){
    	$period = "";
    	$fc ="";
    	$group = "";
    	if($id_group){
    		$group = " AND kc.id_default_group=".$id_group."";
    	}
    	if(!$month){
    		$period = " AND month(kwd.date_add)=".date('m')." AND year(kwd.date_add)=".date('Y')." ";
    	}
    	else{
    		$period = " AND month(kwd.date_add)=".$month." AND year(kwd.date_add)=".$year." ";	
    	}

    	if($id_fc){
    		$fc= " AND kfc.id_fulfillment_centre=".$id_fc." ";
    	}

    	$sql = "SELECT kwd.*,kgl.name as company,kpl.name as product_name,ka.alias as alias FROM `kob_address` ka
                    LEFT JOIN "._DB_PREFIX_."customer kc on kc.id_customer=ka.id_customer
                    LEFT JOIN "._DB_PREFIX_."group_lang kgl on kgl.id_group = kc.id_default_group and kgl.id_lang=1
                    LEFT JOIN "._DB_PREFIX_."fulfillment_centre kfc on kfc.id_state=ka.id_state
                    LEFT JOIN "._DB_PREFIX_."water_delivery_details kwd on kwd.id_address=ka.id_address
                    LEFT JOIN "._DB_PREFIX_."product_lang kpl on kpl.id_product = kwd.id_product and kpl.id_lang=1
                    WHERE kwd.id_water_delivery != '' 
                    ".$group."
                    ".$fc."
                    ".$period."";

	    $result=Db::getInstance()->ExecuteS($sql);
	    foreach($result as &$r){
	        $addr = new Address($r['id_address']);
	    	$r['address_format'] = AddressFormat::generateAddress($addr, $addressPatternRules, ',', ' ');
	    	$link = glob('./waterDRs/'.$r['id_water_delivery'].'.*');
	    	$r['link'] = $link[0];
	    }
		return $result;
    }

}
?>
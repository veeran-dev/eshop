<?php

class ZonalPriceCore extends ObjectModel
{
	/** @var integer Customer id  */
	//public		$id_fc;

	/** @var integer state id  */
	public		$id_fulfillment_centre;

	/** @var integer order id  */
	public		$id_product;

	/** @var integer order id  */
	public		$price;
	

	public static $definition = array(
        'table' => 'zonal_price',
        'primary' => 'id_zonal_price',
        'fields' => array(
            'id_fulfillment_centre' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_product' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'price' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
        ),
    );

    public static function getPricebyProductId($id_product)
    { 
    	$sql = "SELECT fc.`id_fulfillment_centre`, zp.`price` FROM `"._DB_PREFIX_."zonal_price` zp 
                LEFT JOIN `"._DB_PREFIX_."fulfillment_centre` fc ON zp.`id_fulfillment_centre` = fc.`id_fulfillment_centre`
                WHERE zp.`id_product` = ".$id_product."";

        $result = Db::getInstance()->ExecuteS($sql);

        $priceList = '';
    	foreach($result as $row) {
            $priceList .= $row['id_fulfillment_centre'].">".$row['price']."<";
        }

        return $priceList;
    }

    public static function updatePriceByZone($id_product, $id_zone, $price = NULL)
    {
        if(!($id_product && $id_zone))
            return "false";

        $sql= '';
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'zonal_price` WHERE id_fulfillment_centre='.$id_zone.' AND id_product='.$id_product.'';
        $result = Db::getInstance()->ExecuteS($sql);

        $catalogHistory = new CatalogHistory();

        if(!empty($result)) {
            $sql1 ='UPDATE `'._DB_PREFIX_.'zonal_price` SET price = '.$price.' WHERE id_fulfillment_centre = '.$id_zone.' AND id_product = '.$id_product.'';

            $content['0'] = array(
                'from' => $result[0]['price'],
                'to' => $price
                );
            $catalogHistory->addHistory('zonal_price',$id_product, $content, $id_zone);
        }
        else {
            $sql1 ='INSERT INTO `'._DB_PREFIX_.'zonal_price`(id_fulfillment_centre,id_product,price) VALUES('.$id_zone.', '.$id_product.', '.$price.')';
            $content['0'] = array(
                'from' => 0,
                'to' => $price
                );
            $catalogHistory->addHistory('zonal_price',$id_product, $content, $id_zone);
        }

        return Db::getInstance()->Execute($sql1);
    }

    public static function getPrices($id_product, $id_zone = NULL)
    {
        $query = $id_zone != NULL ? ' and z.`id_fulfillment_centre` = '.$id_zone.'' : '';

        $sql = "SELECT z.`id_zonal_price`, s.`name`, z.`id_fulfillment_centre`, z.`price`,
                fc.`city_name` 
                FROM `"._DB_PREFIX_."zonal_price` z 
                LEFT JOIN `"._DB_PREFIX_."fulfillment_centre` fc ON fc.`id_fulfillment_centre` = z.`id_fulfillment_centre`
                LEFT JOIN `"._DB_PREFIX_."state` s ON s.`id_state` = fc.`id_state`
                WHERE z.`id_product` = ".$id_product." ".$query."
                ORDER BY z.`id_zonal_price` DESC";

        return Db::getInstance()->ExecuteS($sql);   
    }

    public static function removePrice($id_product, $id_fc) {
        $sql = 'DELETE FROM `'._DB_PREFIX_.'zonal_price` WHERE id_product = '.$id_product.' AND id_fulfillment_centre = '.$id_fc;
        return Db::getInstance()->Execute($sql);
    }

    public static function getPriceByZone($id_product)
    {
        $sql = "select price from "._DB_PREFIX_."zonal_price where id_product=".$id_product;
        return Db::getInstance()->Execute($sql);   
    }

    public static function getZonalPrice($id_product){
        $sql = "SELECT m.city_name, m.id_fulfillment_centre, m.map, p.price
        FROM (SELECT city_name, id_fulfillment_centre, map FROM 
            (SELECT fc.city_name, fc.id_fulfillment_centre, 'yes' as map FROM kob_product_zone_mapping map, kob_fulfillment_centre fc 
                WHERE map.product_id=".$id_product." AND fc.id_fulfillment_centre=map.zone_id 
             UNION ALL SELECT fc.city_name, fc.id_fulfillment_centre, 'no' as map FROM kob_fulfillment_centre fc) as maps 
             GROUP by maps.id_fulfillment_centre) as m
         LEFT JOIN(	
        SELECT city_name, id_fulfillment_centre, price FROM 
            (SELECT fc.city_name, fc.id_fulfillment_centre, price.price as price FROM kob_zonal_price price , kob_fulfillment_centre fc 
                WHERE price.id_product=".$id_product." AND fc.id_fulfillment_centre=price.id_fulfillment_centre
            UNION ALL SELECT fc.city_name, fc.id_fulfillment_centre, '0' as price FROM kob_fulfillment_centre fc) as price 
            GROUP by price.id_fulfillment_centre
         ) as p on p.id_fulfillment_centre=m.id_fulfillment_centre";

        return Db::getInstance()->ExecuteS($sql);
    }
}
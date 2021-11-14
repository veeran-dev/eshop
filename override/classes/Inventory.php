<?php

class InventoryCore extends ObjectModel
{
	public $id_product;
	public $id_fulfillment_centre;
	public $quantity;
	public $added;
	public $removed;
	public $date;
	public $date_add;


	public static $definition = array(
        'table' => 'inventory',
        'primary' => 'id_inventory',
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_fulfillment_centre' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'quantity' =>        array('type' => self::TYPE_INT, 'required' => true),
            'added' =>        array('type' => self::TYPE_INT),
            'removed' =>        array('type' => self::TYPE_INT),
            'date' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'date_add' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        ),
    );

    public static function getProductsDetails($id_fc){

        if($id_fc){
            $fc = "where kfc.id_fulfillment_centre=".$id_fc;
        }
        else{
            $fc = "where kfc.id_fulfillment_centre=1";   
        }
        $sql ="SELECT * FROM (
                SELECT ki.id_product,kpl.name,kpl.link_rewrite,kfc.id_fulfillment_centre,kfc.city_name,kp.price, (SUM(if(ki.added,ki.quantity,0)) - SUM(if(ki.removed,ki.quantity,0))) as total FROM `"._DB_PREFIX_."inventory` ki
                LEFT JOIN "._DB_PREFIX_."product kp on kp.id_product=ki.id_product
                LEFT JOIN "._DB_PREFIX_."product_lang kpl ON kpl.id_product=kp.id_product AND kpl.id_lang=1
                LEFT JOIN "._DB_PREFIX_."fulfillment_centre kfc ON kfc.id_fulfillment_centre=ki.id_fulfillment_centre
                ".$fc."
                GROUP BY ki.id_product) as products 
                where products.total>0 and products.name != ''";
        $res = Db::getInstance()->Executes($sql);
        // var_dump(Product::getProductsProperties(1,$res));
        return Product::getProductsProperties(1,$res);
    }
}
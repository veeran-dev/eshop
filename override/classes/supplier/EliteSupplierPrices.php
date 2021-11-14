<?php
/*
*
*  Supplier Prices
*
*/
class EliteSupplierPricesCore extends ObjectModel
{
    /** @var int supplier ID */
    public $id_supplier;

    /** @var int Company ID */
    public $id_group;

    /** @var int User ID */
    public $id_customer;

    /** @var int State ID */
    public $id_state;

    /** @var int Product ID  */
    public $id_product;

    /** @var float price */
    public $price;

    /** @var datetime from date */
    public $from;

    /** @var datetime to date */
    public $to;

    /** @var bool active */
    public $active;

    /** @var datetime price added date */
    public $date_add;

    /** @var datetime price last updated */
    public $date_upd;

    public static $definition = array(
        'table' => 'elite_supplier_prices',
        'primary' => 'id_supplier_price',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier Prices master */
            'id_supplier' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_group' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_customer' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_state' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_product' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'price' =>  array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'required' => true),
            'from' =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'to' =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        	'active'	=>	array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
        	'date_add' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );

    public static function getSupplierDetails($id_specific_price){
            $getSupplierDetails = "SELECT kes.company, kes.id_supplier from "._DB_PREFIX_."specific_price kesp
                                        LEFT JOIN "._DB_PREFIX_."elite_supplier kes on kes.id_supplier=kesp.id_supplier
                                        WHERE kesp.id_specific_price=".$id_specific_price."";

            return Db::getInstance()->executeS($getSupplierDetails);
    }
}
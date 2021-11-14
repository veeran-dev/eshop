<?php

class PriceHistoryCore extends ObjectModel
{
	public		$id_product;

	public		$id_group;

	public		$id_employee;

	public		$old_price;

	public		$new_price;

	public		$date_update;

	public static $definition = array(
        'table' => 'price_history',
        'primary' => 'id_change_price',
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_employee' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId','required' => true),
            'id_group' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'new_price' =>                        array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'required' => true),
            'old_price' =>                        array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'required' => true),
            'date_update' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        ),
    );
}
?>
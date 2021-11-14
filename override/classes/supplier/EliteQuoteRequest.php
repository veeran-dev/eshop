
<?php

class EliteQuoteRequestCore extends ObjectModel
{
    public $id_product;
    public $period;
    public $frequency;
    public $quantity;
    public $need;
    public $deadline;
    public $payment;
    public $postcode;
    public $date_add;
    public $description;
    public $product_name;
    public $categories;
    public $id_customer;
    public $quoted;


    public static $definition = array(
        'table' => 'elite_quote_request_details',
        'primary' => 'id_quote_request',
        'fields' => array(
            'id_customer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'quoted' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'period' =>     array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'frequency' =>  array('type' => self::TYPE_STRING),
            'quantity' =>   array('type' => self::TYPE_INT),
            'need' =>       array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'payment' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'postcode' =>   array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'deadline' =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'description' =>   array('type' => self::TYPE_STRING, 'size' => 180),
            'product_name' =>   array('type' => self::TYPE_STRING, 'size' => 64),
            'categories' =>   array('type' => self::TYPE_STRING, 'size' => 64),
            'date_add' =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        ),
    );
}
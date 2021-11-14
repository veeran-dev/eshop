<?php

class PerksCustomerCore extends ObjectModel
{
	
	/** @var integer cst  */
	public		$id_group;

	/** @var integer tin  */
	public		$id_customer;


	public static $definition = array(
        'table' => 'perks_group',
        'primary' => 'id_perks_customer',
        'fields' => array(
            'id_group' =>		array('type' => self::TYPE_INT),
            'id_customer' =>       array('type' => self::TYPE_INT),
        ),
    );

    public static function addToPerks($id_customer, $id_group)
    {
    	$logger = new FileLogger();
        $logger->setFilename('test.txt');
        $logger->logError('');

        $customer = new Customer($id_customer);

        $table = "perks_customer";
        $dbData = array(
            'id_group'             => $id_group,
            'id_customer'               => $customer->id
        );

        Db::getInstance()->insert($table, $dbData);


    }
    
}
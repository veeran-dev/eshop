<?php

class PerksCompaniesCore extends ObjectModel
{
	
	/** @var integer cst  */
	public		$id_group;

	/** @var integer tin  */
	public		$email;

    public      $name;

    public $address1;
    public $city;
    public $state;
    public $postdoe;


	public static $definition = array(
        'table' => 'perks_group',
        'primary' => 'id_group',
        'fields' => array(
            'id_group' =>		array('type' => self::TYPE_INT),
            'email' =>          array('type' => self::TYPE_STRING,'required' => true, 'size' => 254),
            'name' =>           array('type' => self::TYPE_STRING),
            'address1' =>           array('type' => self::TYPE_STRING),
            'city' =>           array('type' => self::TYPE_STRING),
            'state' =>           array('type' => self::TYPE_INT),
            'postcode' =>           array('type' => self::TYPE_INT)
        ),
    );

    public static function getAllDomains()
    {
    	$logger = new FileLogger();
        $logger->setFilename('test.txt');
        $logger->logError('SELECT pg.*,s.name as state FROM `'._DB_PREFIX_.'perks_group` pg left join `'._DB_PREFIX_.'state` s on pg.state = s.id_state ');
    	return Db::getInstance()->executeS('SELECT pg.*,s.name as state FROM `'._DB_PREFIX_.'perks_group` pg left join `'._DB_PREFIX_.'state` s on pg.state = s.id_state ');
    }

    public static function getDomains($name)
    {
        $logger = new FileLogger();
        $logger->setFilename('veeran.txt');
        $domain = substr(strrchr($name, "@"), 1);
        $logger->logError($domain);        
        $logger->logError('SELECT * FROM `'._DB_PREFIX_.'perks_group` where email like "%'.$domain.'%"');
    	return Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'perks_group` where email like "%'.$domain.'%"');
    }

}
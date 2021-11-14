<?php
Class CustomerEscalation extends ObjectModel
{
    public $firstname;

    public $lastname;

    public $email;

    public $mobile;

    public $id_employee;

    public $date_add;



	public static $definition = array(
        'table' => 'customer_escalation',
        'primary' => 'id_group',
        'fields' => array(
            'id_employee' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'firstname' =>        array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 128),
            'lastname' =>        array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 128),
            'email' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
            'mobile' =>        array('type' => self::TYPE_STRING, 'size' => 10),
            'date_add' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
        ),
    );

}
?>
<?php
/*
*
* Supplier and Locations Mapping
*
*/
class EliteSupplierLocationsCore extends ObjectModel
{
    /** @var int ID supplier */
    public $id_supplier;

    /** @var int ID order */
    public $id_state;

    /** @var datetime added date */
    public $date_add;

    public static $definition = array(
        'table' => 'elite_supplier_locations',
        'primary' => 'id_supplier_location',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier Orders Mapping */
            'id_supplier' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_state' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'date_add' =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );
}
<?php
/*
*
* Supplier Invoice Series
*
*/
class EliteSupplierInvoiceSeriesCore extends ObjectModel
{
    /** @var int ID supplier */
    public $id_supplier;

    /** @var int ID order */
    public $number;

    public static $definition = array(
        'table' => 'elite_supplier_invoice_series',
        'primary' => 'id_supplier_invoice',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier Invoice Series */
            'id_supplier' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'number' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isCatalogName'),
        )
    );
}
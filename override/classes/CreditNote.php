<?php
Class CreditNote extends ObjectModel
{
	public $id_group;

    public $id_invoice;

	public $id_employee;

	public $date_added;

	public static $definition = array(
        'table' => 'customer_receivables',
        'primary' => 'id_customer_receivables',
        'fields' => array(
            'id_group' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_employee' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_invoice' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'date_add' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
        ),
    );

    public function customerCreditNoteDetails($id_group){

    	$sql = 'SELECT * FROM '._DB_PREFIX_.'group_lang kgl '.
    				'LEFT JOIN '._DB_PREFIX_.'credit_note cn on kcn.id_group = kgl.id_group '.
                    'LEFT JOIN '._DB_PREFIX_.'credit_note_details cn on kcnd.id_credit_note = kcn.id_credit_note '.
    				' WHERE kgl.id_group ='.$id_group.' AND kgl.id_lang=1';

		return Db::getInstance()->execute($sql);
    }
}
?>
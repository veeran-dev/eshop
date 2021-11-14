<?php
Class InvoicePayments extends ObjectModel
{
	public $id_invoice;

	public $amount;

	public $mode;

	public $bank_name;

	public $acc_no;

    public $reference;

    public $received_on;

    public $status;

    public $date_add;



	public static $definition = array(
        'table' => 'invoice_payment_details',
        'primary' => 'id_customer_receivables   ',
        'fields' => array(
            'id_group' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_employee' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'amount' =>            array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
            'particulars' =>        array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 256),
            'date_add' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
        ),
    );

    public function customerReceivablesLedgerDetails($id_group){

    	$sql = 'SELECT * FROM '._DB_PREFIX_.'group_lang kgl '.
    				'LEFT JOIN '._DB_PREFIX_.'customer_receivables kcr '.
    				'LEFT JOIN '._DB_PREFIX_.'invoice_payment_details kipd on kipd.id_customer_receivables=kcr.id_customer_receivables '.
    				'LEFT JOIN '._DB_PREFIX_.'credit_note cn on kcn.id_group = kgl.id_group '.
    				'LEFT JOIN '._DB_PREFIX_.'credit_note_details cn on kcnd.id_credit_note = kcn.id_credit_note '.
    				' WHERE kgl.id_group ='.$id_group.' AND kgl.id_lang=1';

		return Db::getInstance()->execute($sql);
    }

    public function addPaymentDetails($invoice_number, $amount, $mode, $bank_name=null, $acc_no=null, $reference=null, $received_on ){

    	$invoice = getInvoiceByNumber($invoice_number);

		$dbData = array(
			'id_invoice' 		=> $invoice->id_invoice,
			'id_group' 			=> $id_group,
			'amount' 			=> $amount,
			'mode' 				=> $mode,
			'bank_name'			=> $bank_name,
			'acc_no'			=> $acc_no,
			'reference'			=> $reference,
			'received_on'		=> $received_on,
		);
    	Db::getInstance()->insert($table, $dbData);
    }
}
?>
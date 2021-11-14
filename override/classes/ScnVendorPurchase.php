<?php
class ScnVendorPurchaseCore extends ObjectModel
{
    /** @var int vendor id **/
    public $id_vendor;

    /** @var string bill number **/
    public $id_bill_no;

    /** @var int id product **/
    public $id_product;

    /** @var date bill date **/
    public $bill_date;

    /** @var int product quantity **/
    public $product_qty;

    /** @var decimal unit price **/
    public $unit_price;

    /** @var int tax **/
    public $tax;

    /** @var int payment ID **/
    public $id_payment;

    /** @var int active **/
    public $active;

    /** @var datetime date added **/
    public $date_add;

	
    public static $definition = array(
        'table' => 'vendor_purchase_bill',
        'primary' => 'id_vendor_purchase',
        'multilang' => false,
        'fields' => array(
            /* Classic fields */
            'id_vendor' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_bill_no' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 255),
            'id_product' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'unit_price' =>                        array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
            'bill_date' =>                    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate', 'required' => true),
            'product_qty' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'tax' =>                array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
            'id_payment' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active' =>                    array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
            'date_add' =>                    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate')
        )
    );
 	
	public static function getPurchaseBills($id_vendor = NULL, $from = NULL, $to = NULL)
	{
		$where='';		
		if($id_vendor)
			$where=' and v.id_vendor='.$id_vendor;
		if($from && $to)
			$where .=' AND vpb.date_add  BETWEEN "'.$from.' 00:00:00" AND "'.$to.' 23:59:59"';

		return Db::getInstance()->ExecuteS('SELECT DISTINCT(vpb.`id_bill_no`) AS billno, vpb.`id_payment`, 
											DATE_FORMAT(vpb.`bill_date`,"%d %b %Y") AS bill_date, vpb.`id_vendor` ,
											v.`name`,v.`website`, format(SUM(`product_qty`* `unit_price`),2) AS total
											FROM `'._DB_PREFIX_.'vendor_purchase_bill` AS vpb
											LEFT JOIN `'._DB_PREFIX_.'vendor` AS v ON v.`id_vendor` = vpb.`id_vendor`
											WHERE vpb.`active` = 1 '.$where.' 
											GROUP BY id_bill_no,vpb.id_vendor 
											ORDER BY vpb.`date_add` DESC');
	}

	public function getPurchaseBillDetails($billno, $id_vendor)
	{
		return Db::getInstance()->ExecuteS('SELECT vpb.`id_vendor_purchase`,vpb.`product_qty`, vpb.`tax`,vpb.`id_payment`,vpb.`unit_price` AS unit_price,
											pl.`name`, vpb.`id_product`, vpb.`id_vendor`,vpb.`id_bill_no` AS billno, vpb.`bill_date`
											FROM `'._DB_PREFIX_.'vendor_purchase_bill` AS vpb
											LEFT JOIN `'._DB_PREFIX_.'product_lang` AS pl
											ON pl.id_product = vpb.`id_product`
											WHERE pl.id_lang=1 AND vpb.`id_bill_no`= "'.$billno.'" 
											AND vpb.id_vendor = '.$id_vendor.' 
											AND vpb.`active` = 1');
	}

	public function deleteBill($billno, $id_vendor, $id_vendor_purchase)
	{
  		if($id_vendor_purchase!=0)
		{
			$deletproduct = " AND id_vendor_purchase=".$id_vendor_purchase."";
		}
		
  		return Db::getInstance()->ExecuteS('UPDATE `'._DB_PREFIX_.'vendor_purchase_bill` 
  											SET active = 0 
  											WHERE id_bill_no = "'.$billno.'" 
  											AND id_vendor = '.$id_vendor.''.$deletproduct.'');
	}

	public function topVendorDetails($fc = false, $from_date = false, $to_date = false)
	{
		$query = "";
		$query .= $fc && $fc != "" && $fc != 0 ? ' AND v.`id_fulfillment_centre` = '.$fc.'' : "";
		$query .= ($from_date && $to_date == false) ? ' AND DATE(vpb.`bill_date`) = "'.$from_date.'"' : '';
		$query .= ($from_date == false && $to_date) ? ' AND DATE(vpb.`bill_date`) = "'.$to_date.'"' : '';
		$query .= ($from_date && $to_date) ? ' AND vpb.`bill_date` BETWEEN "'.$from_date.'" AND "'.$to_date.'"' : '';
		$query .= (!$from_date && !$to_date) ? ' AND vpb.`bill_date` > DATE_SUB(now(), INTERVAL 6 MONTH)' : '';

		return Db::getInstance()->executeS('SELECT vpb.`id_bill_no` AS billno,vpb.`id_payment`,DATE_FORMAT(vpb.`bill_date`,"%d %b %Y") AS bill_date,
											vpb.id_vendor ,v.`name`,v.`website`, SUM(`product_qty`* `unit_price`) AS total,COUNT(id_bill_no) as consumption 
											FROM `'._DB_PREFIX_.'vendor_purchase_bill`  AS vpb 
											LEFT JOIN `'._DB_PREFIX_.'vendor` AS v ON v.`id_vendor` = vpb.`id_vendor` 
											WHERE vpb.`active`= 1 AND v.`active` = 1 '.$query.' GROUP BY v.id_vendor 
											ORDER BY total DESC LIMIT 10');
	}

	public function getMonthlyPerformance($id_vendor, $from_date = false, $to_date = false)
	{
		$query = "";
		$query .= ($from_date && $to_date == false) ? ' AND DATE(b.`bill_date`) = "'.$from_date.'"' : '';
		$query .= ($from_date == false && $to_date) ? ' AND DATE(b.`bill_date`) = "'.$to_date.'"' : '';
		$query .= ($from_date && $to_date) ? ' AND b.`bill_date` BETWEEN "'.$from_date.'" AND "'.$to_date.'"' : '';

		return Db::getInstance()->ExecuteS('SELECT SUM(b.`unit_price` * b.`product_qty`) AS purchase_total,b.`bill_date`,a.`name` 
											FROM `'._DB_PREFIX_.'vendor` a LEFT JOIN `'._DB_PREFIX_.'vendor_purchase_bill` b ON a.`id_vendor`=b.`id_vendor`
											WHERE a.`id_vendor`="'.$id_vendor.'" AND a.`active` = 1 AND b.`active` = 1 '.$query.'
											GROUP BY MONTH(bill_date) ORDER BY bill_date ASC');
	}

	public function getVendorLists($search_query)
	{
		return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'vendor` v WHERE v.name LIKE "%'.$search_query.'%" AND v.`active`=1');
	}

	public static function changeBill($id_vendor_purchase, $product_qty, $tax, $unit_price, $billdate, $billno, $old_bill_no)
	{	
		$bill_date = date("Y-m-d", strtotime($billdate));

		if($old_bill_no == 0)
			return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'vendor_purchase_bill` SET `product_qty`='.$product_qty.' ,`unit_price`='.$unit_price.', `tax`='.$tax.', `bill_date`="'.$bill_date.'", `id_bill_no`="'.$billno.'" WHERE `id_vendor_purchase`='.$id_vendor_purchase.' ');
		else 
			return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'vendor_purchase_bill` SET `bill_date`="'.$bill_date.'", `id_bill_no`="'.$billno.'" WHERE `id_bill_no`="'.$old_bill_no.'"');
	}
}
<?php
class Order extends OrderCore
{
	public static function addSplitOrderDetail($new , $old){

		$sql ='select root from '._DB_PREFIX_.'split_details where id_order='.$old.' OR id_parent='.$old.'';					
		$root = Db::getInstance()->getRow($sql);
		if($root){
			return Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'split_details (`id_order`, `id_parent`, `root`) VALUES ('.$new.','.$old.','.$root['root'].')');
		}
		else{
			return Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'split_details (`id_order`, `id_parent`, `root`) VALUES ('.$new.','.$old.','.$old.')');
		}
		
	}

	public static function isSplitOrder($id_order){
		$sql ='select * from '._DB_PREFIX_.'split_details where id_order='.$id_order.' OR id_parent='.$id_order.'';
					
		return Db::getInstance()->Execute($sql);
	}

	public static function SplitOrderDetail($id_order){
		$sql ='select root from '._DB_PREFIX_.'split_details where id_order='.$id_order.' OR id_parent='.$id_order.'';					
		$root = Db::getInstance()->getRow($sql);
		$query = 'SELECT * from '._DB_PREFIX_.'split_details where root='.$root['root'].'';
		$result = Db::getInstance()->ExecuteS($query);		
		return $result;
	}

	public static function validateInvoice($number)
	{
		$sql ='select * from kob_order_history koh
					left join kob_order_invoice koi on koi.id_order = koh.id_order
					where koi.number='.$number.'
					and koh.id_order_state=40';
					
		return Db::getInstance()->Execute($sql);
	}
	public static function getPreviousValidStatus($id_order)
	{
		return Db::getInstance()->getValue('
		SELECT osl.name
		FROM `'._DB_PREFIX_.'order_history` oh
		left join `'._DB_PREFIX_.'order_state` os on os.id_order_state = oh.id_order_state
		left join `'._DB_PREFIX_.'order_state_lang` osl on osl.id_order_state = oh.id_order_state
		WHERE oh.`id_order` = '.(int)($id_order).'
		and os.hidden = 0 and os.deleted = 0
		ORDER BY `date_add` DESC, `id_order_history` DESC');
	}
	public static function getCustomerOrders($id_customer, $showHiddenStatus = false, Context $context = null, $limit = NULL, $offset = NULL, $fromDate = NULL, $toDate = NULL, $duration = NULL, $orderBy = NULL, $orderWay = NULL, $searchQuery = NULL, $dash = false)
	{
		$customer_role = Customer::getCurrentCustomerRole();

		if((int)$customer_role != 2 && (int)$customer_role != 3){
			$query = 'o.`id_customer` = '.(int)$id_customer.'';
			$filterOrders = 'ord.`id_customer` = '.(int)$id_customer.'';
		}
		else{
			$customer = new Customer($id_customer);
			$result = $customer->getChildCustomers();	
			$query = 'o.`id_customer` IN('.$result.')';
			$filterOrders = 'ord.`id_customer` IN('.$result.')';
		}
		$dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";

		$filterQuery = "";

		if($fromDate && $toDate)
			$filterQuery .= ' AND DATE(o.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$filterQuery .= ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$filterQuery .= ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$filterQuery .= ' AND o.`date_add` >= DATE_SUB(NOW(), INTERVAL 1 HOUR)';
		else if($duration == 2)
			$filterQuery .= ' AND DATE(o.`date_add`) >= CURDATE()';
		else if($duration == 3)
			$filterQuery .= ' AND WEEKOFYEAR(o.`date_add`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 4)
			$filterQuery .= ' AND MONTH(o.`date_add`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 5)
			$filterQuery .= "";

		if($searchQuery)
			$filterQuery .= ' AND (es.`name` LIKE "%'.$searchQuery.'%" OR 
							 o.`id_order` LIKE "%'.$searchQuery.'%" OR o.`date_add` LIKE "%'.$searchQuery.'%" OR
							 o.`total_paid` LIKE "%'.$searchQuery.'%" OR osl.`name` LIKE "%'.$searchQuery.'%" OR
							 o.`payment` LIKE "%'.$searchQuery.'%")';

		$count_rows = "SELECT FOUND_ROWS() AS total";
		$data_rows = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT(o.`id_order`) AS total, o.`id_order`, 
						(select MAX(date_add) from '._DB_PREFIX_.'order_history where id_order=o.id_order and id_order_state=22) as date_add, 
						DATE_FORMAT(o.`estimated_delivery_time`, "%M %d, %Y") AS `estimated_time`, 
						os.`id_order_state`, osl.`name` AS order_state,
						(CASE WHEN q.quantity is NULL THEN FORMAT(total.tot,2) ELSE FORMAT(IFNULL(total.tot,0)+o.total_paid,2) END) as total_paid, es.`id_supplier`, IFNULL(es.`company`, "Not Available") AS supplier_name, es.email,o.`payment` AS payment';
 		
		$sql = ' FROM `'._DB_PREFIX_.'orders` o
			    LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON(oh.`id_order` = o.`id_order`)
			    LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
			    LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (osl.`id_order_state` = os.`id_order_state` AND osl.`id_lang` = 1)
			    LEFT JOIN `'._DB_PREFIX_.'elite_supplier_orders` osp ON o.`id_order` = osp.`id_order`
			    LEFT JOIN `'._DB_PREFIX_.'elite_supplier` as es ON (osp.`id_supplier` = es.`id_supplier`)
			    LEFT JOIN(
                        SELECT id_order, COUNT(product_quantity) as quantity FROM kob_order_detail GROUP BY id_order
                    ) as q on q.id_order=o.id_order
			    LEFT JOIN (
                        SELECT ksd.root, SUM(ko.total_paid_tax_incl) as tot, SUM(ord.q) as quantity FROM kob_split_details ksd
                        LEFT JOIN kob_orders ko ON ko.id_order=ksd.id_order
                        LEFT JOIN(
                            SELECT id_order, COUNT(product_quantity) as q FROM kob_order_detail 
                            GROUP BY id_order) as ord ON ord.id_order=ko.id_order
                        GROUP BY ksd.root
                    ) as total on total.root = o.id_order
			    WHERE '.$query.' '.$filterQuery.'
			    AND o.id_order NOT IN(select ksd.id_order from kob_split_details ksd
								LEFT JOIN kob_orders ord on ord.id_order = ksd.id_order
								where '.$filterOrders.')
			    AND oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `'._DB_PREFIX_.'order_history` moh 
										 WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
			    '.($orderBy ? 'ORDER BY '.$orderBy : "ORDER BY o.`id_order`").' '.($orderWay ? $orderWay : "DESC").'';
		$logger = new FileLogger();
		$logger->setFilename("text.txt");
		$logger->logError("=======QUERY============");
		$logger->logError($data_rows.$sql.$dataLimit);
		$data_sql = $data_rows.$sql.$dataLimit;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($data_sql);
		$total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($count_rows);
		if (!$result)
			return array('total' => 0, 'results' => []);

		foreach($result as &$order){

			if($order['hidden'] == 1){
				$order['order_state'] = Order::getPreviousValidStatus($order['id_order']);
			}

			if($order['id_order_state'] == OrderState::FLAG_INVOICE_SUBMITTED || $order['id_order_state'] == OrderState::FLAG_PENDING_PAYMENT )
				$remaining_credit_days = (int)$order['credit_days'] - $order['bill_age'];
			else if($order['id_order_state'] == OrderState::FLAG_ORDER_COMPLETED)
				$remaining_credit_days = "Payment Received";
			else if($order['id_order_state'] == OrderState::FLAG_CANCELED)
				$remaining_credit_days = "Cancelled";
			else
				$remaining_credit_days = "Invoice Submission Pending";
		
			$order['bill_age'] = $remaining_credit_days;
			$order['order_contains_product'] = Order::containsProduct($order['id_order']);
		}
 		if($dash)
 			return array('total' => $total, 'results' => $result);
 		else
 			return $result;
	}

	public static function getFulfillmentCenter($id_address)
	{
 		$sql='select fc.id_fulfillment_centre from `'._DB_PREFIX_.'fulfillment_centre` fc
			join `'._DB_PREFIX_.'address` ad ON fc.id_state=ad.id_state
			where ad.id_address='.$id_address.'';

		$result= Db::getInstance()->getRow($sql);

		try
		{
			if (empty($id_address)){
				throw new Exception("Error Report: Empty variables / Undefined variables", 1);					
			}
			elseif (empty($result)) {
				$result=array('id_fulfillment_centre'=>1);
				return $result;
			}
			else{
				return $result;
			}			
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		
	}

	public function getDrNumber()
	{
		return Db::getInstance()->ExecuteS('SELECT `kd`.delivery_number, `kd`.dr_prefix FROM `'._DB_PREFIX_.'delivery` kd LEFT JOIN  `'._DB_PREFIX_.'order_delivery` kod ON( kod.id_delivery=kd.id_delivery ) WHERE kod.id_order='.$this->id.'');
	}

	public function hasBeenDelivered()
    {
        return count($this->getHistory((int)$this->id_lang, Configuration::get('PS_OS_DELIVERED')));
    }

	public function isInvoiceSubmitted()
	{
		return sizeof($this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_INVOICE_SUBMITTED')));
	}

	public function isInvoiceGenerated()
	{
		return sizeof($this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_INVOICE_GEN')));
	}
 	
 	public function isInPreparation()
	{
		return sizeof($this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_PREPARATION')));
	}
	
	public function packedandreadytobeshipped()
	{
		return $this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_PACKED_AND_READY_TO_SHIPPED'));		
	}
	
	public function checkIfAllProductsDelivered()
	{
		$products = $this->getProducts();
		foreach($products as $product)
		{
			if(((int)$product['product_quantity_delivered'] + (int)$product['product_quantity_return']) != (int)$product['product_quantity'])
				return false;
		}
		return true;
	}

	public function getInvoiceId()
	{
		return Db::getInstance()->getValue('select id_order_invoice FROM `'._DB_PREFIX_.'order_invoice` where id_order='.$this->id);
	}

	public static function getPendingBusinessOrders()
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT od.id_order, cus.id_customer, cus.firstname, NOW(), od.estimated_delivery_time, 
		TIMESTAMPDIFF(HOUR, NOW(), od.estimated_delivery_time) as hours, oh1.id_order_state
		FROM '._DB_PREFIX_.'order_history oh1, '._DB_PREFIX_.'customer cus, '._DB_PREFIX_.'orders od
		WHERE oh1.id_order_history = (SELECT MAX(oh2.id_order_history)
                 FROM '._DB_PREFIX_.'order_history oh2
                 WHERE oh1.id_order = oh2.id_order)
		AND oh1.id_order_state in (4,18,19,21,22,23,24)
		AND oh1.id_order = od.id_order
		AND od.id_customer = cus.id_customer
		AND cus.id_buyer = 3
		ORDER BY `oh1`.`id_order` DESC');
		
		return $result;
	}

	/*This will return the purchases level for that current customer*/
	public static function getHistoryReport($customerid, $duration, $addressId = 0, $fromDate = NULL, $toDate = NULL, $locationID = NULL)
	{
		$customer = new Customer($customerid);
		$str = $customer->getChildCustomers();

 		$query = "";

 		if($addressId != 0)
 			$query .= ' AND a.id_address_delivery = "'.$addressId.'"';

 		if($fromDate && $toDate)
			$query .= ' AND DATE(a.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$query .= ' AND DATE(a.`date_add`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$query .= ' AND DATE(a.`date_add`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$query .= ' AND a.`date_add` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$query .= ' AND DATE(a.`date_add`) >= CURDATE()';
		else if($duration == 3)
			$query .= ' AND WEEKOFYEAR(a.`date_add`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(a.`date_add`)';
		else if($duration == 4)
			$query .= ' AND MONTH(a.`date_add`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(a.`date_add`)';
		else if($duration == 5)
			$query .= "";

		if($locationID != NULL)
			$query .= ' AND ad.`id_state` = '.$locationID.'';
		 
		$result = Db::getInstance()->ExecuteS('SELECT ROUND(sum(a.total_paid_tax_incl), 2) as y, ad.`id_state`, ROUND(sum(a.total_paid_tax_incl), 2) as indexLabel, GROUP_CONCAT(a.id_order) AS id_order, monthname(a.date_add) AS label
											   FROM '._DB_PREFIX_.'orders AS a
											   LEFT JOIN '._DB_PREFIX_.'address ad ON a.`id_address_delivery` = ad.`id_address`
											   LEFT JOIN '._DB_PREFIX_.'order_history AS b ON a.id_order = b.id_order
											   WHERE  b.id_Order_history IN ( SELECT  MAX(oha.`id_order_history`) 
											   								  FROM '._DB_PREFIX_.'order_history AS oha 
											   								  WHERE a.id_order = oha.id_order
																			  GROUP BY oha.id_order
																			) 
											   AND  b.`id_order_state` IN(5,25,34,35,36,37,38,39,40)
											   AND a.`id_customer` IN('.$str.') '.$query.'
											   GROUP BY label ORDER BY a.date_add ASC ');

		return $result;
	}
	
	/*This will return the parent category with purchases for that current customer*/
	public static function getRatioHistoryReport($customerid, $orderid, $duration, $addressId, $selected_category = NULL, $fromDate = false, $toDate = false, $locationID = NULL)
	{	
		$customer = new Customer($customerid);
		$str = $customer->getChildCustomers();

		$query = "";

		if($fromDate && $toDate)
			$query .= ' AND DATE(orders.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$query .= ' AND DATE(orders.`date_add`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$query .= ' AND DATE(orders.`date_add`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$query .= ' AND orders.`date_add` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$query .= ' AND DATE(orders.`date_add`) >= CURDATE()';
		else if($duration == 3)
			$query .= ' AND WEEKOFYEAR(orders.`date_add`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(orders.`date_add`)';
		else if($duration == 4)
			$query .= ' AND MONTH(orders.`date_add`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(orders.`date_add`)';
		else if($duration == 5)
			$query .= "";

		if($locationID != NULL)
			$query .= ' AND ad.`id_state` = '.$locationID.'';
		
		$add_qry = ($addressId != 0) ? ' AND orders.id_address_delivery = "'.$addressId.'"' : "";
		$ord_query = ($orderid == 1 || $orderid == 0) ? "" : ' AND orders.`id_order`= "'.$orderid.'"';

		if($selected_category !=""){
			/*qry_top_10_product*/
			$select_qry ='count(detail.product_id) as total, pro_lang.name as indexLabel , SUM(detail.product_quantity - detail.product_quantity_return - detail.product_quantity_refunded) as qty, ROUND(SUM((detail.`unit_price_tax_incl`)), 2) AS y, detail.unit_price_tax_incl ';
			$where_qry =' AND parent.id_category ='.$selected_category.' '.$query.' group by product.id_product order by y desc limit 10';
		}
		else{
			/*$category_report*/
			$select_qry ='GROUP_CONCAT(orders.`id_order`) AS id_order, ROUND(SUM((detail.`total_price_tax_incl`)), 2) AS y, cat_lang.`name` AS category  ,parent.id_category ';
			$where_qry=''.$add_qry.''.$ord_query.''.$query.' GROUP BY parent.id_category ORDER BY y DESC';
		}

 		$result = Db::getInstance()->ExecuteS('SELECT '.$select_qry.' 
												FROM '._DB_PREFIX_.'orders orders, '._DB_PREFIX_.'order_detail detail, '._DB_PREFIX_.'product product, '._DB_PREFIX_.'order_history history,
												'._DB_PREFIX_.'category node, '._DB_PREFIX_.'category parent, '._DB_PREFIX_.'category_lang cat_lang,'._DB_PREFIX_.'product_lang pro_lang,
												'._DB_PREFIX_.'address ad
												WHERE   orders.`id_customer` IN('.$str.')
												AND		orders.`id_order` = detail.id_order
												AND 	orders.`id_address_delivery` = ad.`id_address`
												AND		product.`id_product` = detail.`product_id`
												AND		product.`id_product` = pro_lang.`id_product`
												AND		product.`id_category_default` = node.`id_category`
												AND		node.nleft BETWEEN parent.nleft AND parent.nright
												AND 	parent.level_depth = 2
												AND 	parent.id_category = cat_lang.`id_category`
												AND     cat_lang.`id_lang`= 1												
												AND     pro_lang.`id_lang`= 1
												AND 	orders.`id_order`= history.`id_order`
												AND 	history.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																WHERE orders.id_order = oha.id_order
																GROUP BY oha.id_order)
												AND 	history.`id_order_state` IN (5,25,34,35,36,37,38,39,40 ) 
												'.$where_qry.'');	 

 		return $result;
	}
	/*this is use to get a order id, date, invoice value for a particular customer*/
	public static function getAllOrders($customerid)
	{
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
 		$result = Db::getInstance()->ExecuteS('SELECT DISTINCT(o.id_order) as orderid,DATE_FORMAT(o.date_add, "%d-%b-%Y") AS orderdate,ROUND(o.total_paid_tax_incl, 2) as totalvalue, o.`id_address_delivery`
												FROM '._DB_PREFIX_.'orders AS o
												LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
												ON oh.`id_order`= o.`id_order`
												WHERE id_customer IN('.$str.') AND 	oh.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																where o.id_order = oha.id_order
																GROUP BY oha.id_order)
												AND 	 oh.`id_order_state` IN (5,25,34,35,36,37,38,39,40)');
		
	return $result;
	}

	public static function getTopOrderValueProducts($customerid, $duration, $addressId, $from_date = NULL, $to_date = NULL)
	{
		if($addressId !=0)
 			$add_qry = 'AND o.id_address_delivery = "'.$addressId.'"';
 		else
 			$add_qry ='';
			
 		$query = "";

		if($from_date != "" && $to_date != "")
			$query .= 'AND DATE(o.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($from_date)).'" AND "'.date("Y-m-d", strtotime($to_date)).'"';
		else if($from_date == NULL && $to_date)
			$query .= 'AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($to_date)).'"';
		else if($to_date == NULL && $from_date)
			$query .= 'AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($from_date)).'"';
		
		if($duration == 1)
			$query .= 'AND o.`date_add` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$query .= 'AND DATE(o.`date_add`) >= CURDATE()';
		else if($duration == 3)
			$query .= 'AND WEEKOFYEAR(o.`date_add`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 4)
			$query .= 'AND MONTH(o.`date_add`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 5)
			$query .= "";

		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();

		$result = Db::getInstance()->ExecuteS('SELECT ROUND(SUM(((od.product_quantity - product_quantity_refunded - product_quantity_return) * od.unit_price_tax_incl)), 2) AS y, pl.`name` AS name, pl.`id_product`,pl.`link_rewrite`, 
												p.`quantity`,p.`out_of_stock`,p.`id_category_default`, p.`minimal_quantity`
												FROM '._DB_PREFIX_.'order_detail AS od
												JOIN '._DB_PREFIX_.'orders o ON o.id_order = od.id_order
												JOIN '._DB_PREFIX_.'product_lang pl	ON pl.id_product = od.product_id
												JOIN '._DB_PREFIX_.'order_detail_tax odt ON od.id_order_detail = odt.id_order_detail
												JOIN '._DB_PREFIX_.'tax t on odt.id_tax = t.id_tax
												JOIN '._DB_PREFIX_.'order_history oh ON o.id_order= oh.id_order
												JOIN '._DB_PREFIX_.'product p ON p.id_product= pl.id_product
												WHERE o.id_customer IN('.$str.') AND p.discontinued = 0  AND p.active = 1 
												AND oh.id_Order_history IN (
																		 SELECT  MAX(oha.`id_order_history`)
																		 FROM '._DB_PREFIX_.'order_history AS oha
																		 WHERE o.id_order = oha.id_order
																		 GROUP BY oha.id_order
																		) 
												AND oh.id_order_state IN (5,25,34,35,36,37,38,39,40 ) '.$add_qry.' 
												AND pl.id_lang = 1 '.$query.' GROUP BY od.product_id ORDER BY y DESC LIMIT 10');	
		return $result;

	}
	
	public static function getLocationBasedReport($customerid, $duration, $fromDate = NULL, $toDate = NULL, $locationID = NULL, $state = false)
	{
		$customer = new Customer($customerid);
		$str = $customer->getChildCustomers();

		$filterQuery = "";

		if($fromDate && $toDate)
			$filterQuery .= ' AND DATE(o.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$filterQuery .= ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$filterQuery .= ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$filterQuery .= ' AND o.`date_add` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$filterQuery .= ' AND DATE(o.`date_add`) >= CURDATE()';
		else if($duration == 3)
			$filterQuery .= ' AND WEEKOFYEAR(o.`date_add`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 4)
			$filterQuery .= ' AND MONTH(o.`date_add`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 5)
			$filterQuery .= "";

		if($locationID != NULL)
			$filterQuery .= ' AND a.`id_state` = '.$locationID.'';

		$groupBy = $state ? "a.`id_state`" : "o.`id_address_delivery`";
		 

		return Db::getInstance()->ExecuteS('SELECT ROUND(SUM(o.total_paid_tax_incl), 2) AS y, o.`id_address_delivery`, a.`alias` AS indexLabel, a.`address1` AS address_line, 
											GROUP_CONCAT(o.`id_order`) AS id_order, a.`city`, gc.`latitude` AS lat, gc.`longitude` AS lng, st.`name` AS state_name, a.`id_state`
											FROM '._DB_PREFIX_.'orders o
											LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
											ON o.`id_order` = oh.`id_order`
											LEFT JOIN '._DB_PREFIX_.'address AS a ON o.`id_address_delivery` = a.`id_address`
											LEFT JOIN '._DB_PREFIX_.'state st ON (a.`id_state` = st.`id_state`) AND st.`id_country` = 110
											LEFT JOIN '._DB_PREFIX_.'state_geocodes gc ON (st.`id_state` = gc.`id_state`) AND gc.`active` = 1
											WHERE o.id_customer IN('.$str.') AND oh.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																 where o.id_order = oha.id_order
																GROUP BY oha.id_order)
											AND oh.`id_order_state` IN ( 5,25,34,35,36,37,38,39,40 ) '.$filterQuery.'
											GROUP BY '.$groupBy.' ORDER BY Y DESC');
	}


	public function getAllPendingPayments($customerIDs, $limit = NULL, $offset = NULL, $fromDate = NULL, $toDate = NULL, $duration = NULL, $orderBy = NULL, $orderWay = NULL, $searchQuery = NULL, $filter_status = NULL)
	{
		
		$dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";

		$query = "";

		if($fromDate && $toDate)
			$query .= ' AND DATE(o.`invoice_date`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$query .= ' AND DATE(o.`invoice_date`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$query .= ' AND DATE(o.`invoice_date`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$query .= ' AND o.`invoice_date` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$query .= ' AND DATE(o.`invoice_date`) >= CURDATE()';
		else if($duration == 3)
			$query .= ' AND WEEKOFYEAR(o.`invoice_date`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`invoice_date`)';
		else if($duration == 4)
			$query .= ' AND MONTH(o.`invoice_date`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`invoice_date`)';
		else if($duration == 5)
			$query .= "";

		if($filter_status){
			$query .=' AND os.id_order_state IN('.$filter_status.')';
		}
		// else{
		// 	$query .=' AND os.id_order_state IN(35,36,39,40)';
		// }
		if($searchQuery)
			$query .= ' AND (o.`id_order` LIKE "%'.$searchQuery.'%" OR o.`date_add` LIKE "%'.$searchQuery.'%" OR
							 o.`total_paid` LIKE "%'.$searchQuery.'%" OR o.`invoice_number` LIKE "%'.$searchQuery.'%" OR
							 o.`invoice_date` LIKE "%'.$searchQuery.'%")';

		$customer = new Customer($customerIDs);
		$str = $customer->getChildCustomers();

		$count_rows = "SELECT FOUND_ROWS() AS total";
		$data_rows = 'SELECT SQL_CALC_FOUND_ROWS o.`invoice_number` AS total,TRIM(o.`invoice_number`) as invoice_number,o.`id_order`,
						DATE_FORMAT(o.`invoice_date`, "%b %d, %Y") AS invoice_date,DATE_FORMAT(o.`invoice_date`, "%Y-%m-%d %h:%i:%s") AS invoice_date_a,o.`id_fc`,
					    DATE_FORMAT(DATE_ADD(o.`invoice_date`, INTERVAL o.credit_days DAY), "%b %d, %Y") as due_date,
					    DATEDIFF(NOW(),oi.`date_add`) AS age,o.`credit_days`,
						o.`id_order` as order_number,o.`total_paid_tax_incl`as invoice_value, 
						oh.`id_order_state`,os.name as invoice_status, (CASE WHEN os.id_order_state=6 THEN "0.00" ELSE (o.`total_paid` - 0) END) AS outstanding ,
						d.`dr_file_name` as dr_file,d.`delivery_number`,d.`id_delivery` ';
			
		$sql = ' FROM `kob_order_history` AS oh
			    LEFT JOIN `'._DB_PREFIX_.'orders` AS o ON oh.`id_order` = o.`id_order`
			    LEFT JOIN `'._DB_PREFIX_.'order_state` AS ostate ON oh.`id_order_state` = ostate.`id_order_state`
			    LEFT JOIN `'._DB_PREFIX_.'order_state_lang` AS os ON oh.`id_order_state` = os.`id_order_state` and os.`id_lang`=1
                LEFT JOIN `'._DB_PREFIX_.'order_invoice` AS oi ON oi.`id_order`= o.`id_order`
                LEFT JOIN `'._DB_PREFIX_.'delivery_details` AS dd ON dd.id_order = o.`id_order`
                LEFT JOIN `'._DB_PREFIX_.'delivery` As d ON d.`id_delivery` = dd.`id_delivery`
                
                WHERE oh.id_order_history IN (
												SELECT  MAX(oh.`id_order_history`)
												FROM `kob_order_history` AS oh
												where o.`id_order` = oh.`id_order` 
												GROUP BY oh.`id_order`
											)
			    AND o.`id_customer` IN ('.$str.') 
			    AND o.`invoice_number`!=0 
			    AND ostate.`hidden` != 1
			    '.$query.'
			    AND o.`invoice_date` <> "0000-00-00 00:00:00"
			    GROUP BY o.`id_order` 
			    '.($orderBy ? 'ORDER BY '.$orderBy : "ORDER BY o.`id_order`").' '.($orderWay ? $orderWay : "DESC").'';

		$data_sql = $data_rows.$sql.$dataLimit;

		$invoice_status_sql = 'SELECT DISTINCT(os.id_order_state), os.name
				FROM `kob_order_history` AS oh
			    LEFT JOIN `kob_orders` AS o ON oh.`id_order` = o.`id_order`
			    LEFT JOIN `kob_order_state` AS ostate ON oh.`id_order_state` = ostate.`id_order_state`
			    LEFT JOIN `kob_order_state_lang` AS os ON oh.`id_order_state` = os.`id_order_state` and os.`id_lang`=1
                
                WHERE oh.id_order_history IN (
												SELECT  MAX(oh.`id_order_history`)
												FROM `kob_order_history` AS oh
												where o.`id_order` = oh.`id_order` 
												GROUP BY oh.`id_order`
											)
			    AND o.`id_customer` IN ('.$str.') 
			    AND o.`invoice_number`!=0 
			    AND ostate.`hidden` != 1
			    
			    AND o.`invoice_date` <> "0000-00-00 00:00:00"
			    GROUP BY o.`id_order` 
			    ORDER BY o.`id_order` DESC';

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($data_sql);
		$total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($count_rows);
		$status = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($invoice_status_sql);
		
		return array('total' => $total, 'results' => $result, 'status' => $status);
	}
	public static function getViewOrders($customerIDs, $limit = NULL, $offset = NULL, $fromDate = NULL, $toDate = NULL, $duration = NULL, $orderBy = NULL, $orderWay = NULL, $searchQuery = NULL, $filter_status = NULL)
	{
		$dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";

		$query = "";
		if($filter_status){
			$query .=' AND os.id_order_state IN('.$filter_status.')';
		}
		// else{
		// 	$query .=' AND os.id_order_state IN(35,36,39,40)';
		// }
		if($searchQuery)
			$query .= ' AND (o.`id_order` LIKE "%'.$searchQuery.'%" OR o.`date_add` LIKE "%'.$searchQuery.'%" OR
							 o.`total_paid` LIKE "%'.$searchQuery.'%" OR o.`invoice_number` LIKE "%'.$searchQuery.'%" OR
							 o.`invoice_date` LIKE "%'.$searchQuery.'%" OR os.`name` LIKE "%'.$searchQuery.'%" )';

		// $customer = new Customer($customerIDs);
		$str = Pincap::getUsers($customerIDs);

		$count_rows = "SELECT FOUND_ROWS() AS total";
		$data_rows = 'SELECT SQL_CALC_FOUND_ROWS o.`invoice_number` AS total,TRIM(o.`invoice_number`) as invoice_number,o.`id_order`,
						DATE_FORMAT(o.`invoice_date`, "%b %d, %Y") AS invoice_date,DATE_FORMAT(o.`invoice_date`, "%Y-%m-%d %h:%i:%s") AS invoice_date_a,o.`id_fc`,
					    DATE_FORMAT(DATE_ADD(o.`invoice_date`, INTERVAL o.credit_days DAY), "%b %d, %Y") as due_date,
					    DATEDIFF(NOW(),oi.`date_add`) AS age,o.`credit_days`,
						o.`id_order` as order_number,o.`total_paid_tax_incl`as invoice_value, 
						oh.`id_order_state`,os.name as invoice_status, (CASE WHEN os.id_order_state=6 THEN "0.00" ELSE (o.`total_paid` - 0) END) AS outstanding ,
						d.`dr_file_name` as dr_file,d.`delivery_number`,d.`id_delivery` ';
			
		$sql = ' FROM `kob_order_history` AS oh
			    LEFT JOIN `'._DB_PREFIX_.'orders` AS o ON oh.`id_order` = o.`id_order`
			    LEFT JOIN `'._DB_PREFIX_.'order_state` AS ostate ON oh.`id_order_state` = ostate.`id_order_state`
			    LEFT JOIN `'._DB_PREFIX_.'order_state_lang` AS os ON oh.`id_order_state` = os.`id_order_state` and os.`id_lang`=1
                LEFT JOIN `'._DB_PREFIX_.'order_invoice` AS oi ON oi.`id_order`= o.`id_order`
                LEFT JOIN `'._DB_PREFIX_.'delivery_details` AS dd ON dd.id_order = o.`id_order`
                LEFT JOIN `'._DB_PREFIX_.'delivery` As d ON d.`id_delivery` = dd.`id_delivery`
                
                WHERE oh.id_order_history IN (
												SELECT  MAX(oh.`id_order_history`)
												FROM `kob_order_history` AS oh
												where o.`id_order` = oh.`id_order` 
												GROUP BY oh.`id_order`
											)
			    AND o.`id_customer` IN ('.$str.') 
			    AND o.`invoice_number`!=0 
			    AND ostate.`hidden` != 1
			    '.$query.'
			    AND o.`invoice_date` <> "0000-00-00 00:00:00"
			    GROUP BY o.`id_order` 
			    '.($orderBy ? 'ORDER BY '.$orderBy : "ORDER BY o.`id_order`").' '.($orderWay ? $orderWay : "DESC").'';

		$data_sql = $data_rows.$sql.$dataLimit;

		$invoice_status_sql = 'SELECT DISTINCT(os.id_order_state), os.name
				FROM `kob_order_history` AS oh
			    LEFT JOIN `kob_orders` AS o ON oh.`id_order` = o.`id_order`
			    LEFT JOIN `kob_order_state` AS ostate ON oh.`id_order_state` = ostate.`id_order_state`
			    LEFT JOIN `kob_order_state_lang` AS os ON oh.`id_order_state` = os.`id_order_state` and os.`id_lang`=1
                
                WHERE oh.id_order_history IN (
												SELECT  MAX(oh.`id_order_history`)
												FROM `kob_order_history` AS oh
												where o.`id_order` = oh.`id_order` 
												GROUP BY oh.`id_order`
											)
			    AND o.`id_customer` IN ('.$str.') 
			    AND o.`invoice_number`!=0 
			    AND ostate.`hidden` != 1
			    
			    AND o.`invoice_date` <> "0000-00-00 00:00:00"
			    GROUP BY o.`id_order` 
			    ORDER BY o.`id_order` DESC';

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($data_sql);
		$total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($count_rows);
		$status = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($invoice_status_sql);
		
		return array('total' => $total, 'results' => $result, 'status' => $status);
	}

	public function getAllInvoice($customerIDs, $limit = NULL, $offset = NULL, $fromDate = NULL, $toDate = NULL, $duration = NULL, $orderBy = NULL, $orderWay = NULL, $searchQuery = NULL)
	{
		
		$dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";

		$query = "";

		if($fromDate && $toDate)
			$query .= ' AND DATE(o.`invoice_date`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$query .= ' AND DATE(o.`invoice_date`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$query .= ' AND DATE(o.`invoice_date`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$query .= ' AND o.`invoice_date` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$query .= ' AND DATE(o.`invoice_date`) >= CURDATE()';
		else if($duration == 3)
			$query .= ' AND WEEKOFYEAR(o.`invoice_date`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`invoice_date`)';
		else if($duration == 4)
			$query .= ' AND MONTH(o.`invoice_date`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`invoice_date`)';
		else if($duration == 5)
			$query .= "";

		if($searchQuery)
			$query .= ' AND (o.`id_order` LIKE "%'.$searchQuery.'%" OR o.`date_add` LIKE "%'.$searchQuery.'%" OR
							 o.`total_paid` LIKE "%'.$searchQuery.'%" OR o.`invoice_number` LIKE "%'.$searchQuery.'%" OR
							 o.`invoice_date` LIKE "%'.$searchQuery.'%")';

		$customer = new Customer($customerIDs);
		$str = $customer->getChildCustomers();

		$count_rows = "SELECT FOUND_ROWS() AS total";
		$data_rows = 'SELECT SQL_CALC_FOUND_ROWS o.`invoice_number` AS total,o.`invoice_number`,DATE_FORMAT(o.`invoice_date`, "%M %d, %Y") AS invoice_date,DATE_FORMAT(o.`date_add` , "%M %d, %Y") AS added_date,
							 o.`id_order`,o.`total_paid_tax_incl`, o.`id_address_delivery`, o.`id_address_invoice`, oh.`id_order_state`,os.`delivery`, os.`invoice`, o.`total_paid`';
			
		$sql = ' FROM `'._DB_PREFIX_.'order_history` AS oh
			    LEFT JOIN `'._DB_PREFIX_.'orders` AS o ON oh.`id_order` = o.`id_order`
			    LEFT JOIN `'._DB_PREFIX_.'order_state` AS os ON oh.`id_order_state` = os.`id_order_state`
			    WHERE oh.id_Order_history IN (
												SELECT  MAX(oh.`id_order_history`)
												FROM `'._DB_PREFIX_.'order_history` AS oh
												where o.`id_order` = oh.`id_order`
												GROUP BY oh.`id_order`
											)  
			    AND o.`id_customer` IN ('.$str.') 
			    '.$query.'
			    AND o.`invoice_date` <> "0000-00-00 00:00:00"
			    '.($orderBy ? 'ORDER BY '.$orderBy : "ORDER BY o.`id_order`").' '.($orderWay ? $orderWay : "DESC").'';

		$data_sql = $data_rows.$sql.$dataLimit;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($data_sql);
		$total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($count_rows);
		
		return array('total' => $total, 'results' => $result);
	}
	
	public static function getAllDeliveryData($customerIDs, $limit = NULL, $offset = NULL, $fromDate = NULL, $toDate = NULL, $duration = NULL ,$orderBy = NULL, $orderWay = NULL, $searchQuery = NULL)
	{
		
		$dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";

		$query = "";

		if($fromDate && $toDate)
			$query .= ' AND DATE(o.`delivery_date`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$query .= ' AND DATE(o.`delivery_date`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$query .= ' AND DATE(o.`delivery_date`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$query .= ' AND o.`delivery_date` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$query .= ' AND DATE(o.`delivery_date`) >= CURDATE()';
		else if($duration == 3)
			$query .= ' AND WEEKOFYEAR(o.`delivery_date`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`delivery_date`)';
		else if($duration == 4)
			$query .= ' AND MONTH(o.`delivery_date`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`delivery_date`)';
		else if($duration == 5)
			$query .= "";

		if($searchQuery)
			$query .= ' AND (o.`id_order` LIKE "%'.$searchQuery.'%" OR o.`date_add` LIKE "%'.$searchQuery.'%" OR
							 o.`total_paid` LIKE "%'.$searchQuery.'%" OR osl.`name` LIKE "%'.$searchQuery.'%" OR d.`delivery_number` LIKE "%'.$searchQuery.'%" OR
							 o.`delivery_date` LIKE "%'.$searchQuery.'%")';

		$customer = new Customer($customerIDs);
		$str = $customer->getChildCustomers();

		$count_rows = "SELECT FOUND_ROWS() AS total";
		$data_rows = 'SELECT SQL_CALC_FOUND_ROWS d.`delivery_number`, d.`delivery_number`,o.`id_address_delivery`, o.`id_address_invoice`, oh.`id_order_state`, osl.`name` AS status,
											  DATE_FORMAT(d.`delivery_date`, "%M %d, %Y") AS delivery_date,DATE_FORMAT(o.`date_add` , "%M %d, %Y") AS added_date,
											  os.`delivery`,od.`id_delivery`,o.`id_order`,oh.`id_order_history`,d.`dr_file_name`';
		
		$sql = ' FROM '._DB_PREFIX_.'order_history AS oh
			   LEFT JOIN '._DB_PREFIX_.'orders AS o ON o.id_order = oh.id_order
			   LEFT JOIN '._DB_PREFIX_.'order_delivery AS od ON o.id_order = od.id_order
			   LEFT JOIN '._DB_PREFIX_.'delivery AS d ON od.id_delivery = d.id_delivery
			   LEFT JOIN '._DB_PREFIX_.'order_state AS os ON os.id_order_state = oh.id_order_state
			   LEFT JOIN '._DB_PREFIX_.'order_state_lang osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = 1)												
			   WHERE oh.id_order_history IN (
											SELECT  MAX(oh.`id_order_history`)
											FROM '._DB_PREFIX_.'order_history AS oh
											where o.id_order = oh.id_order
											GROUP BY oh.id_order
										)
			  AND o.id_customer IN ('.$str.') '.$query.' 
			  AND d.`delivery_date` <> "0000-00-00 00:00:00"
			  '.($orderBy ? 'ORDER BY '.$orderBy : "ORDER BY o.`id_order`").' '.($orderWay ? $orderWay : "DESC").'';
												
								
		$data_sql = $data_rows.$sql.$dataLimit;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($data_sql);
		$total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($count_rows);
		
		return array('total' => $total, 'results' => $result);
	}

	/*Return the durations of orders status according to RM cusotmer */
	public function getRMCusomersOrderDurations($id_employee, $id_fc = NULL)
	{
		$fc_query="";
		if($id_fc)
			$fc_query = 'AND od.`id_fc` = '.$id_fc.'';

		$sql = 'SELECT id_order_state,hours, COUNT(orderid) as totalorder, status_name
				FROM (
					SELECT id_order_state, orderid, 
					CASE WHEN (TIMESTAMPDIFF(HOUR, IF(order_placed_date IS NULL, ordered_date, order_placed_date), NOW())) < 24 THEN 24
						 WHEN (TIMESTAMPDIFF(HOUR, IF(order_placed_date IS NULL, ordered_date, order_placed_date), NOW())) < 48 THEN 48
						 ELSE 72
					END AS hours, (TIMESTAMPDIFF(HOUR, order_placed_date, NOW())), status_name
					FROM (
						SELECT od.`id_order` AS orderid,MAX(oh.`id_order_state`) AS id_order_state, osl.`name` as status_name,
						(SELECT ohr.`date_add` FROM `'._DB_PREFIX_.'order_history` ohr 
							WHERE ohr.`id_order` = od.`id_order` 
							AND ohr.`id_order_state` = '.Configuration::get('PS_OS_ORDERPLACED').'
							GROUP BY ohr.`id_order`
						) AS order_placed_date, od.`date_add` AS ordered_date
						FROM `'._DB_PREFIX_.'orders` AS od
						LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
						ON oh.`id_order` = od.`id_order`
						LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl
						ON osl.`id_order_state` = oh.`id_order_state`
						LEFT JOIN `'._DB_PREFIX_.'customer` AS cus
						ON cus.id_customer = od.`id_customer`
						LEFT JOIN '._DB_PREFIX_.'employee AS emp
						ON emp.id_employee = cus.id_relationship_manager
						WHERE emp.id_employee='.$id_employee.'
						AND cus.`active` = 1 AND cus.`deleted` = 0 '.$fc_query.'
						AND oh.id_Order_history IN (
													SELECT  MAX(oha.`id_order_history`)
													FROM '._DB_PREFIX_.'order_history AS oha
													where od.id_order = oha.id_order
													GROUP BY oha.id_order)
						GROUP BY od.`id_order`
					) AS orders
				) AS result
				GROUP BY id_order_state, hours';
		return Db::getInstance()->ExecuteS($sql);
	}

	public function getStatusOrdersDetails($id_employee,$order_status,$duration,$id_fc = NULL)
	{
 		if($order_status == "2118")
		{
			$status_qry= "IN(21,18)";
		}
		else
		{
			
			$status_qry = "= ".$order_status."";
		}
	
		if($id_employee != 0)
		{
			$empqry = "emp.id_employee=".$id_employee." AND ";
		}
		else
		{
			$empqry = " ";
		}

		if($id_fc)
			$fc_query = 'AND od.`id_fc` = '.$id_fc.'';

		
  		$sql = 'SELECT orderid, id_customer, firstname, total_paid, DATE_ADD, hours, name, buyer 
					FROM (
					SELECT orderid, id_order_state,	id_customer, firstname, total_paid, id_buyer, name,
						CASE WHEN (TIMESTAMPDIFF(HOUR, IF(order_placed_date IS NULL, ordered_date, order_placed_date), NOW())) < 24 THEN 24
							 WHEN (TIMESTAMPDIFF(HOUR, IF(order_placed_date IS NULL, ordered_date, order_placed_date), NOW())) < 48 THEN 48
							 ELSE 72
						END AS hours,
						IF(order_placed_date IS NULL, ordered_date, order_placed_date) AS DATE_ADD, id_buyer AS buyer
					FROM (
						SELECT od.`id_order` AS orderid, MAX(oh.`id_order_state`) AS id_order_state, osl.`name`,
						cus.`id_customer`, cus.`firstname`, od.`total_paid`, cus.`id_buyer`,
						(SELECT ohr.`date_add` FROM `'._DB_PREFIX_.'order_history` ohr 
							WHERE ohr.`id_order` = od.`id_order` 
							AND ohr.`id_order_state` = '.Configuration::get('PS_OS_ORDERPLACED').'
							GROUP BY ohr.`id_order`
						) AS order_placed_date, od.`date_add` AS ordered_date
						FROM `'._DB_PREFIX_.'orders` AS od
						LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
						ON oh.`id_order` = od.`id_order`
						LEFT JOIN `'._DB_PREFIX_.'customer` AS cus
						ON cus.id_customer = od.`id_customer`
						LEFT JOIN '._DB_PREFIX_.'employee AS emp
						ON emp.id_employee = cus.id_relationship_manager
						LEFT JOIN '._DB_PREFIX_.'order_state_lang AS osl
						ON osl.`id_order_state`= oh.`id_order_state`
						WHERE '.$empqry.' oh.`id_order_state`'.$status_qry.' AND osl.id_lang=1
						AND cus.`active` = 1 AND cus.`deleted` = 0 '.$fc_query.'
						AND oh.id_Order_history IN (
									SELECT  MAX(oha.`id_order_history`)
									FROM '._DB_PREFIX_.'order_history AS oha
									where od.id_order = oha.id_order
									GROUP BY oha.id_order
								)
						GROUP BY od.`id_order`
					) AS orders
				) AS result 
				WHERE hours = '.$duration.' ORDER BY DATE_ADD DESC';
		return Db::getInstance()->ExecuteS($sql);
	}

	public static function getOrderStatusForScn($isFinanace = false,$id_fc = NULL)
	{
		$fc_query ="";
		$order_status_id ="";
		if($isFinanace)
		{
			$order_status_id = 'where id_order_state IN ('.OrderState::FLAG_PENDING_INVOICE.','.OrderState::FLAG_PENDING_PAYMENT.','.OrderState::FLAG_INVOICE_SUBMISSION_PENDING.')';			
		}

		if($id_fc)
			$fc_query = 'AND od.`id_fc` = '.$id_fc.'';
		
 		$sql = 'SELECT id_order_state,hours, COUNT(orderid) AS totalorder, buyer
				FROM (
					SELECT id_order_state, orderid, buyer, 
					CASE WHEN (TIMESTAMPDIFF(HOUR, IF(order_placed_date IS NULL, ordered_date, order_placed_date), NOW())) < 24 THEN 24
						 WHEN (TIMESTAMPDIFF(HOUR, IF(order_placed_date IS NULL, ordered_date, order_placed_date), NOW())) < 48 THEN 48
						 ELSE 72
					END AS hours, (TIMESTAMPDIFF(HOUR, order_placed_date, NOW()))
					FROM (
						SELECT od.`id_order` AS orderid,cus.`id_customer`,cus.`firstname`,cus.`Id_buyer` AS buyer, 
						MAX(oh.`id_order_state`) AS id_order_state,
						(SELECT ohr.`date_add` FROM `'._DB_PREFIX_.'order_history` ohr 
							WHERE ohr.`id_order` = od.`id_order` 
							AND ohr.`id_order_state` = '.Configuration::get('PS_OS_ORDERPLACED').'
							GROUP BY ohr.`id_order`
						) AS order_placed_date, od.`date_add` AS ordered_date
						FROM `'._DB_PREFIX_.'customer` AS cus
						LEFT JOIN `'._DB_PREFIX_.'orders` AS od ON od.`id_customer` = cus.id_customer
						LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh ON oh.id_order = od.`id_order`
						WHERE cus.`active` = 1 AND cus.`deleted` = 0 '.$fc_query.'
						AND	oh.id_Order_history IN (
										SELECT  MAX(oha.`id_order_history`)
										FROM '._DB_PREFIX_.'order_history AS oha
										where od.id_order = oha.id_order
										GROUP BY oha.id_order)
						GROUP BY od.id_order
					) AS orders
				) AS result
				'.$order_status_id.'
				GROUP BY id_order_state, hours';
 		return Db::getInstance()->ExecuteS($sql);
	}
	
	public function order_search($term)
	{
		$results = Db::getInstance()->ExecuteS("SELECT id_order FROM "._DB_PREFIX_."order_detail WHERE id_order LIKE '%".$term."%' GROUP BY id_order "); 
		$data = json_encode($results);
		$user_friend =  json_decode($data, true );
		    $data=array();
		    foreach($user_friend as $key=>$val)
		            $data[]=$val['id_order'];
		    $json_friends =json_encode($data);
		    return $json_friends;
	}

	public function savePoNumber($po_number,$id_order)
	{
		Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'orders SET po_number="'.$po_number.'" WHERE id_order='.$id_order);
	}

	private function _getFormatedAddress(Address $the_address, $line_sep, $fields_style = array())
	{
		return AddressFormat::generateAddress($the_address, array('avoid' => array()), $line_sep, ' ', $fields_style);
	}
	
	public function approveOrder($id_customer,$payment_type = NULL,$order_id, $epay_later_order_id = false)
	{
		$customer_role = Customer::getCurrentCustomerRole();
		//Change Order Status to Approved
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;

		if($payment_type == 5)
		{
			if($customer_role == 2)//Approver Level 2
				$order_status = OrderState::FLAG_LEVEL2_APPROVED;
			else if($customer_role == 3)//Approver Level 3
				$order_status = OrderState::FLAG_LEVEL3_APPROVED;
			else if($customer_role == 4)//Approver Level 4
				$order_status = OrderState::FLAG_LEVEL4_APPROVED;
		}
		else
			$order_status = OrderState::FLAG_APPROVED;//Approver Level 1
		
		$result = $history->changeIdOrderStateByApprover($order_status, (int)$this->id, $id_customer, NULL, $payment_type);
		$customer = new Customer((int)($id_customer));
		/*
		$historyCustomer->add();
		*/
		//Change Order Status to Order Placed
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		//$history->changeIdOrderState((int)(OrderState::FLAG_ORDER_PLACED), (int)$this->id);
		if($payment_type != 5) {
			$old_orgin_order = Order::getOrginOrderId((int)$this->id);
			$old_orgin_customer = Order::getOrginOrderCustomer((int)$this->id);
			$context = Context::getContext();
			$cus_id = $context->cookie->id_customer;
			if($old_orgin_order != "" && $context->cookie->id_customer != $old_orgin_customer){
				$re = Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO '._DB_PREFIX_.'orgin_orders (`id_old_order`, `id_new_order`, `id_customer`) VALUES ('.$old_orgin_order.','.$this->id.','.$cus_id.')');
			}
			$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_ORDER_PLACED), (int)$this->id);
		}
		else {
			$old_orgin_order = Order::getOrginOrderId((int)$this->id);
			Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO '._DB_PREFIX_.'orgin_orders (`id_old_order`, `id_new_order`, `id_customer`) VALUES ('.$old_orgin_order.','.(int)$this->id.','.(int)($id_customer).')');
		}
 		//Estimated delivery time
		//Setting estimated delivery time
		
		//Get current IST time
		date_default_timezone_set('Asia/Kolkata');
		// $orderPlacedTime = new DateTime();
		// $cutOffTime = new DateTime();
		// $cutOffTime->setTime(12, 0, 0);
		
		// $estimated_delivery_time = new DateTime();
		// $estimated_delivery_time = $orderPlacedTime;
		
		// if($orderPlacedTime < $cutOffTime){
		// 	$estimated_delivery_time->modify('+1 day');
		// }
		// else{
		// 	$estimated_delivery_time->modify('+2 day');
		// }
		
		// $estimated_delivery_time->setTime(22, 0, 0);
		// $this->estimated_delivery_time = $estimated_delivery_time->format('Y-m-d H:i:s');
		$this->estimated_delivery_time ='0000-00-00 00:00:00';
		$this->update();
		
		if((($customer_role == 2) && ($customer->getApprover())) || (!$customer->getApprover()))
		{
			$order = new Order($order_id);
			$customerNew = new Customer($order->id_customer);
			$cart = new Cart($order->id_cart);
			$vat_address = new Address((int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
			$id_supplier = (int)$this->getSupplier();
			$supplier = new EliteSupplier(intval($id_supplier));
			$products = $cart->getProducts(false, false, null, $id_supplier);

			$productsList = '';

			$customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
			Product::addCustomizationPrice($products, $customizedDatas);

			$storeAllTaxes = array();

			foreach ($products AS $key => $product)
			{
				$productQuantity = (int)(Product::getQuantity((int)($product['id_product']), ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL)));
				$quantityInStock = ($productQuantity - (int)($product['cart_quantity']) < 0) ? $productQuantity : (int)($product['cart_quantity']);
				
				if ($id_order_state != Configuration::get('PS_OS_CANCELED') AND $id_order_state != Configuration::get('PS_OS_ERROR'))
				{
					if (Product::updateQuantity($product, (int)$order->id))
						$product['stock_quantity'] -= $product['cart_quantity'];

					Product::updateDefaultAttribute($product['id_product']);
				}

				$price = Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 6, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
				$price_wt = Product::getPriceStatic((int)($product['id_product']), true, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 2, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));

				/* Store tax info */
				$id_country = (int)Country::getDefaultCountryId();
				$id_state = 0;
				$id_county = 0;
				$rate = 0;
				$id_address = $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
				$address_infos = Address::getCountryAndState($id_address);
				if ($address_infos['id_country'])
				{
					$id_country = (int)($address_infos['id_country']);
					$id_state = (int)$address_infos['id_state'];
					$id_county = (int)County::getIdCountyByZipCode($address_infos['id_state'], $address_infos['postcode']);
				}
				$allTaxes = TaxRulesGroup::getTaxes((int)Product::getIdTaxRulesGroupByIdProduct((int)$product['id_product']), $id_country, $id_state, $id_county);
				$nTax = 0;
				foreach ($allTaxes AS $res)
				{
					if (!isset($storeAllTaxes[$res->id]))
					{
						$storeAllTaxes[$res->id] = array();
						$storeAllTaxes[$res->id]['amount'] = 0;
					}
					$storeAllTaxes[$res->id]['name'] = $res->name[(int)$order->id_lang];
					$storeAllTaxes[$res->id]['rate'] = $res->rate;

					if (!$nTax++)
						$storeAllTaxes[$res->id]['amount'] += ($price * ($res->rate * 0.01)) * $product['cart_quantity'];
					else
					{
						$priceTmp = $price_wt / (1 + ($res->rate * 0.01));
						$storeAllTaxes[$res->id]['amount'] += ($price_wt - $priceTmp) * $product['cart_quantity'];
					}
				}
				/* End */

				// Add some informations for virtual products
				$deadline = '0000-00-00 00:00:00';
				$download_hash = NULL;
				if ($id_product_download = ProductDownload::getIdFromIdProduct((int)($product['id_product'])))
				{
					$productDownload = new ProductDownload((int)($id_product_download));
					$deadline = $productDownload->getDeadLine();
					$download_hash = $productDownload->getHash();
				}

				// Exclude VAT
				if (Tax::excludeTaxeOption())
				{
					$product['tax'] = 0;
					$product['rate'] = 0;
					$tax_rate = 0;
				}
				else
					$tax_rate = Tax::getProductTaxRate((int)($product['id_product']), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                $ecotaxTaxRate = 0;
                if (!empty($product['ecotax']))
                    $ecotaxTaxRate = Tax::getProductEcotaxRate($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                $product_price = (float)Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, false, false);

				$group_reduction = (float)GroupReduction::getValueForProduct((int)$product['id_product'], $customerNew->id_default_group) * 100;
				if (!$group_reduction)
					$group_reduction = Group::getReduction((int)$order->id_customer);

				$quantityDiscount = SpecificPrice::getQuantityDiscount((int)$product['id_product'], Shop::getCurrentShop(), (int)$cart->id_currency, (int)$vat_address->id_country, (int)$customerNew->id_default_group, (int)$product['cart_quantity']);
				$unitPrice = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? intval($product['id_product_attribute']) : NULL), 2, NULL, false, true, 1, false, (int)$order->id_customer, NULL, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
				$quantityDiscountValue = $quantityDiscount ? ((Product::getTaxCalculationMethod((int)$order->id_customer) == PS_TAX_EXC ? Tools::ps_round($unitPrice, 2) : $unitPrice) - $quantityDiscount['price'] * (1 + $tax_rate / 100)) : 0.00;

				$customizationQuantity = 0;
				if (isset($customizedDatas[$product['id_product']][$product['id_product_attribute']]))
				{
					$customizationText = '';
					foreach ($customizedDatas[$product['id_product']][$product['id_product_attribute']] AS $customization)
					{
						if (isset($customization['datas'][_CUSTOMIZE_TEXTFIELD_]))
							foreach ($customization['datas'][_CUSTOMIZE_TEXTFIELD_] AS $text)
								$customizationText .= $text['name'].':'.' '.$text['value'].'<br />';

						if (isset($customization['datas'][_CUSTOMIZE_FILE_]))
							$customizationText .= sizeof($customization['datas'][_CUSTOMIZE_FILE_]) .' '. Tools::displayError('image(s)').'<br />';

						$customizationText .= '---<br />';
					}

					$customizationText = rtrim($customizationText, '---<br />');

					$customizationQuantity = (int)($product['customizationQuantityTotal']);
					$productsList .=
						'<tr>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$product['reference'].'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').' - '.$this->l('Customized').(!empty($customizationText) ? ' - '.$customizationText : '').'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$customizationQuantity.'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice($customizationQuantity * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</span></div></td>
						</tr>';
				}

				if (!$customizationQuantity OR (int)$product['cart_quantity'] > $customizationQuantity)
					$productsList .=
						'<tr>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$product['reference'].'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container"> '.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" 
							class="editable_text"><span class="text_container">'.((int)($product['cart_quantity']) - $customizationQuantity).'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice(((int)($product['cart_quantity']) - $customizationQuantity) * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</span></div></td>
						</tr>';
				} // end foreach ($products)

				/* Add carrier tax */
				$shippingCostTaxExcl = $cart->getOrderShippingCost((int)$order->id_carrier, false);
				$allTaxes = TaxRulesGroup::getTaxes((int)Carrier::getIdTaxRulesGroupByIdCarrier((int)$order->id_carrier), $id_country, $id_state, $id_county);
				$nTax = 0;

				foreach ($allTaxes AS $res)
				{
					if (!isset($res->id))
						continue;

					if (!isset($storeAllTaxes[$res->id]))
						$storeAllTaxes[$res->id] = array();
					if (!isset($storeAllTaxes[$res->id]['amount']))
						$storeAllTaxes[$res->id]['amount'] = 0;
					$storeAllTaxes[$res->id]['name'] = $res->name[(int)$order->id_lang];
					$storeAllTaxes[$res->id]['rate'] = $res->rate;

					if (!$nTax++)
						$storeAllTaxes[$res->id]['amount'] += ($shippingCostTaxExcl * (1 + ($res->rate * 0.01))) - $shippingCostTaxExcl;
					else
					{
						$priceTmp = $order->total_shipping / (1 + ($res->rate * 0.01));
						$storeAllTaxes[$res->id]['amount'] += $order->total_shipping - $priceTmp;
					}
				}

				/* Store taxes */
				/*foreach ($storeAllTaxes AS $t)
					Db::getInstance()->Execute('
					INSERT INTO '._DB_PREFIX_.'order_tax (id_order, tax_name, tax_rate, amount)
					VALUES ('.(int)$order->id.', \''.pSQL($t['name']).'\', '.(float)($t['rate']).', '.(float)$t['amount'].')');
				*/
				// Insert discounts from cart into order_discount table
				$discounts = $cart->getDiscounts();
				$discountsList = '';
				$total_discount_value = 0;
				$shrunk = false;
				foreach ($discounts AS $discount)
				{
					$objDiscount = new Discount((int)$discount['id_discount']);
					$value = $objDiscount->getValue(sizeof($discounts), $cart->getOrderTotal(true, Cart::ONLY_PRODUCTS), $order->total_shipping, $cart->id);
					if ($objDiscount->id_discount_type == 2 AND in_array($objDiscount->behavior_not_exhausted, array(1,2)))
						$shrunk = true;

					if ($shrunk AND ($total_discount_value + $value) > ($order->total_products_wt + $order->total_shipping + $order->total_wrapping))
					{
						$amount_to_add = ($order->total_products_wt + $order->total_shipping + $order->total_wrapping) - $total_discount_value;
						if ($objDiscount->id_discount_type == 2 AND $objDiscount->behavior_not_exhausted == 2)
						{
							$voucher = new Discount();
							foreach ($objDiscount AS $key => $discountValue)
								$voucher->$key = $discountValue;
							$voucher->name = 'VSRK'.(int)$order->id_customer.'O'.(int)$order->id;
							$voucher->value = (float)$value - $amount_to_add;
							$voucher->add();
							$params['{voucher_amount}'] = Tools::displayPrice($voucher->value, $currency, false);
							$params['{voucher_num}'] = $voucher->name;
							$params['{firstname}'] = $customerNew->firstname;
							$params['{lastname}'] = $customerNew->lastname;
							$params['{id_order}'] = $order->id;

							$notifyType = new Notifications(6);
							$notificationData = array('id_customer' => $customerNew->id, 
	                              'notification_type' => $notifyType->id,
	                              'url' => $notifyType->url."/".$params['{voucher_num}'],
	                              'content' => 'New voucher '.$params['{voucher_num}'].' for your order # '.$order->id.' has been created. Amount: '.$params['{voucher_amount}'].'. Check email for more details. - kobzo.com');
	    					Notifications::addNotification($notificationData);

							@Mail::Send((int)$order->id_lang, 'voucher', Mail::l('New voucher regarding your order #', (int)$order->id_lang).$order->id, $params, $customerNew->email, $customerNew->firstname.' '.$customerNew->lastname);
						}
					}
					else
						$amount_to_add = $value;
					$order->addDiscount($objDiscount->id, $objDiscount->name, $amount_to_add);
					$total_discount_value += $amount_to_add;
					if ($id_order_state != Configuration::get('PS_OS_ERROR') AND $id_order_state != Configuration::get('PS_OS_CANCELED'))
						$objDiscount->quantity = $objDiscount->quantity - 1;
					$objDiscount->update();

					$discountsList .=
					'<tr style="background-color:#EBECEE;">
							<td colspan="4" style="padding: 0.6em 0.4em; text-align: right;">'.$this->l('Voucher code:').' '.$objDiscount->name.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.($value != 0.00 ? '-' : '').Tools::displayPrice($value, $currency, false).'</td>
					</tr>';
				}

			$invoice = new Address((int)($order->id_address_invoice));
			$delivery = new Address((int)($order->id_address_delivery));
			$carrier = new Carrier((int)($order->id_carrier), $order->id_lang);
			$delivery_state = $delivery->id_state ? new State((int)($delivery->id_state)) : false;
			$invoice_state = $invoice->id_state ? new State((int)($invoice->id_state)) : false;
			//set approver and child names for Mail purpose .
			$child = new Customer((int)$order->id_customer);
			$child_name = $child->firstname; 			
			$approver_name = new Customer($customer->getApprover());
			
			$approver_data_name =  $approver_name->firstname;
			
			$data = array(
				'{firstname}' => $customerNew->firstname,
				'{lastname}' => $customerNew->lastname,
				'{email}' => $customerNew->email,
				'{delivery_block_txt}' => $this->_getFormatedAddress($delivery, "\n"),
				'{invoice_block_txt}' => $this->_getFormatedAddress($invoice, "\n"),
				'{delivery_block_html}' => $this->_getFormatedAddress($delivery, "<br />",
				array(
					'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
					'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{invoice_block_html}' => $this->_getFormatedAddress($invoice, "<br />",
				array(
					'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
					'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{delivery_company}' => $delivery->company,
					'{delivery_firstname}' => $delivery->firstname,
					'{delivery_lastname}' => $delivery->lastname,
					'{delivery_address1}' => $delivery->address1,
					'{delivery_address2}' => $delivery->address2,
					'{delivery_city}' => $delivery->city,
					'{delivery_postal_code}' => $delivery->postcode,
					'{delivery_country}' => $delivery->country,
					'{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
					'{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
					'{delivery_other}' => $delivery->other,
					'{invoice_company}' => $invoice->company,
					'{invoice_vat_number}' => $invoice->vat_number,
					'{invoice_firstname}' => $invoice->firstname,
					'{invoice_lastname}' => $invoice->lastname,
					'{invoice_address2}' => $invoice->address2,
					'{invoice_address1}' => $invoice->address1,
					'{invoice_city}' => $invoice->city,
					'{invoice_postal_code}' => $invoice->postcode,
					'{invoice_country}' => $invoice->country,
					'{invoice_state}' => $invoice->id_state ? $invoice_state->name : '',
					'{invoice_phone}' => ($invoice->phone) ? $invoice->phone : $invoice->phone_mobile,
					'{invoice_other}' => $invoice->other,
					'{order_name}' => sprintf("#%06d", (int)($order->id)),
					'{date}' => Tools::displayDate(date('Y-m-d H:i:s'), (int)($order->id_lang), 1),
					'{carrier}' => $carrier->name,
					'{payment}' => Tools::substr($order->payment, 0, 32),
					'{products}' => $productsList,
					'{discounts}' => $discountsList,
					'{total_paid}' => Tools::displayPrice($order->total_paid, $currency, false),
					'{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_wrapping + $order->total_discounts, $currency, false),
					'{total_discounts}' => Tools::displayPrice($order->total_discounts, $currency, false),
					'{total_shipping}' => Tools::displayPrice($order->total_shipping, $currency, false),
					'{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $currency, false),
					'{approver_name}' => $approver_data_name,
					'{approved_by}' =>$customer->firstname,
					'{child_name}' => $child_name,
					'{old_order_id}' => $creator_old_order_id,
					'{supplier}' => $supplier->company);
 
 			if($customer->getApprover())
 			{
 				if($payment_type == 5) 
 				{	 				
	 				$notifyType = new Notifications(3);
	 				$notificationData1 = array('id_customer' => $approver_name->id, 
	                                      'notification_type' => $notifyType->id,
	                                      'url' => $notifyType->url."/".$order->id,
	                                      'content' => $em_sub);
	 				$notificationData2 = array('id_customer' => $customerNew->id, 
	                                      'notification_type' => $notifyType->id,
	                                      'url' => $notifyType->url."/".$order->id,
	                                      'content' => $em_sub);
	                Notifications::addNotification($notificationData1);
	                Notifications::addNotification($notificationData2);
					
					
 					$em_sub = 'Order confirmation | The Order with kobzo.com [#'. $order->id .'] is pending for your approval'; 
					Mail::Send(1, 'order_submit_approval', Mail::l($em_sub, 1), $data, $approver_name->email, $approver_name->firstname.' '.$approver_name->lastname, NULL, NULL);
					if($approver_name->mobile) {
						$msgtxt = 'Hello '.$approver_name->firstname.' , The order # '.$order->id.' is pending for your approval. - kobzo.com';
						SMSAlert::sendSMSAlert($approver_name->mobile, $msgtxt);
					}

 					$em_sub = 'Order confirmation | Your Order with kobzo.com [#'. $order->id .'] is approved at level1 and waiting for level2 approval'; 
					Mail::Send(1, 'order_pending_approval_level1', Mail::l($em_sub, 1), $data, $customerNew->email, $customerNew->firstname.' '.$customerNew->lastname, NULL, NULL);
					if($customerNew->mobile) {
						$msgtxt = 'Hello '.$customerNew->firstname.', Your order # '.$order->id.' has been approved at Level1 and waiting for Level2 approval. - kobzo.com';
						SMSAlert::sendSMSAlert($customerNew->mobile, $msgtxt);
					}

					$em_sub = 'Order confirmation | The order with kobzo.com [#' . $order->id . '] is sent for level2 approval';
                    Mail::Send(1, 'order_pending_approval', Mail::l($em_sub, 1) , $data, $customer->email, $customer->firstname . ' ' . $customer->lastname, NULL, NULL);
                    if($customer->mobile) {
                    	$msgtxt = 'Hello '.$customer->firstname.', The order # '.$order->id.' has been sent for Level2 approval. - kobzo.com';
						SMSAlert::sendSMSAlert($customer->mobile, $msgtxt);
                    }
 				}
 				else {
 					$sql = 'SELECT id_customer,id_new_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE id_old_order=(SELECT DISTINCT id_old_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE id_new_order='.$order->id.')';
					$result = Db::getInstance()->ExecuteS($sql);

					foreach($result as $resultArr) 
					{
						$res = new Customer($resultArr['id_customer']);

						$em_sub = 'Order confirmation | Your Order with kobzo.com [#'. $order->id .'] has  been successfully placed!';
						
						$data['{firstname}'] = $res->firstname;
						$data['{lastname}'] = $res->lastname;
						
						$notifyType = new Notifications(1);
						$notificationData = array('id_customer' => $res->id, 
	                                      'notification_type' => $notifyType->id,
	                                      'url' => $notifyType->url."/".$order->id,
	                                      'content' => $em_sub);
	                	Notifications::addNotification($notificationData);
						
						Mail::Send(1, 'order_approve_conf', Mail::l($em_sub, 1), $data, $res->email, $res->firstname.' '.$res->lastname, NULL, NULL);
					}
 				}
 			}
 			else if(!$customer->getApprover())
 			{
				$sql = 'SELECT id_customer,id_new_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE id_old_order=(SELECT DISTINCT id_old_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE id_new_order='.$order_id.')';
				$result = Db::getInstance()->ExecuteS($sql);

				foreach($result as $resultArr) 
				{
					$res = new Customer($resultArr['id_customer']);

					$em_sub = 'Order confirmation | Your Order with kobzo.com [#'. $order->id .'] has  been successfully placed!';
					
					$data['{firstname}'] = $res->firstname;
					$data['{lastname}'] = $res->lastname;
					
					$notifyType = new Notifications(1);
					$notificationData = array('id_customer' => $res->id, 
                                      'notification_type' => $notifyType->id,
                                      'url' => $notifyType->url."/".$order->id,
                                      'content' => $em_sub);
                	Notifications::addNotification($notificationData);
					
					Mail::Send(1, 'order_approve_conf', Mail::l($em_sub, 1), $data, $res->email, $res->firstname.' '.$res->lastname, NULL, NULL);

					if($res->mobile) {
						$msgtxt = 'Hello '.$res->firstname.', Your order # '.$this->id.' has been approved. - kobzo.com';
						SMSAlert::sendSMSAlert($res->mobile, $msgtxt);
					}
				}
 			}

 			/*** Trigger email to supplier ***/
 			if($payment_type != PaymentModule::PENDING_FOR_APPROVAL) {
 			// 	$supplier_order = new EliteSupplierOrders();
    //             $supplier_order->id_supplier = $supplier->id;
    //             $supplier_order->id_order = $order->id;
                if(Order::addSupplier((int)$order->id, (int)$supplier->id)) {
                	$supplier->triggerOrderConfEmail($data, $order, (int)$this->id_lang, (int)$this->id_shop);
                }
 			}
			
		}
	}
	
	public function rejectOrder($id_customer,$reject_msg = NULL)
	{
		//Change Order Status to Rejected
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		//$history->changeIdOrderState((int)(OrderState::FLAG_REJECTED), (int)$this->id);
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_REJECTED), (int)$this->id,$id_customer);
		
		//Persist the user who Rejected the order
		/*$historyCustomer = new HistoryCustomer();
		$historyCustomer->id_history = $history->id;
		$historyCustomer->id_customer = $id_customer;
		$historyCustomer->add();*/
		
		//Change Order Status to Cancelled
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		//$history->changeIdOrderState((int)(OrderState::FLAG_CANCELED), (int)$this->id);
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_CANCELED), (int)$this->id);
		$notifyType = new Notifications(5);
		
		// save approver msg for cancel the order  in kob message
		if($reject_msg)
		{
			$message = new Message();
			$message->message = $reject_msg;
			$message->id_customer = $id_customer;
			$message->id_employee= 0;
			$message->private= 1;
			$message->id_order= (int)$this->id;
			$message->add();
			$reason = $reject_msg;
		}
		else
			$reason = "No Reason Provided";
		/*Information part- SEND MAIL & SMS */
		$creater = new Customer($this->id_customer);
		$creater_name = ''.$creater->firstname.' '.$creater->lastname.'';
		$approver = new Customer($id_customer);
		$approver_name = ''.$approver->firstname.' '.$approver->lastname.'';

		$order_has_origin = Order::getOrginOrderId($history->id_order);

		if($order_has_origin)
		{
			$orgin_related_orders = Order::getOrginChildIds($order_has_origin);

			for($i = 0; $i < sizeof($orgin_related_orders); $i++)
			{
				if($orgin_related_orders[$i]['id_customer'])
				{
					$intermediate_approver = new Customer($orgin_related_orders[$i]['id_customer']);

					if($intermediate_approver)
					{
						$intermediate_approver_name = ''.$intermediate_approver->firstname.' '.$intermediate_approver->lastname.'';						
						//Send Mail to intermediate approvers who related to this order
				 		$msgtxt='Hello '.$intermediate_approver->firstname.', your order # '.$this->id.' has been rejected. Check email for more details. - kobzo.com';
						
						$notificationData = array('id_customer' => $intermediate_approver->id, 
                                      'notification_type' => $notifyType->id,
                                      'url' => $notifyType->url."/".$this->id,
                                      'content' => 'Your order # '.$this->id.' has been rejected. Check email for more details. - kobzo.com');
                		Notifications::addNotification($notificationData);
						
						Mail::Send(1, 'rejectcreatororder', Mail::l('Order has been Rejected ', 1), array('{approver_name}' => $approver_name,'{creater_name}' => $intermediate_approver_name, '{order_id}' => (int)$this->id, '{reason}' => $reason), $intermediate_approver->email, 'Order has been Rejected', 'noreply@kobzo.com');
			
						//Send SMS Alert to intermediate approvers who related to this order
						SMSAlert::sendSMSAlert($intermediate_approver->mobile, $msgtxt);
					}
				}
			}
		}
		else
		{ // if order has no origin
			$status = OrderHistory::getAllStatus((int)($history->id_order),1);
			$latest_status = array_reverse($status);

			for($i = 0; $i < sizeof($latest_status); $i++)
			{
				if($latest_status[$i]['id_order_state'] != 6 && $latest_status[$i]['id_order_state'] != 30 && $latest_status[$i]['id_order_state'] != 9 && $latest_status[$i]['id_order_state'] != 28 )
				{
					$history_customer = OrderHistory::getHistoryCustomer($latest_status[$i]['id_order_history']);

					for($j = 0 ; $j < sizeof($history_customer); $j++)
					{
						$intermediate_approver = new Customer((int)($history_customer[$j]['id_customer']));

						if($intermediate_approver)
						{
							$intermediate_approver_name = ''.$intermediate_approver->firstname.' '.$intermediate_approver->lastname.'';						
					 		$msgtxt='Hello '.$intermediate_approver->firstname.', your order # '.$this->id.' has been rejected. Check email for more details. - kobzo.com';
							
							$notificationData = array('id_customer' => $intermediate_approver->id, 
                                      'notification_type' => $notifyType->id,
                                      'url' => $notifyType->url."/".$this->id,
                                      'content' => 'Your order # '.$this->id.' has been rejected. Check email for more details. - kobzo.com');
                			Notifications::addNotification($notificationData);
							
							//Send Mail to intermediate approvers who related to this order
							Mail::Send(1, 'rejectcreatororder', Mail::l('Order has been Rejected ', 1), array('{approver_name}' => $approver_name,'{creater_name}' => $intermediate_approver_name, '{order_id}' => (int)$this->id, '{reason}' => $reason), $intermediate_approver->email, 'Order has been Rejected', 'noreply@kobzo.com');
				
							//Send SMS Alert to intermediate approvers who related to this order
							SMSAlert::sendSMSAlert($intermediate_approver->mobile, $msgtxt);
						}
					}
				}
			}		
		}
	}
	
	public function reviseChildOrder($id_customer)
	{
		//step 1 -> order revised
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_ORDER_REVISED), (int)$this->id, $id_customer);
		
		//step 2 -> cancelled order
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_CANCELED), (int)$this->id ,$id_customer);
 	
 		$notifyType = new Notifications(5);
 		$msgtxt='Your order # '.$this->id.' has been revised and new order was placed. Check email for more details. - kobzo.com';
		$notificationData = array('id_customer' => $id_customer, 
	                              'notification_type' => $notifyType->id,
	                              'url' => $notifyType->url."/".$this->id,
	                              'content' => $msgtxt);
	    Notifications::addNotification($notificationData);

	}
	public function updateOrderPayment($payment)
	{
 		$this->payment = $payment;
		$this->update();
	}
	public function getChildrenOrders($id_customer, $limit = NULL, $offset = NULL, $fromDate = NULL, $toDate = NULL, $duration = NULL, $orderBy = NULL, $orderWay = NULL, $searchQuery = NULL)
	{	
		$customer_role = Customer::getCurrentCustomerRole();
 		
 		if($customer_role == 2)
 			$id_order_status = 28; 
 		else if($customer_role == 3)
  			$id_order_status = 43;

		$dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";

		$filterQuery = "";
		
		if($fromDate && $toDate)
			$filterQuery .= ' AND DATE(o.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($fromDate == NULL && $toDate)
			$filterQuery .= ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($toDate)).'"';
		else if($toDate == NULL && $fromDate)
			$filterQuery .= ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($fromDate)).'"';
		
		if($duration == 1)
			$filterQuery .= ' AND o.`date_add` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)';
		else if($duration == 2)
			$filterQuery .= ' AND DATE(o.`date_add`) >= CURDATE()';
		else if($duration == 3)
			$filterQuery .= ' AND WEEKOFYEAR(o.`date_add`) >= WEEKOFYEAR(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 4)
			$filterQuery .= ' AND MONTH(o.`date_add`) >= MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(o.`date_add`)';
		else if($duration == 5)
			$filterQuery .= "";

		if($searchQuery)
			$filterQuery .= ' AND (o.`id_order` LIKE "%'.$searchQuery.'%" OR cus.`firstname` LIKE "%'.$searchQuery.'%" OR
							 o.`date_add` LIKE "%'.$searchQuery.'%" OR osl.`name` LIKE "%'.$searchQuery.'%")';
		
 		$count_rows = "SELECT FOUND_ROWS() AS total";
		$data_rows = 'SELECT SQL_CALC_FOUND_ROWS o.`id_order`, o.`id_order`, parent.`id_customer` ,cus.`firstname`,o.`id_address_delivery` as delivery,o.`id_address_invoice` as invoice, 
 					  oh.`id_order_history`,DATE_FORMAT(o.`date_add`, "%M %d, %Y") as date_add, osl.`name` AS status';
 		
 		$sql = ' FROM `'._DB_PREFIX_.'customer_parent` parent , '._DB_PREFIX_.'orders o , '._DB_PREFIX_.'order_history oh, '._DB_PREFIX_.'customer cus, '._DB_PREFIX_.'order_state os, '._DB_PREFIX_.'order_state_lang osl
				WHERE parent.id_parent = '.$id_customer.'
				AND o.id_customer = parent.id_customer
				AND oh.id_order = o.id_order
				AND cus.id_customer = o.id_customer
				AND oh.`id_order_state` = os.`id_order_state`
				AND os.`id_order_state` = osl.`id_order_state`
				AND osl.`id_lang` = 1
				AND oh.id_order_state = '.$id_order_status.'
				'.$filterQuery.'
				AND oh.id_order_history IN (
					SELECT  MAX(oha.`id_order_history`)
					FROM '._DB_PREFIX_.'order_history AS oha
					WHERE o.id_order = oha.id_order
					GROUP BY oha.id_order) '.($orderBy ? 'ORDER BY '.$orderBy : "ORDER BY o.`id_order`").' '.($orderWay ? $orderWay : "DESC").'';

		$data_sql = $data_rows.$sql.$dataLimit;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($data_sql);
		$total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($count_rows);

		if (!$result)
			return array('total' => 0, 'results' => []);
		
		return array('total' => $total, 'results' => $result);											
	}
	
	public function getCusIdForOrder(){
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT o.`id_customer` FROM `'._DB_PREFIX_.'orders` o
			WHERE o.`id_order`='.$this->id.'
			GROUP BY o.`id_order`
			ORDER BY o.`date_add` DESC'
		);
	}

	/*public function getTopProductInCategory($customerid,$duration,$selected_category)
	{
		if($duration == 1)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 1 YEAR';
		}
		else 
		{
			$due_query ='';
		}
		 return Db::getInstance()->ExecuteS('SELECT count(od.product_id) as y,pl.name AS indexLabel,sum(od.product_quantity-od.product_quantity_return-product_quantity_refunded) as qty, round(sum((od.product_quantity-od.product_quantity_return-product_quantity_refunded)*od.product_price+(od.product_price*od.tax_rate/100))) as total
												FROM '._DB_PREFIX_.'order_detail od
												left join '._DB_PREFIX_.'orders o on o.id_order=od.id_order
												left join '._DB_PREFIX_.'product_lang pl on pl.id_product = od.product_id
												left join '._DB_PREFIX_.'order_history oh on od.id_order = oh.id_order 
												where id_customer = '.$customerid.' and pl.id_lang=1 and od.product_id IN (SELECT id_product FROM '._DB_PREFIX_.'category_product WHERE id_category IN (SELECT c.id_category FROM `'._DB_PREFIX_.'category` c LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = 1) WHERE `id_parent` ='.$selected_category.')) and oh.id_order_history in(SELECT  MAX(oha.`id_order_history`)
																									FROM '._DB_PREFIX_.'order_history AS oha
																									LEFT JOIN '._DB_PREFIX_.'orders AS oa
																									ON oa.id_order = oha.id_order 
																									where oa.id_customer = '.$customerid.'
																									GROUP BY oha.id_order)
												AND oh.`id_order_state` IN ( 5,25 ) '.$due_query.'
												group by od.product_id order by y desc limit 10');
												
	}
	*/
	

	public function getCusOrders($id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT a.`id_order` FROM `'._DB_PREFIX_.'orders` a WHERE a.`id_customer` = '.$id_customer.'');

	}
	/*if the order get revised then the old oder id and new order id will save with whom place the order. so we can retervie for future purpose */
	public static function getOrginOrderId($new_order_id)
	{
   		return Db::getInstance()->getValue('Select id_old_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE  id_new_order='.$new_order_id.'');
	}

	public static function getOrginOrderCustomer($new_order_id)
	{
   		return Db::getInstance()->getValue('Select id_customer FROM `'._DB_PREFIX_.'orgin_orders` WHERE  id_new_order='.$new_order_id.'');
	}
	
	public function getOrginChildIds($orgin_order_id)
	{
 		$result = Db::getInstance()->ExecuteS('Select *  FROM `'._DB_PREFIX_.'orgin_orders` WHERE  id_old_order='.$orgin_order_id.'');
 		
		$res_str='';
		foreach($result AS $res)
				$res_str = $res_str.$res['id_new_order'].',';
		$res_str = $res_str.$orgin_order_id;
		 $res_str;
		 
 		 
		return Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'orgin_orders where id_new_order in ('.$res_str.') ORDER BY `id_new_order` DESC ');
	}
	 
	public function getOrdersByState($id_state,$id_group){
		$state='';
		$group='';
		if($id_group)
			$group='AND kg.`id_group`='.$id_group.'';
		if($id_state)
			$state='ka.`id_state`='.$id_state.'';
		$sql='SELECT ko.`id_order`,ko.`payment`,ko.`date_add`,kosl.`name`,koh.*,kfc.`city_name`,ko.`id_fc` FROM `'._DB_PREFIX_.'orders` ko
				JOIN `'._DB_PREFIX_.'order_history` koh ON(koh.`id_order`=ko.`id_order`)
				JOIN `'._DB_PREFIX_.'address` ka ON(ka.`id_address`=ko.`id_address_invoice`)
				JOIN `'._DB_PREFIX_.'order_state` kos ON(kos.`id_order_state`=koh.`id_order_state`)
				JOIN `'._DB_PREFIX_.'order_state_lang` kosl ON(kosl.`id_order_state`=kos.`id_order_state`)
				JOIN `'._DB_PREFIX_.'fulfillment_centre` kfc ON(kfc.`id_fulfillment_centre`=ko.`id_fc`)
				JOIN `'._DB_PREFIX_.'customer` kc ON (kc.`id_customer`=ko.`id_customer`)
				JOIN `'._DB_PREFIX_.'group` kg ON (kg.`id_group`=kc.`id_default_group`)
				WHERE '.$state.'
				AND koh.`id_order_state`IN(37,33,4)
				AND koh.`id_order_history`=(SELECT MAX(`id_order_history`) FROM `'._DB_PREFIX_.'order_history` moh WHERE moh.`id_order` = ko.`id_order`)
				AND ko.`id_lang`=1
				'.$group.'
				AND kosl.`id_lang`=1';
		
		return Db::getInstance()->ExecuteS($sql);
	}

	public function getDashProducts($products = false, $selectedProducts = false, $selectedQty = false, $orderid = false )
	{
		if (!$products)
		{	
 			$products = $this->getProductsDetail($orderid);
   		}
 		$resultArray = array();
		foreach ($products AS $key=> $row)
		{
			// Change qty if selected
			if ($selectedQty)
			{
				$row['product_quantity'] = 0;
				foreach ($selectedProducts AS $key => $id_product)
					if ($row['id_order_detail'] == $id_product)
						$row['product_quantity'] = (int)($selectedQty[$key]);
				if (!$row['product_quantity'])
					continue ;
			}
			$this->setProductPrices($row);

			/* Add information for virtual product */
			if ($row['download_hash'] AND !empty($row['download_hash']))
				$row['filename'] = ProductDownload::getFilenameFromIdProduct($row['product_id']);

			/* Stock product */
			if($orderid=="")
 			$resultArray[(int)($row['id_order_detail'])] = $row;
			else
			 $resultArray[$key] = $row;
		}
 
 		return $resultArray;
	}

	public function getConsolidatedInvoice()
	{
		$sql='SELECT id_order FROM `'._DB_PREFIX_.'orders` WHERE invoice_number='.$this->invoice_number;
		$result= Db::getInstance()->ExecuteS($sql);
		return $result;
	}

	public static function getOrdersDetail($count, $limit, $offset, $orderBy, $orderWay, $id_order, $customer, $buyer_type, $state, $order_total, $payment, $order_status, $fc, $from_date, $to_date, $group)
	{
		if($count)
			$data_limit = '';
		else
			$data_limit = 'LIMIT '.$limit.','.$offset.'';
		$query = "";
		$query .= $id_order ? ' AND o.`id_order` LIKE "%'.$id_order.'%"' : '';
		$query .= $group ? ' AND gl.`name` LIKE "%'.$group.'%"' : '';
		$query .= $customer ? ' AND c.`firstname` LIKE "%'.$customer.'%"' : '';
		$query .= $state ? ' AND a.`id_state` = '.$state.'' : '';
		$query .= $order_total ? ' AND o.`total_paid` LIKE "%'.$order_total.'%"' : '';
		$query .= $payment ? ' AND o.`payment` LIKE "%'.$payment.'%"' : '';
		$query .= $order_status ? ' AND oh.`id_order_state` = '.$order_status.'' : '';
		$query .= $fc ? ' AND o.`id_fc` = '.$fc.'' : '';
		$query .= ($from_date && $to_date == false) ? ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($from_date)).'"' : '';
		$query .= ($from_date == false && $to_date) ? ' AND DATE(o.`date_add`) = "'.date("Y-m-d", strtotime($to_date)).'"' : '';
		$query .= ($from_date && $to_date) ? ' AND DATE(o.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($from_date)).'" AND "'.date("Y-m-d", strtotime($to_date)).'"' : '';

		if(isset($buyer_type)) {
			if($buyer_type == 3 || $buyer_type == 10)
				$query .= $buyer_type ? ' AND c.`id_buyer` = '.$buyer_type.'' : '';
			else if($buyer_type != 3)
				$query .= $buyer_type ? ' AND c.`id_buyer` NOT IN(3, 10)' : '';
		}
		
		return Db::getInstance()->ExecuteS('SELECT o.`id_order` AS id_order,o.`current_state`, gl.`name` AS company, CONCAT_WS("", c.`firstname`, " ", c.`lastname`) AS cus_name,
											c.`firstname` AS customer,c.`id_buyer` AS buyer_type, s.`name` AS state_name, o.`total_paid_tax_incl` AS order_total, o.`payment` AS payment,
											osl.`name` AS order_state_name, fc.`city_name` AS fc_city, o.`date_add` AS date_added, a.`firstname` AS address_name, 
											a.`company` AS address_company,	c.`company` AS cus_company, os.`color` AS color, IF(o.`id_employee` != 0, true, false) AS employee_placed_order,(select id_order from '._DB_PREFIX_.'split_details where id_order=o.`id_order` OR id_parent=o.`id_order` limit 1) as splitOrder
											FROM `'._DB_PREFIX_.'orders` o 
											LEFT JOIN `'._DB_PREFIX_.'customer` c ON c.`id_customer` = o.`id_customer`
											LEFT JOIN `'._DB_PREFIX_.'group_lang` gl ON c.`id_default_group` = gl.`id_group` AND gl.`id_lang` = 1
											LEFT JOIN `'._DB_PREFIX_.'address` a ON a.`id_address` = o.`id_address_delivery` 
											LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` fc ON (fc.`id_fulfillment_centre` = o.`id_fc`)
											LEFT JOIN `'._DB_PREFIX_.'state` s ON s.`id_state` = a.`id_state`
											LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (oh.`id_order` = o.`id_order`)
											LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
											LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (osl.`id_order_state` = oh.id_order_state AND osl.`id_lang` = 1)
											WHERE oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `'._DB_PREFIX_.'order_history` moh 
																		   WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
											'.$query.' ORDER BY `'.$orderBy.'` '.$orderWay.' '.$data_limit.'');
	}

	public function getOrderQuantity()
	{
		$sql = 'SELECT SUM(product_quantity)as total FROM `'._DB_PREFIX_.'order_detail` WHERE id_order ='.$this->id.'';
		return Db::getInstance()->ExecuteS($sql);
	}
	
	public function emptiesCart($productList, $qtyList)
	{
		$cancelQuantitySum = 0;
		$availableQuantitySum = 0;
		
		foreach ($productList as $key => $id_order_detail) 
        {
            $qtyCancelProduct = abs($qtyList[$key]);

            if (!$qtyCancelProduct){//No quantity has been selected for this product.
                $error_code = "404";
            }
                

            $order_detail = new OrderDetail($id_order_detail);
            if($order_detail->product_quantity >= $qtyCancelProduct)//check seleceted quantity and order's quantity
            {	
            	$availableQuantitySum = $availableQuantitySum + $order_detail->product_quantity;
            	$cancelQuantitySum = $cancelQuantitySum + $qtyCancelProduct;
            }
            else
            {
				return "404";
            }
        }
        
        $total_Order_Quantity = $this->getOrderQuantity();
        if($cancelQuantitySum > $total_Order_Quantity[0]['total'])//check total quantity selected 
        {
        	$error_code = "404";
        }
        else
        {
        	$error_code = "200";
        }
        return $error_code;
	}

	public function cancelProduct($productList, $qtyList, $generateDiscount, $shippingBack, $currency)
	{
	    if (!$productList)
	        $error_code = "Please select atleast one product."; //Must select product
	    elseif (!$qtyList) 
	        $error_code = "Please enter atleast one quantity to cancel."; //Must enter quantity
	    else 
	    {
	        $full_product_list = $productList;
	        $full_quantity_list = $qtyList;
	        $orderProducts = $this->getProductsDetail();

	        if ($productList) 
	        {
	            if ($productList) 
	            {
	                $id_cart = Cart::getCartIdByOrderId($this->id);
	                $customization_quantities = Customization::countQuantityByCart($id_cart);

	                foreach ($productList as $key => $id_order_detail) 
	                {
	                    $qtyCancelProduct = abs($qtyList[$key]);

	                    if (!$qtyCancelProduct) //No quantity has been selected for this product.
	                        $error_code = "Quantity missing to cancel the product.";

	                    $order_detail = new OrderDetail($id_order_detail);
	                    $customization_quantity = 0;
	                    if(!$this->checkDeliveredQuantity($id_order_detail,$qtyCancelProduct))
	                    {
	                    	$error_code = "Quantity to cancel is greater than quantity available.";
	                    }
	                    if (array_key_exists($order_detail->product_id, $customization_quantities) && array_key_exists($order_detail->product_attribute_id, $customization_quantities[$order_detail->product_id])) 
	                        $customization_quantity = (int)$customization_quantities[$order_detail->product_id][$order_detail->product_attribute_id];
	                    if (($order_detail->product_quantity - $customization_quantity - $order_detail->product_quantity_refunded - $order_detail->product_quantity_return) < $qtyCancelProduct)
	                        $error_code = "An invalid quantity was selected for the product."; //An invalid quantity was selected for this product.
	                }
	            }
	            if (!strlen($error_code) && $productList)
	            {
	                foreach ($productList as $key => $id_order_detail) 
	                {
	                    $qty_cancel_product = abs($qtyList[$key]);
	                    $order_detail = new OrderDetail((int)($id_order_detail));
	                        
	                    // Delete product
	                    $delete_order_product = $this->cancelOrderedProduct($this, $order_detail, $qty_cancel_product);

	                    // Check if an order exists in purchase order history (for BUDGET)
	                    $budget_order_type = PurchaseOrder::orderExists($order_detail->id_order);
        				if($budget_order_type) {
        					if($budget_order_type == 1) {
	                    		PurchaseOrder::updateHistoryByIdProduct($order_detail->id_order, $order_detail->product_id, $qty_cancel_product);
        					}
        					else if($budget_order_type == 2) {
	                    		PurchaseOrder::updateHistoryByIdOrder($order_detail->id_order, $order_detail->unit_price_tax_incl, $qty_cancel_product);
        					}
	                    }

	                    if($delete_order_product) {
	                    	$updated = $this->updateOrderValue($order_detail, $qty_cancel_product);
	                    }
	                    else {
	                    	$error_code = "An error occurred while deleting the product.";
	                    }	

	                    Hook::exec('actionProductCancel', array('order' => $this, 'id_order_detail' => (int)$id_order_detail), null, false, true, false, $this->id_shop);
	                }
	            }

	       //     $remaining = $this->getProductsCount();
	       //     $cancelled = count($this->getHistory((int)$this->id_lang, Configuration::get('PS_OS_BEING_PROCESSED')));
	       //     if ($remaining[0]['remainingQuantity'] == 0 && !$cancelled) {
		      //      $history = new OrderHistory();
		      //      $history->id_order = (int)$this->id;
		      //      $history->changeIdOrderState(Configuration::get('PS_OS_BEING_PROCESSED'), $this);
		      //      $history->addWithemail();
		      //     	$error_code = 0;
		      //  }

	            // E-mail params
	            if (($generateDiscount == 1) && !strlen($error_code)) 
	            {
	                $customer = new Customer((int)($this->id_customer));
	                $params['{lastname}'] = $customer->lastname;
	                $params['{firstname}'] = $customer->firstname;
	                $params['{id_order}'] = $this->id;
	                $params['{order_name}'] = $this->getUniqReference();
	            }

	            // Generate voucher
	            if ($generateDiscount == 1 && !strlen($error_code)) 
	            {
	            	$products = $this->getProducts($orderProducts, $full_product_list, $full_quantity_list);
	                $total = 0;

	                foreach ($products as $product) 
	                    $total += $product['unit_price_tax_incl'] * $product['product_quantity'];

	                if ($shippingBack == 1) 
	                    $total += $this->total_shipping;

	                $now = time();
	                $cartrule = new CartRule();
	                $languages = Language::getLanguages(true);
	                $cartrule->description = sprintf("Credit card slip for order #%d", $this->id);
	                $cartrule->code = 'V0C'.(int)($this->id_customer).'O'.(int)($this->id);
	                $cartrule->quantity = 1;
	                $cartrule->quantity_per_user = 1;
	                $cartrule->id_customer = $this->id_customer;
	                $cartrule->date_from = date('Y-m-d H:i:s', $now);
	                $cartrule->date_to = date('Y-m-d H:i:s', $now + (3600 * 24 * 365.25)); /* 1 year */
	                $cartrule->active = 1;
	                $cartrule->reduction_amount = $total;
	                $cartrule->reduction_tax = true;
	                $cartrule->minimum_amount_currency = $this->id_currency;
	                $cartrule->reduction_currency = $this->id_currency;
	                
	                foreach ($languages AS $language)
						$cartrule->name[(int)$language['id_lang']] = 'V0C'.(int)($this->id_customer).'O'.(int)($this->id);

	                if (!$cartrule->add()) 
	                    $error_code = 'You cannot generate a voucher.';
	                else 
	                {
	                   // Update the voucher code and name
	                	foreach ($languages AS $language)
							$cartrule->name[(int)$language['id_lang']] = 'V'.(int)($cartrule->id).'C'.(int)($this->id_customer).'O'.$this->id;

	                    $cartrule->code = 'V'.(int)($cartrule->id).'C'.(int)($this->id_customer).'O'.$this->id;

	                    if (!$cartrule->update()) 
	                        $error_code = 'You cannot generate a voucher.';
	                    else 
	                    {
	                        $params['{voucher_amount}'] = Tools::displayPrice($cartrule->reduction_amount, $currency, false);
	                        $params['{voucher_num}'] = $cartrule->code;
	                        @Mail::Send((int)$this->id_lang, 'voucher', sprintf(Mail::l('New voucher for your order #%s', (int)$this->id_lang), $this->reference),
	                        $params, $customer->email, $customer->firstname.' '.$customer->lastname, null, null, null,
	                        null, _PS_MAIL_DIR_, true, (int)$this->id_shop);
	                    }
	               }
	            }
	        } 
	        else 
	        {
	            $error_code = 'No product or quantity has been selected.';
	        }
	    }

	    if(!strlen($error_code))
            return 5;
        else 
            return $error_code;
	}

	public function updateOrderValue($order_detail, $quantity)
	{
	    $logger = new FileLogger();
	    $logger->setFilename("test.txt");
	    $logger->logError("updateOrderValue");
		$tax_incl = $order_detail->unit_price_tax_incl * $quantity;
		$tax_excl = $order_detail->unit_price_tax_excl * $quantity;
		$logger->logError("====================values");
		$logger->logError($tax_incl);
		$logger->logError($tax_excl);
		
		$excl = $this->total_paid_tax_excl - $tax_excl;
		$this->total_paid_tax_excl = $excl < 0 ? 0 :round($excl, 6);
		
		$incl = $this->total_paid_tax_incl - $tax_incl;
		$this->total_paid_tax_incl = $incl < 0 ? 0 : round($incl, 6);
		
		$logger->logError($this->total_paid_tax_excl);
		$logger->logError($this->total_paid_tax_incl);
		if($this->total_products > 0)
		{
		    $tp_excl = $this->total_products - $tax_excl;
			$this->total_products = $tp_excl < 0 ? 0 :round($tp_excl,6);
		}
		//$this->total_paid -= $tax_incl;
		if($this->total_paid != 0){
			$x = $this->total_paid - $tax_incl;
			$this->total_paid = $x < 0 ? 0 : round($x,6);
		}
		if($this->total_paid_real != 0){
		    $tplr_incl = $this->total_paid_real - $tax_incl;
			$this->total_paid_real = $tplr_incl < 0 ? 0 : round($tplr_incl,6);
		}
		$tpwt_incl = $this->total_products_wt - $tax_incl;
		$this->total_products_wt =$tpwt_incl < 0 ? 0 : round($tpwt_incl,6);
		
		$logger->logError($this->total_products);
		$logger->logError($this->total_paid);
		$logger->logError($this->total_paid_real);
		$logger->logError($this->total_products_wt);
		$logger->logError("======END=======");
		return $this->update();
	}

	public function checkDeliveredQuantity($id_order_detail,$qty)
	{
		$orderDetail = new OrderDetail($id_order_detail);
				
		$qty_list = (int)$orderDetail->product_quantity - $qty - (int)$orderDetail->product_quantity_delivered;


		if($qty_list < 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function getOrderProducts($products)
	{
		$product_array = array();
		$linkObj = new Link();
		foreach ($products as $k => $product)
		{
			$product['edt'] = 0;
			if ($this->getTaxCalculationMethod() == PS_TAX_EXC)
				$product['product_price_true'] = $product['product_price'] + $product['ecotax'];
			else
				$product['product_price_true'] = $product['product_price_wt'];

			$image = array();
		 	
		 	if (!isset($image['id_image']) OR !$image['id_image'])
				$image = Db::getInstance()->getRow('
				SELECT id_image
				FROM '._DB_PREFIX_.'image
				WHERE id_product = '.(int)($product['product_id']).' AND cover = 1');

			if (isset($image['id_image']))
			{
				$target = _PS_TMP_IMG_DIR_.'product_mini_'.(int)($product['product_id']).(isset($product['product_attribute_id']) ? '_'.(int)($product['product_attribute_id']) : '').'.jpg';
				if (file_exists($target))
					$products[$k]['image_size'] = getimagesize($target);
			}
			// Normal display
									
			$product['product_quantity_true'] = $product['product_quantity'] - ($product['product_quantity_return'] + $product['product_quantity_refunded']);
			
			if($product['product_quantity'] > ($product['product_quantity_return'] + $product['product_quantity_refunded']))
			{
				$imageObj = new Image($image['id_image']);

				if($imageObj->id != "")
				{
					$cover = Product::getCover($product['product_id']);
					$product['image_link'] = $linkObj->getImageLink($product['link_rewrite'], $product['product_id'].'-'.$cover['id_image'], 'small');
				}
				else
					$product['image_link'] = $baseDir.'img/no-image-available-small.jpg';

				array_push($product_array, $product);
			}
		}

		if(count($product_array))
			return $product_array;
	}

	public static function getCompanyOrderTotalDetails($id_relationship_manager)
	{
		$current_month = date("n");
		if($current_month == 1)
		{
			$last_month = 12;
			$last_before_month=11;
		}
		else if($current_month == 2)
		{
			$last_month = 1;
			$last_before_month=12;
		}
 		else
		{
			$last_month = $current_month - 1;
			$last_before_month = $last_month - 1;
		}
			
		
		 
		/*return Db::getInstance()->ExecuteS('SELECT id_default_group, gl.name AS company,
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 1 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Jan, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 2 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Feb, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 3 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Mar, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 4 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Apr, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 5 THEN o.total_paid_tax_incl ELSE 0 END),2) AS May, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 6 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Jun, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 7 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Jul, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 8 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Aug, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= 9 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Sep, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)=10 THEN o.total_paid_tax_incl ELSE 0 END),2) AS OCT, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)=11 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Nov, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)=12 THEN o.total_paid_tax_incl ELSE 0 END),2) AS Dec,
		ROUND(SUM(o.total_paid_tax_incl),2) AS Total
		FROM '._DB_PREFIX_.'orders AS o LEFT JOIN '._DB_PREFIX_.'customer AS c
		ON c.`id_customer` = o.id_customer
		LEFT JOIN '._DB_PREFIX_.'group_lang AS gl ON gl.`id_group` = c.`id_default_group`
		LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON oh.`id_order` = o.`id_order`
		WHERE oh.id_Order_history IN(
										SELECT  MAX(oha.`id_order_history`)
										FROM '._DB_PREFIX_.'order_history AS oha
										WHERE o.id_order = oha.id_order
										GROUP BY oha.id_order
									) 
		AND  oh.`id_order_state` IN(5,25,34,35,36,37,38,39,40,28,29 ) AND  
		c.`id_relationship_manager` = '.$id_relationship_manager.' AND o.date_add > DATE_SUB(NOW(), INTERVAL 1 YEAR)
		AND gl.`id_lang` = 1 GROUP BY id_default_group ORDER BY o.date_add DESC');*/
		$sql = 'SELECT id_default_group, gl.name AS company,
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= '.$current_month.' THEN (od.`product_quantity`-od.`product_quantity_refunded`-od.`product_quantity_return`) *od.`unit_price_tax_incl` ELSE 0 END),2) AS current_month, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= '.$last_month.' THEN (od.`product_quantity`-od.`product_quantity_refunded`-od.`product_quantity_return`) *od.`unit_price_tax_incl` ELSE 0 END),2) AS last_month, 
		ROUND(SUM(CASE WHEN MONTH(o.date_add)= '.$last_before_month.' THEN (od.`product_quantity`-od.`product_quantity_refunded`-od.`product_quantity_return`) *od.`unit_price_tax_incl` ELSE 0 END),2) AS last_before_month, 
		
		ROUND(SUM((od.`product_quantity`-od.`product_quantity_refunded`-od.`product_quantity_return`)*od.unit_price_tax_incl),2) AS Total
		FROM '._DB_PREFIX_.'orders AS o LEFT JOIN '._DB_PREFIX_.'customer AS c
		ON c.`id_customer` = o.id_customer
		LEFT JOIN '._DB_PREFIX_.'group_lang AS gl ON gl.`id_group` = c.`id_default_group`
		LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON oh.`id_order` = o.`id_order`
		LEFT JOIN `'._DB_PREFIX_.'order_detail` od ON od.`id_order` = o.`id_order`
		WHERE oh.id_Order_history IN(
										SELECT  MAX(oha.`id_order_history`)
										FROM '._DB_PREFIX_.'order_history AS oha
										WHERE o.id_order = oha.id_order
										GROUP BY oha.id_order
									) 
		AND  oh.`id_order_state` NOT IN(6,7,8,9,10,11,12,13,14,15,16,23,24,27,30,45) AND  
		c.`id_relationship_manager` = '.$id_relationship_manager.' AND o.date_add > DATE_SUB(NOW(), INTERVAL 3 Month)
		AND gl.`id_lang` = 1 GROUP BY id_default_group ORDER BY o.date_add DESC';
  		return Db::getInstance()->ExecuteS($sql);
	}

	public function isDelivered()
	{
		$products = $this->getProducts();

		foreach($products as $product)
		{
			if(((int)$product['product_quantity_delivered'] + (int)($product['product_quantity_return']) + (int)($product['product_quantity_refunded'])) != (int)$product['product_quantity'])
				return false;
		}
		return true;
	}

	public function cancelOrderedProduct($order, $order_detail, $quantity)
    {
        if (!(int)$this->getCurrentState() || !validate::isLoadedObject($order_detail)) {
            return false;
        }

        if ($this->hasBeenDelivered()) 
        {
            if (!Configuration::get('PS_ORDER_RETURN', null, null, $this->id_shop)) 
            {
                throw new PrestaShopException('PS_ORDER_RETURN is not defined in table configuration');
            }

            //$order_detail->product_quantity_return += (int)$quantity;
            $order_detail->product_quantity -= (int)$quantity;
            $order_detail->total_price_tax_incl = $order_detail->product_quantity * $order_detail->unit_price_tax_incl;
            $order_detail->total_price_tax_excl = $order_detail->product_quantity * $order_detail->unit_price_tax_excl;
            $order_detail->update();
        } 
        else
        {
            $product_quantity_bckup = $order_detail->product_quantity;
        	$product_unit_price_tax_excl_bckup = $order_detail->unit_price_tax_excl;
            //$order_detail->product_quantity_refunded += (int)$quantity;\
            $order_detail->product_quantity -= (int)$quantity;
            $order_detail->total_price_tax_incl = $order_detail->product_quantity * $order_detail->unit_price_tax_incl;
            $order_detail->total_price_tax_excl = $order_detail->product_quantity * $order_detail->unit_price_tax_excl;
            $order_detail->update();
            if($order_detail->product_quantity <= 0)
            {
            	$deleteCart = Cart::deleteCartProducts($this->id_cart, $order_detail->product_id, $order_detail->product_attribute_id);
            }
            else
            {
            	$deleteCart = Cart::removeCartProducts($this->id_cart, $order_detail->product_id, $quantity, $order_detail->product_attribute_id);
            }
        }
        if ($order_detail->product_quantity == 0) {
            if (!$order_detail->deleteItem($product_quantity_bckup, $product_unit_price_tax_excl_bckup)) {
                return false;
            }
            // $cancelled = count($this->getHistory((int)$this->id_lang, Configuration::get('PS_OS_BEING_PROCESSED')));
            // if (count($this->getProductsDetail()) == 0 && !$cancelled) {
            //     $history = new OrderHistory();
            //     $history->id_order = (int)$this->id;
            //     $history->changeIdOrderState(Configuration::get('PS_OS_BEING_PROCESSED'), $this);
            //     if (!$history->addWithemail()) {
            //         return false;
            //     }
            // }
            //return $this->update();
        }
        return true;
    }

    public function getProductsCount()
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT ( SUM(od.`product_quantity`) - ( SUM(od.`product_quantity_refunded`) + SUM(od.`product_quantity_return`) ) ) AS remainingQuantity
		FROM `'._DB_PREFIX_.'order_detail` od
		LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.id_product = od.product_id)
		LEFT JOIN `'._DB_PREFIX_.'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop)
        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON p.`id_product` = pl.`id_product` AND pl.`id_lang` = 1
		WHERE od.`id_order` = '.(int)$this->id);
    }

    public function getSupplier($select_param = null) {
    	$sql = new DbQuery();
    	
    	if($select_param) {
    		if($select_param == 'name') {
    			$sql->select('es.`name`');
    		}
    	}
    	else {
        	$sql->select('es.id_supplier');
    	}

        $sql->from('elite_supplier_orders', 'os');
        $sql->leftJoin('elite_supplier', 'es', 'os.`id_supplier` = es.`id_supplier`');
        $sql->where('os.`id_order` = '.(int)$this->id);
        
       	return Db::getInstance()->getValue($sql);
    }

    public static function addSupplier() {
		$args = func_get_args();
		if(!Db::getInstance()->getRow("SELECT id_order from `"._DB_PREFIX_."elite_supplier_orders` WHERE id_order=".$args[0]))
		{
			return Db::getInstance()->insert('elite_supplier_orders', array('id_order' => $args[0], 'id_supplier' => $args[1]));	
		}
		else{
			return true;
		}
    }

    public static function containsProduct($id_order) {
    	return Db::getInstance()->getValue('SELECT IF(od.`id_order`, true, false) AS order_id 
    		FROM `'._DB_PREFIX_.'order_detail` od 
    		WHERE od.`id_order` = '.intval($id_order).''
    	);
	}
	
	public function getAllProductsDetails(){
		$ids_query = "SELECT concat(".$this->id.",',',GROUP_CONCAT(id_order)) as ids FROM kob_split_details WHERE root=".$this->id;
		$ids = Db::getInstance()->ExecuteS($ids_query);
		$ids = $ids[0]['ids'] ? $ids[0]['ids'] : $this->id;
		$query = "SELECT ko.id_order,kod.id_order_detail,kod.product_id,kod.product_name,kod.product_quantity,
				FORMAT(kod.unit_price_tax_incl,2) as unit_price_tax_incl,
				FORMAT(kod.unit_price_tax_excl,2) as unit_price_tax_excl,
				FORMAT(kod.total_price_tax_incl,2) as total_price_tax_incl,
				(CASE WHEN ka.isez=1 THEN '0%' ELSE ktrg.name END )as gst,
				ko.estimated_delivery_time,kosl.name ,kos.color, kod.product_reference, pl.link_rewrite
				FROM `"._DB_PREFIX_."orders` ko
				LEFT JOIN `"._DB_PREFIX_."order_detail` kod ON kod.id_order=ko.id_order
				LEFT JOIN `"._DB_PREFIX_."address` ka ON ka.id_address=ko.id_address_delivery
				LEFT JOIN `"._DB_PREFIX_."product_lang` pl ON pl.id_product = kod.product_id AND pl.id_lang=1
				LEFT JOIN `"._DB_PREFIX_."product` kp ON kp.id_product = kod.product_id
				LEFT JOIN `"._DB_PREFIX_."tax_rules_group` ktrg ON ktrg.id_tax_rules_group = kp.id_tax_rules_group
				LEFT JOIN `"._DB_PREFIX_."order_history` koh ON koh.id_order=ko.id_order
				LEFT JOIN `"._DB_PREFIX_."order_state` kos ON kos.id_order_state=koh.id_order_state
				LEFT JOIN `"._DB_PREFIX_."order_state_lang` kosl ON kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
				WHERE koh.id_order_history IN(SELECT MAX(id_order_history) FROM `"._DB_PREFIX_."order_history` WHERE id_order=ko.id_order AND id_order_state not in(25))
				AND ko.id_order IN(".$ids.")
				AND kod.product_id is NOT null";
		return Db::getInstance()->ExecuteS($query);
	}
	public function getRemovedProducts(){
		$ids_query = "SELECT GROUP_CONCAT(id_order) as ids FROM kob_split_details WHERE root=".$this->id;
		$ids = Db::getInstance()->ExecuteS($ids_query);
        $ids_search = "";
		if($ids[0]['ids'] == ""){
		    $ids_search = $this->id;
		}
		else{
		   $ids_search = $ids[0]['ids']; 
		}
		$query ="SELECT bckup.product_id as id_product, kpl.name, kpl.link_rewrite, kp.reference , bckup.product_quantity, FORMAT(bckup.unit_price_tax_excl,2) as unit_price_tax_excl
			from `"._DB_PREFIX_."order_detail_bckup` bckup 
			LEFT JOIN `"._DB_PREFIX_."product` kp on kp.id_product=bckup.product_id
			LEFT JOIN `"._DB_PREFIX_."product_lang` kpl on kpl.id_product=bckup.product_id AND kpl.id_lang=1
			WHERE
			bckup.id_order IN(".$this->id.")
			AND product_id NOT IN(
				SELECT product_id FROM `"._DB_PREFIX_."order_detail` where id_order in(".$ids_search.")
				)";
		$products = Db::getInstance()->ExecuteS($query);
		if(sizeof($products) <= 0){
			return false;
		}
		else{
			return Product::getProductsProperties(1,$products);
		}
	}
	public function getDeliveryPlans(){
		$ids_query = "SELECT GROUP_CONCAT(id_order) as ids FROM kob_split_details WHERE root=".$this->id;
		$ids = Db::getInstance()->ExecuteS($ids_query);
		if($ids[0]['ids']){
			$query = "SELECT ko.id_order,kod.id_order_detail,kod.product_id,kod.product_name,kod.product_reference,kod.product_quantity,(SELECT FORMAT(SUM(total_price_tax_incl),2) FROM kob_order_detail WHERE id_order=ko.id_order)as sm,
					FORMAT(kod.unit_price_tax_excl,2) as unit_price_tax_excl,FORMAT(kod.unit_price_tax_incl,2) as unit_price_tax_incl,FORMAT(kod.total_price_tax_incl,2) as total_price_tax_incl,
					ko.estimated_delivery_time,kosl.name,kd.id_delivery,kd.dr_file_name, concat(kd.dr_prefix,LPAD(kd.delivery_number,6,0)) as delivery_number,kd.delivery_date as dr_date, koh.id_order_state, koh.date_add,kosl.name, kos.color,
					koi.number as inv_number, koi.date_add as inv_date, ko.reference, (CASE WHEN ka.isez=1 THEN '0%' ELSE ktrg.name END )as gst,ko.date_add as created
					FROM `kob_orders` ko
					LEFT JOIN `"._DB_PREFIX_."address` ka ON ka.id_address=ko.id_address_delivery
					LEFT JOIN `"._DB_PREFIX_."order_invoice` koi ON koi.id_order=ko.id_order
					LEFT JOIN `"._DB_PREFIX_."order_detail` kod ON kod.id_order=ko.id_order
					LEFT JOIN `"._DB_PREFIX_."order_history` koh ON koh.id_order=ko.id_order
					LEFT JOIN `"._DB_PREFIX_."order_state_lang` kosl ON kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
					LEFT JOIN `"._DB_PREFIX_."order_state` kos ON kos.id_order_state=koh.id_order_state
					LEFT JOIN `"._DB_PREFIX_."order_delivery` kdd on kdd.id_order=ko.id_order
					LEFT JOIN `"._DB_PREFIX_."delivery` kd on kd.id_delivery=kdd.id_delivery
					LEFT JOIN `"._DB_PREFIX_."product` kp on kp.id_product = kod.product_id
					LEFT JOIN `"._DB_PREFIX_."tax_rules_group` ktrg on ktrg.id_tax_rules_group = kp.id_tax_rules_group
					WHERE koh.id_order_history IN(SELECT MAX(id_order_history) FROM `"._DB_PREFIX_."order_history` WHERE id_order=ko.id_order AND id_order_state NOT IN(25))
					AND ko.id_order IN(".$ids[0]['ids'].")
					AND kod.product_id is NOT null
					Order BY ko.estimated_delivery_time, ko.id_order, kod.id_order_detail ASC";
			// print_r($query);

			$products = Db::getInstance()->ExecuteS($query);
			$list = array();
			$id = $products[0]['id_order'];
			$i = 0;
			$j = 0;
			$value['dr_Ack'] = [];
			foreach ($products as $key => $value) {
				if($value['dr_file_name']){
					$value['dr_Ack'] = Delivery::getDeliverySlips($value['id_order']);
				}
				if($value['id_delivery']){
				    if(glob('Invoice-ACK/'.$value['id_delivery'].'_*.*')){
						$value['inv_Ack']  = glob('Invoice-ACK/'.$value['id_delivery'].'_*.*');
					}
				}
				if($value['id_order'] != $id){
					$i++;
					$j =0;
				}
				$id = $value['id_order'];
				$list[$i][$j] = $value;
				$j++;
			}
			return $list;
		}	
		else{
			return false;
		}
	}

	public function getParentOrder(){
		$ids_query = "SELECT root FROM kob_split_details WHERE id_order=".$this->id;
		$x = Db::getInstance()->getRow($ids_query)['root'];
		return $x ? $x:$this->id;
	}
	
	public function getDeliveryPrefix(){
		$query = "SELECT kd.dr_prefix FROM `"._DB_PREFIX_."order_delivery` kod 
		                LEFT JOIN "._DB_PREFIX_."delivery kd ON kd.id_delivery=kod.id_delivery 
		                WHERE kod.id_order=".$this->id;
		return Db::getInstance()->getRow($query)['dr_prefix'];
	}
}
<?php
class RmReports extends ObjectModel
{
	/*This will return the purchases level for that current customer*/
	public static function getHistoryReport($customerid, $duration, $addressId, $from_date = false, $to_date = false)
	{
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
		$day = 1;
		$month = date("m");
		$year = date("Y");
		$currentdate = ($year."-".$month."-".$day);
		$from_date = date("Y-m-d 00:00:00", strtotime($from_date));
 		$to_date = date("Y-m-d 23:59:59", strtotime($to_date));
 		
		if($addressId !=0)
 			$add_qry = 'AND a.id_address_delivery = "'.$addressId.'"';
 		else
 			$add_qry ='';
  		if($duration == 1)
		{
			$due_query = 'AND a.date_add >= "'.$currentdate.'" -INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND a.date_add >= "'.$currentdate.'" -INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND a.date_add >= "'.$currentdate.'" -INTERVAL 1 YEAR';
		}
		else if($duration == 6)
		{
			$due_query = 'AND a.date_add  BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
		}
		else 
		{
			$due_query ='';
		}
		 
		$result = Db::getInstance()->ExecuteS('SELECT ROUND(sum(a.total_paid_tax_incl),2) as y, ROUND(sum(a.total_paid_tax_incl),2) as indexLabel, monthname(a.date_add) AS label
															  FROM '._DB_PREFIX_.'orders AS a  
															  LEFT JOIN '._DB_PREFIX_.'order_history AS b ON a.id_order = b.id_order 
															   
															  WHERE  b.id_Order_history IN (
																	SELECT  MAX(oha.`id_order_history`)
																	FROM '._DB_PREFIX_.'order_history AS oha
																	WHERE a.id_order = oha.id_order
																	GROUP BY oha.id_order) 
															AND  b.`id_order_state` IN(5,25,34,35,36,37,38,39,40 ) '.$add_qry.' AND a.`id_customer` IN('.$str.') '.$due_query.' GROUP BY label ORDER BY a.date_add ASC ');
		
 
		return $result;
	}
	
	/*This will return the parent category with purchases for that current customer*/
	public static function getRatioHistoryReport($customerid, $orderid,$duration, $addressId,$selected_category=NULL,$from_date = false, $to_date = false)
	{	
		$from_date = date("Y-m-d 00:00:00", strtotime($from_date));
 		$to_date = date("Y-m-d 23:59:59", strtotime($to_date));

 		if($addressId !=0)
 			$add_qry = 'AND orders.id_address_delivery = "'.$addressId.'"';
 		else
 			$add_qry ='';
		
		if($duration == 1)
		{
			$due_query = 'AND orders.date_add >= NOW()-INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND orders.date_add >= NOW()-INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND orders.date_add >= NOW()-INTERVAL 1 YEAR';
		}
		else if($duration == 6)
		{
			$due_query = 'AND orders.date_add BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
		}
		else 
		{
			$due_query ='';
		}
  		if($orderid == 1 || $orderid ==0 )
		{
			$ord_query = '';
		}
		else
		{
			$ord_query='And orders.`id_order`= "'.$orderid.'"';
		}
		if($selected_category !="")
		{
			/*qry_top_10_product*/
			$select_qry ='count(detail.product_id) as total, pro_lang.name as indexLabel , sum(detail.product_quantity - detail.product_quantity_return - detail.product_quantity_refunded)as qty, ROUND(sum(detail.unit_price_tax_excl + (detail.unit_price_tax_excl*t.rate/100)),2) as y, ROUND(detail.unit_price_tax_incl,2) ';
			
			$where_qry ='AND parent.id_category ='.$selected_category.' '.$due_query.' group by product.id_product order by y desc limit 10';
		}
		else{
			/*$category_report*/
			$select_qry ='ROUND(SUM((detail.`product_quantity`-product_quantity_refunded - product_quantity_return)*((detail.unit_price_tax_excl*tax_rate /100)+ detail.unit_price_tax_incl)),2) AS y, cat_lang.`name` AS indexLabel  ,parent.id_category ';
			$where_qry=''.$add_qry.''.$ord_query.''.$due_query.' GROUP BY parent.id_category ORDER BY y DESC';
		}
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
		 

 		$result = Db::getInstance()->ExecuteS('SELECT '.$select_qry.' 
												FROM '._DB_PREFIX_.'orders orders, '._DB_PREFIX_.'order_detail detail, '._DB_PREFIX_.'product product, '._DB_PREFIX_.'order_history history,
												'._DB_PREFIX_.'category node, '._DB_PREFIX_.'category parent, '._DB_PREFIX_.'category_lang cat_lang,'._DB_PREFIX_.'product_lang pro_lang, '._DB_PREFIX_.'order_detail_tax as odt,'._DB_PREFIX_.'tax as t
												WHERE   id_customer IN('.$str.')
												AND		orders.`id_order` = detail.id_order
												AND		product.`id_product` = detail.`product_id`
												AND		product.`id_product` = pro_lang.`id_product`
												AND		product.`id_category_default` = node.`id_category`
												AND		node.nleft BETWEEN parent.nleft AND parent.nright
												AND 	parent.level_depth=2
												AND 	parent.id_category = cat_lang.`id_category`
												AND     cat_lang.`id_lang`= 1												
												AND     pro_lang.`id_lang`= 1
												AND 	orders.`id_order`= history.`id_order`
												AND 	detail.id_order_detail = odt.id_order_detail
												AND		odt.id_tax = t.id_tax
												AND 	history.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																WHERE orders.id_order = oha.id_order
																GROUP BY oha.id_order)
												AND 	history.`id_order_state` IN (5,25,34,35,36,37,38,39,40 ) 
												'.$where_qry.'');
		
		 

 		return $result;
	}

	public static function getTopOrderValueProducts($customerid,$duration, $addressId, $from_date = NULL, $to_date = NULL)
	{
		$from_date = date("Y-m-d 00:00:00", strtotime($from_date));
 		$to_date = date("Y-m-d 23:59:59", strtotime($to_date));

		if($addressId !=0)
 			$add_qry = 'AND o.id_address_delivery = "'.$addressId.'"';
 		else
 			$add_qry ='';
			
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
		else if($duration == 6){
			$due_query = 'AND o.date_add BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
		}
		else 
		{
			$due_query ='';
		}

		

		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();	
		
		 
		
		$result = Db::getInstance()->ExecuteS('SELECT   ROUND(SUM(((od.product_quantity - product_quantity_refunded - product_quantity_return) * od.unit_price_tax_incl)),2) AS y, pl.name AS name, pl.id_product,pl.`link_rewrite`,   p.quantity,p.out_of_stock,p.id_category_default
												FROM '._DB_PREFIX_.'order_detail AS od
												JOIN '._DB_PREFIX_.'orders o
												ON o.id_order= od.id_order
												JOIN '._DB_PREFIX_.'product_lang pl
												ON pl.id_product = od.product_id
												
												JOIN '._DB_PREFIX_.'order_detail_tax odt ON od.id_order_detail = odt.id_order_detail
												JOIN '._DB_PREFIX_.'tax t on odt.id_tax = t.id_tax
												
												JOIN '._DB_PREFIX_.'order_history oh
												ON o.id_order= oh.id_order
												JOIN '._DB_PREFIX_.'product p
												ON p.id_product= pl.id_product
												WHERE o.id_customer IN('.$str.') AND p.discontinued = 0  AND p.active = 1 AND oh.id_Order_history IN (
																		SELECT  MAX(oha.`id_order_history`)
																		FROM kob_order_history AS oha
																		WHERE o.id_order = oha.id_order
																		GROUP BY oha.id_order) 
												AND oh.id_order_state IN (5,25,34,35,36,37,38,39,40 ) '.$add_qry.' AND pl.id_lang=1 '.$due_query.' GROUP BY od.product_id ORDER BY y DESC LIMIT 10');	
	return $result;
	}
	
	public static function getLocationBasedReport($customerid,$duration,$from_date,$to_date)
	{
		$from_date = date("Y-m-d 00:00:00", strtotime($from_date));
 		$to_date = date("Y-m-d 23:59:59", strtotime($to_date));
 		
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
		else if($duration == 6){
			$due_query = 'AND o.date_add BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
		}
		else 
		{
			$due_query ='';
		}
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
		 

		return Db::getInstance()->ExecuteS('SELECT ROUND(SUM(o.total_paid_tax_incl),2) AS y, o.`id_address_delivery`, a.`alias` AS indexLabel
											FROM '._DB_PREFIX_.'orders o
											LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
											ON o.`id_order` = oh.`id_order`
											LEFT JOIN '._DB_PREFIX_.'address AS a
											ON o.`id_address_delivery` = a.`id_address`
											
											 
											WHERE o.id_customer IN('.$str.') AND oh.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																 where o.id_order = oha.id_order
																GROUP BY oha.id_order)
												AND oh.`id_order_state` IN ( 5,25,34,35,36,37,38,39,40 ) '.$due_query.' GROUP BY o.`id_address_delivery` ORDER BY Y DESC');
	}
}
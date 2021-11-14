<?php 
class FinanceCore extends ObjectModel
{
	public static function releaseOrders($orders, $id_employee){

		$sql = "UPDATE "._DB_PREFIX_."orders ko set release_order=1 where id_order IN(".implode(',',$orders).")";
		$result =  Db::getInstance()->Execute($sql);
		if($result){
			$employee = new Employee($id_employee);
			foreach($orders as $order){

				$sql = "INSERT into "._DB_PREFIX_."order_release values(".$order.",".$id_employee.",'".date('Y-m-d h:i:s')."')";
				$insert =  Db::getInstance()->Execute($sql);
			}

			$data = array(
				'{orders}' => implode(',',$orders),
				'{employee}' => $employee->firstname,
				);
			$template = "order_release_info";
			$subject = "Order Hold Released Details";
			$to = array(
					'karthik@kobster.com',
					'vineet.neeraj@kobster.com',
					'mohan.g@kobster.com',
					'pramoth.k@kobster.com',
					'lingakani.g@kobster.com',
					'narayan.s@kobster.com',
					'irthu.suresh@kobster.com'
					);
			Mail::Send(1, $template, $subject, $data, $to, null,"noreply@kobster.com","Order Hold Released Details");
		}
		return $result;
	}

	public static function getAllCustomerOrders($id_group){        
        // $logger = new FileLogger();
        // $logger->setFilename("test.txt");
        // $logger->logError("check");
		$last_date = "SELECT DATE_ADD(MIN(koi.date_add), INTERVAL (ko.credit_days+15) DAY) as last_date 
								FROM "._DB_PREFIX_."customer kc 
								LEFT JOIN "._DB_PREFIX_."orders ko on ko.id_customer=kc.id_customer
								LEFT JOIN "._DB_PREFIX_."order_invoice koi on koi.id_order=ko.id_order
								LEFT join "._DB_PREFIX_."order_history koha on koha.id_order = ko.id_order
							    LEFT join "._DB_PREFIX_."order_history kohb on kohb.id_order = koha.id_order
							    WHERE koha.id_order in(select id_order from "._DB_PREFIX_."order_history oh where oh.id_order=ko.id_order and oh.id_order_state=40)
									AND kohb.id_order_history in( select max(id_order_history) from "._DB_PREFIX_."order_history ohb where ohb.id_order=koha.id_order)
									AND kohb.id_order_state NOT IN(6,7,38,36)
									AND koi.deny_alerts = 0
								    AND ko.invoice_number!=0
                                    AND kc.id_default_group =".$id_group."";
        $res = Db::getInstance()->ExecuteS($last_date);
        // $logger->logError($last_date);
        // $logger->logError($res);
        $sql = "SELECT kc.email,ko.id_order,ko.date_add,ko.release_order,kosl.name FROM "._DB_PREFIX_."customer kc 
					LEFT JOIN "._DB_PREFIX_."orders ko on ko.id_customer=kc.id_customer
					LEFT JOIN "._DB_PREFIX_."order_history koh on koh.id_order=ko.id_order	
					LEFT JOIN "._DB_PREFIX_."order_state_lang kosl on kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
					WHERE koh.id_order_history in(SELECT max(id_order_history) FROM "._DB_PREFIX_."order_history where id_order=ko.id_order)
					AND koh.id_order_state NOT IN(6,7,38)
					AND kc.id_default_group=".$id_group."
					AND ko.date_add > '".$res[0]['last_date']."'";
		// $logger->logError($sql);
		return Db::getInstance()->ExecuteS($sql);
	}
	
	public function getFinanceHistoryReport($duration,$fromdate = NULL, $todate = NULL)
	{
 		
 		$fromdate = date("Y-m-d", strtotime($fromdate));
 		$todate = date("Y-m-d", strtotime($todate));
 		if($duration == 1)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 1 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 3 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 1 YEAR';
		}
		else if($duration == 4)
		{
			$due_query = '';
		}
		else if($duration ==5 )
		{
			$due_query = 'AND o.date_add  BETWEEN "'.$fromdate.'" AND "'.$todate.'"';
		}		
		//SELECT sum(a.total_products) as y, sum(a.total_products) as indexLabel, monthname(a.date_add) AS label

 		return Db::getInstance()->ExecuteS('SELECT o.id_order as label, sum(o.total_paid) as y
											FROM '._DB_PREFIX_.'orders o
											left join '._DB_PREFIX_.'order_history oh
											on o.id_order = oh.id_order
											where oh.id_Order_history IN (
											SELECT  MAX(oha.`id_order_history`) FROM '._DB_PREFIX_.'order_history AS oha
											where o.id_order = oha.id_order GROUP BY oha.id_order
											) AND 
											 oh.id_order_state NOT IN (6,7)'.$due_query.' GROUP BY o.date_add');
	}


 															
	public static function getIndexFinanceValue($id_page = NULL)
	{
 		$select_query='';
		$join_query ='';
		$where_query = '';
		if($id_page != NULL)
		{
			$select_query = ',c.firstname, ol.name, o.total_paid as total';
			$join_query = 'Left join '._DB_PREFIX_.'customer c on o.id_customer = c.id_customer LEFT JOIN '._DB_PREFIX_.'order_state_lang ol on oh.id_order_state = ol.id_order_state';
			$where_query= 'ol.id_lang = 1 and';
			$group_query =' order by o.id_order desc';
		}
		else
		{
			$select_query=',CONCAT("&#8377; ",FORMAT(SUM(o.total_paid), 2)) AS total';
			$group_query =' group by state';
		}
		 
		$order_pending_value =  Db::getInstance()->ExecuteS('SELECT ol.`name` ,DATEDIFF(DATE_ADD(oh.`date_add`,INTERVAL o.`credit_days` DAY),NOW()) AS bill_age,o.credit_days, oh.id_order_state as state '.$select_query.'
										FROM '._DB_PREFIX_.'orders o
										left join '._DB_PREFIX_.'order_history oh
										on o.id_order = oh.id_order
										'.$join_query.'
										LEFT JOIN `kob_order_state_lang` ol ON(ol.`id_order_state`=oh.`id_order_state`)
										where '.$where_query.'  oh.id_Order_history IN (
																	SELECT  MAX(oha.`id_order_history`) FROM '._DB_PREFIX_.'order_history AS oha
																	where o.id_order = oha.id_order GROUP BY oha.id_order
																	) 
										AND ol.`id_lang`=1
										AND oh.id_order_state IN (37,35,39) '.$group_query.'');

 		if($id_page == NULL)
		{		
 			$current_month_order_complete_value = Db::getInstance()->ExecuteS('SELECT CONCAT("&#8377; ",FORMAT(SUM(c.`unit_price_tax_excl`*c.`product_quantity`), 2))  AS total_value,DATE_FORMAT(a.invoice_date, "%m-%Y") AS date_month,DATE_FORMAT(a.`invoice_date`, "%M-%Y") AS month
				FROM kob_orders a
				LEFT JOIN `kob_order_detail` c ON(a.id_order=c.`id_order`)
				LEFT JOIN kob_order_detail_tax AS od ON(od.id_order_detail=c.`id_order_detail`)
				LEFT JOIN kob_order_cart_rule e ON(e.`id_order`=a.`id_order`)
				WHERE DATE_FORMAT(a.invoice_date, "%m-%Y")!="00-0000" 
				GROUP BY DATE_FORMAT(a.invoice_date, "%m-%Y") 
				ORDER BY DATE_FORMAT(a.invoice_date, "%Y-%m") ASC');

			$order_limit = 10;
			$finance_procurement_plan = Finance::financeProcurementPlan(true);
			$result=array();
			$result[] = array_push($result,$order_pending_value,$current_month_order_complete_value,$finance_procurement_plan);
		}
		else
			$result= $order_pending_value;
		return $result;

	}
	public static function getMonthlyPurchaseBillTotal()
	{
		$sql="SELECT DATE_FORMAT(vpb.bill_date,'%M-%Y') AS month,DATE_FORMAT(vpb.bill_date,'%m-%Y') AS month_year,CONCAT('&#8377; ', FORMAT(SUM(`product_qty`* `unit_price`), 2)) AS total_value
				FROM `"._DB_PREFIX_."vendor_purchase_bill`  AS vpb
				LEFT JOIN `"._DB_PREFIX_."vendor` AS v
				ON v.`id_vendor` = vpb.`id_vendor`
				WHERE vpb.`active`=1 
				GROUP BY DATE_FORMAT(vpb.bill_date, '%m-%Y') ORDER BY DATE_FORMAT(vpb.bill_date, '%Y-%m') ASC";
		return Db::getInstance()->ExecuteS($sql);
	}
	public static function financeProcurementPlan($order_limit = Null)
	{
		if($order_limit !="")
			$order_limit = 'Limit 10';
		else
			$order_limit = '';
		return Db::getInstance()->ExecuteS('SELECT o.`id_order`, c.firstname,format(o.`total_paid`,2) as total_paid,o.`id_fc`, fc.city_name
																FROM `'._DB_PREFIX_.'orders` as o
																LEFT JOIN '._DB_PREFIX_.'customer as c on o.id_customer = c.id_customer 
																LEFT JOIN '._DB_PREFIX_.'fulfillment_centre as fc on fc.id_fulfillment_centre = o.id_fc
																LEFT JOIN '._DB_PREFIX_.'order_detail as od on o.id_customer = od.id_order
																LEFT JOIN '._DB_PREFIX_.'order_history AS oh ON o.id_order = oh.id_order
																where  	
																oh.id_Order_history IN (SELECT  MAX(oha.`id_order_history`)
																								FROM '._DB_PREFIX_.'order_history AS oha
																								WHERE o.id_order = oha.id_order
																								GROUP BY oha.id_order) 
																						AND  oh.`id_order_state` IN(18,19,21,22,24)GROUP BY o.id_order ORDER BY o.id_order DESC '.$order_limit.'');
	}

	public static function financePaymentPending($id_group=NULL,$from=NULL,$to=NULL)
	{
			$sql='SELECT g.`id_group`,gl.`name`,(SELECT oha.`date_add` FROM '._DB_PREFIX_.'order_history oha WHERE  o.`id_order` = oha.`id_order` AND oha.`id_order_state`=25 limit 1) as date_add,o.`id_order`,o.`invoice_number`,FORMAT(o.`total_paid`,2) AS total_paid,osl.`name` AS order_status,o.`credit_days`,DATEDIFF(DATE_ADD((SELECT oha.`date_add` FROM '._DB_PREFIX_.'order_history oha WHERE  o.`id_order` = oha.`id_order` AND oha.`id_order_state`=25 limit 1) ,INTERVAL o.`credit_days` DAY),NOW()) AS aging
				FROM '._DB_PREFIX_.'orders o
				LEFT JOIN '._DB_PREFIX_.'order_history oh ON (o.`id_order` = oh.`id_order`)
				LEFT JOIN '._DB_PREFIX_.'order_state_lang osl ON (osl.`id_order_state` = oh.`id_order_state`)
				LEFT JOIN '._DB_PREFIX_.'customer c ON(c.`id_customer` = o.`id_customer`)
				LEFT JOIN '._DB_PREFIX_.'group g ON(g.`id_group`=c.`id_default_group`)
				LEFT JOIN '._DB_PREFIX_.'group_lang gl ON(gl.`id_group`=g.`id_group`)	
				WHERE 
				oh.id_Order_history IN (
				SELECT  MAX(oha.`id_order_history`) FROM '._DB_PREFIX_.'order_history AS oha
				WHERE o.id_order = oha.id_order GROUP BY oha.id_order
				)
				AND oh.`id_order_state` IN (35,37,39)
				AND gl.`id_lang`=1
				AND osl.`id_lang`=1';
		if($id_group)		
		{
			$sql .=" AND g.`id_group`=".$id_group;
		}
		if($from & $to)		
		{
			$to.=" 23:59:59";
			$sql .=" AND oh.`date_add` BETWEEN '".$from."' AND '".$to."'";
		}	
		$result=Db::getInstance()->ExecuteS($sql);	
		return $result;
	}
	public static function agingData()
	{
		$sql="SELECT g.`id_group`,gl.`name`,
				ROUND(SUM(CASE WHEN DATEDIFF(NOW(),oh.`date_add`)<30 THEN o.`total_paid` ELSE 0 END),2) AS '0-30',
				ROUND(SUM(CASE WHEN DATEDIFF(NOW(),oh.`date_add`)>=30 AND DATEDIFF(NOW(),oh.`date_add`)<60 THEN o.`total_paid` ELSE 0 END),2) AS '30-60',
				ROUND(SUM(CASE WHEN DATEDIFF(NOW(),oh.`date_add`)>=60 AND DATEDIFF(NOW(),oh.`date_add`)<90 THEN o.`total_paid` ELSE 0 END),2) AS '60-90',
				ROUND(SUM(CASE WHEN DATEDIFF(NOW(),oh.`date_add`)>=90 THEN o.`total_paid` ELSE 0 END),2) AS '90+',
				ROUND(SUM(CASE WHEN DATEDIFF(NOW(),oh.`date_add`)>=0 THEN o.`total_paid` ELSE 0 END),2) AS 'Total'
				FROM "._DB_PREFIX_."orders o
				LEFT JOIN "._DB_PREFIX_."order_history oh ON (o.`id_order` = oh.`id_order`)
				LEFT JOIN "._DB_PREFIX_."customer c ON(c.`id_customer` = o.`id_customer`)
				LEFT JOIN "._DB_PREFIX_."group g ON(g.`id_group`=c.`id_default_group`)
				LEFT JOIN "._DB_PREFIX_."group_lang gl ON(gl.`id_group`=g.`id_group`)	
				WHERE 
				oh.id_Order_history IN (
				SELECT  MAX(oha.`id_order_history`) FROM "._DB_PREFIX_."order_history AS oha
				WHERE o.id_order = oha.id_order GROUP BY oha.id_order
				)
				and oh.`id_order_state` IN (35)
				AND gl.`id_lang`=1
				GROUP BY g.`id_group`";

		$result=Db::getInstance()->ExecuteS($sql);	
		return $result;

	}
}
?>

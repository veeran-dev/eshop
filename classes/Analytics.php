 <?php

class AnalyticsCore
{
	public static function topLineRevenue(){

		$query = "SELECT  MONTHNAME(ord.date_add) as mon, CONCAT(MONTH(ord.date_add),'-',YEAR(ord.date_add)) as mon_yr, SUM(ord.total_paid_tax_incl) as revenue
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND DATE(ord.date_add) BETWEEN CONCAT(YEAR(NOW() - INTERVAL 1 MONTH), '-', MONTH(NOW() - INTERVAL 1 MONTH),'-1') AND LAST_DAY(NOW())
					GROUP BY mon_yr";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function fcWiseRevenue(){
		
		$query = "SELECT  UPPER(LEFT(fc.city_name,3)) as fc_name, SUM(ord.total_paid_tax_incl) as revenue
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_fulfillment_centre` as fc
					ON ords.id_fc = fc.id_fulfillment_centre
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND MONTH(ord.date_add) = MONTH(CURRENT_DATE)
					AND YEAR(ord.date_add) = YEAR(CURRENT_DATE)
					GROUP BY fc_name";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function rmWiseRevenue(){
		
		$query = "SELECT CASE WHEN emp.firstname IS NULL THEN 'Others' ELSE emp.firstname END AS firstname, sum(ord.total_paid_tax_incl) AS rm_revenue
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_customer` as cust
					ON ords.id_customer = cust.id_customer
					LEFT JOIN `kob_group` as grp
					ON cust.id_default_group = grp.id_group
					LEFT JOIN `kob_employee` as emp
					ON grp.id_relationship_manager = emp.id_employee and emp.id_lang = 1
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND MONTH(ord.date_add) = MONTH(CURRENT_DATE)
					AND YEAR(ord.date_add) = YEAR(CURRENT_DATE)
					GROUP by emp.firstname";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function kamWiseRevenue(){
		
		$query = "SELECT CASE WHEN emp.firstname IS NULL THEN 'Others' ELSE emp.firstname END AS firstname, sum(ord.total_paid_tax_incl) AS kam_revenue
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_customer` as cust
					ON ords.id_customer = cust.id_customer
					LEFT JOIN `kob_group` as grp
					ON cust.id_default_group = grp.id_group
					LEFT JOIN `kob_employee` as emp
					ON grp.id_kam = emp.id_employee and emp.id_lang = 1
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND MONTH(ord.date_add) = MONTH(CURRENT_DATE)
					AND YEAR(ord.date_add) = YEAR(CURRENT_DATE)
					GROUP by emp.firstname";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function categoryWiseRevenue(){
		
		$query = "SELECT LEFT(IF(c5.level_depth = 2,cl5.name,IF(c4.level_depth=2, cl4.name, IF(c3.level_depth=2, cl3.name, IF(c2.level_depth=2, cl2.name, IF(c1.level_depth=2, cl1.name, ''))))),10) as cat_name,SUM(ord_det.total_price_tax_incl) as total_sales
						FROM `kob_order_invoice` ord
						LEFT JOIN kob_order_history ord_hist_1
						ON ord.id_order = ord_hist_1.id_order
						LEFT JOIN `kob_orders` as ords
						ON ord.id_order = ords.id_order
						LEFT JOIN `kob_order_detail` as ord_det
						ON ords.id_order = ord_det.id_order
						LEFT JOIN `kob_product` prod
						ON ord_det.product_id = prod.id_product
						LEFT JOIN `kob_manufacturer` man
						            ON prod.id_manufacturer=man.id_manufacturer
						            LEFT JOIN `kob_category` c1
						            ON c1.id_category = prod.id_category_default
						            LEFT JOIN `kob_category` c2
						            ON c2.id_category = c1.id_parent
						            LEFT JOIN `kob_category` c3
						            ON c3.id_category = c2.id_parent
						            LEFT JOIN `kob_category` c4
						            ON c4.id_category = c3.id_parent
						            LEFT JOIN `kob_category` c5
						            ON c5.id_category = c4.id_parent
						            LEFT JOIN `kob_category_lang` cl1
						            ON c1.id_category = cl1.id_category and cl1.id_lang=1
						            LEFT JOIN `kob_category_lang` cl2
						            ON c2.id_category = cl2.id_category and cl2.id_lang=1
						            LEFT JOIN `kob_category_lang` cl3
						            ON c3.id_category = cl3.id_category and cl3.id_lang=1
						            LEFT JOIN `kob_category_lang` cl4
						            ON c4.id_category = cl4.id_category and cl4.id_lang=1
						            LEFT JOIN `kob_category_lang` cl5
						            ON c5.id_category = cl5.id_category and cl5.id_lang=1
						WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
						                 FROM kob_order_history ord_hist_2
						                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
						AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
						AND MONTH(ord.date_add) = MONTH(CURRENT_DATE)
						AND YEAR(ord.date_add) = YEAR(CURRENT_DATE)
						GROUP BY cat_name
						ORDER BY total_sales DESC
						LIMIT 4";

		return Db::getInstance()->ExecuteS($query);
	}


	public static function topCustomerRevenue(){
		
		$query = "SELECT LEFT(gl.name, 10) as name, SUM(ord.total_paid_tax_incl) as total_sales
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_customer` as cust
					ON ords.id_customer = cust.id_customer
					LEFT JOIN `kob_group` as grp
					ON cust.id_default_group = grp.id_group
					LEFT JOIN `kob_group_lang` gl
					ON grp.id_group = gl.id_group AND gl.id_lang = 1
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					             FROM kob_order_history ord_hist_2
					             WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND MONTH(ord.date_add) = MONTH(CURRENT_DATE)
					AND YEAR(ord.date_add) = YEAR(CURRENT_DATE)
					GROUP BY gl.name
					ORDER BY total_sales desc
					LIMIT 5";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function annualRevenueTarget(){
		
		$query = "SELECT FORMAT(SUM((ord.total_paid_tax_incl - ord.total_discount_tax_incl)),0,'en_IN') as achieved, FORMAT('80000000',0,'en_IN') as target
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND ord.date_add BETWEEN '2017-04-01' AND CURRENT_DATE";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function activeCompaniesCount(){
		
		$query = "SELECT count(company_name) as companies_count FROM
					(SELECT gl.name as company_name, MAX(ord.date_add) as latest_order
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_customer` as cust
					ON ords.id_customer = cust.id_customer
					LEFT JOIN `kob_group` as grp
					ON cust.id_default_group = grp.id_group
					LEFT JOIN `kob_group_lang` gl
					ON grp.id_group = gl.id_group AND gl.id_lang = 1
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					             FROM kob_order_history ord_hist_2
					             WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					GROUP BY gl.name) AS company_latest_order
					WHERE CAST(latest_order AS DATE) BETWEEN (CURRENT_DATE - INTERVAL 6 MONTH) and CURRENT_DATE";


		return Db::getInstance()->ExecuteS($query);
	}

	public static function activeUsersCount(){
		
		$query = "SELECT count(id_customer) as user_count FROM
					(SELECT ords.id_customer, MAX(ord.date_add) as latest_order
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_customer` as cust
					ON ords.id_customer = cust.id_customer
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					GROUP BY ords.id_customer) AS user_latest_order
					WHERE CAST(latest_order AS DATE) BETWEEN (CURRENT_DATE - INTERVAL 6 MONTH) and CURRENT_DATE";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function newCustomers(){
		
		$query = "SELECT count(company_name) as new_customer FROM
					(SELECT gl.name as company_name, MIN(ord.date_add) as first_order
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_customer` as cust
					ON ords.id_customer = cust.id_customer
					LEFT JOIN `kob_group` as grp
					ON cust.id_default_group = grp.id_group
					LEFT JOIN `kob_group_lang` gl
					ON grp.id_group = gl.id_group AND gl.id_lang = 1
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					GROUP BY gl.name) AS company_first_order
					WHERE MONTH(first_order) = MONTH(CURRENT_DATE)
					AND YEAR(first_order) = YEAR(CURRENT_DATE)";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function averageAdt(){
		
		$query = "SELECT (CASE WHEN ROUND(AVG(time_to_sec(timediff(order_delivered.date_add, order_placed.date_add)) / 3600), 2) IS NULL THEN '00' ELSE ROUND(AVG(time_to_sec(timediff(order_delivered.date_add, order_placed.date_add)) / 3600), 2) END )AS adt_hours
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN kob_order_history as order_placed
					ON ords.id_order = order_placed.id_order and order_placed.id_order_state = 22
					LEFT JOIN kob_order_history as order_delivered
					ON ords.id_order = order_delivered.id_order and order_delivered.id_order_state = 5
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					             FROM kob_order_history ord_hist_2
					             WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND MONTH(ord.date_add) = MONTH(CURRENT_DATE)
					AND YEAR(ord.date_add) = YEAR(CURRENT_DATE)";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function fcWiseAverageAdt(){
		
		$query = "SELECT fc.city_name, CASE WHEN adt_result.adt_hours IS NULL THEN '00' ELSE adt_result.adt_hours END AS adt_hours FROM  `kob_fulfillment_centre` fc 
LEFT JOIN(SELECT fc.city_name AS fc_name, ROUND(AVG(ROUND(time_to_sec(timediff(order_delivered.date_add, order_placed.date_add)) / 3600, 2)),2) as adt_hours
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					LEFT JOIN `kob_fulfillment_centre` as fc
					ON ords.id_fc = fc.id_fulfillment_centre
					LEFT JOIN kob_order_history as order_placed
					ON ords.id_order = order_placed.id_order and order_placed.id_order_state = 22
					LEFT JOIN kob_order_history as order_delivered
					ON ords.id_order = order_delivered.id_order and order_delivered.id_order_state = 5
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (5,25,35,36,38,39,40)
					AND MONTH(ord.date_add) = MONTH(CURRENT_DATE)
					AND YEAR(ord.date_add) = YEAR(CURRENT_DATE)
					GROUP BY fc.city_name) as adt_result on adt_result.fc_name = fc.city_name";

		return Db::getInstance()->ExecuteS($query);
	}
	public static function ordersPendingWithOps(){
		
		$query = "SELECT count(*) as pending_ops
			FROM `kob_orders` ord
			LEFT JOIN kob_order_history ord_hist_1	ON ord.id_order = ord_hist_1.id_order
			WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
			                 FROM kob_order_history ord_hist_2
			                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
			AND ord_hist_1.id_order_state IN (4,5,19,22,24,25,33,37,39)
			AND CAST(ord.date_add AS DATE) BETWEEN (CURRENT_DATE - INTERVAL 6 MONTH) and CURRENT_DATE";		
		return Db::getInstance()->ExecuteS($query);
	}

	public static function ordersPendingWithCategory(){
		
		$query = "SELECT count(*) as pending_cat
			FROM `kob_orders` ord
			LEFT JOIN kob_order_history ord_hist_1 ON ord.id_order = ord_hist_1.id_order
			WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
			                 FROM kob_order_history ord_hist_2
			                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
			AND ord_hist_1.id_order_state IN (46)
			AND CAST(ord.date_add AS DATE) BETWEEN (CURRENT_DATE - INTERVAL 6 MONTH) and CURRENT_DATE";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function ordersPendingWithFinance(){
		
		$query = "SELECT count(*) as pending_finance
			FROM `kob_orders` ord
			LEFT JOIN kob_order_history ord_hist_1 ON ord.id_order = ord_hist_1.id_order
			WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
			             FROM kob_order_history ord_hist_2
			             WHERE ord_hist_2.id_order = ord_hist_1.id_order)
			AND ord_hist_1.id_order_state IN (50,36)
			AND CAST(ord.date_add AS DATE) BETWEEN (CURRENT_DATE - INTERVAL 6 MONTH) and CURRENT_DATE";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function ordersPendingWithRm(){
		
		$query = "SELECT count(*) as pending_rm
				FROM `kob_orders` as ords
				LEFT JOIN kob_order_history ord_hist_1 ON ords.id_order = ord_hist_1.id_order
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
									 FROM kob_order_history ord_hist_2
									 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (23,26,29,32,41,42)
					AND CAST(ords.date_add AS DATE) BETWEEN (CURRENT_DATE - INTERVAL 6 MONTH) and CURRENT_DATE";

		return Db::getInstance()->ExecuteS($query);
	}
	
	public static function activeProducts(){
		
		$query = "SELECT count(*) as active_products FROM `kob_product` where active=1 and hsn_code is not NULL and available_for_order=1 and discontinued=0";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function totalBrands(){
		
		$query = "SELECT count(DISTINCT id_manufacturer) as total_brands FROM `kob_product` where active=1 and hsn_code is not NULL and available_for_order=1 and discontinued=0
";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function totalOosProducts(){
		
		$query = "SELECT count(*) total_oos FROM `kob_product` prod, `kob_stock_available` stk where active=1 and hsn_code is not NULL and available_for_order=1 and discontinued=0 and prod.id_product = stk.id_product and stk.out_of_stock = 0
";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function totalVendors(){
		
		$query = "SELECT count(*) as total_vendors FROM `kob_vendor` where active=1";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function currentVendors(){ // vendors who did atleast one transaction
		
		$query = "SELECT count(distinct id_vendor) as current_vendors FROM `kob_vendor_purchase_bill` WHERE MONTH(date_add) = MONTH(CURRENT_DATE) and YEAR(date_add) = YEAR(CURRENT_DATE)";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function newVendors(){ // vendors added recently
		
		$query = "SELECT count(distinct id_vendor) as new_vendors FROM `kob_vendor` WHERE MONTH(date_update) = MONTH(CURRENT_DATE) and YEAR(date_update) = YEAR(CURRENT_DATE)
";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function averageCollectionPeriod(){ // DSO - average (credit) days taken by company to collect the invoice amount
		
		$query ="SELECT round(AVG(DATEDIFF(pay_rec.date_add, inv_sub.date_add)),2) as dso 
                    FROM `kob_order_invoice` ord 
                    LEFT JOIN kob_order_history ord_hist_1 
                    ON ord.id_order =ord_hist_1.id_order 
                    LEFT JOIN `kob_orders` as ords 
                    ON ord.id_order = ords.id_order 
                    LEFT JOIN `kob_order_history` as inv_sub 
                    ON ords.id_order = inv_sub.id_order AND inv_sub.id_order_state = 5 
                    LEFT JOIN `kob_order_history` as pay_rec ON ords.id_order = pay_rec.id_order and pay_rec.id_order_state= 36 
                    WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history) 
                                                         FROM kob_order_history ord_hist_2 
                                                         WHERE ord_hist_2.id_order =ord_hist_1.id_order) 
                    AND ord_hist_1.id_order_state IN (36,38) 
                    AND ord.date_add BETWEEN '2017-04-01' AND CURRENT_DATE 
                    AND inv_sub.date_add IS NOT NULL
                    AND pay_rec.date_add IS NOT NULL
                    AND DATEDIFF(pay_rec.date_add, inv_sub.date_add) > 10";
		$queryOld = "SELECT round(AVG(DATEDIFF(pay_rec.date_add, inv_sub.date_add)),2) as dso
					FROM `kob_order_invoice` ord 
					LEFT JOIN kob_order_history ord_hist_1 ON ord.id_order =ord_hist_1.id_order 
					LEFT JOIN `kob_orders` as ords ON ord.id_order = ords.id_order 
					LEFT JOIN kob_order_history as inv_sub ON ords.id_order =inv_sub.id_order and inv_sub.id_order_state = 5 
					LEFT JOIN kob_order_history as pay_rec ON ords.id_order = pay_rec.id_order and pay_rec.id_order_state= 36 
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history) FROM kob_order_history ord_hist_2 WHERE ord_hist_2.id_order =ord_hist_1.id_order) 
					AND ord_hist_1.id_order_state IN (36,38) 
					AND ord.date_add BETWEEN '2017-04-01' AND CURRENT_DATE 
					AND inv_sub.date_add IS NOT NULL
					AND pay_rec.date_add IS NOT NULL";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function receivablesPending(){
		
		$query = "SELECT FORMAT(sum(ord.total_paid_tax_incl),0,'en_IN') as total_receivables
					FROM `kob_order_invoice` ord
					LEFT JOIN kob_order_history ord_hist_1
					ON ord.id_order = ord_hist_1.id_order
					LEFT JOIN `kob_orders` as ords
					ON ord.id_order = ords.id_order
					WHERE ord_hist_1.id_order_history = (SELECT MAX(ord_hist_2.id_order_history)
					                 FROM kob_order_history ord_hist_2
					                 WHERE ord_hist_2.id_order = ord_hist_1.id_order)
					AND ord_hist_1.id_order_state IN (35)";

		return Db::getInstance()->ExecuteS($query);
	}

	public static function paymentsPending(){
		
		$query = "SELECT FORMAT(sum(amount),0,'en_IN') as total_payables FROM `kob_payment_request` where status = 0  ";

		return Db::getInstance()->ExecuteS($query);
	}

}

?>
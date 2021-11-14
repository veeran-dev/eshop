<?php
    class MonthlyKPI extends FrontController
    {
        public function reportKPI(){
            // fetch data from analytics
		// create excel sheet and add it
		// Mail it to the group

			$toplineRevenue = Analytics::topLineRevenue();
			$fcWiseRevenue = Analytics::fcWiseRevenue();
			$rmWiseRevenue = Analytics::rmWiseRevenue();
			$kamWiseRevenue = Analytics::kamWiseRevenue();
			$categoryWiseRevenue = Analytics::categoryWiseRevenue();
			$topCustomerRevenue = Analytics::topCustomerRevenue();

			$averageAdt = Analytics::averageAdt();
			$fcWiseAverageAdt = Analytics::fcWiseAverageAdt();

			$ordersPendingWithOps = Analytics::ordersPendingWithOps();
			$ordersPendingWithCategory = Analytics::ordersPendingWithCategory();
			$ordersPendingWithFinance = Analytics::ordersPendingWithFinance();
			$ordersPendingWithRm = Analytics::ordersPendingWithRm();
			$totalPendingOrders = $ordersPendingWithOps + $ordersPendingWithCategory + $ordersPendingWithFinance + $ordersPendingWithRm;

			$averageCollectionPeriod = Analytics::averageCollectionPeriod();
			$receivablesPending = Analytics::receivablesPending();
			$paymentsPending = Analytics::paymentsPending();

			$activeCompaniesCount = Analytics::activeCompaniesCount();
			$activeUsersCount = Analytics::activeUsersCount();
			$newCustomers = Analytics::newCustomers();

			$activeProducts = Analytics::activeProducts();
			$totalBrands = Analytics::totalBrands();
			$totalOosProducts = Analytics::totalOosProducts();

			$currentVendors = Analytics::currentVendors();
			$newVendors = Analytics::newVendors();
			$totalVendors = Analytics::totalVendors();

			$annualRevenueTarget = Analytics::annualRevenueTarget();
			
			//$logger = new FileLogger();
			//$logger->setFilename("test.txt");
			//$logger->logError("Email test");

			$arta = ($annualRevenueTarget[0]['achieved']*$annualRevenueTarget[0]['target']) / 100;
			$target_Achived = $annualRevenueTarget[0]['achieved'];
			$annual_target = $annualRevenueTarget[0]['target'];

			$tlr_lm = $toplineRevenue[0]['mon']." : ".$toplineRevenue[0]['revenue'];
			$tlr_cm = $toplineRevenue[1]['mon']." : ".$toplineRevenue[1]['revenue'];

			$fc_wise = '';
			foreach($fcWiseRevenue as $fcwr){
				$fc_wise .= "<p>".$fcwr['fc_name']." : <span> <b>".$fcwr['revenue']."</b></span></p>";
			}

			$rm_wise = '';
			foreach($rmWiseRevenue as $fcwr){
				$rm_wise .= "<p>".$fcwr['firstname']." : <span> <b>".$fcwr['rm_revenue']."</b></span></p>";
			}

			$kam_wise = '';
			foreach($kamWiseRevenue as $fcwr){
				$kam_wise .= "<p>".$fcwr['firstname']." : <span> <b>".$fcwr['kam_revenue']."</b></span></p>";
			}

			$tcat_wise = '';
			foreach($categoryWiseRevenue as $fcwr){
				$tcat_wise .= "<p>".$fcwr['cat_name']." : <span> <b>".$fcwr['total_sales']."</b></span></p>";
			}

			$tcus_wise = '';
			foreach($topCustomerRevenue as $fcwr){
				$tcus_wise .= "<p>".$fcwr['name']." : <span> <b>".$fcwr['total_sales']."</b></span></p>";
			}

			$avg_dt = $averageAdt[0]['adt_hours'];

			$fc_avg_dt = '';
			foreach($fcWiseAverageAdt as $fcwr){
				$fc_avg_dt .= "<p>".$fcwr['city_name']." : <span> <b>".$fcwr['adt_hours']."</b></span></p>";
			}
//$logger->logError($tcat_wise);
//$logger->logError($tcus_wise);
//$logger->logError($avg_dt);
//$logger->logError($fc_avg_dt);
			$total_po = $totalPendingOrders;

			$po .= "<p>Rel. Managers : <span> <b>".$ordersPendingWithRm[0]['pending_rm']."</b></span></p>";
			$po .= "<p>Operations : <span> <b>".$ordersPendingWithOps[0]['pending_ops']."</b></span></p>";
			$po .= "<p>Category : <span> <b>".$ordersPendingWithCategory[0]['pending_cat']."</b></span></p>";
			$po .= "<p>Finance : <span> <b>".$ordersPendingWithFinance[0]['pending_finance']."</b></span></p>";

			$receivables = $receivablesPending[0]['total_receivables'];
			$payables = $paymentsPending[0]['total_receivables'];
			$averageCollectionPeriod = $averageCollectionPeriod[0]['dso'];

			$new_customer = $newCustomers[0]['new_customer'];
			$active_companies = $activeCompaniesCount[0]['companies_count'];
			$active_users = $activeUsersCount[0]['user_count'];

			$active_brands = $totalBrands[0]['total_brands'];
			$active_products = $activeProducts[0]['active_products'];
			$oos = $totalOosProducts[0]['total_oos'];

			$new_vendors = $newVendors[0]['new_vendors'];
			$total_vendors = $totalVendors[0]['total_vendors'];
			$active_vendors = $currentVendors[0]['current_vendors'];

			$month = date("M,y");

			$data = array(
				'{arta}' => $arta,
				'{target_Achived}' => $target_Achived,
				'{annual_target}' => $annual_target,
				'{tlr_lm}' => $tlr_lm,
				'{tlr_cm}' => $tlr_cm,
				'{fc_wise}' => $fc_wise,
				'{rm_wise}' => $rm_wise,
				'{kam_wise}' => $kam_wise,
				'{tcat_wise}' => $tcat_wise,
				'{tcus_wise}' => $tcus_wise,
				'{avg_dt}' => $avg_dt,
				'{fc_avg_dt}' => $fc_avg_dt,
				'{total_po}' => $total_po,
				'{po}' => ////$logger,
				'{fc_wise_po}' => $fc_wise_po,
				'{receivables}' => $receivables,
				'{payables}' => $payables,
				'{averageCollectionPeriod}' => $averageCollectionPeriod,
				'{new_customer}' => $new_customer,
				'{active_companies}' => $active_companies,
				'{active_users}' => $active_users,
				'{active_brands}' => $active_brands,
				'{active_products}' => $active_products,
				'{oos}' => $oos,
				'{new_vendors}' => $new_vendors,
				'{total_vendors}' => $total_vendors,
				'{active_vendors}' => $active_vendors,
				'{month}' => $month,
			);
			
			$to =array('veeran.b@kobster.com','veeran.ambalam@gmail.com'); 

			$subject = "Kobster Montlhy KPI Reports";

			$template = "kpi";

			Mail::Send(1, $template, $subject, $data, $to);
		}
    }
		
?>
<?php
/*
	Author: Elumalai K
	Controller: Quotation Controller
*/
class QuoteControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		$start_memory = memory_get_usage();

		$type = Tools::getValue('type');

		$query = Tools::getValue('q');
		$id_company = Tools::getValue('id_company');
		$id_employee = Tools::getValue('id_employee');
		$id_quotation = Tools::getValue('id_quotation');
		$id_product = Tools::getValue('id_product');
		$id_state = Tools::getValue('id_state');
		$product_array_val = Tools::getValue('product_array');
		$price_type = Tools::getValue('price_type');
		$message = Tools::getValue('message');
		$product_price = Tools::getValue('price');
		$date = Tools::getValue('date');
		$remarks = Tools::getValue('remarks');
		$quote_revise_attempt = Tools::getValue('quote_revise_attempt');
		$delete = Tools::getValue('delete_product');

		// Objects
		$quotationObj = new ScnQuotation();
		$customerObj = new Customer();

		if($type == 1) // search for corporate customers
		{
			$result = $customerObj->searchCompany($query);
			echo Tools::jsonEncode($result);
		}
		else if($type == 2)  //create new quotation
		{
			$quote_exists = $quotationObj->isExistsQuote($query,$id_company);
			 
			if ($quote_exists)
			{
 				echo "0";
				
			}
			else
			{
				$quotationObj->id_group = $id_company;
				$quotationObj->id_employee = $id_employee;
				$quotationObj->quote_name = $query;
				$quotationObj->quote_version = 1;
				$quotationObj->active = 1;
				$quotationObj->date_generated = date('Y-m-d H:i:s');
				if($quotationObj->add()){
					$result = array();
					$quote_regions = FulfillmentCentre::getAllFCentres();
					array_push($result, $quotationObj->id, $quote_regions);
					echo Tools::jsonEncode($result);
				}
			}
		}
		else if($type == 3) // save quotation products
		{
				
			foreach ($product_array_val as $array_of_product) 
			{
				$var = explode("~", $array_of_product);
				
				if($var[3])
				{
					//do nothing
				}
				else
				{
					$var[3] = "--";
				}
				$date=date("Y-m-d H:i:s",strtotime($var[4]));
				//$date=$var[4];
				$quotationObj->addProdToQuotation($quote_id = $var[0], $prod_id = $var[1], $prod_price = $var[2], $remark = $var[3], $date = $date);
			}
			echo "1";
		}
		else if($type == 4) //get quotations
		{
			$result = $quotationObj->getQuotations($id_company,$type);

			for($i = 0;$i < sizeof($result); $i++) {
				$employee = new Employee((int)($result[$i]['id_employee']));
				$result[$i]['id_employee'] = $employee->firstname;
				$quotation = new ScnQuotation(intval($result[$i]['id_quotation']));
				$result[$i]['state'] = $quotation->getRegions();
			}

			echo Tools::jsonEncode($result);
		}
		else if($type == 5) // view quotation in revise block
		{
				$result = $quotationObj->reviseViewQuotation($id_quotation, $type);

				$quotation = new ScnQuotation(intval($id_quotation));
				$quote_regions = FulfillmentCentre::getAllFCentres();
				$result[2]['regions'] = $quote_regions;
				$result[3]['quote_name'] = $quotation->quote_name;
				$result[4]['quote_version'] = $quotation->quote_version;

				echo Tools::jsonEncode($result);
		}
		else if($type == 6) //create revise quote
		{
			$quote_exists = $quotationObj->isExistsQuote($query,$id_company);
 			
 			if(!$quote_exists)
			{
				$quotationObj->id_group = $id_company;
				$quotationObj->id_employee = $id_employee;
				$quotationObj->quote_name = $query;
				$quotationObj->quote_version = 1;
				$quotationObj->active = 1;
				$quotationObj->date_generated = date('Y-m-d H:i:s');
				if($quotationObj->add()) {
   					echo Tools::jsonEncode($quotationObj->id);
				}
			}
			else
			{
				$quote_version = $quotationObj->getLastAddedQuotVersion($query,$id_company);

				//Create revised quote
				$quotationObj->id_group = $id_company;
				$quotationObj->id_employee = $id_employee;
				$quotationObj->quote_name = $query;
				$quotationObj->quote_version = ++$quote_version[0]['quote_version'];
				$quotationObj->active = 1;
				$quotationObj->date_generated = date('Y-m-d H:i:s');
				if($quotationObj->add()){
					foreach ($product_array_val as $array_of_product) {
						$var = explode("~", $array_of_product);
						if($var[3]){}
						else{
							$var[3] = "--";
						}
						$date=date("Y-m-d H:i:s",strtotime($var[4]));
						$date=substr_replace($date,'23:59:59',11);
						$quotationObj->addProdToQuotation($quotationObj->id, $prod_id = $var[1], $prod_price = $var[2], $remark = $var[3], $date = $date);
					}
					echo 1;
				}
			}

		}
		else if($type == 7) // get product details
		{
			$result = array();
			if($quote_revise_attempt == "true") {
				$error = array();
				$quote_version = $quotationObj->getLastAddedQuotVersion($query, $id_company);
				//Create revised quote
				$quotationObj->id_group = $id_company;
				$quotationObj->id_employee = $id_employee;
				$quotationObj->quote_name = $query;
				$quotationObj->quote_version = ++$quote_version[0]['quote_version'];
				$quotationObj->active = 1;
				$quotationObj->date_generated = date('Y-m-d H:i:s');
				if($quotationObj->add()){
					$quote_detail = $quotationObj->getQuotationDetailById($id_quotation);
					if(!empty($quote_detail)) {
						foreach ($quote_detail as $key => $value) {
							if(!$quotationObj->addProdToQuotation($quotationObj->id, $value['id_product'], $value['product_price'], $value['remarks'], $value['to'])) {
								$error[] = "There is an issue with revising quote.";
							}
						}
					}

					if(sizeof($error) < 1) 
					{
						$success = false;

						if(isset($delete) && $delete == 'true') {
							$deleted = ScnQuotation::removeProductFromQuote($quotationObj->id, $id_product);
							if($deleted) {
								$success = true;
							}
						}
						else {
							$date=date("Y-m-d H:i:s",strtotime($date));
							$date=substr_replace($date,'23:59:59',11);
							if($quotationObj->addProdToQuotation($quotationObj->id, $id_product, $product_price, $remarks, $date)) {
								$success = true;
							}
							else {
								echo 0;
							}
						}

						if($success) {
							$product = new Product((int)($id_product));
							$product->tax_value = $quotationObj->getProductTaxRate((int)$id_product);
							$product->quoted_price = Tools::ps_round($product_price, _PS_PRICE_COMPUTE_PRECISION_);
							$product->to = $date;
							array_push($result, $product, $quotationObj->id);
							echo Tools::jsonEncode($result);
						}
						else {
							echo 0;
						}
					}
					else {
						echo 1;
					}
				}
			}
			else 
			{
				$success = false;

				if(isset($delete) && $delete == 'true') {
					$deleted = ScnQuotation::removeProductFromQuote($id_quotation, $id_product);
					if($deleted) {
						$success = true;
					}
				}
				else {
					$date=date("Y-m-d H:i:s",strtotime($date));
					$date=substr_replace($date,'23:59:59',11);
					if($quotationObj->addProdToQuotation($id_quotation, $id_product, $product_price, $remarks, $date)) {
						$success = true;
					}
					else {
						echo 0;
					}
				}

				if($success) {
					$product = new Product((int)($id_product));
					$product->tax_value = $quotationObj->getProductTaxRate((int)$id_product);
					$product->quoted_price = Tools::ps_round($product_price, _PS_PRICE_COMPUTE_PRECISION_);
					$product->to = $date;
					array_push($result, $product, $id_quotation);
					echo Tools::jsonEncode($result);
				}
				else {
					echo 0;
				}
			}
		}
		else if($type == 8) // get price suggestions
		{
			$product = new Product(intval($id_product));
			$available_zones = FulfillmentCentre::getAllFCentres();
			$wholesale_price = $product->wholesale_price;
			$zonal_prices = array();

			if(isset($available_zones) && !empty($available_zones)) { // Mapped All Zones
				/*** Check zone prices added to product ***/
				foreach ($available_zones as $key => $zone) {
					$fc = new FulfillmentCentre(intval($zone['id_fulfillment_centre']));
					$zonal_price = ZonalPrice::getPrices($product->id, $fc->id);
					$zonal_prices[$key]['available_at_region'] = (int)$fc->getProductAvailable($product->id) ? "Yes" : "No";
					$zonal_prices[$key]['id_fulfillment_centre'] = $zone['id_fulfillment_centre'];
					$zonal_prices[$key]['city'] = $zone['city_name'];
					if(empty($zonal_price)) { // No zonal price
						if($wholesale_price != '0.000000') { // Check wholesale price
							$zonal_prices[$key]['price'] = Tools::ps_round($wholesale_price, _PS_PRICE_COMPUTE_PRECISION_);
						}
						else {
							$zonal_prices[$key]['price'] = "Not updated";
						}
					}
					else {
						// Zonal price available
						$zonal_prices[$key]['price'] = Tools::ps_round($zonal_price[0]['price'], _PS_PRICE_COMPUTE_PRECISION_);
					}
				}
			}
			// else { // Mapped Particularly Some Zones
			// 	/*** Check zone prices added to some locations ***/
			// 	foreach ($available_zones as $key => $zone) {
			// 		$_zonal_price_result = "";
			// 		$zonal_price = ZonalPrice::getPrices($product->id, $zone['id_fulfillment_centre']);
			// 		$zonal_prices[$key]['id_fulfillment_centre'] = $zone['id_fulfillment_centre'];
			// 		$zonal_prices[$key]['city'] = $zone['city_name'];
			// 		// Loop through product mapped zones
			// 		foreach ($product_mapped_zones as $mapped_zone) { // Mapped zones
			// 			if($zone['id_fulfillment_centre'] == $mapped_zone['id_fulfillment_centre']) {
			// 				if(empty($zonal_price)) { // No zonal price
			// 					if($wholesale_price != '0.000000') { // Check wholesale price
			// 						$_zonal_price_result = Tools::ps_round($wholesale_price, _PS_PRICE_COMPUTE_PRECISION_);
			// 					}
			// 					else {
			// 						$_zonal_price_result = "NA";
			// 					}
			// 				}
			// 				else {
			// 					// Zonal price available
			// 					$_zonal_price_result = Tools::ps_round($zonal_price[0]['price'], _PS_PRICE_COMPUTE_PRECISION_);
			// 				}
			// 			}
			// 		}

			// 		if($_zonal_price_result == "")
			// 			$_zonal_price_result = "NA";

			// 		$zonal_prices[$key]['price'] = $_zonal_price_result;
			// 	}
			// }

			$product_details = $quotationObj->getProdPiceDetail($product->id);

			$result = array('product_details' => $product_details, 'zone_prices' => $zonal_prices);

			echo Tools::jsonEncode($result);
		}
		else if($type == 9) // publishing quotation
		{
			$quotationObj = new ScnQuotation((int)($id_quotation));
			
			$quotationObj->published = 1;

			if($quotationObj->update())
			{
				$company = new Group($id_company);
				$get_rm_id = RelationshipManager::getRmByCompany((int)($company->id));
				$rel_manager = new Employee((int)($get_rm_id[0]['id_relationship_manager']));
				$employee = new Employee($id_employee);
				$regions = $quotationObj->getRegions();

				$data = array(
							'{firstname}' => $rel_manager->firstname,
							'{lastname}' => $rel_manager->lastname,
							'{location}' => $regions,
							'{employee}' => $employee->firstname,
							'{company}' => $company->name[1]);

				$em_sub = 'Quotation publish notification by '. $employee->firstname .'';

				Mail::Send(1, 'quote_published', Mail::l($em_sub, 1), $data, $rel_manager->email, $rel_manager->firstname.' '.$rel_manager->lastname, NULL, NULL, $fileAttachment = NULL);
				
				echo 1;
			}
		}
		else if($type == 10) // get all available locations
		{
			$result = PinCodeMaster::getZones($include_pan_india = false);
			echo Tools::jsonEncode($result);
		}
		else if($type == 12) // Delete quote product
		{
			$delete_quote_product = $quotationObj->deleteQuoteProduct($id_product,$id_quotation);

			if($delete_quote_product)
				echo "2";
			else
				echo "1";
		}
		else if($type == 13) //View price suggestions
		{
			$result = $quotationObj->getPrices($id_product, $id_company, $price_type);
			echo Tools::jsonEncode($result);	
		}
		else if($type == 14)
		{
			$product = new Product((int)($id_product));
			$employee = new Employee((int)($id_employee));

			$params = array(
                '{firstname}' => $employee->firstname,
                '{lastname}' => $employee->lastname,
                '{productName}' => $product->name[1],
                '{productCode}' => $product->reference,
                '{message}'	=> $message != "" ? $message : "No descriptions added."
            );
            $cc = $employee->email;

            Mail::Send(1,'quoteReportError',
            	Mail::l('Quote module product data error message from SCN Portal', 1),
            	$params,
            	array('category@kobster.com', 'catalog@kobster.com'),
            	null,null, null, null, null, _PS_MAIL_DIR_, false, 1,null,null,$cc);

            echo 1;
		}
		else if($type==29)
		{
			$result=Tax::getTaxes(1);
			echo json_encode($result);
		}
		else if($type == 30) { // Add single row - quote creation
			$exp_date = date("Y-m-d H:i:s",strtotime($date));
			$quotationObj = new ScnQuotation(intval($id_quotation));
			if($quotationObj->addProdToQuotation($quotationObj->id, $id_product, $product_price, $remarks, $exp_date)) {
				echo 1;
			}
		}
		else if($type == 31) {
			$quote_regions = FulfillmentCentre::getAllFCentres();
			echo Tools::jsonEncode($quote_regions);
		}
	}
}
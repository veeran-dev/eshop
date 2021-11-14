<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14006 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class PurchaseOrderControllerCore extends FrontController
{
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$po_number = Tools::getValue('po_number');
		$po_date = Tools::getValue('po_date');
		$valid_from = Tools::getValue('valid_from');
		$valid_through = Tools::getValue('valid_through');
		$po_details = Tools::getValue('po_details');
		$id_address = Tools::getValue('id_address');
		$id_customer = Tools::getValue('id_customer');
		$file_array = $_FILES;
		$file = $file_array['file']['name'];
		$temp_name  = $file_array['file']['tmp_name'];
		require_once (_PS_ROOT_DIR_.'/classes/PHPExcel/Classes/PHPExcel.php');
		$uploaded_by = $this->context->cookie->id_customer;

		$id_option_configured = $this->context->cookie->budget_option;
		$id_address_configured = $this->context->cookie->id_address_budget;

		// Upload Purchase Order Template
		if($type == 1) 
		{
			if($file != "" && isset($file)) 
			{
				// Allowed file formats
				$allowed =  array('xls','xlsx');
				$ext = pathinfo($file, PATHINFO_EXTENSION);

				if(!in_array($ext, $allowed)) 
				    echo 1; // File format not supported
				else 
				{
					if($file_array['file']['size'] > (5 * 1024 * 1024)) 
						echo 2; // Size is too large. Allowed file size - <= 5MB
					else 
					{
						$file_name = $uploaded_by."-".$po_number."-".date("Ymd-His")."-".uniqid();
						$splitName = explode(".", $file);
						$fileExt = end($splitName);

						if(count($splitName) > 1)
							$newFileName  = strtolower($file_name.'.'.$fileExt);  
						else
							$newFileName  = strtolower($file_name);

						$location = "budget_purchase_orders"; 

						if(!move_uploaded_file($temp_name, "$location/$newFileName"))
							echo 3; // Upload error
						else 
						{
							/* Read excel sheet data */
							$inputFileName = 'budget_purchase_orders/'.$newFileName;
							$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
							$sheetData = $objPHPExcel->getActiveSheet()->toArray();
							$productIds = array();
							$productErrors = array();
							$sheetResult = array();

							// Looping excel datas
							for($i = 1; $i < sizeof($sheetData); $i++) 
							{
								$datas[$i] = Product::getIdByReference((int)($sheetData[$i][0]));

								if($datas[$i] != false && $sheetData[$i][4] != "" && (int)$sheetData[$i][4] > 0) {
									$productIds[] = $datas[$i];
									$sheetResult[] = array("id_product" => $datas[$i], "quantity" => $sheetData[$i][4]);
								}
								else 
									$productErrors[] = "error";
							}
							
							if(sizeof($productIds)) 
							{
								$productString = implode(",", $productIds);
								$productsProperties = Product::getSpecificProducts($productString);

								for($j = 0; $j < sizeof($productsProperties); $j++) 
									for($k = 0; $k < sizeof($sheetResult); $k++) 
										if((int)($productsProperties[$j]['id_product']) == (int)($sheetResult[$k]['id_product'])) {
											// Product status string
											if($productsProperties[$j]['discontinued'] == 1) 
												$productsProperties[$j]['productStatus'] = "disabled";
											else {
												if(($productsProperties[$j]['allow_oosp'] == 1) || ($productsProperties[$j]['allow_oosp'] == 0 && $productsProperties[$j]['available_for_order'] == 1))
	        										$productsProperties[$j]['productStatus'] = "active";
												else
													$productsProperties[$j]['productStatus'] = "Out of Stock";
											}
											// Given quantity by user
											$productsProperties[$j]['quantityGiven'] = $sheetResult[$k]['quantity'];
										}

								// Get products full properties
								$products = Product::getProductsPropertiesMini(1, $productsProperties);

								echo Tools::jsonEncode($products);
							}
							else 
							{
								/* Error in products list or details */
								echo 4;
							}
						}	
					}
			 	}
			}
		}
		else if($type == 2) // Add Purchase order
		{
			/* Initialize PO Object */
			$purchaseOrderObj = new PurchaseOrder();

			if((bool)strtotime($valid_from)) {
				$valid_from = date("Y-m-d H:i:s", strtotime($valid_from));
			}
			else {
				$valid_from = date("Y-m-d H:i:s");
			}
			
			if((bool)strtotime($valid_through)) {
				$valid_through = date("Y-m-d 23:59:59", strtotime($valid_through));
			}

			$po_date = date("Y-m-d", strtotime($po_date));

			$po_option = Tools::getValue('po_option');

			if($po_option == 2) {
				$po_upload_response = $purchaseOrderObj->uploadPo($po_number, $file_array);
				if($po_upload_response != 3) {
					echo $po_upload_response;
					return false;
				}
			}

			$purchaseOrderObj->po_number = $po_number;
			$purchaseOrderObj->po_date = $po_date;
			$purchaseOrderObj->uploaded_by = (int)($uploaded_by);
			$purchaseOrderObj->valid_from = $valid_from;
			$purchaseOrderObj->valid_through = $valid_through;
			$purchaseOrderObj->active = 1;
			/* Add new purchase order */
			if(!$purchaseOrderObj->isExists($po_number, $id_address[0])) {
				if($purchaseOrderObj->add()) {
					/* Map addresses to purchase order */
					$addresses_arr = $id_address;
					$addresses = array();
					for ($i = 0; $i < sizeof($addresses_arr); $i++) {
						$addresses[$i]['id_purchase_order'] = $purchaseOrderObj->id;
						$addresses[$i]['id_address'] = $addresses_arr[$i];
						$addresses[$i]['id_option'] = $this->context->cookie->budget_option;
					}

					$purchaseOrderObj->id_address = $addresses;

					if($purchaseOrderObj->mapAddressWithPurchaseOrder()) 
					{
						/* Add products in purchase order details */
						if($po_option == 1) {
							$products = explode(",", $po_details);
							$productDetails = array();
							foreach ($products as $key => $product) {
								$productDetail = explode("-", $product);
								$productDetails[$key]['id_purchase_order'] = $purchaseOrderObj->id;
								$productDetails[$key]['id_product'] = $productDetail[0];
								$productDetails[$key]['quantity'] = $productDetail[1];
							}

							$purchaseOrderObj->product_details = $productDetails;
							
							if($purchaseOrderObj->addProductsToPurchaseOrder()) {
								echo "success";
							}
						}
						else {
							$purchaseOrderObj->po_value = $po_details;
							if($purchaseOrderObj->addValueToPurchaseOrder()) {
								echo "success";
							}
						}
					}
				}
			}
			else {
				echo "PO already exists. Please create new one to proceed.";
			}
		}
		else if($type == 3) 
		{
			$widget = new Widget(17);
			echo $widget->userHasWidget($id_customer, 1);
		}
		else if($type == 4) 
		{
			$po_string = Tools::getValue('po_string');
			PurchaseOrder::downloadPoById($po_string);
		}
		else if($type == 5) 
		{
			$limit = Tools::getValue('limit');
			$offset = Tools::getValue('offset');
			$fromDate = Tools::getValue('fromDate');
			$toDate = Tools::getValue('toDate');
			$duration = Tools::getValue('duration');
			$idPage = Tools::getValue('idPage');

			$limit ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
			$offset = (PAGE_PER_NO * intval($idPage));

			$result = PurchaseOrder::getAllPoHistory($id_address_configured, $id_option_configured, $limit, $offset, $orderBy, $orderWay, $fromDate, $toDate);

			echo Tools::jsonEncode($result);
		}
		else if($type == 6) /*** For PO detailed view with history ***/
		{ 
			$result = array();
			$id_purchase_order = Tools::getValue('id_purchase_order');
			
			// Get PO master detail
			$po_master_obj = new PurchaseOrder(intval($id_purchase_order));
			
			// Get PO address
			$address_obj = Address::getParticularAddress(intval($id_address_configured));

			// Get PO detail based or PO option
			if($id_option_configured == 1) {
				$po_details = $po_master_obj->getProducts($id_address_configured);
			}
			else {
				$po_details = $po_master_obj->getValues($id_address_configured);
			}

			// Get PO used orders
			$po_orders = $po_master_obj->getOrders($id_address_configured, $id_option_configured);

			foreach ($po_orders as $key => $order) {
				$orderObj = new Order(intval($order['id_order']));
				// Get order products
				$po_orders[$key]['products'] = $orderObj->getProducts();
			}

			$result = array(
				'po' => $po_master_obj,
				'poAddress' => $address_obj,
				'poDetails' => $po_details,
				'poHistory' => $po_orders,
				'poOption' => $id_option_configured
			);

			echo Tools::jsonEncode($result);
		}
		else if($type == 7) { // Get Purchase Orders associated with address
			$purchaseOrderObj = new PurchaseOrder();
			$result = $purchaseOrderObj->getPurchaseOrdersByAddress($id_address, $id_option_configured, true);
			if(sizeof($result) > 0) {
				foreach ($result as $key => $po) {
					$purchaseOrderObjNew = new PurchaseOrder(intval($po['id_purchase_order']));
					if($id_option_configured == 1) {
						$product_available = 0;
						$result[$key]['products'] = $purchaseOrderObjNew->getProducts($id_address);
						$result[$key]['product_available_total'] = sizeof($result[$key]['products']);
						foreach ($result[$key]['products'] as $key => $product) {
							if($product['remaining_quantity'] > 0) {
								$product_available++;
							}
						}
						$result[$key]['product_available'] = $product_available;
					}
					else if($id_option_configured == 2) {
						$result[$key]['value_available'] = 0;
						$result[$key]['value'] = $purchaseOrderObjNew->getValues($id_address);
						if(intval($result[$key]['value'][0]['remaining_value']) > 0) {
							$result[$key]['value_available'] = $result[$key]['value'][0]['remaining_value'];
							$result[$key]['value_available_total'] = $result[$key]['value'][0]['value'];
						}
					}
				}
			}
			echo Tools::jsonEncode($result);
		}
		else if($type == 8) {
			$activate_type = Tools::getValue('activate_type');
			$id_purchase_order = Tools::getValue('id_purchase_order');
			$purchaseOrder = new PurchaseOrder(intval($id_purchase_order));
			if($activate_type == 1) {
				$purchaseOrder->active = 1;
			}
			else if($activate_type == 2) {
				$purchaseOrder->active = 0;
			}
			else if($activate_type == 3) {
				$purchaseOrder->delete = 1;
			}

			if($purchaseOrder->update()) {
				$purchaseOrder->addActionHistory($activate_type, $this->context->cookie->id_customer);
				$has_valid_po = $purchaseOrder->getPurchaseOrdersByAddress($id_address_configured, $id_option_configured, true);
				$has_valid_po = sizeof($has_valid_po) > 0 ? true : false;
				echo Tools::jsonEncode(array('proceed' => $has_valid_po));
			}
			else {
				echo 0;
			}
		}
 	}

 	public function generateReport() 
 	{
 		$poNumber = Tools::getValue('poNumber');
 		$poDate = Tools::getValue('poDate');
 		$poFromDate = Tools::getValue('poFromDate');
 		$poToDate = Tools::getValue('poToDate');
 		$id_customer = $this->context->cookie->id_customer;

 		// Specific price object initialization
		$specificPriceObj = new SpecificPrice();

		// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster.com")->setLastModifiedBy("Kobster.com")->setTitle("Purchase Order")->setSubject("Purchase Order")->setDescription("Purchase Order")->setKeywords("Purchase Order")->setCategory("Purchase Order");
        
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
		//Write Data
		//Header
		$objPHPExcel->getActiveSheet()->setCellValue('A'.'1', "Product Code");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.'1', "Product Name");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.'1', "Price( Tax Exclusive )");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.'1', "Minimum Quantity");
		$objPHPExcel->getActiveSheet()->setCellValue('E'.'1', "Quantity");
		
		$cols = array("A", "B", "C", "D", "E");
		$result = $specificPriceObj->getCustomerProductList((int)($id_customer));

		if($result){
			$j = 2;
			foreach($result as $row)
			{
				$i = 0;
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['reference']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['name']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['sp_price']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['minimal_quantity']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, "");
				$j++;
			}
		}

		// Set auto expand size for columns
		foreach ($cols as $key => $column) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $download_filename  = $id_customer . "-" . $poNumber . "-purchase-order" . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
 	}

 	public function notifyPOStatus() {
 		$purchaseOrder = new PurchaseOrder();
 		$result = $purchaseOrder->getAllPO();
 		if(sizeof($result) > 0) {
 			foreach ($result as $key => $po) {
 				$valid_through = date('Y-m-d', strtotime($po['valid_through']));
 				$one_week_after = date('Y-m-d', strtotime("+1 week"));
 				$one_day_after = date('Y-m-d', strtotime("+1 day"));
 				$fifteen_days_after = date('Y-m-d', strtotime("+15 day"));
 				if(($valid_through == $one_week_after) || 
 					$valid_through == $one_day_after ||
 					$valid_through == $fifteen_days_after
 				) {
 					if($po['id_option'] == 2) {
 						//Get all po going to expire in one week and send notification to user
	 					//execute now only for value based.
	 					$purchaseOrderNew  = new PurchaseOrder(intval($po['id_purchase_order']));
	 					$groupObj = new Group(intval($po['id_default_group']));
	 					$relationshipManager = new Employee(intval($groupObj->id_relationship_manager));
	 					$kam = new Employee(intval($groupObj->id_kam));
	 					$purchaseOrderValues = $purchaseOrderNew->getValues();
	 					$templateVars['{date}'] = date('Y-m-d H:i:s');
	 					$templateVars['{firstname}'] = $po['firstname'];
			            $templateVars['{lastname}'] = $po['lastname'];
			            $templateVars['{company}'] = $groupObj->name;
			            $templateVars['{validity_date}'] = $po['validity_date'];
			            $templateVars['{po_date}'] = $po['po_date'];
			            $templateVars['{po_number}'] = $po['po_number'];
			            $templateVars['{budget_type}'] = $po['budget_type'];
			            $templateVars['{available_budget}'] = Tools::ps_round($purchaseOrderValues[0]['remaining_value'], 2);
			            $templateVars['{total_budget}'] = Tools::ps_round($purchaseOrderValues[0]['value'], 2);
			            $templateVars['{rm_start_msg}'] = "";

			            $id_lang = Language::getIdByIso('en');  //Set the English mail template
			            $template_name = 'budget_value_based'; //Specify the template file name
			            $title = Mail::l('[Kobster][Elite PO] #'.$po['po_number'].': Expires on '.$po['validity_date']);

			            // Send email to configured user
			            Mail::Send($id_lang, $template_name, $title, $templateVars, $po['email'], NULL, NULL, NULL);

			            // Send email to realtionship manager
			            if(Validate::isLoadedObject($relationshipManager)) {
				            $templateVars['{firstname}'] = $relationshipManager->firstname;
				            $templateVars['{lastname}'] = $relationshipManager->lastname;
				            $templateVars['{rm_start_msg}'] = "customer's ";
				            Mail::Send($id_lang, $template_name, $title, $templateVars, $relationshipManager->email, NULL, NULL, NULL);
				        }

			            // Send email to kam
			            if(Validate::isLoadedObject($kam)) {
			            	$templateVars['{firstname}'] = $kam->firstname;
			            	$templateVars['{lastname}'] = $kam->lastname;
			            	$templateVars['{rm_start_msg}'] = "customer's ";
			            	Mail::Send($id_lang, $template_name, $title, $templateVars, $kam->email, NULL, NULL, NULL);
			            }
 					}
 				}
	 		}
 		}
 	}
}
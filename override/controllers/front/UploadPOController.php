<?php 
/**
 * Author: Elumalai K
 * Implemented For: Bulk purchase by uploading excel sheet info's
**/
class UploadPOControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		if(!$this->context) {
			$this->context = Context::getContext();
		}

		$type = Tools::getValue('type');
		$file = $_FILES['file']['name'];
		$temp_name  = $_FILES['file']['tmp_name'];
		require_once (_PS_ROOT_DIR_.'/classes/PHPExcel/Classes/PHPExcel.php');
		
		if($type == 1)
		{
			if($file != "" && isset($file)){
				$allowed =  array('xls','xlsx');
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				if(!in_array($ext, $allowed) ) {
				    echo 1; // File format not supported
				}
				else{
					if($_FILES['file']['size'] > (2 * 1024 * 1024))
						echo 2; // Size is too large
					else{
						$file_name = $this->context->customer->id."-".date("Ymd-His")."-".uniqid();
						$splitName = explode(".", $file);
						$fileExt = end($splitName);
						if(count($splitName) > 1)
							$newFileName  = strtolower($file_name.'.'.$fileExt);  
						else
							$newFileName  = strtolower($file_name);

						$location = "bulk_purchase"; 
						if(!move_uploaded_file($temp_name, "$location/$newFileName"))
							echo 3; // Upload error
						else{
							$inputFileName = 'bulk_purchase/'.$newFileName;
							$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
							$sheetData = $objPHPExcel->getActiveSheet()->toArray();
							$quantity = array();
							$product_errors = array();
							$sheetResult = array();
							$result = array();
							// Looping excel datas
							for($i = 1; $i < sizeof($sheetData); $i++){
								$datas[$i] = Product::getIdByReference((int)($sheetData[$i][0]));
								if($datas[$i] != false){
									if(Validate::isInt($sheetData[$i][3]) && (int)$sheetData[$i][3] > 0) {
										$sheetResult[] = $datas[$i];
										$quantity[] = array(
											'id_product' => $datas[$i], 
											'givenQuantity' => $sheetData[$i][3], 
											'supplier_name' => $sheetData[$i][6]
										);
									}
									else {
										$product_errors[] = $datas[$i];
									}
								}
								else{
									$product_errors[] = $datas[$i];
								}
							}
							
							$product_string = implode(",", $sheetResult);
							$specific_price = new SpecificPrice();
							$products_properties = $specific_price->getCustomerProductList((int)($this->context->customer->id));
							$products_properties_uploaded = array();

							for($j = 0; $j < sizeof($products_properties); $j++){
								for($k = 0; $k < sizeof($quantity); $k++){
									if(
										(int)($products_properties[$j]['id_product']) == (int)($quantity[$k]['id_product'])
										&& (string)$products_properties[$j]['supplier_name'] == (string)$quantity[$k]['supplier_name']
									) 
									{
										$products_properties[$j]['quantityGiven'] = $quantity[$k]['givenQuantity'];
										$products_properties_uploaded[] = $products_properties[$j];
									}
								}
							}

							// Get products full properties
							$products = Product::getProductsPropertiesSupplier(1, $products_properties_uploaded);

							// For region selection
							if(isset($this->context->cookie->delivery_region) && $this->context->cookie->delivery_region != "")
								$fc = new FulfillmentCentre($this->context->cookie->delivery_region);

							if($this->context->cookie->budget_configured == 1 && $this->context->cookie->budget_option == 1) {
								$budgetProducts = array();
								$purchaseOrderObj = new PurchaseOrder();
								$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($this->context->cookie->id_address_budget), $this->context->cookie->budget_option, true);
								for ($i = 0; $i < sizeof($products); $i++) {
									$products[$i]['tax_value'] = Tax::getProductTaxRate($products[$i]['id_product'], $this->context->cart->id_address_delivery);
									$productObj = new Product((int)($products[$i]['id_product']), false, (int)($this->context->cookie->id_lang));
									$price[$i] = $productObj->getPrice($tax);
									if(isset($fc)) {
										$products[$i]['available_in_selected_region'] = (int)$fc->getProductAvailable($productObj->id);
										$products[$i]['selected_region_name'] = $fc->getStateNameByFc();
									}
									for($j = 0; $j < sizeof($purchaseOrderProducts); $j++) {
										if($products[$i]['id_product'] == $purchaseOrderProducts[$j]['id_product']) {
											$products[$i]['available_budget_quantity'] = (int)$purchaseOrderProducts[$j]['available_quantity'];
											$budgetProducts[] = $products[$i];
										}
									}
								}
							}
							else {
								for ($i = 0; $i < sizeof($products); $i++) {
									$products[$i]['tax_value'] = Tax::getProductTaxRate($products[$i]['id_product'], $this->context->cart->id_address_delivery);
									$productObj = new Product((int)($products[$i]['id_product']), false, (int)($this->context->cookie->id_lang));
									$price[$i] = $productObj->getPrice($tax);
									if(isset($fc)) {
										$products[$i]['available_in_selected_region'] = (int)$fc->getProductAvailable($productObj->id);
										$products[$i]['selected_region_name'] = $fc->getStateNameByFc();
									}
								}
							}

							array_push($result, $products, (sizeof($product_errors) > 0 ? true : false));

							echo Tools::jsonEncode($result);
						}	
					}
			 	}
			}
		}
 	}

 	public function generateReport(){
 		$id_customer = Tools::getValue('id_customer');

 		// Specific price object initialization
		$specificPriceObj = new SpecificPrice();

		// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Active sheet
        $activeSheet = $objPHPExcel->getActiveSheet();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("kobzo.com")->setLastModifiedBy("kobzo.com")->setTitle("Purchase Order - Bulk Purchase")->setSubject("Purchase Order - Bulk Purchase")->setDescription("Purchase Order - Bulk Purchase")->setKeywords("Purchase Order - Bulk Purchase")->setCategory("Purchase Order - Bulk Purchase");
        
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setFitToPage(true);
        $activeSheet->setShowGridlines(true);

        $activeSheet->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $activeSheet->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('d2493c');

		//Header
		$activeSheet->setCellValue('A'.'1', "Product Code")
					->setCellValue('B'.'1', "Product Name")
					->setCellValue('C'.'1', "Price( Tax Exclusive )")
					->setCellValue('D'.'1', "Quantity")
					->setCellValue('E'.'1', "GST %")
					->setCellValue('F'.'1', "Product Availability")
					->setCellValue('G'.'1', "Supplier");
		//Result
		$result = $specificPriceObj->getCustomerProductList((int)($id_customer));

		//Process result
		$cols = array("A", "B", "C", "D", "E", "F", "G");
		if($result){
			$j = 2;
			foreach($result as $row)
			{
				$status = "Available";
				if($row['allow_oosp'] != 0) {
					$status = "Not Available";
				}

				$i = 0;

				$activeSheet->setCellValue($cols[$i++]."".$j, $row['reference'])
							->setCellValue($cols[$i++]."".$j, $row['name'])
							->setCellValue($cols[$i++]."".$j, $row['sp_price'])
							->setCellValue($cols[$i++]."".$j, "")
							->setCellValue($cols[$i++]."".$j, $row['tax_value'])
							->setCellValue($cols[$i++]."".$j, $status)
							->setCellValue($cols[$i++]."".$j, $row['supplier_name']);
				$j++;
			}
			$objPHPExcel->getActiveSheet()->getStyle($columnID.$rID)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);
		}

		// Set auto expand size for columns
		foreach ($cols as $key => $column) {
			$activeSheet->getColumnDimension($column)->setAutoSize(true);
		}
		
        $activeSheet->setShowGridlines(true);

        $download_filename  = $id_customer . "purchase-order" . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
 	}

 	public function uploadOrderPoRm() 
 	{
 		$po_number = Tools::getValue('po_number');
		$upload_po = $_FILES['po_file']['name'];
		$temp_name  = $_FILES['po_file']['tmp_name'];
		$id_order_rm = Tools::getValue('id_order');
		$ebs_po_upload = Tools::getValue('ebs_po_upload');

		$id_cart = $this->context->cart->id;

		// Clear cookies
		$this->context->customer->mylogout();

		if(isset($upload_po) && !empty($upload_po))
		{   
			$order = new Order(intval($id_order_rm));
			$order->po_number = trim($po_number);
			if($order->update()) {
				$file_name = $ebs_po_upload != "" ? $id_cart."-PO-EBS|".str_replace(",", "-", $order->po_number) : $order->id."-(".str_replace(",", "-", $order->po_number).")-PO";			
				$splitName = explode(".", $upload_po);
				$fileExt = end($splitName);
				$newFileName  = strtoupper($file_name.'.'.$fileExt);  		
				$location = "customer_PO/"; 
				if(move_uploaded_file($temp_name, "$location/$newFileName")) {
					echo 1;
				}
			}
		}
 	}
}
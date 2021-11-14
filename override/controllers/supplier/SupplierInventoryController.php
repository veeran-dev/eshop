<?php
class SupplierInventoryControllerCore extends FrontController
{
 	public function  ajaxReturn(){
 		$this->context = Context::getContext();
		$type = Tools::getValue('type');
 		$limit= $_GET['limit'];
		$offset= $_GET['offset'];
		$fromDate= $_GET['fromDate'];
		$toDate= $_GET['toDate'];        	
		$idPage= $_GET['idPage'];
		$orderBy= $_GET['orderBy'];
		$orderWay= $_GET['orderWay'];
		$q= trim($_GET['q']);

 		$id_supplier = $this->context->cookie->s_id;
 		$supplier = new EliteSupplier($id_supplier);
        // var_dump($_FILES['file']);
        // print_r($_POST);
        if($type == 1){
        	$result = json_encode(
						array(
 							'inventories'=> SupplierInventory::getInventories($id_supplier), 
						));
 			echo $result;
        }

        if($type == 2){
        	$inventory_name = $_GET['inventory_name'];
        	$user_email = $_GET['user_email']; 
        	$password = $_GET['password'];
        	$inventory_address = $_GET['inventory_address'];
        	$address_mobile = $_GET['address_mobile'];
        	$address_city = $_GET['address_city'];
        	$address_state = $_GET['address_state'];
        	$address_country = $_GET['address_country'];
        	$address_pincode = $_GET['address_pincode'];
        	$address_gst = $_GET['address_gst'];
        	$contact_name = $_GET['contact_name'];
        	$contact_mobile = $_GET['contact_mobile'];
        	$passwd = uniqid(rand(), true);

        	$logger = new FileLogger();
        	$logger->setFilename("test_sco.txt");
        	$logger->logError($contact_mobile);
        	$logger->logError($user_email);
        	$logger->logError($supplier::validateRegistration($user_email, $contact_mobile));
        	if($supplier::validateRegistration($user_email, $contact_mobile))
        	{
        		$result = json_encode(
						array(
 							'error'=> false,
						));
 				echo $result;
 				return false;
        	}
        	else
        	{
	        	//Create Group
	        	if($group_detail = Group::getGroupByName($supplier->company)){
	        		$group = new Group();
		        	$group->name[1] = trim($supplier->company);
		        	$group->price_display_method = false;
		        	$group->add();
	        	}
	        	//Create Customer
	        	$customer = new Customer();
				$customer->email = $user_email;
				$customer->passwd = md5(_COOKIE_KEY_.$passwd);
				$customer->firstname = $contact_name;
				$customer->id_default_group = $group_detail ? $group_detail[0]['id_group'] : $group->id;
				$customer->mobile = $contact_mobile;
				$customer->id_buyer = 3;	
				if($customer->add()){
					$logger->logError("customer id");
					$logger->logError($customer->id);
					//Create Address
		        	$passwd = uniqid(rand(), true);

		        	$supplier_new = new EliteSupplier();
					$supplier_new->email = $user_email;
					$supplier_new->company = $supplier->company;
					$supplier_new->name = $contact_name;
					$supplier_new->mobile = $contact_mobile;
					$supplier_new->active = 1;
					$supplier_new->passwd = md5(_COOKIE_KEY_.$passwd);
					if($supplier_new->add()){
						$logger->logError("new supplier");

						$address = new Address();
						$address->alias = $inventory_name;
						$address->firstname = $contact_name;
						$address->company = $supplier->company;
						$address->address1 = $inventory_address;
						$address->city = $address_city;
						$address->id_state = $address_state;
						$address->postcode = $address_pincode;
						$address->phone_mobile = $address_mobile;
						$address->id_country = $countryId ? $countryId : 110;
						$address->id_customer = $supplier_id;
						$address->vat_number = $address_gst;
						$address->add();
						$logger->logError("address added");
						$logger->logError($address->id);
						if($address->add())
						{
							$logger->logError("supplier added");
							$supplierAddress = new EliteSupplierAddress();
							$supplierAddress->id_address = $address->id;
							$supplierAddress->id_supplier = $supplier_new->id;
							$supplierAddress->add();
						}
						$logger->logError("add child");
						$supplier_new->addChild($id_supplier);
					}

					$logger->logError("added Warehouse");
					//Add Warehouse
					$inventory = new SupplierInventory();
					$inventory->name = $inventory_name;
					$inventory->id_address = $address->id;
					if($inventory->add()){
						$logger->logError($inventory->id);
						$logger->logError("tag supplier");
						$inventory->tagSupplier($id_supplier, $supplier_new->id);
						$inventory->tagProfile(SupplierInventory::WAREHOUSE_MANAGER);
					}
				}

				$result = json_encode(
							array(
	 							'success'=> true, 
							));
	 			echo $result;
 			}
        }
        if($type == 3){
        	$id_inventory = $_GET['id_inventory'];
        	$result = json_encode(
						array(
 							'inventory_products'=> SupplierInventory::getInventoryProducts($id_supplier, $id_inventory), 
						));
 			echo $result;	
        }
        if($type == 4){
        	// print_r($_FILES);
        	$file = $_FILES['file']['name'];
        	$id_inventory = $_POST['id_inventory'];
			$temp_name  = $_FILES['file']['tmp_name'];
			$file_name = "inventory-".date("Ymd-His")."-".uniqid();
			$splitName = explode(".", $file);
			$fileExt = end($splitName);
			
			if(count($splitName) > 1)
				$newFileName  = strtolower($file_name.'.'.$fileExt);  
			else
				$newFileName  = strtolower($file_name);

			$inputFileName = _PS_ROOT_DIR_.'/InventoryFiles/'.$newFileName;

			if(move_uploaded_file($temp_name, $inputFileName)){
				require_once (_PS_ROOT_DIR_.'/classes/PHPExcel/Classes/PHPExcel.php');
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray();
	        	$logger = new FileLogger();
	        	$logger->setFilename('test_sco.txt');
	        	$logger->logError('====');
	        	
	        	$error = "";
	        	$start = false;

	        	for($i = 1; $i < sizeof($sheetData); $i++){
	        		$logger->logError($sheetData[$i]);
	        		if($sheetData[$i][0] == "Product ID" && $sheetData[$i][1] == "Initial Stock" && $start == false){
	        			$start = true;
	        			continue;
	        		}
	        		if($sheetData[$i][0] != "" && $sheetData[$i][1] != "" && $start == true){
	        			$logger->logError($start.'====');

	        			if(preg_match('/^\d+$/', $sheetData[$i][0]) && preg_match('/^\d+$/', $sheetData[$i][1]))
	        			{
	        				// $checkInventory = SupplierInventory::addProducts($id_inventory, $sheetData[$i][0], $sheetData[$i][1]);
	        				$logger->logError($i." checked");
	        			}
	        			else{
	        				$logger->logError($sheetData[$i][0]);
	        				$logger->logError($sheetData[$i][1]);
	        				$logger->logError($i."==> loop");
	        				$start = false;
	        				$error ="Please check the line no: ".$i." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;
	        			}
	        		}
				}

				$start = false;
				for($i = 1; $i < sizeof($sheetData); $i++){
	        		$logger->logError($sheetData[$i]);
	        		if($sheetData[$i][0] == "Product ID" && $sheetData[$i][1] == "Initial Stock" && $start == false){
	        			$start = true;
	        		}
	        		if($sheetData[$i][0] != "" && $sheetData[$i][1] != "" && $start == true){
        				$checkInventory = SupplierInventory::addProducts($id_inventory, $sheetData[$i][0], $sheetData[$i][1]);
        				$logger->logError($checkInventory);
	        		}
				}
				$result = json_encode(
					array(
						'success'=> "You're Products Added to Inventory Successfully", 
					));
 					echo $result;
			}
        }
	}

}
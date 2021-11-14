<?php
/*
*
* Supplier main controller
*
*/
class EliteQuotationControllerCore extends FrontController 
{
	public function ajaxReturn() 
	{
		$type = $_GET['type'];
		if($type == 1){
			$query = $_GET['query'];
			$page = $_GET['page'];
			$limit = $_GET['limit'];
			$sort = $_GET['sort'];
			$id_customer = $_GET['id_customer'];
			die(json_encode(array(
				'success'=>EliteSupplier::getQuotationRequestsCustomers($id_customer, $query, $limit, $page, $sort),
				'count'=>EliteSupplier::getQuotationRequestsCountCustomer($id_customer, $query, $limit, $page, $sort)
				)));
		}

		if($type == 2){
			$id_quotation = $_GET['id_quotation'];
			die(json_encode(array(
				'details'=>EliteSupplier::getQuotationRequestsDetails($id_quotation),
				'supplier'=>EliteSupplier::getQuotationRequestsSuppliers($id_quotation)
				)));
		}
		if($type == 3){
			$option = $_GET['option'];
			$price = $_GET['price'];
			$id_quote_request = $_GET['idQuoteRequest'];
			$id_supplier = $_GET['idSupplier'];
			// update quote details
			$data = EliteSupplier::selectQuote($id_quote_request, $id_supplier, $price, $option);
			if($data == false){
			    die(json_encode(array('result'=>true, 'message'=>"Sorry Quotation is already processed")));
			}
			elseif($data == 1){
			    die(json_encode(array('result'=>true, 'message'=>"Thanks for accepting the Quotation, the product is added to your rate contract")));
			}
			else if($data == 2){
			    die(json_encode(array("msg" => 'success', 'message'=>"Thanks for accepting the Quotation, Please wait until the Supplier accept the contract")));
			}
		}
		if($type == 4){
			$option = $_GET['option'];
			$target_price = $_GET['target_price'];
			$id_quote_request = $_GET['idQuoteRequest'];
			$id_supplier = $_GET['idSupplier'];
			$chance = $_GET['chance'];


			die(json_encode(EliteSupplier::negotiatePrice($id_quote_request, $id_supplier, $target_price, $chance)));
		}
		if($type == 5){
			$id_quote_request = $_GET['idQuoteRequest'];
			$id_supplier = $_GET['idSupplier'];
			$id_address_delivery = $_GET['shippingAddress'];
			$id_product = $_GET['id_product'];
			$quantity = $_GET['quantity'];
			
			$address = new Address(intval($id_address_delivery));
 			$stateObj = new State(intval($address->id_state));
 			// $context = Context::getContext();
 			// var_dump($this->context->cookie);
			$this->context->cookie->delivery_region = $stateObj->getFcIdByState(); // Set cookie for delivery region
			$this->context->cookie->id_state = $stateObj->id;
			$this->context->cookie->delivery_region_name = $stateObj->name;

			$result = ControllerFactory::getController('CartController')->mulProductAdd(0, $id_product, $id_supplier, $quantity);
			if($result["msg"] == "success"){
			    die(json_encode(
			        array(
			            'delivery_region'=>$stateObj->getFcIdByState(),
			            'id_state'=>$stateObj->id,
			            'delivery_region_name'=>$stateObj->name
			        )
			        ));
			}
		}
		if($type == 6){
			$id_category = $_POST['id_category'];
			$name_category = $_POST['name_category'];
			$description = $_POST['description'];
			$date = $_POST['date'];
			$qty = $_POST['qty'];
			$period = $_POST['period'];
			$credit = $_POST['credit'];
			$payment = $_POST['payment'];
			$regular = $_POST['regular'];
			$immediately = $_POST['immediately'];
			$product_name = $_POST['product_name'];

			$db_payment = $payment;
			if($payment == 1){
                    $payment = "Advance";
              }
            elseif ($payment == 2) {
                    $payment = "On Delivery";
            }
            elseif ($payment == 0) {
                    // $db_payment = $credit==1?3 : $credit == 2 ? 4 : 5;
                    // $payment ="credit - ".$credit==1? "7 Days" : $credit == 2 ? "30 Days" : "45 Days";
                    
                    if($credit == 1){
                        $payment ="credit - 7 days";    
                        $db_payment = 3;
                    }
                    else if($credit == 2){
                        $payment ="credit - 30 days";    
                        $db_payment = 4;
                    }
                    else if($credit == 3){
                        $payment ="credit - 45 days";    
                        $db_payment = 5;
                    }
            }

            $elite_quote_request = new EliteQuoteRequest();
            $elite_quote_request->id_customer= $this->context->cookie->id_customer;
            $elite_quote_request->id_product= 0;
            if(isset($period) && $period > 0){
                $elite_quote_request->period=$period;
            }
            $elite_quote_request->frequency=$regular;
            $elite_quote_request->quantity=$qty;
            $elite_quote_request->need= $immediately;
            $elite_quote_request->deadline=date_format(date_create($date),"Y-m-d");
            $elite_quote_request->payment=$db_payment; 
            $elite_quote_request->postcode= 0;
            $elite_quote_request->description= $description;
            $elite_quote_request->product_name= $product_name;
            $elite_quote_request->categories= $id_category;
            $elite_quote_request->add();

            $quoteHistory = new EliteQuoteHistory();
            $quoteHistory->id_quote_request = $elite_quote_request->id;
            $quoteHistory->id_quote_status = EliteQuoteHistory::IN_PROCESS;
            $quoteHistory->add();

			$id = $elite_quote_request->id;
			$rootPath = _PS_ROOT_DIR_."/EliteQuotation";
			$image = false;
			$attachment = false;
			foreach($_FILES as $index=>$val){
				$search = 'image';
				$attachment = false;
				if($index === "file_i"){
					$file = $_FILES['file_i']['name'];
		            $temp_name  = $_FILES['file_i']['tmp_name'];
		            $ext = end(explode(".", $file));    
					$location = $rootPath."/quotations/".$id.".".$ext;
	                if(!move_uploaded_file($temp_name, $location)){
	                    die(json_encode(array('error' => 'Error in uploading quotations')));
	                    return false;
	                }
				}
				else if($index === "file_k"){
					$attachment = true;
					$file_k = $_FILES['file_k']['name'];
		            $temp_name  = $_FILES['file_k']['tmp_name'];
		            $ext = end(explode(".", $file_k));    
					$location = $rootPath."/attachment/".$id.".".$ext;
	                if(!move_uploaded_file($temp_name, $location)){
	                    die(json_encode(array('error' => 'Error in uploading attachment file')));
	                    return false;
	                }
				}
				else if(preg_match("/{$search}/i", $index)) {
					$image = true;
					$image_file = $_FILES[$index]['name'];
		            $temp_name  = $_FILES[$index]['tmp_name'];
		            $ext = end(explode(".", $image_file));    
					$location = $rootPath."/images/".$id."_".$index.".".$ext;

					if($temp_name != ""){
						if(!move_uploaded_file($temp_name, $location)){
		                    die(json_encode(array('error' => 'Error in uploading image file')));
		                    return false;
		                }
					}
				}
			}
			if($image == true){
				$zip = new ZipArchive;
				$zip->open($rootPath."/".$id.'.zip', ZipArchive::CREATE);
				foreach (glob($rootPath."/images/".$id."*.*") as $file) {
				    $zip->addFile($file);
				}
				$zip->close();
				foreach (glob($rootPath."/images/".$id."*.*") as $file) {
					unlink($file);
				}
			}
			
			$customer = new Customer($this->context->cookie->id_customer);
			$subject = "Quotation Request From ".$customer->firstname." (".$customer->email.") QUOTATION: #".sprintf("%06d", $elite_quote_request->id);
			$product_name = $product_name ? $product_name : "NA";
			
			$file_attachment = array();
			foreach(glob(_PS_ROOT_DIR_."/EliteQuotation/quotations/".$id.".*") as $file){
				$ext = end(explode(".", $file));
				$file_root = $file;
	            $file_size = filesize($file_root);
	            $handle = fopen($file_root, "r");
	            $content = fread($handle, $file_size);
	            fclose($handle);
	           // $content = chunk_split(base64_encode($content));
	            $attach['content'] = $content;
	        	$attach['name'] = sprintf('%06d', $id)."_quotation.".$ext;
	            $attach['mime'] = $this->getMimeType($ext);
	            array_push($file_attachment, $attach);
			}
			foreach(glob(_PS_ROOT_DIR_."/EliteQuotation/attachment/".$id.".*") as $file){
				$ext = end(explode(".", $file));
	            $file_size = filesize($file);
	            $handle = fopen($file, "r");
	            $content = fread($handle, $file_size);
	            fclose($handle);
	           // $content = chunk_split(base64_encode($content));
	            $attach['content'] = $content;
	        	$attach['name'] = sprintf('%06d', $id)."_attachmnent.".$ext;
	            $attach['mime'] = $this->getMimeType($ext);
	            array_push($file_attachment, $attach);
			}
			if($image == true){
    			$image_root = _PS_ROOT_DIR_."/EliteQuotation/".$id.".zip";
                $file_size = filesize($image_root);
                $handle = fopen($image_root, "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                // $content = chunk_split(base64_encode($content));
                $attach['content'] = $content;
            	$attach['name'] = sprintf('%06d', $id).".zip";
                $attach['mime'] = 'application/zip';
                array_push($file_attachment, $attach);
			}
            
			$period_name = "";
			if($period == 1){
				$period_name = "Weekly";
			}
			elseif ($period == 2) {
				$period_name = "Monthly";
			}
			else{
				$period_name = "Quaterly";
			}

			$oneTime = "";
			if($regular == 1){
				$oneTime = "One Time";
				$period_name="--";
			}
			elseif ($regular == 2) {
				$oneTime = "Regular";
			}

			$urgency = "";
			if($immediately == 1){
				$urgency = "Immediately";
			}
			elseif ($immediately == 2) {
				$urgency = "After a Month";
			}
            $city = json_decode($this->context->cookie->search_zone)->selectedArea;
			$mailData = array(
				'{quotation_ref}' => sprintf('%06d', $id),
                '{product}' => $product_name,
                '{category}' => $name_category,
                '{description}' => $description,
                '{quantity}' => $qty,
                '{deadline}' => date_format(date_create($date),"Y-m-d"),
                '{oneTime}' => $oneTime,
                '{frequency}' => $period_name,
                '{urgency}' => $urgency,
                '{payment}' => $payment,
                '{user}' => $customer->firstname,
                '{location}' => $city ? $city: "NA",
                );
			$mail = Mail::Send(1, 'elite_custom_quotation', $subject, $mailData, "vijayashanthi@kobster.com", null, null, null, $file_attachment);
			die(json_encode(array('success' => true, 'reference' =>sprintf("%06d", $elite_quote_request->id))));
		}
		if($type == 7){
            $id_customer = $_GET['id_customer'];
            $id_customer = $id_customer ?$id_customer: $this->context->cookie->id_customer;
            $intervalOption = $_GET['intervalOption'];
            $quoteQuantity = $_GET['quoteQuantity'];
            $buyingPeriod = $_GET['buyingPeriod'];
            $immediately = $_GET['immediately'];
            // $suppliers = $_GET['suppliers'];
            $deadline = $_GET['deadline'];
            $payment = $_GET['payment'];
            $credit = $_GET['credit'];  
            $id_product = $_GET['id_product'];  
            $product = new Product($id_product);
            $db_payment = $payment;

            if($payment == 1){
                    $payment = "Advance";
              }
            elseif ($payment == 2) {
                    $payment = "On Delivery";
            }
            elseif ($payment == 0) {
                    if($credit == 1){
                        $payment ="credit - 7 days";    
                        $db_payment = 3;
                    }
                    else if($credit == 2){
                        $payment ="credit - 30 days";    
                        $db_payment = 4;
                    }
                    else if($credit == 3){
                        $payment ="credit - 45 days";    
                        $db_payment = 5;
                    }
                    
            }

            $city = json_decode($this->context->cookie->search_zone)->selectedArea;
            // var_dump(date_format(date_create($deadline),"Y-m-d"));
            $elite_quote_request = new EliteQuoteRequest();
            $elite_quote_request->id_customer= $this->context->cookie->id_customer;
            $elite_quote_request->id_product= $id_product;
            if(isset($intervalOption) && $intervalOption > 0){
                $elite_quote_request->period=$intervalOption;
            }
            $elite_quote_request->frequency=$buyingPeriod;
            
            $elite_quote_request->quantity=$quoteQuantity;
            $elite_quote_request->need= $immediately;
            $elite_quote_request->deadline=date_format(date_create($deadline),"Y-m-d");
            $elite_quote_request->payment=$db_payment; 
            $elite_quote_request->postcode=json_decode($this->context->cookie->search_zone)->postcode;
            $elite_quote_request->add();

            $quoteHistory = new EliteQuoteHistory();
            $quoteHistory->id_quote_request = $elite_quote_request->id;
            $quoteHistory->id_quote_status = EliteQuoteHistory::IN_PROCESS;
            $quoteHistory->add();
            $suppliers = EliteSupplierProducts::getSuppliersForQuotation($id_product, false, true,json_decode($this->context->cookie->search_zone)->postcode);
            
            $subject = "Quotation request from kobster market place ( QUOTATION : #".sprintf("%06d", $elite_quote_request->id).")";
            $quote_table = "elite_quote_request";
            foreach($suppliers as $supplier){
                    $dbData = array(
                            'id_customer'           =>$id_customer,
                            'id_supplier'            =>$supplier,
                            'id_quote_request'      =>$elite_quote_request->id

                            );
                    $result_db = Db::getInstance()->insert($quote_table, $dbData);
                    $sup = new EliteSupplier($supplier);
                    $mailData = array(
                            '{product_name}' => $product->name['1'],
                            '{quantities}' => $quoteQuantity,
                            '{deadline}' => $deadline,
                            '{payment}' => $payment,
                            '{city}' => $this->context->cookie->search_zone ? $city : "NA",
                            );
                    Mail::Send(1, 'elite_quotation_invite', $subject, $mailData, $sup->email, $sup->name, null, "Kobster Market Place - Quotation Request");
            }
            if(sizeof($suppliers) > 0){
                $suppliers ='<tr><td align="left" style="font-family: Helvetica, Arial, sans-serif; font-weight: bold; font-size: 16px; line-height:16px; color: #666666; text-align:left;padding-left: 30px; padding-right: 30px; padding-top:0px; padding-bottom: 0px;">Suppliers: '.sizeof($suppliers).' Received Quotation</td>
                  </tr>';
            }
            else{
                $suppliers ='<tr><td align="left" style="font-family: Helvetica, Arial, sans-serif; font-weight: bold; font-size: 16px; line-height:16px; color: #DC2D3C; text-align:left;padding-left: 30px; padding-right: 30px; padding-top:0px; padding-bottom: 0px;">Suppliers: No Suppliers Found</td>
                  </tr>';        
            }
            $customerDetails = new Customer($id_customer);
            $mailData = array(
                    '{customer}' => $customerDetails->firstname." (".$customerDetails->email.")",
                    '{product_name}' => $product->name['1'],
                    '{quantities}' => $quoteQuantity,
                    '{deadline}' => $deadline,
                    '{payment}' => $payment,
                    '{suppliers}'=> $suppliers,
                    '{city}' => $this->context->cookie->search_zone ? $city : "NA",
                    );
            Mail::Send(1, 'elite_quotation_invite_internal', $subject, $mailData, "arumugasamy@kobster.com", null, null, "Kobster Market Place - Buyer Raised Quotation");
            die(
                json_encode(
                array(
                    'success' => 1,
                    'reference' =>sprintf("%06d", $elite_quote_request->id)
                    )
                ));
		}
		if($type == 8){
			$id = $_GET['id'];
			$quoteHistory = new EliteQuoteHistory();
            $quoteHistory->id_quote_request = $id;
            $quoteHistory->id_quote_status = EliteQuoteHistory::CANCELLED;

            if($quoteHistory->add()){
            	$elite_quote_request = new EliteQuoteRequest($id);
            	$reference = sprintf("%06d", $elite_quote_request->id);
            	$subject = "Quotation (#".$reference.") cancel request";
            	$context = Context::getContext();
            	$customer = new Customer($context->cookie->id_customer);
            	$mailData = array(
                            '{customer}' => $customer->firstname." (".$customer->email.")",
                            );
            	Mail::Send(1, 'elite_quotation_cancel_internal', $subject, $mailData, "arumugasamy@kobster.com", null, null, "Kobster Market Place - Buyer Cancelled Quotation");
            	die(json_encode(array('success' => "Quotation requests cancelled")));
            }
            else{
            	die(json_encode(array('error' => "Unable to cancel the quotation request, pleast contact the support team")));
            }
		}
	}

	public function getMimeType($extension){
		switch ($extension) {
			case 'jpg':
				return 'image/jpeg';
				break;
			case 'jpeg':
				return 'image/jpeg';
				break;
			case 'png':
				return 'image/png';
				break;
			case 'xlsx':
				return 'application/excel';
				break;
			case 'xls':
				return 'application/excel';
				break;
			case 'csv':
				return 'application/excel';
				break;
			case 'pdf':
				return 'application/pdf';
				break;
			case 'doc':
				return 'application/msword';
				break;
			case 'docx':
				return 'application/msword';
				break;
			case 'txt':
			    return 'text/plain';
			    break;
			default:
				return '';
				break;
		}
	}
}
<?php
/*
*
* Supplier main controller
*
*/
class SupplierQuotationControllerCore extends FrontController 
{
	public function ajaxReturn() 
	{
		$type = $_GET['type'];
		if($type == 1){
			$query = $_GET['query'];
			$page = $_GET['page'];
			$sort = $_GET['sort'];
			$context = Context::getContext();
			$supplier = new EliteSupplier($context->cookie->s_id);
			die(json_encode(array(
				'success'=>$supplier->getQuotationRequests($query, $page, $sort),
				'count'=>$supplier->getQuotationRequestsCount($context->cookie->s_id, $query, $page, $sort)
				)));
		}
		if($type == 2){
			$id_quote_request = $_GET['id_quote_request'];
			$context = Context::getContext();
			$id_supplier = $context->cookie->s_id;
			$expiry = $_GET['expiryDate'];
			$expiry = date("Y-m-d", strtotime($expiry));
			$lowPrice = $_GET['lowPrice'];
			$name = $_GET['name'];
			$quantity = $_GET['quantity'];
			$id_customer = $_GET['id_customer'];
			$cus = new Customer($id_customer);

			$quote_table = 'elite_quote_request';
			$dbData = array(
                'expiry'           => $expiry,
                'low_Price'            => $lowPrice,
            );
            $where = 'id_supplier='.$id_supplier.' and id_quote_request='.$id_quote_request;
            if(Db::getInstance()->update($quote_table, $dbData, $where))
            {
            	if(!EliteQuoteHistory::isQuoted($id_quote_request)){
	            	$quoteHistory = new EliteQuoteHistory();
		            $quoteHistory->id_quote_request = $id_quote_request;
		            $quoteHistory->id_quote_status = EliteQuoteHistory::RESPONSE_RECEIVED;
		            $quoteHistory->add();
		        }
                $mailData = array(
                        '{expiry_date}' 		=> $expiry,
                        '{price}' 		=> $lowPrice,
                        '{product_name}' 		=> $name,
                        '{quantities}' 	=> $quantity
                        );
                // var_dump($mailData)
                // var_dump($cus);
                $subject = 'kobzo Market Place - Quotation Response - QUOTATION: #'.sprintf("%06d", $id_quote_request).')';
            	Mail::Send(1, 'supplier_quote_response', $subject, $mailData, $cus->email, $cus->firstname, null, "kobzo Market Place - Quotation Response");
            	die(json_encode(array('success' => 1)));
            }
            else{
            	die(json_encode(array('error' => 1)));
            }
		}
		if($type == 3){
			$id_quote_request = $_GET['id_quote_request'];
			$context = Context::getContext();
			$id_supplier = $context->cookie->s_id;

			$quote_table = 'elite_quote_request';
			$dbData = array(
                'denied'=> 1,
            );
            $where = 'id_supplier='.$id_supplier.' and id_quote_request='.$id_quote_request;
            if(Db::getInstance()->update($quote_table, $dbData, $where)){
            	die(json_encode(array('success' => 1)));
            }
            else{
            	die(json_encode(array('error' => 1)));
            }	
		}
		if($type == 4){
			$type = $_GET['type'];
			$query = $_GET['query'];
			$page = $_GET['page'];
			$limit = $_GET['limit'];

			$context = Context::getContext();
			$supplier = new EliteSupplier($context->cookie->s_id);
			$lists = $supplier->getAcceptedCustomer($query, $page, $limit);
			$count = $supplier->getAcceptedCustomerCount($query, $page, $limit);
			die(json_encode(
				array(
					'success' => true,
					'lists' => $lists,
					'count' => $count,
				)));
		}

		if($type == 5){
			$option = $_GET['option'];
			$id_quote_request = $_GET['id_quote_request'];

			if($option == 1){
				$context = Context::getContext();
				$elite_quote_request = new EliteQuoteRequest($id_quote_request);
				$supplier = new EliteSupplier($context->cookie->s_id);
				$customer = new Customer($elite_quote_request->id_customer);

				$price = $supplier->getQuotePrice($id_quote_request)[0]['price'];
				$id_supplier = $supplier->id;
				$expiry = $supplier->getQuotePrice($id_quote_request)[0]['expiry'];
                $logger = new FileLogger();
                $logger->setFilename("testbo.txt");
                $logger->logError("type 5 option 1");
				// add supplier and product rate contract
				if(SpecificPrice::addSpecificPrice($price, $id_supplier, $elite_quote_request->id_product, $customer->id_default_group, $expiry)){
				    $id_zone = Db::getInstance()->ExecuteS("select zone_id from "._DB_PREFIX_."pincode_master where zone_pin_start <= ".$elite_quote_request->postcode." and zone_pin_end >= ".$elite_quote_request->postcode);
                    $logger->logError("select zone_id from "._DB_PREFIX_."pincode_master where zone_pin_start <= ".$elite_quote_request->postcode." and zone_pin_end >= ".$elite_quote_request->postcode);
                    $logger->logError($id_zone);
                    $logger->logError($elite_quote_request->quoted);
                    $logger->logError($elite_quote_request->id_product);
                    EliteSupplierProducts::addStockDetails($elite_quote_request->quoted, $elite_quote_request->id_product);
                    EliteSupplierProducts::addZoneDetails($elite_quote_request->quoted, $elite_quote_request->id_product, $id_zone[0]['zone_id']);
                    
					$quoteHistory = new EliteQuoteHistory();
		            $quoteHistory->id_quote_request = $id_quote_request;
		            $quoteHistory->id_quote_status = EliteQuoteHistory::RATECONTRACT_ADDED;
		            if($quoteHistory->add()){
		                $logger->logError($context->cookie->s_id." === ". $customer->id_default_group);
		                $logger->logError(EliteSupplierCustomer::isTagged($context->cookie->s_id, $customer->id_default_group));
		                $logger->logError(!EliteSupplierCustomer::isTagged($context->cookie->s_id, $customer->id_default_group));
		                if(!EliteSupplierCustomer::isTagged($context->cookie->s_id, $customer->id_default_group)){
			            	$esc = new EliteSupplierCustomer();
			            	$esc->id_supplier = $context->cookie->s_id;
			            	$esc->id_group = $customer->id_default_group;
			            	$esc->add();
			            }
		            	
		            	$product = new Product($elite_quote_request->id_product);
		            	$subject = 'Supplier is ready to serve you - kobzo Market Place - QUOTATION: #'.sprintf("%06d", $elite_quote_request->id).')';
		            	$mailData = array(
		            		'{customer}' => $customer->firstname." (".$customer->email.")",
		            		'{customer_name}' => $customer->firstname,
                            '{product_name}' => $product->name['1']." | ".$product->reference,
                            '{quantities}' => $elite_quote_request->quantity,
                            '{price}' => $price,
                            '{expiry}' => $expiry,
                            '{supplier}' => $supplier->company,
                            '{supplier_address}' => EliteSupplierAddress::getSupplierAddress($supplier->id),
                            );
                    	Mail::Send(1, 'supplier_accepted_customer', $subject, $mailData, $customer->email, $customer->name, null, "Supplier is ready to serve you - kobzo Market Place");

                    	Mail::Send(1, 'supplier_accepted_customer_internal', $subject, $mailData, "vijayashanthi@kobzo.com", null, null, "Supplier is ready to serve you - kobzo Market Place");

		            	die(json_encode(array("success" => "Product added to buyer's rate contract")));
		            }
				}
			}
			else if($option == 2){
				$quoteHistory = new EliteQuoteHistory();
	            $quoteHistory->id_quote_request = $id_quote_request;
	            $quoteHistory->id_quote_status = EliteQuoteHistory::REJECTED_BY_SUPPLIER;
	            
	            $context = Context::getContext();
				$elite_quote_request = new EliteQuoteRequest($id_quote_request);
				$supplier = new EliteSupplier($context->cookie->s_id);
				$customer = new Customer($elite_quote_request->id_customer);

	            $subject = 'Supplier rejected your contract request - kobzo Market Place - Quotation #'.sprintf('%06d', $id_quote_request);
	            $mailData = array(
            		'{customer_name}' => $customer->firstname,
            		'{customer}' => $customer->firstname." (".$customer->email.")",
            		'{reference}' => sprintf('%06d', $id_quote_request),
                    );
				Mail::Send(1, 'supplier_rejected_customer', $subject, $mailData, $customer->email, null, null);
				Mail::Send(1, 'supplier_rejected_customer_internal', $subject, $mailData, "vijayashanthi@kobzo.com", null, null);

	            if($quoteHistory->add()){
	            	die(json_encode(array("success" => "Quotation contract rejected successfully")));
				}
			}
		}
	}
}
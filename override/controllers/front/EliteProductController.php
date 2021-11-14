<?php
class  EliteProductControllerCore extends FrontController {

        public function ajaxReturn(){
                $id_product = $_GET['id_product'];
                $type = $_GET['type'];
                if($type == 1){
                        $product = new Product($id_product);
                        $link_rewrite = $product->link_rewrite['1'];
                        $product_props = Product::getProductPropertiesSupplier(1,array('id_product' => $id_product, 'link_rewrite'=>$link_rewrite));   
                        $name = htmlspecialchars($product->name['1']);
                        $name = str_replace(",","",$name);
                        $product_details = array(
                                'id_product'=>$product->id,
                                'name'=>$name,
                                'reference' => $product->reference,
                                'description' => $product->description['1'],
                                'price'=> $product->price,
                                'ratings'=> $product_props['ratings']['grade'],
                                'features'=>$product_props['features'],
                                'img'=>$product_props['imageLink']
                                );                        
                        $zone = $_GET['zone'];
                        $context = Context::getContext();
                        $postcode = "";
                        if(!$context->cookie->search_zone || (json_decode($zone)->postcode != "" && json_decode($context->cookie->search_zone)->postcode != json_decode($zone)->postcode)){
                                $context->cookie->search_zone = $zone;
                        }
                        if($context->cookie->search_zone){
                                $postcode = json_decode($context->cookie->search_zone)->postcode;
                        }
                        $supplier_details = EliteSupplierZone::getSuppliersDetails($id_product, $postcode);
                        $zone_result = sizeof(json_decode($context->cookie->search_zone)) ? json_decode($context->cookie->search_zone) : array("trigger"=>true);
                        die(json_encode(array('product_details' => $product_details,'supplier_details'=>$supplier_details, 'zone' => $zone_result )));
                }
                if($type == 2){
                        $zone = $_GET['zone'];
                        $context = Context::getContext();
                        $postcode = "";
                        if(!$context->cookie->search_zone || (json_decode($zone)->postcode != "" && json_decode($context->cookie->search_zone)->postcode != json_decode($zone)->postcode)){
                                $context->cookie->search_zone = $zone;
                        }
                        if($context->cookie->search_zone){
                                $postcode = json_decode($context->cookie->search_zone)->postcode;
                        }
                        $supplier_details = EliteSupplierZone::getSuppliersDetails($id_product, $postcode);
                        die(json_encode(array('supplier_details'=>$supplier_details, 'zone' => json_decode($context->cookie->search_zone) )));       
                }
                if($type == 3){
                        $context = Context::getContext();
                        $id_customer = $_GET['id_customer'];
                        $id_customer = $id_customer ?$id_customer: $context->cookie->id_customer;
                        $intervalOption = $_GET['intervalOption'];
                        $quoteQuantity = $_GET['quoteQuantity'];
                        $buyingPeriod = $_GET['buyingPeriod'];
                        $immediately = $_GET['immediately'];
                        $suppliers = $_GET['suppliers'];
                        $deadline = $_GET['deadline'];
                        $payment = $_GET['payment'];
                        $credit = $_GET['credit'];                        
                        $product = new Product($id_product);
                        $subject = "Quotation request from kobster market place";
                        $db_payment = $payment;

                        if($payment == 1){
                                $payment = "Advance";
                          }
                        elseif ($payment == 2) {
                                $payment = "On Delivery";
                        }
                        elseif ($payment == 0) {
                                $db_payment = $credit==1?3 : $credit == 2 ? 4 : 5;
                                $payment ="credit - ".$credit==1? "7 Days" : $credit == 2 ? "30 Days" : "45 Days";
                        }

                        $city = json_decode($context->cookie->search_zone)->selectedArea;
                        // var_dump(date_format(date_create($deadline),"Y-m-d"));
                        $elite_quote_request = new EliteQuoteRequest();
                        $elite_quote_request->id_customer= $this->context->cookie->id_customer;
                        $elite_quote_request->id_product= $id_product;
                        $elite_quote_request->period=$intervalOption;
                        $elite_quote_request->frequency=$buyingPeriod;
                        $elite_quote_request->quantity=$quoteQuantity;
                        $elite_quote_request->need= $immediately;
                        $elite_quote_request->deadline=date_format(date_create($deadline),"Y-m-d");
                        $elite_quote_request->payment=$db_payment; 
                        $elite_quote_request->postcode=json_decode($context->cookie->search_zone)->postcode;
                        $elite_quote_request->add();

                        $quote_table = "elite_quote_request";
                        foreach(explode(",",$suppliers) as $supplier){
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
                                        '{city}' => $context->cookie->search_zone ? $city : "NA",
                                        );
                                Mail::Send(1, 'elite_quotation_invite', $subject, $mailData, $sup->email, $sup->name, null, "Kobster Market Place - Quotation Request");
                        }
                        die(json_encode(array('success' => 1)));
                }
        }
}
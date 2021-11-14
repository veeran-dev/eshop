<?php
/*
*
* Elite Supplier Master
*
*/
class EliteSupplierCore extends ObjectModel
{
    /** @var String name of supplier */
    public $name;

    /** @var String email */
    public $email;

    /** @var int mobile number  */
    public $mobile;

    /** @var string password */
    public $passwd;

    /** @var bool active */
    public $active;

    /** @var string reference */
    public $reference;

    /** @var bool active */
    public $company;

    public static $definition = array(
        'table' => 'elite_supplier',
        'primary' => 'id_supplier',
        'multilang' => false,      
        'fields' => array(
            /* EliteSupplier master */
            'name' =>   array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
            'email' =>  array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 45),
            'mobile' => array('type' => self::TYPE_INT, 'required' => true),
            'passwd' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isPasswd', 'size' => 32),
            'active'    =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'company' =>   array('type' => self::TYPE_STRING),
            'reference' =>   array('type' => self::TYPE_STRING),

        )
    );

    public static function getAllSupplier(){
        $sql = "select id_supplier, company from "._DB_PREFIX_."elite_supplier";
        return Db::getInstance()->ExecuteS($sql);
    }

    public function addChild($id_parent){
        return Db::getInstance()->insert('elite_supplier_child', array('id_supplier' => $id_parent, 'id_child' => $this->id));   
    }
    
    public function logout()
    {
        if (isset(Context::getContext()->cookie)) {
            Context::getContext()->cookie->logout();
            Context::getContext()->cookie->write();
        }
        $this->id = null;
    }

    public function isChild(){
        $sql = "SELECT * FROM `kob_elite_supplier_child` WHERE id_supplier=".$this->id;
        return Db::getInstance()->Executes($sql);
    }

    public static function validateRegistration($email, $mobile){
        $auth_query = "select * from "._DB_PREFIX_."elite_supplier where email like '".$email."' OR mobile like '".$mobile."'";
        $result = Db::getInstance()->getRow($auth_query);
        return $result['id_supplier'] != undefined && $result['id_supplier'] >0 ? true : false;   
    }
    public static function checkAuth($passwd, $email){
        $auth_query = "select * from "._DB_PREFIX_."elite_supplier where email like '".$email."' and passwd like '".Tools::encrypt($passwd)."' and active=1";
        $result = Db::getInstance()->getRow($auth_query);
        return new EliteSupplier($result['id_supplier']);
    }
    public static function checkEmail($email){
        $auth_query = "select * from "._DB_PREFIX_."elite_supplier where email like '".$email."'";
        $result = Db::getInstance()->getRow($auth_query);
        return new EliteSupplier($result['id_supplier']);
    }
 
    public function getDeliveryNumber(){
        $auth_query = "select dr_number from "._DB_PREFIX_."elite_supplier_configuration where id_supplier=".$this->id;
        $result = Db::getInstance()->getRow($auth_query);
        return $result['dr_number']?$result['dr_number']:"1";
    }

    public function setDeliveryNumber($number){
        $update_query ="update "._DB_PREFIX_."elite_supplier_configuration set dr_number='".$number."' where id_supplier=".$this->id;
        $result = Db::getInstance()->Execute($update_query);
        return $result;
    }

    public function getDeliveryPrefix(){
        $auth_query = "select dr_prefix from "._DB_PREFIX_."elite_supplier_configuration where id_supplier=".$this->id;
        $result = Db::getInstance()->getRow($auth_query);
        return $result['dr_prefix']?$result['dr_prefix']:"DE";
    }
    
    public function setDeliveryPrefix($number){
        $update_query ="update "._DB_PREFIX_."elite_supplier_configuration set dr_prefix='".$number."' where id_supplier=".$this->id;
        $result = Db::getInstance()->Execute($update_query);
        return $result;
    }
    
    public function drConfiguration($prefix, $number){
        $old_dr_number = $this->getDeliveryNumber();
        $old_dr_prefix = $this->getDeliveryPrefix();
        if($old_dr_number == 1 && $old_dr_prefix == "DE"){
            $sql ="INSERT into "._DB_PREFIX_."elite_supplier_configuration (id_supplier, dr_prefix, dr_number) values(".$this->id.",'".$prefix."',".$number.")";
            $result = Db::getInstance()->Execute($sql);
            return $result ? true:false;
        }
        $x = true;
        $y =true;
        if($old_dr_number != $number){
            $x = $this->setDeliveryNumber($number);
        }
        if($old_dr_prefix != prefix){
            $y =$this->setDeliveryPrefix($prefix);
        }
        return $x && $y;
    }

    /**
    *
    * Send order email confirmation to suppliers
    * @param 
    * @return bool
    */
    public function triggerOrderConfEmail($data = array(), $order, $id_lang, $id_shop) {
        if($this->email) {
            $em_sub = 'New Order from '.$data['{delivery_company}'].' Order ID #'.$order->id.'';
            Mail::Send((int)$id_lang, 'order_conf_supplier', Mail::l($em_sub, (int)$id_lang) , $data, $this->email, $this->name);
        }

        if($this->mobile) {
            $msgtxt = 'Hey '.$this->name.', You just got a new order # '.$order->id.' from '.$data['{delivery_company}'].'. You can manage your orders at '.Tools::getShopDomain().'/supplier';
            SMSAlert::sendSMSAlert($this->mobile, $msgtxt);
        }
    }

    public static function isSupplierEmailExists($email) {
        return Db::getInstance()->getValue('SELECT IF(id_supplier > 0, true, false) AS email_exists 
            FROM `'._DB_PREFIX_.'elite_supplier` 
            WHERE email = \''.pSQL($email).'\''
        );  
    }

    public function getQuotationRequests($query, $page, $sort){
        $query = $query != '' ? " and pl.name like '%".$query."%' ":"";
        $start  = $page*10;
        $end    = 10;
        $page   = " limit ".$start.",".$end."";

        // print_r($sort);
        $orderBy = "";
        if($sort == 1){
            $orderBy= "ORDER BY details.deadline ASC";
        }
        else if($sort == 2){
            $orderBy = "ORDER BY details.id_quote_request DESC";
        }
        $today = date("Y-m-d");
        $sql ="SELECT kqh.id_quote_status, details.*,pl.*,p.`reference`,p.`price`,quote.`id_customer`,
                        DATE_FORMAT(details.deadline, '%d, %b %Y') as deadline,
                        (CASE WHEN details.period = 1 then 'One Time' WHEN details.period = 2 THEN details.frequency END) as buying_interval,
                        (CASE WHEN details.need = 1 then 'Immediately' WHEN details.need = 2 THEN 'In 1 Month' END) as purchase,
                        (select zone_name from "._DB_PREFIX_."pincode_master where zone_pin_start <= details.postcode and zone_pin_end >= details.postcode) as location,
                        (CASE WHEN payment=1 THEN 'Advance' WHEN payment=2 then 'On Delivery' WHEN payment=3 then 'Credit - 7 days' WHEN payment=4 then 'Credit - 30 days' WHEN payment=5 then 'Credit - 45 days' END) as payment
                        from "._DB_PREFIX_."elite_quote_request quote 
                        LEFT JOIN "._DB_PREFIX_."elite_quote_request_details details on details.id_quote_request=quote.id_quote_request
                        LEFT JOIN "._DB_PREFIX_."product_lang pl on pl.id_product=details.id_product and pl.id_lang=1
                        LEFT JOIN "._DB_PREFIX_."product p on p.id_product=details.id_product
                        LEFT JOIN "._DB_PREFIX_."quote_history kqh ON kqh.id_quote_request=details.id_quote_request
                        WHERE quote.id_supplier=".$this->id." and quote.denied=0 and quote.low_price=0 
                        AND kqh.id_quote_history IN(SELECT MAX(id_quote_history) FROM kob_quote_history WHERE id_quote_request=details.id_quote_request)  
                        AND kqh.id_quote_status NOT IN(4)
                        AND details.deadline >= '".$today."'
                        ".$query." ".$orderBy." ".$page."";
        // print_r($sql);
        $results = Db::getInstance()->ExecuteS($sql);
        foreach ($results as &$result) {
            $coverImage = Image::getCover($result['id_product']);
            $result['cover'] = $result['id_product'].'-'.$coverImage['id_image'];
            if (!$coverImage['id_image'])
            $result['cover'] = Language::getIsoById((int)($id_lang)).'-default';

            $linkObj = new Link();
            $result['imageLink2'] = $linkObj->getImageLink($result['link_rewrite'], $result['cover'], 'large');
            if($result['buying_interval'] == 1 || $result['buying_interval'] == 2 || $result['buying_interval'] == 3 ){
                $result['buying_interval'] = $result['buying_interval'] == 1 ? "Weekly" : $result['buying_interval'] == 2 ? "Monthly" : "Quaterly";
            }
            
        }
        return $results;
    }

    public function getQuotationRequestsCountCustomer($id_customer, $query, $limit, $page, $sort){
        $count_sql ="SELECT count(DISTINCT(details.`id_quote_request`)) as count
                                    from "._DB_PREFIX_."elite_quote_request_details details
                                    LEFT JOIN "._DB_PREFIX_."quote_history kqh ON kqh.id_quote_request=details.id_quote_request
                                    WHERE kqh.id_quote_history IN(SELECT MAX(id_quote_history) FROM kob_quote_history WHERE id_quote_request=details.id_quote_request)  
                                    AND details.id_customer=".$id_customer."";
        // print_r($count_sql);
        $result_count = Db::getInstance()->ExecuteS($count_sql);
        return $result_count;
    }

    public static function getQuotationRequestsCustomers($id_customer, $query, $limit, $page, $sort){
        $start  = $page*$limit;
        $end    = $limit;
        $page   = " limit ".$start.",".$end."";
        $sql ="SELECT kqd.id_quote_request, 
                    (CASE 
                     WHEN keqr.id_quote_request != '' THEN 1 
                     WHEN kqd.product_name != '' THEN 2 
                     ELSE 3 END) as type,
                    LPAD(kqd.id_quote_request, 6, '0') as ref,
                    kqd.`categories`,
                    kqd.`product_name`,
                    kqd.`quantity`,
                    kqd.`description`,
                    kqd.`date_add` as created,
                    DATE_FORMAT(kqd.`deadline`, '%Y-%m-%d') as deadline,
                    kqsl.`name` as status,
                    pl.`id_product`, pl.`name` as pname,pl.`link_rewrite`,p.`reference` as code
                    FROM `kob_elite_quote_request_details` kqd
                    LEFT JOIN kob_elite_quote_request keqr ON keqr.id_quote_request=kqd.id_quote_request
                    LEFT JOIN kob_quote_history kqh ON kqh.id_quote_request=kqd.id_quote_request
                    LEFT JOIN kob_quote_status_lang kqsl ON kqsl.id_quote_status=kqh.id_quote_status
                    LEFT JOIN "._DB_PREFIX_."product_lang pl on pl.id_product=kqd.id_product and pl.id_lang=1
                    LEFT JOIN "._DB_PREFIX_."product p on p.id_product=kqd.id_product
                    WHERE kqd.id_customer=".$id_customer."
                    AND kqh.id_quote_history IN(SELECT MAX(id_quote_history) FROM kob_quote_history WHERE id_quote_request=kqd.id_quote_request)
                    GROUP BY kqd.id_quote_request ORDER BY kqd.id_quote_request DESC ".$page;
        $logger=new FileLogger();
        $logger->setFilename("test1.txt");
        $logger->logError("query");
        // $logger->logError($sql);

        $rootPath = _PS_ROOT_DIR_."/EliteQuotation";
        $results = Db::getInstance()->ExecuteS($sql);
        // $logger->logError($results);
        foreach ($results as &$result) {
            if($result['id_product']){
                $coverImage = Image::getCover($result['id_product']);
                $result['cover'] = $result['id_product'].'-'.$coverImage['id_image'];
                if (!$coverImage['id_image'])
                $result['cover'] = Language::getIsoById((int)($id_lang)).'-default';

                $linkObj = new Link();
                $result['imageLink2'] = $linkObj->getImageLink($result['link_rewrite'], $result['cover'], 'medium');    
            }

            foreach(glob($rootPath."/quotations/".$result['id_quote_request'].".*") as $file){
                $ext = end(explode(".", $file));    
                $result['quotation_file'] = "./EliteQuotation/quotations/".$result['id_quote_request'].".".$ext;
            }    

            foreach(glob($rootPath."/".$result['id_quote_request'].".zip") as $file){
                $result['quotation_image'] = "./EliteQuotation/".$result['id_quote_request'].".zip";
            }

            foreach(glob($rootPath."/attachment/".$result['id_quote_request'].".*") as $file){
                $ext = end(explode(".", $file));    
                $result['quotation_attachment'] = "./EliteQuotation/attachment/".$result['id_quote_request'].".".$ext;    
            }
            if($result['categories']){
                $result['categories']= Category::getCategoryName($result['categories']);
            }
            
        }
        // $logger->logError($results);
        return $results;
    }

    public static function getQuotationRequestsCount($id_supplier, $query, $page, $sort){
        $query = $query != '' ? " and pl.name like '%".$query."%' ":"";
        $start = $page*10;
        $end = $start + 10;
        $page =" limit ".$start.",".$end."";
        $orderBy = $sort == 1 ? "ORDER BY details.deadline ASC": "ORDER BY details.id_quote_request DESC";
        $today = date("Y-m-d");
        $count_sql ="SELECT count(details.`id_quote_request`) as count
                                                from "._DB_PREFIX_."elite_quote_request quote 
                                                LEFT JOIN "._DB_PREFIX_."elite_quote_request_details details on details.id_quote_request=quote.id_quote_request
                                                LEFT JOIN "._DB_PREFIX_."product_lang pl on pl.id_product=details.id_product and pl.id_lang=1
                                                LEFT JOIN "._DB_PREFIX_."product p on p.id_product=details.id_product
                                                WHERE quote.id_supplier=".$id_supplier." and quote.denied=0 and quote.low_price=0 AND details.deadline >= '".$today."'
                                                ".$query."";
        // print_r($count_sql);
        $result_count = Db::getInstance()->ExecuteS($count_sql);
        return $result_count;
    }
    
    public function getQuotationSubmitted(){
        $count_sql ="SELECT count(details.`id_quote_request`) as count
                                                from "._DB_PREFIX_."elite_quote_request quote 
                                                LEFT JOIN "._DB_PREFIX_."elite_quote_request_details details on details.id_quote_request=quote.id_quote_request
                                                LEFT JOIN "._DB_PREFIX_."product_lang pl on pl.id_product=details.id_product and pl.id_lang=1
                                                LEFT JOIN "._DB_PREFIX_."product p on p.id_product=details.id_product
                                                WHERE quote.id_supplier=".$this->id." 
                                                AND quote.denied =0 
                                                AND quote.low_price > 0 
                                                AND details.quoted = 0";
        // print_r($count_sql);
        $result_count = Db::getInstance()->ExecuteS($count_sql);
        return $result_count;
    }

    public static function getQuotationRequestsDetails($id_quotation){
        $sql = "select details.*,pl.*,p.`reference`,p.`price`,quote.`id_customer`,
                    DATE_FORMAT(details.deadline, '%d, %b %Y') as deadline, details.quoted,
                    (CASE WHEN details.period = 1 then 'One Time' WHEN details.period = 2 THEN details.frequency END) as buying_interval,
                    (CASE WHEN details.need = 1 then 'Immediately' WHEN details.need = 2 THEN 'In 1 Month' END) as purchase,
                    (select zone_name from "._DB_PREFIX_."pincode_master where zone_pin_start <= details.postcode and zone_pin_end >= details.postcode) as location,
                    (CASE WHEN payment=1 THEN 'Advance' WHEN payment=2 then 'On Delivery' WHEN payment=3 then 'Credit - 7 days' WHEN payment=4 then 'Credit - 30 days' WHEN payment=5 then 'Credit - 45 days' END) as payment,
                    (SELECT id_state FROM "._DB_PREFIX_."pincode_master WHERE zone_pin_start <= details.postcode and zone_pin_end >= details.postcode) as id_state 
                        from "._DB_PREFIX_."elite_quote_request quote 
                        LEFT JOIN "._DB_PREFIX_."elite_quote_request_details details on details.id_quote_request=quote.id_quote_request
                        LEFT JOIN "._DB_PREFIX_."product_lang pl on pl.id_product=details.id_product and pl.id_lang=1
                        LEFT JOIN "._DB_PREFIX_."product p on p.id_product=details.id_product
                        WHERE quote.id_quote_request=".$id_quotation."" ;
        // print_r($sql);
        $results = Db::getInstance()->ExecuteS($sql);
        foreach ($results as &$result) {
            $coverImage = Image::getCover($result['id_product']);
            $result['cover'] = $result['id_product'].'-'.$coverImage['id_image'];
            if (!$coverImage['id_image'])
            $result['cover'] = Language::getIsoById((int)($id_lang)).'-default';

            $linkObj = new Link();
            $result['imageLink2'] = $linkObj->getImageLink($result['link_rewrite'], $result['cover'], 'large');
            if($result['buying_interval'] == 1 || $result['buying_interval'] == 2 || $result['buying_interval'] == 3 ){
                $result['buying_interval'] = $result['buying_interval'] == 1 ? "Weekly" : $result['buying_interval'] == 2 ? "Monthly" : "Quaterly";
            }
        }
        return $results;
    }

    public static function getQuotationRequestsSuppliers($id_quotation){
        $sql = "select quote.id_quote_request, quote.low_price, quote.id_supplier, quote.id_customer, quote.denied, quote.expiry, sup.*, DATE(details.deadline) < DATE(CURDATE()) as ready, DATE(quote.expiry) <= DATE(CURDATE()) as expired, (YEAR(NOW())-YEAR(sup.established)) as est
                        from "._DB_PREFIX_."elite_quote_request quote 
                        LEFT JOIN "._DB_PREFIX_."elite_supplier sup on sup.id_supplier=quote.id_supplier
                        LEFT JOIN "._DB_PREFIX_."elite_quote_request_details details on details.id_quote_request=quote.id_quote_request
                        WHERE quote.id_quote_request=".$id_quotation."
                        ORDER BY quote.low_price =0, quote.low_price ASC" ;
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

    public static function negotiatePrice($id_quote_request, $id_supplier, $target_price, $chance){
        $negotiated = "select negotiated from "._DB_PREFIX_."elite_quote_request_details where id_quote_request=".$id_quote_request;
        $negotiated_result = Db::getInstance()->getRow($negotiated);
        
        if($negotiated_result['negotiated'] == 1 && $chance=="true"){
            return array('result'=>2);
        }

        $sql = "select if(".$target_price.">= low_price, true, false) as result 
                        from "._DB_PREFIX_."elite_quote_request quote 
                        where id_quote_request=".$id_quote_request." AND id_supplier=".$id_supplier;
        $result = Db::getInstance()->getRow($sql);
        if($result['result'] == true){
            $sql ="UPDATE `"._DB_PREFIX_."elite_quote_request_details` k1
                        LEFT JOIN "._DB_PREFIX_."elite_quote_request k2 ON k1.id_quote_request=k2.id_quote_request
                        SET k1.negotiated=1, k2.high_price=".$target_price."
                        WHERE k2.id_supplier=".$id_supplier." AND k1.id_quote_request=".$id_quote_request;
            $update = Db::getInstance()->Execute($sql);
        }
        $sql ="UPDATE `"._DB_PREFIX_."elite_quote_request_details` k1
                    SET k1.negotiated=1
                    WHERE k1.id_quote_request=".$id_quote_request;
        $update = Db::getInstance()->Execute($sql);
        return $result;
    }

    public static function selectQuote($id_quote_request, $id_supplier, $target_price, $option){
        $logger = new FileLogger();
        $logger->setFilename("testbo.txt");
        $logger->logError("selectQuote");
        
        $check_query = Db::getInstance()->ExecuteS("select quoted from "._DB_PREFIX_."elite_quote_request_details where id_quote_request=".$id_quote_request);
        $logger->logError($check_query);
        $logger->logError($check_query[0]['quoted'] != 0);
        if($check_query[0]['quoted'] != 0){
            return false;
        }
        $sql ="update "._DB_PREFIX_."elite_quote_request_details set quoted=".$id_supplier.", price=".$target_price.", options=".$option." 
                        where id_quote_request=".$id_quote_request;
        $update = Db::getInstance()->Execute($sql);
        
        if($update){
            $context = Context::getContext();
            $customer = new Customer($context->cookie->id_customer);
            $sql ="SELECT * FROM "._DB_PREFIX_."specific_price where id_supplier=".$id_supplier." AND id_group=".$customer->id_default_group;
            $result_existing_customer = Db::getInstance()->Executes($sql);
                
            $quoteHistory = new EliteQuoteHistory();
            $quoteHistory->id_quote_request = $id_quote_request;
            $quoteHistory->id_quote_status = sizeof($result_existing_customer) > 0 ? EliteQuoteHistory::RATECONTRACT_ADDED : EliteQuoteHistory::AWAITS_SUPPLIER_ONBOARRDING;
            if($quoteHistory->add()){
                $sql = "select kpl.id_product, kpl.name as name, quote.quantity, sup_quote.expiry, quote.quantity, quote.id_customer 
                                from "._DB_PREFIX_."elite_quote_request_details quote 
                                LEFT JOIN "._DB_PREFIX_."elite_quote_request sup_quote on sup_quote.id_quote_request=quote.id_quote_request
                                LEFT JOIN "._DB_PREFIX_."product_lang kpl on quote.id_product=kpl.id_product and kpl.id_lang=1  
                                where quote.id_quote_request=".$id_quote_request." and sup_quote.id_supplier=".$id_supplier;
                $result = Db::getInstance()->ExecuteS($sql);
                $supplier = new EliteSupplier($id_supplier);
                $quote_ref = sprintf('%06d', $id_quote_request);
                $internal_data = array(
                    '{date}' => date('Y-m-d H:i:s'),
                    '{product_name}' => $result[0]['name'],
                    '{product_quantity}' => $result[0]['quantity'],
                    '{product_price}' => $target_price,
                    '{quote_ref}' => $quote_ref,
                );
                $logger->logError($sql);
                $logger->logError($result_existing_customer);
                $logger->logError(sizeof($result_existing_customer));
                if(sizeof($result_existing_customer) > 0){
                    $logger->logError($target_price);
                    $logger->logError($id_supplier);
                    $logger->logError($result[0]['id_product']);
                    $logger->logError($customer->id_default_group);
                    $logger->logError($result[0]['expiry']);
                    
                    $id_zone = Db::getInstance()->ExecuteS("select zone_id from "._DB_PREFIX_."pincode_master where zone_pin_start <= ".$result[0]['postcode']." and zone_pin_end >= ".$result[0]['postcode']);
                    $logger->logError($id_zone);
                    
                    EliteSupplierProducts::addStockDetails($id_supplier, $result[0]['id_product']);
                    EliteSupplierProducts::addZoneDetails($id_supplier, $result[0]['id_product'], $id_zone[0]['zone_id']);
                    
                    SpecificPrice::addSpecificPrice($target_price, $id_supplier, $result[0]['id_product'], $customer->id_default_group, $result[0]['expiry']);
                    
                    Mail::Send(1, 'ratecontract_confirmation', Mail::l("Congratulations, customer accepted your Quotation ".$quote_ref, 1) , $internal_data, "$supplier->email");
                    Mail::Send(1, 'ratecontract_confirmation', Mail::l("Buyer accepted a Quotation #".$quote_ref." and added to Ratecontract", 1) , $internal_data, "vijayashanthi@kobster.com");
                }
                else{
                    Mail::Send(1, 'quotation_confirmation', Mail::l("Congratulations, customer accepted your Quotation ".$quote_ref, 1) , $internal_data, $supplier->email);
                    Mail::Send(1, 'quotation_confirmation', Mail::l("Buyer accepted a Quotation #".$quote_ref, 1) , $internal_data, "vijayashanthi@kobster.com");
                }
            }
        }
        return sizeof($result_existing_customer) > 0 ? 1 : 2;
    }

    public static function getSuppliers($id_customer){
        $sql = "select supplier.email, supplier.company, supplier.reference, ka.*
                        FROM "._DB_PREFIX_."elite_supplier supplier 
                        LEFT JOIN "._DB_PREFIX_."elite_supplier_address sa on sa.id_supplier=supplier.id_supplier
                        LEFT JOIN "._DB_PREFIX_."elite_supplier_customer customer on customer.id_supplier=sa.id_supplier
                        LEFT JOIN "._DB_PREFIX_."address ka on ka.id_address=sa.id_address 
                        LEFT JOIN "._DB_PREFIX_."customer kc on kc.id_default_group=customer.id_group
                        WHERE kc.id_customer=".$id_customer."";
                        // print_r($sql);
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;   
    }

    public static function getCustomers($id_supplier){
        $sql = "select kgl.id_group, kgl.name as company
                        FROM "._DB_PREFIX_."elite_supplier_customer kesc
                        LEFT JOIN "._DB_PREFIX_."group_lang kgl on kgl.id_group = kesc.id_group and kgl.id_lang=1
                        WHERE kesc.id_supplier=".$id_supplier."";
                        // print_r($sql);
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;   
    }

    public function getOrdersSchedule(){
        $sql = "SELECT DISTINCT(ko.id_order) as id_order, kgl.name as title, ko.reference as id, replace(ko.estimated_delivery_time,' ','T') as end, replace(ko.estimated_delivery_time,' ','T') as start FROM `kob_elite_supplier_orders` keso
                LEFT JOIN kob_split_details ksd ON ksd.root = keso.id_order
                LEFT JOIN kob_orders ko ON ko.id_order=ksd.id_order
                LEFT JOIN kob_customer kc ON kc.id_customer = ko.id_customer
                LEFT JOIN kob_group_lang kgl ON kgl.id_group = kc.id_default_group and kgl.id_lang = 1
                LEFT JOIN kob_order_history koh ON koh.id_order=ko.id_order
                WHERE keso.id_supplier= ".$this->id."
                AND ko.`estimated_delivery_time` >= curdate()
                AND koh.`id_order_history` IN(SELECT MAX(id_order_history) FROM kob_order_history WHERE id_order = ko.id_order)
                AND koh.`id_order_state` IN(19, 20, 4, 22)";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;   
    }
    
    public function contractLists($limit = null, $offset =null, $searchQuery= null, $id_group = null){
        $filterQuery="";
        if($searchQuery){
            $filterQuery .='AND ( kgl.name LIKE "%'.$searchQuery.'%" 
                                OR kpl.name LIKE "%'.$searchQuery.'%"
                                OR kp.reference LIKE "%'.$searchQuery.'%")';
        }
        if($id_group){
            $filterQuery .= ' AND kc.id_default_group='.$id_group;
        }
        $dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";
        $sql = "SELECT DISTINCT(ksp.id_specific_price), format(ksp.price,2) as price, ksp.`to`, kpl.`name` as product_name, kp.reference, ktrg.name as gst, kgl.name as company, kgl.id_group
                    FROM kob_specific_price ksp
                    LEFT JOIN kob_customer kc on kc.id_default_group=ksp.id_group
                    LEFT JOIN kob_group_lang kgl on kgl.id_group=ksp.id_group and kgl.id_lang=1
                    LEFT JOIN kob_product kp ON kp.`id_product` = ksp.`id_product`
                    LEFT JOIN kob_product_lang kpl ON kpl.`id_product` = ksp.`id_product` AND kpl.`id_lang`=1
                    LEFT JOIN kob_tax_rules_group ktrg on ktrg.`id_tax_rules_group` = kp.`id_tax_rules_group`
                    WHERE kgl.id_group != 1 AND ksp.id_supplier=".$this->id." ".$filterQuery." ORDER BY ksp.id_specific_price DESC ".$dataLimit."";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;   
    }

    public function contractCount($searchQuery= null, $id_group = null){
        $filterQuery="";
        if($searchQuery){
            $filterQuery .='AND ( kgl.name LIKE "%'.$searchQuery.'%" 
                                OR kpl.name LIKE "%'.$searchQuery.'%"
                                OR kp.reference LIKE "%'.$searchQuery.'%")';
        }
        if($id_group){
            $filterQuery .= ' AND kc.id_default_group='.$id_group;
        }
        $sql = "SELECT count(DISTINCT(ksp.id_specific_price)) as cnt
                    FROM kob_specific_price ksp
                    LEFT JOIN kob_customer kc on kc.id_default_group=ksp.id_group
                    LEFT JOIN kob_group_lang kgl on kgl.id_group=ksp.id_group and kgl.id_lang=1
                    LEFT JOIN kob_product kp ON kp.`id_product` = ksp.`id_product`
                    LEFT JOIN kob_product_lang kpl ON kpl.`id_product` = ksp.`id_product` AND kpl.`id_lang`=1
                    LEFT JOIN kob_tax_rules_group ktrg on ktrg.`id_tax_rules_group` = kp.`id_tax_rules_group`
                    WHERE kgl.id_group != 1 AND ksp.id_supplier=".$this->id." ".$filterQuery;
        $result = Db::getInstance()->ExecuteS($sql);
        return $result[0]['cnt'];
    }
    
    public function productLists($limit = null, $offset =null, $searchQuery= null){
        $filterQuery="";
        if($searchQuery){
            $filterQuery .='AND ( kpl.name LIKE "%'.$searchQuery.'%"
                                OR kp.reference LIKE "%'.$searchQuery.'%")';
        }
        $dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";
        $sql = "SELECT DISTINCT(kp.id_product), kpl.`name` as product_name,kpl.`link_rewrite`, kp.`reference`, ktrg.`name` as gst, kes.`out_of_stock`
                    FROM kob_elite_supplier_stock kes
                    LEFT JOIN kob_product kp ON kp.`id_product` = kes.`id_product`
                    LEFT JOIN kob_product_lang kpl ON kpl.`id_product` = kes.`id_product` AND kpl.`id_lang`=1
                    LEFT JOIN kob_tax_rules_group ktrg on ktrg.`id_tax_rules_group` = kp.`id_tax_rules_group`
                    WHERE kes.id_supplier=".$this->id." ".$filterQuery." ORDER BY kp.id_product ".$dataLimit."";
                    
        $result = Db::getInstance()->ExecuteS($sql);
        return Product::getProductsProperties(1, $result);
    }
    
    public function productCount(){
        $sql = "SELECT count(DISTINCT(kp.id_product)) as cnt
                    FROM kob_elite_supplier_stock kes
                    LEFT JOIN kob_product kp ON kp.`id_product` = kes.`id_product`
                    LEFT JOIN kob_product_lang kpl ON kpl.`id_product` = kes.`id_product` AND kpl.`id_lang`=1
                    LEFT JOIN kob_tax_rules_group ktrg on ktrg.`id_tax_rules_group` = kp.`id_tax_rules_group`
                    WHERE kes.id_supplier=".$this->id;
                    
        $result = Db::getInstance()->ExecuteS($sql);
        return $result[0]['cnt'];
    }
    
    /*Pending - all invoices value which order's credit day started with status pending payment, invoice generated */
    public function totalDue(){
        $sql = "SELECT FORMAT(SUM(total_paid_tax_incl),2) as sm FROM (
                    SELECT ko.id_order, koi.total_paid_tax_incl, ko.credit_days, koi.date_add, DATE_ADD(koi.date_add, INTERVAL ko.credit_days DAY) as age, DATEDIFF(DATE_ADD(koi.date_add, INTERVAL ko.credit_days DAY), CURRENT_DATE) as pending_credit_days,koh.id_order_state, kosl.name  
                    from kob_order_invoice koi
                    LEFT JOIN kob_elite_supplier_orders keso ON keso.id_order=koi.id_order
                    LEFT JOIN kob_orders ko on ko.id_order=keso.id_order
                    LEFT JOIN kob_order_history koh ON koh.id_order=ko.id_order
                    LEFT JOIN kob_order_state_lang kosl ON kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
                    where keso.id_supplier = ".$this->id."
                    AND koh.id_order_history IN(SELECT MAX(id_order_history) FROM kob_order_history WHERE id_order=ko.id_order)
                    AND koh.id_order_state IN(25, 35) ) as x";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result['0']['sm'];
    }
    
    /*Pending - all invoices value which crossed the order's credit days with status pending payment, invoice generated */
    public function PendingPayment(){
        $sql = "SELECT FORMAT(SUM(total_paid_tax_incl),2) as sm FROM (
                    SELECT ko.id_order, koi.total_paid_tax_incl, ko.credit_days, koi.date_add, DATE_ADD(koi.date_add, INTERVAL ko.credit_days DAY) as age, DATEDIFF(DATE_ADD(koi.date_add, INTERVAL ko.credit_days DAY), CURRENT_DATE) as pending_credit_days,koh.id_order_state, kosl.name  from kob_order_invoice koi
                    LEFT JOIN kob_elite_supplier_orders keso ON keso.id_order=koi.id_order
                    LEFT JOIN kob_orders ko on ko.id_order=keso.id_order
                    LEFT JOIN kob_order_history koh ON koh.id_order=ko.id_order
                    LEFT JOIN kob_order_state_lang kosl ON kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
                    where keso.id_supplier = ".$this->id."
                    AND koh.id_order_history IN(SELECT MAX(id_order_history) FROM kob_order_history WHERE id_order=ko.id_order)
                    AND koh.id_order_state IN(25, 35) ) as x WHERE x.pending_credit_days < 0";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result['0']['sm'];
    }

    public function currentMonthRevenue(){
        date_default_timezone_set('Asia/Kolkata');
        $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
        $d = new DateTime('first day of this month');
        $t = new DateTime();
        
        $sql =" SELECT FORMAT(sum(a.sm),2) as sm FROM(
                SELECT DISTINCT(ko.id_order), ko.total_paid_tax_incl as sm
                FROM kob_orders ko
                LEFT JOIN kob_elite_supplier_orders keso ON keso.id_order=ko.id_order
                LEFT JOIN kob_order_history koh ON koh.id_order=keso.id_order AND koh.id_order_state IN(".$sales_status.")
                LEFT JOIN kob_order_history koha ON koha.id_order=koh.id_order
                WHERE keso.id_supplier=".$this->id."
                AND koh.date_add BETWEEN '".$d->format('Y-m-d 00:00:00')."' AND '".$t->format('Y-m-d 23:59:59')."'
                AND koha.id_order_history in(select max(id_order_history) from kob_order_history where id_order = koh.id_order) )as a";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

    public function previousMonthRevenue(){
        $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        $sql =" SELECT FORMAT(sum(a.sm),2) as sm FROM(
                SELECT DISTINCT(ko.id_order), ko.total_paid_tax_incl as sm
                FROM kob_orders ko
                LEFT JOIN kob_elite_supplier_orders keso ON keso.id_order=ko.id_order
                LEFT JOIN kob_order_history koh ON koh.id_order=keso.id_order AND koh.id_order_state IN(".$sales_status.")
                LEFT JOIN kob_order_history koha ON koha.id_order=koh.id_order
                WHERE keso.id_supplier=".$this->id."
                AND koh.date_add BETWEEN '".$month_ini->format('Y-m-d 00:00:00')."' AND '".$month_end->format('Y-m-d 23:59:59')."'
                AND koha.id_order_history in(select max(id_order_history) from kob_order_history where id_order = koh.id_order)) as a";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }
    public function activeCustomerCurrentMonth(){
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');
        $sql ="SELECT COUNT(DISTINCT(kc.id_default_group)) as total_cus FROM kob_elite_supplier_orders keso
                LEFT JOIN kob_orders ko ON ko.id_order=keso.id_order
                LEFT JOIN kob_customer kc ON kc.id_customer=ko.id_customer
                LEFT JOIN kob_order_history koh ON koh.id_order=keso.id_order
                WHERE keso.id_supplier=".$this->id."
                AND koh.id_order_history in(select max(id_order_history) from kob_order_history where id_order = keso.id_order)
                AND koh.id_order_state = 22
                AND koh.date_add BETWEEN DATE_FORMAT('".$now."' ,'%Y-%m-01') AND '".$now."'";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

    public function activeCustomerPreviousMonth(){
        date_default_timezone_set('Asia/Kolkata');
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        $sql ="SELECT COUNT(DISTINCT(kc.id_default_group)) as total_cus FROM kob_elite_supplier_orders keso
                LEFT JOIN kob_orders ko ON ko.id_order=keso.id_order
                LEFT JOIN kob_customer kc ON kc.id_customer=ko.id_customer
                LEFT JOIN kob_order_history koh ON koh.id_order=keso.id_order
                WHERE keso.id_supplier=".$this->id."
                AND koh.id_order_history in(select max(id_order_history) from kob_order_history where id_order = keso.id_order)
                AND koh.id_order_state in(22)
                AND koh.date_add BETWEEN '".$month_ini->format('Y-m-d 00:00:00')."' AND '".$month_end->format('Y-m-d 23:59:59')."'";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;   
    }
    
    public function currentMonthSellingProducts(){
        date_default_timezone_set('Asia/Kolkata');
        $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
        $d = new DateTime('first day of this month');
        $t = new DateTime();

        $sql =" SELECT COUNT(DISTINCT(kod.product_id)) as sm
                FROM kob_orders ko
                LEFT JOIN kob_order_detail kod ON kod.id_order=ko.id_order
                LEFT JOIN kob_elite_supplier_orders keso ON keso.id_order=ko.id_order
                LEFT JOIN kob_order_history koh ON koh.id_order=keso.id_order AND koh.id_order_state IN(".$sales_status.")
                LEFT JOIN kob_order_history koha ON koha.id_order=koh.id_order
                WHERE keso.id_supplier=".$this->id."
                AND ko.id_order is not null
                AND koh.date_add BETWEEN '".$d->format('Y-m-d 00:00:00')."' AND '".$t->format('Y-m-d 23:59:59')."'
                AND koha.id_order_history in(select max(id_order_history) from kob_order_history where id_order = koh.id_order)";
        
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }
    
    public function lastMonthSellingProducts(){
        date_default_timezone_set('Asia/Kolkata');
        $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");
        
        $sql =" SELECT count(DISTINCT(kod.product_id)) as sm
                FROM kob_orders ko
                LEFT JOIN kob_order_detail kod ON kod.id_order=ko.id_order
                LEFT JOIN kob_elite_supplier_orders keso ON keso.id_order=ko.id_order
                LEFT JOIN kob_order_history koh ON koh.id_order=keso.id_order AND koh.id_order_state IN(".$sales_status.")
                LEFT JOIN kob_order_history koha ON koha.id_order=koh.id_order
                WHERE keso.id_supplier=".$this->id."
                AND ko.id_order is not null
                AND koh.date_add BETWEEN '".$month_ini->format('Y-m-d 00:00:00')."' AND '".$month_end->format('Y-m-d 23:59:59')."'
                AND koha.id_order_history in(select max(id_order_history) from kob_order_history where id_order = koh.id_order)";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

    public function getAcceptedCustomer($query, $page, $limit){
        $start  = $page*$limit;
        $end    = $limit;
        $page   = " limit ".$start.",".$end."";

        $sql ="SELECT det.id_quote_request,
                kp.id_product, kpl.name, kpl.link_rewrite, kp.reference as code,
                LPAD(det.id_quote_request, 6, '0') as ref,
                det.quantity, req.low_price,kgl.name as company,det.postcode as pcode,
                (SELECT zone_name FROM kob_pincode_master where zone_pin_start<=pcode and zone_pin_end >=pcode) as location
                FROM `kob_elite_quote_request` req
                LEFT JOIN kob_elite_quote_request_details det ON req.id_quote_request=det.id_quote_request
                LEFT JOIN kob_customer kc ON kc.id_customer=det.id_customer
                LEFT JOIN kob_group_lang kgl ON kgl.id_group=kc.id_default_group and kgl.id_lang=1
                LEFT JOIN kob_product_lang kpl ON kpl.id_product=det.id_product
                LEFT JOIN kob_product kp ON kp.id_product=det.id_product
                LEFT JOIN kob_quote_history kqh ON kqh.id_quote_request=det.id_quote_request
                LEFT JOIN kob_quote_status_lang kqsl ON kqsl.id_quote_status=kqh.id_quote_status
                WHERE det.quoted = ".$this->id."
                AND kqh.id_quote_history IN(SELECT MAX(id_quote_history) FROM kob_quote_history WHERE id_quote_request=det.id_quote_request)
                AND kqh.id_quote_status = 5
                AND req.low_price > 0
                ".$page;
                $logger = new FileLogger();
                $logger->setFilename("testbo.txt");
                $logger->logError($sql);
        $results = Db::getInstance()->ExecuteS($sql);
        foreach ($results as &$result) {
            $coverImage = Image::getCover($result['id_product']);
            $result['cover'] = $result['id_product'].'-'.$coverImage['id_image'];
            if (!$coverImage['id_image'])
            $result['cover'] = Language::getIsoById((int)($id_lang)).'-default';

            $linkObj = new Link();
            $result['imageLink2'] = $linkObj->getImageLink($result['link_rewrite'], $result['cover'], 'small');
        }
        return $results;

    }

    public function getAcceptedCustomerCount($query, $page, $limit){
        $start  = $page*$limit;
        $end    = $limit;
        $page   = " limit ".$start.",".$end."";

        $sql ="SELECT count(DISTINCT(det.id_quote_request)) as cnt
                FROM `kob_elite_quote_request` req
                LEFT JOIN kob_elite_quote_request_details det ON req.id_quote_request=det.id_quote_request
                LEFT JOIN kob_customer kc ON kc.id_customer=det.id_customer
                LEFT JOIN kob_group_lang kgl ON kgl.id_group=kc.id_default_group and kgl.id_lang=1
                LEFT JOIN kob_product_lang kpl ON kpl.id_product=det.id_product and kpl.id_lang=1
                LEFT JOIN kob_product kp ON kp.id_product=det.id_product
                LEFT JOIN kob_quote_history kqh ON kqh.id_quote_request=det.id_quote_request
                LEFT JOIN kob_quote_status_lang kqsl ON kqsl.id_quote_status=kqh.id_quote_status
                WHERE det.quoted = ".$this->id."
                AND kqh.id_quote_history IN(SELECT MAX(id_quote_history) FROM kob_quote_history WHERE id_quote_request=det.id_quote_request)
                AND kqh.id_quote_status = 5
                AND req.low_price > 0
                ";
                
        $result = Db::getInstance()->ExecuteS($sql);
        return array("cnt"=>0);

    }

    public function getQuotePrice($id_quote_request){
        $sql ="select low_price as price, expiry from kob_elite_quote_request 
                WHERE id_quote_request=".$id_quote_request." AND id_supplier=".$this->id;
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

}
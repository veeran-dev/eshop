<?php
/*
*
* Supplier and Orders Mapping
*
*/
class EliteSupplierOrdersCore extends ObjectModel
{
    /** @var int ID supplier */
    public $id_supplier;
    /** @var int ID order */
    public $id_order;

    public static $definition = array(
        'table' => 'elite_supplier_orders',
        'primary' => 'id_supplier_order',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier Orders Mapping */
            'id_supplier' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_order' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
        )
    );

    public function __construct($id_supplier = null)
    {   
        parent::__construct();
        if($id_supplier) {
            $this->id_supplier = $id_supplier;
        }
    }

    public static function getOrderSupplier($id_order){
        $sql = "SELECT id_supplier from "._DB_PREFIX_."elite_supplier_orders where id_order=".$id_order;
        $result = Db::getInstance()->getRow($sql)['id_supplier'];
        return $result;
    }

    public function getOrders($limit, $offset, $fromDate, $toDate, $idPage, $orderBy, $orderWay, $searchQuery, $status, $id_group){
        $filterQuery = "";

        if($fromDate && $toDate)
            $filterQuery .= ' AND DATE(ko.`date_add`) BETWEEN "'.date("Y-m-d", strtotime($fromDate)).'" AND "'.date("Y-m-d", strtotime($toDate)).'"';
        else if($fromDate == NULL && $toDate)
            $filterQuery .= ' AND DATE(ko.`date_add`) = "'.date("Y-m-d", strtotime($toDate)).'"';
        else if($toDate == NULL && $fromDate)
            $filterQuery .= ' AND DATE(ko.`date_add`) = "'.date("Y-m-d", strtotime($fromDate)).'"';

        if($searchQuery)
            $filterQuery .= ' AND (ko.`id_order` LIKE "%'.$searchQuery.'%" OR koh.`date_add` LIKE "%'.$searchQuery.'%" OR
                             ko.`total_paid` LIKE "%'.$searchQuery.'%" OR kosl.`name` LIKE "%'.$searchQuery.'%" 
                             OR kgl.`name` LIKE "%'.$searchQuery.'%" OR
                             kc.`email` LIKE "%'.$searchQuery.'%")';
        if($id_group){
            $filterQuery .= ' AND kc.id_default_group='.$id_group;
        }
        if($status > 0){
            $filterQuery .= ' AND koh.id_order_state in ('.$status.')';
        }

         $dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";

         $get_orders_query = "SELECT DISTINCT(ko.id_order),kc.email, kgl.name as company, 
                            total.tot as zx, ko.total_paid as kp,ka.id_state,ks.name as state_name,
                            (CASE WHEN q.quantity is NULL THEN FORMAT(total.tot,2) ELSE FORMAT(IFNULL(total.tot,0)+ko.total_paid,2) END) as total_paid, 
                            (CASE WHEN q.quantity is NULL THEN total.tot ELSE IFNULL(total.tot,0)+ko.total_paid END) as total_paid_sort, 
                            (CASE WHEN q.quantity is NULL THEN total.quantity ELSE q.quantity+IFNULL(total.quantity,0) END) as quantity,
                            kosl.name,(select MAX(date_add) from "._DB_PREFIX_."order_history where id_order=ko.id_order and id_order_state=22) as date_add, 
                            ko.estimated_delivery_time as estimated_time, koh.id_order_state,kos.color
                            from "._DB_PREFIX_."elite_supplier_orders keso
                            LEFT JOIN "._DB_PREFIX_."orders ko ON ko.id_order=keso.id_order
                            LEFT JOIN "._DB_PREFIX_."address ka on ka.id_address = ko.id_address_delivery
                            LEFT JOIN "._DB_PREFIX_."state ks on ks.id_state = ka.id_state
                            LEFT JOIN "._DB_PREFIX_."order_history koh ON koh.id_order=ko.id_order
                            LEFT JOIN "._DB_PREFIX_."order_history koha ON koha.id_order=ko.id_order
                            LEFT JOIN "._DB_PREFIX_."order_state kos ON kos.id_order_state=koh.id_order_state
                            LEFT JOIN "._DB_PREFIX_."order_state_lang kosl ON kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
                            LEFT JOIN "._DB_PREFIX_."customer kc ON kc.id_customer=ko.id_customer
                            LEFT JOIN "._DB_PREFIX_."group_lang kgl on kgl.id_group=kc.id_default_group AND kgl.id_lang=1
                            LEFT JOIN(
                                SELECT id_order, COUNT(product_quantity) as quantity FROM kob_order_detail GROUP BY id_order
                            ) as q on q.id_order=ko.id_order
                            LEFT JOIN (
                                SELECT ksd.root, SUM(ko.total_paid_tax_incl) as tot, SUM(ord.q) as quantity FROM kob_split_details ksd
                                LEFT JOIN kob_orders ko ON ko.id_order=ksd.id_order
                                LEFT JOIN(
                                    SELECT id_order, COUNT(product_quantity) as q FROM kob_order_detail 
                                    GROUP BY id_order) as ord ON ord.id_order=ko.id_order
                                GROUP BY ksd.root
                            ) as total on total.root = ko.id_order
                            WHERE keso.id_supplier=".$this->id_supplier."
                            AND koh.id_order_history IN(SELECT MAX(id_order_history) from "._DB_PREFIX_."order_history where id_order=ko.id_order )
                            AND koh.id_order_state IN(".Configuration::get('ELITE_SUPPLIER_ORDER_STATUS').")
                            AND koha.id_order_history IN(SELECT MAX(id_order_history) from kob_order_history where id_order=ko.id_order AND id_order_state=22)
                            AND ko.id_order not in(select sd.id_order from "._DB_PREFIX_."split_details sd 
                                                        left join "._DB_PREFIX_."elite_supplier_orders eso on eso.id_order=sd.root
                                                        where eso.id_supplier=".$this->id_supplier.")
                            ".$filterQuery."
                            ".($orderBy ? 'ORDER BY '.$orderBy : 'ORDER BY koha.`date_add` ')." 
                            ".($orderWay ? $orderWay : "DESC")." 
                            ".$dataLimit."";
        $result = Db::getInstance()->ExecuteS($get_orders_query);
        // print_r($get_orders_query);
        return $result;

    }

    public function getOrdersCount(){
        $get_orders_query = "SELECT COUNT(DISTINCT(ko.id_order)) as norders
                                    from "._DB_PREFIX_."elite_supplier_orders keso
                                    LEFT JOIN "._DB_PREFIX_."orders ko ON ko.id_order=keso.id_order
                                    LEFT JOIN "._DB_PREFIX_."order_history koh ON koh.id_order=ko.id_order
                                    LEFT JOIN "._DB_PREFIX_."order_state_lang kosl ON kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
                                    LEFT JOIN "._DB_PREFIX_."customer kc ON kc.id_customer=ko.id_customer
                                    LEFT JOIN "._DB_PREFIX_."group_lang kgl on kgl.id_group=kc.id_default_group AND kgl.id_lang=1
                                    WHERE keso.id_supplier=".$this->id_supplier."
                                    AND koh.id_order_history IN(SELECT MAX(id_order_history) from "._DB_PREFIX_."order_history where id_order=ko.id_order )";
        $result = Db::getInstance()->ExecuteS($get_orders_query);
        return $result[0]['norders'];

    }

    public function getOrderDetails($id_order){
        $checkOrder = $this->checkOrderDelay($id_order);
        $query = "SELECT root from "._DB_PREFIX_."split_details where id_order=".$id_order;
        $root_order = Db::getInstance()->getRow($query);
        $id_order = $root_order['root'] ? $root_order['root'] : $id_order;
        $get_order_cus_query = "SELECT ko.id_order, ko.payment, kod.product_name, ko.po_number, kgl.name as company,kc.firstname,kc.email,ko.estimated_delivery_time,
                            ko.id_address_delivery,ko.id_address_invoice,koh.id_order_state, kosl.name as order_status,kod.product_reference,
                            kd.id_delivery, kd.delivery_number,kd.delivery_date as dr_date,(select MIN(date_add) from "._DB_PREFIX_."order_history where id_order=ko.id_order and id_order_state=22) as order_date,kd.dr_prefix, ka.isez, kos.color,
                            (CASE WHEN kod.product_quantity IS NULL THEN FORMAT(total.total_paid_tax_incl,2) ELSE FORMAT(ko.total_paid_tax_incl+IFNULL(total.total_paid_tax_incl, 0),2) END) as total_paid_tax_incl,
                            (CASE WHEN kod.product_quantity IS NULL THEN FORMAT(total.total_paid_tax_excl,2) ELSE FORMAT(ko.total_paid_tax_excl+IFNULL(total.total_paid_tax_excl, 0),2) END) as total_paid_tax_excl,
                            (CASE WHEN kod.product_quantity IS NULL THEN FORMAT(total.total_discounts,2) ELSE FORMAT(ko.total_discounts+IFNULL(total.total_discounts, 0),2) END) as total_discounts,
                            (CASE WHEN kod.product_quantity IS NULL THEN FORMAT(total.gst,2) ELSE FORMAT(IFNULL(total.gst,0)+(ko.total_paid_tax_incl-ko.total_paid_tax_excl),2) END) as gst, kes.company as supplier_company
                            from "._DB_PREFIX_."orders ko
                            LEFT JOIN "._DB_PREFIX_."order_detail kod ON kod.id_order=ko.id_order
                            LEFT JOIN "._DB_PREFIX_."address ka on ka.id_address = ko.id_address_delivery
                            LEFT JOIN "._DB_PREFIX_."customer kc ON kc.id_customer=ko.id_customer
                            LEFT JOIN "._DB_PREFIX_."group_lang kgl on kgl.id_group=kc.id_default_group AND kgl.id_lang=1
                            LEFT JOIN "._DB_PREFIX_."order_history koh on koh.id_order=ko.id_order
                            LEFT JOIN "._DB_PREFIX_."order_state_lang kosl on kosl.id_order_state = koh.id_order_state and kosl.id_lang=1
                            LEFT JOIN "._DB_PREFIX_."order_state kos on kos.id_order_state = koh.id_order_state
                            LEFT JOIN "._DB_PREFIX_."order_delivery kdd on kdd.id_order=ko.id_order
                            LEFT JOIN "._DB_PREFIX_."delivery kd on kd.id_delivery=kdd.id_delivery
                            LEFT JOIN "._DB_PREFIX_."elite_supplier_orders keso on keso.id_order=ko.id_order
                            LEFT JOIN "._DB_PREFIX_."elite_supplier kes on kes.id_supplier=keso.id_supplier
                            LEFT JOIN "._DB_PREFIX_."elite_supplier_configuration conf on conf.id_supplier=keso.id_supplier
                            LEFT JOIN (
                                SELECT ksd.root,
                                SUM(tot.total_paid_tax_incl) as total_paid_tax_incl, SUM(tot.total_paid_tax_excl) as total_paid_tax_excl, SUM(tot.total_discounts) as total_discounts, (SUM(tot.total_paid_tax_incl)-SUM(tot.total_paid_tax_excl)) as gst
                                FROM `"._DB_PREFIX_."split_details` ksd 
                                LEFT JOIN "._DB_PREFIX_."orders tot ON tot.id_order IN(ksd.id_order) 
                                WHERE ksd.root = ".$id_order."
                                GROUP BY ksd.root
                            ) as total ON total.root = ko.id_order
                            WHERE koh.id_order_history in(SELECT MAX(id_order_history) from "._DB_PREFIX_."order_history where id_order=ko.id_order) 
                            AND ko.id_order=".$id_order."";
        
        $order_detail = Db::getInstance()->ExecuteS($get_order_cus_query);
        if($order_detail[0]['delivery_number']){
            $order_detail[0]['delivery_number'] = sprintf('%06d', $order_detail[0]['delivery_number']);
        }
        $order = new Order($id_order);

        //Get customer PO
        $po_number = "";
        $po_file = "";
        if(!empty(glob("customer_PO/".$order->id."*.*"))){
            $po_file = glob("customer_PO/".$order->id."*.*");
        }
        $order_detail[0]['po_file'] = $po_file;
        $order_detail[0]['po_number'] = $order->po_number;
        $addressInvoice = new Address($order_detail[0]['id_address_invoice']);        
        $invoice_address = AddressFormat::generateAddress($addressInvoice, $patternRules, '<br />');
        $invoice_address = $invoice_address.'<br /> GST:'.$addressInvoice->vat_number;

        $addressDelivery = new Address($order_detail[0]['id_address_delivery']);
        $shipping_address = AddressFormat::generateAddress($addressDelivery, $patternRules, '<br />');
        $shipping_address = $shipping_address.'<br /> GST:'.$addressDelivery->vat_number;

        $products = $order->getAllProductsDetails();
        // $products = $order->getProductsDetail();        
        $product_detail = $order->getOrderProducts($products);
        $states = OrderState::getSupplierOrderStates(1);
        
        $supplierAddress = new EliteSupplierAddress();
        $saddress = $supplierAddress->getAddress();

        $delivery_plan = $order->getDeliveryPlans();
        $removedProducts = $order->getRemovedProducts();
        // var_dump($order_detail[0]);
        $result = array('0' => $order_detail, '1' => $invoice_address, '2'=>$shipping_address, '3'=> $product_detail, '4'=> $states, '5'=> $saddress, '6'=> $delivery_plan, '7'=>$order_totals, '8'=>$removedProducts, '9'=>$checkOrder);
        return $result;
    }
    public static function checkOrderDelay($id_order){
        $query = "SELECT root from "._DB_PREFIX_."split_details where id_order=".$id_order;
        $root_order = Db::getInstance()->getRow($query);
        $id_order = $root_order['root'] ? $root_order['root'] : $id_order;
        $logger = new FileLogger();
        $logger->setFilename("test.txt");
        $logger->logError("checkOrderDelay ==>".$id_order);
        
        // date_default_timezone_set('Asia/Kolkata');
        $today = date('Y-m-d H:i:s');
        $first_hour = Configuration::get('SUPPLIER_ORDER_FIRST_HOUR');
        $first_hour = '23:59:58';
        $second_hour = Configuration::get('SUPPLIER_ORDER_SECOND_HOUR');
        $second_hour = '71:59:28';
        $query = "SELECT koh.id_order_state, TIMEDIFF(if(koh.id_order_state=22, '".$first_hour."', '".$second_hour."'), TIMEDIFF('".$today."', koha.date_add)) as t 
                    FROM `"._DB_PREFIX_."orders` ko
                    LEFT JOIN "._DB_PREFIX_."order_history koh ON koh.id_order=ko.id_order
                    LEFT JOIN "._DB_PREFIX_."order_history koha ON koha.id_order=ko.id_order
                    WHERE ko.id_order=".$id_order."
                    AND koh.id_order_history IN(SELECT MAX(id_order_history) from "._DB_PREFIX_."order_history where id_order=ko.id_order)
                    AND koha.id_order_state=22";
        $result = Db::getInstance()->getRow($query);
        $logger->logError($query);
        $x = explode(":",$result['t']);
        $logger->logError($today);
        $logger->logError($result);
        $first_hour = Configuration::get('SUPPLIER_ORDER_FIRST_HOUR');
        $second_hour = Configuration::get('SUPPLIER_ORDER_SECOND_HOUR');
        if($result['id_order_state'] == 6){
            return $first_hour;
        }
        else if(((int)$x[0] < 0 || $x[0] === "-00") && $result['id_order_state'] == 22){
            //Cancel Order
            $order = new Order($id_order);
            $context = Context::getContext();
            $id_supplier = $context->cookie->s_id;
            $history = new OrderHistory();
            $history->id_order = $id_order;
            $history->id_employee = $id_supplier;
            $templateVars = array();
            $history->changeIdOrderState(OrderState::FLAG_CANCELED, $order, $use_existings_payment);
            if($history->addWithemail(true, $templateVars, $internal_mail)) {
                return $first_hour;
            }
        }
        else if((int)$x[0] < 0 || $x[0] === "-00"){
            //if no products schedule cancel order
            $query1 = "SELECT root from "._DB_PREFIX_."split_details where id_order=".$id_order;
            $root_order = Db::getInstance()->getRow($query1);
            $id_ord = $root_order['root'] ? $root_order['root'] : $id_order;
            $query2 = "SELECT id_order from "._DB_PREFIX_."split_details where root=".$id_order;
            $final_order = Db::getInstance()->getRow($query2);
            
            if(!$final_order){
                $order = new Order($id_order);
                $context = Context::getContext();
                $id_supplier = $context->cookie->s_id;
                $history = new OrderHistory();
                $history->id_order = $id_order;
                $history->id_employee = $id_supplier;
                $templateVars = array();
                $history->changeIdOrderState(OrderState::FLAG_CANCELED, $order, $use_existings_payment);
                if($history->addWithemail(true, $templateVars, $internal_mail)) {
                    return $second_hour;
                }
            }else{
                //if partial edt scheduled remove all products in order
                $order = new Order($id_order);
                $order_detail_ids = "SELECT id_order_detail from kob_order_detail where id_order=".$id_order;
                $order_detail_qty = "SELECT product_quantity from kob_order_detail where id_order=".$id_order;
                $product_list = Db::getInstance()->ExecuteS($order_detail_ids);
                $product_quantity = Db::getInstance()->ExecuteS($order_detail_qty);
                $order->cancelProduct(array_column($product_list, 'id_order_detail'), array_column($product_quantity, 'product_quantity'), false, false, false);
                $context = Context::getContext();
                $id_supplier = $context->cookie->s_id;
                $findChildOrderquery = "SELECT id_order from "._DB_PREFIX_."split_details where root=".$id_order;
                $child_order = Db::getInstance()->getRow($findChildOrderquery);
                $logger->logError($findChildOrderquery);
                $logger->logError($child_order);
                OrderHistory::checkParentOrderStatus($child_order['id_order'], 0, $id_supplier);
                return $second_hour;  
            }  
        }
        else{
            // return $result['id_order_state'] == 22 ? $first_hour:$second_hour;
            return $result['id_order_state'] == 22 ? $first_hour:$second_hour;
        }
    }

    
    public function getSupplierByOrderDetail($id_order_detail){
           $query = "SELECT keso.id_supplier from "._DB_PREFIX_."order_detail kod 
                            LEFT JOIN "._DB_PREFIX_."elite_supplier_orders keso on keso.id_order=kod.id_order
                            where kod.id_order_detail=".$id_order_detail."";
            $result = Db::getInstance()->ExecuteS($query);
            return $result[0]['id_supplier'];
    }

    public function getOrdersCountWithStates(){
        $query = "SELECT states.id_order_state, states.name, states.id_supplier, states.cn FROM
                    (SELECT kosl.id_order_state, kosl.name as name, keso.id_supplier, COUNT(ko.id_order) as cn FROM `"._DB_PREFIX_."elite_supplier_orders` keso
                    LEFT JOIN "._DB_PREFIX_."orders ko ON ko.id_order=keso.id_order
                    LEFT JOIN "._DB_PREFIX_."order_history koh ON koh.id_order=ko.id_order
                    LEFT JOIN "._DB_PREFIX_."order_state_lang kosl ON kosl.id_order_state=koh.id_order_state AND kosl.id_lang=1
                    WHERE koh.id_order_history IN(SELECT MAX(id_order_history) FROM "._DB_PREFIX_."order_history WHERE id_order=ko.id_order)
                    AND kosl.id_order_state IN(".Configuration::get('ELITE_SUPPLIER_ORDER_STATUS').")
                    AND keso.id_supplier = ".$this->id_supplier."
                    AND ko.id_order not in(select sd.id_order from "._DB_PREFIX_."split_details sd 
                                                left join "._DB_PREFIX_."elite_supplier_orders eso on eso.id_order=sd.root
                                                where eso.id_supplier=".$this->id_supplier.")
                    GROUP BY kosl.id_order_state
                    UNION 
                    SELECT kosl.id_order_state, kosl.name as name, 1 as id_supplier, 0 as cn FROM "._DB_PREFIX_."order_state kos 
                    LEFT JOIN "._DB_PREFIX_."order_state_lang kosl ON kos.id_order_state=kosl.id_order_state 
                    WHERE kosl.id_lang=1 AND kos.deleted=0 AND kos.id_order_state IN(".Configuration::get('ELITE_SUPPLIER_ORDER_STATUS').")
                    GROUP BY kosl.id_order_state) as states
                    GROUP BY states.id_order_state";
        $result = Db::getInstance()->ExecuteS($query);
        return $result;
    }
    
    public function getCustomersOrderCount(){
        $sql = "select kgl.id_group, kgl.name as company, count(ko.id_order) as cn
                        FROM kob_elite_supplier_orders keso
                        LEFT JOIN kob_orders ko ON ko.id_order=keso.id_order
                        LEFT JOIN kob_customer kc on kc.id_customer = ko.id_customer
                        LEFT JOIN kob_group_lang kgl on kgl.id_group = kc.id_default_group and kgl.id_lang=1
                        LEFT JOIN kob_order_history koh ON koh.id_order=ko.id_order
                        WHERE keso.id_supplier=".$this->id_supplier."
                        AND kc.id_customer IS NOT NULL
                        AND koh.id_order_history IN(SELECT MAX(id_order_history) from kob_order_history where id_order=ko.id_order)
                        AND koh.id_order_state IN(".Configuration::get('ELITE_SUPPLIER_ORDER_STATUS').")
                        AND ko.id_order not in(select sd.id_order from kob_split_details sd 
                                                        left join kob_elite_supplier_orders eso on eso.id_order=sd.root
                                                        where eso.id_supplier=".$this->id_supplier.")

                        GROUP BY kgl.id_group";
                        // print_r($sql);
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;   
    }
}
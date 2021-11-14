<?php
/*
*
* Supplier and Customer Mapping
*
*/
class EliteSupplierCustomerCore extends ObjectModel
{
    /** @var int ID supplier */
    public $id_group;
    public $id_supplier;
    
    public static $definition = array(
        'table' => 'elite_supplier_customer',
        'primary' => 'id_supplier_customer',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier Customer Mapping */
            'id_supplier' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_group' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
        )
    );
    
    public function getTopCustomer($from = null, $to =null){
        $context = Context::getContext();
        $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
        $filter = "";
        if($from && $to){
            $filter = " AND koh.date_add between '".$from."' and '".$to."'";
        }
        $sql="SELECT k.id_group, k.name, cast(sum(k.total_paid_tax_incl) as decimal(12,2)) as sales FROM(
                SELECT DISTINCT(ko.id_order), kgl.id_group, kgl.name,  ko.total_paid_tax_incl 
                FROM "._DB_PREFIX_."orders ko
                LEFT JOIN "._DB_PREFIX_."elite_supplier_orders keso ON keso.id_order=ko.id_order
                LEFT JOIN "._DB_PREFIX_."order_history koh ON koh.id_order=keso.id_order AND koh.id_order_state IN(".$sales_status.")
                LEFT JOIN "._DB_PREFIX_."order_history koha ON koha.id_order=koh.id_order
                LEFT JOIN "._DB_PREFIX_."customer kc ON kc.id_customer=ko.id_customer
                LEFT JOIN "._DB_PREFIX_."group_lang kgl ON kgl.id_group=kc.id_default_group AND kgl.id_lang=1
                WHERE keso.id_supplier=".$context->cookie->s_id."
                ".$filter."
                AND koha.id_order_history in(select max(id_order_history) from "._DB_PREFIX_."order_history where id_order = koh.id_order)
            ) as k GROUP BY k.id_group ORDER BY sales desc LIMIT 3";
            
        // $logger = new FileLogger();
        // $logger->setFilename("test_Sco.txt");
        // $logger->logError($sql);
        
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

    public static function isTagged($id_supplier, $id_group){
        $sql = "select * from "._DB_PREFIX_."elite_supplier_customer WHERE id_supplier=".$id_supplier." AND id_group=".$id_group;
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;   
    }
    // public function getTopCustomer($from = null, $to =null){
    //     $context = Context::getContext();
    //     $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
    //     $filter = "";
    //     if($from && $to){
    //         $filter = " AND koh.date_add between '".$from."' and '".$to."'";
    //     }
    //     $sql="SELECT k.id_group, k.name, cast(sum(k.total_paid_tax_incl) as decimal(12,2)) as sales FROM(
    //             SELECT DISTINCT(ko.id_order), kgl.id_group, kgl.name,  ko.total_paid_tax_incl 
    //             FROM "._DB_PREFIX_."orders ko
    //             LEFT JOIN "._DB_PREFIX_."elite_supplier_orders keso ON keso.id_order=ko.id_order
    //             LEFT JOIN "._DB_PREFIX_."order_history koh ON koh.id_order=keso.id_order AND koh.id_order_state IN(".$sales_status.")
    //             LEFT JOIN "._DB_PREFIX_."order_history koha ON koha.id_order=koh.id_order
    //             LEFT JOIN "._DB_PREFIX_."customer kc ON kc.id_customer=ko.id_customer
    //             LEFT JOIN "._DB_PREFIX_."group_lang kgl ON kgl.id_group=kc.id_default_group AND kgl.id_lang=1
    //             WHERE keso.id_supplier=".$context->cookie->s_id."
    //             ".$filter."
    //             AND koha.id_order_history in(select max(id_order_history) from "._DB_PREFIX_."order_history where id_order = koh.id_order)
    //         ) as k GROUP BY k.id_group";
            
    //     $logger = new FileLogger();
    //     $logger->setFilename("test_Sco.txt");
    //     // $logger->logError($sql);
        
    //     $result = Db::getInstance()->ExecuteS($sql);
    //     return $result;
    // }
    // public static function getTopCustomer(){
    //     $context = Context::getContext();
    //     $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
    //     $sql = "SELECT kgl.name, cast(sum(ko.total_paid_tax_incl) as decimal(12,2)) as sales 
    //                 from "._DB_PREFIX_."elite_supplier_customer kesc
    //                 LEFT JOIN "._DB_PREFIX_."group_lang kgl on kgl.id_group=kesc.id_group
    //                 LEFT JOIN "._DB_PREFIX_."customer kc on kc.id_default_group=kesc.id_group
    //                 LEFT JOIN "._DB_PREFIX_."orders ko on ko.id_customer=kc.id_customer
    //                 LEFT JOIN "._DB_PREFIX_."elite_supplier_orders keso on keso.id_order=ko.id_order AND keso.id_supplier=kesc.id_supplier
    //                 LEFT JOIN "._DB_PREFIX_."order_history koh on koh.id_order=keso.id_order
    //                 LEFT JOIN "._DB_PREFIX_."order_history koha on koha.id_order=koh.id_order
    //                 WHERE koh.id_order IN(select id_order from "._DB_PREFIX_."order_history WHERE id_order=ko.id_order) 
    //                 AND koha.id_order_history IN(select MAX(id_order_history) from "._DB_PREFIX_."order_history WHERE id_order=koh.id_order AND id_order_state=".$sales_status.")
    //                 AND koha.id_order_state NOT IN(6, 7)
    //                 AND kesc.id_supplier=".$context->cookie->s_id."
    //                 GROUP BY kesc.id_group
    //                 ORDER BY sales DESC
    //                 LIMIT 4";
    //     $result = Db::getInstance()->ExecuteS($sql);
    //     return $result;
    // }

    public static function monthlySales(){
        $context = Context::getContext();
        $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
        $sql = "SELECT DATE_FORMAT(ko.date_add, '%M,%Y') as month, cast(sum(ko.total_paid_tax_incl) as decimal(12,2)) as sales 
                    from "._DB_PREFIX_."elite_supplier_orders keso
                    LEFT JOIN "._DB_PREFIX_."orders ko on ko.id_order=keso.id_order
                    LEFT JOIN "._DB_PREFIX_."order_history koh on koh.id_order=ko.id_order AND koh.id_order_state=".$sales_status."
                    LEFT JOIN "._DB_PREFIX_."order_history koha on koha.id_order=koh.id_order
                    WHERE koha.id_order_history IN(select MAX(id_order_history) from "._DB_PREFIX_."order_history WHERE id_order=ko.id_order)
                    AND koha.id_order_state NOT IN(6,7)
                    AND keso.id_supplier=".$context->cookie->s_id."
                    AND ko.date_add >= now()-interval 3 month
                    GROUP BY DATE_FORMAT(ko.date_add, '%Y-%m')
                    ORDER BY sales DESC
                    LIMIT 4";
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

    public static function getSuppliersCustomer($id_supplier){
        return Db::getInstance()->ExecuteS("SELECT kgl.name as company, kgl.id_group 
                                                FROM `kob_elite_supplier_customer` kesc 
                                                LEFT JOIN kob_group_lang kgl ON kgl.id_group=kesc.id_group AND kgl.id_lang=1
                                                WHERE kesc.id_supplier=".$id_supplier);
    }
}
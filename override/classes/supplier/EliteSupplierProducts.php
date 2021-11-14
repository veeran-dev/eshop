<?php
/*
*
* Supplier and Products Mapping
*
*/
class EliteSupplierProductsCore extends ObjectModel
{
    /** @var int Supplier ID */
    public $id_supplier;

    /** @var int Product ID */
    public $id_product;

    /** @var bool active */
    public $active;

    /** @var datetime added date */
    public $date_add;

    public static $definition = array(
        'table' => 'elite_supplier_products',
        'primary' => 'id_supplier_product',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier Address */
            'id_supplier' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'id_product' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'active'    =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add' =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );

    public static function checkAvailabillity($id_supplier, $id_product){
        /** check product availabillity with supplier **/
        $query = "SELECT kess.`out_of_stock`,kes.`company` from "._DB_PREFIX_."elite_supplier_stock  kess
                        LEFT JOIN "._DB_PREFIX_."elite_supplier kes on kes.id_supplier=kess.id_supplier
                        where kess.id_supplier=".$id_supplier." and kess.id_product=".$id_supplier."";
        $result = Db::getInstance()->ExecuteS($query);

        return $result[0]['out_of_stock'] == 1 ? $result[0]['company'] : '';
    }

    public static function topSoldProducts($id_supplier, $from = null, $to = null){
        $sales_status = Configuration::get('KOB_SUP_SALE_STATUS');
        $filter = "";
        if($from && $to){
            $filter = " AND koh.date_add between '".$from."' and '".$to."'";
        }
        $query = "SELECT k.`product_id`, k.`product_reference`, k.`product_name`, SUM(k.`product_quantity`) as cnt FROM(
                    SELECT DISTINCT(kod.id_order), kod.`product_id`, kod.`product_reference`, kod.`product_name`, kod.`product_quantity` 
                    FROM "._DB_PREFIX_."elite_supplier_orders keso
                    LEFT JOIN `"._DB_PREFIX_."orders` ko ON ko.id_order=keso.id_order
                    LEFT JOIN `"._DB_PREFIX_."order_detail` kod ON kod.id_order=ko.id_order
                    LEFT JOIN "._DB_PREFIX_."order_history koh ON koh.id_order=keso.id_order AND koh.id_order_state IN(".$sales_status.")
                    LEFT JOIN "._DB_PREFIX_."order_history koha ON koha.id_order=koh.id_order
                    WHERE keso.id_supplier=".$id_supplier."
                    AND koha.id_order_history in(select max(id_order_history) from "._DB_PREFIX_."order_history where id_order = koh.id_order)
                     ) as k
                    WHERE k.product_id is NOT NULL
                    GROUP BY k.product_id
                    order by cnt desc
                    LIMIT 4";
        $result = Db::getInstance()->ExecuteS($query);
        return $result;
    }

    public static function tagCategory($id_category, $id_supplier){

        $sql = "select DISTINCT(kpm.`zone_id`) as zone from "._DB_PREFIX_."elite_supplier_address kesa
                    LEFT JOIN "._DB_PREFIX_."address ka on ka.id_address=kesa.id_address
                    LEFT JOIN "._DB_PREFIX_."pincode_master kpm on kpm.id_state = ka.id_state
                    where kesa.id_supplier=".$id_supplier;
        
        $zone = Db::getInstance()->ExecuteS($sql)[0]['zone'];
        
        $zone_sql = "INSERT INTO `kob_elite_supplier_zone` (id_supplier, id_product, id_zone, moq) 
                        SELECT ".$id_supplier.",id_product,".$zone.",0  from "._DB_PREFIX_."category_product kcp where id_category=".$id_category."";

        $stock_sql = "INSERT INTO `kob_elite_supplier_stock` (id_supplier, id_product, out_of_stock)
                        SELECT ".$id_supplier.",id_product, 0  from "._DB_PREFIX_."category_product kcp where id_category=".$id_category."";

        $zone_result = Db::getInstance()->Execute($zone_sql);
        $stock_result = Db::getInstance()->Execute($stock_sql);
    }

    public static function getSuppliersForQuotation($id_product, $inStock = false, $level_two = true, $zone = null){
        $logger = new FileLogger();
        $logger->setFilename("test1.txt");
        $logger->logError("======");
        $oos = $inStock == true ? "AND kes.out_of_stock=0":"";
        $zone = $zone != null ? " AND kez.id_zone IN(select zone_id from "._DB_PREFIX_."pincode_master where zone_pin_start <= ".$zone." and zone_pin_end >= ".$zone.")":null;

        $sql = "select GROUP_CONCAT(DISTINCT(kes.id_supplier)) as suppliers 
                    from "._DB_PREFIX_."elite_supplier_stock kes 
                    LEFT JOIN "._DB_PREFIX_."elite_supplier_zone kez ON kes.id_product=kez.id_product AND kes.id_supplier=kez.id_supplier
                    where kes.id_product=".$id_product." ".$zone." ".$oos;
        $level_one = Db::getInstance()->ExecuteS($sql);
        $logger->logError($sql);
        $logger->logError($level_one);
        if($level_two == true){
            $sql = "SELECT GROUP_CONCAT(map.id_supplier) as suppliers FROM kob_category_product kcp
                    LEFT JOIN `kob_supplier_category_auto_map` map ON `map`.c_list IN(`kcp`.id_category)
                    LEFT JOIN "._DB_PREFIX_."elite_supplier_zone kez ON map.id_supplier=kez.id_supplier
                    where kcp.id_product=".$id_product." ".$zone;
            $level_two = Db::getInstance()->ExecuteS($sql);

            $logger->logError($sql);
            $logger->logError($level_two);

            $x = $level_one[0]['suppliers'];
            $y = $level_two[0]['suppliers'];
            $logger->logError($x);
            $logger->logError($y);
            $z = $x.",".$y;
            $logger->logError($z);
            $return = array_unique(explode(",", $z));
            return $return;
        }
        else{
            return array_unique(explode(",",$level_one));
        }
    }
    
    public static function addStockDetails($id_supplier, $id_product, $oos = 0){
        $logger = new FileLogger();
        $logger->setFilename("testbo.txt");
        $logger->logError("addStockDetails");
        
        $stock_query = "SELECT * FROM `kob_elite_supplier_stock` WHERE id_supplier=".$id_supplier." AND id_product=".$id_product;
        $stock_res = Db::getInstance()->ExecuteS($stock_query);
        
        $logger->logError($stock_query);
        $logger->logError($stock_res);
        
        if(!$stock_res){
            $stock_sql = "INSERT INTO `kob_elite_supplier_stock` (id_supplier, id_product, out_of_stock)
                                values(".$id_supplier.",".$id_product.",".$oos.")";
            $logger->logError($stock_sql);
            return Db::getInstance()->Execute($stock_sql);
        }   
        else{
            return false;
        }
    }

    public static function addZoneDetails($id_supplier, $id_product, $id_zone, $moq = 1){
        $zone_query = "SELECT * FROM `kob_elite_supplier_zone` WHERE id_supplier=".$id_supplier." AND id_product=".$id_product;
        $zones_res = Db::getInstance()->ExecuteS($zone_query);
        if(!$zones_res){
            $zone_sql = "INSERT INTO `kob_elite_supplier_zone` (id_supplier, id_product, id_zone, moq) 
                                values(".$id_supplier.",".$id_product.",".$id_zone.",".$moq.")";
            $zone_result = Db::getInstance()->Execute($zone_sql);
            return $zone_result;
        }
        else{
            return false;
        }
    }
}


<?php
/*
*
* Supplier and Products Mapping
*
*/
class EliteSupplierZoneCore extends ObjectModel
{
    /** @var int Supplier ID */
    public $id_supplier;

    /** @var int Product ID */
    public $id_product;

    /** @var bool active */
    public $id_zone;

    /** @var datetime added date */
    public $moq;
  
    public static function getSuppliersDetails($id_product, $pincode){
        $zone = $pincode != undefined && $pincode > 0 ? " and pincode.zone_pin_start<=".$pincode." AND pincode.zone_pin_end >=".$pincode: "";
        // $year = now();
        // var_dump($year);
        $sql = "SELECT DISTINCT(supplier.id_supplier), supplier.reference,(YEAR(NOW())-YEAR(supplier.established)) as established, supplier.ratings as ratings, supplier.response_time, supplier.orders_processed,       zone.* 
                    from "._DB_PREFIX_."elite_supplier_zone zone 
                    LEFT JOIN "._DB_PREFIX_."elite_supplier_stock stock ON (stock.id_product = zone.id_product AND stock.id_supplier = zone.id_supplier)
                    LEFT JOIN kob_pincode_master as pincode ON zone.id_zone = pincode.zone_id
                    LEFT JOIN "._DB_PREFIX_."elite_supplier supplier ON zone.id_supplier = supplier.id_supplier 
                    where zone.id_product=".$id_product." ".$zone." AND stock.out_of_stock=0
                    GROUP by supplier.id_supplier";
            // var_dump($sql);
        $result = Db::getInstance()->executeS($sql);
        return $result;
    }

}
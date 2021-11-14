<?php
/*
*
* Elite Supplier Master
*
*/
class SupplierInventoryCore extends ObjectModel
{
    /** @var String name of supplier */
    public $name;

    /** @var String email */
    public $id_address;

    /** @var string password */
    public $date_add;

    /** @var bool active */
    public $date_upd;

    const WAREHOUSE_MANAGER    = 1;  /* 00001 */

    public static $definition = array(
        'table' => 'supplier_inventory',
        'primary' => 'id_inventory',
        'multilang' => false,
        'fields' => array(
            /* EliteSupplier master */
            'name' =>   array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128),
            'id_address' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'date_add' =>                    array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' =>                    array('type' => self::TYPE_DATE, 'validate' => 'isDate'),

        )
    );

    public static function getInventories($id_supplier){
        $supplier = new EliteSupplier($id_supplier);
        $isChild = $supplier->isChild();
    	if($child == true){
            //, ksw.id_parent, ksw.id_supplier, ksw.id_address
    		$sql ="SELECT ksw.id_inventory as value, ksw.name as label FROM "._DB_PREFIX_."supplier_inventory ksw 
    				LEFT join kob_supplier_inventory_map map on ksw.id_inventory=map.id_inventory
    				WHERE map.id_supplier=".$id_supplier;
		}
		else{
            //, ksw.id_parent, ksw.id_supplier, ksw.id_address
			$sql ="SELECT ksw.id_inventory as value, ksw.name as label FROM "._DB_PREFIX_."supplier_inventory ksw 
    				LEFT join kob_supplier_inventory_map map on ksw.id_inventory=map.id_inventory
    				WHERE map.id_parent=".$id_supplier;	
		}
        return Db::getInstance()->ExecuteS($sql);
    }

    public function tagSupplier($parent, $child){
        return Db::getInstance()->insert('supplier_inventory_map', array('id_inventory' => $this->id, 'id_parent' => $parent, 'id_supplier' => $child));
    }

    public function tagProfile($profile){
        return Db::getInstance()->insert('supplier_profile_map', array('id_supplier' => $this->id, 'id_profile' => $profile));   
    }

    public static function getInventoryProducts($id_supplier, $id_inventory){
        $inventory = $id_inventory!= undefined && $id_inventory > 0 ? "AND map.id_inventory=".$id_inventory:"";
        $sql ="SELECT * FROM kob_supplier_inventory ksw 
                    LEFT join kob_supplier_inventory_map map on ksw.id_inventory=map.id_inventory
                    LEFT JOIN kob_supplier_inventory_products ksip ON ksip.id_inventory=map.id_inventory
                    LEFT JOIN kob_product_lang kpl ON kpl.id_product=ksip.id_products AND kpl.id_lang=1
                    LEFT JOIN kob_product kp ON kp.id_product=kpl.id_product
                    WHERE map.id_parent=".$id_supplier." ".$inventory."
                    AND ksw.id_inventory IN(SELECT MIN(id_inventory) FROM kob_supplier_inventory_map WHERE id_parent=".$id_supplier." )";
        
        // print_r($sql);
        $products = Db::getInstance()->ExecuteS($sql);
        foreach($products as &$product){
            $coverImage = Image::getCover($product['id_product']);
            $product['cover'] = $product['id_product'].'-'.$coverImage['id_image'];
            if (!$coverImage['id_image'])
                $product['cover'] = Language::getIsoById((int)($id_lang)).'-default';

            $linkObj = new Link();
            $product['imageLink'] = $linkObj->getImageLink($product['link_rewrite'], $product['cover'], 'small');
        }
        return $products;
    }

    public static function addProducts($id_inventory, $id_product, $stock){
        $logger = new FileLogger();
        $logger->setFilename('test_sco.txt');
        $logger->logError('===='.$id_product);
        $logger->logError('===='.$stock);
        $res = Db::getInstance()->insert('supplier_inventory_products', array('id_inventory' => $id_inventory, 'id_product' => $id_product, 'stock' => $stock));
        $logger->logError($res);
        return $res;
    }
}
<?php
class Product extends ProductCore
{
    public static function getSRWProducts($id_srw=null, $page=0, $size=12){
        $category = "";
        if($id_srw){
            $category = " WHERE map.id_srw =".$id_srw;
        }
        $page = $page*$size;
        $limit = " LIMIT ".$page.", ".$size;
        $sql = "SELECT kp.id_product, kp.reference, kpl.name, kp.id_category_default, kpl.link_rewrite, kp.price 
                    FROM `kob_srw_category_map` map
                    LEFT JOIN kob_product kp ON kp.id_category_default = map.id_category
                    LEFT JOIN kob_product_lang kpl ON kpl.id_product=kp.id_product".$category." ".$limit;
        // print_r($sql);
        $results = Db::getInstance()->ExecuteS($sql);
        foreach ($results as &$result) {
            $result['price'] = Tools::ps_round(Product::getPriceStatic((int)$result['id_product'], true, null, 6), 2);
            $coverImage = Image::getCover($result['id_product']);
            $result['cover'] = $result['id_product'].'-'.$coverImage['id_image'];
            if (!$coverImage['id_image'])
            $result['cover'] = Language::getIsoById((int)($id_lang)).'-default';

            $linkObj = new Link();
            $result['imageLink'] = $linkObj->getImageLink($result['link_rewrite'], $result['cover'], 'large');
        }
        return $results;
    }
    
    public static function getSRWProductsCount($id_srw=null){
        $category = "";
        if($id_srw){
            $category = " WHERE map.id_srw =".$id_srw;
        }
        $sql = "SELECT COUNT(DISTINCT(kp.id_product)) as count
                    FROM `kob_srw_category_map` map
                    LEFT JOIN kob_product kp ON kp.id_category_default = map.id_category
                    LEFT JOIN kob_product_lang kpl ON kpl.id_product=kp.id_product".$category;
        
        $results = Db::getInstance()->ExecuteS($sql);
        return $results[0]['count'];
    }
    public static function getProductProperties($id_lang, $row, Context $context = null)
    {
        if (!$row['id_product'])
            return false;

        if(!Product::getHsnAvailability($row['id_product']))
            return false;

        if ($context == null) {
            $context = Context::getContext();
        }
        if (ProductComment::getAverageGrade($row['id_product'])) {
            $row['ratings'] = ProductComment::getAverageGrade($row['id_product']);
            $row['nbComments'] = (int)(ProductComment::getCommentNumber($row['id_product']));
        }
        else{
            $row['ratings'] = 0;
            $row['nbComments'] = 0;
        }
        $id_product_attribute = $row['id_product_attribute'] = (!empty($row['id_product_attribute']) ? (int)$row['id_product_attribute'] : null);

        // Product::getDefaultAttribute is only called if id_product_attribute is missing from the SQL query at the origin of it:
        // consider adding it in order to avoid unnecessary queries
        
        $row['allow_oosp'] = Product::isAvailableWhenOutOfStock($row['out_of_stock']);
         if (Combination::isFeatureActive() && $id_product_attribute === null
            && ((isset($row['cache_default_attribute']) && ($ipa_default = $row['cache_default_attribute']) !== null)
                || ($ipa_default = Product::getDefaultAttribute($row['id_product'], !$row['allow_oosp'])))) {
            $id_product_attribute = $row['id_product_attribute'] = $ipa_default;
        }
        if (!Combination::isFeatureActive() || !isset($row['id_product_attribute'])) {
            $id_product_attribute = $row['id_product_attribute'] = 0;
        }

        // Tax
        $usetax = Tax::excludeTaxeOption();

        $cache_key = $row['id_product'].'-'.$id_product_attribute.'-'.$id_lang.'-'.(int)$usetax;
        if (isset($row['id_product_pack'])) {
            $cache_key .= '-pack'.$row['id_product_pack'];
        }

        if (isset(self::$producPropertiesCache[$cache_key])) {
            return array_merge($row, self::$producPropertiesCache[$cache_key]);
        }
         // Datas
        $row['category'] = Category::getLinkRewrite((int)$row['id_category_default'], (int)$id_lang);
       //$row['link'] = $context->link->getProductLink((int)$row['id_product'], $row['link_rewrite'], $row['category'], $row['ean13']);
       $row['link'] = $context->link->getProductLink((int)$row['id_product'], $row['link_rewrite'], $row['category']);

        $row['attribute_price'] = 0;
        if ($id_product_attribute) {
            $row['attribute_price'] = (float)Product::getProductAttributePrice($id_product_attribute);
        }

        $row['price_tax_exc'] = Product::getPriceStatic(
            (int)$row['id_product'],
            false,
            $id_product_attribute,
            (self::$_taxCalculationMethod == PS_TAX_EXC ? 2 : 6)
        );

        if (self::$_taxCalculationMethod == PS_TAX_EXC) {
            $row['price_tax_exc'] = Tools::ps_round($row['price_tax_exc'], 2);
            $row['price'] = Product::getPriceStatic(
                (int)$row['id_product'],
                true,
                $id_product_attribute,
                6
            );
            $row['price_without_reduction'] = Product::getPriceStatic(
                (int)$row['id_product'],
                false,
                $id_product_attribute,
                2,
                null,
                false,
                false
            );
        } else {
            $row['price'] = Tools::ps_round(
                Product::getPriceStatic(
                    (int)$row['id_product'],
                    true,
                    $id_product_attribute,
                    6
                ),
                (int)Configuration::get('PS_PRICE_DISPLAY_PRECISION')
            );
            $row['price_without_reduction'] = Product::getPriceStatic(
                (int)$row['id_product'],
                true,
                $id_product_attribute,
                6,
                null,
                false,
                false
            );
        }

        $row['reduction'] = Product::getPriceStatic(
            (int)$row['id_product'],
            (bool)$usetax,
            $id_product_attribute,
            6,
            null,
            true,
            true,
            1,
            true,
            null,
            null,
            null,
            $specific_prices
        );

        $row['specific_prices'] = $specific_prices;

        $row['quantity'] = Product::getQuantity(
            (int)$row['id_product'],
            0,
            isset($row['cache_is_pack']) ? $row['cache_is_pack'] : null
        );

        $row['quantity_all_versions'] = $row['quantity'];

        if ($row['id_product_attribute']) {
            $row['quantity'] = Product::getQuantity(
                (int)$row['id_product'],
                $id_product_attribute,
                isset($row['cache_is_pack']) ? $row['cache_is_pack'] : null
            );
        }

        $coverImage = Image::getCover($row['id_product']);
        $row['cover'] = $row['id_product'].'-'.$coverImage['id_image'];
        if (!$coverImage['id_image'])
            $row['cover'] = Language::getIsoById((int)($id_lang)).'-default';

        $linkObj = new Link();
        $row['imageLink'] = $linkObj->getImageLink($row['link_rewrite'], $row['cover'], 'small');
        $row['imageLink2'] = $linkObj->getImageLink($row['link_rewrite'], $row['cover'], 'large');

        $row['features'] = Product::getFrontFeaturesStatic((int)$id_lang, $row['id_product']);
        $manufacturerObj = new Manufacturer((int)($row['id_manufacturer']));
        $row['manufacturer'] = $manufacturerObj->name;

        $row['attachments'] = array();
        if (!isset($row['cache_has_attachments']) || $row['cache_has_attachments']) {
            $row['attachments'] = Product::getAttachmentsStatic((int)$id_lang, $row['id_product']);
        }

        $row['virtual'] = ((!isset($row['is_virtual']) || $row['is_virtual']) ? 1 : 0);

        // Pack management
        $row['pack'] = (!isset($row['cache_is_pack']) ? Pack::isPack($row['id_product']) : (int)$row['cache_is_pack']);
        $row['packItems'] = $row['pack'] ? Pack::getItemTable($row['id_product'], $id_lang) : array();
        $row['nopackprice'] = $row['pack'] ? Pack::noPackPrice($row['id_product']) : 0;
        if ($row['pack'] && !Pack::isInStock($row['id_product'])) {
            $row['quantity'] = 0;
        }

        $row['customization_required'] = false;
        if (isset($row['customizable']) && $row['customizable'] && Customization::isFeatureActive()) {
            if (count(Product::getRequiredCustomizableFieldsStatic((int)$row['id_product']))) {
                $row['customization_required'] = true;
            }
        }

        if($available_regions = FulfillmentCentreCore::getProductAvailableZones($row['id_product'])) {
            $row['available_regions'] = $available_regions;
        }

        $row['product_status'] = Product::getProductStatus($row['id_product']);

        $row = Product::getTaxesInformations($row, $context);
        self::$producPropertiesCache[$cache_key] = $row;
        return self::$producPropertiesCache[$cache_key];
    }

    public static function getProductsPropertiesMini($id_lang, $query_result) {
        $results_array = array();
        if (is_array($query_result)) {
            foreach ($query_result as $row) {
                if ($row2 = Product::getProductPropertiesMini($id_lang, $row)) {
                    $results_array[] = $row2;
                }
            }
        }

        return $results_array;
    }

    public static function getProductsPropertiesSupplier($id_lang, $query_result) {
        $results_array = array();
        if (is_array($query_result)) {
            foreach ($query_result as $row) {
                $q = Product::getProductPropertiesSupplier($id_lang, $row);
                array_push($results_array, $q);
            }
        }
        
        
        return $results_array;
    }

    public static function getProductPropertiesSupplier($id_lang, $row, Context $context = null) {
        if (!$row['id_product'])
            return false;
        
        if(!Product::getHsnAvailability($row['id_product']))
            return false;

        if ($context == null)
            $context = Context::getContext();

        $linkObj = new Link();
        if($row['id_specific_price'] != undefined && $row['id_specific_price'] > 0){
            $row['id_specific_price'] = $row['id_specific_price'];
            $supplierData = EliteSupplierPrices::getSupplierDetails($row['id_specific_price']);
            $row['id_supplier'] = $supplierData['0']['id_supplier'];
            $row['company'] = $supplierData['0']['company'];
        }
        $id_product_attribute = $row['id_product_attribute'] = (!empty($row['id_product_attribute']) ? (int)$row['id_product_attribute'] : null);
        // Tax
        $usetax = Tax::excludeTaxeOption();

        $cache_key = $row['id_product'].'-'.$id_product_attribute.'-'.$id_lang.'-'.(int)$usetax;
        if(!$row['price_tax_exc'])
            $row['price_tax_exc'] = Tools::ps_round(Product::getPriceStatic((int)$row['id_product'], false, $id_product_attribute, (self::$_taxCalculationMethod == PS_TAX_EXC ? 2 : 6)), 2);
        $row['price'] = Tools::ps_round(Product::getPriceStatic((int)$row['id_product'], true, $id_product_attribute, 6), 2);
        
        if (self::$_taxCalculationMethod == PS_TAX_EXC)
            $row['price_without_reduction'] = Product::getPriceStatic((int)$row['id_product'], false, $id_product_attribute, 2, null, false, false);
        else
            $row['price_without_reduction'] = Product::getPriceStatic((int)$row['id_product'], true, $id_product_attribute, 6, null, false, false);

        $row['reduction'] = Product::getPriceStatic((int)$row['id_product'], (bool)$usetax, $id_product_attribute, 6, null, true, true, 1, true, null, null, null, $specific_prices);

        $row['specific_prices'] = $specific_prices;
        $product= new Product($row['id_product']);
        $row['minimal_quantity'] = $product->minimal_quantity;

        $row['quantity'] = Product::getQuantity((int)$row['id_product'], 0, isset($row['cache_is_pack']) ? $row['cache_is_pack'] : null);

        $row['quantity_all_versions'] = $row['quantity'];

        $coverImage = Image::getCover($row['id_product']);
        $row['cover'] = $row['id_product'].'-'.$coverImage['id_image'];
        
        if (!$coverImage['id_image'])
            $row['cover'] = Language::getIsoById((int)($id_lang)).'-default';

        
        $row['imageLink'] = $linkObj->getImageLink($row['link_rewrite'], $row['cover'], 'large');
        $row['features'] = Product::getFrontFeaturesStatic((int)$id_lang, $row['id_product']);
        $manufacturerObj = new Manufacturer((int)($row['id_manufacturer']));
        $row['manufacturer'] = $manufacturerObj->name;
        $row['virtual'] = ((!isset($row['is_virtual']) || $row['is_virtual']) ? 1 : 0);

        if (ProductComment::getAverageGrade($row['id_product'])) {
            $row['ratings'] = ProductComment::getAverageGrade($row['id_product']);
            $row['nbComments'] = (int)(ProductComment::getCommentNumber($row['id_product']));
        }
        else{
            $row['ratings'] = 0;
            $row['nbComments'] = 0;
        }

        $row = Product::getTaxesInformations($row, $context);
        self::$producPropertiesCache[$cache_key] = $row;
        return self::$producPropertiesCache[$cache_key];
    }
    public static function getProductPropertiesMini($id_lang, $row, Context $context = null) {
        if (!$row['id_product'])
            return false;
        
        if(!Product::getHsnAvailability($row['id_product']))
            return false;

        if ($context == null)
            $context = Context::getContext();

        $linkObj = new Link();
        if($row['id_supplier_price'] != undefined && $row['id_supplier_price'] > 0){
            $row['id_supplier_price'] = $row['id_supplier_price'];
        }
        $row['allow_oosp'] = Product::isAvailableWhenOutOfStock($row['out_of_stock']);
        $id_product_attribute = $row['id_product_attribute'] = (!empty($row['id_product_attribute']) ? (int)$row['id_product_attribute'] : null);
        // Tax
        $usetax = Tax::excludeTaxeOption();

        $cache_key = $row['id_product'].'-'.$id_product_attribute.'-'.$id_lang.'-'.(int)$usetax;
        
        if (isset(self::$producPropertiesCache[$cache_key])){
            return array_merge($row, self::$producPropertiesCache[$cache_key]);
        }

        $row['price_tax_exc'] = Tools::ps_round(Product::getPriceStatic((int)$row['id_product'], false, $id_product_attribute, (self::$_taxCalculationMethod == PS_TAX_EXC ? 2 : 6)), 2);
        $row['price'] = Tools::ps_round(Product::getPriceStatic((int)$row['id_product'], true, $id_product_attribute, 6), 2);
        
        if (self::$_taxCalculationMethod == PS_TAX_EXC)
            $row['price_without_reduction'] = Product::getPriceStatic((int)$row['id_product'], false, $id_product_attribute, 2, null, false, false);
        else
            $row['price_without_reduction'] = Product::getPriceStatic((int)$row['id_product'], true, $id_product_attribute, 6, null, false, false);

        $row['reduction'] = Product::getPriceStatic((int)$row['id_product'], (bool)$usetax, $id_product_attribute, 6, null, true, true, 1, true, null, null, null, $specific_prices);

        $row['specific_prices'] = $specific_prices;
        $product= new Product($row['id_product']);
        $row['minimal_quantity'] = $product->minimal_quantity;

        $row['quantity'] = Product::getQuantity((int)$row['id_product'], 0, isset($row['cache_is_pack']) ? $row['cache_is_pack'] : null);

        $row['quantity_all_versions'] = $row['quantity'];

        $coverImage = Image::getCover($row['id_product']);
        $row['cover'] = $row['id_product'].'-'.$coverImage['id_image'];
        
        if (!$coverImage['id_image'])
            $row['cover'] = Language::getIsoById((int)($id_lang)).'-default';

        
        $row['imageLink'] = $linkObj->getImageLink($row['link_rewrite'], $row['cover'], 'large');

        $row['virtual'] = ((!isset($row['is_virtual']) || $row['is_virtual']) ? 1 : 0);

        if (ProductComment::getAverageGrade($row['id_product'])) {
            $row['ratings'] = ProductComment::getAverageGrade($row['id_product']);
            $row['nbComments'] = (int)(ProductComment::getCommentNumber($row['id_product']));
        }
        else{
            $row['ratings'] = 0;
            $row['nbComments'] = 0;
        }

        $row = Product::getTaxesInformations($row, $context);
        self::$producPropertiesCache[$cache_key] = $row;
        return self::$producPropertiesCache[$cache_key];
    }

    public function insertUpdateZone($id_product, $zones)
    {
        $db = Db::getInstance();
        $available_zones = FulfillmentCentre::getAllFCentres();
        $values = array();

        if(isset($zones) && !empty($zones)) {
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'product_zone_mapping` WHERE product_id = '.$id_product);

            if(count($available_zones) == count($zones) || in_array(0, $zones)) {
               return Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'product_zone_mapping` (`product_id`, `zone_id`) VALUES ('.$id_product.', 0)'); 
            }
            else {
                foreach ($zones as $key => $fc) {
                    $values[] = "(".$id_product.",".$fc.")";
                }
                return Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'product_zone_mapping` (`product_id`, `zone_id`) VALUES '.implode(",", $values));
            }
        }
    }

    public static function saveOldPrice($id_product,$old_price,$new_price,$id_group,$id_employee)
    {
        Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'price_history`(`id_product`, `id_group`, `old_price`, `new_price`, `id_employee`) VALUES ('.$id_product.','.$id_group.','.$old_price.','.$new_price.','.$id_employee.')');
    }

    public function removeZone($id_product, $id_zone)
    {
        Db::getInstance()->Execute('
                DELETE FROM `'._DB_PREFIX_.'product_zone_mapping` WHERE product_id='.$id_product.' and zone_id='.$id_zone);
    }

    public function removeAllZone($id_product)
    {
        Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_zone_mapping` WHERE product_id='.$id_product.'');
    }     

    public function getProductZones($id_product)
    {
        $product='';
        if($id_product)
            $product='WHERE a.`product_id` = '.$id_product;
        return Db::getInstance()->ExecuteS('SELECT a.`zone_id` 
                                            FROM `'._DB_PREFIX_.'product_zone_mapping` a '.$product);
    }

    public function getProductQuickviewDetails($id_product, $id_supplier = 0, $id_customer = 0)
    {
        if($id_customer) {
            $customer = new Customer(intval($id_customer));
            $id_group = $customer->id_default_group;
        }
        $context = Context::getContext();
        $id_state = $context->cookie->id_state;

        if($id_supplier) {
            return Db::getInstance()->ExecuteS('SELECT DISTINCT(sp.`id_specific_price`), sp.`price` AS sp_price, p.`id_product`, p.`reference`, p.`id_manufacturer`, pl.`description_short`, pl.`description`, 
                pl.`name`, pl.`link_rewrite`, es.`name` AS supplier_name, es.`id_supplier`, sp.`price` AS price_tax_exc
              FROM '._DB_PREFIX_.'specific_price sp
              LEFT JOIN `'._DB_PREFIX_.'map_specific_price` kmsp on kmsp.id_specific_price=sp.id_specific_price
              LEFT JOIN `'._DB_PREFIX_.'elite_supplier` as es ON (sp.`id_supplier` = es.`id_supplier`)
              LEFT JOIN `'._DB_PREFIX_.'product` as p ON (sp.`id_product` = p.`id_product`) 
              LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.`id_product` = pl.`id_product`) AND pl.`id_lang` = 1
              WHERE kmsp.id_state='.$id_state.' AND
              sp.`id_product` = '.$id_product.'
              AND sp.`id_supplier` = '.$id_supplier.'
              AND sp.`id_group` = '.($id_group ? $id_group : 0).''
            );
        }

        return Db::getInstance()->ExecuteS('SELECT p.*,pl.`description_short`, pl.`description`, pl.`name`, pl.`link_rewrite`
          FROM '._DB_PREFIX_.'product p 
          LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.`id_product` = pl.`id_product`) AND pl.`id_lang` = 1
          WHERE p.`id_product` = '.$id_product.''
        );
    }

    public function getSuperParentCategoryName($id_product)
    {
        return Db::getInstance()->getValue('SELECT  cat_lang.name as category
        FROM  '._DB_PREFIX_.'product as product, '._DB_PREFIX_.'category as node, '._DB_PREFIX_.'category as parent,'._DB_PREFIX_.'category_lang cat_lang
                WHERE   product.id_product = '.$id_product.'                 
                AND     product.`id_category_default` = node.`id_category`
                AND     node.nleft BETWEEN parent.nleft AND parent.nright
                AND     parent.level_depth=1
                AND     parent.id_category = cat_lang.`id_category`
                AND     cat_lang.`id_lang`= 1');     
    }

    public static function getProductDetail($id_product,$old_vat_name = NULL , $new_vat_name = NUll)
    {
        if($old_vat_name !="")
        {
            $select_qry = ',p.id_tax_rules_group, (select name from kob_tax_rules_group where id_tax_rules_group ='.$old_vat_name.') as old_vat_name,(select name from kob_tax_rules_group where id_tax_rules_group ='.$new_vat_name.') as new_vat_name';
            $join_qry = 'left join '._DB_PREFIX_.'tax_rules_group as trg
                                        on trg.id_tax_rules_group = p.id_tax_rules_group';
        }
        else
        {
            $join_qry='';
            $select_qry ='';
        }
        
        return Db::getInstance()->getRow('select p.reference,pl.name as product_name '.$select_qry.'
                                        from '._DB_PREFIX_.'product as p
                                        left join '._DB_PREFIX_.'product_lang as pl
                                        on pl.id_product = p.id_product
                                        '.$join_qry.'
                                        where p.id_product = '.$id_product.'  and id_lang=1 ');
        

    }

    public function getIdByReference($referenceID){
        return Db::getInstance()->getValue('SELECT id_product FROM 
                                            '._DB_PREFIX_.'product
                                            WHERE reference = '.$referenceID.'');
    }

    public function getSpecificProducts($productIds){
        return Db::getInstance()->ExecuteS('SELECT p.*, pl.`name`, pl.`link_rewrite`, pl.`description_short`
                                            FROM '._DB_PREFIX_.'product p
                                            LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.`id_product` = pl.`id_product`) AND pl.`id_lang` = 1
                                            WHERE p.`id_product` IN('.$productIds.') ORDER BY pl.`name` ASC'); 
    }

    public function getProductLastOrderedDate($idProduct, $idCustomer){
        return Db::getInstance()->ExecuteS('SELECT DATE_FORMAT(o.`date_add`, "%M %d, %Y") AS date_add FROM `kob_orders` o
                                            LEFT JOIN `kob_order_detail` od ON o.`id_order` = od.`id_order`
                                            WHERE od.`product_id` = '.(int)$idProduct.' 
                                            AND o.`id_customer` = '.(int)$idCustomer.'
                                            ORDER BY od.`id_order_detail` 
                                            DESC LIMIT 1');
    }

    public function getAvailableNow()
    {
        return Db::getInstance()->getValue('SELECT available_now FROM 
                                            '._DB_PREFIX_.'product_lang
                                            WHERE id_product='.$this->id.'');   
    }

    public static function getHsnAvailability($id_product) {
        return Db::getInstance()->getValue('SELECT IF(p.`hsn_code` IS NOT NULL, 1, 0) AS hsn_code 
                                          FROM '._DB_PREFIX_.'product p WHERE p.`id_product` = '.intval($id_product).'');
    }

    public function getProductAvailableLocations() {
        $mapped_to_all = Db::getInstance()->getValue('SELECT IF(`zone_id` != "" OR `zone_id` != NULL, true, false) AS mapped
                                            FROM `'._DB_PREFIX_.'product_zone_mapping`
                                            WHERE `zone_id` = 0 AND product_id = '.$this->id);
        if($mapped_to_all) {
            $sql = 'SELECT id_fulfillment_centre FROM `'._DB_PREFIX_.'fulfillment_centre`';
        }
        else {
            $sql = 'SELECT fc.`id_fulfillment_centre`
                FROM `'._DB_PREFIX_.'product_zone_mapping` pzm
                LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` fc ON pzm.`zone_id` = fc.`id_fulfillment_centre`
                WHERE pzm.`product_id` = '.$this->id.' GROUP BY pzm.`zone_id`';
        }
        
        return Db::getInstance()->ExecuteS($sql);
    }

    public static function getProductStatus($id_product) 
    {
        $product = new Product($id_product);
        
        $out_of_stock = StockAvailable::outOfStock($product->id);
        $quantity = StockAvailable::getQuantityAvailableByProduct($product->id);

        $status = 'Available';
        
        if($product->discontinued) {
            $status = 'Discontinued';
        }
        else if(!$product->active) {
            $status = 'Disabled';
        }
        else if(!$product->available_for_order) {
            $status = 'Not available';
        }
        else if(!$out_of_stock && $quantity <= 0) {
            $status = 'Out of Stock';
        }

        return $status;
    }

    public function getRateContractProducts() {
        $now = date('Y-m-d H:i:s');
        $sql = 'SELECT sp.* FROM `'._DB_PREFIX_.'specific_price` sp 
                WHERE sp.`id_product` = '.$this->id.' 
                AND ((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) 
                AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`))';
        return Db::getInstance()->ExecuteS($sql);
    }
    public function validatePrice($price = 0, $buying_price = 0, $region_prices = NULL, $csv_validate = false, $use_tax = false, $reduction_price = 0, $name = NULL) {
        $product = new Product($this->id, false, 1);
        $price_tax_exclusive = $product->price;
        $wholesale_price = $product->wholesale_price;
        $product_name = $product->name;
        $zonal_prices = isset($this->id) ? ZonalPrice::getPrices($this->id) : array();
        $errors = array();

        if(isset($price) && $price) {
            
            if($use_tax) {
                $price_tax_exclusive = $price / (1 + (Tax::getProductTaxRate($product->id) / 100));
            }

            $price_tax_exclusive = $price;
        }

        if(isset($buying_price) && $buying_price) {
            $wholesale_price = $buying_price;
        }

        if(isset($name) && $name != "") {
            $product_name = $name;
        }

        if($price_tax_exclusive) {
            /**
            * Get rate contract products associated with this product
            * If price is greater than product price expire them
            * After expire set comment called quoted price is greater than MRP
            */
            if(!$csv_validate && isset($this->id)) { // This action not needed for csv validation purpose. Allow team to upload prices.
                $rate_contract_products = $this->getRateContractProducts();

                if(!empty($rate_contract_products)) {
                    foreach ($rate_contract_products as $rc_product) {
                        $specific_price = new SpecificPrice(intval($rc_product['id_specific_price']));
                        $group = new Group(intval($specific_price->id_group), 1);
                        if($price_tax_exclusive != $product->price) {
                            $to_date = $specific_price->to;
                            $specific_price->to = date('Y-m-d H:i:s');
                            if($specific_price->update()) {
                                $content['0'] = array('from' => $to_date, 'to' => $specific_price->to);
                                CatalogHistory::addHistory('rcp_expired', $this->id, $content);
                            }

                            $errors[] = Tools::displayError("Price Change: Rate contract price for the company ".$group->name." has been expired.");
                        }
                    }
                }
            }

            if($wholesale_price && $wholesale_price > $price_tax_exclusive) { //If wholesale price exceeds MRP
                $errors[] = Tools::displayError("Wholesale price exceeds MRP for the product " . $product_name);
            }

            if((empty($region_prices) || !$region_prices) && !empty($zonal_prices)) { // For existing zonal prices with product prices check
                foreach ($zonal_prices as $key => $value) {
                    if($value['price'] > $price_tax_exclusive) {
                        $errors[] = Tools::displayError($value['city_name'] . " price exceeds MRP for the product " . $product_name);
                    }
                }
            }

            if(isset($reduction_price) && $reduction_price) {
                if($reduction_price > $price_tax_exclusive) {
                    $errors[] = Tools::displayError('Specific price exceeds MRP for the product ' . $product_name);
                }
            }

            if(!empty($region_prices)) { // For currently uploaded zonal price price with product price check
                foreach ($region_prices as $key => $value) {
                    if(isset($value) && is_numeric($value)) {
                        if((float)$value) {
                            if($value > $price_tax_exclusive) {
                                $errors[] = Tools::displayError($key." price exceeds MRP for the product " . $product_name);
                            }
                        }
                    }
                    else {
                        $errors[] = Tools::displayError($key . " price invalid for the product " . $product_name);
                    }
                }
            }
        }

        if(sizeof($errors)) {
            return $errors;
        }

        return true;
    }

    public static function isValidProduct($id){
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'product` WHERE id_product='.$id.'';
        return Db::getInstance()->ExecuteS($sql);
    }

    public static function priceCalculation($id_shop, $id_product, $id_product_attribute, $id_country, $id_state, $zipcode, $id_currency, $id_group, $quantity, $use_tax, $decimals, $only_reduc, $use_reduc, $with_ecotax, &$specific_price, $use_group_reduction, $id_customer = 0, $use_customer_price = true, $id_cart = 0, $real_quantity = 0)
    {
        static $address = null;
        static $context = null;

        if ($address === null) {
            $address = new Address();
        }

        if ($context == null) {
            $context = Context::getContext()->cloneContext();
        }

        if ($id_shop !== null && $context->shop->id != (int)$id_shop) {
            $context->shop = new Shop((int)$id_shop);
        }

        if (!$use_customer_price) {
            $id_customer = 0;
        }

        if ($id_product_attribute === null) {
            $id_product_attribute = Product::getDefaultAttribute($id_product);
        }

        $cache_id = (int)$id_product.'-'.(int)$id_shop.'-'.(int)$id_currency.'-'.(int)$id_country.'-'.$id_state.'-'.$zipcode.'-'.(int)$id_group.
            '-'.(int)$quantity.'-'.(int)$id_product_attribute.
            '-'.(int)$with_ecotax.'-'.(int)$id_customer.'-'.(int)$use_group_reduction.'-'.(int)$id_cart.'-'.(int)$real_quantity.
            '-'.($only_reduc?'1':'0').'-'.($use_reduc?'1':'0').'-'.($use_tax?'1':'0').'-'.(int)$decimals;

        // reference parameter is filled before any returns
        $specific_price = SpecificPrice::getSpecificPrice(
            (int)$id_product,
            $id_shop,
            $id_currency,
            $id_country,
            $id_group,
            $quantity,
            $id_product_attribute,
            $id_customer,
            $id_cart,
            $real_quantity
        );
        if (isset(self::$_prices[$cache_id])) {
            return self::$_prices[$cache_id];
        }

        // fetch price & attribute price
        $cache_id_2 = $id_product.'-'.$id_shop;
        if (!isset(self::$_pricesLevel2[$cache_id_2])) {
            $sql = new DbQuery();
            $sql->select('product_shop.`price`, product_shop.`ecotax`');
            $sql->from('product', 'p');
            $sql->innerJoin('product_shop', 'product_shop', '(product_shop.id_product=p.id_product AND product_shop.id_shop = '.(int)$id_shop.')');
            $sql->where('p.`id_product` = '.(int)$id_product);
            if (Combination::isFeatureActive()) {
                $sql->select('IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute, product_attribute_shop.`price` AS attribute_price, product_attribute_shop.default_on');
                $sql->leftJoin('product_attribute_shop', 'product_attribute_shop', '(product_attribute_shop.id_product = p.id_product AND product_attribute_shop.id_shop = '.(int)$id_shop.')');
            } else {
                $sql->select('0 as id_product_attribute');
            }

            $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

            if (is_array($res) && count($res)) {
                foreach ($res as $row) {
                    $array_tmp = array(
                        'price' => $row['price'],
                        'ecotax' => $row['ecotax'],
                        'attribute_price' => (isset($row['attribute_price']) ? $row['attribute_price'] : null)
                    );
                    self::$_pricesLevel2[$cache_id_2][(int)$row['id_product_attribute']] = $array_tmp;

                    if (isset($row['default_on']) && $row['default_on'] == 1) {
                        self::$_pricesLevel2[$cache_id_2][0] = $array_tmp;
                    }
                }
            }
        }

        if (!isset(self::$_pricesLevel2[$cache_id_2][(int)$id_product_attribute])) {
            return;
        }

        $result = self::$_pricesLevel2[$cache_id_2][(int)$id_product_attribute];
        if (!$specific_price || $specific_price['price'] < 0) {
            $price = (float)$result['price'];
        } else {
            $price = (float)$specific_price['price'];
        }
        // convert only if the specific price is in the default currency (id_currency = 0)
        if (!$specific_price || !($specific_price['price'] >= 0 && $specific_price['id_currency'])) {
            $price = Tools::convertPrice($price, $id_currency);
        }
        // Attribute price
        if (is_array($result) && (!$specific_price || !$specific_price['id_product_attribute'] || $specific_price['price'] < 0)) {
            $attribute_price = Tools::convertPrice($result['attribute_price'] !== null ? (float)$result['attribute_price'] : 0, $id_currency);
            // If you want the default combination, please use NULL value instead
            if ($id_product_attribute !== false) {
                $price += $attribute_price;
            }
        }
        // Tax
        $address->id_country = $id_country;
        $address->id_state = $id_state;
        $address->postcode = $zipcode;
        
        $context =  Context::getContext();
        
        if(isset($context->cart->id_address_delivery)) {
            $sez_address = new Address($context->cart->id_address_delivery);
            // Check SEZ address here
            if(isset($sez_address->isez) && $sez_address->isez) {
                if(isset($context->cookie->delivery_region)) {
                    $fc = new FulfillmentCentre($context->cookie->delivery_region);
                    if($fc->lut != "") { // If LUT number exists - don't calculate tax
                       $use_tax = false;
                    }
                }
            }
        }

        $tax_manager = TaxManagerFactory::getManager($address, Product::getIdTaxRulesGroupByIdProduct((int)$id_product, $context));
        $product_tax_calculator = $tax_manager->getTaxCalculator();

        if($use_tax) {
            $price = $product_tax_calculator->addTaxes($price);
        }
        // Eco Tax
        if (($result['ecotax'] || isset($result['attribute_ecotax'])) && $with_ecotax) {
            $ecotax = $result['ecotax'];
            if (isset($result['attribute_ecotax']) && $result['attribute_ecotax'] > 0) {
                $ecotax = $result['attribute_ecotax'];
            }

            if ($id_currency) {
                $ecotax = Tools::convertPrice($ecotax, $id_currency);
            }
            if ($use_tax) {
                // reinit the tax manager for ecotax handling
                $tax_manager = TaxManagerFactory::getManager(
                    $address,
                    (int)Configuration::get('PS_ECOTAX_TAX_RULES_GROUP_ID')
                );
                $ecotax_tax_calculator = $tax_manager->getTaxCalculator();
                $price += $ecotax_tax_calculator->addTaxes($ecotax);
            } else {
                $price += $ecotax;
            }
        }

        // Reduction
        $specific_price_reduction = 0;
        if (($only_reduc || $use_reduc) && $specific_price) {
            if ($specific_price['reduction_type'] == 'amount') {
                $reduction_amount = $specific_price['reduction'];

                if (!$specific_price['id_currency']) {
                    $reduction_amount = Tools::convertPrice($reduction_amount, $id_currency);
                }

                $specific_price_reduction = $reduction_amount;

                    // Adjust taxes if required

                    if (!$use_tax && $specific_price['reduction_tax']) {
                        $specific_price_reduction = $product_tax_calculator->removeTaxes($specific_price_reduction);
                    }
                if ($use_tax && !$specific_price['reduction_tax']) {
                    $specific_price_reduction = $product_tax_calculator->addTaxes($specific_price_reduction);
                }
            } else {
                $specific_price_reduction = $price * $specific_price['reduction'];
            }
        }

        if ($use_reduc) {
            $price -= $specific_price_reduction;
        }

        // Group reduction
        if ($use_group_reduction) {
            $reduction_from_category = GroupReduction::getValueForProduct($id_product, $id_group);
            if ($reduction_from_category !== false) {
                $group_reduction = $price * (float)$reduction_from_category;
            } else { // apply group reduction if there is no group reduction for this category
                $group_reduction = (($reduc = Group::getReductionByIdGroup($id_group)) != 0) ? ($price * $reduc / 100) : 0;
            }

            $price -= $group_reduction;
        }

        if ($only_reduc) {
            return Tools::ps_round($specific_price_reduction, $decimals);
        }

        $price = Tools::ps_round($price, $decimals);

        if ($price < 0) {
            $price = 0;
        }

        self::$_prices[$cache_id] = $price;
        return self::$_prices[$cache_id];
    }
}
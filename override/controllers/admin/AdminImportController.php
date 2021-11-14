<?php
class AdminImportController extends AdminImportControllerCore
{
    public function tagSupplierImport()
    {
        $this->receiveTab();
        $handle = $this->openCsvFile();
        $convert = Tools::getValue('convert');

        for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, $this->separator); $current_line++) {
            if ($convert) {
                $line = $this->utf8EncodeArray($line);
            }
            $info = AdminImportController::getMaskedRow($line);
            $id_supplier = !empty($info['id_supplier'])?$info['id_supplier']:'';
            $id_product = !empty($info['id_product'])?$info['id_product']:'';
            $id_zone = !empty($info['id_zone'])?$info['id_zone']:'';
            $moq = $info['moq'];
            $oos = $info['oos'];
            //$logger = new FileLogger();
            //$logger->setFilename("test1.txt");
            //$logger->logError("admin import");
            //$logger->logError($oos);
            //$logger->logError("====END===");
            if(is_numeric($oos) == 1 && ($info['oos'] == 0 || $info['oos'] == 1)){
                //$logger->logError("====END 1===");    
            }
            else{
                $this->errors[] = (Tools::displayError($current_line.':Invalid oos '.$oos));
            }
            if($id_supplier === null || $id_supplier === '' || is_numeric($id_supplier) != 1 || floor($id_supplier) != $id_supplier){
                $this->errors[] = (Tools::displayError($current_line.':Invalid id_supplier '.$id_supplier));
            }
            if($id_product === null || $id_product === '' || is_numeric($id_product) != 1 || floor($id_product) != $id_product){
                $this->errors[] = (Tools::displayError($current_line.':Invalid id_product '.$id_product));
            }
            if($id_zone === null || $id_zone === '' || is_numeric($id_zone) != 1 || floor($id_zone) != $id_zone){
                $this->errors[] = (Tools::displayError($current_line.':Invalid id_zone '.$id_zone));
            }
            if(is_numeric($moq) != 1 || floor($moq) != $moq){
                $this->errors[] = (Tools::displayError($current_line.':Invalid moq '.$moq));
            }

            if(!$this->isSupplierexistsInDatabase((int)$id_supplier,'supplier', 'elite_supplier')){
                $this->errors[] = (Tools::displayError($current_line.':Invalid id_supplier '.$id_supplier));
            }
            
            if(!Product::existsInDatabase((int)$id_product, 'product')){
                $this->errors[] = (Tools::displayError($current_line.':Invalid id_product '.$id_product));
            }
            
            if(!is_numeric($id_zone) || !$this->isValidZone($id_zone)){
                $this->errors[] = (Tools::displayError($current_line.':Invalid id_zone '.$id_zone));
            }
            
            if($moq < 0)
            {
                $this->errors[] = (Tools::displayError($current_line.':Invalid moq '.$moq));
            }
            
            if(($oos != 1 && $oos != 0) || $oos === '')
            {
                $this->errors[] = (Tools::displayError($current_line.':Invalid oos '.$oos));
            }
        }
        if(empty($this->errors))
        {
            $this->closeCsvFile($handle);
            $handle = $this->openCsvFile();
            for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, $this->separator); $current_line++) {
                if ($convert) {
                    $line = $this->utf8EncodeArray($line);
                }

                $info = AdminImportController::getMaskedRow($line);
                $id_supplier = !empty($info['id_supplier'])?$info['id_supplier']:'';
                $id_product = !empty($info['id_product'])?$info['id_product']:'';
                $id_zone = !empty($info['id_zone'])?$info['id_zone']:'';
                $moq = $info['moq'];
                $oos = $info['oos'];

                //Insert into the table
                $zone_query = "SELECT * FROM `kob_elite_supplier_zone` WHERE id_supplier=".$id_supplier." AND id_product=".$id_product;
                $zones_res = Db::getInstance()->ExecuteS($zone_query);

                if(count($zones_res) > 0){
                    $update = 4;
                    foreach($zones_res as $z){
                        if($z['id_product'] == $id_product && $z['id_supplier'] == $id_supplier && $z['id_zone'] == $id_zone && $z['moq'] == $moq){
                            $update =1;
                        }
                        else if($z['id_product'] == $id_product && $z['id_supplier'] == $id_supplier && $z['id_zone'] == $id_zone){
                            $update = $update < 2 ? $update :2;
                        }
                        else if($z['id_product'] == $id_product && $z['id_supplier'] == $id_supplier){
                            $update = $update < 3 ? $update :3;
                        }
                    }

                    if($update == 2){
                        $zone_sql = "UPDATE `kob_elite_supplier_zone` set moq=".$moq." WHERE id_product=".$id_product." AND id_supplier=".$id_supplier." AND id_zone=".$id_zone;
                    }
                    else if($update == 3){
                        $zone_sql = "INSERT INTO `kob_elite_supplier_zone` (id_supplier, id_product, id_zone, moq) 
                                values(".$id_supplier.",".$id_product.",".$id_zone.",".$moq.")";
                    }
                }
                else{
                    $zone_sql = "INSERT INTO `kob_elite_supplier_zone` (id_supplier, id_product, id_zone, moq) 
                                values(".$id_supplier.",".$id_product.",".$id_zone.",".$moq.")";    
                }
                if($zone_sql != ""){
                    //$logger->logError($zone_sql);
                    $zone_result = Db::getInstance()->Execute($zone_sql);
                }
                
                $stock_query = "SELECT * FROM `kob_elite_supplier_stock` WHERE id_supplier=".$id_supplier." AND id_product=".$id_product;
                $stock_res = Db::getInstance()->ExecuteS($stock_query);

                if(count($stock_res) > 0){
                    $stock_sql = "UPDATE `kob_elite_supplier_stock` set out_of_stock =".$oos." WHERE id_supplier=".$id_supplier." AND id_product=".$id_product;
                }
                else{
                    $stock_sql = "INSERT INTO `kob_elite_supplier_stock` (id_supplier, id_product, out_of_stock)
                                values(".$id_supplier.",".$id_product.",".$oos.")";
                }
                //$logger->logError($stock_sql);
                Db::getInstance()->Execute($stock_sql);
            }
        }
        $this->closeCsvFile($handle);
    }

    public function isValidZone($id_zone){
        $sql = "SELECT GROUP_CONCAT(DISTINCT(zone_id)) as z FROM `kob_pincode_master`";
        $zones = Db::getInstance()->ExecuteS($sql);
        $zones = explode(",",$zones[0]['z']);
        return in_array($id_zone, $zones) ? true : false;

    }

    public function validateProductImport()
    {
        $approver=Tools::getValue('select_employee');
        $file_name=Tools::getValue('csv');

        $this->receiveTab();
        $handle = $this->openCsvFile();
        //AdminImportController::setLocale();

        $convert = Tools::getValue('convert');

        for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, $this->separator); $current_line++) {
            if ($convert) {
                $line = $this->utf8EncodeArray($line);
            }
            
            $info = AdminImportController::getMaskedRow($line);
            $name = !empty($info['name'])?$info['name']:'';
            $id = !empty($info['id'])?$info['id']:'';
            $reference = !empty($info['reference'])?$info['reference']:'';
            $manufacturer = !empty($info['manufacturer'])?$info['manufacturer']:'';
            $meta_title = !empty($info['meta_title'])?$info['meta_title']:'';
            $meta_keywords = !empty($info['meta_keywords'])?$info['meta_keywords']:'';
            $meta_description = !empty($info['meta_description'])?$info['meta_description']:'';
            $description = !empty($info['description'])?$info['description']:'';
            $description_short = !empty($info['description_short'])?$info['description_short']:'';
            $tags = !empty($info['tags'])?$info['tags']:'';
            $category = !empty($info['category'])?explode($this->multiple_value_separator,$info['category']):'';
            $image = !empty($info['image'])?$info['image']:'';
            $quantity = !empty($info['quantity'])?$info['quantity']:'';
            $minimal_quantity = !empty($info['minimal_quantity'])?$info['minimal_quantity']:'';
            $reduction_price = !empty($info['reduction_price']) ? $info['reduction_price'] : 0;
            $reduction_percent = !empty($info['reduction_percent']) ? $info['reduction_percent'] : '';
            $reduction_from = !empty($info['reduction_from']) ? $info['reduction_from'] : '';
            $reduction_to = !empty($info['reduction_to']) ? $info['reduction_to'] : '';

            $product = new Product(intval($id));

            $identifier = '';

            if($name) {
                $identifier=$name;
            }
            else if($id) {
                $identifier=$id;
            }
            elseif(!$name && !$id) {
                $this->errors[] = (Tools::displayError($current_line.' : Invalid Line'));
                continue;
            }

            if(!$name && !$id && !$reference)
            {
                $this->errors[] = (Tools::displayError($current_line.' : No Product ID / NAME / REFERENCE : '.$id));   
                continue;
            }

            if($id) {
                if(!Product::existsInDatabase((int)$id, 'product')){
                    $this->errors[] = (Tools::displayError($current_line.' :Invalid Product ID : '.$id));   
                }
            }

            if($reference)
            {
                $datas = Db::getInstance()->getRow('
                        SELECT p.`id_product`
                        FROM `'._DB_PREFIX_.'product` p
                        '.Shop::addSqlAssociation('product', 'p').'
                        WHERE p.`reference` = "'.pSQL($reference).'"
                    ', false);
                if($datas['id_product'])
                    $this->errors[] = (Tools::displayError($current_line.' :Invalid Product reference : '.$info['product_reference']));   
            }
            
            /***Tax Rule Verification***/
            if (isset($info['id_tax_rules_group']) && $info['id_tax_rules_group'] != 0) {
                if (!Validate::isLoadedObject(new TaxRulesGroup($info['id_tax_rules_group']))) {
                    $this->errors[] = (Tools::displayError($current_line.' :Invalid tax rule group ID. You first need to create a group with this ID.'));
                }
            }

            /*** Manufacturer Verification ***/
            if((is_numeric($manufacturer) && Category::existsInDatabase((int)$manufacturer, 'manufacturer')) || (is_string($manufacturer) && Manufacturer::getIdByName($manufacturer)) ) 
            {

            }
            else if(isset($manufacturer))
            {
                if(is_numeric($manufacturer))
                {
                    $this->errors[] = sprintf(
                            Tools::displayError($current_line.':manufacturer name error for product '.$identifier),
                            $manufacturer
                        );
                }
                else if(strlen($manufacturer) > 64)
                {
                    $this->errors[] = sprintf(
                            Tools::displayError($current_line.':manufacturer name exceeds length '.$identifier),
                            $manufacturer
                        );
                }
            }
            /*** PRICE Validation***/
            if (isset($info['price_tex']) || isset($info['price_tin'])) {
                if($info['price_tex'] != '' && !is_numeric($info['price_tex'])) {
                    $this->errors[] = sprintf(
                            Tools::displayError($current_line.':Price Error for'. gettype($info['price_tex']) .''.$identifier),
                            $identifier                            
                        );
                }
                if($info['price_tin'] != '' && !is_numeric($info['price_tin']))
                {
                    $this->errors[] = sprintf(
                            Tools::displayError($current_line.':Price Error for'. gettype($info['price_tin']) .''.$identifier),
                            $identifier                            
                        );
                }

            }

            if(isset($info['brands_mrp'])) {
                if($info['brands_mrp'] != '' && !is_numeric($info['brands_mrp'])) {
                    $this->errors[] = sprintf(
                        Tools::displayError($current_line.': Brands MRP Error for '. gettype($info['brands_mrp']) .' '.$identifier),
                        $identifier                            
                    );
                }
            }

            $use_tax = false;
            $price_to_validate = 0;
            $wholesale_price_validate = 0;
            $chennai_price_to_validate = 0;
            $bengaluru_price_to_validate = 0;
            $mumbai_price_to_validate = 0;
            $hyderabad_price_to_validate = 0;
            $delhi_price_to_validate = 0;
            $product_name = $product->name[1];

            if(isset($info['price_tin']) && $info['price_tin']) {
                $use_tax = true;
                $price_to_validate = $info['price_tin'];
            }

            if(isset($info['price_tex']) && $info['price_tex']) {
                $price_to_validate = $info['price_tex'];
            }

            if(isset($info['wholesale_price']) && $info['wholesale_price']) {
                $wholesale_price_validate = $info['wholesale_price'];
            }

            if(isset($info['chennai_price']) && $info['chennai_price']) {
                $chennai_price_to_validate = $info['chennai_price'];
            }

            if(isset($info['bengaluru_price']) && $info['bengaluru_price']) {
                $bengaluru_price_to_validate = $info['bengaluru_price'];
            }

            if(isset($info['mumbai_price']) && $info['mumbai_price']) {
                $mumbai_price_to_validate = $info['mumbai_price'];
            }

            if(isset($info['hyderabad_price']) && $info['hyderabad_price']) {
                $hyderabad_price_to_validate = $info['hyderabad_price'];
            }

            if(isset($info['delhi_price']) && $info['delhi_price']) {
                $delhi_price_to_validate = $info['delhi_price'];
            }

            if($name != "")
                $product_name = $name;

            $region_prices = array(
                'Chennai' => $chennai_price_to_validate,
                'Bengaluru' => $bengaluru_price_to_validate,
                'Mumbai' => $mumbai_price_to_validate,
                'Hyderabad' => $hyderabad_price_to_validate,
                'New Delhi' => $delhi_price_to_validate
            );

            $region_price_found = array_filter($region_prices, function($item) {
                return isset($item) && $item;
            });

            $validate_response = $product->validatePrice($price_to_validate, $wholesale_price_validate, $region_price_found, true, $use_tax, $reduction_price, $product_name);

            if(!empty($validate_response) && is_array($validate_response)) {
                foreach ($validate_response as $errors) {
                    $this->errors[] = $errors; 
                }
            }
            
            /***Category Validation***/
            if($category)
            {
                if(is_array($category))
                {
                    foreach ($category as $value) {
                        if (is_numeric($value)) {
                            if (Category::categoryExists((int)$value)) {
                                $id_category[] = (int)$value;
                            }
                            else{
                                $this->errors[] = sprintf(
                                    Tools::displayError($current_line.':Invalid category id : '.$identifier),
                                    $identifier);
                            }
                        }
                        else if(is_string($value))
                        {
                            if(!Validate::isCatalogName($value) && is_string($value))
                            {
                                if(strlen($value)){
                                    $this->errors[] = sprintf(Tools::displayError($current_line.':Invalid Category Name: '.$value),$value);
                                }                                
                            }            
                        }
                    }
                }         
            }
            /***Product Name ***/
            if($name)
            {
                 if(strlen($name) >= 128)
                 {
                    $this->errors[] = sprintf(Tools::displayError($current_line.':Product name Exceeds length: '.$name),$name);
                 }
            }
            /*** Tags ***/
            if($tags)
            {
                foreach($tags as $value){
                    if (!Validate::isTagsList($value)) {
                        $this->errors[] = sprintf(
                            Tools::displayError('The tags list (%s) is invalid.'),
                            $value
                        );
                    }
                }
            }
            /*** Meta Keywords ***/
            if($meta_keywords)
            {
                if(strlen($meta_keywords) >= 255)
                 {
                    $this->errors[] = sprintf(Tools::displayError($current_line.':meta_keywords Exceeds length: '.$meta_keywords),$identifier);
                 }   
            }
            if($minimal_quantity)
            {
                if(!is_numeric($minimal_quantity))
                 {
                    $this->errors[] = sprintf(Tools::displayError($current_line.':invalid minimal_quantity '.$minimal_quantity),$identifier);
                 }   
            }
            if(isset($info['quantity'])) {
                if(!is_numeric($info['quantity']))
                    $this->errors[] = sprintf(Tools::displayError($current_line.':invalid quantity'.$info['quantity']),$identifier);
            }

            if(isset($info['active'])) {
                if($info['active'] != 0 && $info['active'] != 1)
                    $this->errors[] = sprintf(Tools::displayError($current_line.':invalid active status'.$info['active']),$identifier);
            }

            if($meta_keywords)
            {
                if(strlen($meta_keywords) >= 255)
                 {
                    $this->errors[] = sprintf(Tools::displayError($current_line.':tags Exceeds length: '.$meta_keywords),$identifier);
                 }   
            }

            if($meta_description)
            {
                if(strlen($meta_description) >= 255)
                 {
                    $this->errors[] = sprintf(Tools::displayError($current_line.':tags Exceeds length: '.$meta_description),$identifier);
                 }   
            }

            if($meta_title)
            {
                if(strlen($meta_title) >= 128)
                 {
                    $this->errors[] = sprintf(Tools::displayError($current_line.':tags Exceeds length: '.$meta_title),$identifier);
                 }   
            }

            if($meta_keywords)
            {
                if(strlen($meta_keywords) >= 255)
                 {
                    $this->errors[] = sprintf(Tools::displayError($current_line.':tags Exceeds length: '.$meta_keywords),$identifier);
                 }   
            }

            if($image)
            {
                $images = explode($this->multiple_value_separator, $image);
                foreach($images as $img)
                {
                    $img=$this->checkRemoteFile($img);
                    if(!$img)
                    {
                        $this->errors[] = sprintf(Tools::displayError($current_line.':image not available: '.$identifier),$identifier);
                    }
                }
            }

            if(isset($info['features']) && !empty($info['features']))
            {

                $features = explode($this->multiple_value_separator, $info['features']);
                foreach($features as $features_data){
                    $tab_feature = explode(':', $features_data);
                    $feature_name = isset($tab_feature[0]) ? trim($tab_feature[0]) : '';
                    $feature_value = isset($tab_feature[1]) ? trim($tab_feature[1]) : '';
                    $position = isset($tab_feature[2]) ? (int)$tab_feature[2] - 1 : false;

                    if(ctype_space($feature_value[0]))
                    {
                        $this->errors[] = "invalid feature value : ".$identifier;
                    }
                    if(!is_numeric($position) || ($position[0] == ' '))
                    {
                        $this->errors[] = "invalid position : ".$identifier;    
                    }
                    if(strlen($feature_name) >= 128 || ($feature_name[0] == ' ') || $feature_name == '')
                    {
                        $this->errors[] = "invalid feature name : ".$identifier;    
                    }
                    if(strlen($feature_value) >= 255 || ($feature_value[0] == ' ') || $feature_value == '')
                    {
                        $this->errors[] = "invalid feature value : ".$identifier;       
                    }    
                }
                
            }
            if($reduction_price || $reduction_percent)
            {
                if($reduction_price)
                {
                    if(!is_numeric($reduction_price)){
                        $this->errors[] = sprintf(Tools::displayError($current_line.':invalid discount price'.$identifier),$identifier);
                    }
                }
                else if($reduction_percent)
                {
                    if(!is_numeric($reduction_percent)){
                        $this->errors[] = sprintf(Tools::displayError($current_line.':invalid discount percent'.$identifier),$identifier);
                       }
                       else if($reduction_percent > 100)
                       {
                            $this->errors[] = sprintf(Tools::displayError($current_line.':discount percent exceeds 100%'.$identifier),$identifier);
                       }
                }
            }
        }
        if(empty($this->errors))
        {
            $password=rand(1000,9999);
            $now=Date("y-m-d h:i:sa");
            $csv=new CsvImport();
            $csv->validated_by=$this->context->employee->id;
            $csv->approved_by=$approver;
            $csv->password=$password;
            $csv->file_name=$file_name;
            $csv->date_add=$now;
            $csv->valid=1;
            $csv->save();
            $this->sendMail($approver,$password,$file_name);
        }
        
    }
    public function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if(curl_exec($ch)!==FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function sendMail($approver,$password,$file_name)
    {
        $context=Context::getContext();
        $approver_emp=new Employee($approver);
        $data = array('{password}'=>$password,                  
                      '{file_name}' => $file_name,
                      '{name}' => $approver_emp->firstname.$approver_emp->lastname
                      );

        $em_sub = 'QC Approcal Mail';
        
        Mail::Send((int)$context->cookie->id_lang, 'qc', Mail::l($em_sub, (int)$context->cookie->id_lang), $data,  $approver_emp->email, 'Catalog Team');
    }
    
    public function isSupplierexistsInDatabase($id_entity, $id, $table)
    {
        $row = Db::getInstance()->getRow('
            SELECT `id_'.bqSQL($id).'` as id
            FROM `'._DB_PREFIX_.bqSQL($table).'` e
            WHERE e.`id_'.bqSQL($id).'` = '.(int)$id_entity, false
        );
        return isset($row['id']);
    }
}

?>
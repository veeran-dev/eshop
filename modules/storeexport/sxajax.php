<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');



$a=new StoreExportAjax();

$first=$_POST["first"];
$second=$_POST["second"];

$langid='';
$langid=Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
select id_lang from ps_lang
where iso_code="en"');

$l=$langid;

$langid=$l[0]["id_lang"];

if($first=="Categories"){
    $a->populateCategoreis($langid,$second);
}
else if($first=="Combinations"){
    $a->attributeImport($langid, $second);
}
else if($first=="Products"){
    $a->populateProducts($langid, $second);
}
else if($first=="Customers"){
    $a->populateCustomers($langid, $second);
}
else if($first=="Manufacturers"){
    $a->populateManufacturers($langid, $second);
}
else if($first=="Suppliers"){
    $a->populateSuppliers($langid, $second);
}
else if($first=="Addresses"){
    $a->populateAddresses($langid, $second);
}


class StoreExportAjax{

    public function populateCategoreis($langid,$second) {
        $Colheader = "ID;Active;Name;Parent Category;Description;Meta-title;Meta-keyword;Meta-description;URL rewritten;Image URL\n";

        $output = '';
        
            $cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		select c.id_category,c.active,l.name,c.id_parent,l.description,l.meta_title,l.meta_keywords,l.meta_description,l.link_rewrite
from ' . _DB_PREFIX_ . 'category c,' . _DB_PREFIX_ . 'category_lang l
where l.id_lang=' . $langid . ' and l.id_category=c.id_category');

            $output = '';
            for ($cindex = 0; $cindex < count($cats); $cindex++) {
                $cat = $cats[$cindex];
                $firstitem = 1;
                foreach ($cat as $value) {
                    $value = str_replace("\"", "\"\"", $value);
                    if ($firstitem == 1) {
                        $firstitem = 0;
                        $output = $output . "\"" . $value . "\"";
                    } else {
                        $output = $output . $this->RECORD_SEPARATOR . "\"" . $value . "\"";
                    }
                }
                //$url = Tools::getProtocol(false) . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__;
                $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__;
                $url = $url . "img/c/" . $cat["id_category"] . "-category.jpg";


                if (!$this->url_exists($url)) {
                    $url = '';
                }
                $output = $output . $this->RECORD_SEPARATOR . $url . "\n";
            }



            $myFile = "Categories_" . $second . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $Colheader);
            fwrite($fh, $output);

            fclose($fh);
        }
    
        public function populateProducts($langid,$second) {


        $max = 0;

        $output = '';
       
            $prods = '';
            if (Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('DESC ' . _DB_PREFIX_ . 'specific_price') == true) {
                $prods = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT s.*,l.*,p.*
FROM ' . _DB_PREFIX_ . 'product_lang l,' . _DB_PREFIX_ . 'product p
LEFT JOIN ' . _DB_PREFIX_ . 'specific_price s ON s.id_product=p.id_product
WHERE l.id_lang=' . $langid . ' AND p.id_product=l.id_product');
            } else {
                $prods = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT p.*,l.*
FROM ' . _DB_PREFIX_ . 'product_lang l,' . _DB_PREFIX_ . 'product p
WHERE l.id_lang=' . $langid . ' AND p.id_product=l.id_product');
            }

            $output = '';
            $colheader = '';
            $colheaderfeat = '';

            for ($pindex = 0; $pindex < count($prods); $pindex++) {
                $ppp = $prods[$pindex];
                $pid = $prods[$pindex]["id_product"];

                $cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
            select id_category 
            from ' . _DB_PREFIX_ . 'category_product
            where id_product=' . $pid);
                $catid = '';
                for ($cindex = 0; $cindex < count($cats); $cindex++) {
                    if ($cindex == 0)
                        $catid = $cats[$cindex]["id_category"];
                    else
                        $catid=$catid . "," . $cats[$cindex]["id_category"];
                }


                $tags = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                select t.name 
                from ' . _DB_PREFIX_ . 'tag t,' . _DB_PREFIX_ . 'product_tag p
                where p.id_product=' . $pid . ' and t.id_lang=' . $langid . '  and p.id_tag=t.id_tag');
                $tag = '';
                for ($tindex = 0; $tindex < count($tags); $tindex++) {
                    if ($tindex == 0)
                        $tag = $tags[$tindex]["name"];
                    else
                        $tag=$tag . "," . $tags[$tindex]["name"];
                }


                $imgs = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                select i.id_image
                from ' . _DB_PREFIX_ . 'image i,' . _DB_PREFIX_ . 'product p
                where p.id_product=' . $pid . ' and i.id_product=p.id_product');
                $imglink = '';
                for ($iindex = 0; $iindex < count($imgs); $iindex++) {
                    $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__;

                    $url = $url . "img/p/" . $pid . "-" . $imgs[$iindex]["id_image"] . ".jpg";
                    if ($this->url_exists($url) == false)
                        continue;
                    if ($iindex == 0)
                        $imglink = $url;
                    else
                        $imglink=$imglink . "," . $url;
                }


                $featurekey = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                                                    select name
                                                    from ' . _DB_PREFIX_ . 'feature_lang
                                                    where id_lang=' . $langid);


                $features = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                select l.name,fl.value
                from ' . _DB_PREFIX_ . 'feature_lang l,' . _DB_PREFIX_ . 'feature_product p,' . _DB_PREFIX_ . 'feature_value_lang fl
                where p.id_product=' . $pid . ' and l.id_lang=' . $langid . '   and p.id_feature=l.id_feature and fl.id_feature_value=p.id_feature_value and fl.id_lang=' . $langid);
                $feature = '';
                for ($findex = 0; $findex < count($featurekey); $findex++) {
                    $ii = $this->in_array_r($featurekey[$findex]["name"], $features);
                    if ($findex == 0) {
                        if ($ii != -1) {
                            //$feature = "\"" . str_replace("\"", "\"\"", $features[$ii]["name"]) . ":" . str_replace("\"", "\"\"", $features[$ii]["value"]) . "\"";
                            $feature = "\"" . str_replace("\"", "\"\"", $features[$ii]["value"]) . "\"";
                        } else {
                            $feature = "\"" . str_replace("\"", "\"\"", "") . "" . str_replace("\"", "\"\"", "") . "\"";
                        }
                        if ($max < count($features))
                            $colheaderfeat = "Feature-" . $featurekey[$findex]["name"];
                    }
                    else {
                        if ($ii != -1) {
                            //$feature = $feature. ";" ."\"" . str_replace("\"", "\"\"", $features[$ii]["name"]) . ":" . str_replace("\"", "\"\"", $features[$ii]["value"]) . "\"";
                            $feature = $feature . ";" . "\"" . str_replace("\"", "\"\"", $features[$ii]["value"]) . "\"";
                        } else {
                            $feature = $feature . ";" . "\"" . str_replace("\"", "\"\"", "") . "" . str_replace("\"", "\"\"", "") . "\"";
                        }

                        if ($max < count($features))
                            $colheaderfeat = $colheaderfeat . ";Feature-" . $featurekey[$findex]["name"];
                    }
                }

                if (count($features) > $max)
                    $max = count($features);


                $colheader = "ID;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["id_product"]) . "\"" . ";";
                $colheader = $colheader . "Active;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["active"]) . "\"" . ";";
                $colheader = $colheader . "Name;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["name"]) . "\"" . ";";
                $colheader = $colheader . "Category(x,y,z);";
                $output = $output . "\"" . str_replace("\"", "\"\"", $catid) . "\"" . ";";
                $colheader = $colheader . "price tax excl;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["price"]) . "\"" . ";";
                $colheader = $colheader . "Tax rules id;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["id_tax_rules_group"]) . "\"" . ";";
                $colheader = $colheader . "Wholesale price;";
                if ($prods[$pindex]["wholesale_price"] == null) {
                    $output = $output . "\"" . "0.00" . "\"" . ";";
                } else {
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["wholesale_price"]) . "\"" . ";";
                }
                $colheader = $colheader . "On sale;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["on_sale"]) . "\"" . ";";
                $colheader = $colheader . "Discount amount;Discount percent;";
                if ($prods[$pindex]["reduction_type"] == "amount") {
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["reduction"]) . "\"" . ";" . ";";
                } else {
                    $output = $output . ";" . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["reduction"]) . "\"" . ";";
                }
                $colheader = $colheader . "Discount from (yyyy-mm-dd);";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["from"]) . "\"" . ";";
                $colheader = $colheader . "Discount to (yyyy-mm-dd);";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["to"]) . "\"" . ";";
                $colheader = $colheader . "Reference #;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["reference"]) . "\"" . ";";
                $colheader = $colheader . "Supplier Reference #;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["supplier_reference"]) . "\"" . ";";
                $colheader = $colheader . "Supplier;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["id_supplier"]) . "\"" . ";";
                $colheader = $colheader . "Manufacturer;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["id_manufacturer"]) . "\"" . ";";
                $colheader = $colheader . "EAN13;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["ean13"]) . "\"" . ";";
                $colheader = $colheader . "UPC;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["upc"]) . "\"" . ";";
                $colheader = $colheader . "Ecotax;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["ecotax"]) . "\"" . ";";
                $colheader = $colheader . "Weight;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["weight"]) . "\"" . ";";
                $colheader = $colheader . "Quantity;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["quantity"]) . "\"" . ";";
                $colheader = $colheader . "Short description;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["description_short"]) . "\"" . ";";
                $colheader = $colheader . "Description;";
                $dd = $prods[$pindex]["description"];
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["description"]) . "\"" . ";";
                $colheader = $colheader . "Tags (x,y,z...);";
                $tt = $tag;
                $output = $output . "\"" . str_replace("\"", "\"\"", $tag) . "\"" . ";";
                $colheader = $colheader . "meta_title;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["meta_title"]) . "\"" . ";";
                $colheader = $colheader . "meta_keywords;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["meta_keywords"]) . "\"" . ";";
                $colheader = $colheader . "meta_description;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["meta_description"]) . "\"" . ";";
                $colheader = $colheader . "URL rewritten;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["link_rewrite"]) . "\"" . ";";
                $colheader = $colheader . "Text when in-stock;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["available_now"]) . "\"" . ";";
                $colheader = $colheader . "Text if back-order allowed;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["available_later"]) . "\"" . ";";
                $colheader = $colheader . "Available for order;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["available_for_order"]) . "\"" . ";";
                $colheader = $colheader . "Date add product;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["date_add"]) . "\"" . ";";
                $colheader = $colheader . "Show price;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["show_price"]) . "\"" . ";";
                $colheader = $colheader . "Image URLs (x,y,z...);";
                $output = $output . "\"" . str_replace("\"", "\"\"", $imglink) . "\"" . ";";
                $colheader = $colheader . "Delete existing images (0 = no, 1 = yes);";
                $output = $output . "1" . ";";
                $colheader = $colheader . $colheaderfeat . ";";
                $output = $output . $feature . ";";
                $colheader = $colheader . "Only available online;";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["online_only"]) . "\"" . ";";
                $colheader = $colheader . "Condition('new','used','refurbished')";
                $output = $output . "\"" . str_replace("\"", "\"\"", $prods[$pindex]["condition"]) . "\"";
                $output = str_replace("\r\n", '', $output);
                $output = $output . "\n";
            }

            $colheader = $colheader . "\n";
            $myFile = "Products_" . $second . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        
    }
        
        
        public function attributeImport($langid,$second) {
        $output = '';
        $prods = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                select * from ' . _DB_PREFIX_ . 'product');

        
            $output = '';
            $colheader = '';
            for ($pindex = 0; $pindex < count($prods); $pindex++) {
                $prodcombi = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                        SELECT * 
                        from ' . _DB_PREFIX_ . 'product_attribute
                        where id_product=' . $prods[$pindex]["id_product"]);



                for ($cindex = 0; $cindex < count($prodcombi); $cindex++) {


                    $attrbcombi = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                            select gl.name,al.name as N
                            from ' . _DB_PREFIX_ . 'product_attribute_combination ac,' . _DB_PREFIX_ . 'attribute a,' . _DB_PREFIX_ . 'attribute_group_lang gl,' . _DB_PREFIX_ . 'attribute_lang al
                            where ac.id_product_attribute=' . $prodcombi[$cindex]["id_product_attribute"] . ' and a.id_attribute=ac.id_attribute and gl.id_attribute_group=a.id_attribute_group and gl.id_lang=' . $langid . '
                                and al.id_attribute=a.id_attribute and al.id_lang=' . $langid);

                    $groupvalue = '';
                    for ($gindex = 0; $gindex < count($attrbcombi); $gindex++) {
                        $name_ = $attrbcombi[$gindex]['name'];
                        $N_ = $attrbcombi[$gindex]['N'];

                        $name_ = str_replace("\"", "\"\"", $name_);
                        $N_ = str_replace("\"", "\"\"", $N_);

                        if ($gindex == 0) {
                            $groupvalue = $name_ . ":" . $N_;
                        } else {
                            $groupvalue = $groupvalue . "," . $name_ . ":" . $N_;
                        }
                    }

                    $imgid = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                        SELECT id_image 
                        from ' . _DB_PREFIX_ . 'product_attribute_image
                        where id_product_attribute=' . $prodcombi[$cindex]["id_product_attribute"]);

                    $colheader = "ID;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["id_product"]) . "\"" . ";";
                    $colheader = $colheader . "Options;";
                    $output = $output . "\"" . $groupvalue . "\"" . ";";
                    $colheader = $colheader . "Reference;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["reference"]) . "\"" . ";";
                    $colheader = $colheader . "Supplier Reference;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["supplier_reference"]) . "\"" . ";";
                    $colheader = $colheader . "EAN13;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["ean13"]) . "\"" . ";";
                    $colheader = $colheader . "UPC;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["upc"]) . "\"" . ";";
                    $colheader = $colheader . "WholeSale price;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["wholesale_price"]) . "\"" . ";";
                    $colheader = $colheader . "Price;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["price"]) . "\"" . ";";
                    $colheader = $colheader . "Ecotax;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["ecotax"]) . "\"" . ";";
                    $colheader = $colheader . "Quantity;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["quantity"]) . "\"" . ";";
                    $colheader = $colheader . "Weight;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["weight"]) . "\"" . ";";
                    $colheader = $colheader . "Default on;";
                    $output = $output . "\"" . str_replace("\"", "\"\"", $prodcombi[$cindex]["default_on"]) . "\"" . ";";
                    $colheader = $colheader . "Image Position;";
                    $output = $output . ";";
                    $tmp = str_split($imgid[0]["id_image"]);
                    $imgpath = '';
                    $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . "img/p/";
                    for ($tmpindex = 0; $tmpindex < count($tmp); $tmpindex++) {
                        $imgpath = $imgpath . $tmp[$tmpindex] . '/';
                    }
                    $url = $url . $imgpath . $imgid[0]["id_image"] . ".jpg";

                    $colheader = $colheader . "Image URL;";
                    //only for testing
                    if ($this->url_exists($url)) {

                        $output = $output . "\"" . $url . "\"";
                    }
                    $output = $output . "\n";
                }
            }
            $colheader = $colheader . "\n";
            $myFile = "Combinations_" . $second . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        
    }
        
    public function populateAddresses($langid,$second) {
        $output = '';
        
            $query = 'SELECT *
        FROM   ' . _DB_PREFIX_ . 'address a
               LEFT OUTER JOIN ' . _DB_PREFIX_ . 'customer pc
                 ON ( a.id_customer = pc.id_customer ) ';

            $cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
            $output = '';
            $colheader = '';
            for ($cindex = 0; $cindex < count($cats); $cindex++) {
                $cat = $cats[$cindex];
                $firstitem = 1;

                foreach ($cat as $key => $value) {

                    if ($key == "date_add" || $key == "date_upd" || $key == "id_lang")
                        continue;
                    $value = str_replace("\"", "\"\"", $value);

                    if ($cindex == 0) {
                        if ($colheader == '') {
                            $colheader = $key;
                        } else {
                            $colheader = $colheader . ";" . $key;
                        }
                    }

                    if ($firstitem == 1) {
                        $firstitem = 0;
                        $output = $output . "\"" . $value . "\"";
                    } else {
                        $output = $output . ';' . "\"" . $value . "\"";
                    }
                }
                $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__;
                $output = $output . "\n";
            }
            $colheader = $colheader . "\n";
            $myFile = "Addresses_" . $second . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        
    }

    public function populateCustomers($langid,$second) {
        $output = '';
       
            $query = 'SELECT *
            FROM   ' . _DB_PREFIX_ . 'customer ';

            $cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
            $output = '';
            $colheader = '';
            for ($cindex = 0; $cindex < count($cats); $cindex++) {
                $cat = $cats[$cindex];
                $firstitem = 1;
                foreach ($cat as $key => $value) {
                    if ($key == "date_add" || $key == "date_upd" || $key == "secure_key" || $key == "last_passwd_gen" || $key == "ip_registration_newsletter" || $key == "newsletter_date_add" || $key == "deleted" || $key == "dni" || $key == "id_default_group")
                        continue;
                    $value = str_replace("\"", "\"\"", $value);

                    if ($cindex == 0) {
                        if ($colheader == '') {
                            $colheader = $key;
                        } else {
                            $colheader = $colheader . ";" . $key;
                        }
                    }
                    if ($firstitem == 1) {
                        $firstitem = 0;
                        $output = $output . "\"" . $value . "\"";
                    } else {
                        $output = $output . ';' . "\"" . $value . "\"";
                    }
                }
                $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__;
                $output = $output . "\n";
            }
            $colheader = $colheader . "\n";
            $myFile = "Customers_" . $second . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        
    }

    public function populateManufacturers($langid,$second) {
        $output = '';
        
            $query = 'SELECT l.*,m.*
            FROM   ' . _DB_PREFIX_ . 'manufacturer m LEFT JOIN
                  ' . _DB_PREFIX_ . 'manufacturer_lang l ON (l.id_manufacturer = m.id_manufacturer
                      AND l.id_lang =' . $langid . ')';

            $cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
            $output = '';
            $colheader = '';
            for ($cindex = 0; $cindex < count($cats); $cindex++) {
                $cat = $cats[$cindex];
                $firstitem = 1;
                foreach ($cat as $key => $value) {
                    if ($key == "date_add" || $key == "date_upd" || $key == "id_lang")
                        continue;
                    $value = str_replace("\"", "\"\"", $value);

                    if ($cindex == 0) {
                        if ($colheader == '') {
                            $colheader = $key;
                        } else {
                            $colheader = $colheader . ";" . $key;
                        }
                    }

                    if ($firstitem == 1) {
                        $firstitem = 0;
                        $output = $output . "\"" . $value . "\"";
                    } else {
                        $output = $output . ';' . "\"" . $value . "\"";
                    }
                }
                $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__;
                $output = $output . "\n";
            }

            $colheader = $colheader . "\n";
            $myFile = "Manufacturers_" . $second . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        
    }

    public function populateSuppliers($langid,$second) {
        $output = '';
       


            $query = 'SELECT l.*,s.*
            FROM   ' . _DB_PREFIX_ . 'supplier s LEFT JOIN 
                  ' . _DB_PREFIX_ . 'supplier_lang l ON (l.id_supplier = s.id_supplier
                      AND l.id_lang =' . $langid . ')';


            $cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
            $output = '';
            $colheader = '';
            for ($cindex = 0; $cindex < count($cats); $cindex++) {
                $cat = $cats[$cindex];
                $firstitem = 1;

                foreach ($cat as $key => $value) {

                    if ($key == "date_add" || $key == "date_upd" || $key == "id_lang")
                        continue;
                    $value = str_replace("\"", "\"\"", $value);
                    if ($cindex == 0) {
                        if ($colheader == '') {
                            $colheader = $key;
                        } else {
                            $colheader = $colheader . ";" . $key;
                        }
                    }
                    if ($firstitem == 1) {
                        $firstitem = 0;
                        $output = $output . "\"" . $value . "\"";
                    } else {
                        $output = $output . ';' . "\"" . $value . "\"";
                    }
                }
                $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__;
                $output = $output . "\n";
            }
            $colheader = $colheader . "\n";
            $myFile = "Suppliers_" . $second . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        
    }
    
    
     function url_exists($url) {
        @ $headers = get_headers($url);
        return preg_match('/^HTTP\/\d\.\d\s+(200|301|302)/', $headers[0]);
    }
    
    public function in_array_r($needle, $haystack) {
        for ($index = 0; $index < count($haystack); $index++) {
            if ($haystack[$index]["name"] == $needle) {
                return $index;
            }
        }

        return -1;
    }
}
?>

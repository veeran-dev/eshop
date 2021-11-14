<?php

class Storeexport extends Module {

    private $_html;
    private $RECORD_SEPARATOR;

    public function __construct() {
        $this->name = 'storeexport';
        $this->tab = 'Tools';
        $this->version = 0.1;
        $this->author = 'Presta FABRIQUE';
        $this->need_instance = 0;
        $this->RECORD_SEPARATOR = ";";

        parent::__construct();

        $this->displayName = $this->l('Store export for PrestaShop');
        $this->description = $this->l('Export data to CSV compatible with PrestaShop import');
    }

    public function install() {
        if (!parent::install() OR
                !$this->registerHook('productFooter') OR
                !$this->registerHook('header'))
            return false;
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall())
            return false;
        return true;
    }

    public function getContent() {

        $langs = $this->getLanguages();

//        $this->populateCategoreis($langs);
//
//        $this->populateProducts($langs);
//
//        $this->attributeImport($langs);
//
//
//        $this->populateSuppliers($langs);
//        $this->populateManufacturers($langs);
//        $this->populateCustomers($langs);
//        $this->populateAddresses($langs);

        $adminDir = __PS_BASE_URI__ . substr($_SERVER['SCRIPT_NAME'], strlen(__PS_BASE_URI__));
        $adminDir = substr($adminDir, 0, strrpos($adminDir, '/'));

        
        
        $url = "http://" . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8');


        $this->_html .= '<div>';
        $this->_html.="<script src='http://code.jquery.com/jquery-latest.js'></script>";
        $this->_html.="<script type='text/javascript'>
            $(document).ready(function(){    
            
        $('#export').click(function () {
        
                $('#Exporting').show('slow');

                //alert($('#exportitems option:selected').val());
                 //alert($('#langs option:selected').val());
                 var first=$('#exportitems option:selected').val();
                 var second=$('#langs option:selected').val();
                 var u=first+'_'+second;
                
                 $.post('../modules/storeexport/sxajax.php', { first: first, second: second },
                    function(data) {
                        //alert('Data Loaded: ' + data);
                        var e='" . $url .__PS_BASE_URI__ ."';
                        e+='/../modules/storeexport/'+u+'.csv';
                        //window.open(e,'_blank');
                        window.location.href = e;
                        $('#Exporting').hide('slow');
                 });
                 
                 
                 
           });
           });
           </script>";
        $this->_html.='<fieldset>
					<legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Export options').'</legend>
                    <label>Select which entity to export:</label>
		<p style="margin-top:0px;"><select id="exportitems">
                <option>Categories</option>
                <option>Products</option>
                <option>Combinations</option>
                <option>Customers</option>
                <option>Addresses</option>
                <option>Manufacturers</option>
                <option>Suppliers</option>
                </select></p>';
        $this->_html .= '<br/>
                <label>Select Language:</label>
		<p style="margin-top:0px;"><select id="langs">';

        for ($index = 0; $index < count($langs); $index++) {
            $this->_html .= '<option value="' . $langs[$index]["iso_code"] . '">' . $langs[$index]["name"] . '</option>';
        }
        $this->_html .="</select></p>";
        $this->_html.="<br/><label>&nbsp;</label><input type='submit' value='Export' id='export' class='button' /><br/><label id='Exporting' style='display: none'>Exporting...</label></fieldset>";

        $this->_html.="</div>";





        return $this->_html;
    }

    public function getLanguages() {

        $langs = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT *
		FROM ' . _DB_PREFIX_ . 'lang');
        return $langs;
    }

    function url_exists($url) {
        @ $headers = get_headers($url);
        return preg_match('/^HTTP\/\d\.\d\s+(200|301|302)/', $headers[0]);
    }

    public function populateCategoreis($langs) {
        $Colheader = "ID;Active;Name;Parent Category;Description;Meta-title;Meta-keyword;Meta-description;URL rewritten;Image URL\n";

        $output = '';
        for ($index = 0; $index < count($langs); $index++) {
            $cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		select c.id_category,c.active,l.name,c.id_parent,l.description,l.meta_title,l.meta_keywords,l.meta_description,l.link_rewrite
from ' . _DB_PREFIX_ . 'category c,' . _DB_PREFIX_ . 'category_lang l
where l.id_lang=' . $langs[$index]["id_lang"] . ' and l.id_category=c.id_category');

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



            $myFile = "Categories_" . $langs[$index]["iso_code"] . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $Colheader);
            fwrite($fh, $output);

            fclose($fh);
        }
    }

    public function in_array_r($needle, $haystack) {
        for ($index = 0; $index < count($haystack); $index++) {
            if ($haystack[$index]["name"] == $needle) {
                return $index;
            }
        }

        return -1;
    }

    public function populateProducts($langs) {


        $max = 0;

        $output = '';
        for ($index = 0; $index < count($langs); $index++) {
            $prods = '';
            if (Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('DESC ' . _DB_PREFIX_ . 'specific_price') == true) {
                $prods = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT s.*,l.*,p.*
FROM ' . _DB_PREFIX_ . 'product_lang l,' . _DB_PREFIX_ . 'product p
LEFT JOIN ' . _DB_PREFIX_ . 'specific_price s ON s.id_product=p.id_product
WHERE l.id_lang=' . $langs[$index]["id_lang"] . ' AND p.id_product=l.id_product');
            } else {
                $prods = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT p.*,l.*
FROM ' . _DB_PREFIX_ . 'product_lang l,' . _DB_PREFIX_ . 'product p
WHERE l.id_lang=' . $langs[$index]["id_lang"] . ' AND p.id_product=l.id_product');
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
                where p.id_product=' . $pid . ' and t.id_lang=' . $langs[$index]["id_lang"] . '  and p.id_tag=t.id_tag');
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
                                                    where id_lang=' . $langs[$index]["id_lang"]);


                $features = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                select l.name,fl.value
                from ' . _DB_PREFIX_ . 'feature_lang l,' . _DB_PREFIX_ . 'feature_product p,' . _DB_PREFIX_ . 'feature_value_lang fl
                where p.id_product=' . $pid . ' and l.id_lang=' . $langs[$index]["id_lang"] . '   and p.id_feature=l.id_feature and fl.id_feature_value=p.id_feature_value and fl.id_lang=' . $langs[$index]["id_lang"]);
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
            $myFile = "Products_" . $langs[$index]["iso_code"] . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        }
    }

    public function attributeImport($langs) {
        $output = '';
        $prods = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
                select * from ' . _DB_PREFIX_ . 'product');

        for ($index = 0; $index < count($langs); $index++) {
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
                            where ac.id_product_attribute=' . $prodcombi[$cindex]["id_product_attribute"] . ' and a.id_attribute=ac.id_attribute and gl.id_attribute_group=a.id_attribute_group and gl.id_lang=' . $langs[$index]["id_lang"] . '
                                and al.id_attribute=a.id_attribute and al.id_lang=' . $langs[$index]["id_lang"]);

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
            $myFile = "Combinations_" . $langs[$index]["iso_code"] . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        }
    }

    public function populateAddresses($langs) {
        $output = '';
        for ($index = 0; $index < count($langs); $index++) {
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
            $myFile = "Addresses_" . $langs[$index]["iso_code"] . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        }
    }

    public function populateCustomers($langs) {
        $output = '';
        for ($index = 0; $index < count($langs); $index++) {
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
            $myFile = "Customers_" . $langs[$index]["iso_code"] . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        }
    }

    public function populateManufacturers($langs) {
        $output = '';
        for ($index = 0; $index < count($langs); $index++) {
            $query = 'SELECT l.*,m.*
            FROM   ' . _DB_PREFIX_ . 'manufacturer m LEFT JOIN
                  ' . _DB_PREFIX_ . 'manufacturer_lang l ON (l.id_manufacturer = m.id_manufacturer
                      AND l.id_lang =' . $langs[$index]["id_lang"] . ')';

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
            $myFile = "Manufacturers_" . $langs[$index]["iso_code"] . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        }
    }

    public function populateSuppliers($langs) {
        $output = '';
        for ($index = 0; $index < count($langs); $index++) {


            $query = 'SELECT l.*,s.*
            FROM   ' . _DB_PREFIX_ . 'supplier s LEFT JOIN 
                  ' . _DB_PREFIX_ . 'supplier_lang l ON (l.id_supplier = s.id_supplier
                      AND l.id_lang =' . $langs[$index]["id_lang"] . ')';


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
            $myFile = "Suppliers_" . $langs[$index]["iso_code"] . ".csv";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $colheader);
            fwrite($fh, $output);
            fclose($fh);
        }
    }

    public function hookHeader() {
        
    }

    /**
     * Returns module content for left column
     */
    public function hookProductFooter($params) {
        global $smarty, $cookie, $link;


        return true;
    }

}
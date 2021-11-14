<?php
/**
 *
 */
class InstantSearchCore extends ObjectModel
{
    public static function find($id_lang, $expr, $page_number = 1, $page_size = 1, $order_by = 'position', $order_way = 'desc', Context $context = null, $category, $brand, $price, $zone, $sort)
    {

        if (!$context) {
            $context = Context::getContext();
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $start = ($page_number-1) * $page_size;
        $sphinx_results = self::getSphinxResults($expr, $start, $page_size, $category, $brand, $price, $sort);
        $result = null;
        $total = 0;
        // get products by id if something found
        if (is_array($sphinx_results) AND sizeof($sphinx_results) AND isset($sphinx_results['total']) AND $sphinx_results['total'] > 0) {
            $zone_query = '';
            if(!empty($zone) && $zone != undefined){
                $zone_query = ' AND pincode.zone_pin_start <= '.$zone.' AND pincode.zone_pin_end >='.$zone   ;
            }
            
            // $sphinx_results_id = implode(",", $sphinx_results['results']);
            $sphinx_results_id = $sphinx_results['results'];
            if($sort == 'desc' || $sort == 'asc'){
                $sort = "ORDER BY FIELD(p.id_product,".$sphinx_results_id.")";
            }
            else{
                $sort = "";
            }
            $sql = "SELECT p.id_product,p.reference,p.price,p.id_category_default,p.id_manufacturer,pl.`link_rewrite`, pl.`name`,pl.`link_rewrite`, pl.`name`,MAX(pa.`id_product_attribute`) as id_product_attribute, suppliers.`supplier_count`
                    FROM kob_product p
                    INNER JOIN `kob_product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = 1 AND pl.id_shop = 1)
                    LEFT JOIN `kob_product_attribute` pa ON (p.`id_product` = pa.`id_product`)
                    LEFT JOIN (
                        SELECT COUNT(DISTINCT(zone.id_supplier)) as supplier_count, zone.id_product FROM `kob_elite_supplier_zone` AS zone
                        LEFT JOIN kob_elite_supplier_stock stock on zone.id_product=stock.id_product and stock.id_supplier = zone.id_supplier
                        LEFT JOIN kob_pincode_master AS pincode ON zone.id_zone=pincode.zone_id
                        WHERE stock.out_of_stock = 0
                        ".$zone_query."
                        GROUP by zone.id_product
                    ) as suppliers on suppliers.id_product = p.id_product
                    WHERE p.`id_product` IN(".$sphinx_results_id.") and p.`available_for_order` = 1
                    and p.`hsn_code` != 0
                    and p.`active`=1
                    and .p.`price` != 0
                    GROUP BY p.id_product 
                    ".$sort." 
                    LIMIT ".$start.",".$page_size."";
                    // print_r($sql);
            $result = $db->executeS($sql);  
            $total = $sphinx_results['total'];
        }
        // $result_properties=$result;
        $result_properties = Product::getProductsProperties((int)$id_lang, $result);    
        foreach($result_properties as &$product){
            $prod = new Product($product['id_product']);
            $product['price'] = $prod->price;
        }
        // print_r($result_properties);
        $price = max(array_column($result_properties, 'price'));
        $category = array_column($result_properties, 'category', 'id_category_default');
        $new_cat = array();
        $i = 0;
        foreach($category as $key => $value){
            if($value != ""){
                $new_cat[$i]['value'] = $key;
                $new_cat[$i]['label'] = $value;
                $i++;
            }
        }
        $manufacturer = array_column($result_properties, 'manufacturer', 'id_manufacturer');
        $new_brd = array();
        $j = 0;
        foreach($manufacturer as $key => $value){
            if($value != ""){
                $new_brd[$j]['value'] = $key;
                $new_brd[$j]['label'] = $value;
                $j++;
            }
        }
        return array('total' => $total, 'result' => $result_properties, 'category' => $new_cat, 'manufacturer' => $new_brd, 'price' => $price, 'zone' => $zone);
    }

    protected static function getSphinxResults($search_query, $page_number, $page_size, $category, $brand, $price, $sort)
    {
        $results = array();
        $total = 0;
        if(!$search_query){
            return null;
        }
        
        $link = mysqli_connect('127.0.0.1', '', '', '', '9306');
        if($link)
        {
            $additinal_queries = "";
            $price_a = "";
            $price_b = "";
            $order_by = "";
            
            if($brand != ''  AND $brand != undefined){
                // $brand = str_replace('brd_', '', $brand);                
                $additinal_queries .= 'AND id_manufacturer IN('.$brand.')';
            }
            
            if($category != ''  AND $category != undefined){
                // $category = str_replace('cat_', '', $category);                
                $additinal_queries .= 'AND id_category IN('.$category.')';
            }
            if($price != '' AND $price != undefined){
                $price_a = ' AND price<'. preg_replace('/,/','',number_format($price,2)).'';
                $price_b = '  and cond=1';
            }
            if($sort=='desc'){
                $sort = "ORDER BY price DESC";
            }
            else if($sort == 'asc'){
                $sort = "ORDER BY price ASC";
            }
            if($search_query){
                // $search_query = str_replace(' ','&', $search_query);
            }
                    
            $query = 'SELECT * FROM `prestasite` WHERE MATCH(\''.pSQL($search_query).'\') '.$price_a.' '.$additinal_queries.' '.$sort.' LIMIT 1000 OPTION ranker=bm25, field_weights=(name=20, reference=50, category=8, brand=8, tag=7);';
            // var_dump($query);
            $result = $link->query($query);
            if ($result = $link->query($query))
            {
                
                $total = (int)$result->num_rows;
                if($total > 1000){
                    $total = 1000;
                }
                $result_arr = "";
                while($query_results = $result->fetch_array())
                {   
                    $result_arr .= ", ".$query_results[0];
                }
                $result_arr = ltrim($result_arr,",");
                /* clear result */
                $result->close();
            }

            mysqli_close($link);
        }
        return array('results' => $result_arr, 'total' => $total);
    }
}

 ?>

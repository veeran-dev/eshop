<?php
class Search extends SearchCore {
   
      public static function find($id_lang, $expr, $page_number = 1, $page_size = 1, $order_by = 'position',
        $order_way = 'desc', $ajax = false, $use_cookie = true, Context $context = null, $id_category=null, $id_customer = NULL)
    {
        if (!$context) {
            $context = Context::getContext();
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

        // TODO : smart page management
        if ($page_number < 1) {
            $page_number = 1;
        }
        if ($page_size < 1) {
            $page_size = 1;
        }

        if($id_customer){
            $customerObj = new Customer((int)($id_customer));
            $now = date('Y-m-d H:i:s');
        }

        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            return false;
        }

        $intersect_array = array();
        $score_array = array();
        $words = explode(' ', Search::sanitize($expr, $id_lang, false, $context->language->iso_code));

        foreach ($words as $key => $word) {
            if (!empty($word) && strlen($word) >= (int)Configuration::get('PS_SEARCH_MINWORDLEN')) {
                $word = str_replace(array('%', '_'), array('\\%', '\\_'), $word);
                $start_search = Configuration::get('PS_SEARCH_START') ? '%': '';
                $end_search = Configuration::get('PS_SEARCH_END') ? '': '%';

                $intersect_array[] = 'SELECT si.id_product
                    FROM '._DB_PREFIX_.'search_word sw
                    LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
                    WHERE sw.id_lang = '.(int)$id_lang.'
                        AND sw.id_shop = '.$context->shop->id.'
                        AND sw.word LIKE
                    '.($word[0] == '-'
                        ? ' \''.$start_search.pSQL(Tools::substr($word, 1, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\''
                        : ' \''.$start_search.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\''
                    );

                if ($word[0] != '-') {
                    $score_array[] = 'sw.word LIKE \''.$start_search.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\'';
                }
            } else {
                unset($words[$key]);
            }
        }

        if (!count($words)) {
            return ($ajax ? array() : array('total' => 0, 'result' => array()));
        }

        $score = '';
        if (is_array($score_array) && !empty($score_array)) {
            $score = ',(
                SELECT SUM(weight)
                FROM '._DB_PREFIX_.'search_word sw
                LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
                WHERE sw.id_lang = '.(int)$id_lang.'
                    AND sw.id_shop = '.$context->shop->id.'
                    AND si.id_product = p.id_product
                    AND ('.implode(' OR ', $score_array).')
            ) position';
        }

        $sql_groups = '';   
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1');
        }
        $category_ids='';
        if($id_category)
        {
            $category_ids='AND c.`id_category`='.$id_category;
        }        
        
        $results = $db->executeS('
        SELECT cp.`id_product`
        FROM `'._DB_PREFIX_.'category_product` cp
        '.(Group::isFeatureActive() ? 'INNER JOIN `'._DB_PREFIX_.'category_group` cg ON cp.`id_category` = cg.`id_category`' : '').'
        INNER JOIN `'._DB_PREFIX_.'category` c ON cp.`id_category` = c.`id_category`
        INNER JOIN `'._DB_PREFIX_.'product` p ON cp.`id_product` = p.`id_product`
        WHERE c.`active` = 1
        AND p.`active` = 1
        AND p.`visibility` IN ("both", "search") 
        AND p.indexed = 1
        '.$category_ids.'
        '.$sql_groups, true, false);

        $eligible_products = array();
        foreach ($results as $row) {
            $eligible_products[] = $row['id_product'];
        }
        foreach ($intersect_array as $query) {
            $eligible_products2 = array();
            foreach ($db->executeS($query, true, false) as $row) {
                $eligible_products2[] = $row['id_product'];
            }

            $eligible_products = array_intersect($eligible_products, $eligible_products2);
            if (!count($eligible_products)) {
                return ($ajax ? array() : array('total' => 0, 'result' => array()));
            }
        }

        $eligible_products = array_unique($eligible_products);

        $product_pool = '';
        foreach ($eligible_products as $id_product) {
            if ($id_product) {
                $product_pool .= (int)$id_product.',';
            }
        }
        if (empty($product_pool)) {
            return ($ajax ? array() : array('total' => 0, 'result' => array()));
        }
        $product_pool = ((strpos($product_pool, ',') === false) ? (' = '.(int)$product_pool.' ') : (' IN ('.rtrim($product_pool, ',').') '));

        if ($ajax) 
        {
            $join_query = $id_customer ? 'LEFT JOIN '._DB_PREFIX_.'specific_price sp ON p.`id_product` = sp.`id_product`' : "";
            $where_query = $id_customer ? 'AND sp.`id_group` = '.(int)$customerObj->id_default_group.' 
                                           AND((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) 
                                           AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`))
                                           GROUP BY sp.`id_product`' : "";

            $sql = 'SELECT DISTINCT p.`id_product`,p.`reference`,p.`discontinued`,pl.`description_short`, pl.`name` pname, cl.`name` cname,
                                    IF(i.`id_image`, CONCAT(p.`id_product`,"-",i.`id_image`), "en-default") AS product_cover,
                                    cl.`link_rewrite` crewrite, pl.`link_rewrite` '.$score.'
                    FROM '._DB_PREFIX_.'product p
                    '.$join_query.'
                    INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                        p.`id_product` = pl.`id_product`
                        AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                    )
                    INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (
                        p.`id_category_default` = cl.`id_category`
                        AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').'
                    )
                    LEFT JOIN kob_image_shop i ON (p.`id_product` = i.`id_product`) AND i.`cover` = 1 
                    WHERE p.`hsn_code` IS NOT NULL AND p.`id_product` '.$product_pool.' '.$where_query.'
                    ORDER BY position DESC LIMIT '.(int)(($page_number - 1) * $page_size).','.(int)$page_size.'';

            return $db->executeS($sql, true, false);                                              
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
        }
        $alias = '';
        if ($order_by == 'price') {
            $alias = 'p.';
        } elseif (in_array($order_by, array('date_upd', 'date_add'))) {
            $alias = 'p.';
        }
        $sql = 'SELECT p.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
                pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`name`,
             image_shop.`id_image` id_image, il.`legend`, m.`name` manufacturer_name '.$score.',
                DATEDIFF(
                    p.`date_add`,
                    DATE_SUB(
                        "'.date('Y-m-d').' 00:00:00",
                        INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
                    )
                ) > 0 new'.(Combination::isFeatureActive() ? ', product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, IFNULL(product_attribute_shop.`id_product_attribute`,0) id_product_attribute' : '').'
                FROM '._DB_PREFIX_.'product p
                INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                    p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                )
                '.(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop
                ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)$context->shop->id.')':'').'
                '.Product::sqlStock('p', 0).'
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
                    ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int)$context->shop->id.')
                LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
                WHERE p.`hsn_code` IS NOT NULL AND p.`id_product` '.$product_pool.'
                GROUP BY p.id_product
                '.($order_by ? 'ORDER BY  '.$alias.$order_by : '').($order_way ? ' '.$order_way : '').'
                LIMIT '.(int)(($page_number - 1) * $page_size).','.(int)$page_size;

        $result = $db->executeS($sql, true, false);

        $sql = 'SELECT COUNT(*)
                FROM '._DB_PREFIX_.'product p
                INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                    p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                )
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                WHERE p.`hsn_code` IS NOT NULL AND p.`id_product` '.$product_pool;
        $total = $db->getValue($sql, false);

        if (!$result) {
            $result_properties = false;
        } else {
            $result_properties = Product::getProductsProperties((int)$id_lang, $result);
        }

        return array('total' => $total,'result' => $result_properties);
    }

    public static function rowCount($expr)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

        $result= $db->getValue('SELECT count(DISTINCT id_product) FROM '._DB_PREFIX_.'search_word sw
                    LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
                    WHERE sw.id_lang = 1 AND sw.word LIKE "'.$expr.'%" ');
        return $result;
    }
	public static function customSearch($search_word,$id_customer)
	{  
 		$join='';
		$where='';
		if((int)$id_customer !=0)
		{
			$customer = new Customer((int)$id_customer); 
			$category_join = 'LEFT JOIN '._DB_PREFIX_.'category as c on c.id_category = cl.id_category  LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_product = cp.id_product  ';
			$product_join = 'LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_product = p.id_product ';
			$brand_join = ' LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_product = p.id_product ';
			
			$where = 'AND sp.id_group='.$customer->id_default_group.'';
			$cat_where = 'AND sp.id_group='.$customer->id_default_group.' AND c.active=1 ';
		}
		else{
			$category_join='';
			$product_join='';
			$brand_join='';
			$where='';
		}
  		 		 
		$sql='(SELECT cl.id_category, 0 AS id_product, 0 AS brand, "'.$search_word.'" AS search_query, (1000*MATCH(`name`) AGAINST ("'.$search_word.'*" IN BOOLEAN MODE)) AS score
		FROM  '._DB_PREFIX_.'category_lang AS cl  '.$category_join.' LEFT JOIN '._DB_PREFIX_.'category_product as cp on cp.id_category = cl.id_category LEFT JOIN '._DB_PREFIX_.'product AS p on p.id_product = cp.id_product WHERE (MATCH(`name`) AGAINST ("'.$search_word.'*" IN BOOLEAN MODE)) AND id_lang = 1 '.$cat_where.' AND p.active = 1 AND p.discontinued=0 GROUP BY cl.id_category LIMIT 2) 
		UNION
		(SELECT 0 AS id_category, p.id_product AS id_product, 0 AS brand ,"'.$search_word.'" AS search_query, ( ( 5 * MATCH(sw.`word`) AGAINST (+"'.$search_word.'*" IN BOOLEAN MODE))+( 5 * MATCH(pl.`name`) AGAINST (+"'.$search_word.'*" IN BOOLEAN MODE)) ) AS score
		FROM `'._DB_PREFIX_.'search_word` AS sw LEFT JOIN `'._DB_PREFIX_.'search_index` AS si ON si.`id_word` = sw.`id_word` LEFT JOIN '._DB_PREFIX_.'product AS p ON si.`id_product` = p.`id_product` LEFT JOIN '._DB_PREFIX_.'product_lang pl ON pl.id_product = p.id_product '.$product_join.'
		WHERE  (MATCH(`name`,reference) AGAINST (+"'.$search_word.'*" IN BOOLEAN MODE)) AND pl.id_lang =1 AND p.active=1 AND p.discontinued=0  '.$where.' GROUP BY p.id_product LIMIT 2 )
		UNION		
		(SELECT 0 AS id_category, 0 AS id_product, m.`id_manufacturer` AS brand ,"'.$search_word.'" AS search_query , ((1*MATCH(`name`) AGAINST ("'.$search_word.'*" IN BOOLEAN MODE))) AS score
		FROM '._DB_PREFIX_.'manufacturer as m  LEFT JOIN '._DB_PREFIX_.'product as p on p.id_manufacturer = m.id_manufacturer  '.$brand_join.' 
		WHERE (MATCH(`name`) AGAINST ("'.$search_word.'*" IN BOOLEAN MODE)) AND m.active = 1 AND p.active=1 AND p.discontinued=0  '.$where.' GROUP BY m.id_manufacturer LIMIT 2) 
		ORDER BY  score DESC';
		

  	    $result =  Db::getInstance()->executeS($sql);
		return $result;
	}
	public function getProductIdFromQueryForFilter($query,$id_customer,$page_number,$limit,$priceValues=array())
	{
		
		$join="";
		$where="";
		 

		if((int)$page_number == 0)
 			$page_number =1;
		else
			$page_number++;
		if($id_customer !=0)
		{
			$customer = new Customer((int)$id_customer); 
 			$join = ' LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_group ='.$customer->id_default_group;
		}
		// var_dump($priceValues);
		if($priceValues['priceMax']>0)
		{			
 			if($id_customer !=0)
			{	 
				
				
 				$where .= ' AND sp.id_product = p.id_product  And sp.price BETWEEN "'.$priceValues['priceMin'].'" AND "'.$priceValues['priceMax'].'" ';
			}
			else
			{
				$where .=' AND p.price BETWEEN "'.$priceValues['priceMin'].'" AND "'.$priceValues['priceMax'].'" ';
			}
			
		}
  		
		$sql_select = 'SELECT DISTINCT(p.`id_product`), pl.name';
		$sql_count = 'SELECT COUNT(DISTINCT(p.`id_product`)) AS total';
		$dataLimit =  ' LIMIT '.(int)(($page_number - 1) * $limit).','.(int)($page_number*$limit).'';
		
		$sql='  
		FROM `'._DB_PREFIX_.'search_word` AS sw LEFT JOIN `'._DB_PREFIX_.'search_index` AS si ON si.`id_word` = sw.`id_word` LEFT JOIN '._DB_PREFIX_.'product AS p ON si.`id_product` = p.`id_product` LEFT JOIN '._DB_PREFIX_.'product_lang pl ON pl.id_product = p.id_product '.$join.'
		WHERE  (MATCH(`name`,reference) AGAINST (+"'.$query.'*" IN BOOLEAN MODE)) AND pl.id_lang =1 AND p.active=1 AND p.discontinued=0  '.$where.'';
  			
 		$data = Db::getInstance()->ExecuteS($sql_select.$sql.$dataLimit);
		$count = Db::getInstance()->getValue($sql_count.$sql);
 		return array('result' => $data, 'total' => $count);	
	}
	
	public static function customAllSearch($search_query, $id_customer, $page_number, $limit, $suggestion = false)
	{
 		$join = "";
		$where = "";
		$now = date('Y-m-d H:i:s');

 		if((int)$page_number == 0)
 			$page_number =1;
		else
			$page_number++;
		
 		$dataLimit =  ' LIMIT '.(int)(($page_number - 1) * $limit).','.(int)($page_number*$limit).'';

		if($id_customer != 0) {
			$customer = new Customer((int)$id_customer); 
 			$join = ' LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_group ='.$customer->id_default_group; 
			$where =' AND p.id_product = sp.id_product AND ((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) 
												 AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`)) ' ;
		}
		
		$sql_select = 'SELECT p.`id_product`, pl.`name` as pname, p.`reference`, p.`id_manufacturer` as brand, 
                        p.`id_category_default` as id_category, m.`name` as m_name, cl.`name` as c_name, pl.`description_short`,
                        pl.`link_rewrite`, pl.`description`,((10 * MATCH(pl.`name`) AGAINST ("'.$search_query.'*" IN BOOLEAN MODE)
						) + (9 * MATCH(p.`reference`) AGAINST ("'.$search_query.'*" IN BOOLEAN MODE)
						) + (8 * MATCH(m.`name`) AGAINST ("'.$search_query.'*" IN BOOLEAN MODE)
						) + (7 * MATCH(cl.`name`) AGAINST ("'.$search_query.'*" IN BOOLEAN MODE)
						) + (6 * MATCH(pl.`description_short`) AGAINST ("'.$search_query.'*" IN BOOLEAN MODE)
						) + (5 * MATCH(pl.`description`) AGAINST ("'.$search_query.'*" IN BOOLEAN MODE) )
					  ) AS score';

 		$sql_filter_data = 'SELECT DISTINCT(p.id_product)';

		$sql = ' FROM '._DB_PREFIX_.'product AS p 
				  LEFT JOIN '._DB_PREFIX_.'product_lang AS pl ON p.`id_product` = pl.`id_product` 
				  LEFT JOIN '._DB_PREFIX_.'manufacturer AS m ON p.`id_manufacturer` = m.`id_manufacturer` 
				  LEFT JOIN '._DB_PREFIX_.'category AS c ON c.`id_category` = p.`id_category_default` 
				  LEFT JOIN '._DB_PREFIX_.'category_lang AS cl ON p.`id_category_default` = cl.`id_category` 
				  '.$join.'
				WHERE pl.`id_lang` = 1 AND p.`hsn_code` IS NOT NULL
				  AND (
					MATCH(pl.`name`,p.reference,m.name,cl.name,pl.`description_short`,pl.`description`) AGAINST ("'.$search_query.'*" IN BOOLEAN MODE)
				  ) 
				  AND cl.`id_lang` = 1 
				  AND p.`active` = 1 
				  AND p.`discontinued` = 0 
				  AND c.`active` = 1 
				  AND m.`active` = 1
				  '.$where;
		

   		if(!$suggestion) {
  			$data = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql_select.$sql." ORDER BY score DESC ".$dataLimit);
 			$filter_data = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql_filter_data.$sql);
 			return array('result' => $data, 'filter_data' => $filter_data);
		}
		else {
  			$data = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql_select.$sql." ORDER BY score DESC ".$dataLimit);
 			return $data;
		}	
 	}

    public static function customSearchInternal($id_lang, $expr, $page_number = 1, $page_size = 1, $order_by = 'position',
        $order_way = 'desc', $ajax = false, $use_cookie = true, Context $context = null, $id_category=null, $id_customer = NULL, $regions = NULL) {
        if (!$context) {
            $context = Context::getContext();
        }

        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

        // TODO : smart page management
        if ($page_number < 1) {
            $page_number = 1;
        }
        if ($page_size < 1) {
            $page_size = 1;
        }

        if($id_customer){
            $customerObj = new Customer((int)($id_customer));
            $now = date('Y-m-d H:i:s');
        }

        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            return false;
        }

        $intersect_array = array();
        $score_array = array();
        $words = explode(' ', Search::sanitize($expr, $id_lang, false, $context->language->iso_code));

        foreach ($words as $key => $word) {
            if (!empty($word) && strlen($word) >= (int)Configuration::get('PS_SEARCH_MINWORDLEN')) {
                $word = str_replace(array('%', '_'), array('\\%', '\\_'), $word);
                $start_search = Configuration::get('PS_SEARCH_START') ? '%': '';
                $end_search = Configuration::get('PS_SEARCH_END') ? '': '%';

                $intersect_array[] = 'SELECT si.id_product
                    FROM '._DB_PREFIX_.'search_word sw
                    LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
                    WHERE sw.id_lang = '.(int)$id_lang.'
                        AND sw.id_shop = '.$context->shop->id.'
                        AND sw.word LIKE
                    '.($word[0] == '-'
                        ? ' \''.$start_search.pSQL(Tools::substr($word, 1, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\''
                        : ' \''.$start_search.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\''
                    );

                if ($word[0] != '-') {
                    $score_array[] = 'sw.word LIKE \''.$start_search.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).$end_search.'\'';
                }
            } else {
                unset($words[$key]);
            }
        }

        if (!count($words)) {
            return ($ajax ? array() : array('total' => 0, 'result' => array()));
        }

        $score = '';
        if (is_array($score_array) && !empty($score_array)) {
            $score = ',(
                SELECT SUM(weight)
                FROM '._DB_PREFIX_.'search_word sw
                LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
                WHERE sw.id_lang = '.(int)$id_lang.'
                    AND sw.id_shop = '.$context->shop->id.'
                    AND si.id_product = p.id_product
                    AND ('.implode(' OR ', $score_array).')
            ) position';
        }

        $sql_groups = '';   
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1');
        }
        $category_ids='';
        if($id_category)
        {
            $category_ids='AND c.`id_category`='.$id_category;
        }        
        
        $results = $db->executeS('
        SELECT cp.`id_product`
        FROM `'._DB_PREFIX_.'category_product` cp
        '.(Group::isFeatureActive() ? 'INNER JOIN `'._DB_PREFIX_.'category_group` cg ON cp.`id_category` = cg.`id_category`' : '').'
        INNER JOIN `'._DB_PREFIX_.'category` c ON cp.`id_category` = c.`id_category`
        INNER JOIN `'._DB_PREFIX_.'product` p ON cp.`id_product` = p.`id_product`
        WHERE c.`active` = 1
        AND p.`active` = 1
        AND p.`visibility` IN ("both", "search") 
        AND p.indexed = 1
        '.$category_ids.'
        '.$sql_groups, true, false);

        $eligible_products = array();
        foreach ($results as $row) {
            $eligible_products[] = $row['id_product'];
        }
        foreach ($intersect_array as $query) {
            $eligible_products2 = array();
            foreach ($db->executeS($query, true, false) as $row) {
                $eligible_products2[] = $row['id_product'];
            }

            $eligible_products = array_intersect($eligible_products, $eligible_products2);
            if (!count($eligible_products)) {
                return ($ajax ? array() : array('total' => 0, 'result' => array()));
            }
        }

        $eligible_products = array_unique($eligible_products);

        $product_pool = '';
        foreach ($eligible_products as $id_product) {
            if ($id_product) {
                $product_pool .= (int)$id_product.',';
            }
        }
        if (empty($product_pool)) {
            return ($ajax ? array() : array('total' => 0, 'result' => array()));
        }
        $product_pool = ((strpos($product_pool, ',') === false) ? (' = '.(int)$product_pool.' ') : (' IN ('.rtrim($product_pool, ',').') '));

        if ($ajax) 
        {
            $join_query = $id_customer ? 'LEFT JOIN '._DB_PREFIX_.'specific_price sp ON p.`id_product` = sp.`id_product`' : "";
            $where_query = $id_customer ? 'AND sp.`id_group` = '.(int)$customerObj->id_default_group.' 
                                           AND((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) 
                                           AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`))
                                           GROUP BY sp.`id_product`' : "";
            $join = "";
            $where = "";

            if(isset($regions) && $regions) {
                $join = 'LEFT JOIN '._DB_PREFIX_.'product_zone_mapping pzm ON p.`id_product` = pzm.`product_id`';
                $where = ' AND pzm.`zone_id` IN('.implode($regions, ',').', 0)';
            }

            $sql = 'SELECT DISTINCT p.`id_product`,p.`reference`,p.`discontinued`,pl.`description_short`, pl.`name` pname, cl.`name` cname,
                                    IF(i.`id_image`, CONCAT(p.`id_product`,"-",i.`id_image`), "en-default") AS product_cover,
                                    cl.`link_rewrite` crewrite, pl.`link_rewrite` '.$score.'
                    FROM '._DB_PREFIX_.'product p
                    '.$join_query.'
                    '.$join.'
                    INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                        p.`id_product` = pl.`id_product`
                        AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                    )
                    INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (
                        p.`id_category_default` = cl.`id_category`
                        AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').'
                    )
                    LEFT JOIN kob_image_shop i ON (p.`id_product` = i.`id_product`) AND i.`cover` = 1 
                    WHERE p.`hsn_code` IS NOT NULL AND p.`id_product` '.$product_pool.' '.$where_query.'
                    '.$where.'
                    ORDER BY position DESC LIMIT '.(int)(($page_number - 1) * $page_size).','.(int)$page_size.'';
                    
            return $db->executeS($sql, true, false);                                              
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
        }
        $alias = '';
        if ($order_by == 'price') {
            $alias = 'p.';
        } elseif (in_array($order_by, array('date_upd', 'date_add'))) {
            $alias = 'p.';
        }
        $sql = 'SELECT p.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
                pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`name`,
             image_shop.`id_image` id_image, il.`legend`, m.`name` manufacturer_name '.$score.',
                DATEDIFF(
                    p.`date_add`,
                    DATE_SUB(
                        "'.date('Y-m-d').' 00:00:00",
                        INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
                    )
                ) > 0 new'.(Combination::isFeatureActive() ? ', product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, IFNULL(product_attribute_shop.`id_product_attribute`,0) id_product_attribute' : '').'
                FROM '._DB_PREFIX_.'product p
                INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                    p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                )
                '.(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop
                ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)$context->shop->id.')':'').'
                '.Product::sqlStock('p', 0).'
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
                    ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int)$context->shop->id.')
                LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
                WHERE p.`hsn_code` IS NOT NULL AND p.`id_product` '.$product_pool.'
                GROUP BY p.id_product
                '.($order_by ? 'ORDER BY  '.$alias.$order_by : '').($order_way ? ' '.$order_way : '').'
                LIMIT '.(int)(($page_number - 1) * $page_size).','.(int)$page_size;

        $result = $db->executeS($sql, true, false);

        $sql = 'SELECT COUNT(*)
                FROM '._DB_PREFIX_.'product p
                INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (
                    p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
                )
                LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                WHERE p.`hsn_code` IS NOT NULL AND p.`id_product` '.$product_pool;
        $total = $db->getValue($sql, false);

        if (!$result) {
            $result_properties = false;
        } else {
            $result_properties = Product::getProductsProperties((int)$id_lang, $result);
        }

        return array('total' => $total,'result' => $result_properties);        
    }
}
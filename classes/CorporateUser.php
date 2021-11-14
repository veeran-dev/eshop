<?php
	
class CorporateUserCore extends Link
{
	public $q;
	public $customerid;
	public $pro;
	public $cus;
	public $result;
	public $resultsArray;
	public $query_result;
	public $id_customer;
	public $row;
	public $id_lang;
	public $row2;
	public $src;
	public $getimage;
	public $imagePath;
	public $m;

	 
	public function search($q,$id_customer)
	{
		$now = date('Y-m-d H:i:s'); 
		$useSSL = true;
		$q=trim($q);
		$customerid=$id_customer;
		//$my_data=mysql_real_escape_string($q);
		$my_data=$q;
				/*$matchedProducts = Db::getInstance()->ExecuteS('SELECT  rc.id_rate_contract, rc.id_product, kpl.name, c.id_image, kcl.link_rewrite,kp.`reference`,((20*MATCH(kp.`reference`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+(10*MATCH(kpl.`name`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE)) 
														+ (5*MATCH(kcl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+
																	(2*MATCH(km.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))) AS Relevance
														FROM `'._DB_PREFIX_.'rate_contract` AS rc, 
														`'._DB_PREFIX_.'product_lang` AS kpl, 
														`'._DB_PREFIX_.'category_product` AS kcp,
														`'._DB_PREFIX_.'category_lang` AS kcl,
														`'._DB_PREFIX_.'product` AS kp LEFT JOIN `'._DB_PREFIX_.'manufacturer` AS km ON km.`id_manufacturer`=kp.`id_manufacturer`
														LEFT JOIN `'._DB_PREFIX_.'image` AS c ON c.`id_product`= kp.`id_product` AND c.cover=1
														WHERE (MATCH(kp.`reference`,km.`name`,kcl.`name`,kpl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))
														AND kpl.`id_product` = rc.`id_product` 
														AND kcp.`id_product`= kpl.`id_product`
														AND kcl.`id_category`= kcp.`id_category`
														AND rc.`id_product`=kp.`id_product`
														AND kpl.id_lang=1 AND kcl.id_lang=1
														AND	rc.`id_customer` = "'.$customerid.'"
														AND rc.active= 1
														AND kp.active = 1
														AND kp.discontinued = 0
														GROUP BY rc.id_product
														ORDER BY Relevance DESC
														');*/
		
		
		
		$matchedProducts = Db::getInstance()->ExecuteS('SELECT  sp.id_product,kes.company ,kes.id_supplier, kpl.name, c.id_image, kcl.link_rewrite,kp.`reference`,((10*MATCH(kp.`reference`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+(20*MATCH(kpl.`name`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE)) 
														+ (8*MATCH(kcl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+
																	(7*MATCH(km.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))) AS Relevance
														FROM  
														`'._DB_PREFIX_.'specific_price` AS sp, 
														`'._DB_PREFIX_.'elite_supplier` AS kes,
														`'._DB_PREFIX_.'customer` AS cus, 
														`'._DB_PREFIX_.'product_lang` AS kpl, 
														`'._DB_PREFIX_.'category_product` AS kcp,
														`'._DB_PREFIX_.'category_lang` AS kcl,
														`'._DB_PREFIX_.'product` AS kp LEFT JOIN `'._DB_PREFIX_.'manufacturer` AS km ON km.`id_manufacturer`=kp.`id_manufacturer`
														LEFT JOIN `'._DB_PREFIX_.'image` AS c ON c.`id_product`= kp.`id_product` AND c.cover=1
														WHERE (MATCH(kp.`reference`,km.`name`,kcl.`name`,kpl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))
														AND kpl.`id_product` = sp.`id_product` 
														AND kcp.`id_product`= kpl.`id_product`
														AND kcl.`id_category`= kcp.`id_category`
														AND sp.`id_product`=kp.`id_product`
														AND kpl.id_lang = 1 
														AND kcl.id_lang = 1
														AND	cus.`id_customer` = "'.$customerid.'"
														AND cus.id_default_group = sp.id_group
														AND((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`))
														AND kp.active = 1
														AND kp.discontinued = 0
														AND sp.id_supplier=kes.id_supplier
														GROUP BY sp.id_product
														ORDER BY Relevance DESC
														');
		$products = Product::getProductsProperties($id_lang=1, $matchedProducts);												
		$this->getProductImageLink($products,null,null);
	}
	public   function searchAll($q,$id_customer)
	{
		
		$useSSL = true;
		$q=trim($q);
		$customerid=$id_customer;
		//$my_data=mysql_real_escape_string($q);
		$my_data= $q;
				$matchedProducts = Db::getInstance()->ExecuteS('SELECT  kp.id_product, kes.company ,kes.name,kpl.name, c.id_image, kcl.link_rewrite,kp.`reference`,((10*MATCH(kp.`reference`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+(20*MATCH(kpl.`name`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE)) 
														+ (8*MATCH(kcl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+
																	(7*MATCH(km.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))) AS Relevance
														FROM 
														`'._DB_PREFIX_.'product_lang` AS kpl, 
														`'._DB_PREFIX_.'category_product` AS kcp,
														`'._DB_PREFIX_.'category_lang` AS kcl,
														`'._DB_PREFIX_.'product` AS kp LEFT JOIN `'._DB_PREFIX_.'manufacturer` AS km ON km.`id_manufacturer`=kp.`id_manufacturer`
														LEFT JOIN `'._DB_PREFIX_.'image` AS c ON c.`id_product`= kp.`id_product` AND c.cover=1
														WHERE (MATCH(kp.`reference`,km.`name`,kcl.`name`,kpl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))
														AND kpl.`id_product` = kp.`id_product` 
														AND kcp.`id_product`= kpl.`id_product`
														AND kcl.`id_category`= kcp.`id_category`
														AND kpl.id_lang=1 AND kcl.id_lang=1
														AND kp.active = 1
														AND kp.discontinued = 0
														GROUP BY kp.id_product
														ORDER BY Relevance DESC
														LIMIT 20
														');
		$products = Product::getProductsProperties($id_lang=1, $matchedProducts);												
		$this->getProductImageLink($products,null,null);
	}
	public function getProductImageLink($products = NULL,$shippingPrice = NULL,$totalPrice = NULL,$totalTax = NULL,$discount = NULL,$points_product = NULL)
	{
		global $cookie;
		$link = new Link();
		for ($i = 0; $i < sizeof($products); ++$i)
		{
			$obj = new Product((int)($products[$i]['id_product']), false, 1);
			if (!Validate::isLoadedObject($obj))
				continue;
			else
			{				
				$images = $obj->getImages(1);
				foreach ($images AS $k => $image)
				{
					if ($image['cover'])
					{
						$products[$i]['cover'] = $obj->id.'-'.$image['id_image'];
						break;
					}
				}

				if (!isset($products[$i]['cover']))
					$products[$i]['cover'] = Language::getIsoById((int)$cookie->id_lang).'-default';

				if (!isset($products[$i]['link']))
					$products[$i]['link'] = $link->getProductLink($products[$i]['id_product']);
			}
		}

	 $price = array();	
	 $getimages = array();
	$priceDisplayValue = Product::getTaxCalculationMethod();

	if(!$priceDisplayValue || $priceDisplayValue == 2)
		$tax=true;
	elseif($priceDisplayValue == 1)
		$tax=false;

	foreach($products as $product)
	{
		$useProduct = new Product($product['id_product']);
		$price[] = $useProduct->getPrice($tax);
		$getimages[] = parent::getImageLink($product['link_rewrite'], $product['cover'], 'small');
	}
	
	for($i = 0; $i < sizeof($products); $i++)
	{
		$getimages[$i] = $getimages[$i];
		array_push($products[$i], $getimages[$i], $price[$i], $shippingPrice,$totalPrice,$totalTax,$discount,$points_product);
	}

	echo Tools::jsonEncode($products);

	}
}
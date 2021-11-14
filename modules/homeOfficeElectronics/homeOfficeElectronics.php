<?php
class homeOfficeElectronics extends Module
{
	private $_html = '';
	private $_postErrors = array();
	function __construct()
	{
		$this->name = 'homeOfficeElectronics';
		$this->tab = 'front_office_features';
		$this->version = '0.0.0';
		parent::__construct(); // The parent construct is required for translations
		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Office Electronics products on the home page');
		$this->description = $this->l('Office Electronics products on the home page');
	}
	function install()
	{
		if (!Configuration::updateValue('HOME_OFF_ELEC_NBR', 20) OR !parent::install() OR !$this->registerHook('home') OR !$this->registerHook('header') OR !$this->registerHook('displayShop'))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_SORT', 0))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_DISPLAY_PRICE', 1))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_DISPLAY_NAME', 1))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_SKIP_CAT', 1))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_AUTOPLAY', 1))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_AUTOPLAY_DURATION', 15))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_ITEMS_VISIBLE', 5))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_ITEMS_SCROLL', 3))
			return false;
		if (!Configuration::updateValue('HOME_OFF_ELEC_IMAGE_TYPE', 'home'))
			return false;
		return true;
	}
	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitHomeCarouselNew'))
		{
			$nbr = (int)(Tools::getValue('nbr'));
			$sort = (int)(Tools::getValue('sort'));
			$displayprice = (int)(Tools::getValue('displayprice'));
			$displayname = (int)(Tools::getValue('displayname'));
			$skipcat = Tools::getValue('skipcat');
			$autoplay = (int)(Tools::getValue('autoplay'));
			$autoplayduration = (int)(Tools::getValue('autoplayduration'));
			$itemsvisible = (int)(Tools::getValue('itemsvisible'));
			$itemsscroll = (int)(Tools::getValue('itemsscroll'));
			$imagetype = Tools::getValue('imagetype');
			if (!$nbr OR $nbr <= 0 OR !Validate::isInt($nbr))
				$errors[] = $this->l('Invalid number of product');
			else
				Configuration::updateValue('HOME_OFF_ELEC_NBR', $nbr);
				
			Configuration::updateValue('HOME_OFF_ELEC_SORT', $sort);
			Configuration::updateValue('HOME_OFF_ELEC_DISPLAY_PRICE', $displayprice);
			Configuration::updateValue('HOME_OFF_ELEC_DISPLAY_NAME', $displayname);
			if (!empty($skipcat))
				Configuration::updateValue('HOME_OFF_ELEC_SKIP_CAT', implode(',',$skipcat));
			Configuration::updateValue('HOME_OFF_ELEC_AUTOPLAY', $autoplay);
			Configuration::updateValue('HOME_OFF_ELEC_AUTOPLAY_DURATION', $autoplayduration);
			Configuration::updateValue('HOME_OFF_ELEC_ITEMS_VISIBLE', $itemsvisible);
			Configuration::updateValue('HOME_OFF_ELEC_ITEMS_SCROLL', $itemsscroll);
			Configuration::updateValue('HOME_OFF_ELEC_IMAGE_TYPE', $imagetype);
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}
	function recurseCategory($categories, $current, $id_category = 1, $selectids_array)
	{
		global $currentIndex;		
		echo '<option value="'.$id_category.'"'.(in_array($id_category,$selectids_array) ? ' selected="selected"' : '').'>'.
		str_repeat('&nbsp;', $current['infos']['level_depth'] * 5) . preg_replace('/^[0-9]+\./', '', stripslashes($current['infos']['name'])) . '</option>';
		if (isset($categories[$id_category]))
			foreach ($categories[$id_category] AS $key => $row)
				$this->recurseCategory($categories, $categories[$id_category][$key], $key, $selectids_array);
	}
	public function displayForm()
	{
		global $cookie,$currentIndex;
		$output = '
					<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
						<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
						<label>'.$this->l('Autoplay Carousel').'</label>
						<div class="margin-form">
							<input type="radio" name="autoplay" id="autoplay_on" value="1" '.(Tools::getValue('autoplay', Configuration::get('HOME_OFF_ELEC_AUTOPLAY')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="autoplay_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
							<input type="radio" name="autoplay" id="autoplay_off" value="0" '.(!Tools::getValue('autoplay', Configuration::get('HOME_OFF_ELEC_AUTOPLAY')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="autoplay_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						</div>		
						<label>'.$this->l('Autoplay time').'</label>
						<div class="margin-form">
							<input type="text" size="5" name="autoplayduration" value="'.Tools::getValue('autoplayduration', Configuration::get('HOME_OFF_ELEC_AUTOPLAY_DURATION')).'" />
							<p class="clear">'.$this->l('The time between each carousel move').'</p>
						</div>		
						<label>'.$this->l('Number of products in the carousel').'</label>
						<div class="margin-form">
							<input type="text" size="5" name="nbr" value="'.Tools::getValue('nbr', Configuration::get('HOME_OFF_ELEC_NBR')).'" />
							<p class="clear">'.$this->l('The number of products in the carousel (default: 20)').'</p>
						</div>
						<label>'.$this->l('Number of product visible').'</label>
						<div class="margin-form">
							<input type="text" size="5" name="itemsvisible" value="'.Tools::getValue('itemsvisible', Configuration::get('HOME_OFF_ELEC_ITEMS_VISIBLE')).'" />
							<p class="clear">'.$this->l('The number of products displayed in the visible part of the carousel').'</p>
						</div>				
						<label>'.$this->l('Number of product to scroll by').'</label>
						<div class="margin-form">
							<input type="text" size="5" name="itemsscroll" value="'.Tools::getValue('itemsscroll', Configuration::get('HOME_OFF_ELEC_ITEMS_SCROLL')).'" />
							<p class="clear">'.$this->l('The number of products to scroll by when clicking on the arrows or during the autoplay').'</p>
						</div>			
					';
		/* Get the images type */
		$imagestypes = ImageType::getImagesTypes('products');
		$output .= '
						<label>'.$this->l('Select Carousel image type').'</label>
						<div class="margin-form">		
							<select name="imagetype">
					';
		$currentimagetype = Configuration::get('HOME_OFF_ELEC_IMAGE_TYPE');
		foreach ($imagestypes AS $key => $imagetype)
		{	
			if ($imagetype['name'] == $currentimagetype)
			{
				$output .= '<option selected="selected" value="' . $imagetype['name'] . '">' . $imagetype['name'] . ' ' . $imagetype['width'] . 'x' . $imagetype['height'] . '</option>';
			}
			else
			{
				$output .= '<option value="' . $imagetype['name'] . '">' . $imagetype['name'] . ' ' . $imagetype['width'] . 'x' . $imagetype['height'] . '</option>';
			}
		}
		$output .= '
							</select>
							<p class="clear">'.$this->l('Select the image type you want to use for the Carousel').'</p>									
						</div>						
						<label>'.$this->l('Display Product name').'</label>
						<div class="margin-form">
							<input type="radio" name="displayname" id="displayname_on" value="1" '.(Tools::getValue('displayname', Configuration::get('HOME_OFF_ELEC_DISPLAY_NAME')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="displayname_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
							<input type="radio" name="displayname" id="displayname_off" value="0" '.(!Tools::getValue('displayname', Configuration::get('HOME_OFF_ELEC_DISPLAY_NAME')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="displayname_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						</div>	
						<label>'.$this->l('Display Price').'</label>
						<div class="margin-form">
							<input type="radio" name="displayprice" id="text_list_on" value="1" '.(Tools::getValue('text_list', Configuration::get('HOME_OFF_ELEC_DISPLAY_PRICE')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="text_list_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
							<input type="radio" name="displayprice" id="text_list_off" value="0" '.(!Tools::getValue('text_list', Configuration::get('HOME_OFF_ELEC_DISPLAY_PRICE')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="text_list_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						</div>						
				  ';
		/* Retrieval of the shop cats to construct the multiple select */
		/* Get Skip Cat */
		$skipcat = Configuration::get('HOME_OFF_ELEC_SKIP_CAT');
		if (!empty($skipcat))
		{
			$skipcat_array = explode(',',$skipcat);
		}
		else
		{
			$skipcat_array = array();
		}
		/* Get Skip cat select */
		$output .= '
						<label>'.$this->l('Shop categories to skip').'</label>
						<div class="margin-form">		
							<select name="skipcat[]" multiple="multiple">';
		$categories = Category::getCategories((int)($cookie->id_lang));
		ob_start();
		$this->recurseCategory($categories, $categories[0][1], 1, $skipcat_array);
		$output .= ob_get_contents();
		ob_end_clean();
		$output .= '
							</select>
							<p class="clear">'.$this->l('Select the categories you want to exclude from the carousel (Hold CTRL to select multiples)').'</p>									
						</div>						
					';
		$output .= '
						<label>'.$this->l('Choice of sort').'</label>
						<div class="margin-form">
							<select name="sort" id="sort">
								<option value="0" '.(Configuration::get('HOME_OFF_ELEC_SORT') == 0 ? 'selected' : '').'>'.$this->l('No Sort - Sort by Back Office => Catalogue -> Position').'</option>
								<option value="1" '.(Configuration::get('HOME_OFF_ELEC_SORT') == 1 ? 'selected' : '').'>'.$this->l('Random').'</option>
								<option value="2" '.(Configuration::get('HOME_OFF_ELEC_SORT') == 2 ? 'selected' : '').'>'.$this->l('Price Asc').'</option>
								<option value="3" '.(Configuration::get('HOME_OFF_ELEC_SORT') == 3 ? 'selected' : '').'>'.$this->l('Price Desc').'</option>
								<option value="4" '.(Configuration::get('HOME_OFF_ELEC_SORT') == 4 ? 'selected' : '').'>'.$this->l('Last update in first').'</option>
								<option value="5" '.(Configuration::get('HOME_OFF_ELEC_SORT') == 5 ? 'selected' : '').'>'.$this->l('Last add in first').'</option>
								<option value="6" '.(Configuration::get('HOME_OFF_ELEC_SORT') == 6 ? 'selected' : '').'>'.$this->l('Alphabetical').'</option>
							</select>
						</div>	
						<center><input type="submit" name="submitHomeCarouselNew" value="'.$this->l('Save').'" class="button" /></center>
					</fieldset>
				</form>
			  ';
		return $output;
	}
	public function getCategory()
	{
		$sql='SELECT kc.`id_category`,kcl.`name` FROM `'._DB_PREFIX_.'category` kc
				LEFT JOIN `'._DB_PREFIX_.'category_lang` kcl ON(kc.`id_category`=kcl.`id_category`)
				WHERE kcl.`id_lang`=1
				AND kc.`id_parent`=1 and kc.active = 1 and kc.`id_category` not in(41200445,41200435,41200425,41200213,208615)';
														
		return(Db::getInstance()->ExecuteS($sql));
	}
	public function getBrowseCategory($id_categories)
	{
		$sql='SELECT kc.`id_category`,kcl.`name` FROM `'._DB_PREFIX_.'category` kc
				LEFT JOIN `'._DB_PREFIX_.'category_lang` kcl ON(kc.`id_category`=kcl.`id_category`)
				WHERE kcl.`id_lang`=1
				AND kc.`id_category` IN('.$id_categories.')';
		return(Db::getInstance()->ExecuteS($sql));
	}
	public function getProducts($id_lang = 1, $product_ids)
	{
		global $cookie;
		//Modify the category ID and product IDs
		$sql = '
		SELECT cat.link_rewrite,p.*, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0 AS new,
			(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice, p.minimal_quantity
		FROM `'._DB_PREFIX_.'category_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cat ON (p.`id_category_default` = cat.`id_category`)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`
		                                           AND tr.`id_country` = 110
	                                           	   AND tr.`id_state` = 0)
	    LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
		WHERE p.`active` = 1 
		AND p.`available_for_order`=1
		AND p.`id_product` IN ('.($product_ids).')
		GROUP BY cp.`id_product`
		ORDER BY RAND()';
		$result = Db::getInstance()->ExecuteS($sql);
		
		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}
	
	function hookHome($params)
	{
		global $smarty;
		
		//$top_selling = $this->getProducts(1, '8,9,98,1,6,7,257'); // local testing
		//$top_selling = $this->getProducts(1, '218501,218502,218503,937785,212902,937790,950199,262640'); // biz testing
		
		$top_selling = $this->getProducts(1, '949310,950354,950249,212888,264394,926139,937785,212902,937790,950199,262640');
		
		/* Old page product Grid items commented for refernce. We Can remove if needed */
		/* COMPANY */		
		/*$products_safety = $this->getProducts(1, '262661,256005,262678,256016,262663,256009,262676,256020');
		$products_plumbing = $this->getProducts(1, '264400,221707,250756,253314,264377,221664,250728');
		$products_taparia = $this->getProducts(1, '264998,265031,265020,203303,265029,265017,265002,265019');
		$products_electrical_supplies = $this->getProducts(1, '217656,217652,210586,253903,253972,253905');*/

		/*Reseller*/
		/*$products_led = $this->getProducts(1, '264195,221125,261353,262657,264200,223090');
		$products_copier_paper = $this->getProducts(1, '10125,20116,201297,201296,20119');
		$products_storage_devices = $this->getProducts(1, '206500,206501,251363,251387,206499,251382,251379');
		$products_stationary = $this->getProducts(1, '204722,264834,201418,2003,201290,204717,1177,1374');

		$product_company = $this->getProducts(1, '926073,926099,262662,262673,262674,262675,262592,217812,264998,219008,926285,926292,207560,207568,266210,252858');
		$product_retail = $this->getProducts(1, '251418,251376,264526,264533,201634,201297,264215,264242,207568,207560,264844,264841,218612,265025,205309,20155,10139,18012');*/

		$category_company = $this->getBrowseCategory('4101003,4101005,41010061,4104001,4104083,41200256,4105017,41200055');
		$category_retail = $this->getBrowseCategory('42012,42007,44052,41200419,4105017,43001,4104083,43017,42001');
		/*$products_tools = $this->getProducts(1, '203301,203310,203303');*/
		//var_dump($this->getCategory());
		
		$smarty->assign(array(
			'allow_buy_when_out_of_stock' => Configuration::get('PS_ORDER_OUT_OF_STOCK', false),
			'max_quantity_to_allow_display' => Configuration::get('PS_LAST_QTIES'),

			'top_selling' 		=> $top_selling,
			
			/*'products_safety' => $products_safety,
			'products_plumbing' => $products_plumbing,
			'products_taparia' => $products_taparia,
			'products_electrical_supplies' => $products_electrical_supplies,

			'products_led' => $products_led,
			'products_copier_paper' => $products_copier_paper,
			'products_storage_devices' => $products_storage_devices,
			'products_stationary' => $products_stationary,

			'product_company' => $product_company,
			'product_retail' => $product_retail,
			'category_company' => $category_company,
			'category_retail' => $category_retail,*/


			'category_details' => $this->getCategory(),
			'search_query' => (string)Tools::getValue('search_query'),
			'currency' => new Currency((int)($params['cart']->id_currency)),
			'lang' => Language::getIsoById((int)($params['cookie']->id_lang)),
			//'productNumber' => sizeof($products),
			'displayname' =>	Configuration::get('HOME_OFF_ELEC_DISPLAY_NAME'),
			'displayprice' =>	Configuration::get('HOME_OFF_ELEC_DISPLAY_PRICE'),
			'autoplay' => Configuration::get('HOME_OFF_ELEC_AUTOPLAY'),
			'autoplayduration' => Configuration::get('HOME_OFF_ELEC_AUTOPLAY_DURATION'),
			'itemsvisible' => Configuration::get('HOME_OFF_ELEC_ITEMS_VISIBLE'),
			'itemsscroll' => Configuration::get('HOME_OFF_ELEC_ITEMS_SCROLL'),
			'imagetype' => 'home',
			'static_token' => Tools::getToken(false)
		));
		return $this->display(__FILE__, 'homeOfficeElectronics.tpl');
	}
	public function hookShop($params)
	{
		global $smarty;		
		$top_selling = $this->getProducts(1, '949310,950354,950249,212888,264394,926139,937785,212902,937790,950199,262640');		
		$category_company = $this->getBrowseCategory('4101003,4101005,41010061,4104001,4104083,41200256,4105017,41200055');
		$category_retail = $this->getBrowseCategory('42012,42007,44052,41200419,4105017,43001,4104083,43017,42001');
		
		$smarty->assign(array(
			'allow_buy_when_out_of_stock' => Configuration::get('PS_ORDER_OUT_OF_STOCK', false),
			'max_quantity_to_allow_display' => Configuration::get('PS_LAST_QTIES'),
			'top_selling' 		=> $top_selling,
			'category_details' => $this->getCategory(),
			'search_query' => (string)Tools::getValue('search_query'),
			'currency' => new Currency((int)($params['cart']->id_currency)),
			'lang' => Language::getIsoById((int)($params['cookie']->id_lang)),
			//'productNumber' => sizeof($products),
			'displayname' =>	Configuration::get('HOME_OFF_ELEC_DISPLAY_NAME'),
			'displayprice' =>	Configuration::get('HOME_OFF_ELEC_DISPLAY_PRICE'),
			'autoplay' => Configuration::get('HOME_OFF_ELEC_AUTOPLAY'),
			'autoplayduration' => Configuration::get('HOME_OFF_ELEC_AUTOPLAY_DURATION'),
			'itemsvisible' => Configuration::get('HOME_OFF_ELEC_ITEMS_VISIBLE'),
			'itemsscroll' => Configuration::get('HOME_OFF_ELEC_ITEMS_SCROLL'),
			'imagetype' => 'home',
			'static_token' => Tools::getToken(false)
		));
		return $this->display(__FILE__, 'homeOfficeElectronics.tpl');
	}
	public function hookHeader($params)
	{
		return $this->display(__FILE__, 'homeOfficeElectronics-header.tpl');	
	}
}
?>
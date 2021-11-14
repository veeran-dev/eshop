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
		if (!Configuration::updateValue('HOME_OFF_ELEC_NBR', 20) OR !parent::install() OR !$this->registerHook('home') OR !$this->registerHook('header'))
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
	public function getProducts($id_lang = 1, $product_ids)
	{
		global $cookie;
		
		//Modify the category ID and product IDs
		$sql = '
		SELECT p.*, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0 AS new,
			(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice, p.minimal_quantity
		FROM `'._DB_PREFIX_.'category_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`
		                                           AND tr.`id_country` = '.(int)Country::getDefaultCountryId().'
	                                           	   AND tr.`id_state` = 0)
	    LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
		WHERE p.`active` = 1 
		AND p.`id_product` IN ('.($product_ids).')
		GROUP BY cp.`id_product`
		ORDER BY RAND()
		LIMIT 4';
		
		$result = Db::getInstance()->ExecuteS($sql);
		
		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}
	function hookHome($params)
	{
		global $smarty;
		
		$products_paper = $this->getProducts(1, '20119,203626,201296');
		$products_fur = $this->getProducts(1, '202488,16024');
		$products_net = $this->getProducts(1, '201799,201826,249');
		$products_por = $this->getProducts(1, '202380,201098,201096');
		$products_tools = $this->getProducts(1, '203301,203310,203303');
					
		$smarty->assign(array(
			'allow_buy_when_out_of_stock' => Configuration::get('PS_ORDER_OUT_OF_STOCK', false),
			'max_quantity_to_allow_display' => Configuration::get('PS_LAST_QTIES'),
			'products' => $products,
			'products_paper' => $products_paper,
			'products_fur' => $products_fur,
			'products_net' => $products_net,
			'products_por' => $products_por,
			'products_tools' => $products_tools,
			'currency' => new Currency((int)($params['cart']->id_currency)),
			'lang' => Language::getIsoById((int)($params['cookie']->id_lang)),
			'productNumber' => sizeof($products),
			'displayname' =>	Configuration::get('HOME_OFF_ELEC_DISPLAY_NAME'),
			'displayprice' =>	Configuration::get('HOME_OFF_ELEC_DISPLAY_PRICE'),
			'autoplay' => Configuration::get('HOME_OFF_ELEC_AUTOPLAY'),
			'autoplayduration' => Configuration::get('HOME_OFF_ELEC_AUTOPLAY_DURATION'),
			'itemsvisible' => Configuration::get('HOME_OFF_ELEC_ITEMS_VISIBLE'),
			'itemsscroll' => Configuration::get('HOME_OFF_ELEC_ITEMS_SCROLL'),
			'imagetype' => 'home'
		));
		return $this->display(__FILE__, 'homeOfficeElectronics.tpl');
	}
	public function hookHeader($params)
	{
		return $this->display(__FILE__, 'homeOfficeElectronics-header.tpl');	
	}
}
?>
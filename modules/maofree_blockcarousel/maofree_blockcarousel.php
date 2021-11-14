<?php

/*Copyright 2011 maofree  email: msecco@gmx.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 3, as 
published by the Free Software Foundation.

This file can't be removed. This module can't be sold.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

*/

if (!defined('_PS_VERSION_'))
	exit;

class Maofree_BlockCarousel extends Module
{
    public function __construct()
    {
        $this->name = 'maofree_blockcarousel';
        $this->tab = 'others';
        $this->version = '2.0';
		  $this->author = 'maofree';
		  $this->need_instance = 0;
        
        parent::__construct();

        $this->displayName = $this->l('Carousel Block');
        $this->description = $this->l('Adds a block with a corousel of products');
    }

	public function install()
	{
		if (
		   !parent::install() ||
		   !$this->registerHook('rightColumn') ||
		   !$this->registerHook('header') ||
		   !Configuration::updateValue('BLOCKCAROUSEL_TIMEEFFECT', 2000) || 
		   !Configuration::updateValue('BLOCKCAROUSEL_IMAGETYPE', 'medium') || 
		   !Configuration::updateValue('BLOCKCAROUSEL_SELECTCAT', 1) ||
		   !Configuration::updateValue('BLOCKCAROUSEL_TIMETRANSITION', 4000) || 
		   !Configuration::updateValue('BLOCKCAROUSEL_PRICE', 1) ||
		   !Configuration::updateValue('BLOCKCAROUSEL_ITEMSVIS', 1) ||
		   !Configuration::updateValue('BLOCKCAROUSEL_TITLE', 1) ||
		   !Configuration::updateValue('BLOCKCAROUSEL_ADDSCRIPTS', 1) ||
		   !Configuration::updateValue('BLOCKCAROUSEL_EFFECT', 'random') || 
		   !Configuration::updateValue('BLOCKCAROUSEL_NUMBER', 30) ||
		   !Configuration::updateValue('BLOCKCAROUSEL_DATABASENUMBER', 1000) ||
			!Configuration::updateValue('BLOCKCAROUSEL_MOVEMENT', 'horizontal') ||
			!Configuration::updateValue('BLOCKCAROUSEL_HOOK_POSITION', 'rightColumn') ||
		   !Configuration::updateValue('BLOCKCAROUSEL_MOUSEWHEEL', 1)
		)
         return false;		
		return true;
	}

   public function uninstall()
   {
      if (
         !Configuration::deleteByName('BLOCKCAROUSEL_TIMEEFFECT') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_TIMETRANSITION') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_EFFECT') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_NUMBER') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_DATABASENUMBER') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_TITLE') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_ADDSCRIPTS') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_SELECTCAT') ||            
         !Configuration::deleteByName('BLOCKCAROUSEL_IMAGETYPE') ||            
         !Configuration::deleteByName('BLOCKCAROUSEL_MOUSEWHEEL') ||            
         !Configuration::deleteByName('BLOCKCAROUSEL_PRICE') ||
         !Configuration::deleteByName('BLOCKCAROUSEL_ITEMSVIS') ||         
         !Configuration::deleteByName('BLOCKCAROUSEL_MOVEMENT') ||         
         !Configuration::deleteByName('BLOCKCAROUSEL_HOOK_POSITION') ||
         !parent::uninstall()
      )
         return false;
      return true;
   }   

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		$errors = array();
		$hookidleftcolumn = (int)(Hook::get('leftColumn'));
		$hookidrightcolumn = (int)(Hook::get('rightColumn'));				
		if (Tools::isSubmit('submitBlockCarousel'))
		{
			$movement = Tools::getValue('movement');
			$itemsvisible = (int)(Tools::getValue('itemsvisible'));
			$hookposition = Tools::getValue('hookposition');						
			$timeeffect = (int)(Tools::getValue('timeeffect'));
			$timetransition = (int)(Tools::getValue('timetransition'));
			$slidenumber = (int)(Tools::getValue('slidenumber'));
			$databasenumber = (int)(Tools::getValue('databasenumber'));
			$effect = Tools::getValue('effect');
			$title = (int)(Tools::getValue('title'));
			$addscripts = (int)(Tools::getValue('addscripts'));
			$selectcat = Tools::getValue('selectcat');
			$mousewheel = (int)(Tools::getValue('mousewheel'));
			$imagetype = Tools::getValue('imagetype');			
			$price = (int)(Tools::getValue('price'));
			if (!$timeeffect OR $timeeffect <= 0 OR !Validate::isInt($timeeffect))
				$errors[] = $this->l('Invalid number in = Time of effect');
			else		
				Configuration::updateValue('BLOCKCAROUSEL_TIMEEFFECT', $timeeffect);
			if (!$timetransition OR $timetransition <= 0 OR !Validate::isInt($timetransition))
				$errors[] = $this->l('Invalid number in = Time of transition');
			else
				Configuration::updateValue('BLOCKCAROUSEL_TIMETRANSITION', $timetransition);
			if (!$slidenumber OR $slidenumber <= 0 OR !Validate::isInt($slidenumber))
				$errors[] = $this->l('Invalid number in = Number of products');
			else		
				Configuration::updateValue('BLOCKCAROUSEL_NUMBER', $slidenumber);
			if (!$databasenumber OR $databasenumber <= 0 OR !Validate::isInt($databasenumber))
				$errors[] = $this->l('Invalid number in = Number of products from database');
			else		
				Configuration::updateValue('BLOCKCAROUSEL_DATABASENUMBER', $databasenumber);
			if ($selectcat)
				Configuration::updateValue('BLOCKCAROUSEL_SELECTCAT', implode(',',$selectcat));
			Configuration::updateValue('BLOCKCAROUSEL_EFFECT', $effect);
			Configuration::updateValue('BLOCKCAROUSEL_TITLE', $title);
			Configuration::updateValue('BLOCKCAROUSEL_ADDSCRIPTS', $addscripts);
			Configuration::updateValue('BLOCKCAROUSEL_IMAGETYPE', $imagetype);						
			Configuration::updateValue('BLOCKCAROUSEL_MOUSEWHEEL', $mousewheel);
			Configuration::updateValue('BLOCKCAROUSEL_MOVEMENT', $movement);
			Configuration::updateValue('BLOCKCAROUSEL_ITEMSVIS', $itemsvisible);						
			Configuration::updateValue('BLOCKCAROUSEL_HOOK_POSITION', $hookposition);
			Configuration::updateValue('BLOCKCAROUSEL_PRICE', $price);
			if(!$this->isRegisteredInHook($hookposition))
			{
				if($hookposition == 'leftColumn')
					$this->unregisterHook($hookidrightcolumn);
				else
					$this->unregisterHook($hookidleftcolumn);				    	 
				$this->registerHook($hookposition);
			}			
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}	
	
	public function displayForm()
	{
		global $cookie,$currentIndex;
				
		$output = '
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" alt="maofree\'s module" title="maofree\'s module" />maofree</legend>
				<a href="http://www.maofree-developer.com" target="_blank"><img src="'._MODULE_DIR_.$this->name.'/img/donate.png" alt="maofree\'s website" title="'.$this->l('Do you need some help? (click here)').'" /></a>
				<div style="float:right;width:70%;">
					<h3 style="color:lightCoral;">'.$this->l('If you like my job, you could support me with a donation').'.</h3>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="MEF3Z7XDHQZF8">
						<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Paypal" style="margin-top:20px;">
						<img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>
			</fieldset>			
			
			<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
				<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="maofree\'s module" title="maofree\'s module" />'.$this->l('Settings').'</legend>
				   <label>'.$this->l('Time of effect').':</label>
					<div class="margin-form">
						<input type="text" size="5" maxlength="5" name="timeeffect" value="'.Tools::getValue('timeeffect', Configuration::get('BLOCKCAROUSEL_TIMEEFFECT')).'" />
						<p class="clear">'.$this->l('The time of each effect in ms (default: 2000)').'</p>
					</div>		
					<label>'.$this->l('Time of transition').':</label>
					<div class="margin-form">
						<input type="text" size="5" maxlength="5" name="timetransition" value="'.Tools::getValue('timetransition', Configuration::get('BLOCKCAROUSEL_TIMETRANSITION')).'" />
						<p class="clear">'.$this->l('The time between each slide in ms (default: 4000)').'</p>
					</div>
					<label>'.$this->l('Number of products').':</label>
					<div class="margin-form">
						<input type="text" size="2" maxlength="2" name="slidenumber" value="'.Tools::getValue('slidenumber', Configuration::get('BLOCKCAROUSEL_NUMBER')).'" />
						<p class="clear">'.$this->l('Choose how many random products you want to display into the carousel').'.<br />'.$this->l('Too many elements make slow the page loading and they are not handled by Carousel.').'<br />'.$this->l('I suggest you no more than 50. Do not worry at each page loading there will be different products (default 30)').'</p>
					</div>
					<label>'.$this->l('Number of products from database').':</label>
					<div class="margin-form">
						<input type="text" size="6" maxlength="6" name="databasenumber" value="'.Tools::getValue('databasenumber', Configuration::get('BLOCKCAROUSEL_DATABASENUMBER')).'" />
						<p class="clear">'.$this->l('Choose how many products you want to extract from database').'.<br />'.$this->l('Too many elements make slow the page loading.').'<br />'.$this->l('(default 1000)').'</p>
					</div>
					<label>'.$this->l('Product price').':</label>
					<div class="margin-form">
						<input type="radio" name="price" id="price_on" value="1" '.(Tools::getValue('price', Configuration::get('BLOCKCAROUSEL_PRICE')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="price_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="price" id="price_off" value="0" '.(!Tools::getValue('price', Configuration::get('BLOCKCAROUSEL_PRICE')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="price_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('Display product price').'</p>
					</div>
					<label>'.$this->l('Mouse wheel').':</label>
					<div class="margin-form">
						<input type="radio" name="mousewheel" id="mousewheel_on" value="1" '.(Tools::getValue('mousewheel', Configuration::get('BLOCKCAROUSEL_MOUSEWHEEL')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="mousewheel_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="mousewheel" id="mousewheel_off" value="0" '.(!Tools::getValue('mousewheel', Configuration::get('BLOCKCAROUSEL_MOUSEWHEEL')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="mousewheel_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('Mouse wheel to scroll from one item to next').'</p>
					</div>
					<label>'.$this->l('Product name').':</label>
					<div class="margin-form">
						<input type="radio" name="title" id="title_on" value="1" '.(Tools::getValue('title', Configuration::get('BLOCKCAROUSEL_TITLE')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="title_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="title" id="title_off" value="0" '.(!Tools::getValue('title', Configuration::get('BLOCKCAROUSEL_TITLE')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="title_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('Display product name').'</p>
					</div>
					<label>'.$this->l('Add two javascritps').':</label>
					<div class="margin-form">
						<input type="radio" name="addscripts" id="addscripts_on" value="1" '.(Tools::getValue('addscripts', Configuration::get('BLOCKCAROUSEL_ADDSCRIPTS')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="addscripts_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="addscripts" id="addscripts_off" value="0" '.(!Tools::getValue('addscripts', Configuration::get('BLOCKCAROUSEL_ADDSCRIPTS')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="addscripts_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('jcarousellite and mousewheel script will be added into the header (if you use more than one of my carousels, you can remove javascript duplications from header, disabling this option)').'</p>
					</div>
					<label>'.$this->l('Visible Items').':</label>
					<div class="margin-form">
						<select name="itemsvisible">
					';
						
					for ($i = 1; $i <= 10; $i++)
						$output .= '<option value="' . $i . '" '.(Tools::getValue('itemsvisible', Configuration::get('BLOCKCAROUSEL_ITEMSVIS')) ==  $i ? 'selected="selected"' : '').'>'. $i .'</option>';
						
					$output .= '							
						</select>
						'.$this->l('More articles can be viewed only with vertical scrolling (default: 1)').'
					</div><br />					
					<label>'.$this->l('Carousel movement').':</label>
					<div class="margin-form">
						<select name="movement">
							<option value="horizontal" '.(Tools::getValue('movement', Configuration::get('BLOCKCAROUSEL_MOVEMENT')) == 'horizontal' ? 'selected="selected"' : '').'>'.$this->l('horizontal').'</option>
							<option value="vertical" '.(Tools::getValue('movement', Configuration::get('BLOCKCAROUSEL_MOVEMENT')) == 'vertical' ? 'selected="selected"' : '').'>'.$this->l('vertical').'</option>
						</select>
						'.$this->l('(default: horizontal)').'
					</div><br />										
					<label>'.$this->l('Hook Position').':</label>
					<div class="margin-form">
						<select name="hookposition">
							<option value="leftColumn" '.(Tools::getValue('hookposition', Configuration::get('BLOCKCAROUSEL_HOOK_POSITION')) == 'leftColumn' ? 'selected="selected"' : '').'>leftColumn</option>
							<option value="rightColumn" '.(Tools::getValue('hookposition', Configuration::get('BLOCKCAROUSEL_HOOK_POSITION')) == 'rightColumn' ? 'selected="selected"' : '').'>rightColumn</option>
						</select>
						'.$this->l('(default: rightColumn)').'
					</div><br />				
					';
					
					/* Get the images type */
					$imagestypes = ImageType::getImagesTypes('products');
					$currentimagetype = Tools::getValue('imagetype', Configuration::get('BLOCKCAROUSEL_IMAGETYPE'));				
					
					$output .= '
					<label>'.$this->l('Select product image type').':</label>
					<div class="margin-form">		
						<select name="imagetype">
					';
										
					foreach ($imagestypes AS $imagetype)
						$output .= '<option ' . ($imagetype['name'] == $currentimagetype ? 'selected="selected"' : '') . ' value="' . $imagetype['name'] . '">' . $imagetype['name'] . ' ' . $imagetype['width'] . 'x' . $imagetype['height'] . '</option>';
					
					$output .= '
						</select>
						<p class="clear">'.$this->l('Select the image type you want to use in the carousel (I have configurated this module only for medium and home image type)').'</p>
					</div>													
					<label>'.$this->l('Choose the effect').'</label>
					<div class="margin-form">
						<select name="effect">
					';
						
			      $effectsc = array('\'easeInQuad\'', '\'easeOutQuad\'', '\'easeInOutQuad\'', '\'easeInCubic\'', '\'easeOutCubic\'', '\'easeInOutCubic\'', '\'easeInQuart\'', '\'easeOutQuart\'', '\'easeInOutQuart\'', '\'easeInQuint\'','\'easeOutQuint\'', '\'easeInOutQuint\'', '\'easeInSine\'', '\'easeOutSine\'', '\'easeInOutSine\'','\'easeInExpo\'', '\'easeOutExpo\'', '\'easeInOutExpo\'', '\'easeInCirc\'', '\'easeOutCirc\'', '\'easeInOutCirc\'', '\'easeInElastic\'', '\'easeOutElastic\'', '\'easeInOutElastic\'', '\'easeInBack\'','\'easeOutBack\'', '\'easeInOutBack\'', '\'easeInBounce\'', '\'easeOutBounce\'', '\'easeInOutBounce\'', 'random');					
			      $effects = array('easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint','easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine','easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack','easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce', 'random');	
					for ($i = 0; $i <= 30; $i++)
						$output .= '<option value="' . $effectsc[$i] . '" '.(Tools::getValue('effect', Configuration::get('BLOCKCAROUSEL_EFFECT')) ==  $effectsc[$i] ? 'selected="selected"' : '').'>'. $effects[$i] .'</option>';
	
					$output .= '																																																																									
						</select>
						<p class="clear">'.$this->l('In random mode, the slideshow, for each new page, will have a different effect (default random)').'</p>
					</div>
					';				

					$selectcat = Configuration::get('BLOCKCAROUSEL_SELECTCAT');
					$selectcat_array = array();
					if ($selectcat)
						$selectcat_array = explode(',',$selectcat);
					
					$output .= '
					<label>'.$this->l('Categories to select').':</label>
					<div class="margin-form">		
						<select name="selectcat[]" multiple="multiple">';
					$categories = Category::getCategories((int)($cookie->id_lang));
					ob_start();
					$this->recurseCategory($categories, $categories[0][1], 1, $selectcat_array);
					$output .= ob_get_contents();
					ob_end_clean();
					$output .= '
						</select>
						<p class="clear">'.$this->l('Select the categories you want to include into the carousel (Hold CTRL to select multiples)').'</p>									
					</div>						
					<div class="margin-form clear"><input type="submit" name="submitBlockCarousel" value="'.$this->l('Save').'" class="button" /></div>
				</fieldset>
			</form>
			<br />
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" alt="maofree\'s module" title="maofree\'s module" />'.$this->l('Instructions:').'</legend>
				<h5>'.$this->l('Home category').':</h5>
				<p>'.$this->l('Don\'t select this category if you don\'t want some duplicate products into the carousel').'.</p>          
			</fieldset>';			
			
		return $output;
	}	

	private function recurseCategory($categories, $current, $id_category = 1, $selectids_array)
	{
		echo '<option value="' . $id_category . '"' . (in_array($id_category,$selectids_array) ? ' selected="selected"' : '') . '>' .	str_repeat('&nbsp;', $current['infos']['level_depth'] * 5) . stripslashes($current['infos']['name']) . '</option>';
		if (isset($categories[$id_category]))
			foreach (array_keys($categories[$id_category]) AS $key)
				$this->recurseCategory($categories, $categories[$id_category][$key], $key, $selectids_array);
	}

	/**
	  * Return current category products
	  *
	  * @param integer $id_lang Language ID
	  * @param integer $p Page number
	  * @param integer $n Number of products per page
	  * @param boolean $getTotal return the number of results instead of the results themself
	  * @param boolean $active return only active products
	  * @param boolean $random active a random filter for returned products
	  * @param int $randomNumberProducts number of products to return if random is activated
	  * @return mixed Products or number of products
	  */
	private function getProducts($idcat, $id_lang, $p, $n, $orderBy = NULL, $orderWay = NULL, $getTotal = false, $active = true, $random = false, $randomNumberProducts = 1)
	{
		global $cookie;

		if (empty($idcat))
			return false;
		
		if ($p < 1) $p = 1;
		if ($n < 1) $n = 10;

		if (empty($orderBy))
			$orderBy = 'position';
		else
			/* Fix for all modules which are now using lowercase values for 'orderBy' parameter */
			$orderBy = strtolower($orderBy);
			
		if (empty($orderWay))
			$orderWay = 'ASC';
		if ($orderBy == 'id_product' OR	$orderBy == 'date_add')
			$orderByPrefix = 'p';
		elseif ($orderBy == 'name')
			$orderByPrefix = 'pl';
		elseif ($orderBy == 'manufacturer')
		{
			$orderByPrefix = 'm';
			$orderBy = 'name';
		}
		elseif ($orderBy == 'position')
			$orderByPrefix = 'cp';

		if ($orderBy == 'price')
			$orderBy = 'orderprice';

		if (!Validate::isBool($active) OR !Validate::isOrderBy($orderBy) OR !Validate::isOrderWay($orderWay))
			die (Tools::displayError());

		$id_supplier = (int)(Tools::getValue('id_supplier'));

		/* Return only the number of products */
		if ($getTotal)
		{
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT COUNT(cp.`id_product`) AS total
			FROM `'._DB_PREFIX_.'product` p
			LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON p.`id_product` = cp.`id_product`
			WHERE cp.`id_category` = '.(int)($this->id).($active ? ' AND p.`active` = 1' : '').'
			'.($id_supplier ? 'AND p.id_supplier = '.(int)($id_supplier) : ''));
			return isset($result) ? $result['total'] : 0;
		}

		$sql = '
		SELECT p.*, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0 AS new,
			(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice
		FROM `'._DB_PREFIX_.'category_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group` AND tr.`id_country` = '.(int)Country::getDefaultCountryId().' AND tr.`id_state` = 0)
	   LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
		WHERE cp.`id_category` = '.(int)$idcat.($active ? ' AND p.`active` = 1' : '').'
		'.($id_supplier ? 'AND p.id_supplier = '.(int)$id_supplier : '');

		if ($random === true)
		{
			$sql .= ' ORDER BY RAND()';
			$sql .= ' LIMIT 0, '.(int)($randomNumberProducts);
		}
		else
		{
			$sql .= ' ORDER BY '.(isset($orderByPrefix) ? $orderByPrefix.'.' : '').'`'.pSQL($orderBy).'` '.pSQL($orderWay).'
			LIMIT '.(((int)($p) - 1) * (int)($n)).','.(int)($n);
		}

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

		if ($orderBy == 'orderprice')
			Tools::orderbyPrice($result, $orderWay);

		if (!$result)
			return false;

		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}
	
	public function hookRightColumn($params)
   {
		global $smarty;

		$selectcat_array = array();
      $catproducts = array();
      $carouselproducts = array();
		$number = (int)(Configuration::get('BLOCKCAROUSEL_NUMBER'));
		$databasenumber = (int)(Configuration::get('BLOCKCAROUSEL_DATABASENUMBER'));
		$selectcat = Configuration::get('BLOCKCAROUSEL_SELECTCAT');
		
		if ($selectcat)
			$selectcat_array = explode(',',$selectcat);
			
		foreach ($selectcat_array AS $value) {
			$catproducts = $this->getProducts($value,(int)($params['cookie']->id_lang), 1, $databasenumber);
			if (is_array($catproducts))
				$carouselproducts = array_merge($carouselproducts, $catproducts);
		}
		
		if ($carouselproducts) {
			shuffle($carouselproducts);
			if (sizeof($carouselproducts) > $number)
			   $carouselproducts = array_splice($carouselproducts, 0, $number);
		}
		   		  	   
	   $smarty->assign(array(
         'blockcarousel_title' => Configuration::get('BLOCKCAROUSEL_TITLE'),
         'blockcarousel_price' => Configuration::get('BLOCKCAROUSEL_PRICE'),
		   'blockcarousel_imagetype' => Configuration::get('BLOCKCAROUSEL_IMAGETYPE'),
		   'blockcarousel_imagesize' => Image::getSize(Configuration::get('BLOCKCAROUSEL_IMAGETYPE')),
         'blockcarousel_products' => $carouselproducts
      ));
      
	   return $this->display(__FILE__, 'maofree_blockcarousel.tpl');
   }
   
   public function hookHeader($params)
   {
   	global $smarty;
   	
   	$itemsvisible = '1';
   	$movement = Configuration::get('BLOCKCAROUSEL_MOVEMENT');
   	
   	if ($movement == 'vertical')
   	{
   	   $vertical = 'true';
   	   $itemsvisible = (int)(Configuration::get('BLOCKCAROUSEL_ITEMSVIS'));
   	}   
   	else
   	   $vertical = 'false';
       
      $effects = array('\'easeInQuad\'', '\'easeOutQuad\'', '\'easeInOutQuad\'', '\'easeInCubic\'', '\'easeOutCubic\'', '\'easeInOutCubic\'', '\'easeInQuart\'', '\'easeOutQuart\'', '\'easeInOutQuart\'', '\'easeInQuint\'','\'easeOutQuint\'', '\'easeInOutQuint\'', '\'easeInSine\'', '\'easeOutSine\'', '\'easeInOutSine\'','\'easeInExpo\'', '\'easeOutExpo\'', '\'easeInOutExpo\'', '\'easeInCirc\'', '\'easeOutCirc\'', '\'easeInOutCirc\'', '\'easeInElastic\'', '\'easeOutElastic\'', '\'easeInOutElastic\'', '\'easeInBack\'','\'easeOutBack\'', '\'easeInOutBack\'', '\'easeInBounce\'', '\'easeOutBounce\'', '\'easeInOutBounce\'');   	
		$effect = Configuration::get('BLOCKCAROUSEL_EFFECT');
		if	($effect == 'random')
		{
		   shuffle($effects);
		   $effect = $effects[0];
		}
		   	
	   $smarty->assign(array(
         'blockcarousel_timeeffect' => Configuration::get('BLOCKCAROUSEL_TIMEEFFECT'),
         'blockcarousel_timetransition' => Configuration::get('BLOCKCAROUSEL_TIMETRANSITION'),
         'blockcarousel_effect' => $effect,
         'blockcarousel_itemsvis' => $itemsvisible,         
         'blockcarousel_vertical' => $vertical,
         'blockcarousel_mousewheel' => Configuration::get('BLOCKCAROUSEL_MOUSEWHEEL')
      ));

		Tools::addCSS(($this->_path).'css/blockcarousel.css', 'all');
		if (Configuration::get('BLOCKCAROUSEL_ADDSCRIPTS'))
		{
			Tools::addJS(($this->_path).'js/jcarousellite_1.0.1.min.js');
			if (Configuration::get('BLOCKCAROUSEL_MOUSEWHEEL'))
				Tools::addJS(($this->_path).'js/jquery.mousewheel.min.js');
		}
         	
		return $this->display(__FILE__, 'header.tpl');
   }   

   public function hookLeftColumn($params)
   {
      return $this->hookRightColumn($params);
   }
}
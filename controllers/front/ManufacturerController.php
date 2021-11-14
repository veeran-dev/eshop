<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class ManufacturerControllerCore extends FrontController
{
    public $php_self = 'manufacturer';

    /** @var Manufacturer */
    protected $manufacturer;

    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS(_THEME_CSS_DIR_.'manufacturer.css');
    }

    public function canonicalRedirection($canonicalURL = '')
    {
        if (Tools::getValue('live_edit')) {
            return;
        }
        if (Validate::isLoadedObject($this->manufacturer)) {
            parent::canonicalRedirection($this->context->link->getManufacturerLink($this->manufacturer));
        }
    }

    /**
     * Initialize manufaturer controller
     * @see FrontController::init()
     */
    public function init()
    {
        parent::init();

        if ($id_manufacturer = Tools::getValue('id_manufacturer')) {
            $this->manufacturer = new Manufacturer((int)$id_manufacturer, $this->context->language->id);
            if (!Validate::isLoadedObject($this->manufacturer) || !$this->manufacturer->active || !$this->manufacturer->isAssociatedToShop()) {
                header('HTTP/1.1 404 Not Found');
                header('Status: 404 Not Found');
                $this->errors[] = Tools::displayError('The brand does not exist.');
            } else {
                $this->canonicalRedirection();
            }
        }
    }

    /**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();
		
		if(Tools::getValue('b')){ $this->b = Tools::getValue('b'); } else {$this->b = 'all'; }
		if(Tools::getValue('c')){ $this->c = Tools::getValue('c'); } else {$this->c = 'all'; }
		
		$data_total 	= Manufacturer::getManufacturers(false, $this->context->language->id, true, false, false, false);
		//$category_list 	= $this->getCategoriesByParent(1, 1);
		
		$this->context->smarty->assign(array(
			'b' => $this->b,
			'c' => $this->c,	
			'manufacturers_total' 	=> $data_total
			
		));
		
        if (Validate::isLoadedObject($this->manufacturer) && $this->manufacturer->active && $this->manufacturer->isAssociatedToShop()) {
            $this->productSort();
            $this->assignOne();
            $this->setTemplate(_PS_THEME_DIR_.'manufacturer.tpl');
        } else {
            $this->assignAll();
            $this->setTemplate(_PS_THEME_DIR_.'manufacturer-list.tpl');
        }
    }

    /**
     * Assign template vars if displaying one manufacturer
     */
    protected function assignOne()
    {
		/*if ($this->c == 'all'){
			Tools::redirect('/'.$php_self);
		}*/
		
        $this->manufacturer->description = Tools::nl2br(trim($this->manufacturer->description));
        $nbProducts = $this->manufacturer->getProductsByCategory($this->manufacturer->id, null, null, null, $this->orderBy, $this->orderWay, true, true, true, NULL, $this->c);
        $this->pagination((int)$nbProducts);
		
		$totalProducts = $this->manufacturer->getProducts($this->manufacturer->id, null, null, null, $this->orderBy, $this->orderWay, true, true, true, NULL);

        $products = $this->manufacturer->getProductsByCategory($this->manufacturer->id, $this->context->language->id, (int)$this->p, (int)$this->n, $this->orderBy, $this->orderWay, false, true, 2, NULL, $this->c);
			
		$this->manufacturer->image = (!file_exists(_PS_MANU_IMG_DIR_.$this->manufacturer->id.'-'.ImageType::getFormatedName('medium').'.jpg')) ? $this->context->language->iso_code.'-default' : $this->manufacturer->id;
		
        $this->addColorsToProductList($products);
		
		$category_list 	= $this->getCategoriesByManufacturer($this->manufacturer->id);
		
        $this->context->smarty->assign(array(
            'nb_products' 			=> $nbProducts,
            'products' 				=> $products,
            'path' 					=> ($this->manufacturer->active ? Tools::safeOutput($this->manufacturer->name) : ''),
            'manufacturer' 			=> $this->manufacturer,
			'category' 				=> $category_list,
			'totalProducts'			=> $totalProducts,
            'comparator_max_item' 	=> Configuration::get('PS_COMPARATOR_MAX_ITEM'),
            'body_classes' 			=> array($this->php_self.'-'.$this->manufacturer->id, $this->php_self.'-'.$this->manufacturer->link_rewrite)
        ));
		$products_count = count($products);
    }

    /**
     * Assign template vars if displaying the manufacturer list
     */
    protected function assignAll()
    {
        if (Configuration::get('PS_DISPLAY_SUPPLIERS')) {
            $data_total = Manufacturer::getManufacturers(false, $this->context->language->id, true, false, false, false);
            $nbProducts = count($data_total);
            $this->n = abs((int)Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE')));
            $this->p = abs((int)Tools::getValue('p', 1));
            $data = Manufacturer::getManufacturers(true, $this->context->language->id, true, $this->p, $this->n, false);
			
			
			foreach ($data as $key=> $manufact){
				$data[$key]['product_image'] 		= (file_exists(_PS_MANU_IMG_DIR_.'product/'.$manufact['id_manufacturer'].'.jpg')) ? 1 : NULL;
				$data[$key]['description'] 			= strip_tags($data[$key]['description']);
				$data[$key]['short_description'] 	= strip_tags($data[$key]['short_description']);
			}
			
            $this->pagination($nbProducts);

            foreach ($data as &$item) {
                $item['image'] = (!file_exists(_PS_MANU_IMG_DIR_.$item['id_manufacturer'].'-'.ImageType::getFormatedName('medium').'.jpg')) ? $this->context->language->iso_code.'-default' : $item['id_manufacturer'];
            }
			
			
			
			//echo "<pre>";
            $this->context->smarty->assign(array(
                'pages_nb' 				=> ceil($nbProducts / (int)$this->n),
                'nbManufacturers' 		=> $nbProducts,
                'mediumSize' 			=> Image::getSize(ImageType::getFormatedName('medium')),
				'manufacturers' 		=> $data,
                'add_prod_display' 		=> Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'),
				'page_no' 				=> $this->p,
				'show_no'				=> $this->n
            ));
			//echo "</pre>";
	
        } else {
            $this->context->smarty->assign('nbManufacturers', 0);
        }
    }
	
	public function getCategoriesByParent($id_lang = 1, $parent = NULL)
	{
		$query 	= 	'SELECT c.`id_category`,cl.`name` 
					FROM `'._DB_PREFIX_.'category` c
					LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category` 
					WHERE cl.`id_lang` = '.$id_lang.'
					AND c.`id_parent` = '.$parent.'
					ORDER BY cl.`name` ASC';
															  
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
															  
	}
	
	public function getCategoriesByManufacturer($id_manufacturer)
	{
		$query 	= 	'SELECT DISTINCT c.`id_category`,cl.`name` 
					FROM `'._DB_PREFIX_.'category` c
					LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category` 
					LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_category_default` = cl.`id_category` 
					WHERE cl.`id_lang` = 1
					AND p.`id_manufacturer` = '.$id_manufacturer.'
					AND c.`active` = 1 AND p.`active` = 1
					ORDER BY cl.`name` ASC';
															  
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
															  
	}
	
	public function getProductsByCategoryBrandFilter()
	{
		$query 	= 	"SELECT a.`id_product`, b.`name` AS `name`, `reference`, a.`price` AS `price`, sa.`active` AS `active`, cp.`position` AS `position` , shop.`name` AS `shopname`, a.`id_shop_default`, image_shop.`id_image` AS `id_image`, cl.`name` AS `name_category`, sa.`price`, 0 AS `price_final`, a.`is_virtual`, pd.`nb_downloadable`, sav.`quantity` AS `sav_quantity`, sa.`active`, IF(sav.`quantity`<=0, 1, 0) AS `badge_danger` , cp.`position` 
		FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) 
		LEFT JOIN `kob_stock_available` sav ON (sav.`id_product` = a.`id_product` AND sav.`id_product_attribute` = 0 AND sav.id_shop = 1 AND sav.id_shop_group = 0 ) 
		JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) 
		LEFT JOIN `kob_category_lang` cl ON (sa.`id_category_default` = cl.`id_category` AND b.`id_lang` = cl.`id_lang` AND cl.id_shop = a.id_shop_default) 
		LEFT JOIN `kob_shop` shop ON (shop.id_shop = a.id_shop_default) 
		LEFT JOIN `kob_image_shop` image_shop ON (image_shop.`id_product` = a.`id_product` AND image_shop.`cover` = 1 AND image_shop.id_shop = a.id_shop_default) 
		LEFT JOIN `kob_image` i ON (i.`id_image` = image_shop.`id_image`) 
		LEFT JOIN `kob_product_download` pd ON (pd.`id_product` = a.`id_product`) 
		INNER JOIN `kob_category_product` cp ON (cp.`id_product` = a.`id_product` AND cp.`id_category` = 4001) 
		WHERE 1 ORDER BY a.`id_product` desc LIMIT 0, 50";
															  
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query);
															  
	}
	
	

    /**
     * Get instance of current manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }
}

<?php
/*
* 2016-2017 Kobster.com
*
*  @author Elumalai K <elumalai.k@kobster.com>
*  @copyright  2016-2017 Kobster.com
*  @version  Release: $Revision: 1797 $
*/

class VendorCore extends ObjectModel
{
	public 		$id;

	/** @var int vendor ID */
	public		$id_vendor;

	/** @var string Firstname */
	public 		$firstname;

	/** @var string designation */
	public 		$designation;

	/** @var string e-mail */
	public 		$email;

	/** @var string Password */
	public 		$passwd;

	/** @var datetime Password */
	public $last_passwd_gen;

	/** @var integer Address */
	public 		$id_address;

	/** @var int mobile number of the user*/
	public 		$phone1;

	/** @var int mobile number of the user*/
	public 		$phone2;

	/** @var int mobile number of the user*/
	public 		$smart_phone;

	/** @var string comments */
	public 		$comments;
	
	/** @var boolean Status */
	public 		$active = true;

	/** @var string Object creation date */
	public 		$date_add;

	/** @var string Object last modification date */
	public 		$date_upd;

	public $errors = array();
	
	protected $tables = array ('vendor_poc');

 	protected 	$fieldsRequired = array('firstname', 'email', 'passwd');
 	protected 	$fieldsSize = array('passwd' => 32, 'firstname' => 100, 'email' => 128);

 	protected 	$fieldsValidate = array('email' => 'isEmail', 'passwd' => 'isPasswd',
		 								'active' => 'isBool');

	protected	$webserviceParameters = array(
		'fields' => array(
			'last_passwd_gen' => array('setter' => null),
			'passwd' => array('setter' => 'setWsPasswd')
		));

	protected 	$table = 'vendor_poc';
	protected 	$identifier = 'id_poc';

	public function getFields()
	{
		parent::validateFields();
		if (isset($this->id))
			$fields['id_poc'] = (int)($this->id);
		$fields['id_vendor'] = (int)($this->id_vendor);
		$fields['firstname'] = pSQL($this->firstname);
		$fields['designation'] = pSQL($this->designation);
		$fields['passwd'] = pSQL($this->passwd);
		$fields['last_passwd_gen'] = pSQL($this->last_passwd_gen);
		$fields['id_address'] = (int)($this->id_address);
		$fields['phone1'] = (int)($this->phone1);
		$fields['phone2'] = (int)($this->phone2);
		$fields['email'] = pSQL($this->email);
		$fields['smart_phone'] = (int)($this->smart_phone);
		$fields['comments'] = pSQL($this->comments);
		$fields['active'] = (int)($this->active);
		$fields['date_add'] = pSQL($this->date_add);
		$fields['date_upd'] = pSQL($this->date_upd);
		
		return $fields;
	}

	public function add($autodate = true, $nullValues = true)
	{
		$this->last_passwd_gen = date('Y-m-d H:i:s', strtotime('-'.Configuration::get('PS_PASSWD_TIME_FRONT').'minutes'));

	 	if (!parent::add($autodate, $nullValues))
			return false;
	}

		/**
	  * Return employee instance from its e-mail (optionnaly check password)
	  *
	  * @param string $email e-mail
	  * @param string $passwd Password is also checked if specified
	  * @return Employee instance
	  */
	public function getByEmail($email, $passwd = NULL)
	{
	 	if (!Validate::isEmail($email) OR ($passwd != NULL AND !Validate::isPasswd($passwd)))
	 		die(Tools::displayError());

		$result = Db::getInstance()->getRow('
		SELECT *
		FROM `'._DB_PREFIX_.'vendor_poc`
		WHERE `active` = 1
		AND `email` = \''.pSQL($email).'\'
		'.($passwd ? 'AND `passwd` = \''.Tools::encrypt($passwd).'\'' : ''));
		if (!$result)
			return false;
		$this->id = $result['id_poc'];
		foreach ($result AS $key => $value)
			if (key_exists($key, $this))
				$this->{$key} = $value;
		return $this;
	}

	public static function vendorExists($email)
	{
	 	if (!Validate::isEmail($email))
	 		die (Tools::displayError());

		return (bool)Db::getInstance()->getValue('
		SELECT `id_poc`
		FROM `'._DB_PREFIX_.'vendor_poc`
		WHERE `email` = \''.pSQL($email).'\'');
	}

	/**
	  * Check if employee password is the right one
	  *
	  * @param string $passwd Password
	  * @return boolean result
	  */
	public static function checkPassword($id_poc, $passwd)
	{
	 	if (!Validate::isUnsignedId($id_poc) OR !Validate::isPasswd($passwd, 8))
	 		die (Tools::displayError());

		return Db::getInstance()->getValue('
		SELECT `id_poc`
		FROM `'._DB_PREFIX_.'vendor_poc`
		WHERE `id_poc` = '.(int)$id_poc.'
		AND `passwd` = \''.pSQL($passwd).'\'
		AND active = 1');
	}

	public function setWsPasswd($passwd)
	{
		
		if ($this->id != 0)
		{
			if ($this->passwd != $passwd)
				$this->passwd = Tools::encrypt($passwd);
		}
		else
			$this->passwd = Tools::encrypt($passwd);
		return true;
	}

	public function getEmployeeDetails($id_poc)
	{
		return Db::getInstance()->executeS('SELECT CONCAT(e.`firstname`, \' \', e.`lastname`) AS employee_name,e.`id_employee`,e.`email`,e.`phone` FROM `'._DB_PREFIX_.'vendor_employee_map` vep
											LEFT JOIN `'._DB_PREFIX_.'employee` e ON vep.`id_employee` = e.`id_employee`
											WHERE vep.`id_poc` = '.$id_poc.'');
	}

	public function getProductCountByStatus($id_status = false,$id_vendor, $id_employee = false){

		
		$query = $id_status ? ' AND ph.`id_product_state` = '.$id_status.'' : "";
		$id_vendor = $id_vendor ? ' AND p.`id_vendor` = '.$id_vendor.'' : "";
		$id_employee = $id_employee ? ' AND p.`id_employee` = '.$id_employee.'' : "";
		
		return Db::getInstance()->executeS('SELECT COUNT(p.`id_product`) AS total_products
											FROM `'._DB_PREFIX_.'product_history` ph
											LEFT JOIN `'._DB_PREFIX_.'product` p ON ph.`id_product` = p.`id_product`
											WHERE ph.`id_history` = (SELECT MAX(s.`id_history`) FROM `'._DB_PREFIX_.'product_history` s WHERE ph.`id_product` = s.`id_product`) 
											'.$query.' '.$id_vendor.' '.$id_employee.'
											ORDER BY ph.`id_history` DESC');
	}

	public function getProductDetails($id_poc = false, $status, $id_employee = false)
	{
		$currency = Currency::getDefaultCurrency();
		$query = "";
		$query .= $id_employee ? ' AND p.`id_employee` = '.$id_employee.'' : "";
		$query .= $id_poc ? ' AND p.`id_vendor` = '.$id_poc.'' : "";
		$query .= $status ? ' AND ph.`id_product_state` = '.$status.'' : "";

		return Db::getInstance()->executeS('SELECT p.`reference`,p.`id_product`,pl.`name`,p.`price`,p.`wholesale_price`,portal_price.`reduction` AS discount, 
											(p.`price` * (( tax_rate.`rate` / 100) + 1 )) AS mrp,
											((p.`price` * (( tax_rate.`rate` / 100) + 1 )) - portal_price.`reduction`) AS selling_price,
											((((p.`price` * (( tax_rate.`rate` / 100) + 1 )) - portal_price.`reduction`) * 100) / (100 + tax_rate.`rate`)) AS selling_price_without_tax,
											((((((((p.`price` * (( tax_rate.`rate` / 100) + 1 )) - portal_price.`reduction`) * 100) / (100 + tax_rate.`rate`))) - p.`wholesale_price`) / p.`wholesale_price`) * 100) AS margin,
											tax_rate.`rate`,p.`active`,p.`id_product`, cl.`name` AS category,
											ps.`name` AS product_status, ph.`id_product_state`,ph.`comment`
											FROM `'._DB_PREFIX_.'product_history` ph
											LEFT JOIN `'._DB_PREFIX_.'product` p ON ph.`id_product` = p.`id_product`
											LEFT JOIN `'._DB_PREFIX_.'product_state` ps ON ph.`id_product_state` = ps.`id_product_state`
											LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON ph.`id_product` = pl.`id_product`
											LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = 1 
											LEFT JOIN (
														SELECT t.`rate`,tr.`id_tax_rules_group` FROM `'._DB_PREFIX_.'tax_rule` tr
														LEFT JOIN `'._DB_PREFIX_.'tax` t ON tr.`id_tax` = t.`id_tax`
														WHERE tr.`id_country` = 110 AND tr.`id_state` = 0 AND t.`active` = 1 AND t.`deleted` = 0
											)tax_rate ON p.`id_tax_rules_group` = tax_rate.`id_tax_rules_group`
											LEFT JOIN (
														SELECT sp.`reduction`,sp.`id_product`,sp.`price` FROM `'._DB_PREFIX_.'specific_price` sp WHERE sp.`id_group` = 1 GROUP BY sp.`id_product`
											)portal_price ON p.`id_product` = portal_price.`id_product`
											WHERE ph.`id_history` = (SELECT MAX(s.`id_history`) FROM `'._DB_PREFIX_.'product_history` s WHERE ph.`id_product` = s.`id_product`) 
											'.$query.' AND pl.`id_lang` = 1 
											ORDER BY ph.`id_history` DESC');
	}

	public function getVendorState($id_poc){
		return Db::getInstance()->executeS('SELECT va.`id_state`,va.`country`,va.`pincode` AS postcode FROM `'._DB_PREFIX_.'vendor_poc` poc
											LEFT JOIN `'._DB_PREFIX_.'vendor_address` va ON poc.`id_vendor` = va.`id_vendor`
											WHERE poc.`id_poc` = '.$id_poc.'
											ORDER BY va.`id_address` DESC LIMIT 1');
	}

	public static function getFrontFeaturesStatic($id_lang, $id_product, $id_category)
	{
		return Db::getInstance()->executeS('SELECT fl.`name`, fvl.`value`, pf.`id_feature`, cfg.`feature_required`, pf.`id_feature_value`, fv.`custom`
											FROM '._DB_PREFIX_.'feature_product pf
											LEFT JOIN '._DB_PREFIX_.'feature_lang fl ON (pf.id_feature = fl.id_feature AND fl.id_lang = '.(int)$id_lang.')
											LEFT JOIN '._DB_PREFIX_.'feature_value fv ON (pf.id_feature_value = fv.id_feature_value)
											LEFT JOIN '._DB_PREFIX_.'feature_value_lang fvl ON (pf.id_feature_value = fvl.id_feature_value AND fvl.id_lang = '.(int)$id_lang.')
											LEFT JOIN '._DB_PREFIX_.'category_feature_group cfg ON (pf.`id_feature` = cfg.`id_feature`)
											WHERE pf.id_product = '.(int)($id_product).' AND cfg.`id_category` = '.$id_category.'');
	}

	public function addProductImage($product, $method = 'auto', $id_image, $image_array, $newImageName, $newImageTempName)
	{
		/* Updating an existing product image */
		if ($id_image = ((int)($id_image)))
		{
			$image = new Image($id_image);
			if (!Validate::isLoadedObject($image))
				echo "0";
			else
			{
				if (($cover = Tools::getValue('cover')) == 1)
					Image::deleteCover($product->id);
				$image->cover = $cover;
				if (sizeof($errors) OR !$image->update())
					$errors = 'An error occurred while updating image.';
				elseif (isset($_FILES['image_product']['tmp_name']) AND $_FILES['image_product']['tmp_name'] != NULL)
					Vendor::copyImage($product->id, $image->id, $method, $image_array, $newImageName, $newImageTempName);
			}
		}

		/* Adding a new product image */
		elseif (isset($newImageName) && $newImageName != NULL )
		{
			if (isset($newImageName) AND $newImageName != NULL)
			{
				if (!Validate::isLoadedObject($product))
					$errors = "Product Not Added";
				elseif (substr($newImageName, -4) == '.zip')
					return Vendor::uploadImageZip($product);
				else
				{
					$image = new Image();
					$image->id_product = (int)($product->id);
					$_POST['id_product'] = $image->id_product;
					$image->position = Image::getHighestPosition($product->id) + 1;
					if (($cover = Tools::getValue('cover')) == 1)
						Image::deleteCover($product->id);
					$image->cover = !$cover ? !sizeof($product->getImages(Configuration::get('PS_LANG_DEFAULT'))) : true;
					if (!$image->add())
						echo 'Error while creating additional image';
					else
						Vendor::copyImage($product->id, $image->id, $method, $image_array, $newImageName, $newImageTempName);
						$id_image = $image->id;
				}
			}
		}
		if (isset($image) AND Validate::isLoadedObject($image) AND !file_exists(_PS_PROD_IMG_DIR_.$image->getExistingImgPath().'.'.$image->image_format))
			$image->delete();

		@unlink(_PS_TMP_IMG_DIR_.'/product_'.$product->id.'.jpg');
		@unlink(_PS_TMP_IMG_DIR_.'/product_mini_'.$product->id.'.jpg');
		return ((isset($id_image) AND is_int($id_image) AND $id_image) ? $id_image : true);
	}

	public function copyImage($id_product, $id_image, $method = 'auto', $image_array, $newImageName, $newImageTempName)
	{
		if (!isset($newImageTempName)) {
            return false;
        }

       
        $image = new Image($id_image);

        if (!$new_path = $image->getPathForCreation()) 
        {
           echo "1";
        }

        if (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($newImageTempName, $tmpName)) 
        {
            echo "2";
        } 
        elseif (!ImageManager::resize($tmpName, $new_path.'.'.$image->image_format)) 
        {
           echo "3";
        } 
        elseif ($method == 'auto') 
        {
            $imagesTypes = ImageType::getImagesTypes('products');
            foreach ($imagesTypes as $k => $image_type) 
            {
                if (!ImageManager::resize($tmpName, $new_path.'-'.stripslashes($image_type['name']).'.'.$image->image_format, $image_type['width'], $image_type['height'], $image->image_format)) 
                {
                    echo "4";
                }
            }
        }

        @unlink($tmpName);
        Hook::exec('actionWatermark', array('id_image' => $id_image, 'id_product' => $id_product));
	}

	public function createImageFromURL($urls, $id_product, $name, $delete_existing_image = NULL)
	{

		$product = new Product((int)($id_product));

		if ($delete_existing_image == "on")
			$product->deleteImages();

		$productHasImages = (bool)Image::getImages(1, (int)($product->id));
		
		foreach ($urls AS $key => $url)
		{
			if (!empty($url))
			{
				$image = new Image();
				$image->id_product = (int)($product->id);
				$image->position = Image::getHighestPosition($product->id) + 1;
				$image->cover = (!$key AND !$productHasImages) ? true : false;
				$image->legend = $name;
				if ($image->add())
				{
					if (!Vendor::copyImg($product->id, $image->id, $url, 'products'))
						echo "Error in copying image";
				}
				else
				{
					echo "Error while adding image";
				}
			}
		}
	}

	/* Copying image from remote URL
	   Param1: Product or Category Id, Param2: ID Image, Param3: Remote URL, Param4: Type
	*/
	protected static function copyImg($id_entity, $id_image = null, $url, $entity = 'products', $regenerate = true)
    {
        $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
        $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));

        switch ($entity) {
            default:
            case 'products':
                $image_obj = new Image($id_image);
                $path = $image_obj->getPathForCreation();
            break;
            case 'categories':
                $path = _PS_CAT_IMG_DIR_.(int)$id_entity;
            break;
            case 'manufacturers':
                $path = _PS_MANU_IMG_DIR_.(int)$id_entity;
            break;
            case 'suppliers':
                $path = _PS_SUPP_IMG_DIR_.(int)$id_entity;
            break;
        }

        $url_source_file = str_replace(' ', '%20', trim($url));

        $orig_tmpfile = $tmpfile;

        if (Tools::copy($url_source_file, $tmpfile)) {
            // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
            if (!ImageManager::checkImageMemoryLimit($tmpfile)) {
                @unlink($tmpfile);
                return false;
            }

            $tgt_width = $tgt_height = 0;
            $src_width = $src_height = 0;
            $error = 0;
            ImageManager::resize($tmpfile, $path.'.jpg', null, null, 'jpg', false, $error, $tgt_width, $tgt_height, 5,
                                 $src_width, $src_height);
            $images_types = ImageType::getImagesTypes($entity, true);

            if ($regenerate) {
                $previous_path = null;
                $path_infos = array();
                $path_infos[] = array($tgt_width, $tgt_height, $path.'.jpg');
                foreach ($images_types as $image_type) {
                    $tmpfile = self::get_best_path($image_type['width'], $image_type['height'], $path_infos);

                    if (ImageManager::resize($tmpfile, $path.'-'.stripslashes($image_type['name']).'.jpg', $image_type['width'],
                                         $image_type['height'], 'jpg', false, $error, $tgt_width, $tgt_height, 5,
                                         $src_width, $src_height)) {
                        // the last image should not be added in the candidate list if it's bigger than the original image
                        if ($tgt_width <= $src_width && $tgt_height <= $src_height) {
                            $path_infos[] = array($tgt_width, $tgt_height, $path.'-'.stripslashes($image_type['name']).'.jpg');
                        }
                        if ($entity == 'products') {
                            if (is_file(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'.jpg')) {
                               unlink(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'.jpg');
                            }
                            if (is_file(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'_'.(int)Context::getContext()->shop->id.'.jpg')) {
                               unlink(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'_'.(int)Context::getContext()->shop->id.'.jpg');
                            }
                        }
                    }
                    if (in_array($image_type['id_image_type'], $watermark_types)) {
                        Hook::exec('actionWatermark', array('id_image' => $id_image, 'id_product' => $id_entity));
                    }
                }
            }
        } else {
            @unlink($orig_tmpfile);
            return false;
        }
        unlink($orig_tmpfile);
        return true;
    }

    private static function get_best_path($tgt_width, $tgt_height, $path_infos)
    {
        $path_infos = array_reverse($path_infos);
        $path = '';
        foreach ($path_infos as $path_info) {
            list($width, $height, $path) = $path_info;
            if ($width >= $tgt_width && $height >= $tgt_height) {
                return $path;
            }
        }
        return $path;
    }


	public function addProductFeatures($id_product, $post_data)
	{
		if (Validate::isLoadedObject($product = new Product((int)($id_product))))
		{
			// delete all objects
			$product->deleteFeatures();
			// add new objects
			$languages = Language::getLanguages(false);

			foreach ($post_data AS $key => $val)
			{
				if (preg_match('/^custom_([0-9]+)_value/i', $key, $match))
				{	
					$feature_value = Tools::getValue($key);

					if(trim($feature_value) != "" && $feature_value != "null") 
					{
						$id_feature_value = Vendor::addFeatureValueImport($match[1], $feature_value);
						Product::addFeatureProductImport($product->id, $match[1], $id_feature_value);
						//Map new feature to category
						$feature_check = Vendor::isExistsFeature($match[1], Tools::getValue('category'));
						if($feature_check){}
						else{
							Vendor::mapToCategory($match[1], Tools::getValue('category'), 0);
						}
					}
				}
			}
		}
	}

	public function isExistsProductState($id_product, $id_employee, $id_state){
		return Db::getInstance()->executeS('SELECT ph.`id_product` FROM `'._DB_PREFIX_.'product_history` ph
										   WHERE ph.`id_product` = '.$id_product.' 
										   AND ph.`id_employee` = '.$id_employee.'
										   AND ph.`id_product_state` = '.$id_state.'');
	}

	public function addToProductHistory($id_product, $id_employee, $id_product_state, $reject_comment = false)
	{
		Db::getInstance()->delete(_DB_PREFIX_.'product_history', 'id_product = '.(int)($id_product).'  
									AND id_product_state >= '.(int)($id_product_state).'');
		return Db::getInstance()->autoExecute(_DB_PREFIX_.'product_history', 
										array('id_product' => (int)($id_product), 'id_employee' => (int)($id_employee), 
										'id_product_state' => (int)($id_product_state), 'comment' => $reject_comment), 'INSERT');
	}

	public function getEmployeeRole($id_employee)
	{
		return Db::getInstance()->executeS('SELECT el.`id_role` FROM `'._DB_PREFIX_.'employee_role` el
										   WHERE el.`id_employee` = '.(int)$id_employee.'');
	}

	public function getVendorByEmployee($id_employee){
		return Db::getInstance()->executeS('SELECT vem.`id_poc` FROM `'._DB_PREFIX_.'vendor_employee_map` vem
											WHERE vem.`id_employee` = '.$id_employee.'');
	}

	public function getProductHistoryByIdProduct($id_product,$status){
		return Db::getInstance()->executeS('SELECT ph.* FROM `'._DB_PREFIX_.'product_history` ph 
											WHERE ph.`id_product` = '.$id_product.' AND ph.`id_product_state` = '.$status.'');
	}

	public function getCategoryPattern($id_category)
	{
		return Db::getInstance()->executeS('SELECT cp.`pattern_rule` FROM `'._DB_PREFIX_.'category_pattern` cp
											WHERE cp.`id_category` = '.$id_category.'');
	}

	public static function addFeatureValueImport($id_feature, $name)
	{
		$rq = Db::getInstance()->executeS('SELECT fv.`id_feature_value`
			FROM '._DB_PREFIX_.'feature_value fv
			LEFT JOIN '._DB_PREFIX_.'feature_value_lang fvl ON (fvl.`id_feature_value` = fv.`id_feature_value`)
			WHERE `value` = \''.pSQL($name).'\'
			AND fv.`id_feature` = '.(int)$id_feature.'
			AND fv.`custom` = 1
			GROUP BY fv.`id_feature_value` LIMIT 1'
		);

		if (!isset($rq[0]['id_feature_value']) OR !$id_feature_value = (int)$rq[0]['id_feature_value']) {
			// Feature doesn't exist, create it
			$featureValue = new FeatureValue();
			
			$languages = Language::getLanguages();
			foreach ($languages AS $language)
				$featureValue->value[$language['id_lang']] = strval($name);

			$featureValue->id_feature = (int)$id_feature;
			$featureValue->custom = 1;
			$featureValue->add();

			return (int)$featureValue->id;
		}

		return (int)$id_feature_value;
	}

	public static function getFeatureValuesWithLang($id_lang, $id_feature)
	{
		return Db::getInstance()->executeS('
		SELECT *
		FROM `'._DB_PREFIX_.'feature_lang` v
		WHERE v.`id_feature` = '.(int)$id_feature.' AND v.`id_lang` = 1');
	}

	public function isExistsFeature($id_feature, $id_category)
	{
		return Db::getInstance()->executeS('SELECT a.`id_category` FROM `'._DB_PREFIX_.'category_feature_group` a
											WHERE a.`id_category` = '.$id_category.' AND a.`id_feature` = '.$id_feature.'');
	}

	public function mapToCategory($id_feature, $id_category, $required)
	{
		return Db::getInstance()->autoExecute(_DB_PREFIX_.'category_feature_group', array('id_category' => (int)($id_category), 'id_feature' => (int)($id_feature), 'feature_required' => (int)($required)), 'INSERT');
	}

	public function getFeatureDetail($id_feature, $id_lang)
	{
		return Db::getInstance()->executeS('SELECT fl.`id_feature`,fl.`name` 
											FROM `'._DB_PREFIX_.'feature_lang` fl
											WHERE fl.`id_feature` = '.$id_feature.' AND fl.`id_lang` = '.$id_lang.'');
	}

	public function addPatternToCategory($pattern,$id_category)
	{
		$get_pattern_id = Db::getInstance()->executeS('SELECT id_category FROM `'._DB_PREFIX_.'category_pattern` 
												WHERE id_category = '.(int)($id_category).'');

		if(!$get_pattern_id[0]['id_category'])
			return Db::getInstance()->autoExecute(_DB_PREFIX_.'category_pattern', array('id_category' => (int)($id_category), 'pattern_rule' => ($pattern)), 'INSERT');
		else
			return Db::getInstance()->autoExecute(_DB_PREFIX_.'category_pattern', array('pattern_rule' => ($pattern)), 'UPDATE', 'id_category = '.(int)($id_category).'');
	}

	public function addFeatureToCategory($id_feature, $id_category, $required, $feature_status)
	{
		$required = $required == 'true' ? 1 : 0;

		if($feature_status == 'true')
		{
			$get_feature = Db::getInstance()->executeS('SELECT id_feature FROM `'._DB_PREFIX_.'category_feature_group`
														WHERE id_category = '.(int)($id_category).' AND id_feature = '.(int)($id_feature).'');

			if(!$get_feature[0]['id_feature']){
				Db::getInstance()->autoExecute(_DB_PREFIX_.'category_feature_group', array('id_category' => (int)($id_category), 'id_feature' => ($id_feature), 'feature_required' => ($required)), 'INSERT');
				return 1;
			}
			else{
				Db::getInstance()->autoExecute(_DB_PREFIX_.'category_feature_group', array('feature_required' => ($required)), 'UPDATE', 'id_category = '.(int)($id_category).' AND id_feature = '.$id_feature.'');

				return 2;
			}
		}
		else
		{
			Db::getInstance()->delete(''._DB_PREFIX_.'category_feature_group', 'id_category = '.(int)($id_category).' AND id_feature = '.$id_feature.'', 1);

			return 3;
		}

	}

	public static function getManufacturerByName($name)
	{
		return Db::getInstance()->executeS('SELECT m.`id_manufacturer` FROM `'._DB_PREFIX_.'manufacturer` m
											WHERE m.`name` = "'.pSQL($name).'" GROUP BY m.`id_manufacturer` LIMIT 1');
	}

	public static function getCategoryFeature($id_category)
    {
        return Db::getInstance()->executeS('SELECT cf.`id_category`,cf.`id_feature`,cf.`feature_required`,fl.`name`,fl.`id_lang` 
                                            FROM `'._DB_PREFIX_.'category_feature_group` cf
                                            LEFT JOIN `'._DB_PREFIX_.'feature` f ON cf.`id_feature` = f.`id_feature`
                                            LEFT JOIN  `'._DB_PREFIX_.'feature_lang` fl ON cf.`id_feature` = fl.`id_feature` AND fl.`id_lang` = 1
                                            WHERE cf.`id_category` = '.(int)($id_category).' AND f.`id_feature` IS NOT NULL
                                            ORDER BY cf.`feature_required` DESC');
    }

    public static function getAttributesWithCategory($id_category)
    {
        return Db::getInstance()->executeS('SELECT f.`id_feature`,fl.`name`,category_features.`feature_required` 
                                            FROM `'._DB_PREFIX_.'feature` f
                                            LEFT JOIN ( SELECT cfg.`id_feature`,cfg.`feature_required` 
                                                        FROM `'._DB_PREFIX_.'category_feature_group` cfg 
                                                        WHERE cfg.`id_category` = '.$id_category.' ) category_features ON f.`id_feature` =  category_features.`id_feature`
                                            LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl ON f.`id_feature` = fl.`id_feature` AND fl.`id_lang` = 1
                                            WHERE 1 ORDER BY fl.`name` ASC');
    }

    public static function getChildren($id_parent, $id_lang, $active = true)
	{
		if (!Validate::isBool($active))
	 		die(Tools::displayError());

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT c.`id_category`, cl.`name`, cl.`link_rewrite`
		FROM `'._DB_PREFIX_.'category` c
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`
		WHERE `id_lang` = '.(int)($id_lang).'
		AND c.`id_parent` = '.(int)($id_parent).'
		'.($active ? 'AND `active` = 1' : '').'
		ORDER BY `position` ASC');
	}

	/**
	* Resize, cut and optimize image
	*
	* @param array $sourceFile Image object from $_FILE
	* @param string $destFile Destination filename
	* @param integer $destWidth Desired width (optional)
	* @param integer $destHeight Desired height (optional)
	*
	* @return boolean Operation result
	  */
	function imageResize($sourceFile, $destFile, $destWidth = NULL, $destHeight = NULL, $fileType = 'jpg')
	{
		if (!file_exists($sourceFile))
			return false;
		list($sourceWidth, $sourceHeight, $type, $attr) = getimagesize($sourceFile);
		// If PS_IMAGE_QUALITY is activated, the generated image will be a PNG with .jpg as a file extension.
		// This allow for higher quality and for transparency. JPG source files will also benefit from a higher quality
		// because JPG reencoding by GD, even with max quality setting, degrades the image.
		if (Configuration::get('PS_IMAGE_QUALITY') == 'png_all'
			|| (Configuration::get('PS_IMAGE_QUALITY') == 'png' && $type == IMAGETYPE_PNG))
			$fileType = 'png';
		
		if (!$sourceWidth)
			return false;
		if ($destWidth == NULL) $destWidth = $sourceWidth;
		if ($destHeight == NULL) $destHeight = $sourceHeight;

		$sourceImage = Vendor::createSrcImage($type, $sourceFile);

		$widthDiff = $destWidth / $sourceWidth;
		$heightDiff = $destHeight / $sourceHeight;

		if ($widthDiff > 1 AND $heightDiff > 1)
		{
			$nextWidth = $sourceWidth;
			$nextHeight = $sourceHeight;
		}
		else
		{
			if (Configuration::get('PS_IMAGE_GENERATION_METHOD') == 2 OR (!Configuration::get('PS_IMAGE_GENERATION_METHOD') AND $widthDiff > $heightDiff))
			{
				$nextHeight = $destHeight;
				$nextWidth = round(($sourceWidth * $nextHeight) / $sourceHeight);
				$destWidth = (int)(!Configuration::get('PS_IMAGE_GENERATION_METHOD') ? $destWidth : $nextWidth);
			}
			else
			{
				$nextWidth = $destWidth;
				$nextHeight = round($sourceHeight * $destWidth / $sourceWidth);
				$destHeight = (int)(!Configuration::get('PS_IMAGE_GENERATION_METHOD') ? $destHeight : $nextHeight);
			}
		}

		$destImage = imagecreatetruecolor($destWidth, $destHeight);

		// If image is a PNG and the output is PNG, fill with transparency. Else fill with white background.
		if ($fileType == 'png' && $type == IMAGETYPE_PNG)
		{
			imagealphablending($destImage, false);
			imagesavealpha($destImage, true);	
			$transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
			imagefilledrectangle($destImage, 0, 0, $destWidth, $destHeight, $transparent);
		}else
		{
			$white = imagecolorallocate($destImage, 255, 255, 255);
			imagefilledrectangle($destImage, 0, 0, $destWidth, $destHeight, $white);
		}
		
		imagecopyresampled($destImage, $sourceImage, (int)(($destWidth - $nextWidth) / 2), (int)(($destHeight - $nextHeight) / 2), 0, 0, $nextWidth, $nextHeight, $sourceWidth, $sourceHeight);

		return (Vendor::returnDestImage($fileType, $destImage, $destFile));
	}

	function returnDestImage($type, $ressource, $filename)
	{
		$flag = false;
		switch ($type)
		{
			case 'gif':
				$flag = imagegif($ressource, $filename);
				break;
			case 'png':
				$quality = (Configuration::get('PS_PNG_QUALITY') === false ? 7 : Configuration::get('PS_PNG_QUALITY'));
				$flag = imagepng($ressource, $filename, (int)$quality);
				break;		
			case 'jpg':
			case 'jpeg':
			default:
				$quality = (Configuration::get('PS_JPEG_QUALITY') === false ? 90 : Configuration::get('PS_JPEG_QUALITY'));
				$flag = imagejpeg($ressource, $filename, (int)$quality);
				break;
		}
		imagedestroy($ressource);
		@chmod($filename, 0664);
		return $flag;
	}

	function createSrcImage($type, $filename)
	{
		switch ($type)
		{
			case 1:
				return imagecreatefromgif($filename);
				break;
			case 3:
				return imagecreatefrompng($filename);
				break;
			case 2:
			default:
				return imagecreatefromjpeg($filename);
				break;
		}
	}
}
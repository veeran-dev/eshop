<?php
/*
* 2016-2017 Kobster.com
*
*  @author Elumalai K <elumalai.k@kobster.com>
*  @copyright  2013-2017 Kobster.com
*  @version  Release: $Revision: 1797 $
*/
class CatalogDataControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		global $smarty;

		$type = Tools::getValue('type');
		$id_parent = Tools::getValue('id_parent');
		$id_category = Tools::getValue('id_category');
		$id_product = Tools::getValue('id_product');
		$id_state = Tools::getValue('id_product_state');
		$id_image = Tools::getValue('id_image');
		$imageUrls = Tools::getValue('imageUrls');
		$delete_existing_images = Tools::getValue('delete_existing_images');
		$search_query = Tools::getValue('search_query');

		$currency = Currency::getDefaultCurrency();
		$tax_group = TaxRulesGroup::getTaxRulesGroups(true);
		$features_list = Feature::getFeatures(true);
		$get_manufacturer = Vendor::getManufacturerByName(Tools::getValue('custom_19_value'));

		if(isset($type))
		{
			if($type == 1) //GET uploaded products counts
			{
				$home_content = array();

				$employees = Vendor::getEmployeeDetails(self::$cookie->id_poc);

				$pending_count = Vendor::getProductCountByStatus(1, self::$cookie->id_poc, false);
				$qc_count = Vendor::getProductCountByStatus(2, self::$cookie->id_poc, false);
				$live_count = Vendor::getProductCountByStatus(3, self::$cookie->id_poc, false);
				$rejected = Vendor::getProductCountByStatus(4, self::$cookie->id_poc, false);

				array_push($home_content, $employees, $pending_count, $live_count, $rejected, $qc_count);

				echo Tools::jsonEncode($home_content);
			}
			else if($type == 2) //GET home categories
			{
				$result = Category::getHomeCategories(1, $active = true);
				echo Tools::jsonEncode($result);
			}
			else if($type == 3) //GET child categories
			{
				$result = Vendor::getChildren($id_parent, 1, $active = true);
				echo Tools::jsonEncode($result);
			}
			else if($type == 4) //GET features for category
			{
				$result_array = array();
				$result = Vendor::getCategoryFeature($id_category);

				array_push($result_array, $result, $tax_group);

				echo Tools::jsonEncode($result_array);
			}
			else if($type == 5) //Product creation
			{	
				$product = new Product();
				$custom_prod_name = Tools::getValue('custom_prod_name');
				$built_prod_name = Tools::getValue('product_name');
				$id_tax_rules_group = Tools::getValue('taxId');
				$tax_exclusive = Tools::getValue('taxExclusive');
				$wholesale_price = Tools::getValue('wholesalePrice');
				$hsn_code = Tools::getValue('hsnCode');
				$long_description = Tools::getValue('longDesc');
				$short_description = Tools::getValue('shortDescription');
				$portal_price = Tools::getValue('portalPrice');
				$category_id = Tools::getValue('category');

				if($custom_prod_name != "")
					$product->name[1] = $custom_prod_name;
				else
					$product->name[1] = $built_prod_name;

				if(isset($long_description) && $long_description != "")
					$product->description[1] = $long_description;

				if(isset($short_description) && $short_description != "")
					$product->description_short[1] = $short_description;

				$product->id_vendor = (int)self::$cookie->id_poc ? (int)self::$cookie->id_poc : 0;
				$product->id_employee = (int)self::$cookie->id_employee;
				$product->active = 0;
				$product->condition = "new";

		  		$link_rewrite = str_replace(' ', '-', $product->name[1]); // Replaces all spaces with hyphens.
				$link_rewrite_value = preg_replace('/[^A-Za-z0-9\-]/', '', $link_rewrite); // Removes special chars.
				$link_rewrite_value = str_replace('--', '-', $link_rewrite_value);
				$link_rewrite_value = rtrim($link_rewrite_value,'-');

		 		$product->link_rewrite[1] = $link_rewrite_value;

	 			$product->id_tax_rules_group = isset($id_tax_rules_group) && is_numeric($id_tax_rules_group) ? $id_tax_rules_group : 0;

	 			$product->hsn_code = isset($hsn_code) && $hsn_code ? $_POST['hsnCode'] : 1000;

				$product->price = isset($tax_exclusive) && is_numeric($tax_exclusive) ? $tax_exclusive : 0;

				$product->wholesale_price = isset($wholesale_price) && is_numeric($wholesale_price) ? $wholesale_price : 0;

				if(!isset($get_manufacturer[0]['id_manufacturer']) OR !$id_manufacturer = (int)$get_manufacturer[0]['id_manufacturer'])
				{
					//Create Manufacturer if not exists
					$manufacturer = new Manufacturer();
					$manufacturer->name = Tools::getValue('custom_19_value');
					$manufacturer->active = 1;
					if($manufacturer->add())
						$product->id_manufacturer = $manufacturer->id;
				}
				else
					$product->id_manufacturer = (int)$get_manufacturer[0]['id_manufacturer'];
		 		
		 		if($product->add())
		 		{
					/**
					* Product Created
					* Map product to category with all parent levels
					*/
					$categoryObj = new Category(intval($category_id));
					$parent_categories = $categoryObj->getParentsCategories(1);
					
					$categories = array();
					
					foreach ($parent_categories as $category) {
						$categories[] = $category['id_category'];
					}

					$product->addToCategories($categories);

					$product->id_category_default = $_POST['category'];
					$product->meta_title[1] = "".$product->name[1]." (".$product->reference.") | Kobster.com";
					$product->meta_description[1] = "Buy Wholesale ".$product->name[1]." (".$product->reference.") Online at Best Prices in India at Kobster.com";

					if($product->update())
					{
						//add specific price
						if(isset($portal_price) && is_numeric($portal_price) && $portal_price > 0)
						{
							$addSpecificPrice = new SpecificPrice();
							$addSpecificPrice->id_product = $product->id;
							$addSpecificPrice->id_shop = 1;
							$addSpecificPrice->id_currency = 0;
							$addSpecificPrice->id_country = 0;
							$addSpecificPrice->id_group =1;
							$addSpecificPrice->price = -1;
							$addSpecificPrice->from_quantity = 1;
							$addSpecificPrice->reduction = $_POST['portalPrice'];
							$addSpecificPrice->reduction_type = "amount";
							$addSpecificPrice->from = "0000-00-00 00:00:00";
							$addSpecificPrice->to = "0000-00-00 00:00:00";
							$addSpecificPrice->add();
						}

						//Upload Image from URL
						if(isset($imageUrls) && $imageUrls != "")
							Vendor::createImageFromURL($imageUrls = explode("..", $imageUrls),$product->id, $product->name[1]);
						//Update features to product
						Vendor::addProductFeatures($product->id, $_POST);

						// Loop through each file
						if($total = count($_FILES['file']['name'])) {
							for($i=0; $i < $total; $i++) {							
								$img_array = $_FILES['file'];
								$image_name = $_FILES['file']['name'][$i];
								$img_tmp_name = $_FILES['file']['tmp_name'][$i];
								
								Vendor::addProductImage($product, $method = 'auto', false, $img_array, $image_name, $img_tmp_name);
							}
						}

						//Add product to product history(param1: product id, param2: employee id, param3: product state)
						if((int)self::$cookie->id_poc)
							Vendor::addToProductHistory($product->id, 0, 1);
						elseif((int)self::$cookie->id_employee)
							Vendor::addToProductHistory($product->id, (int)self::$cookie->id_employee, 2);

						if($_POST['uploadStay'] == "true")
							echo 2;
						else
							echo 1;
					}
				}
			}
			else if($type == 6) //GET all product details by their statuses
			{
				$id_state = isset($id_state) && ($id_state != "") ? $id_state : false;
				$result = array();

				$product_detail = Vendor::getProductDetails((int)(self::$cookie->id_poc), $id_state);
				for($i = 0; $i < sizeof($product_detail); $i++)
					$product_detail[$i]['price'] = Tools::convertPrice($product_detail[$i]['price'], $currency);

				echo Tools::jsonEncode($product_detail);
			}
			else if($type == 7) //View specific product detail
			{
				$product_details = array();
				$product = new Product((int)($id_product));

				$features = Vendor::getFrontFeaturesStatic(1, $product->id, $product->id_category_default);

				$product_comment = Vendor::getProductHistoryByIdProduct($id_product,4);

				$product->reject_comment = $product_comment[0]['comment'];
				$product->description = $product->description[1]; 
				$product->description_short = $product->description_short[1];

				/** specific price **/
				$specific_price = SpecificPrice::getSpecificProductPrice((int)$id_product,1);
				
				$image = Image::getImages(1,$id_product);				
				$link = new Link;//because getImageLInk is not static function
				$image_urls = array();
				
				for($i=0;$i<sizeof($image);$i++)
				{
					$imagePath = $link->getImageLink($product->link_rewrite[1], $image[$i]['id_image'], 'home_default');
					$image_urls[$i]['image'] = 'http://'.$imagePath;
					$image_urls[$i]['id_image'] = $image[$i]['id_image'];
				}

				array_push($product_details, $product, $features, false, $tax_group, $features_list, $image_urls, $specific_price);

				echo Tools::jsonEncode($product_details);
			}
			else if($type == 8) //for product object update
			{
				$product = new Product((int)($id_product));
				$custom_prod_name = Tools::getValue('custom_prod_name');
				$built_prod_name = Tools::getValue('product_name');
				$id_tax_rules_group = Tools::getValue('taxId');
				$tax_exclusive = Tools::getValue('taxExclusive');
				$wholesale_price = Tools::getValue('wholesalePrice');
				$hsn_code = Tools::getValue('hsnCode');
				$long_description = Tools::getValue('longDesc');
				$short_description = Tools::getValue('shortDescription');
				$portal_price = Tools::getValue('portalPrice');

				if(isset($tax_exclusive) && is_numeric($tax_exclusive))
					$product->price = $tax_exclusive;

				if(isset($wholesale_price) && is_numeric($wholesale_price))
					$product->wholesale_price = $wholesale_price;

				$validation = $product->validatePrice($product->price, $product->wholesale_price);

				if(!$validation && is_array($validation) && count($validation)) {
					echo Tools::jsonEncode($validation);
					return false;
				}

				
				if($custom_prod_name != "" || $built_prod_name != "")
				{
					if($custom_prod_name != "")
						$product->name[1] = $custom_prod_name;
					else
						$product->name[1] = $built_prod_name;

					
					$product->meta_title[1] = "".$product->name[1]." (".$product->reference.") | Kobster.com";
					$product->meta_description[1] = "Buy Wholesale ".$product->name[1]." (".$product->reference.") Online at Best Prices in India at Kobster.com";
				}

				if(!isset($get_manufacturer[0]['id_manufacturer']) OR !$id_manufacturer = (int)$get_manufacturer[0]['id_manufacturer'])
				{
					//Create Manufacturer if not exists
					$manufacturer = new Manufacturer();
					$manufacturer->name = Tools::getValue('custom_19_value');
					$manufacturer->active = 1;
					if($manufacturer->add())
						$product->id_manufacturer = $manufacturer->id;
				}
				else
					$product->id_manufacturer = (int)$get_manufacturer[0]['id_manufacturer'];

				if(isset($wholesale_price) && is_numeric($wholesale_price))
					$product->wholesale_price = $wholesale_price;

				if(isset($tax_exclusive) && is_numeric($tax_exclusive))
					$product->price = $tax_exclusive;

				if(isset($id_tax_rules_group) && is_numeric($id_tax_rules_group))
					$product->id_tax_rules_group = $id_tax_rules_group;

				if(isset($hsn_code) && $hsn_code)
					$product->hsn_code = $hsn_code;

				if(isset($long_description) && $long_description)
					$product->description[1] = $long_description;

				if(isset($short_description) && $short_description)
					$product->description_short[1] = $short_description;

				if($product->update())
				{
					//add specific price
					if(isset($portal_price) && is_numeric($portal_price) && $portal_price > 0)
					{
						/*deletes existing price while updating new price*/
						$deleteExisting = SpecificPrice::deleteSpecificPrice($product->id, 1);
						$addSpecificPrice = new SpecificPrice();
						$addSpecificPrice->id_product = $product->id;
						$addSpecificPrice->id_shop = 1;
						$addSpecificPrice->id_currency = 0;
						$addSpecificPrice->id_country = 0;
						$addSpecificPrice->id_group =1;
						$addSpecificPrice->price = -1;
						$addSpecificPrice->from_quantity = 1;
						$addSpecificPrice->reduction = $portal_price;
						$addSpecificPrice->reduction_type = "amount";
						$addSpecificPrice->from = "0000-00-00 00:00:00";
						$addSpecificPrice->to = "0000-00-00 00:00:00";
						$addSpecificPrice->add();
					}

					//Upload Image from URL
					if(isset($imageUrls) && $imageUrls != "")
						Vendor::createImageFromURL($imageUrls = explode("..", $imageUrls), $product->id, $product->name[1], $delete_existing_images);

					//Update features to product
					Vendor::addProductFeatures($product->id, $_POST);
						
					// Loop through each file
					if($total = count($_FILES['file']['name'])) {
						for($i=0; $i < $total; $i++) {							
							$img_array = $_FILES['file'];
							$image_name = $_FILES['file']['name'][$i];
							$img_tmp_name = $_FILES['file']['tmp_name'][$i];
							
							Vendor::addProductImage($product, $method = 'auto', false, $img_array, $image_name, $img_tmp_name);
						}
					}
					
					if((int)self::$cookie->id_poc)
						Vendor::addToProductHistory($product->id, 0,1);
					elseif((int)self::$cookie->id_employee)
						Vendor::addToProductHistory($product->id, (int)self::$cookie->id_employee,2);

					echo 3;
				}
			}
			else if($type == 9) //GET waiting for approval products for vendor
			{
				$product_detail = array();
				$result = array();
				$product_detail1 = Vendor::getProductDetails((int)(self::$cookie->id_poc), 1);
				$product_detail2 = Vendor::getProductDetails((int)(self::$cookie->id_poc), 2);

				for($i = 0; $i < sizeof($product_detail1); $i++)
					array_push($product_detail, $product_detail1[$i]);
				for($j = 0; $j < sizeof($product_detail2); $j++)
					array_push($product_detail, $product_detail2[$j]);

				//Formatting currency
				for($i = 0; $i < sizeof($product_detail); $i++)
						$product_detail[$i]['price'] = Tools::convertPrice($product_detail[$i]['price'], $currency);

				echo Tools::jsonEncode($product_detail);
			}
			else if($type == 10){
				$result = Feature::getFeaturesByName(true, $search_query, true);
				echo Tools::jsonEncode($result);
			}
			else if($type == 11)
			{
				$image = new Image($id_image);
				if($image->delete())
				{
					echo "0";
				}
				else
				{
					echo "1";
				}
			}
			else if($type == 12)
			{
				$product_id = Tools::getValue('product_id');
				$productObj = new Product(intval($product_id));

				foreach ($_GET as $key => $value) 
				{
					if(preg_match('/^region_([0-9]+)/i', $key, $match)) 
					{
						$price = Tools::getValue($key);
						$zone = new FulfillmentCentre($match[1]);

						if($price > $productObj->price) {
							echo "Buying price exceeds MRP for ".$zone->city_name." zone.";
							return false;
						}

						if($price == 0 OR $price == "") {
							ZonalPrice::removePrice($product_id, $match[1], $price);
						}
						else {
							ZonalPrice::updatePriceByZone($product_id, $match[1], $price);
						}
					}
				}

				$zoneChanges = 0;
				
				echo "success";
			}
			else if($type == 13)
			{
				$data = Competitor::getAllPrices();
				echo Tools::jsonEncode($data);
			}
			else if($type == 14)
			{
				$id_product = Tools::getValue('id_product');
				$name = Tools::getValue('name');
				$amazon = Tools::getValue('amazon');
				$flipkart = Tools::getValue('flipkart');
				$snapdeal = Tools::getValue('snapdeal');				

				if(Competitor::addPrice($id_product,$amazon,$flipkart,$snapdeal)){
					echo "1";
				}
				else
					echo "0";

			}
			else if($type == 15)
			{
				$competitor = new Competitor(Tools::getValue('id_competitors'));
				if($competitor->delete())
					echo "1";
				else
					echo "0";
			}
			else if($type == 16) {
				$available_fc = FulfillmentCentre::getAllFCentres();
				echo Tools::jsonEncode($available_fc);
			}
		}
	}
}
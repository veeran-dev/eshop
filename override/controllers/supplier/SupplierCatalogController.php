 <?php
class SupplierCatalogControllerCore extends FrontController
{
	public function  ajaxReturn(){
		$context = Context::getContext();
 		$type= Tools::getValue('type');
		$file = $_FILES['file']['name'];
		$temp_name  = $_FILES['file']['tmp_name'];
		$id_supplier = $this->context->cookie->s_id;
		if($type==1){
			$supplier = new EliteSupplier($context->cookie->s_id);

			if($file != "" && isset($file)){
				$allowed =  array('xlsx','csv', 'xls');
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				if(!in_array($ext, $allowed)) {
				    echo "1";
				    return false;
				}
				else if($_FILES['file']['size'] > 5120000){
				    echo "2";
				    return false;
				}
				else{
					$file_name = $_FILES['file']['name'];
					$splitName = explode(".", $file);
					$fileExt = end($splitName);
					$file_name = $splitName[0]."_".date('Y-m-d H:m:i');
					
                    
					$filename  = _PS_ROOT_DIR_."/supplier/catalog/".$file_name.".".$fileExt;
					$files = glob($filename);
					if (count($files)) {
					    array_map('unlink', $files);
					}
					if(move_uploaded_file($temp_name, $filename)){
				        $file_size = filesize($filename);
				        $handle = fopen($filename, "r");
				        $content = fread($handle, $file_size);
				        fclose($handle);
				        $attach['content'] = $content;
				        $attach['name'] = $file_name.".".$fileExt;
				        $attach['mime'] = 'application/'.$fileExt;
				        $template = "shareCatalog";
				        $data = array(
				        	'{supplier}' => $supplier->name,
				        	'{mobile}' => $supplier->mobile,
				        	'{mail}' => $supplier->email,
				        	'{date}' => date("Y-m-d H:i:s"));
				        $subject = $supplier->name."'s Catalog Update Request";
				        if(Mail::Send(1, $template, $subject, $data, "support@kobster.com", null,"noreply@kobster.com",$supplier->name."'s Catalog Update Request", $attach, null, null, false, null, null, null, 'divya.d@kobster.com')){
					    echo "4";
					    return false;
				        }
					}
					else{
					    echo "3";
					    return false;
					}
				}
			}
		}
		if($type==2){
			$limit= $_GET['limit'];
			$offset= $_GET['offset'];
			$idPage= $_GET['idPage'];
			$query= $_GET['query'];
			$id_group= $_GET['idGroup'];

			$supplier = new EliteSupplier($id_supplier);

			$limit ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
			$offset = (PAGE_PER_NO * intval($idPage));
			
			$list = $supplier->contractLists($limit, $offset, $query, $id_group);
			$customers = EliteSupplier::getCustomers($id_supplier);
			$contractCount = $supplier->contractCount($query, $id_group);
 			$result = json_encode(
						array(
 							'contract'=> $list, 
							 'customers' => $customers,
							 'contractCount' => $contractCount
						));
 			echo $result;
		}
		if($type==3){
			$limit= $_GET['limit'];
			$offset= $_GET['offset'];
			$idPage= $_GET['idPage'];
			$query= $_GET['query'];

			$supplier = new EliteSupplier($id_supplier);

			$limit ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
			$offset = (PAGE_PER_NO * intval($idPage));
			
			$list = $supplier->productLists($limit, $offset, $query);
			$productCount = $supplier->productCount();
 			$result = json_encode(
						array(
 							'productList'=> $list,
 							'productCount' => $productCount,
						));
 			echo $result;
		}
		if($type == 4){
			echo Tools::jsonEncode(Category::recursive_category_tree());
		}
		if($type == 5){
			echo Tools::jsonEncode(Category::getAllCategoriesName());
		}
		if($type == 6){
			echo Tools::jsonEncode(Manufacturer::getManufacturers());
		}
		if($type == 7){
			echo Tools::jsonEncode(TaxRulesGroup::getTaxRulesGroups());
		}
		if($type == 8){

			$name= Tools::getValue('name');
			$hsn_code= Tools::getValue('hsn_code');
			$price= Tools::getValue('price');
			$moq= Tools::getValue('moq');
			$desc= Tools::getValue('desc');
			$id_category= Tools::getValue('id_category');
			$id_manufacturer= Tools::getValue('id_manufacturer');
			$id_tax_rules_group= Tools::getValue('id_tax_rules_group');			
			$supplier = new EliteSupplier($context->cookie->s_id);

			$link_rewrite = Tools::link_rewrite($name);
			$_POST['width'] = empty($_POST['width']) ? '0' : str_replace(',', '.', $_POST['width']);
			$_POST['height'] = empty($_POST['height']) ? '0' : str_replace(',', '.', $_POST['height']);
			$_POST['depth'] = empty($_POST['depth']) ? '0' : str_replace(',', '.', $_POST['depth']);
			$_POST['weight'] = empty($_POST['weight']) ? '0' : str_replace(',', '.', $_POST['weight']);

			$product = new Product();
			$product->name['1'] = $name;
			$product->hsn_code = $hsn_code;
			$product->price = floatval($price);
			$product->minimal_quantity = $moq;
			$product->description = $desc;
			$product->id_category_default = $id_category;
			$product->id_manufacturer = $id_manufacturer;
			$product->manufacturer_name = Manufacturer::getNameById($id_manufacturer);
			$product->id_tax_rules_group = $id_tax_rules_group;
			$product->link_rewrite['1'] = $link_rewrite;
			$product->available_for_order = 1;
			$product->show_price = 1;
			$product->ecotax = str_replace(',', '.', Tools::getValue('ecotax'));
			$product->save();


			$product->addToCategories($id_category);

			$manufacturer = new Manufacturer($id_manufacturer);
			$manufacturer->associateTo($product->id_shop_list);

			$dbData = array(
	            'id_supplier'=>$supplier->id,
	            'id_product' => $product->id,
	            'out_of_stock' => 0
			);
    		Db::getInstance()->insert('elite_supplier_stock', $dbData);

			$this->addProductImage($product->id, $name);
		}

		if($type == 9){

			$supplier = new EliteSupplier($context->cookie->s_id);
        	$file = $_FILES['file']['name'];
			$temp_name  = $_FILES['file']['tmp_name'];
			$file_name = "bulk-upload-".date("Ymd-His")."-".uniqid();
			$splitName = explode(".", $file);
			$fileExt = end($splitName);
			
			if(count($splitName) > 1)
				$newFileName  = strtolower($file_name.'.'.$fileExt);  
			else
				$newFileName  = strtolower($file_name);

			$inputFileName = _PS_ROOT_DIR_.'/BulkUpload/'.$newFileName;

			if(move_uploaded_file($temp_name, $inputFileName)){
				require_once (_PS_ROOT_DIR_.'/classes/PHPExcel/Classes/PHPExcel.php');
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray();
	        	
	        	$error = "";
	        	$start = false;
	        	if (!defined('PS_MASS_PRODUCT_CREATION')) {
			        define('PS_MASS_PRODUCT_CREATION', true);
			    }
                $logger = new FileLogger();
			    $logger->setFilename('textbo.txt');
			    $logger->logError('=============');
	        	for($i = 0; $i < sizeof($sheetData); $i++){	        				 					
	        		if($sheetData[$i][0] == "PRODUCT NAME" && $sheetData[$i][1] == "DESCRIPTION" && $sheetData[$i][2] == "HSN CODE" && $sheetData[$i][3] == "UNIT PRICE TAX EXCL" && $sheetData[$i][4] == "MINIMAL QUANTITY" && $sheetData[$i][5] == "GST ID" && $sheetData[$i][6] == "CATEGORY ID" && $sheetData[$i][7] == "MANUFACTURER ID" && $sheetData[$i][8] == "IMAGE URL" && $start == false){
	        			$start = true;
	        			continue;
	        		}
	        		if($sheetData[$i][0] != "" && $sheetData[$i][1] != "" && $sheetData[$i][2] != "" && $sheetData[$i][3] != "" && $sheetData[$i][4] != "" && $sheetData[$i][5] != "" && $sheetData[$i][6] != "" && $sheetData[$i][7] != "" && $sheetData[$i][8] != "" && $start == true){
        				
						if(!(ctype_alnum($sheetData[$i][2]) || ctype_alpha($sheetData[$i][2]) || is_numeric($sheetData[$i][2])))
						{
							$start = false;
	        				$error = "Please check the HSN CODE on line no: ".($i+1)." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;
						}
						if(strlen($sheetData[$i][2]) > 9 )
						{
							$start = false;
	        				$error = "Please check the HSN CODE on line no: ".($i+1)." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;
						}
						if(!is_numeric($sheetData[$i][3])){
							$start = false;
	        				$error ="Please check the UNIT PRICE on line no: ".($i+1)." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;	
						}
						if(!is_numeric($sheetData[$i][4]) || $sheetData[$i][4] <= 0){
							$start = false;
	        				$error ="Please check the MINIMAL QUANTITY on line no: ".($i+1)." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;	
						}
						if (!Validate::isLoadedObject(new TaxRulesGroup($sheetData[$i][5]))) {
							$start = false;
	        				$error ="Please check the GST ID on line no: ".($i+1)." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;	
						}
						else{
							$TaxRulesGroup = new TaxRulesGroup($sheetData[$i][5]);
							$logger->logError($TaxRulesGroup);
							if($TaxRulesGroup->active == 0){
								$start = false;
		        				$error ="Please check the GST ID is not active on line no: ".($i+1)." and try again";
		        				$result = json_encode(
											array(
												'error'=> $error, 
											));
			 					echo $result;
		        				return false;			
							}
						}
						if (!Validate::isLoadedObject(new Category($sheetData[$i][6]))) {
							$start = false;
	        				$error ="Please check the CATEGORY ID on line no: ".($i+1)." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;	
						}
						else{
							$category = new Category($sheetData[$i][6]);
							if($category->active == 0){
								$start = false;
		        				$error ="Please check the CATEGORY ID is not active on line no: ".($i+1)." and try again";
		        				$result = json_encode(
											array(
												'error'=> $error, 
											));
			 					echo $result;
		        				return false;			
							}
						}
						if (!Validate::isLoadedObject(new Manufacturer($sheetData[$i][7]))) {
							$start = false;
	        				$error ="Please check the MANUFACTURER ID is on line no: ".($i+1)." and try again";
	        				$result = json_encode(
										array(
											'error'=> $error, 
										));
		 					echo $result;
	        				return false;	
						}
						else{
							$manufacturer = new Manufacturer($sheetData[$i][7]);
							if($manufacturer->active == 0){
								$start = false;
		        				$error ="Please check the MANUFACTURER ID is not active on line no: ".($i+1)." and try again";
		        				$result = json_encode(
											array(
												'error'=> $error, 
											));
			 					echo $result;
		        				return false;			
							}
						}
						if($sheetData[$i][8]){
							$images = explode(',', $sheetData[$i][8]);
			                foreach($images as $img)
			                {
			                    $img=$this->checkRemoteFile($img);
			                    if(!$img)
			                    {
			                    	$start = false;
			        				$error ="Invalid image URL, please use URL which ends with .jpeg, .jpg, .png on line no: ".($i+1)." and try again";
			        				$result = json_encode(
												array(
													'error'=> $error, 
												));
				 					echo $result;
				 					return false;	
			                    }
			                }
						}
	        		}
				}
				
				if($start == false){
					$result = json_encode(
					array(
						'error'=> "Please keep the template as it is and try again", 
					));
 					echo $result;	
 					return false;
				}
				$start = false;
				for($i = 0; $i < sizeof($sheetData); $i++){
	        		if($sheetData[$i][0] == "PRODUCT NAME" && $sheetData[$i][1] == "DESCRIPTION" && $sheetData[$i][2] == "HSN CODE" && $sheetData[$i][3] == "UNIT PRICE TAX EXCL" && $sheetData[$i][4] == "MINIMAL QUANTITY" && $sheetData[$i][5] == "GST ID" && $sheetData[$i][6] == "CATEGORY ID" && $sheetData[$i][7] == "MANUFACTURER ID" && $sheetData[$i][8] == "IMAGE URL" && $start == false){

	        			$start = true;
	        			continue;
	        		}
	        		if($sheetData[$i][0] != "" && $sheetData[$i][1] != "" && $sheetData[$i][2] != "" && $sheetData[$i][3] != "" && $sheetData[$i][4] != "" && $sheetData[$i][5] != "" && $sheetData[$i][6] != "" && $sheetData[$i][7] != "" && $sheetData[$i][8] != "" && $start == true){
        				
        				$link_rewrite = Tools::link_rewrite($sheetData[$i][0]);
        				$categories = explode(',', $sheetData[$i][6]);

        				$product = new Product();
						$product->name['1'] = $sheetData[$i][0];
						$product->description = $sheetData[$i][1];
						$product->hsn_code= $sheetData[$i][2];
						$product->price = $sheetData[$i][3];
						$product->minimal_quantity = $sheetData[$i][4];
						$product->id_tax_rules_group = $sheetData[$i][5];
						
						$product->id_category_default = $categories[0];
						$product->id_manufacturer= $sheetData[$i][7];
						$product->manufacturer_name = Manufacturer::getNameById($sheetData[$i][7]);
						$product->active = 1;
						$product->link_rewrite['1'] = $link_rewrite;
						$product->available_for_order = 1;
						$product->show_price = 1;
						$product->ecotax = str_replace(',', '.', Tools::getValue('ecotax'));
						$product->add();	

						$product->addToCategories($categories);

						$dbData = array(
				            'id_supplier'=>$supplier->id,
				            'id_product' => $product->id,
				            'out_of_stock' => 0
						);
			    		Db::getInstance()->insert('elite_supplier_stock', $dbData);

			    		if($sheetData[$i][8]){
							$images = explode(',', $sheetData[$i][8]);
							$shops = Shop::getContextListShopID();
							foreach ($images as $key => $url) {
		                        $url = trim($url);
		                        if (!empty($url)) {
		                            $url = str_replace(' ', '%20', $url);

		                            $image = new Image();
		                            $image->id_product = (int)$product->id;
		                            $image->position = Image::getHighestPosition($product->id) + 1;
		                            $image->cover = true;
		                            $image->associateTo($shops);
		                            $image->save();

	                                if (!$this->copyImg($product->id, $image->id, $url, 'products', !$regenerate)) {
	                                    $image->delete();
	                                }
		                            
		                        }
		                        
		                    }
		                }
	        		}
				}
				$result = json_encode(
					array(
						'success'=> "You're Products Added to Catalog Successfully", 
					));
 					echo $result;
			}
		}
	}

	public function addProductImage($id_product, $name)
    {
        $product = new Product($id_product);
        $image_uploader = new HelperImageUploader('file');
        $image_uploader->setAcceptTypes(array('jpeg', 'png', 'jpg'))->setMaxSize((int)Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE'));
        $files = $image_uploader->process();
        
        foreach ($files as &$file) {
            $image = new Image();
            $image->id_product = (int)($product->id);
            $image->position = Image::getHighestPosition($product->id) + 1;

            $image->legend['1'] = $name;

            if (!Image::getCover($image->id_product)) {
                $image->cover = 1;
            } else {
                $image->cover = 0;
            }
            
            if (($validate = $image->validateFieldsLang(false, true)) !== true) {
                $file['error'] = Tools::displayError($validate);
            }

            if (isset($file['error']) && (!is_numeric($file['error']) || $file['error'] != 0)) {
                continue;
            }

            if (!$image->add()) {
                $file['error'] = Tools::displayError('Error while creating additional image');
            } else {
                if (!$new_path = $image->getPathForCreation()) {
                    $file['error'] = Tools::displayError('An error occurred during new folder creation');
                    continue;
                }

                $error = 0;

                if (!ImageManager::resize($file['save_path'], $new_path.'.'.$image->image_format, null, null, 'jpg', false, $error)) {
                    switch ($error) {
                        case ImageManager::ERROR_FILE_NOT_EXIST :
                            $file['error'] = Tools::displayError('An error occurred while copying image, the file does not exist anymore.');
                            break;

                        case ImageManager::ERROR_FILE_WIDTH :
                            $file['error'] = Tools::displayError('An error occurred while copying image, the file width is 0px.');
                            break;

                        case ImageManager::ERROR_MEMORY_LIMIT :
                            $file['error'] = Tools::displayError('An error occurred while copying image, check your memory limit.');
                            break;

                        default:
                            $file['error'] = Tools::displayError('An error occurred while copying image.');
                            break;
                    }
                    continue;
                } else {
                    $imagesTypes = ImageType::getImagesTypes('products');
                    $generate_hight_dpi_images = (bool)Configuration::get('PS_HIGHT_DPI');

                    foreach ($imagesTypes as $imageType) {
                        if (!ImageManager::resize($file['save_path'], $new_path.'-'.stripslashes($imageType['name']).'.'.$image->image_format, $imageType['width'], $imageType['height'], $image->image_format)) {
                            $file['error'] = Tools::displayError('An error occurred while copying image:').' '.stripslashes($imageType['name']);
                            continue;
                        }

                        if ($generate_hight_dpi_images) {
                            if (!ImageManager::resize($file['save_path'], $new_path.'-'.stripslashes($imageType['name']).'2x.'.$image->image_format, (int)$imageType['width']*2, (int)$imageType['height']*2, $image->image_format)) {
                                $file['error'] = Tools::displayError('An error occurred while copying image:').' '.stripslashes($imageType['name']);
                                continue;
                            }
                        }
                    }
                }
                unlink($file['save_path']);
                //Necesary to prevent hacking
                unset($file['save_path']);
                if (!$image->update()) {
                    $file['error'] = Tools::displayError('Error while updating status');
                    continue;
                }

                // Associate image to shop from context
                $shops = Shop::getContextListShopID();
                $image->associateTo($shops);

                @unlink(_PS_TMP_IMG_DIR_.'product_'.(int)$product->id.'.jpg');
                @unlink(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$product->id.'_'.$this->context->shop->id.'.jpg');
            }
        }
        return true;
    }
    
    // public function url_exists_checkRemoteFile($url) {
    //     if(@file_get_contents($url,0,NULL,0,1))
    //     {return true;}
    //     else
    //     {return false;}
    // }
    public function checkRemoteFile($url)
    {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        $logger = new FileLogger();
        $logger->setFilename('textbo.txt');
        $logger->logError('check=====>');
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $logger->logError($code);
        $x = curl_exec($ch);
        $logger->logError($x);
        if(strpos($x, '405') !== false)
        {
            return false;
        }
        if($x !==FALSE)
        {
            
            return true;
        }
        else
        {
            return false;
        }
    }

    protected static function copyImg($id_entity, $id_image = null, $url, $entity = 'products', $regenerate = true)
    {
        $logger = new FileLogger();
        $logger->SetFilename('textbo.txt');
        $logger->logError('copy image');
        
        $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
        $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));

        switch ($entity) {
            default:
            case 'products':
                $image_obj = new Image($id_image);
                $path = $image_obj->getPathForCreation();
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
            $logger->logError("===> image failed");
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
}
<?php
/*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14006 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class SettingsControllerCore extends FrontController
{
	public function ajaxReturn()
	{
		global $cookie;
		$type = Tools::getValue('type');
		$file = $_FILES['file']['name'];
		$temp_name  = $_FILES['file']['tmp_name'];
		
		if($type == 1) {
			if($file != "" && isset($file)){
				$allowed =  array('jpg', "JPG", "JPEG",'png', "PNG", "svg", "SVG");
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				if(!in_array($ext, $allowed) ) {
				    echo 1; // File format not supported
				}
				else{
					if($_FILES['file']['size'] > 512000)
						echo 2; // Size is too large
					else{
						$customerObj = new Customer((int)($cookie->id_customer));
						$file_name = $customerObj->id_default_group;
						$splitName = explode(".", $file);
						$fileExt = end($splitName);
						if(count($splitName) > 1)
							$newFileName  = strtolower($file_name.'.'.$fileExt);  
						else
							$newFileName  = strtolower($file_name);

						$location = "img/logo"; 

						$logos = glob($location."/".$file_name.'.*');
						if (count($logos)) {
						    array_map('unlink', $logos);
						}

						if(!move_uploaded_file($temp_name, "$location/$newFileName"))
							echo 3; // Upload error
						else 
						{
							$image = file_get_contents(_PS_ROOT_DIR_.'/img/logo/'.$newFileName);
							$imageObject = imagecreatefromstring($image);
							imagepng($imageObject, _PS_ROOT_DIR_.'/img/logo/'.$file_name.".png");
							if(!file_get_contents(_PS_ROOT_DIR_.'/img/logo/'.$file_name.".png"))
								unlink(_PS_ROOT_DIR_.'/img/logo/'.$newFileName);
							echo 0;
						}
					}
				}
			}
		}
		else if($type == 2) {
			$customerObj = new Customer((int)($cookie->id_customer));
			$file_name = $customerObj->id_default_group;
			$logos = glob("img/logo/".$file_name.'.*');
			echo $logos[0];
		}
		else if($type == 3) {
			$oldPassword = Tools::getValue('oldPassword');
			$newPassword = Tools::getValue('newPassword');

			$customerObj = new Customer((int)($cookie->id_customer));


			if(Tools::encrypt($oldPassword) != $customerObj->passwd) {
				echo 0;
			}
			else {
				$customerObj->passwd = Tools::encrypt($newPassword);
				if($customerObj->update()) {
					$params = array(
	                    '{email}' => $customerObj->email,
	                    '{lastname}' => $customerObj->lastname,
	                    '{firstname}' => $customerObj->firstname,
	                    '{passwd}' => $newPassword
	                );

	                Mail::Send(1, 'password', Mail::l('Your new password', 1), $params, $customerObj->email, $customerObj->firstname.' '.$customerObj->lastname);

					echo 1;
				}
			}
		}
		else if($type == 4) {
			$purchaseOrderObj = new PurchaseOrder();
			$customerObj = new Customer((int)($cookie->id_customer));
			$purchaseOrderOptions = $purchaseOrderObj->getAllPoOptions($customerObj->id_default_group);
			echo Tools::jsonEncode($purchaseOrderOptions);
		}
		else if($type == 5) {
			$purchaseOrderObj = new PurchaseOrder();
			$id_option = Tools::getValue('id_po_option');
			$setOption = $purchaseOrderObj->setPoOption(intval($cookie->id_customer), $id_option);
			$this->context->cookie->budget_option = $id_option;
			$this->context->cookie->id_address_budget = "";
	 		$this->context->cookie->id_address_delivery = "";
	 		$this->context->cookie->id_purchase_order = "";
	 		$this->context->cookie->po_number = "";
			// Delete cart associations to avoid using already added cart with products.
			$cart = new Cart(self::$cookie->id_cart);
			$cart->deleteAssociations();	
			echo Tools::jsonEncode($setOption);
		}
 	}
}
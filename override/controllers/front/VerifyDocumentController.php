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

class VerifyDocumentControllerCore extends FrontController
{
	public $php_self = 'verify-document.php';
	public $ssl = true;
	public $auth = true;
	public $guestAllowed = true;
	public $authRedirection = 'verify-document.php';

	public function preProcess()
	{
		parent::preProcess();

		if (Tools::isSubmit('submitDocument'))
		{
			$file = $_FILES['uploadBuyerDocument']['name'];
			$temp_name  = $_FILES['uploadBuyerDocument']['tmp_name'];

			if(isset($file))
			{
				$allowed =  array('gif','png' ,'jpg','docx','doc','pdf','rtf','zip');
				$filename = $_FILES['uploadBuyerDocument']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(!in_array($ext,$allowed) ) {
				    $this->errors[] = Tools::displayError('Please Upload Valid Document');
				}
				else
				{
					if($_FILES['uploadBuyerDocument']['size'] > (5 * 1024 * 1024))
					{
						$this->errors[] = Tools::displayError('Please Upload a Document less than 5 MB size');
					}
					else
					{
						$customer = new Customer(self::$cookie->id_customer);
					
							$file_name = $customer->id."-".$customer->firstname;
							$splitName = explode(".", $file);
							$fileExt = end($splitName);
							$newFileName  = strtolower($file_name.'.'.$fileExt);  		
							$location = "Buyer_Verification_Document"; 
								move_uploaded_file($temp_name, "$location/$newFileName");		
						
						$customer->verification_document = $file;
						$customer->verification_status = 1;
						$customer->update();

						if (!$customer->update())
									$this->errors[] = Tools::displayError('An error occurred while uploading your document.');
						else
							self::$smarty->assign('confirmation', "Your document was uploaded successfully and being processed.");
									
						if (count($this->errors) > 1)
							array_unique($this->errors);
					}
				}
			}
			else
			{
				$this->errors[] = Tools::displayError('Please Upload a Document');
			}
		}
	}

	public function setMedia()
	{
		parent::setMedia();
		Tools::addCSS(_THEME_CSS_DIR_.'contact-form.css');
	}

	public function process()
	{
		parent::process();

		$email = Tools::safeOutput(Tools::getValue('from'));
		self::$smarty->assign(array(
			'errors' => $this->errors,
			'email' => $email
		));
	}

	public function displayContent()
	{
		$_POST = array_merge($_POST, $_GET);
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'verify-document.tpl');
	}

	public function verifyBuyer()
	{
		$customer = new Customer($_GET['id_customer']);

		if($customer->verification_document)
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
}


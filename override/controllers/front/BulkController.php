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

class BulkControllerCore extends FrontController
{
	public $php_self = 'corporate-bulk.php';
	public $ssl = true;

	public function preProcess()
	{
		parent::preProcess();
		
		if (Tools::isSubmit('submitMessage'))
		{
			$email =  Tools::getValue('email');
			$name =  Tools::getValue('name');
			$mobile =  Tools::getValue('phone');
			$org_name =  Tools::getValue('org_name');
			$designation =  Tools::getValue('designation');
			$office_phone =  Tools::getValue('land_line');
			$extn =  Tools::getValue('extn');
			$noofemp =  Tools::getValue('noofemp');
			$address1 =  Tools::getValue('addressline1');
			$address2 =  Tools::getValue('addressline2');
			$city =  Tools::getValue('city');
			$id_state =  Tools::getValue('id_state');
			$min_pur =  Tools::getValue('minamt');
			$max_pur =  Tools::getValue('maxamt');
			$dur =  Tools::getValue('category');
			
			self::$smarty->assign('sl_id_state', $id_state);
			self::$smarty->assign('sl_dur', $dur);
				
			if (!($email = trim(Tools::getValue('email'))) OR !Validate::isEmail($email))
				$this->errors[] = Tools::displayError('Invalid e-mail address');
			elseif (!($name = nl2br2($name)))
				$this->errors[] = Tools::displayError('Name cannot be blank');
			elseif (!($email = nl2br2($email)))
				$this->errors[] = Tools::displayError('Email cannot be blank');
			elseif (!($org_name = nl2br2($org_name)))
				$this->errors[] = Tools::displayError('Organization name can not be blank');
			elseif (!($designation = nl2br2($designation)))
				$this->errors[] = Tools::displayError('Designation can not be blank');
			elseif (!Validate::isCleanHtml($org_name))
				$this->errors[] = Tools::displayError('Invalid organization name');
			else
			{
				$credit = new Credit();
				
				$credit->email	=	$email;
				$credit->name	=	$name;
				$credit->mobile	=	$mobile;
				$credit->org_name	=	$org_name;
				$credit->designation	=	$designation;
				$credit->office_phone	=	$office_phone;
				$credit->extn	=	$extn;
				$credit->noofemp	=	$noofemp;
				$credit->address1	=	$address1;
				$credit->address2	=	$address2;
				$credit->city	=	$city;
				$credit->id_state	=	$id_state;
				$credit->min_pur	=	$min_pur;
				$credit->max_pur	=	$max_pur;
				$credit->dur	=	$dur;

				
				if (!empty($credit->email))
				{
					if (Mail::Send((int)self::$cookie->id_lang, 'bulk', Mail::l('Message for Coporate/Bulk account', (int)self::$cookie->id_lang), 
					array('{email}'	=>	$email,
							'{name}'	=>	$name,
							'{mobile}'	=>	$mobile,
							'{org_name}'	=>	$org_name,
							'{designation}'	=>	$designation,
							'{office_phone}'	=>	$office_phone,
							'{extn}'	=>	$extn,
							'{noofemp}'	=>	$noofemp,
							'{address1}'	=>	$address1,
							'{address2}'	=>	$address2,
							'{city}'	=>	$city,
							'{min_pur}'	=>	$min_pur,
							'{max_pur}'	=>	$max_pur,
							'{dur}'	=>	$dur),
					'admin@kobster.com', 'Credit', 'admin@kobster.com', $credit->id_credit, NULL)){
					
					Mail::Send((int)self::$cookie->id_lang, 'bulk_cust', Mail::l('Bulk Purchase/Corporate Account Application Received', (int)self::$cookie->id_lang), 
					array('{email}'	=>	$email,
							'{name}'	=>	$name),
					$email, 'Credit', 'admin@kobster.com', $credit->id_credit, NULL);
					
						$confirmation = 1;
					}
					else{
						$this->errors[] = Tools::displayError('An error occurred while sending message.');
						$confirmation = 0;
					}
				}

				if (!$credit->add()){
					$this->errors[] = Tools::displayError('An error occurred while sending your message.');
					$confirmation = 0;
				}
				
				self::$smarty->assign('confirmation', $confirmation);
				
				if (count($this->errors) > 1)
					array_unique($this->errors);
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
		
		$states = State::getStatesByIdCountry(110);
				
		$email = Tools::safeOutput(Tools::getValue('from'));
		self::$smarty->assign(array(
			'errors' => $this->errors,
			'email' => $email,
			'states' => $states
		));
	}

	public function displayContent()
	{
		$_POST = array_merge($_POST, $_GET);
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'corporate-bulk.tpl');
	}
	
	public function processBulkRequest()
	{	
		$bulkReq = new BulkRequest();
		$bulkReq->id_product = Tools::getValue('id_product');
		$bulkReq->product_name = Tools::getValue('product_name');
		$product_code = new Product($bulkReq->id_product);
		$logged = (int)Tools::getValue('logged');
		$customer = new Customer();
		
		if($logged == 0)
		{
			$email = Tools::getValue('bq_email');
			$password = Tools::getValue('bq_password');
			$authentication = $customer->getByEmail(trim($email), trim($password));
		}
		else
		{
			$authentication = true;
			$customer = new Customer((int)Tools::getValue('bq_id_customer'));
		}
		
		if (!$authentication OR !$customer->id)
		{
			/* Handle brute force attacks */
			sleep(1);
			echo "0";
		}
		else
		{
			$bulkReq->id_customer = $customer->id;
			$bulkReq->quantity = Tools::getValue('bq_quantity');
			$bulkReq->quantity_unit = Tools::getValue('bq_qty_unit');
			$bulkReq->delivery_pincode = Tools::getValue('bq_pincode');
			$bulkReq->credit = Tools::getValue('bq_credit');
			$bulkReq->other_details = Tools::getValue('bq_other_details');
			$bulkReq->target_price = Tools::getValue('bq_target_price');
			$bulkReq->target_price_currency = Tools::getValue('bq_select_price');
			
			if($bulkReq->add())
			{
				if($bulkReq->credit == 1)
				{
					$bulkReq->credit = "Yes";
				}
				else
				{
					$bulkReq->credit = "No";
				}
				if (isset($customer->mobile))
					$mobile=$customer->mobile;
				else
					$mobile='NULL';

				$data = array(
					'{firstname}' => $customer->firstname,
					'{email}' => $customer->email,
					'{phone}' => $mobile,
					'{product_name}' => $bulkReq->product_name,
					'{estimated_quantity}' => $bulkReq->quantity." ".$bulkReq->quantity_unit,
					'{pin_code}' => $bulkReq->delivery_pincode,
					'{target_price}' => $bulkReq->target_price." (Tax Included)",
					'{credit}' => $bulkReq->credit,
					'{other_details}' => $bulkReq->other_details,
					'{product_code}' => $product_code->reference
				);
				
				Mail::Send(1, 'edge-request-received', Mail::l('Quotation Request Received', 1), $data, $customer->email, $customer->firstname, NULL, NULL, NULL);
				Mail::Send(1, 'edge-request-received-internal', Mail::l('Price Quote Request Received', 1), $data, 'sales@kobster.com', 'Edge Request', NULL, NULL, NULL);
				
				if(isset($customer->mobile))
				{
					$msgtxt = 'Hello '.$customer->firstname.', a price quote request has been received & is being processed. - Kobster.com';
					SMSAlert::sendSMSAlert($customer->mobile, $msgtxt);
				}

				echo "1";
			}
			else
				echo "0";
		}
	}
}
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

class CustomerFeedbackControllerCore extends DashController
{
	public function ajaxReturn()
	{
		global $cookie;

		$type = Tools::getValue('type');
		$id_customer = (int)(self::$cookie->id_customer);
		$reaction = Tools::getValue('reaction');
		$message = Tools::getValue('message');
		
		if($type == 1) {
			$id_supplier = $this->context->cookie->s_id;

			$customerFeedbackObj = new CustomerFeedback();
			$customerFeedbackObj->id_customer = $id_customer;
			if($id_supplier){
				$customerFeedbackObj->id_supplier = $id_supplier;
			}
			$customerFeedbackObj->reaction = $reaction;
			$customerFeedbackObj->message = $message;
			if($customerFeedbackObj->add()) {
				if($id_supplier){
					$supplier = new EliteSupplier($id_supplier);
					Mail::Send(1, 'feedback', Mail::l('Feedback from Kobster Supplier', 1), 
										array(
											'{name}' => $supplier->name,
											'{email}' => $supplier->email,
											'{message}' => $message
										), 'feedback@kobster.com');
				}
				else{
					// Send Mail to feedback@kobster.com
					$customerObj = new Customer((int)($id_customer));

					Mail::Send(1, 'feedback', Mail::l('Feedback from Kobster Elite', 1), 
										array(
											'{name}' => $customerObj->firstname." ".$customerObj->lastname,
											'{email}' => $customerObj->email,
											'{message}' => $message
										), 'feedback@kobster.com');
				}

				echo 1;
			}
			else {
				echo 0;
			}
		}
	}

}
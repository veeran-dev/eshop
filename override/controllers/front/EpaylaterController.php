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

class EpaylaterControllerCore extends FrontController
{
	public function ajaxReturn()
	{
		global $cookie;
		$type = Tools::getValue('type');

		if(isset($type)) 
		{
			$customerIsLogged = $cookie->id_customer && $cookie->id_customer != "" ? true : false;
			$orderValue = (float)$this->context->cart->getOrderTotal(true, Cart::BOTH);
        	define("_DATE_", gmDate("Y-m-d\TH:i:s\Z"));
			$categoryOfOrder = Tools::getValue('category');
			$id_shipping_address = Tools::getValue("id_shipping_address");
			$epaylater_id = Tools::getValue("epaylater_id");
			$id_shipping_address = $id_shipping_address != undefined && $id_shipping_address != "" ? $id_shipping_address : $this->context->cart->id_address_delivery;
			// Initialize customer object
			$customerObj = new Customer((int)($cookie->id_customer));
			// Initialize address object
			$addressObj = new Address((int)($id_shipping_address));

			$epaylaterObj = new Epaylater();

			$deviceType = $epaylaterObj->getDeviceType();
			$deviceClient = $_SERVER['REMOTE_ADDR'];

			$deviceInformation = array("deviceType" => $deviceType,
			 "deviceClient" => $_SERVER['HTTP_USER_AGENT'],
			 "deviceNumber" => $_SERVER['REMOTE_ADDR'],
			 "deviceId" => "",
			 "deviceMake" => "",
			 "deviceModel" => "",
			 "osVersion" => "");

			$customerAddress = array("line1" => $addressObj->address1,
			 "line2" => "",
			 "line3" => "",
			 "city" => $addressObj->city,
			 "postcode" => $addressObj->postcode);

			$orderHistory = array(array( 
		        "amount" => (int)($orderValue) * 100, 
		        "currencyCode" => "INR", 
		        "date" => _DATE_, 
		        "category" => "ELECTRONICS", 
		        "paymentMethod" => "EPAYLATER", 
		        "returned" => "", 
		        "returnReason" => "", 
		        "address" => $customerAddress, 
		        "device" => $deviceInformation
		    ));

			$customerInfo = array(
				"firstName" => $customerObj->firstname,
				"lastName" => $customerObj->lastname,
				"emailAddress" => $customerObj->email,
				"telephoneNumber" => $customerObj->mobile
			);

			$marketplaceSpecificSectionData = array("marketplaceCustomerId" => $customerObj->id);
			
			if($type == 1) // Request to get eligibility of a customer
			{
				$epaylaterObj->customerLoggedin = $customerIsLogged;
				$epaylaterObj->customerEmailVerified = true;
				$epaylaterObj->customerMobileVerified = true;
				$epaylaterObj->customerWorthy = true;
				$epaylaterObj->date = _DATE_;
				$epaylaterObj->amount = (int)($orderValue) * 100;
				$epaylaterObj->category = "ELECTRONICS";
				$epaylaterObj->customer = $customerInfo;
				$epaylaterObj->address = $customerAddress;
				$epaylaterObj->device = $deviceInformation;
				$epaylaterObj->orderHistory = $orderHistory;
				$epaylaterObj->marketplaceSpecificSection = $marketplaceSpecificSectionData;

				// Upload customer info into epaylater
				if(!$customerObj->epaylater) {
					$epayLaterUploadInfo = $epaylaterObj->uploadCustomerInfo();
					if($epayLaterUploadInfo) {
						$customerObj->epaylater = 1;
						$customerObj->update();
					}
				}

				$result = $epaylaterObj->getCustomerEligibility();
				echo $result;
			}
			else if($type == 2) { // Send OTP to user
				$epaylaterObj->id = $epaylater_id;
				$epaylaterObj->customerWorthy = true;
				$epaylaterObj->customerLoggedin = true;
				$epaylaterObj->customerEmailVerified = true;
				$epaylaterObj->amount = (int)($orderValue) * 100;
				$epaylaterObj->date = _DATE_;
				$epaylaterObj->customer = $customerInfo;
				$epaylaterObj->address = $customerAddress;
				$epaylaterObj->paylater = true;
				$epaylaterObj->status = "agreed";
				$epaylaterObj->statusDate = _DATE_;
				$epaylaterObj->category = "ELECTRONICS";
				$result = $epaylaterObj->sendOTP();
				echo $result;
			}
		}
 	}
}
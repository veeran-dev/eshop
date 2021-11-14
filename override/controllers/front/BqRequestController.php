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
class BqRequestControllerCore extends FrontController
{
	public function ajaxReturn()
	{	
		global $smarty;

		if(isset($_GET['type'])){
			if($_GET['type'] == 1)
			{
				$bulk_data = new BulkRequest();
				$smarty->assign('bq_array',Tools::jsonEncode($bulk_data->getBulkDataForScn()));
				$smarty->display('scn/scn-bq-request.tpl');
			}
			if($_GET['type'] == 2){
				$vendors = ProductVendorMapping::getVendors($_GET['id_product']);
				echo Tools::jsonEncode($vendors);
			}
		}
		
		if(isset($_POST['type'])){
			if($_POST['type'] == 1){
				$vendors = ProductVendorMapping::getVendors($_POST['id_product']);
				$mail = array();
				$sms = array();
				foreach ($vendors as $result) {
					if($result['email']){
						Mail::Send(1, 'edge-bq-for-vendor', Mail::l('Please find below Requirement for the Product from Kobster.com.', 1), 
									array(
										'{firstname}' => $result['poc_name'],
										'{email}' => $result['email'],
										'{phone2}' => $result['phone2'],
										'{product_name}' => $result['product_name'],
										'{quantity}' => $result['qty'],
										'{unit}' => $result['qty_unit']
									), $result['email'], $result['poc_name'], NULL, NULL, NULL);
				    }
					if($result['phone2']){
						SMSAlert::sendSMSAlert($result['phone2'],'Hello '.$result['poc_name'].' Requirement for the Product of '.$result['product_name'].' in '.$result['qty'].' '.$result['qty_unit'].'. - Kobster.com');
					}
				}

				$bq_table = new BulkRequest((int)($_POST['bq_id']));
				$bq_table->triggered = 1;
				$bq_table->update();
			}
		    if($_POST['type'] == 2){
				$data = array(
						'{name}' => $_POST['c_name'],
						'{company}' => $_POST['c_company'],
						'{email}' => $_POST['c_email'],
						'{message}' => $_POST['c_message']
					);
				Mail::Send(1, 'edge-feedback', Mail::l('Feedback for your Kobster Edge', 1), $data, 'sales@kobster.com', 'Edge Feedback', NULL, NULL, NULL);
				Mail::Send(1, 'edge-feedback', Mail::l('Feedback for your Kobster Edge', 1), $data, 'partners@kobster.com', 'Edge Feedback', NULL, NULL, NULL);
			}
		}
	}

	public function edgeProcessBqRequest()
	{
		$bulkReq = new BulkRequest();
		$bulkReq->id_product = $_POST['id_product'];
		$bulkReq->product_name = $_POST['product_name'];
		$product_code = new Product($bulkReq->id_product);
		$logged = (int)$_POST['logged'];
		
		if($logged == 0)
		{
			$customer = new Customer();
			$email = $_POST['acc_email'];
			$password = $_POST['acc_pass'];
			$authentication = $customer->getByEmail(trim($email), trim($password));
		}
		else
		{
			$authentication = true;
			$customer = new Customer((int)$_POST['bq_id_customer']);
			// $logger = new FileLogger();
			// $logger->setFilename('test.txt');
			// $logger->logError("-------bq_id--------".$_POST['bq_id_customer']);
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
			$bulkReq->quantity = $_POST['est_qty'];
			$bulkReq->quantity_unit = $_POST['qty_type'];
			$bulkReq->delivery_pincode = $_POST['pin_code'];
			$bulkReq->credit = $_POST['credit'];
			$bulkReq->other_details = $_POST['message-text'];
			$bulkReq->target_price = $_POST['tar_price'];
			$bulkReq->target_price_currency = 'inr';
						
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
				
				$data = array(
					'{firstname}' => $customer->firstname,
					'{email}' => $customer->email,
					'{phone}' => $customer->mobile,
					'{product_name}' => $bulkReq->product_name,
					'{estimated_quantity}' => $bulkReq->quantity,
					'{pin_code}' => $bulkReq->delivery_pincode,
					'{target_price}' => $bulkReq->target_price,
					'{credit}' => $bulkReq->credit,
					'{other_details}' => $bulkReq->other_details,
					'{product_code}' => $product_code->reference
				);
				
				Mail::Send(1, 'edge-request-received', Mail::l('Price Quote Request Received', 1), $data, $customer->email, $customer->firstname, NULL, NULL, NULL);
				Mail::Send(1, 'edge-request-received-internal', Mail::l('Price Quote Request Received', 1), $data, 'sales@kobster.com', 'Edge Request', NULL, NULL, NULL);
				if($customer->mobile)
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
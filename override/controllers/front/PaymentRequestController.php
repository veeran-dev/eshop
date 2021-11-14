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
*  @version  Release: $Revision: 14007 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
class PaymentRequestControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		global $smarty;

		$type = !empty(Tools::getValue('type')) ? Tools::getValue('type') : "";
		$id_vendor = !empty(Tools::getValue('id_vendor')) ? Tools::getValue('id_vendor') : "";
		$id_bank = !empty(Tools::getValue('id_bank')) ? Tools::getValue('id_bank') : "";
		$id_order = !empty(Tools::getValue('id_order')) ? Tools::getValue('id_order') : "";
		$amount = !empty(Tools::getValue('amount')) ? Tools::getValue('amount') : "";
		$comments = !empty(Tools::getValue('comments')) ? Tools::getValue('comments') : "";
		$id_request = !empty(Tools::getValue('id_request')) ? Tools::getValue('id_request') : "";
		$reject = !empty(Tools::getValue('reject')) ? Tools::getValue('reject') : "";
		$corporate_bank = !empty(Tools::getValue('corporate_bank')) ? Tools::getValue('corporate_bank') : "";

		/* Get Vendor Details for create starts here */
		$vendor_name = !empty(Tools::getValue('vendorName')) ? Tools::getValue('vendorName') : "";
		$gst_no = !empty(Tools::getValue('gstNo')) ? Tools::getValue('gstNo') : ""; 
		$pan_no = !empty(Tools::getValue('panNo')) ? Tools::getValue('panNo') : "";
		$phone = !empty(Tools::getValue('phone')) ? Tools::getValue('phone') : "";
		$website = !empty(Tools::getValue('website')) ? Tools::getValue('website') : "";
		$credit_days = !empty(Tools::getValue('credit_days')) ? Tools::getValue('credit_days') : "";
		$id_fc = !empty(Tools::getValue('id_fc')) ? Tools::getValue('id_fc') : "";
		$payment_mode = !empty(Tools::getValue('payment_mode')) ? Tools::getValue('payment_mode') : "";
		$delivery = !empty(Tools::getValue('deliveryAvailable')) ? Tools::getValue('deliveryAvailable') : "";
		$replacement = !empty(Tools::getValue('replaceAvailable')) ? Tools::getValue('replaceAvailable') : "";
		/* Get Vendor Details for create ends here */

		/*Get Vendor bank details starts */
		$bank_name = !empty(Tools::getValue('bankName')) ? Tools::getValue('bankName') : "";
		$branch = !empty(Tools::getValue('bankBranch')) ? Tools::getValue('bankBranch') : "";
		$acc_holder = !empty(Tools::getValue('accountHolder')) ? Tools::getValue('accountHolder') : "";
		$acc_number = !empty(Tools::getValue('accountNumber')) ? Tools::getValue('accountNumber') : "";
		$ifsc_code = !empty(Tools::getValue('ifscCode')) ? Tools::getValue('ifscCode') : "";
		$acc_type = !empty(Tools::getValue('acc_type')) ? Tools::getValue('acc_type') : "";
		/*Get Vendor bank details ends */

		/*Getting filter parameters starts*/
		$req_made_string = !empty(Tools::getValue('req_made_by')) ? Tools::getValue('req_made_by') : "";
		$req_from_date = !empty(Tools::getValue('req_from_date')) ? Tools::getValue('req_from_date') : "";
		$req_to_date = !empty(Tools::getValue('req_to_date')) ? Tools::getValue('req_to_date') : "";
		$ven_city = !empty(Tools::getValue('city')) ? Tools::getValue('city') : "";
		$reference = !empty(Tools::getValue('reference')) ? Tools::getValue('reference') : "";
		$status = !empty(Tools::getValue('status')) ? Tools::getValue('status') : "";
		/* Getting filter parameters ends */

		$bank_detail = ScnVendorInfo::getBankDetails(NULL, $id_vendor);
		$fullfillment_centre = FulfillmentCentre::getAllFCentres();
		$payment_modes = ScnVendorInfo::getPaymentMode();
		$vendor_array = ScnVendorInfo::getVendorDetails($id_vendor);
		$currency = Currency::getDefaultCurrency();
		$corporate_bank_details = CorporateBankDetails::getAllBankDetails();

		if(isset($type))
		{
			if($type == 0) // Load Payment Request template
			{
				$smarty->assign(array('fc_array' => $fullfillment_centre, 'payment_array' => $payment_modes, 'corporate_bank_details' => $corporate_bank_details));
				$smarty->display('scn/scn-payment-request.tpl');
			}
			elseif($type == 1) //Get Vendor Bank Details for selected vendor
			{
				$smarty->assign(array('vendor_bank_array' => $bank_detail, 'fc_array' => $fullfillment_centre, 'payment_array' => $payment_modes, 
									  'vendor_array' => $vendor_array, 'corporate_bank_details' => $corporate_bank_details));
				$smarty->display('scn/scn-payment-request.tpl');
			}
			elseif($type == 2) //Show bank detail for selected bank
			{
				$bank_array = ScnVendorInfo::getBankDetails($id_bank, $id_vendor);
				$smarty->assign(array('bank_array' => $bank_array, 'vendor_bank_array' => $bank_detail, 'fc_array' => $fullfillment_centre, 
									  'payment_array' => $payment_modes, 'vendor_array' => $vendor_array, 'corporate_bank_details' => $corporate_bank_details));
				$smarty->display('scn/scn-payment-request.tpl');
			}
			elseif($type == 3) // Add New Payment Request
			{
				$payment_req = new PaymentRequest();
				$payment_req->id_vendor = $id_vendor;
				$payment_req->id_bank = $id_bank;
				$payment_req->order_numbers = $id_order;
				$payment_req->amount = $amount;
				$payment_req->comments = $comments;
				$payment_req->req_made_by = self::$cookie->id_employee;
				$payment_req->date_add = date("Y-m-d H:i:s");
				$payment_req->date_upd = date("Y-m-d H:i:s");

				if($payment_req->add())
					echo 1;
			}
			elseif($type == 4) // Add New Vendor
			{
				$vendor  = new ScnVendorInfo();
				$vendor->name = $vendor_name;
				$vendor->gst = $gst_no;
				$vendor->id_payment = $payment_mode;
				$vendor->credit_days = $credit_days;
				$vendor->website = $website;
				$vendor->replacement = $replacement;
				$vendor->comments = $vendor_comment;
				$vendor->delivery = $delivery;
				$vendor->pan = $pan_no;
				$vendor->phone = $phone;
				$vendor->id_fulfillment_centre = $id_fc;
				$vendor->date_add = date('Y:m:d H:i:s');
				if($vendorId = $vendor->addVendor()) {
					echo Tools::jsonEncode($vendorId);
				}
			}
			elseif($type == 5) // Add New Bank Detail
			{
				$vendorBankDetails = ScnVendorInfo::addBankDetails($bank_name,$branch,$bankAddress = NULL,$acc_holder,$acc_type,$acc_number,$ifsc_code,$id_vendor,$vendorAddress = NULL);
				echo Tools::jsonEncode($id_vendor);
			}
			elseif($type == 6) //Finance Payment request data fetching
			{
				$payment_req_detail = PaymentRequest::getPaymentRequests($id_request, $req_made_string, $req_from_date, $req_to_date, $ven_city, $id_fc, $id_employee = false, $status, $vendor_name);
				for($i = 0; $i < sizeof($payment_req_detail); $i++)
					$payment_req_detail[$i]['amount'] = Product::convertAndFormatPrice($payment_req_detail[$i]['amount'], $currency);
				$smarty->assign(array('req_details' => $payment_req_detail, 'fc_array' => $fullfillment_centre, 'corporate_bank_details' => $corporate_bank_details));
				$smarty->display('finance/finance-payment-requests.tpl');
			}
			elseif($type == 7) //Get specific payment details for view
			{
				$payment_req_detail = PaymentRequest::getPaymentRequests($id_request, $req_made_string, $req_from_date, $req_to_date, $ven_city, $id_fc, $id_employee = false, $status, $vendor_name);

				for($i = 0; $i < sizeof($payment_req_detail); $i++){
					if($payment_req_detail[$i]['order_numbers'] != 'NA')
					{
    					$orders_arr = explode(",", $payment_req_detail[$i]['order_numbers']);					
    					$orders="";
    					foreach($orders_arr as $order){
    						$orders .="<a href='kobster_admin/index.php?tab=AdminOrders&id_order=".$order."&vieworder&token=fa47c37ac87d8ca50a892867f9dcce34'>".$order."</a>";
    					}
    					$payment_req_detail[$i]['order_numbers'] = $orders;
					}
				}

				echo Tools::jsonEncode($payment_req_detail);
			}
			elseif($type == 8) //Approve and Complete payment
			{
				$payment_req = new PaymentRequest((int)($id_request));
				$payment_req->reference = $reference;
				$payment_req->id_bank_kobster = $corporate_bank;
				$reject == 0 ? $payment_req->status = 1 : $payment_req->status = 2;
				$payment_req->req_completed_by = self::$cookie->id_employee;
				$payment_req->date_upd = date("Y-m-d H:i:s");

				if($payment_req->update())
				{
					$payment_req_detail = PaymentRequest::getPaymentRequests($payment_req->id, $req_made_string, $req_from_date, $req_to_date, $ven_city, $id_fc, $id_employee = false, $status,Null);
					
					$req_made_by = new Employee((int)($payment_req_detail[0]['req_made_by']));
					$req_completed_by = new Employee((int)($payment_req_detail[0]['req_completed_by']));
					$vendor_poc = ScnVendorInfo::getVendorPOC((int)($payment_req_detail[0]['id_vendor']));

					$payment_bank = new CorporateBankDetails((int)($payment_req->id_bank_kobster));


					$account_number_split = substr($payment_req_detail[0]['account_no'], -4);
					$account_num_real = str_pad($account_number_split, strlen($payment_req_detail[0]['account_no']), "X", STR_PAD_LEFT); 

					$data = array(
						'{id_request}' => $payment_req_detail[0]['id_request'],
						'{req_made_by}' => $req_made_by->firstname,
						'{req_completed_by}' => $req_completed_by->firstname,
						'{order_numbers}' => $payment_req_detail[0]['order_numbers'],
						'{amount}' => Tools::convertPrice($payment_req_detail[0]['amount'], $currency),
						'{vendor_name}' => $payment_req_detail[0]['vendor_name'],
						'{comments}' => $payment_req_detail[0]['comments'],
						'{payment_reference}' => $payment_req_detail[0]['reference'],
						'{account_no}' => $account_num_real,
						'{date_paid}' => $payment_req_detail[0]['req_date_upd'],
						'{payment_bank_logo}' => $payment_bank->logo
					);
					
					if($payment_req->status == 1)
					{
						Mail::Send(1, 'payment-approved', Mail::l('Payment Request Completed', 1), $data, $req_made_by->email, $req_made_by->firstname, NULL, NULL, NULL);
						Mail::Send(1, 'vendor-payment-slip', Mail::l('Payment Acknowledgement Alert from Kobster.com', 1), $data, $req_made_by->email, $req_made_by->firstname, NULL, NULL, NULL);
						if($vendor_poc[0]['email'])
							Mail::Send(1, 'vendor-payment-slip', Mail::l('Payment Acknowledgement Alert from Kobster.com', 1), $data, $vendor_poc[0]['email'], $vendor_poc[0]['firstname'], NULL, NULL, NULL);
					}
					elseif($payment_req->status = 2)
						Mail::Send(1, 'payment-rejected', Mail::l('Payment Request Rejected', 1), $data, $req_made_by->email, $req_made_by->firstname, NULL, NULL, NULL);
					
					echo $payment_req->status;
				}
			}
			elseif($type == 9)
			{
				$payment_req_detail = PaymentRequest::getPaymentRequests(false,false,false,false,false,false, $id_employee = self::$cookie->id_employee, false, NULL);
				for($i = 0; $i < sizeof($payment_req_detail); $i++)
					$payment_req_detail[$i]['amount'] = Tools::convertPrice($payment_req_detail[$i]['amount'], $currency);
				$smarty->assign(array('req_details' => $payment_req_detail, 'payment_request_view' => 1, 'fc_array' => $fullfillment_centre, 'corporate_bank_details' => $corporate_bank_details));
				$smarty->display('scn/scn-payment-request.tpl');
			}
			elseif($type == 10)
			{
				$payment_req_detail = PaymentRequest::getPaymentRequests($id_request, $req_made_string, $req_from_date, $req_to_date, false, $id_fc, $id_employee = self::$cookie->id_employee, $status, $vendor_name);
				for($i = 0; $i < sizeof($payment_req_detail); $i++)
					$payment_req_detail[$i]['amount'] = Tools::convertPrice($payment_req_detail[$i]['amount'], $currency);
				$smarty->assign(array('req_details' => $payment_req_detail, 'fc_array' => $fullfillment_centre, 'payment_request_view' => 1, 'corporate_bank_details' => $corporate_bank_details));
				$smarty->display('scn/scn-payment-request.tpl');
			}
			elseif($type == 11){
				$payment_req = new PaymentRequest((int)($id_request));
				$payment_req->status = 3;
				if($payment_req->update())
					echo "1";
			}
		}
	}
}
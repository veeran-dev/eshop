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

class PaymentRequestCore extends ObjectModel
{
	public 		$id_request;

	/** @var integer Vendor ID */
	public		$id_vendor;

	/** @var integer Vendor Bank ID */
	public		$id_bank;

	/** @var integer Kobster Bank ID */
	public		$id_bank_kobster;

	/** @var string Order Numbers */
	public		$order_numbers;

	/** @var integer Amount */
	public		$amount;

	/** @var string comments */
	public 		$comments;

	/** @var integer Requestor ID */
	public 		$req_made_by;

	/** @var integer Status of the Request*/
	public 		$status;

	/** @var integer Request Completed By */
	public 		$req_completed_by;

	/** @var string Payment Reference Number */
	public      $reference;

	/** @var string Object creation date */
	public 		$date_add;

	/** @var string Object last modification date */
	public 		$date_upd;

	protected $tables = array ('payment_request');

	protected 	$table = 'payment_request';
	protected 	$identifier = 'id_request';

	public function getFields()
	{
		parent::validateFields();
		$fields['id_request'] = (int)($this->id_request);
		$fields['id_vendor'] = (int)($this->id_vendor);
		$fields['id_bank'] = (int)($this->id_bank);
		$fields['id_bank_kobster'] = (int)($this->id_bank_kobster);
		$fields['order_numbers'] = $this->order_numbers;
		$fields['amount'] = $this->amount;
		$fields['comments'] = pSQL($this->comments, true);
		$fields['req_made_by'] = (int)($this->req_made_by);
		$fields['status'] = (int)($this->status);
		$fields['req_completed_by'] = (int)($this->req_completed_by);
		$fields['reference'] = $this->reference;
		$fields['date_add'] = pSQL($this->date_add);
		$fields['date_upd'] = pSQL($this->date_upd);	
		return $fields;
	}

	public static function getPaymentRequests($id_request = false, $req_made_string = false, $req_from_date = false, $req_to_date = false, $ven_city = false, $id_fc = false, $id_employee = false, $status = false, $vendor_name)
	{	
		$query = "";
		$query .= $req_made_string ? ' AND emp.`firstname` LIKE "%'.$req_made_string.'%"' : '';
		$query .= $ven_city ? ' AND va.`city` LIKE "%'.$ven_city.'%"' : '';
		if($vendor_name)
			$query .= $vendor_name ? ' AND v.`name` LIKE "%'.$vendor_name.'%"' : '';
		$query .= $id_fc ? ' AND v.`id_fulfillment_centre` = '.$id_fc.'' : '';
		$query .= $id_request ? ' AND pr.`id_request` = '.$id_request.'' : '';
		$query .= $id_employee ? ' AND pr.`req_made_by` = '.$id_employee.'' : '';
		$query .= ($status == 2) ? ' AND pr.`status` = 1' : (($status == 1) ? ' AND pr.`status` = 0' : (($status == 3) ? ' AND pr.`status` = 2' : ''));
		$query .= ($req_from_date && $req_to_date == false) ? ' AND DATE(pr.`date_add`) = "'.$req_from_date.'"' : '';
		$query .= ($req_from_date == false && $req_to_date) ? ' AND DATE(pr.`date_add`) = "'.$req_to_date.'"' : '';
		$query .= ($req_from_date && $req_to_date) ? ' AND DATE(pr.`date_add`) BETWEEN "'.$req_from_date.'" AND "'.$req_to_date.'"' : '';
		 
		return Db::getInstance()->ExecuteS('SELECT pr.*,format(pr.`amount`,2) as request_amount, v.`name` as vendor_name, emp.`firstname` as emp_first_name, emp.`lastname` as emp_last_name,
											fc.`city_name` as fc_city, va.`city` as vendor_city, vbd.*,pr.`date_add` as req_date_add,pr.`date_upd` as req_date_upd
											FROM `'._DB_PREFIX_.'payment_request` pr
											LEFT JOIN `'._DB_PREFIX_.'vendor` v ON pr.`id_vendor` = v.`id_vendor`
											LEFT JOIN `'._DB_PREFIX_.'vendor_address` va ON v.`id_default_address` = va.`id_address`
											LEFT JOIN `'._DB_PREFIX_.'vendor_bank_details` vbd ON pr.`id_bank` = vbd.`id_bank`
											LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` fc ON v.`id_fulfillment_centre` = fc.`id_fulfillment_centre`
											LEFT JOIN `'._DB_PREFIX_.'employee` emp ON pr.`req_made_by` = emp.`id_employee`
											WHERE pr.`status` NOT IN(3) '.$query.' ORDER BY pr.`id_request` DESC LIMIT 500');
	}

	public function getPaymentAckSlip($id_request)
	{
		$payment_request = new PaymentRequest((int)($id_request));
		$payment_bank = new CorporateBankDetails((int)($payment_request->id_bank_kobster));
		$payment_req_detail = PaymentRequest::getPaymentRequests($id_request, false, false, false, false, false, false, false, false);
				for($i = 0; $i < sizeof($payment_req_detail); $i++)
					$payment_req_detail[$i]['amount'] = Product::convertAndFormatPrice($payment_req_detail[$i]['amount'], $currency);

		$account_number_split = substr($payment_req_detail[0]['account_no'], -4);
		$account_num_real = str_pad($account_number_split, strlen($payment_req_detail[0]['account_no']), "X", STR_PAD_LEFT); 

		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			   <head>
			      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			      <title>Kobster - Payment Acknowledgement Slip</title>
			      
			      <style type="text/css">
			         /* Client-specific Styles */
			         #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
			         body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
			         /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
			         .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
			         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  */
			         #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
			         img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
			         a img {border:none;}
			         .image_fix {display:block;}
			         p {margin: 0px 0px !important;}
			         table td {border-collapse: collapse;}
			         table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
			         a {color: #33b9ff;text-decoration: none;text-decoration:none!important;}
			         /*STYLES*/
			         table[class=full] { width: 100%; clear: both; }
			         /*IPAD STYLES*/
			         @media only screen and (max-width: 640px) {
			         a[href^="tel"], a[href^="sms"] {
			         text-decoration: none;
			         color: #33b9ff; /* or whatever your want */
			         pointer-events: none;
			         cursor: default;
			         }
			         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
			         text-decoration: default;
			         color: #33b9ff !important;
			         pointer-events: auto;
			         cursor: default;
			         }
			         table[class=devicewidth] {width: 440px!important;text-align:center!important;}
			         table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
			         img[class=banner] {width: 440px!important;height:220px!important;}
			         img[class=colimg2] {width: 440px!important;height:220px!important;}
			         td[class=footer-spacing] {display: none !important;}
			         img[class=footer-pattern] {width: 440px!important;height:59px!important;}
			         }
			         /*IPHONE STYLES*/
			         @media only screen and (max-width: 480px) {
			         a[href^="tel"], a[href^="sms"] {
			         text-decoration: none;
			         color: #ffffff; /* or whatever your want */
			         pointer-events: none;
			         cursor: default;
			         }
			         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
			         text-decoration: default;
			         color: #ffffff !important; 
			         pointer-events: auto;
			         cursor: default;
			         }
			         table[class=devicewidth] {width: 280px!important;text-align:center!important;}
			         table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
			         img[class=banner] {width: 280px!important;height:140px!important;}
			         img[class=colimg2] {width: 280px!important;height:140px!important;}
			         td[class="padding-top15"]{padding-top:15px!important;}
			         img[class=footer-pattern] {width: 280px!important;height:38px!important;}
			         
			        
			         }
			      </style>
			      <script type="text/javascript" src="finance/js/finance-payment-requests.js"></script>
			   </head>
			   <body onload="javascript:window.print()">  
					<!-- Start of running content -->
					<table width="100%" bgcolor="#f5f5f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
					   <tbody>
					      <tr>
					         <td>
					            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" bgcolor="#ffffff">
					               <tbody>
									<tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                </tr>
									  <tr>
					                     <td align="center" style="font-family: Helvetica, arial, sans-serif; font-size: 20px; line-height:30px; color: #333333; text-align:center; padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">
											<a target="_blank" href="#" style="text-align:center;"><img align="center" width="185" height="40" alt="" border="0" style="border:none; outline:none; text-decoration:none;text-align:center;" src="https://www.kobster.co/product_images/email/img_cdn/logo.png"></a>
										 </td>
					                  </tr>
									  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                </tr>
					                  <tr>
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 20px; line-height:30px; color: #333333; text-align:left; padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">Dear '.$payment_req_detail[0]["vendor_name"].',</td>
					                  </tr>
					                  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                  </tr>
					                  <tr>
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; line-height:24px; color: #333333; text-align:left; padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">We have made an online payment of <span style="color:#DC2D3C;">'.$payment_req_detail[0]["amount"].'</span> with Transaction ID '.$payment_req_detail[0]["reference"].' towards payee '.$payment_req_detail[0]["vendor_name"].' to your <span style="color:#DC2D3C;">Account '.$account_num_real.'</span> on '.$payment_req_detail[0]['req_date_upd'].'.</td>
					                  </tr>
					                  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                  </tr>
					                  <tr>
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; line-height:24px; color: #333333; text-align:left; padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">
					                        Please find the detailed transaction information given below,
					                     </td>
					                  </tr>
					                  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                  </tr>
									  <tr>
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 18px; line-height:24px; color: #333333; font-weight: bold; padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">
					                        Transaction Details
					                     </td>
					                  </tr>
									  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 10px; line-height:10px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                  </tr>
									  <tr>
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; line-height:24px; color: #222222; text-align:left; padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">
											<table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
												<tbody>
													<tr>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">Reference No.</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">'.$payment_req_detail[0]['reference'].'</td>
													</tr>
													<tr>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">Account No.</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">'.$account_num_real.'</td>
													</tr>
													<tr>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">Amount Paid</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">'.$payment_req_detail[0]['amount'].'</td>
													</tr>
													<tr>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">Paid On</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
														<td align="left" valign="top" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; text-align:left">'.$payment_req_detail[0]['req_date_upd'].'</td>
													</tr>
												</tbody>
											</table>
					                     </td>
					                  </tr>
									  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                  </tr>
									  <tr>   
					                     <td align="center" style="font-family: Helvetica, arial, sans-serif; font-size: 18px; line-height:24px; color: #333333; font-weight:bold; text-align:center;padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">Payment was made from</td>
					                  </tr>
									  <tr>   
					                     <td align="center" style="font-family: Helvetica, arial, sans-serif; font-size: 18px; line-height:24px; color: #DC2D3C; text-align:center;">
											<img src="https://www.kobster.co/product_images/email/v1/'.$payment_bank->logo.'" width="226" height="51" align="center">
										 </td>
					                  </tr>
									  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                  </tr>
									  
									  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; line-height:24px; color: #666666;text-align:left;padding-left: 24px; padding-right: 24px; padding-top:0px; padding-bottom: 0px;">Thanks,<br>Kobster.com</td>
					                  </tr>
									  <tr>   
					                     <td align="left" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; line-height:30px; color: #DC2D3C; text-align:left;">&nbsp;</td>
					                  </tr>
					                  
					               </tbody>
					            </table>
					         </td>
					      </tr>
					   </tbody>
					</table>
					<!-- End of running content -->    
				</body>
			</html>';
	}
}
<?php
/**
 * Modified on: 5th August 2016
 * Author: Elumalai K
 * Changes: Pagination Variables, Variables camelCase used
*/

class DashPendingPaymentDataControllerCore extends DashController
{
	public function ajaxReturn()
	{	 
		$customerId = Tools::getValue('id_customer');
		$fromDate = Tools::getValue('fromDate');
		$toDate = Tools::getValue('toDate');
		$duration = Tools::getValue('duration');
		$idPage = Tools::getValue('idPage');
		$filter_status = Tools::getValue('filter_status');
		$limit = Tools::getValue('limit');
		$searchQuery = Tools::getValue('q');
		$offset = Tools::getValue('offset');
		$orderBy = Tools::getValue('orderBy');
		$orderWay = Tools::getValue('orderWay');

		$orderObj = new Order();
		$startMemory = memory_get_usage();
		$currency = Currency::getCurrent();

		$limit && $limit != "" ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
		$offset = ($offset && $offset == 0) ? $offset : (PAGE_PER_NO * $idPage);
		
		$invoice = $orderObj->getAllPendingPayments($customerId, $limit, $offset, $fromDate, $toDate, $duration, $orderBy, $orderWay, $searchQuery, $filter_status);

		if($invoice['results']) {
			for($i=0; $i<sizeof($invoice['results']); $i++){
				$invoice['results'][$i]['invoice_ack'] = $this->getInvoiceFile($invoice['results'][$i]['invoice_number']);
				if($invoice['results'][$i]['dr_file']){

					if(glob('scanedDRs/'.$invoice['results'][$i]['dr_file'])){
						$invoice['results'][$i]['dr_file']	= glob('scanedDRs/'.$invoice['results'][$i]['dr_file']);
					}
					else{
						$invoice['results'][$i]['dr_file']	= $this->getDrAckFile($invoice['results'][$i]['delivery_number'], $invoice['results'][$i]['id_delivery']);
					}
				}
				
				// $invoice['results'][$i]['dr_file'] = $this->getDrAckFile($invoice['results'][$i]['id_delivery']);

				// $invoice['results'][$i]['invoice_number'] = Configuration::get('PS_INVOICE_PREFIX', (int)($this->context->language->id)).sprintf('%06d', $invoice['results'][$i]['invoice_number']);
				$today = date(Configuration::get('PS_INVOICE_PREFIX_DATE'));
		        $date = date($invoice['results'][$i]['invoice_date_a']);
		      //  var_dump(Configuration::get('PS_INVOICE_PREFIX_DATE'));
		      //  var_dump($today);
		      //  var_dump($date);
		      //var_dump(strtotime($today) < strtotime($date));
		        if(strtotime($today) < strtotime($date)){
		            $invoice['results'][$i]['invoice_number'] =FulfillmentCentre::getInvoicePrefix($invoice['results'][$i]['id_fc'])[0]['prefix'].sprintf('%06d',$invoice['results'][$i]['invoice_number']);
		        }
		        else{
		          //  $invoice['results'][$i]['invoice_number'] = Configuration::get('PS_INVOICE_PREFIX').sprintf('%06d', $invoice['results'][$i]['invoice_number']);
		            $invoice['results'][$i]['invoice_number'] = Configuration::get('PS_INVOICE_PREFIX', (int)($this->context->language->id)).sprintf('%06d', $invoice['results'][$i]['invoice_number']);
		        }

				$invoice['results'][$i]['delivery_number'] = Configuration::get('PS_DELIVERY_PREFIX', (int)($this->context->language->id)).sprintf('%06d', $invoice['results'][$i]['delivery_number']);

			}
			$invoice['results'] = array_values($invoice['results']);

			
			$invoice['total'] = ceil($invoice['total'] / PAGE_PER_NO);
		}
		
 		echo Tools::jsonEncode($invoice);

	}
	public function getDrAckFile($dr, $id){
		$delivery = new Delivery($id);

		if($files = glob('scanedDRs/'.$dr.'_*.*')){
			return $files;
		}
		else if($files = glob('scanedDRs/'.$delivery->dr_file_name.'_*.*')){
			return $files;	
		}
		
	}
	public function getInvoiceFile($number)
	{
		if(file_exists('Invoice-ACK/'.$number.'.png'))
		{
			return 'Invoice-ACK/'.$number.'.png';
		}
		else
		{
			return false;
		}
	}
}
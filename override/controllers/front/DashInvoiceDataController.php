<?php
/**
 * Modified on: 5th August 2016
 * Author: Elumalai K
 * Changes: Pagination Variables, Variables camelCase used
*/

class DashInvoiceDataControllerCore extends DashController
{
	public function ajaxReturn()
	{	 
		$customerId = Tools::getValue('id_customer');
		$fromDate = Tools::getValue('fromDate');
		$toDate = Tools::getValue('toDate');
		$duration = Tools::getValue('duration');
		$idPage = Tools::getValue('idPage');

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
		
		$invoice = $orderObj->getAllInvoice($customerId, $limit, $offset, $fromDate, $toDate, $duration, $orderBy, $orderWay, $searchQuery);

		if($invoice['results']) {
			for($i=0; $i<sizeof($invoice['results']); $i++)
				$invoice['results'][$i]['invoice_number'] = Configuration::get('PS_INVOICE_PREFIX', (int)($this->context->language->id)).sprintf('%06d', $invoice['results'][$i]['invoice_number']);

			$invoice['total'] = ceil($invoice['total'] / PAGE_PER_NO);
		}
		
 		echo Tools::jsonEncode($invoice);

	}
}
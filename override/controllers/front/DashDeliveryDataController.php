<?php
class DashDeliveryDataControllerCore extends DashController
{
	public function ajaxReturn()
	{	 
		$cus_id = Tools::getValue('id_customer');
		$fromDate = Tools::getValue('fromDate');
		$toDate = Tools::getValue('toDate');
		$duration = Tools::getValue('duration');
		$searchQuery = Tools::getValue('q');
		$orderBy = Tools::getValue('orderBy');
		$orderWay = Tools::getValue('orderWay');
		$idPage = Tools::getValue('idPage');

		$limit = Tools::getValue('limit');
		$offset = Tools::getValue('offset');

		$order = new Order();
		$start_memory = memory_get_usage();

		$limit && $limit != "" ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
		$offset = ($offset && $offset == 0) ? $offset : (PAGE_PER_NO * $idPage);

		$deliverydata = Order::getAllDeliveryData($cus_id, $limit, $offset, $fromDate, $toDate, $duration, $orderBy, $orderWay, $searchQuery);

		if($deliverydata['results']){
			for($i = 0; $i < sizeof($deliverydata['results']); $i++)
				$deliverydata['results'][$i]['delivery_number']= Configuration::get('PS_DELIVERY_PREFIX', 1).sprintf('%06d', $deliverydata['results'][$i]['delivery_number']);
			$deliverydata['total'] = ceil($deliverydata['total'] / PAGE_PER_NO);
		}

 		echo Tools::jsonEncode($deliverydata);
	}
}
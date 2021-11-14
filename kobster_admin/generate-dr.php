<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');

	$productList = Tools::getValue('dr_id_order_detail');
	$qtyList = Tools::getValue('drQuantity');
	$id_order = Tools::getValue('id_order');
	$kob_box = Tools::getValue('kob-box');
	$other_box = Tools::getValue('other-box');
	$error = 0;
	
	
	if($productList && $qtyList)
	{
		$order = new Order(intval($id_order));
		
		$products = $order->getProductsDetail();

		if(sizeof($productList) < sizeof($products)) {
			echo "Please select all products to generate DR.";
			return false;
		}

		if($order->checkIfAllProductsDelivered()) {
			echo "DR already generated";
			return false;
		}

		foreach ($productList AS $key => $id_order_detail)
		{
			//Check if Quantity is entered
			$qtyDeliveredProduct = abs($qtyList[$key]);
			if (!$qtyDeliveredProduct){
				$error = 1;
				echo 'No quantity selected for product(s)';		
			}
			//Check if Quantity entered is correct
			$order_detail = new OrderDetail($key);
			
			if (($qtyDeliveredProduct < $order_detail->product_quantity)){
				$error = 1;
				echo 'Invalid quantity selected for product.';
			}
		}
		
		if($error != 1)
		{
			//Generate the DR
			
			//Create new delivery number
			$number = (int)(Configuration::get('PS_DELIVERY_NUMBER'));
			if (!(int)($number))
				die(Tools::displayError('Invalid delivery number'));
			Configuration::updateValue('PS_DELIVERY_NUMBER', $number + 1);
			
			//1. Create new delivery
			$delivery = new Delivery();
			//
			$delivery->id_carrier = 0;
			$delivery->id_zone = 0;
			$delivery->id_shop = 1;
			$delivery->id_shop_group = 1;
			$delivery->price = 0;
			$delivery->id_range_price = 0;
			$delivery->id_range_weight = 0;
			$delivery->delivery_number = $number;
			$delivery->delivery_date = date('Y-m-d H:i:s');
			$delivery->kob_boxes = $kob_box;
			$delivery->other_boxes = $other_box;
			$delivery->add();

			//2. Map delivery to order
			$orderDelivery = new OrderDelivery();
			$orderDelivery->id_delivery = $delivery->id;
			$orderDelivery->id_order = $id_order;
			$orderDelivery->add();
			
			//3. Add products & quantity to new delivery
			foreach ($productList AS $key => $id_order_detail)
			{
				$qtyDeliveredProduct = abs($qtyList[$key]);
				$order_detail = new OrderDetail($key);
				
				$deliveryDetails = new DeliveryDetails();
				$deliveryDetails->id_order = $order_detail->id_order;
				$deliveryDetails->id_delivery = $delivery->id;
				$deliveryDetails->id_product = $order_detail->product_id;
				$deliveryDetails->id_product_attribute = $order_detail->product_attribute_id;
				$deliveryDetails->quantity = $qtyDeliveredProduct;
				$deliveryDetails->add();
				$order_detail->updateQtyDelivered($order_detail->product_quantity_delivered + $qtyDeliveredProduct);
			}
		}
	}
	else
	{
		echo 'No products selected.';
	}
?>
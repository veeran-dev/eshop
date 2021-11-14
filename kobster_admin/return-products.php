<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');

	$productList = Tools::getValue('id_order_detail');
	$qtyList = Tools::getValue('cancelQuantity');
	$id_order = Tools::getValue('id_order');
	$error = 0;
	
	if($productList && $qtyList)
	{	
		foreach ($productList AS $key => $id_order_detail)
		{
			//Check if Quantity is entered
			$qtyReturnedProduct = abs($qtyList[$key]);
			if (!$qtyReturnedProduct){
				$error = 1;
				echo 'No quantity selected for product(s)';		
			}
			
			//Check if Quantity entered is correct
			$order_detail = new OrderDetail($id_order_detail);
			if (($order_detail->product_quantity_delivered < $qtyReturnedProduct)){
				$error = 1;
				echo 'Invalid quantity selected for product.';
			}
		}
		
		if($error != 1)
		{
			//Move products from delivered to returned
			foreach ($productList AS $key => $id_order_detail)
			{
				$order_detail->updateQtyDelivered($order_detail->product_quantity_delivered - $qtyReturnedProduct);
			}
		}
	}
	else
	{
		echo 'No products selected.';
	}
?>
<?php
class ShipmentAlertControllerCore extends FrontController
{ 
	public function displayContent()
	{
		
 	}
	
	public function displayHeader()
	{
		
	}
	
	public function displayFooter()
	{
		
	}
	
	public function preProcess()
	{
		$pendingOrders = Order::getPendingBusinessOrders();
		$shippedOrderStates = array(4, 18);

		//Get day number of week .Ex: 0 for sunday.
		$day_num = date("N",$timestamp = time());

		//Execute function except sunday
		 if($day_num != "0")
		{ 
			foreach($pendingOrders as $order)
			{
				//Shipment Alert
				if($order['hours'] > 0 && $order['hours'] < 8)
				{
					if(!in_array($order['id_order_state'], $shippedOrderStates))
					{
						//Send email
						$orders = new Order((int)($order['id_order']));
						$customer = new Customer((int)($orders->id_customer));
						$relationship_manager = new Employee((int)($customer->id_relationship_manager));
						$fc = new FulfillmentCentre((int)($orders->id_fc));
						$fc_head = new Employee((int)($fc->id_employee));

						// Customer having relationship manager
						if($relationship_manager){
							if (Mail::Send(1, 'pending-shipment-alert', Mail::l('Order not shipped yet #', 1).$order['id_order'], 
							array('{id_order}' => $order['id_order'], '{customer_name}' => $order['firstname'], 
							'{hours}' => $order['hours'], '{id_order}' =>$order['id_order']), 
							$relationship_manager->email, 'shipment-alert',  'noreply@kobzo.com'))
								echo "Mail sent Shipment - ".$order['id_order']." to ".$relationship_manager->email.".<br/>";		
						} 

						if($fc_head){
							if (Mail::Send(1, 'pending-shipment-alert', Mail::l('Order not shipped yet #', 1).$order['id_order'], 
							array('{id_order}' => $order['id_order'], '{customer_name}' => $order['firstname'], 
							'{hours}' => $order['hours'], '{id_order}' =>$order['id_order']), 
							$fc_head->email, 'shipment-alert',  'noreply@kobzo.com'))
								echo "Mail sent Shipment - ".$order['id_order']." to ".$fc_head->email.".<br/>";		
						}

						if (Mail::Send(1, 'pending-shipment-alert', Mail::l('Order not shipped yet #', 1).$order['id_order'], 
						array('{id_order}' => $order['id_order'], '{customer_name}' => $order['firstname'], 
						'{hours}' => $order['hours'], '{id_order}' =>$order['id_order']), 
						'ops@kobzo.com', 'shipment-alert',  'noreply@kobzo.com'))
							echo "Mail sent Shipment - ".$order['id_order']." to ops@kobzo.com.<br/>";						
					}
				}
				
				//Delivery Alert
				if($order['hours'] < 0)
				{
					//Send email
					$orders = new Order((int)($order['id_order']));
					$customer = new Customer((int)($orders->id_customer));
					$relationship_manager = new Employee((int)($customer->id_relationship_manager));
					$fc = new FulfillmentCentre((int)($orders->id_fc));
					$fc_head = new Employee((int)($fc->id_employee));

					// Customer having relationship manager
					if($relationship_manager){
						if (Mail::Send(1, 'pending-delivery-alert', Mail::l('Order not delivered yet #', 1).$order['id_order'], 
						array('{id_order}' => $order['id_order'], '{customer_name}' => $order['firstname'], 
						'{hours}' => $order['hours'], '{id_order}' =>$order['id_order']), 
						$relationship_manager->email, 'delivery-alert',  'noreply@kobzo.com'))
							echo "Mail sent Delivery - ".$order['id_order']." to ".$relationship_manager->email.".<br/>";		
					} 

					if($fc_head){
						if (Mail::Send(1, 'pending-delivery-alert', Mail::l('Order not delivered yet #', 1).$order['id_order'], 
						array('{id_order}' => $order['id_order'], '{customer_name}' => $order['firstname'], 
						'{hours}' => $order['hours'], '{id_order}' =>$order['id_order']), 
						$fc_head->email, 'delivery-alert',  'noreply@kobzo.com'))
							echo "Mail sent Delivery - ".$order['id_order']." to ".$fc_head->email.".<br/>";		
					}
				
					if (Mail::Send(1, 'pending-delivery-alert', Mail::l('Order not delivered yet #', 1).$order['id_order'], 
					array('{id_order}' => $order['id_order'], '{customer_name}' => $order['firstname'], 
					'{hours}' => $order['hours'], '{id_order}' =>$order['id_order'], '{estimated_delivery_time}' =>$order['estimated_delivery_time']), 
					'ops@kobzo.com', 'delivery-alert',  'noreply@kobzo.com'))
						echo "Mail sent Delivery - ".$order['id_order']." to ops@kobzo.com.<br/>";
				}
			}
		}	
	}
}
?>
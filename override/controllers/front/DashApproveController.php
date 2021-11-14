<?php 
class DashApproveControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		global $cookie;
		$type=$_POST["type"];
		$orderId=$_POST["orderid"];
		$id_customer=$_POST["id_customer"];
		$payment_type=$_POST["payment_type"];
		$cancel_reason=$_POST["cancel_reason"];
		$epay_later_order_id = Tools::getValue("id_pay_later");
 		
		if($type==1)//Order Approved
		{
			if($payment_type==1)
				$payment_mode ='Cash on delivery (COD)';
			else if($payment_type==2)
				$payment_mode ='Cheque';
			else if($payment_type==3)
				$payment_mode ='Bank Wire';
			else if($payment_type==5)
				$payment_mode ='PENDING FOR APPROVAL';
			else if($payment_type==6)
				$payment_mode ='Credit';
			else if($payment_type == 7)
				$payment_mode = 'Epaylater';

 			$order = new Order($orderId);
 			$order->updateOrderPayment($payment_mode);
			
 			if($payment_type == 5)
			{
				$cookie->payment_type = $payment_type;
				$order->approveOrder($id_customer, $payment_type, $orderId, false);
			}
			else
				$order->approveOrder($id_customer, $payment_type, $orderId, $epay_later_order_id);
		}
		else if($type==2)//Order Cancelled
		{
			$order = new Order($orderId);
			$order->rejectOrder($id_customer,$cancel_reason);
		}
		else if($type==3)//Order Revised
		{
			$order = new Order($orderId);
			$creator_customer_id = $order->id_customer;// set child customer Id Step =>1
			$this->context->cookie->creator_customer_id = $creator_customer_id;
			$this->context->cookie->creator_old_order_id = $order->id;
			
			//$order->reviseChildOrder($id_customer);// Revise and cancel the order in this Step => 2
			
			//step = > 3 for Reorder the same order 
 			$oldCart = new Cart($order->id_cart);
 			$duplication = $oldCart->duplicate();
			$this->context->cookie->id_cart = $duplication['cart']->id;
			$this->context->cookie->write();

			if($this->context->cookie->id_cart)
				echo 1;
		}
 	}
 }
?>
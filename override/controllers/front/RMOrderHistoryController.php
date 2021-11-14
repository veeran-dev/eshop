<?php
class RMOrderHistoryControllerCore extends BackController
{
	
	public function displayContent()
	{
		self::$smarty->display('rm/rm-order-history.tpl');	
 	}
 	public function ajaxReturn()
 	{
 		$type=$_POST['type'];
 		$order_id=$_POST['order_id'];
 		$days=$_POST['days'];
 		if($type==1)
 		{
 			$order=new Order($order_id);
 			$order->credit_days=$days;
 			$order->update(); //order credit days updated

 			$newOrderId=Order::getOrginOrderId($order_id);//mail alert to finance and customer
 			$template='credit_days_changed';

 			if($newOrderId)
 			{
 				$em_sub = 'Credit Days Changed | Your Order with Kobster.com [#'. $newOrderId .'] is pending for payment!';
 				$this->SendMail($order_id,$em_sub,$template);
 			}
 			else
 			{
 				$em_sub = 'Credit Days Changed | Your Order with Kobster.com [#'. $order_id .'] is pending for payment!';
 				$this->SendMail($order_id,$em_sub,$template);
 			}
 		}
 		if($type==2)
 		{
 			$order=new Order($order_id);
 			$order->credit_alert_date=date('Y-m-d H:i:s');
 			$order->update();
 			$newOrderId=Order::getOrginOrderId($order_id);
 			$template='pending-payment';

 			if($newOrderId)
 			{
 				$em_sub = 'Payment Pending | Your Order with Kobster.com [#'. $newOrderId .'] is pending for payment!';
 				$this->SendMail($order_id,$em_sub,$template);
 			}
 			else
 			{
 				$em_sub = 'Payment Pending | Your Order with Kobster.com [#'. $order_id .'] is pending for payment!';
 				$this->SendMail($order_id,$em_sub,$template);
 			}
 		}
 	}
 	public function SendMail($order_id,$em_sub,$template)
 	{
		$order=new Order($order_id);
		$cart=new Cart($order->id_cart);

		$customerNew=new Customer($order->id_customer);

		$sql='SELECT DATE(DATE_ADD(orh.`date_add`,INTERVAL orr.`credit_days` DAY)) AS last_date FROM `kob_order_history` orh 
				LEFT JOIN `kob_orders` orr ON(orr.`id_order`=orh.`id_order`)
				WHERE orr.`id_order`='.$order_id.' AND orh.`id_order_state`=40';
		$credit_date= Db::getInstance()->getRow($sql);			
		$payment_amount=$cart->getOrderTotal(true);
		$data = array(
			'{firstname}' => $customerNew->firstname,
			'{order_name}' => $order->id,
			'{payment}' => $order->payment,
			'{date}' => $order->date_add,
			'{credit_date}' => $credit_date['last_date'],
			'{payment_amount}' => $payment_amount
			);
		
			
		Mail::Send(1, $template, Mail::l($em_sub, 1), $data, $customerNew->email, $customerNew->firstname.' '.$customerNew->lastname, NULL, NULL);
			
 	}
}
?>
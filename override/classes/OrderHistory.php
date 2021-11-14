<?php

class OrderHistory extends OrderHistoryCore
{
	//created by sreeni
	public function changeIdOrderStateByApprover($new_order_state = NULL, $id_order,$id_customer = NULL,$id_employee = NULL,$payment_type =NULL)
	{
		$logger = new FileLogger();
		$logger->setFilename('order_history_track.txt');
		$logger->logError('-------------OrderHistory---------------');
		$logger->logError('id_employee==>'.$id_employee);
		$logger->logError('id_order==>'.$id_order);
		$logger->logError('id_customer==>'.$id_customer);
		$logger->logError('payment_type==>'.$payment_type);
		$logger->logError('new_order_state==>'.$new_order_state);
		$logger->logError('-------------END---------------');
		if($id_employee == NULL)
		{
			$id_employee = 0;
		}
		$order = new Order($id_order);
		$order->current_state = $new_order_state;
        $order->update();
		$this->id_employee =$id_employee;
		$this->id_order = $id_order;
		$this->id_order_state = $new_order_state;
		$this->add();
		
 		//Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('INSERT INTO `'._DB_PREFIX_.'order_history`(`id_employee`, `id_order`, `id_order_state`, `date_add`) VALUES ('.$id_employee.','.$id_order.','.$new_order_state.','.$current_time.')');
		if($id_customer !="")
		{
			if($payment_type !="")
			{
				$old_orgin_order = Order::getOrginOrderId($id_order);
				if($old_orgin_order == "")
					Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO '._DB_PREFIX_.'orgin_orders (`id_old_order`, `id_new_order`, `id_customer`) VALUES ('.$id_order.','.$id_order.','.$id_customer.')');
			}
			Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO `'._DB_PREFIX_.'order_history_customer`(`id_order_history`, `id_customer`) SELECT id_order_history,'.$id_customer.' FROM `'._DB_PREFIX_.'order_history` ORDER BY `id_order_history` DESC limit 1 ');
		}	
	}
	public static function getLastOrderState($id_order)
	{		
		$id_order_state = Db::getInstance()->getValue('
		SELECT `id_order_state`
		FROM `'._DB_PREFIX_.'order_history`
		WHERE `id_order` = '.(int)($id_order).'
		ORDER BY `date_add` DESC, `id_order_history` DESC');
		
		if (!$id_order_state)
			return false;
		return new OrderState($id_order_state, Configuration::get('PS_LANG_DEFAULT'));		
	}

	public static function getAllStatus($id_order,$id_lang)
	{
 		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT oh.id_order,oh.date_add,oh.`id_order_history`,oh.id_order_state,IF(os.hidden=1, "",osl.name) AS name, os.`hidden` FROM `'._DB_PREFIX_.'order_history` oh
		LEFT JOIN  '._DB_PREFIX_.'order_state_lang AS osl ON oh.`id_order_state` = osl.id_order_state
 		LEFT JOIN `'._DB_PREFIX_.'order_state` AS os ON oh.`id_order_state` = os.id_order_state
		WHERE id_order= '.$id_order.' AND os.`hidden`= 0 AND  osl.`id_lang` = '.$id_lang.' ORDER BY oh.id_order_history ASC');
	}
	public static function getShippedOrderTime($id_order,$id_lang)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT oh.id_order,oh.date_add, oh.id_order_state, osl.name,TIME_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), oh.date_add), "%H") AS shippingtime FROM `'._DB_PREFIX_.'order_history` oh
		LEFT JOIN  '._DB_PREFIX_.'order_state_lang AS osl ON oh.`id_order_state` = osl.id_order_state
		WHERE id_order= '.$id_order.' AND  osl.`id_lang` = '.$id_lang.' ORDER BY DATE_ADD DESC');
	}
	
	public function checkStatus($id_order,$check_status)
	{
 		if($check_status == 25 || $check_status == 34)
			$qry = 'id_order_state IN (25,34)';
		else
			$qry = 'id_order_state ='.$check_status.'';
		
 		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT count(*) FROM `'._DB_PREFIX_.'order_history` where id_order= '.$id_order.' and '.$qry.' ');
	}
	public function automatedStatus($id_order)
	{
		$order=new Order($id_order);
		$current_os = $order->getCurrentOrderState();
		$current_status=0;
		if(is_object($current_os))
		{
			$current_status=$current_os->id;
		}
		else
		{
			$current_status=$current_os;
		}
		if($current_status == 5 || $current_status == 25 || $current_status== 40 || $current_status == 36)
		{
			//nothing happens
			//return true;
		}
		else
		{
			return true;
		}

		global $cookie;
		$history = new OrderHistory();
		$delivery_status = $history->checkStatus($id_order,OrderState::FLAG_DELIVERY);//check the order get deliver or not 
		$genereate_invoice = $history->checkStatus($id_order,OrderState::GENERATE_INVOICE);//Check for generate invoice 
		$invoice_submission_pending = $history->checkStatus($id_order,OrderState::FLAG_INVOICE_SUBMISSION_PENDING);//Check for invoice_submission
		$invoice_submitted = $history->checkStatus($id_order,OrderState::FLAG_INVOICE_SUBMITTED);//Check for invoice_submitted

		if($genereate_invoice !=0 && $invoice_submission_pending !=0 && $invoice_submitted !=0)//Invoice got generated already
		{
			$payment_check = $history->checkStatus($id_order,OrderState::FLAG_PAYMENT_RECIEVED);//Check for payment Received 
			$check_EBS = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT count(*) FROM `'._DB_PREFIX_.'orders` where id_order= '.$id_order.' and payment ="EBS"');
			
			if($payment_check !=0)//Payment Received already
				$history->changeIdOrderStateByApprover(OrderState::FLAG_ORDER_COMPLETED,$id_order,NULL,$cookie->id_employee);
			else//Payment Pending
			{
				if($check_EBS == 1)
				{
					$history->changeIdOrderStateByApprover(OrderState::FLAG_PAYMENT_RECIEVED,$id_order,NULL,$cookie->id_employee);
					$history->changeIdOrderStateByApprover(OrderState::FLAG_ORDER_COMPLETED,$id_order,NULL,$cookie->id_employee);
				}
				else	
					$history->changeIdOrderStateByApprover(OrderState::FLAG_PENDING_PAYMENT,$id_order,NULL,$cookie->id_employee);
			}
		}
		else if($genereate_invoice !=0 && $invoice_submission_pending ==0)
		{
			$history->changeIdOrderStateByApprover(OrderState::FLAG_INVOICE_SUBMISSION_PENDING,$id_order,NULL,$cookie->id_employee);
		}
		else if($genereate_invoice !=0 && $invoice_submission_pending !=0 && $invoice_submitted ==0 )
		{
			$history->changeIdOrderStateByApprover(OrderState::FLAG_INVOICE_SUBMITTED,$id_order,NULL,$cookie->id_employee);
		}		
		else//Invoice need to generated
			$history->changeIdOrderStateByApprover(OrderState::FLAG_PENDING_INVOICE,$id_order,NULL,$cookie->id_employee);			 
	}

	public function getHistoryCustomer($id_order_history){
		return Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'order_history_customer a WHERE a.`id_order_history` = '.$id_order_history.'');
	}
}


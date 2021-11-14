<?php
class FinancePendingPaymentControllerCore extends BackController
{
	
	public function displayContent()
	{
		$id_group=!empty($_GET['id_group']) ? $_GET['id_group'] : "";
 		$from=!empty($_GET['from']) ? $_GET['from'] : "";
 		$to=!empty($_GET['to']) ? $_GET['to'] : "";


		$result=Finance::financePaymentPending($id_group,$from,$to);
		$group=new Group();
		$groups=$group->getGroups(1);
		//var_dump($result);
		$this->context->smarty->assign('pending_payment',$result);
		$this->context->smarty->assign('groups', $groups);
		self::$smarty->display('finance/finance-pending-payment.tpl');	
 	}
 	public function ajaxReturn()
 	{
 		$type=!empty($_POST['type']) ? $_POST['type'] : "";
 		if(!$type)
 			$type=!empty($_GET['type']) ? $_GET['type'] : "";
 		$id_order=!empty($_GET['id_order']) ? $_GET['id_order'] : "";
 		$id_group=!empty($_POST['id_group']) ? $_POST['id_group'] : "";
 		$from=!empty($_POST['from']) ? $_POST['from'] : "";
 		$to=!empty($_POST['to']) ? $_POST['to'] : "";

 		if($type==1)
 		{
 			$result=Finance::financePaymentPending($id_group,$from,$to);
 			$group=new Group();
			$groups=$group->getGroups(1);
			//var_dump($result);
			$this->context->smarty->assign('pending_payment',$result);
			$this->context->smarty->assign('groups', $groups);
			//self::$smarty->display('finance/finance-pending-payment.tpl');
 			//echo json_encode($result);
 		}
 		if($type==2)
 		{
 			global $cookie;
			$order_state = new OrderState(36);
			$order=new Order($id_order);
            // Create new OrderHistory
            $history = new OrderHistory();
            $history->id_order = $id_order;
            $history->id_employee = $cookie->id_employee;


            $use_existings_payment = false;
            if (!$order->hasInvoice()) {
                $use_existings_payment = true;
            }
            if(!$order_state->id)
            {
            	echo "issue in order state";
            	return false;
            }
            elseif (!$order || !$history) {
            	echo "issue in order id";
            	return false;
            }
            $history->changeIdOrderState((int)$order_state->id, $order, $use_existings_payment);

            $carrier = new Carrier($order->id_carrier, $order->id_lang);
            $templateVars = array();
            if ($history->id_order_state == Configuration::get('PS_OS_SHIPPING') && $order->shipping_number) {
                $templateVars = array('{followup}' => str_replace('@', $order->shipping_number, $carrier->url));
            }

            // Save all changes
            if ($history->addWithemail(true, $templateVars)) {
                // synchronizes quantities if needed..
                if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
                    foreach ($order->getProducts() as $product) {
                        if (StockAvailable::dependsOnStock($product['product_id'])) {
                            StockAvailable::synchronize($product['product_id'], (int)$product['id_shop']);
                        }
                    }
                }

                $delivery_status = $history->checkStatus($order->id,OrderState::FLAG_DELIVERY);//check the order get deliver or not                             
                if($delivery_status !=0)
                {
                    $delivery_status = $history->automatedStatus($order->id);
                }

                //Tools::redirectAdmin(self::$currentIndex.'&id_order='.(int)$order->id.'&vieworder&token='.$this->token);
            }
            echo 1;
	        
 		}
 	}
}
?>
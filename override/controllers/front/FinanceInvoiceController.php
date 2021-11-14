<?php
class FinanceInvoiceControllerCore extends BackController
{
	public function ajaxReturn()
	{
		global $cookie;

		$load=!empty($_GET['load']) ? $_GET['load'] : "";
		$type=!empty($_POST['type']) ? $_POST['type'] : "";
		$id_group=!empty($_POST['id_group']) ? $_POST['id_group'] : "";
		$id_fc=!empty($_POST['id_fc']) ? $_POST['id_fc'] : "";
		$orderids=!empty($_POST['orderids']) ? $_POST['orderids'] : "";
		$id_state=!empty($_POST['id_state']) ? $_POST['id_state'] : "";

		if($load==6)
		{
			
			$group=new Group();
			$groups=$group->getGroups(1);
			 $this->context->smarty->assign('groups', $groups);
			 self::$smarty->display('finance/finance-invoice.tpl');
		}
		if($type==1)
		{
			$group=new Group();
			echo json_encode($group->getGroups(1));
		}
		if($type==2)
		{
			$fc=new FulfillmentCentre();
			echo json_encode($fc->getFcForGroup($id_group));
		}
		if($type==3)
		{
			$address=new Address();			
			echo json_encode($address->getstateByGroup($id_group));
		}
		if($type==4)
		{
			$orders=new Order();
			echo json_encode($orders->getOrdersByState($id_state,$id_group));
		}
		if($type==5)
		{
			$return_id=0;
			$order_id=explode(",", $orderids);
			$cookie->consolidated_invoice=0;
			foreach($order_id as $id)
			{
				$order = new Order($id);
				if(!$order->checkIfAllProductsDelivered())
				{
					$return_id .= $id."-";
				}
			}
			if($return_id==0 || $return_id=='')
			{
				$token=Tools::getToken(false);
				$consolidated_invoice_orders="kobster_admin/index.php?controller=AdminPdf&loggedInternal=true&token=".$token."&submitAction=generateConsolidatedInvoicePDF";
				//$consolidated_invoice_orders="index.php?controller=pdf-invoice&id_order=";
				foreach($order_id as $id)
				{
					$consolidated_invoice_orders .="&id_order[]=".$id;					
					$order = new Order($id);
					if($cookie->consolidated_invoice==0 && isset($cookie->consolidated_invoice))
					{
						$number = Db::getInstance()->getRow('SELECT MAX(`invoice_number`) + 1 AS `invoice_number` FROM `'._DB_PREFIX_.'orders`');
						$cookie->consolidated_invoice=$number['invoice_number'];
					}
					

					$use_existings_payment = false;
                    if (!$order->hasInvoice()) {
                        $use_existings_payment = true;
                    }					
					$history = new OrderHistory();
					$history->id_order = (int)$id;
					$history->id_employee = (int)($cookie->id_employee);
					$history->changeIdOrderState(Configuration::get('PS_OS_INVOICE_GEN'), (int)$id,$use_existings_payment);
					$history->save();
					$history->automatedStatus($id);
					$order->invoice_number=$cookie->consolidated_invoice;	
					$order->update();					
				}
				
				$cookie->invoice_number=0;
				echo $consolidated_invoice_orders;
			}
			else
			{
				echo $return_id;
			}
		}
	}
}
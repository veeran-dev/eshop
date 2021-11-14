<?php
class RmIndexDataControllerCore extends BackController
{
	public function ajaxReturn()
	{
		parent::ajaxReturn();
		
 		$type = Tools::getValue('type');
		$id_employee = Tools::getValue('id_employee');
		$order_status = Tools::getValue('order_status');
		$duration = Tools::getValue('duration');
		$id_quotation = Tools::getValue('id_quotation');
		$id_group = Tools::getValue('id_group');
		$id_state = Tools::getValue('id_state');
		$id_address = Tools::getValue('id_address');
		$id_customer = Tools::getValue('id_customer');
		$request_detail_month = Tools::getValue('request_detail_month');
		$action = Tools::getValue('action');
		
		$id_fc = Tools::getValue('id_fc');
		$order = new Order();
		if($id_fc == 0)
			$id_fc = NULL;
  		if($type==1)
		{
				$result = array();
				$order_status_details= $order->getRMCusomersOrderDurations($id_employee, $id_fc);
				$states = OrderState::getOrderStates(1);
				array_push($result, $order_status_details, $states);
 				echo Tools::jsonEncode($result);
		}
		elseif($type==2)
		{
			$tab = 'AdminOrders';
			$token = Tools::getAdminTokenLite($tab);
			$result=array();
			$order_status_customers=$order->getStatusOrdersDetails($id_employee,$order_status,$duration, $id_fc);
			array_push($result,$order_status_customers,$token);
			echo Tools::jsonEncode($result);
		}
		elseif($type == 3){
			$scnquotation = new ScnQuotation();
			$published_quotations = $scnquotation->getQuotations($id_group,$type,$id_employee);
 			for($i = 0;$i < sizeof($published_quotations);$i++)
			{
				$employee = new Employee((int)$published_quotations[$i]['id_employee']);
				$published_quotations[$i]['id_employee'] = $employee->firstname;
			}
			
			echo Tools::jsonEncode($published_quotations);
		}
		elseif($type == 4){
			$scnquotation = new ScnQuotation();
			$view_quotation = $scnquotation->reviseViewQuotation($id_quotation, $type);
			echo Tools::jsonEncode($view_quotation);
		}
		
		elseif($type == 5){
			$state = new State();
			
			$id = $state->getaddresbystate($id_state);
			echo Tools::jsonEncode($id[0]['id_address']);
		}
		elseif($type == 6){
			$fullfillment_centre = FulfillmentCentre::getAllFCentres();
			echo Tools::jsonEncode($fullfillment_centre);
		}
		elseif($type == 7)
		{
			$result = Order::getCompanyOrderTotalDetails($id_employee);
			echo Tools::jsonEncode($result);
		}
		elseif($type == 8)
		{
			$result = Address::assignAddressToCustomer($id_customer,$id_address,$action);
			echo $result;
		}
		 
		
 	}
}
 
?>
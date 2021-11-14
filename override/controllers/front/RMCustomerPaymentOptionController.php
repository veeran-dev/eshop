<?php
class RMCustomerPaymentOptionControllerCore extends BackController
{
	
	public function displayContent()
	{
			$this->context->smarty->display('rm/rm-customerpaymentoption.tpl');
 	}
	
	public function ajaxReturn()
	{
			
		$type=$_POST['type'];
		
		
		 
		if($type==1)
		{
			$customer_id=$_POST['id_customer'];	
			$dash_payment = new DashPaymentOption();
			$result=$dash_payment->getPaymentOptions($customer_id);
			echo $result;
		}
		if($type==2)
		{
			$customer_id = $_POST['id_customer'];	
			$payment_option = $_POST['payment_option'];
			$result = DashPaymentOption::checkPaymentOptions($customer_id, $payment_option);
		}
	}
}
?>
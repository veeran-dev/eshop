<?php
class DashLoyaltyPointsControllerCore extends DashController
{
	public function ajaxReturn()
	{
		
		$id_customer =$_POST['id_customer'];
		$customerPoints = new LoyaltyPoints();
		$loyaltypts = $customerPoints->getPointsByCustomer($id_customer);
		echo $loyaltypts;
	}
}
?>
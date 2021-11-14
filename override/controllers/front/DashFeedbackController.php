<?php
class DashFeedbackControllerCore extends DashController
{
	public function ajaxReturn()
	{
		global $cookie;
		$type=$_POST['type'];
		
		
		

		if($type==1)
		{
			$feedback=new EliteFeedback();
			$orderDetails=$feedback->completedOrder($cookie->id_customer);
			echo json_encode($orderDetails);
		}
		if($type==2)
		{
			$customer_id=$_POST['customer_id'];
			$comments=$_POST['comments'];
			$rating=$_POST['rating'];
			$order_id=$_POST['order_id'];
			$feedback=new EliteFeedback();
			$feedback->id_order=$order_id;
			$feedback->rating=$rating;
			$feedback->id_customer=$customer_id;
			$feedback->comment=$comments;
			
			$feedback->save();
			/*if($feedback->add())
				echo "1";
			else
				echo "404";*/

		}
	}

}
<?php 
class FestivalpromotionControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		
		$recievedData = array(
			'cust_name' 		=> trim(Tools::getValue('cust_name')),
			'company_name' 		=> trim(Tools::getValue('company_name')),
			'mobile' 			=> trim(Tools::getValue('mobile')),
			'email' 			=> trim(Tools::getValue('email')),
			'festival' 			=> trim(Tools::getValue('festival'))
		);
		
		
		
		$rec_email 	= $recievedData['email'];
		$sell_name 	='Relationship Manager from Kobster';
		
		if($recievedData['festival'] == 1) $festival = "Ayudha Pooja";
		else if($recievedData['festival'] == 2) $festival = "Diwali";
		else if($recievedData['festival'] == 3) $festival = "Paper One";
		else if($recievedData['festival'] == 4) $festival = "Pantry";
		else $festival = "Festival";
		
		$mailData = array(
			'{cust_name}' 		=> $recievedData['cust_name'],
			'{company_name}' 	=> $recievedData['company_name'],
			'{mobile}' 			=> $recievedData['mobile'],
			'{email}' 			=> $recievedData['email'],
			'{festival}' 		=> $festival
		);
		
		$table = "festival_leads";
		$dbData = array(
			'firstname' 		=> $recievedData['cust_name'],
			'company' 			=> $recievedData['company_name'],
			'phone' 			=> $recievedData['mobile'],
			'email' 			=> $recievedData['email'],
			'festival' 			=> $recievedData['festival']
		);
		
		if(Db::getInstance()->insert($table, $dbData)){
			
			// Mail sent to Registerer
			$to			= $recievedData['email'];
			$toName 	= $recievedData['cust_name'];
			$from		= "marketing@kobster.com";
			$fromName 	= "From Kobster";
			$subject 	= $recievedData['cust_name'].', Kobster '.$festival.' Sale!';
			Mail::Send(1, 'festival_promotion_requester', $subject, $mailData, $to, $toName, $from, $fromName);
			
			// Mail sent to Marketing team
			$to			= "marketing@kobster.com";
			$toName 	= "Marketing";
			$from		= "noreply@kobster.com";
			$fromName 	= $recievedData['cust_name']. ' from '. $recievedData['company_name'];
			$subject 	= $festival.' promotional from '. $recievedData['cust_name'];
			Mail::Send(1, 'festival_promotion_internal', $subject, $mailData, $to, $toName, $from, $fromName);
			
			echo "success";
			
		}
		else {
			echo "failed";	
		}	
 	
	}
	
	
}
?>
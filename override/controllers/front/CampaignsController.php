<?php 
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14007 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
class CampaignsControllerCore extends FrontController
{
	public function ajaxReturn()
	{	
		$firstname = Tools::getValue('fullname');
		$email = Tools::getValue('email');
		$company = Tools::getValue('company');
		$city = Tools::getValue('city');
		$mobile = Tools::getValue('mobile');
		$festivalID = Tools::getValue('festival');
		$products = Tools::getValue('products');
		$logger = new FileLogger();
		$logger->setFilename("test.txt");
		$logger->logError("data");
		$logger->logError($products);
		$logger->logError($this->context->cookie->id_customer);
		if($products){
			$customer = new Customer($this->context->cookie->id_customer);
			$firstname = $customer->firstname;
			$email = $customer->email;
			$mobile = $customer->mobile;
			$festivalID = 9;
		}

		if(isset($firstname)) {
			if($festivalID == 1) 
				$festival = "Ayudha Pooja";
			else if($festivalID == 2) 
				$festival = "Diwali";
			else if($festivalID == 3) 
				$festival = "Paper One";
			else if($festivalID == 4) 
				$festival = "Pantry";
			else if($festivalID == 5) 
				$festival = "Office Supplies";
			else if($festivalID == 6) 
				$festival = "House Keeping";
			else if($festivalID == 7) 
				$festival = "Electronics"; 
			else if($festivalID == 8) 
				$festival = "Taski";
			else if($festivalID == 9) 
				$festival = "Elite Deals";
			else 
				$festival = "Festival";
			
			
			$table = "festival_leads";

			$dbData = array(
				'firstname' 		=> $firstname,
				'company' 			=> $company,
				'phone' 			=> $mobile,
				'email' 			=> $email,
				'festival' 			=> $festivalID,
				'city'				=> $city
			);
			$logger->logError($dbData);
			if(Db::getInstance()->insert($table, $dbData)){
				
				if($products){

					$data = explode(",", $products);
					$details = "";
					$details = "<br><tr><td style='color: #383838; '>Below are the requested products</td></tr>";
					$details .= "<table><thead><tr><th>Products</th><th>Quantity</th></thead><tbody>";
					foreach ($data as $values) {
						$val = explode("~", $values);
						$details .="<tr colspan='2'><td style='width: 80%'>".$val[0]."</td>".$val[1]."<td></td></tr>";
					}
					$details .= "</tbody></table>";
					$logger->logError($details);
					$mailData = array(
        				'{cust_name}' 		=> $firstname,
        				'{mobile}' 			=> $mobile,
        				'{email}' 			=> $email,
        				'{festival}' 		=> $festival,
        				'{details}'         => $details,
        			);
        			$employee = new Employee($customer->id_relationship_manager);
        			$to_email = $employee->email ? $employee->email : "rm@kobster.com";
					// Mail sent to Registerer
					$to			= $email;
					$toName 	= $firstname;
					$from		= "marketing@kobster.com";
					$fromName 	= "From Kobster";
					$subject 	= $firstname.', Kobster '.$festival.' Sale!';
					Mail::Send(1, 'festival_promotion_requester', $subject, $mailData, $to, $toName, $from, $fromName);
					
					// Mail sent to Marketing team
					$to			= $to_email;
					$toName 	= "Marketing";
					$from		= "noreply@kobster.com";
					$fromName 	= $firstname;
					$subject 	= $firstname.' - New Lead from '.$festival.' Landing Page' ;
					Mail::Send(1, 'elite_promotion_internal', $subject, $mailData, $to, $toName, $from, $fromName);
				}
				else{

					$mailData = array(
						'{cust_name}' 		=> $firstname,
						'{company_name}' 	=> $company,
						'{mobile}' 			=> $mobile,
						'{email}' 			=> $email,
						'{festival}' 		=> $festival,
						'{city}' 			=> $city
					);
					// Mail sent to Registerer
					$to			= $email;
					$toName 	= $firstname;
					$from		= "marketing@kobster.com";
					$fromName 	= "From Kobster";
					$subject 	= $firstname.', Kobster '.$festival.' Sale!';
					Mail::Send(1, 'festival_promotion_requester', $subject, $mailData, $to, $toName, $from, $fromName);
					
					// Mail sent to Marketing team
					$to			= "marketing@kobster.com";
					$toName 	= "Marketing";
					$from		= "noreply@kobster.com";
					$fromName 	= $firstname. ' from '. $company;
					$subject 	= $firstname.' - New Lead from '.$festival. ' Landing Page' ;
					Mail::Send(1, 'festival_promotion_internal', $subject, $mailData, $to, $toName, $from, $fromName);
				}
				echo "success";
			}
			else {
				$logger->logError("fail");
				echo "failed";
			}	
		}
	}
}
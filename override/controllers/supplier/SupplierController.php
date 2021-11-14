<?php
/*
*
* Supplier main controller
*
*/
class SupplierControllerCore extends FrontController 
{
	public function ajaxReturn() 
	{
		$type = Tools::getValue('type');
		if($type == 1){
			$entp_name = Tools::getValue('entp_name');
			$contact_person = Tools::getValue('contact_person');
			$entp_email = Tools::getValue('entp_email');
			$mobile = Tools::getValue('mobile');
			$city = Tools::getValue('city');
			$category = Tools::getValue('category');
			
			if(!$this->context) {
				$this->context = Context::getContext();
			}
			//Invite suppliers through email
			$customer = new Customer(intval($this->context->customer->id));
			$company = new Group(intval($customer->id_default_group));

			$insertData = array(
				'id_customer'=>$customer->id,
				'enterprise_name'=>$entp_name,
				'enterprise_email' => $entp_email,
				'contact_person' => $contact_person,
				'contact_mobile' => $mobile,
				'city' => $city,
				'category' => $category
				);
			$insertResult = Db::getInstance()->insert('supplier_invitation', $insertData);			

			/**SEND INVITATION TO SUPPLIER **/
			$em_sub = 'You have been invited by '.$company->name[1].'';
			$data = array(
				'{date}' => date('Y-m-d H:i:s'),
				'{user_name}' => $customer->firstname.' '.$customer->lastname,
				'{company_name}' => $company->name[1],
				'{id_group}' => $company->id,
				'{id_customer}' => $customer->id
			);
			Mail::Send(1, 'elite_supplier_invite', Mail::l($em_sub, 1) , $data, $entp_email);
            
            $logger = new FileLogger();
            $logger->setFilename("test1.txt");
            $logger->logError("ooooo");
            $city_names = Db::getInstance()->ExecuteS("SELECT GROUP_CONCAT(name) as cities FROM `kob_city` where id_city in(".$city.")");
			$category_names = Db::getInstance()->ExecuteS("SELECT GROUP_CONCAT(name) as cname FROM `kob_category_lang` 
																where id_lang=1 AND id_category in(".$category.")");
			$logger->logError($city_names);
			$logger->logError($category_names);
			/**SEND INFORMATION TO INTERNAL TEAM **/
			$internal_data = array(
				'{date}' => date('Y-m-d H:i:s'),
				'{user_name}' => $customer->firstname.' '.$customer->lastname,
				'{company_name}' => $company->name[1],
				'{id_group}' => $company->id,
				'{id_customer}' => $customer->id,
				'{suppliers}' => $entp_email,
				'{enterprise_name}'=>$entp_name,
				'{enterprise_email}' => $entp_email,
				'{contact_person}' => $contact_person,
				'{contact_mobile}' => $mobile,
				'{city}' => $city_names[0]['cities'],
				'{category}' => $category_names[0]['cname']
			);
			$logger->logError($internal_data);
			Mail::Send(1, 'elite_supplier_invite_internal', Mail::l($em_sub, 1) , $internal_data, 'arumugasamy@kobzo.com');
			echo "1";
		}
	}
}
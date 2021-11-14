<?php

class Customer extends CustomerCore
{
	public function  getCompanyName()
	{
		$result =  Db::getInstance()->getRow('SELECT g.name from kob_perks_customer c, kob_group_lang g where g.id_group = c.id_group and c.id_customer='.$this->id.'');		
		return $result['name'];		
	}
	public function getCusForVerification($id_customer)
	{	 

		return Db::getInstance()->ExecuteS('SELECT c.`id_customer`,c.`firstname`,c.`email`,c.`mobile`,c.`verification_status`,c.`verification_document`,c.`verification_alert_sent` FROM `'._DB_PREFIX_.'customer` c WHERE c.id_customer ='.$id_customer );
	}
	public function getChildCustomers()//Returns Child customers ID and also Parent Customers ID
	{
		$id_parent=$this->id;
		$result= Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('SELECT id_customer from `'._DB_PREFIX_.'customer_parent` where id_parent='.$id_parent.'');
		$res_str='';
		foreach($result AS $res)
				$res_str = $res_str.$res['id_customer'].',';
		$res_str = $res_str.$id_parent;
		return $res_str;
	}
	public function getBuyerId($email)
	{
		return Db::getInstance()->getValue(
		'SELECT id_buyer
		FROM `'._DB_PREFIX_	.'customer`
		WHERE `active` = 1
		AND `email` = \''.pSQL($email).'\'');
	}
	
	public function getRelationShipManager()
	{
		return Db::getInstance()->ExecuteS('SELECT id_employee, firstname FROM `'._DB_PREFIX_.'employee` WHERE `id_profile`=5 AND active=1 ');
	}

	public static function searchCorpCus($query_string)
	{
		return Db::getInstance()->ExecuteS('
		SELECT c.*
		FROM `'._DB_PREFIX_.'customer` c
		WHERE  c.firstname LIKE "%'.$query_string.'%" AND c.`active`=1 AND c.`id_buyer`=3');
	}

	

	public static function getCustomerInGroups($id_group)
	{
		 

		return DB::getInstance()->ExecuteS('select cus.firstname as name,cus.id_customer, cus.email from `'._DB_PREFIX_.'customer` cus 
											LEFT JOIN `'._DB_PREFIX_.'customer_group` custgroup ON(custgroup.id_customer=cus.id_customer) 
											where id_group='.$id_group);
	}
	
	public static function searchAllCustomers($query)
	{
		 

		return  Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT c.*
		FROM `'._DB_PREFIX_.'customer` c
		WHERE c.`email` LIKE \'%'.pSQL($query).'%\'
		OR c.`id_customer` LIKE \'%'.pSQL($query).'%\'
		OR c.`lastname` LIKE \'%'.pSQL($query).'%\'
		OR c.`firstname` LIKE \'%'.pSQL($query).'%\'
		AND c.`active` = 1 AND c.`deleted` = 0');
		
		/*$data = json_encode($results);
		$user_friend =  json_decode($data, true );
		    $data=array();
			
		   foreach($user_friend as $key=>$val)
		            $data[]=$val['id_customer'];
					
		    $json_friends =json_encode($user_friend);
		    return $json_friends;*/
	}

	public static function searchAllCustomersByGroup($query, $id_group)
	{
		return  Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT c.id_customer as id, concat(c.`firstname`," [",c.`email`,"]") as name
		FROM `'._DB_PREFIX_.'customer` c
		WHERE (c.`email` LIKE \'%'.pSQL($query).'%\'
		OR c.`id_customer` LIKE \'%'.pSQL($query).'%\'
		OR c.`lastname` LIKE \'%'.pSQL($query).'%\'
		OR c.`firstname` LIKE \'%'.pSQL($query).'%\') 
		AND c.`id_default_group` = '.$id_group.' AND c.`active` = 1 AND c.`deleted` = 0');
		
	}

	/*public static function getCusDetails($id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT a.`id_customer`,a.`email`,a.`firstname`,a.`id_customer`,a.`mobile`,a.`company` as cus_company,b.`firstname` as poc_person,
											b.`phone_mobile` as poc_mobile,b.`address1` as poc_add1,b.`address2` as poc_add2,b.`alias`,b.`company` as poc_company,b.`id_address` as address_id,
											c.`name` as state,b.`city`,b.`postcode`,b.`phone` as poc_landline,b.`active` as address_active,b.`deleted` as address_deleted
											FROM `'._DB_PREFIX_.'customer` a 
											LEFT JOIN `'._DB_PREFIX_.'address` b ON a.`id_customer` = b.`id_customer`
											LEFT JOIN `'._DB_PREFIX_.'state` c ON b.`id_state`= c.`id_state`
											WHERE a.`id_customer` = '.$id_customer.' 
											AND a.`active` = 1 AND a.`deleted` = 0');
	}*/
	public static function getGroupAddressDetails($id_group)
	{
		 

		return Db::getInstance()->ExecuteS('SELECT b.`company` as cus_company, CONCAT(b.`firstname`, " ", b.`lastname`) as poc_person,
											b.`phone_mobile` as poc_mobile,b.`address1` as poc_add1,b.`address2` as poc_add2,b.`alias`,b.`company` as poc_company,b.`id_address` as address_id,
											c.`name` as state,b.`city`,b.`postcode`,b.`phone` as poc_landline,b.`active` as address_active,b.`deleted` as address_deleted,a.`id_customer`
											FROM `'._DB_PREFIX_.'address` b 
											LEFT JOIN `'._DB_PREFIX_.'customer` a ON a.`id_customer` = b.`id_customer`
											LEFT JOIN `'._DB_PREFIX_.'state` c ON b.`id_state`= c.`id_state`
											WHERE a.`id_default_group` = '.$id_group.' 
											AND a.`active` = 1 AND a.`deleted` = 0 AND b.`deleted` = 0');
	}

	public function isExistsGroup($id_customer,$id_group)
	{
		return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'customer_group` a 
											WHERE a.`id_customer` = '.$id_customer.' AND a.`id_group` = '.$id_group.'');
	}

	public function mapGroupToCustomer($id_customer,$id_group)
	{
		Db::getInstance()->ExecuteS('INSERT INTO `'._DB_PREFIX_.'customer_group`(`id_customer`,`id_group`) VALUES('.$id_customer.','.$id_group.')');
	}

	public static function getAllRolesForCustomer()
	{
		return Db::getInstance()->ExecuteS('SELECT rlm.`id_role` as role,rlm.`name` as role_name 
											FROM `'._DB_PREFIX_.'role_master` rlm');
	}

	public function createCustomerRole($id_customer,$role,$action = false)
	{
		if($action)
		{
			$result = Db::getInstance()->autoExecute(_DB_PREFIX_.'customer_role', array('id_customer' => $id_customer, 'id_role' => $role), 'UPDATE','id_customer = '.$id_customer.'');
		}
		else
		{
			$result = Db::getInstance()->autoExecute(_DB_PREFIX_.'customer_role', array('id_customer' => $id_customer, 'id_role' => $role), 'INSERT');
		}
		
		$check = Db::getInstance()->executeS('select * from '._DB_PREFIX_.'payment_group_map where id_customer ='.$id_customer.'');
		if(sizeof($check)>0)
		{
			Db::getInstance()->executeS('DELETE FROM `'._DB_PREFIX_.'payment_group_map` WHERE id_customer ='.$id_customer);
		}
		if($role == 1)
		{
			Db::getInstance()->executeS('INSERT INTO `kob_payment_group_map`(`id_payment`,`id_customer`) VALUE (5,'.$id_customer.')');
			
		}
		else
		{
				Db::getInstance()->executeS('INSERT INTO `kob_payment_group_map`(`id_payment`,`id_customer`) VALUE (2,'.$id_customer.'),(3,'.$id_customer.')');
		}
		
		return $result;
	}

	public function isExistsRole($id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT a.`id_customer`
										   FROM `'._DB_PREFIX_.'customer_role` a
										   WHERE a.`id_customer` = '.$id_customer.'');
	}

	public static function getParents($id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT c.`id_customer`,cl.`id_role`,c.`firstname` as name,c.`email` as email
											FROM `'._DB_PREFIX_.'customer_parent` cp
											LEFT JOIN `'._DB_PREFIX_.'customer` c ON cp.`id_parent` = c.`id_customer`
											LEFT JOIN `'._DB_PREFIX_.'customer_role` cl ON cp.`id_parent` = cl.`id_customer`
											WHERE cp.`id_customer` = '.$id_customer.' AND c.email !="" ');
	}

	public function assignParent($id_customer,$id_parent)
	{
		 return Db::getInstance()->autoExecute(_DB_PREFIX_.'customer_parent', array('id_customer' => $id_customer, 'id_parent' => $id_parent), 'INSERT');
	}

	public function removeParent($id_parent,$id_customer = false)
	{
		if($id_customer)
			return Db::getInstance()->ExecuteS('DELETE FROM `'._DB_PREFIX_.'customer_parent` WHERE id_customer = '.$id_customer.' OR id_parent = '.$id_parent.'');
		else
			return Db::getInstance()->ExecuteS('DELETE FROM `'._DB_PREFIX_.'customer_parent` WHERE id_parent = '.$id_parent.'');
	}

	/*Elite Customer system starts here*/
	public function getCustomerRole()
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT IFNULL(r.id_role, 0) as role  FROM '._DB_PREFIX_.'customer c
		LEFT JOIN '._DB_PREFIX_.'customer_role r ON (c.id_customer = r.id_customer)
		WHERE c.id_customer = '.(int)($this->id));
		
		return (int)$result[0]['role'];
	}

	public static function getCurrentCustomerRole()
	{		
		global $cookie;

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT IFNULL(r.id_role, 0) as role  FROM '._DB_PREFIX_.'customer c
		LEFT JOIN '._DB_PREFIX_.'customer_role r ON (c.id_customer = r.id_customer)
		WHERE c.id_customer = '.(int)($cookie->id_customer));
		
		return (int)$result[0]['role'];
	}

	public function getApprover($multiple_approver = false, $nearest_level_approver = false)
	{
		if($this->getCustomerRole() == 1 || $this->getCustomerRole() == 2 )
		{
			if($this->getCustomerRole() == 1)
			{
				$sub_qry = 'cr.id_role = 2';
			}
			else if($this->getCustomerRole() == 2)
			{
				$sub_qry = 'cr.id_role = 3';
			}

			$result =  Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT parent.id_parent as id_parent, cr.id_role FROM `'._DB_PREFIX_.'customer_parent` parent 
			left join '._DB_PREFIX_.'customer_role as cr on cr.id_customer = parent.id_parent 
			LEFT JOIN '._DB_PREFIX_.'customer cust on cust.id_customer=parent.id_customer
			WHERE cust.email NOT LIKE "%pincap%" and parent.id_customer = '.(int)($this->id).' and '.$sub_qry.'');

			if($multiple_approver == true) 
			{
				return $result;
			}
			else 
			{
				if($nearest_level_approver) {
					/* Get nearest level approver details */
					$approver_details = array();
					foreach ($result as $key => $approver) {
						if($approver['id_role'] == $this->getCustomerRole() + 1) {
							$approver_details[$key]['id_parent'] = $approver['id_parent'];
						}
					}

					return $approver_details;
				}

				return (int)$result[0]['id_parent'];
			}
		}
		else
			return 0;
	}

	public function searchCompany($query_string)
	{
		return Db::getInstance()->executeS('SELECT g.*,gl.`name`
											FROM `'._DB_PREFIX_.'group` g
											LEFT JOIN `'._DB_PREFIX_.'group_lang` gl ON g.`id_group` = gl.`id_group` AND gl.`id_lang` = 1
											WHERE gl.`name` LIKE "%'.$query_string.'%"');
	}

	public function getAllCustomersByGroup() {
		return Db::getInstance()->executeS('SELECT c.`id_customer` AS id_customer
											FROM `'._DB_PREFIX_.'customer` c
											WHERE c.`id_default_group` = '.$this->id_default_group.' 
											AND c.`active` = 1 AND c.`deleted` = 0');
	}

	public function verifyIsHuman($recaptcha_response) {
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
			'secret' => '6LcA3CsUAAAAAOs0rK1vQN46eCBfciUL8rY9-hvS', 
			'response' => $recaptcha_response
		);

		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data)
		    )
		);

		$context  = stream_context_create($options);

		$api_response = file_get_contents($url, false, $context);

		$decoded_response = Tools::jsonDecode($api_response, true);

		if ($decoded_response['success'] == 1) { /* Handle response */ 
			return true;
		}
		else { 
			return false;
		}
	}

	public function setLastConnectionDate()
    {
        return Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'customer`
			SET `last_connection_date` = CURRENT_DATE()
			WHERE `id_customer` = '.(int)$this->id.' AND `last_connection_date` < CURRENT_DATE()
		');
    }

    public function getCustomerAvailableZones() 
	{
		$sql = 'SELECT fc.`id_fulfillment_centre`, fc.`city_name` 
				FROM `'._DB_PREFIX_.'address` a
				LEFT JOIN `'._DB_PREFIX_.'customer_address` ca ON a.`id_address` = ca.`id_address`
				LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` fc ON a.`id_state` = fc.`id_state`
				WHERE ca.`id_customer` IN('.$this->getChildCustomers().') 
				AND a.`deleted` = 0 AND a.`active` = 1 AND a.`id_state` != 0
				GROUP BY fc.`id_fulfillment_centre` ORDER BY fc.`city_name` ASC';

		return Db::getInstance()->executeS($sql);
	}

	public function getCustomerZoneByAddress($id_address) {
		$sql = 'SELECT fc.`id_fulfillment_centre`, fc.`city_name` FROM `'._DB_PREFIX_.'address` a
				LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` fc ON a.`id_state` = fc.`id_state`
				WHERE a.`id_address` = '.$id_address.'';
		return Db::getInstance()->executeS($sql);
	} 	 

	public function checkCustomerCredibility($id_order){
	   // $logger = new FileLogger();
	   // $logger->setFilename("test.txt");
	   // $logger->logError("check ");
		$sql ='SELECT if(DATE_ADD(MIN(koi.date_add), INTERVAL (ko.credit_days+15) DAY) < (SELECT date_add from kob_orders WHERE id_order='.$id_order.'),1,0) as age, (SELECT release_order from kob_orders WHERE id_order='.$id_order.') as release_order FROM `kob_group` kg
				LEFT JOIN kob_customer kc on kc.id_default_group = kg.id_group
			    LEFT JOIN kob_orders ko on ko.id_customer = kc.id_customer
			    LEFT JOIN kob_order_invoice koi on koi.id_order = ko.id_order
			    left join kob_order_history koha on koha.id_order = ko.id_order
			    left join kob_order_history kohb on kohb.id_order = koha.id_order
			    WHERE koha.id_order in(select id_order from kob_order_history oh where oh.id_order=ko.id_order and oh.id_order_state=40)
									AND kohb.id_order_history in( select max(id_order_history) from kob_order_history ohb where ohb.id_order=koha.id_order)
									AND kohb.id_order_state NOT IN(6,7,38,36)
									AND ko.date_add >= "2017-07-01 00:00:00" 
									AND koi.deny_alerts = 0
								    AND ko.invoice_number!=0
                                    AND kg.id_group ='.$this->id_default_group.'';
        // $logger->logError($sql);
        $result= Db::getInstance()->executeS($sql);
        // $logger->logError($result);
        return ($result[0]['age'] == 1 && $result[0]['release_order'] == 0) ? true: false;
        // return ($result[0]['age'] == 1 || $result[0]['age'] == "")  ? false : true;
	}

	public function triggerOrderConfEmail($id_order_state, $order_ids, $data = array(), $split_order, $id_lang, $id_shop, $invoice, $product_list, $id_carrier) {
		if($split_order == true){
			return true;
		}
		//Send email to users related to order
        if ($id_order_state != Configuration::get('PS_OS_ERROR') && $id_order_state != Configuration::get('PS_OS_CANCELED') && $this->id) 
        {
        	if(!$this->context) {
        		$this->context = Context::getContext();
        	}

        	$multiple_orders_str = 'order';
        	if(sizeof($order_ids) > 1) {
        		$multiple_orders_str = 'orders';
        	}

        	$data['{total_paid}'] = Tools::displayPrice((float)Tools::ps_round((float)$this->context->cart->getOrderTotal(true, Cart::BOTH, $product_list, $id_carrier) , _PS_PRICE_COMPUTE_PRECISION_), $this->context->currency, false);
        	$data['{total_discounts}'] = Tools::displayPrice((float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS, $product_list, $id_carrier)), $this->context->currency, false);
        	$data['{total_products}'] = Tools::displayPrice((float)$this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS, $product_list, $id_carrier), $this->context->currency, false); 

        	$combined_order_ids = implode(',', $order_ids);

        	$data['{order_name}'] = '# '.(string)$combined_order_ids;

            if ($this->id_buyer == 3) 
            {
                $customer_name = '' . $this->firstname . ',';

                if ($this->context->cookie->payment_type != 5) // If selected payment option is not approval pending 
                { 
                    $em_sub = 'Order confirmation | Your '.$multiple_orders_str.' with Kobster.com [#' . $combined_order_ids . '] has  been successfully placed!';
                    Mail::Send((int)$id_lang, 'order_conf', Mail::l($em_sub, (int)$id_lang) , $data, $this->email, $this->firstname . ' ' . $this->lastname);

                    if ($this->mobile) {
	                    $msgtxt = 'Hello '.$customer_name.' Your order '.$data['{order_name}'].' has been placed sucessfully.- Kobster.com';
	                    SMSAlert::sendSMSAlert($this->mobile, $msgtxt);
	                }
	                elseif ($invoice->phone_mobile) {
	                    $msgtxt = 'Hello '.$customer_name.' Your order '.$data['{order_name}'].' has been placed sucessfully.- Kobster.com';
	                    SMSAlert::sendSMSAlert($invoice->phone_mobile, $msgtxt);
	                }
                }
                else 
                {
                    if (!$split_order) // Approval pending email should not trigger for split orders
                    {
                        $em_sub = 'Order confirmation | The '.$multiple_orders_str.' with Kobster.com [#' . $combined_order_ids . '] is pending for approval';
                        // Send email stating pending approval
                        Mail::Send((int)$id_lang, 'order_pending_approval', Mail::l($em_sub, (int)$id_lang) , $data, $this->email, $this->firstname . ' ' . $this->lastname);

                        // Send email to approver
                        $approver = $this->getApprover(false, true);
                        for ($i = 0; $i < sizeof($approver); $i++) {
                            $approver_details = new Customer($approver[$i]['id_parent']);
                            Mail::Send((int)$id_lang, 'order_submit_approval', Mail::l($em_sub, (int)$id_lang) , $data, $approver_details->email, $approver_details->firstname . ' ' . $approver_details->lastname);
                            if ($approver_details->mobile) {
                                $msgtxt = 'Hello ' . $approver_details->firstname . ' , The '.$multiple_orders_str.' # '. $combined_order_ids .' is pending for your approval. - Kobster.com';
                                SMSAlert::sendSMSAlert($approver_details->mobile, $msgtxt);
                            }
                        }

                        if ((int)$this->getCustomerRole() == 1 || (int)$this->getCustomerRole() == 2 && $this->context->cookie->payment_type == 5 && $this->context->cookie->creator_customer_id == 0) {
                            foreach ($order_ids as $id_order) {
                            	$old_orgin_order = Order::getOrginOrderId($id_order);
	                            if ($old_orgin_order == "") {
	                            	Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO ' . _DB_PREFIX_ . 'orgin_orders (`id_old_order`, `id_new_order`, `id_customer`) VALUES (' . $id_order . ',' . $id_order . ',' . $this->id . ')');
	                            }
                            }
                        }

		                if ($this->mobile) {
		                    $msgtxt = 'Hello ' . $customer_name . ' Your '.$multiple_orders_str.' # ' . $combined_order_ids . ' has been sent for approval. - Kobster.com';
		                    SMSAlert::sendSMSAlert($this->mobile, $msgtxt);
		                }
		                elseif ($invoice->phone_mobile) {
		                    $msgtxt = 'Hello ' . $customer_name . ' Your '.$multiple_orders_str.' # ' . $combined_order_ids . ' has been sent for approval. - Kobster.com';
		                    SMSAlert::sendSMSAlert($invoice->phone_mobile, $msgtxt);
		                }
                    }
                }
            }
            else {
                $em_sub = 'Order confirmation | Your '.$multiple_orders_str.' with Kobster.com [#' . $combined_order_ids . '] has  been successfully placed!';
                Mail::Send((int)$id_lang, 'order_conf', Mail::l($em_sub, (int)$id_lang) , $data, $this->email, $this->firstname . ' ' . $this->lastname);
            }
        }
	}
	
	public static function getSelectedCategories()
	{
		return Db::getInstance()->ExecuteS('SELECT kcl.`id_category` as value, kcl.`name` as label FROM `kob_selected_category` ksc LEFT JOIN kob_category_lang kcl ON kcl.`id_category` = ksc.`id_category` AND kcl.`id_lang`=1 WHERE kcl.name != ""');
	}

	public static function getSelectedCities()
	{
		return Db::getInstance()->ExecuteS('SELECT kc.id_city as value, kc.name as label FROM `kob_selected_city` ksc LEFT JOIN kob_city kc ON kc.id_city = ksc.id_city');
	}
}
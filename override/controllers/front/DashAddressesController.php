<?php
class DashAddressesControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		$type = Tools::getValue('type');
			 
		$start_memory = memory_get_usage();

		if($type == 1)// to get all country list
		{
			foreach (Country::getCountries(1) AS $country)
				$countryList[] = array('id' => $country['id_country'], 'name' => $country['name']);
			$result = $countryList;

			echo Tools::jsonEncode($result);
		}
		else if($type == 2)/*type=2 update the address of the user*/
		{
			$addressObj = new Address((int)Tools::getValue('id_address'));

			$addressObj->id_customer = (int)($this->context->customer->id);
			$addressObj->id_country = Tools::getValue('country');
			$addressObj->id_state = Tools::getValue('state');
			$addressObj->alias = Tools::getValue('alias');
			$addressObj->address1 = Tools::getValue('address_line');
			$addressObj->city = Tools::getValue('city');
			$addressObj->company = Tools::getValue('company_name');
			$addressObj->firstname = Tools::getValue('contact_person');
			$addressObj->postcode = Tools::getValue('pincode');
			$addressObj->phone_mobile = Tools::getValue('mobile');
			$addressObj->phone = Tools::getValue('land_line');
			
			if($addressObj->update())
				echo "1";
			else
				echo "0";
		}
		else if($type == 3)//to get all address of a customer
		{
			$result = array();
			$customer_id = Tools::getValue('id_customer');
			$customer = new Customer((int)($customer_id));
			$address = $customer->getAddresses(1);//id_lang=1
			$state = new State();
			array_push($result,$address,$state->getStatesByIdCountry(110));

			echo Tools::jsonEncode($result);
		}
		else if($type == 4)/*get state for particular country*/
		{
			$countryId = Tools::getValue('id_country');
			$result = Country::getStates($countryId);

			echo Tools::jsonEncode($result);
		}
		else if($type == 5)/*getLanguages*/
		{
			$result = Language::getAllLanguages();

			echo Tools::jsonEncode($result);
		}
		else if($type == 6)
		{
			$firstname = Tools::getValue('firstname');
			$lastname = Tools::getValue('lastname');
			$company = Tools::getValue('company');
			$address1 = Tools::getValue('address1');
			$gst_no = Tools::getValue('gst_no');
			$city = Tools::getValue('city');
			$state = Tools::getValue('state');
			$postcode = Tools::getValue('postcode');
			$mobile = Tools::getValue('mobile');
			$countryId = Tools::getValue('id_country');
			$alias = Tools::getValue('alias');
			
			$address = new Address();
			 
			$address->firstname = $firstname;
			$address->lastname = $lastname;
			$address->company = $company;
			$address->address1 = $address1;
			$address->vat_number = $gst_no;
			$address->city = $city;
			$address->id_state = $state;
			$address->postcode = $postcode;
			$address->phone_mobile = $mobile;
			$address->id_country = $countryId;
			$address->phone_mobile = $mobile;
			$address->alias = $alias;
			$address->id_customer = $this->context->customer->id;
			if($address->add())
			{
				$id_address = Address::getAddressId($this->context->customer->id);
				$customer_address = new CustomerAddress();
				$customer_address->mapId($this->context->customer->id, $id_address[0]['id_address']);
				$result = 1;
			}

			echo $result;
	 	}
		else if($type == 7)
		{
	 		$customer = new Customer(); 
			$state = new State();
	 		echo Tools::jsonEncode($state->getStatesByIdCountry(110));
	 	}
		else if($type == 8)//to delete user address
		{
			$address_id = Tools::getValue('address_id');
			$id_customer = Tools::getValue('id_customer');
			$result = Address::deleteAddress($address_id, $id_customer);

			echo $result;
		}
		else if($type == 9) // Get address by ID
		{
			$id_address = Tools::getValue('id_address');
			$result = Address::getParticularAddress((int)($id_address));

			echo Tools::jsonEncode($result);
		}
		else if($type == 10)
		{
			$id_address = Tools::getValue('id_address');

			$stateObj = new State();
			$result = array();

			$address = Address::getAddressById((int)($id_address));
			$states = $stateObj->getStatesByIdCountry(110);
			array_push($result, $address, $states);

			echo Tools::jsonEncode($result);
		}
		else if($type == 11) {
			$id_address = Tools::getValue('id_address');
			$id_customer = Tools::getValue('id_customer');
			$action = Tools::getValue('action');
			$result = Address::assignAddressToCustomer($id_customer, $id_address, $action);
			echo Tools::jsonEncode($result);
		}
		else if($type == 12) {
			$id_address = Tools::getValue('id_address');
			$address = new Address($id_address);
			$id_customer = Tools::getValue('id_customer');
			$action = Tools::getValue('action');
			if($id_customer == $address->id_customer)
			{
				$result = Address::assignAddressToCustomer($id_customer, $id_address, $action);
				echo Tools::jsonEncode($result);
			}
			else
			{
				$customer = new Customer($address->id_customer);
				echo $customer->firstname;
			}
		}
		else if($type == 13)
		{
			$id_address = Tools::getValue('id_address');
			$address = new Address($id_address);

			if($this->context->customer->id == $address->id_customer)
			{
				$stateObj = new State();
				$result = array();

				$address = Address::getAddressById((int)($id_address));
				$states = $stateObj->getStatesByIdCountry(110);
				array_push($result, $address, $states);

				echo Tools::jsonEncode($result);
			}
			else
			{
				$customer = new Customer($address->id_customer);
				$array = array();
				$array[0] = '200';
				$array[1] = $customer->firstname;
				echo Tools::jsonEncode($array);
			}
		}
		else if($type == 14) 
		{
			$id_address_delivery = Tools::getValue('id_address_delivery');
			$id_address_billing = Tools::getValue('id_address_billing');
			$this->context->cart->id_address_delivery =(int)$id_address_delivery;
			$this->context->cart->id_address_invoice =(int)$id_address_billing;
			if($this->context->cart->update() && $this->context->cart->updateNewAddressId($id_address_delivery))
				echo "success";
		}
		else if($type == 15) {
			$id_address_delivery = Tools::getValue('id_address_delivery');
			$this->context->cart->id_address_delivery = $id_address_delivery;
			if($this->context->cart->update()) {
				if($this->context->cart->updateNewAddressId($id_address_delivery)) {
					echo Tools::jsonEncode($this->context->cart->getProductsWithSummary());
				}
				else {
					echo "Unable to update delivery address. Please try again.";
				}
			}
			else {
				echo "Unable to update delivery address. Please try again.";
			}
		}
		else if($type == 16) {
			$id_address_invoice = Tools::getValue('id_address_invoice');
			$this->context->cart->id_address_invoice = $id_address_invoice;
			if($this->context->cart->update()) {
				$result = json_encode(array('success'=>true));
				echo $result;
			}
			else {
				echo "Unable to update invoice address. Please try again.";
			}
		}
	}
}


 
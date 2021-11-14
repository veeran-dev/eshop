<?php
class SupplierAddressControllerCore extends FrontController
{
	public function  ajaxReturn(){
		$this->context = Context::getContext();
 		$type= Tools::getValue('type');
 		
 		if($type == 1){
 			$states = State::getStatesByIdCountry((int)Country::getDefaultCountryId());
 			$result = json_encode(array('states'=>$states));
			echo $result;
 		}

 		if($type == 2){
			$firstname = Tools::getValue('firstname');
			$lastname = Tools::getValue('lastname');
			$company = Tools::getValue('company');
			$address1 = Tools::getValue('address1');
			$city = Tools::getValue('city');
			$state = Tools::getValue('state');
			$postcode = Tools::getValue('postcode');
			$mobile = Tools::getValue('mobile');
			$countryId = Tools::getValue('id_country');
			$alias = Tools::getValue('alias');
			
			$supplier_id = $this->context->cookie->s_id ? $this->context->cookie->s_id:$this->context->cookie->supplier_reg_id;
			$address = new Address();
			 
			$address->firstname = $firstname;
			$address->lastname = $lastname;
			$address->company = $company;
			$address->address1 = $address1;
			$address->city = $city;
			$address->id_state = $state;
			$address->postcode = $postcode;
			$address->phone_mobile = $mobile;
			$address->id_country = $countryId;
			$address->phone_mobile = $mobile;
			$address->alias = $alias;
			$address->id_customer = $supplier_id;
			if($address->add())
			{

				$supplierAddress = new EliteSupplierAddress();
				$supplierAddress->id_address = $address->id;
				$supplierAddress->id_supplier = $supplier_id;
				$supplierAddress->add();
				$address_data = new Address($address->id);
        		$address_data = AddressFormat::generateAddress($address_data, $patternRules, '<br />');
        		$result = json_encode(array('address'=>$address_data));
        		echo $result;
			}
			else{
				$result = json_encode(array('error'=>'Something went wrong, please try again later'));
				echo $result;
			}

			echo $result;
	 	}
	 	if($type == 3){
			$result = json_encode(
						array(
 							'selectedCities'=> Customer::getSelectedCities(), 
						));
 			echo $result;
		}
		if($type == 4){
			$result = json_encode(
						array(
 							'selectedCategories'=> Customer::getSelectedCategories(), 
						));
 			echo $result;
		}
	}
}
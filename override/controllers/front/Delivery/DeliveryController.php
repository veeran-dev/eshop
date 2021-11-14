<?php
class DeliveryControllerCore extends FrontController
{
	public function ajaxReturn()
	{
		$request = Tools::getValue('request');
		if($request == 1){
			$password = Tools::getValue('password');
			$this->context->employee = new Employee();
            $is_employee_loaded = $this->context->employee->smartLogin($password);
			if ($is_employee_loaded) {
			    $arr = array(
			        'id_user' => $this->context->employee->id,
			        'name' => $this->context->employee->firstname,
			        'email' => $this->context->employee->email,
			        );
				die(json_encode($arr));
			}
		}
		else if($request == 2){
		    $id_user = $_GET['id_user'];
		    $address = Address::getWaterDeliveryAddress($id_user);
		    $addressPatternRules = Tools::jsonDecode(Configuration::get('PS_INVCE_DELIVERY_ADDR_RULES'), true);
		    foreach($address as &$adrs){
		        $w_address = new Address($adrs['id_address']);
                $adrs['location_address'] = AddressFormat::generateAddress($w_address, $addressPatternRules, ',', ' ');
                $adrs['show_address'] = AddressFormat::generateAddress($w_address, $addressPatternRules, '~', ' ');
		    }
		    die(json_encode($address));
		}
		else if($request == 3){
		    //upload file and save 
		    
            $file = Tools::getValue('file');
		    $delivered = Tools::getValue('delivered');
		    $empty = Tools::getValue('empty');
		    $id_address = Tools::getValue('id_address');
		    $data = explode("~",Tools::getValue('id_employee'));
		    $id_employee = $data[0];
		    $id_product = $data[1];
		    
		    $waterDelivery = new WaterDelivery();
		    $waterDelivery->empty = $empty;
		    $waterDelivery->delivered = $delivered;
		    $waterDelivery->id_address = $id_address;
		    $waterDelivery->id_employee = $id_employee;
		    $waterDelivery->id_product = $id_product;
		    $waterDelivery->save();
		    $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
		    $target_file = _PS_ROOT_DIR_.'/waterDRs/'.$waterDelivery->id.'.'.$ext;
		    
		    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
    		    return true;
		    }
		    else{
		        return false;
		    }
		}
		else if($request == 4){
		    die(json_encode(Product::getWaterProducts()));
		}
	}
}


?>
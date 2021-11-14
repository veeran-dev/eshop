<?php
class CommonDataControllerCore extends FrontController
{
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		if($type == 1){
			$result = json_encode(
						array(
 							'selectedCities'=> Customer::getSelectedCities(), 
						));
 			echo $result;
		}
		if($type == 2){
			$result = json_encode(
						array(
 							'selectedCategories'=> Customer::getSelectedCategories(), 
						));
 			echo $result;
		}
		if($type == 3){
			$result = json_encode(
						array(
 							'allStates'=> State::getStates(), 
						));
 			echo $result;
		}

	}
}
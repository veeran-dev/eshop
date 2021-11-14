<?php
/*Created this file to update the price for all the products under one or more parent category using the lowest specific price from the specific price table.*/
class PriceUpdateControllerCore extends DashController
{
	public function ajaxReturn()
	{
		$parent_category_id = [2,3];
		SpecificPrice::changeCategoryProductPrice($parent_category_id);
	}
}



?>
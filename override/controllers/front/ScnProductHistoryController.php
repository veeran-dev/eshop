<?php
class ScnProductHistoryControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		$start_memory = memory_get_usage();
	
		$type = Tools::getValue('type');
		$id_product = Tools::getValue('id_product');
		$id_fc = Tools::getValue('id_fc');
		 

		if($type == 1)// search for product
		{
			 
			$result = ScnVendorInfo::getProductHistory($id_product, $id_fc);
			
		}
		
		echo Tools::jsonEncode($result);
	}
}
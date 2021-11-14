<?php
/*
*
* Supplier main controller
*
*/
class EliteSupplierControllerCore extends FrontController 
{
	public function ajaxReturn() 
	{
		$type = $_GET['type'];
		if($type == 1){
			$id_customer = $_GET['id_customer'];
			die(json_encode(array(
				'suppliers'=>EliteSupplier::getSuppliers($id_customer),
				)));
		}
	}
}
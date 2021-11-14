<?php
class RMCatalogControllerCore extends BackController
{
	public function displayContent()
	{
		global $cookie;
		$catalogHistory = new CatalogHistory();
		$customer_details = $catalogHistory->affectedCustomers(self::$cookie->id_employee);
		$product_details = $catalogHistory->taggedCustomersProduct(self::$cookie->id_employee);
		$currency = new Currency((int)$this->context->cookie->id_currency);
		$this->context->smarty->assign('customer_details', $customer_details);
		$this->context->smarty->assign('product_details_others', $product_details[0]);
		$this->context->smarty->assign('product_details_price', $product_details[1]);
		$this->context->smarty->assign('currency', $currency->sign);
		$this->context->smarty->display('rm/rm-catalog.tpl');
 	}

 	public function ajaxReturn(){

 		$id_catalog_change = Tools::getValue('id_catalog_change');
 		$id_catalog_changes = Tools::getValue('id_catalog_changes');
 		$notification_comapany = Tools::getValue('notification_comapany');
 		$id_company = Tools::getValue('id_company');
 		$quote_details = Tools::getValue('quote_details');
 		$quote = Tools::getValue('quote');

 		$catalogHistory = new CatalogHistory($id_catalog_change);

 		/* single notification read */
 		if($id_catalog_change >= 1){
 			return $catalogHistory::read($id_catalog_change, $id_company);
 		}

 		/* multiple notification read */
 		if($id_catalog_changes){
 			$ids = explode(",", $id_catalog_changes);
			return $catalogHistory::read($ids, $id_company);
 		}

 		/* create quote and products */
 		if(isset($quote)){
 			$group =new Group($id_company);
 			$quotationObj = new ScnQuotation();
 			$date = date("yy-mm-dd h:i:sa");
			$quotationObj->id_group = $id_company;
			$quotationObj->id_employee = self::$cookie->id_employee;
			$quotationObj->quote_name = $group->name[1]."-".$date."-catalog";
			$quotationObj->quote_version = 1;
			$quotationObj->active = 1;
			$quotationObj->date_generated = date('Y-m-d H:i:s');
			if($quotationObj->add()){
				if($quotationObj->addRegion(0)) {
					$result = array();
					$quote_regions = $quotationObj->getRegions();
					array_push($result, $quotationObj->id_quotation, $quote_regions);
				}
			}
			else{
				echo "0";
				return false;
			}
			foreach (json_decode($quote_details) as $product) 
			{
				$date=date("Y-m-d H:i:s",strtotime($product->expiry_date));
				$result = $quotationObj->addProdToQuotation($quote_id = $quotationObj->id, $prod_id = $product->id_product, $prod_price = $product->price, $remark = "", $date = $date);
	 		}
	 		echo $quotationObj->id;
	 		return true;
	 	}

 	}


 	public function displayHeader($display = false){

 	}
 	public function displayFooter($display = false){

 	}
}
?>
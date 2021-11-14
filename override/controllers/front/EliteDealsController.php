<?php
/*
* Pantry campaign controller added by Elumalai K
*/
class EliteDealsControllerCore extends FrontController 
{
	public $php_self = 'elite-deals';

	public function display() {
		// var_dump($this->context->cookie);
		if($this->context->cookie->id_customer){
			$id_fc = (Tools::getValue("id_fc") ? Tools::getValue("id_fc"):2);
			$products = Inventory::getProductsDetails($id_fc);
			$fc = FulfillmentCentre::getAllFCentres();
			// var_dump($id_fc);
			$this->context->smarty->assign('products', $products);
			$this->context->smarty->assign('fc', $fc);
			$this->context->smarty->assign('id_fc', $id_fc);
			$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/elite-deals.tpl');
		}
		else{
			Tools::redirect('dash-login');
		}
	}

	public function displayHeader($display = false) {
		return false;
	}

	public function displayFooter($display = false) {
		return false;
	}
}

?>
<?php 
include_once(dirname(__FILE__).'/../../../modules/ebs/ebs.php');
class DashEBSDataControllerCore extends DashController
{
	public function ajaxReturn()
	{	
 		$type = Tools::getValue('type');
		$orderid = Tools::getValue('orderid');
		$id_address_delivery = Tools::getValue('id_address_delivery');
		$id_address_invoice = Tools::getValue('id_address_invoice');

		if(isset($id_address_delivery) && $id_address_delivery != ""){
  			$this->context->cart->id_address_delivery =(int)$id_address_delivery;
			$this->context->cart->id_address_invoice =(int)$id_address_invoice;
			$this->context->cart->update();
  		}

 		if($type == 1) {
			self::$cookie->dash=1;
			self::$cookie->child_approver=1;
			self::$cookie->child_id_order=$orderid;
			
			$order = new Order($orderid);
			$cart = new Cart($order->id_cart);
			$this->context->cart = $cart;
			$params=array('cookie' => self::$cookie, 'cart' => $this->context->cart);
		}
		else
			$params=array('cookie' => self::$cookie, 'cart' => self::$cart);
		
 		$ebs = new EBS();
		$start_memory = memory_get_usage();
		$result = $ebs->processEBSData($params['cart'], NULL);
  		echo Tools::jsonEncode($result);
	}
}
?>
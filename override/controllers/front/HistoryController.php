<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14006 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class HistoryController extends HistoryControllerCore
{
	public $auth = true;
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$id_order = Tools::getValue('id_order');
		$mulOrderId = Tools::getValue('mulOrderId');
		$delivery_add = Tools::getValue('delivery_add');
		$invoice_add = Tools::getValue('invoice_add');
		$customer_id = Tools::getValue('id_customer');
		$customer = new Customer((int)($this->context->cookie->id_customer));
		$order = new Order($id_order);
		$token = Tools::getAdminTokenLiteCustom('AdminPdf',Tools::getValue('id_employee'));

		$fromDate = Tools::getValue('fromDate');
		$toDate = Tools::getValue('toDate');
		$duration = Tools::getValue('duration');
		$idPage = Tools::getValue('idPage');
		$limit = Tools::getValue('limit');
		$orderBy = Tools::getValue('orderBy');
		$orderWay = Tools::getValue('orderWay');
		$searchQuery = Tools::getValue('q');
		$limit ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
		$offset = (PAGE_PER_NO * intval($idPage));

		if($type == 1 )
		{
  			$result = Order::getCustomerOrders(
  												(int)($this->context->cookie->id_customer), 
  												false,
  												NULL,
  												$limit, 
  												$offset, 
  												$fromDate, 
  												$toDate, 
  												$duration, 
  												$orderBy, 
  												$orderWay, 
  												$searchQuery, 
  												$dash = true
  											);

			/* Below data cannot be executed. Because, Not necessary as per Elite v.0.2 */
			if($this->context->cookie->id_customer) {
				if($result['results']) {
					for($i = 0; $i < sizeof($result['results']); $i++)
					{
						// $order = new Order($result['results'][$i]['id_order']);
						// $result['results'][$i]['orderids']='';
						// if($order->invoice_number){
						// 	foreach($order->getConsolidatedInvoice() as $orderid){
						// 		$result['results'][$i]['orderids'] .='&id_order[]='.$orderid['id_order'];
						// 	}
						// }

						$result['results'][$i]['delivery_number'] = sprintf('%06d', $result['results'][$i]['delivery_number']);
						$result['results'][$i]['token_pdf'] = $token;
					}
				}
			}

			if($result['total'])
				$result['total'] = ceil($result['total'] / PAGE_PER_NO);

			echo Tools::jsonEncode($result);
		}
		else if($type == 2)
		{
			$result = array();
			$addressObj = new Address();
			// For Order Status flow
			$history = OrderHistory::getAllStatus($id_order, $id_lang = 1);
			// Fetching addresses
 			$addressInvoice = $addressObj->getParticularAddress($order->id_address_invoice);
			$addressDelivery = $addressObj->getParticularAddress($order->id_address_delivery);
			// GET ordered products
 			$productDetails = $order->getDashProducts($products = false, $selectedProducts = false, $selectedQty = false, $orderid = $id_order);
 			// GET Tax type incl. or excl. 
 			$tax[] = Configuration::get('PS_TAX');
			// GET shopping summary
  			$order_details = $order->getFields();
  			// Get supplier
  			$supplier = $order->getSupplier('name');

			array_push($result, $history, $addressInvoice, $addressDelivery, $productDetails, $tax, $order_details, $supplier);
			
			echo Tools::jsonEncode($result);
		}
		else if($type==3)
		{
			$orderObj = new Order(intval($id_order));
			$child_customer = $orderObj->getCusIdForOrder();
			$customer_role = Customer::getCurrentCustomerRole();

			if((int)$customer_role != 2 || $customer_role != 3)
			{
				$oldCart = new Cart($orderObj->getCartIdStatic((int)$id_order, (int)$child_customer));
			}
			else
			{
			    $oldCart = new Cart($orderObj->getCartIdStatic((int)$id_order, (int)$this->context->cookie->id_customer));
			}

			// Get supplier ID of the current order. May cart can have multiple suppliers.
			$supplier_id = $orderObj->getSupplier();
			$id_state = $this->context->cookie->id_state;

			$address = new Address($orderObj->id_address_delivery);
			$result = array();
			if($address->id_state != $id_state) {
 				$errors_m = array(
					"name" => 'Order Delivery State', 
					"msg" => 'Order contains different delivery state, please change the state to proceed.'
				);
  				array_push($result, $errors_m);
  				echo Tools::jsonEncode($result);
 				return false;
 			}
 			// $product = $oldCart->getReorderProducts($oldCart->id, $supplier_id);
 			$product = $orderObj->getAllProductsDetails();
 			$productRemoved = $orderObj->getRemovedProducts();

  			
  			if(sizeof($product) > 0 || $productRemoved[0]['id_product']) {
  				if(sizeof($product) > 0) {
	  				for($i = 0; $i < sizeof($product); $i++ )
					{
						$final_result = ControllerFactory::getController('CartController')->mulProductAdd($product[$i], 
							$product[$i]['product_id'], 
							$supplier_id,
							$product[$i]['product_quantity']
						);

						if($final_result != "") {
							array_push($result,$final_result);
						}
					}
				}
				if($productRemoved[0]['id_product']){
					for($i = 0; $i < sizeof($productRemoved); $i++ )
					{
						$final_result = ControllerFactory::getController('CartController')->mulProductAdd($productRemoved[$i], 
							$productRemoved[$i]['id_product'], 
							$supplier_id,
							$productRemoved[$i]['product_quantity']
						);

						if($final_result != "") {
							array_push($result,$final_result);
						}
					}	
				}
  			}
  			else {
  				$errors_m = array(
					"name" => 'All Products', 
					"msg" => 'Sorry unable to find the products to reorder.'
				);
  				array_push($result, $errors_m);
  			}
			
			echo Tools::jsonEncode($result);
		}
		else if($type == 4)
		{
			//$result  = OrderHistory::getAllStatus($id_order,$id_lang = 1);
			$result = $order->getHistory((int)($this->context->language->id), false, true);
			echo Tools::jsonEncode($result);
		}
		else if($type == 5)//Order status in home page
		{
			$result = Order::getCustomerOrders(
												(int)($this->context->cookie->id_customer),
												false,
												NULL, 
												$limit, 
												$offset, 
												$fromDate, 
												$toDate, 
												$duration, 
												NULL, 
												NULL, 
												NULL, 
												$dash = true
											);
			$result['pageId'] = $idPage;

			if($result['total'])
				$result['total'] = ceil($result['total'] / PAGE_PER_NO);

			echo Tools::jsonEncode($result);
		}
		else if($type == 6)
		{
			$mulOrderId = explode(",",$mulOrderId);
			for($i = 0; $i < 3; $i++){
				$result[] = OrderHistory::getShippedOrderTime($mulOrderId[$i],$id_lang = 1);
			}

			echo Tools::jsonEncode($result);
		}
		else if($type == 7)
		{
			$order = new Order();
  			$result = $order->getChildrenOrders(
												 $this->context->cookie->id_customer, 
												 $limit, 
												 $offset, 
												 $fromDate, 
												 $toDate, 
												 $duration, 
												 $orderBy, 
												 $orderWay, 
												 $searchQuery
											);
  			
  			if($result['results']){
  				$result['total'] = ceil($result['total'] / PAGE_PER_NO);
  			}

  			$result['pageId'] = $idPage;
  			echo Tools::jsonEncode($result);
		}
		else if($type == 8) 
		{
			$order = new Order();
  			$result = $order->getChildrenOrders(
												  $this->context->cookie->id_customer, 
												  $limit, 
												  $offset, 
												  $fromDate, 
												  $toDate, 
												  $duration, 
												  NULL, 
												  NULL, 
												  NULL
											);
  			
  			if($result['results']){
  				$result['total'] = ceil($result['total'] / PAGE_PER_NO);
  			}

  			$result['pageId'] = $idPage;
  			echo Tools::jsonEncode($result);
		}
		else if($type == 9){
			$id_supplier = EliteSupplierOrders::getOrderSupplier($id_order);
			$supplier_order = new EliteSupplierOrders($id_supplier);
			$result = json_encode($supplier_order->getOrderDetails($id_order));
 			echo $result;
		}
 	}
}


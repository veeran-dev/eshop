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

class WidgetControllerCore extends FrontController
{
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$id_widget = Tools::getValue("id_widget");
		$is_paid = Tools::getValue('is_paid');
		$active = Tools::getValue('active');
		$position = Tools::getValue('position');
		$po_option = Tools::getValue('id_option');

		$id_user = $this->context->cookie->id_customer;
		$userRole = Customer::getCurrentCustomerRole();

		// Initialize widget object to specific widget
		$widgetObj = new Widget((int)($id_widget));
		// Initializing empty widget object
		$widget = new Widget();

		if($type == 1) // Installation of widget
		{
			if((int)($userRole) >= (int)($widgetObj->id_role)) {
				$data = array(
  					'id_widget' => $widgetObj->id,
  					'id_user' => $id_user,
  					'paid' => $is_paid,
  					'position' => $position,
  					'active' => $active,
  					'date_add' => date("Y-m-d H:i:s"), 
  					'date_upd' => date("Y-m-d H:i:s")
  				);

				if($widget->installNewWidget($data)) 
				{
					if($widgetObj->id == 17) 
					{
						/****Install new widget to all users in company starts****/
						//Get all users in company for widget installation
			            $customerObj = new Customer(intval($id_user));
				  		$allUsers = $customerObj->getAllCustomersByGroup();
				  		// If any of user in company already installed widget and is active now - Install that to this user
				  		if(sizeof($allUsers) > 0) {
				  			foreach ($allUsers as $key => $user) {
				  				if($widget->userHasWidget($user['id_customer'], 1)) {}
				  				else if($widget->userHasWidget($user['id_customer'], 0)) {}
				  				else {
				  					$data['id_user'] = $user['id_customer'];
				  					if($id_user != $user['id_customer']) {
				  						$widgetObj->installNewWidget($data);
				  					}
				  				}
				  			}
				  		}
				  		/****Company level installation ends****/

						$purchaseOrder = new PurchaseOrder();
						$purchaseOrder->setPoOption($id_user, $po_option);
						$this->context->cookie->budget_option = $po_option;
						$this->context->cookie->id_address_budget = "";
	 					$this->context->cookie->id_address_delivery = "";
	 					$this->context->cookie->id_purchase_order = "";
	 					$this->context->cookie->po_number = "";
						// Delete cart associations to avoid using already added cart with products.
						$cart = new Cart($this->context->cookie->id_cart);
						$cart->deleteAssociations();	
					}

					echo 1;
				}
				else 
				{
					echo 0;
				}
			}
			else {
				if($widgetObj->id == 17) {
					echo "Sorry, this feature is only for approvers";
				}
				else {
					echo "You don't have an access to add this widget";
				}
			}
		}
		else if($type == 2) // Get All widgets for store
		{
			$widgets = $widget->getAllWidgets();

			/**Check whether widget is installed to user - if installed show already installed text.
			  *If not installed and is default and active show install button
			  *If not installed - price is mentioned - show Buy Now Button
			  */

			foreach ($widgets as $key => $value) {
				$widgetObjUser = new Widget((int)($value['id_widget']));
				$widgets[$key]['installed'] = $widgetObjUser->userHasWidget((int)($id_user), 1);
			}

			echo Tools::jsonEncode($widgets);
		}
		else if($type == 3) // Check if user have an access to widget
		{
			echo Tools::jsonEncode(parent::userWidgetCheck());
		}
		else if($type == 4) // Get dashboard widgets
		{
			echo Tools::jsonEncode($widget->getDashboardWidgetsByUser($id_user));
		}
		else if($type == 5)
		{
			if((int)($userRole) >= (int)($widgetObj->id_role)) {
				$result = $widget->uninstallWidget($id_widget, $id_user);
				if($result) {
					if($id_widget == 17) {
			            $this->context->cookie->budget_configured = 0;
			            $this->context->cookie->id_address_budget = 0;
			            $this->context->cookie->budget_option = 0;
			            $this->context->cookie->id_purchase_order = "";
	 					$this->context->cookie->po_number = "";
			            $customerObj = new Customer(intval($id_user));
			            $allUsers = $customerObj->getAllCustomersByGroup();
				  		// If any of user in company already installed widget and is active now - Install that to this user
				  		if(sizeof($allUsers) > 0) {
				  			foreach ($allUsers as $key => $user) {
				  				if($id_user != $user['id_user']) {
				  					$widget->uninstallWidget($id_widget, $user['id_customer']);
				  				}
				  			}
				  		}
			        }

			        echo 1;
				}
				else {
					echo "Error while removing widget. Please try again.";
				}
			}
			else {
				if($id_widget == 17) {
					echo "Sorry, this feature can be removed by approvers only";
				}
				else {
					echo "You don't have an access to remove this widget.";
				}
			}
		}
		else if($type == 6) {
			echo Tools::jsonEncode($widgetObj->getWidgetById());
		}
 	}
}
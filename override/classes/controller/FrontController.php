<?php
class FrontController extends FrontControllerCore
{
	public function ajaxCall()
	{
 		$this->init();
 		$supplier_token = Tools::getValue("supplier_token");
  		$url = $_SERVER[REQUEST_URI];
 		if(strpos( $url, 'elite-supplier-auth.php' ) === false && strpos( $url, 'elite-supplier-address.php' ) === false ) {
      		if($supplier_token==true && ($this->context->cookie->s_id ==0 || $this->context->cookie->s_id ==null) ) {
                 http_response_code(401);
             }
             else if($supplier_token==true && $this->context->cookie->s_id >0) {
                 $this->context->cookie->last_activity = time();
                 $this->context->cookie->write();
             }
 		}
		// $this->preProcess();
		/*$logger = new FileLogger();
		$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
		$logger->logInfo("Ajax Call :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname);*/
		$this->ajaxReturn();
  	}

  	public function postProcess()
    {
        //User widget installation at initial load.
        if($this->context->cookie->id_customer) 
        {
            $customerObj = new Customer((int)($this->context->cookie->id_customer));
            $customerRole = $customerObj->getCustomerRole();
            // Allow only corporate customers to install widget
            if($customerObj->id_buyer == 3) 
            {
                $widgetObj = new Widget();
                // Get all active widgets
                $defaultWidgets = $widgetObj->getAllWidgets(true);
                
                foreach ($defaultWidgets as $widget_key => $widget_value) 
                {
                 	// Initialize particular widget object 
                    $widget = new Widget((int)($widget_value['id_widget']));

                    if($widget->userHasWidget($customerObj->id, 1)) {} // If user has widget and active - No installation required
                    else if($widget->userHasWidget($customerObj->id, 0)) {} //If user has widget and uninstalled - No installation required
                   	else {
                   		// Widget data to insert in widget_users table
                   		$data = array(
		  					'id_widget' => $widget->id,
		  					'id_user' => $customerObj->id,
		  					'paid' => 0,
		  					'position' => 0,
		  					'active' => 1,
		  					'date_add' => date("Y-m-d H:i:s"), 
		  					'date_upd' => date("Y-m-d H:i:s")
		  				);

				  		if((int)$widget->id_role <= (int)$customerRole) {
					  		$widgetObj->installNewWidget($data);
				  		}
                   	}                   		
                }
            }

            /* Set budget configuration variable */
            $widgetObj = new Widget(Widget::BUDGET);
            if($widgetObj->userHasWidget($customerObj->id, 1)) { // Allow only if user has widget already installed
            	$po_option = PurchaseOrder::getPoOption($customerObj->id_default_group);
				$this->context->cookie->budget_option = $po_option != "" ? $po_option : 0;

				if($widgetObj->isBudgetConfigured($this->context->cookie->id_customer)) {

	            	$budget_widget = new Widget(Widget::BUDGET);
	            	if($budget_widget->userHasWidget($this->context->cookie->id_customer, 1)) {
						$this->context->cookie->budget_configured = 1;
	            	}
	            }
	            else {
					$this->context->cookie->budget_configured = 0;
	            }
            }
        }
    }

	public function getViewPortContent()
	{
			$this->init();
		//$this->preProcess();
		$this->displayContent();	
	}

	public function userWidgetCheck()
	{
		$is_widget = Tools::getValue("widget");
		$id_widget = Tools::getValue("id_widget");
		$id_user = $this->context->cookie->id_customer;
		$userRole = Customer::getCurrentCustomerRole();

		$widgetObj = new Widget((int)($id_widget));

		if($is_widget) {
			if($widgetObj->isDefault() || (int)($userRole) >= (int)($widgetObj->id_role)) {
				if($widgetObj->userHasWidget($id_user, 1)) 
					return 1;
				else
					return 2;
			}
			else {
				return 3;
			}
		}
		else {
			//No widget check. Free to go..
			return 1;
		}
	}

	public function getShopSaleStatus() {
		$now = strtotime(Date("Y-m-d H:i:s"));
        $target1 = strtotime(Date('2017-06-27 23:59:59'));
        $target2 = strtotime(Date('2017-07-04 23:59:59'));
        $noSales = 0;
        
        if($now < $target1 || $now > $target2){
            $noSales = 0;
        }
        else{
            $noSales = 1;
        }
        
        return $noSales;
	}
}
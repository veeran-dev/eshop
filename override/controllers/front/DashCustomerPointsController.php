<?php
class DashCustomerPointsControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		$type = Tools::getValue('type');
		$id_customer = Tools::getValue('id_customer');
		$totalPoints = Tools::getValue('totalPoints');
		$totalValue = Tools::getValue('totalValue');
		$orderIDs = Tools::getValue('orderIDs');
		// Initialize loyalty object
		$loyaltyObj = new LoyaltyPoints();

		if($type == 1)//to display individual points for a customer.
		{
			$customer_points = $loyaltyObj->getAllByIdCustomer($id_customer, 1, true, false, 10, 1);
			$voucher_points = $loyaltyObj->getPointsByCustomer($id_customer);
			$voucher_value = $loyaltyObj->getVoucherValue($voucher_points);
			
			$loyalty = array();
			array_push($loyalty, $voucher_value, $voucher_points);
			
			$convert_points_array = array();
			array_push($convert_points_array, $loyalty, $customer_points, Configuration::get('PS_LOYALTY_POINT_VALUE'));
			
			echo Tools::jsonEncode($convert_points_array, $loyalty, $customer_points );
		
		}
		else if($type ==  3)// to convert points into vouchers
		{
			/* Generate a voucher code */
			$voucher_code = null;
			do{
				$voucher_code = 'FID'.rand(1000, 100000);
			}
			while (CartRule::cartRuleExists($voucher_code));

			// Voucher creation and affectation to the customer
			$cartRuleObj = new CartRule();
			$cartRuleObj->code = $voucher_code;
			$cartRuleObj->id_customer = (int)$id_customer;
			$cartRuleObj->reduction_currency = 4;
			$cartRuleObj->reduction_amount = $loyaltyObj->getVoucherValue((int)$totalPoints);
			$cartRuleObj->quantity = 1;
			$cartRuleObj->highlight = 1;
			$cartRuleObj->quantity_per_user = 1;
			$cartRuleObj->reduction_tax = (bool)Configuration::get('PS_LOYALTY_TAX');

			// If merchandise returns are allowed, the voucher musn't be usable before this max return date
			//$date_from = $loyaltyObj->dateAdd((int)$id_customer);

			// if (Configuration::get('PS_ORDER_RETURN'))
			// 	$date_from += 60 * 60 * 24 * (int)Configuration::get('PS_ORDER_RETURN_NB_DAYS');

			$cartRuleObj->date_from = date('Y-m-d H:i:s');
			$cartRuleObj->date_to = date('Y-m-d H:i:s', strtotime($cartRuleObj->date_from.' +1 year'));

			$cartRuleObj->minimum_amount = (float)Configuration::get('PS_LOYALTY_MINIMAL');
			$cartRuleObj->minimum_amount_currency = (int)$this->context->currency->id;
			$cartRuleObj->active = 1;

			$categories = Configuration::get('PS_LOYALTY_VOUCHER_CATEGORY');
			if ($categories != '' && $categories != 0)
				$categories = explode(',', Configuration::get('PS_LOYALTY_VOUCHER_CATEGORY'));
			else
				die (Tools::displayError());

			$languages = Language::getLanguages(true);
			$default_text = Configuration::get('PS_LOYALTY_VOUCHER_DETAILS', (int)Configuration::get('PS_LANG_DEFAULT'));

			foreach ($languages as $language)
			{
				$text = Configuration::get('PS_LOYALTY_VOUCHER_DETAILS', (int)$language['id_lang']);
				$cartRuleObj->name[(int)$language['id_lang']] = $text ? strval($text) : strval($default_text);
			}


			$contains_categories = is_array($categories) && count($categories);
			if ($contains_categories)
				$cartRuleObj->product_restriction = 1;

			$cartRuleObj->add();

			//Restrict cartRules with categories
			if ($contains_categories)
			{
				//Creating rule group
				$id_cart_rule = (int)$cart_rule->id;
				$sql = "INSERT INTO "._DB_PREFIX_."cart_rule_product_rule_group (id_cart_rule, quantity) VALUES ('$id_cart_rule', 1)";
				Db::getInstance()->execute($sql);
				$id_group = (int)Db::getInstance()->Insert_ID();

				//Creating product rule
				$sql = "INSERT INTO "._DB_PREFIX_."cart_rule_product_rule (id_product_rule_group, type) VALUES ('$id_group', 'categories')";
				Db::getInstance()->execute($sql);
				$id_product_rule = (int)Db::getInstance()->Insert_ID();

				//Creating restrictions
				$values = array();
				foreach ($categories as $category) {
					$category = (int)$category;
					$values[] = "('$id_product_rule', '$category')";
				}
				$values = implode(',', $values);
				$sql = "INSERT INTO "._DB_PREFIX_."cart_rule_product_rule_value (id_product_rule, id_item) VALUES $values";
				Db::getInstance()->execute($sql);
			}

			// Register order(s) which contributed to create this voucher
			if (!$loyaltyObj->registerDiscount($cartRuleObj, $orderIDs)){
				$cartRuleObj->delete();
			}
			else{
				echo 1;
			}				
		}
		else if($type == 4)// to list all the available vouchers
		{
			$display_voucher = $loyaltyObj->displayVoucher($id_customer);
			echo Tools::jsonEncode($display_voucher);
			
		}
		else if($type == 5)
		{
			$count_voucher_value = $loyaltyObj->countVoucher($id_customer);
			echo $count_voucher_value;
		}
		else if($type == 6)
		{
			$result = array();
			$voucher_points = $loyaltyObj->getPointsByCustomer($id_customer);
			$voucher_value = $loyaltyObj->getVoucherValue($voucher_points);
			array_push($result, $voucher_points, $voucher_value);

			echo Tools::jsonEncode($result);
		}
	}
}
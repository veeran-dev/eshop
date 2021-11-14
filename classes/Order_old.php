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
*  @version  Release: $Revision: 14927 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class OrderCore extends ObjectModel
{
	/** @var integer Delivery address id */
	public 		$id_address_delivery;

	/** @var integer Invoice address id */
	public 		$id_address_invoice;

	/** @var integer Cart id */
	public 		$id_cart;

	/** @var integer Currency id */
	public 		$id_currency;

	/** @var integer Language id */
	public 		$id_lang;

	/** @var integer Customer id */
	public 		$id_customer;

	/** @var integer id_fc */
	public 		$id_fc;

	/** @var integer Carrier id */
	public 		$id_carrier;

	/** @var string Secure key */
	public		$secure_key;

	/** @var string Payment method id */
	public 		$payment;

	/** @var string Payment module */
	public 		$module;

	/** @var float Currency conversion rate */
	public 		$conversion_rate;

	/** @var boolean Customer is ok for a recyclable package */
	public		$recyclable = 1;

	/** @var boolean True if the customer wants a gift wrapping */
	public		$gift = 0;

	/** @var string Gift message if specified */
	public 		$gift_message;

	/** @var string Shipping number */
	public 		$shipping_number;

	/** @var float Discounts total */
	public 		$total_discounts;

	/** @var float Total to pay */
	public 		$total_paid;

	/** @var float Total really paid */
	public 		$total_paid_real;

	/** @var float Products total */
	public 		$total_products;

	/** @var float Products total tax excluded */
	public 		$total_products_wt;

	/** @var float Shipping total */
	public 		$total_shipping;

	/** @var float Shipping tax rate */
	public 		$carrier_tax_rate;

	/** @var float Wrapping total */
	public 		$total_wrapping;

	/** @var integer Invoice number */
	public 		$invoice_number;

	/** @var integer Delivery number */
	public 		$delivery_number;

	/** @var string Invoice creation date */
	public 		$invoice_date;

	/** @var string Delivery creation date */
	public 		$delivery_date;

	/** @var boolean Order validity (paid and not canceled) */
	public 		$valid;
	
	/*Estimated time of delivery*/
	public $estimated_delivery_time;

	/** @var string Object creation date */
	public 		$date_add;

	/** @var string Object last modification date */
	public 		$date_upd;
	
	

	protected $tables = array ('orders');

	protected	$fieldsRequired = array('conversion_rate', 'id_address_delivery', 'id_address_invoice', 'id_cart', 'id_currency', 'id_lang', 'id_customer', 'id_carrier', 'payment', 'total_paid', 'total_paid_real', 'total_products', 'total_products_wt');
	protected	$fieldsValidate = array(
		'id_address_delivery' => 'isUnsignedId',
		'id_address_invoice' => 'isUnsignedId',
		'id_cart' => 'isUnsignedId',
		'id_currency' => 'isUnsignedId',
		'id_lang' => 'isUnsignedId',
		'id_customer' => 'isUnsignedId',
		 
		'id_carrier' => 'isUnsignedId',
		'secure_key' => 'isMd5',
		'payment' => 'isGenericName',
		'recyclable' => 'isBool',
		'gift' => 'isBool',
		'gift_message' => 'isMessage',
		'total_discounts' => 'isPrice',
		'total_paid' => 'isPrice',
		'total_paid_real' => 'isPrice',
		'total_products' => 'isPrice',
		'total_products_wt' => 'isPrice',
		'total_shipping' => 'isPrice',
		'carrier_tax_rate' => 'isFloat',
		'total_wrapping' => 'isPrice',
		'shipping_number' => 'isUrl',
		'conversion_rate' => 'isFloat',
	);

	protected	$webserviceParameters = array(
		'objectMethods' => array('add' => 'addWs'),
		'objectNodeName' => 'order',
		'objectsNodeName' => 'orders',
		'fields' => array(
			'id_address_delivery' => array('xlink_resource'=> 'addresses'),
			'id_address_invoice' => array('xlink_resource'=> 'addresses'),
			'id_cart' => array('xlink_resource'=> 'carts'),
			'id_currency' => array('xlink_resource'=> 'currencies'),
			'id_lang' => array('xlink_resource'=> 'languages'),
			'id_customer' => array('xlink_resource'=> 'customers'),
			'id_carrier' => array('xlink_resource'=> 'carriers'),
			'module' => array('required' => true),
			'invoice_number' => array(),
			'invoice_date' => array(),
			'delivery_number' => array(),
			'delivery_date' => array(),
			'valid' => array(),
			'current_state' => array('getter' => 'getCurrentState', 'setter' => 'setCurrentState', 'xlink_resource'=> 'order_states'),
		),
		'associations' => array(
			'order_rows' => array('resource' => 'order_row', 'setter' => false, 'virtual_entity' => true,
				'fields' => array(
					'id' =>  array(),
					'product_id' => array('required' => true),
					'product_attribute_id' => array('required' => true),
					'product_quantity' => array('required' => true),
					'product_name' => array('setter' => false),
					'product_price' => array('setter' => false),
			)),
		),

	);

	/* MySQL does not allow 'order' for a table name */
	protected 	$table = 'orders';
	protected 	$identifier = 'id_order';
	protected	$_taxCalculationMethod = PS_TAX_EXC;

	protected static $_historyCache = array();

	public function getFields()
	{
		parent::validateFields();

		$fields['id_address_delivery'] = (int)($this->id_address_delivery);
		$fields['id_address_invoice'] = (int)($this->id_address_invoice);
		$fields['id_cart'] = (int)($this->id_cart);
		$fields['id_currency'] = (int)($this->id_currency);
		$fields['id_lang'] = (int)($this->id_lang);
		$fields['id_customer'] = (int)($this->id_customer);
		$fields['id_fc'] = (int)($this->id_fc);
		$fields['id_carrier'] = (int)($this->id_carrier);
		$fields['secure_key'] = pSQL($this->secure_key);
		$fields['payment'] = pSQL($this->payment);
		$fields['module'] = pSQL($this->module);
		$fields['conversion_rate'] = (float)($this->conversion_rate);
		$fields['recyclable'] = (int)($this->recyclable);
		$fields['gift'] = (int)($this->gift);
		$fields['gift_message'] = pSQL($this->gift_message);
		$fields['shipping_number'] = pSQL($this->shipping_number);
		$fields['total_discounts'] = (float)($this->total_discounts);
		$fields['total_paid'] = (float)($this->total_paid);
		$fields['total_paid_real'] = (float)($this->total_paid_real);
		$fields['total_products'] = (float)($this->total_products);
		$fields['total_products_wt'] = (float)($this->total_products_wt);
		$fields['total_shipping'] = (float)($this->total_shipping);
		$fields['carrier_tax_rate'] = (float)($this->carrier_tax_rate);
		$fields['total_wrapping'] = (float)($this->total_wrapping);
		$fields['invoice_number'] = (int)($this->invoice_number);
		$fields['delivery_number'] = (int)($this->delivery_number);
		$fields['invoice_date'] = pSQL($this->invoice_date);
		$fields['delivery_date'] = pSQL($this->delivery_date);
		$fields['estimated_delivery_time'] = pSQL($this->estimated_delivery_time);
		$fields['valid'] = (int)($this->valid) ? 1 : 0;
		$fields['date_add'] = pSQL($this->date_add);
		$fields['date_upd'] = pSQL($this->date_upd);

		return $fields;
	}

	public function __construct($id = NULL, $id_lang = NULL)
	{
		parent::__construct($id, $id_lang);
		if ($this->id_customer)
		{
			$customer = new Customer((int)($this->id_customer));
			$this->_taxCalculationMethod = Group::getPriceDisplayMethod((int)($customer->id_default_group));
		}
		else
			$this->_taxCalculationMethod = Group::getDefaultPriceDisplayMethod();
	}

	public function getTaxCalculationMethod()
	{
		return (int)($this->_taxCalculationMethod);
	}

	/* Does NOT delete a product but "cancel" it (which means return/refund/delete it depending of the case) */
	public function deleteProduct($order, $orderDetail, $quantity)
	{
		if (!(int)($this->getCurrentState()))
			return false;

		if ($this->hasBeenDelivered())
		{	
			if (!Configuration::get('PS_ORDER_RETURN'))
				die(Tools::displayError());
			return $this->_deleteProduct($orderDetail, (int)($quantity));
			/*$orderDetail->product_quantity_return += (int)($quantity);
			return $orderDetail->update();*/
		}
		elseif ($this->hasBeenPaid())
		{
			$orderDetail->product_quantity_refunded += (int)($quantity);
			return $orderDetail->update();
		}
		return $this->_deleteProduct($orderDetail, (int)($quantity));
	}

	/* DOES delete the product */
	protected function _deleteProduct($orderDetail, $quantity)
	{
		global $cookie;
		$price = $orderDetail->product_price * (1 + $orderDetail->tax_rate * 0.01);
		if ($orderDetail->reduction_percent != 0.00)
			$reduction_amount = $price * $orderDetail->reduction_percent / 100;
		elseif ($orderDetail->reduction_amount != '0.000000')
			$reduction_amount = Tools::ps_round($orderDetail->reduction_amount, 2);
		if (isset($reduction_amount) AND $reduction_amount)
			$price = Tools::ps_round($price - $reduction_amount, 2);
		$productPriceWithoutTax = number_format($price / (1 + $orderDetail->tax_rate * 0.01), 2, '.', '');
		$price += Tools::ps_round($orderDetail->ecotax * (1 + $orderDetail->ecotax_tax_rate / 100), 2);
		$productPrice = number_format($quantity * $price, 2, '.', '');
		/* Update cart */
		$cart = new Cart($this->id_cart);
		$cart->updateQty($quantity, $orderDetail->product_id, $orderDetail->product_attribute_id, false, 'down'); // customization are deleted in deleteCustomization
		$cart->update();

		/* Update order */
		$shippingDiff = $this->total_shipping - $cart->getOrderShippingCost();
		$this->total_products -= $productPriceWithoutTax;

		// After upgrading from old version
		// total_products_wt is null
		// removing a product made order total negative
		// and don't recalculating totals (on getTotalProductsWithTaxes)
		if ($this->total_products_wt != 0)
			$this->total_products_wt -= $productPrice;

		$this->total_shipping = $cart->getOrderShippingCost();

		/* It's temporary fix for 1.3 version... */
		if ($orderDetail->product_quantity_discount != '0.000000')
			$this->total_paid -= ($productPrice + $shippingDiff);
		else
			$this->total_paid = $cart->getOrderTotal();

		$this->total_paid_real -= ($productPrice + $shippingDiff);

		/* Prevent from floating precision issues (total_products has only 2 decimals) */
		if ($this->total_products < 0)
			$this->total_products = 0;

		if ($this->total_paid < 0)
			$this->total_paid = 0;

		if ($this->total_paid_real < 0)
			$this->total_paid_real = 0;

		/* Prevent from floating precision issues */
		$this->total_paid = number_format($this->total_paid, 2, '.', '');
		$this->total_paid_real = number_format($this->total_paid_real, 2, '.', '');
		$this->total_products = number_format($this->total_products, 2, '.', '');
		$this->total_products_wt = number_format($this->total_products_wt, 2, '.', '');

		/* Update order detail */
		$orderDetail->product_quantity -= (int)($quantity);
		if($orderDetail->product_quantity_delivered>0)
		{
			$orderDetail->product_quantity_delivered -= (int)($quantity);
		}
		if (!$orderDetail->product_quantity)
		{
			if (!$orderDetail->delete())
				return false;
			if (count($this->getProductsDetail()) == 0)
			{
 				$history = new OrderHistory();
				$history->id_order = (int)($this->id);
				$history->changeIdOrderState(Configuration::get('PS_OS_CANCELED'), (int)($this->id));
				if (!$history->addWithemail())
					return false;

				$get_order_last_status=OrderHistory::getLastOrderState((int)($this->id));
				if($get_order_last_status->id == Configuration::get('PS_OS_CANCELED'))
				{
					$id_order_history = Db::getInstance()->getValue('SELECT id_order_history from `'._DB_PREFIX_.'order_history` where id_order = '.(int)($this->id).' order by id_order_history DESC');
					Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'order_history` SET `id_employee`='.$cookie->id_employee.' WHERE id_order = '.(int)($this->id).' AND id_order_history = '.$id_order_history.'');
				}
			}
			return $this->update();
		}
		return $orderDetail->update() AND $this->update();
	}

	public function deleteCustomization($id_customization, $quantity, $orderDetail)
	{
		if (!(int)($this->getCurrentState()))
			return false;

		if ($this->hasBeenDelivered())
			return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'customization` SET `quantity_returned` = `quantity_returned` + '.(int)($quantity).' WHERE `id_customization` = '.(int)($id_customization).' AND `id_cart` = '.(int)($this->id_cart).' AND `id_product` = '.(int)($orderDetail->product_id));
		elseif ($this->hasBeenPaid())
			return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'customization` SET `quantity_refunded` = `quantity_refunded` + '.(int)($quantity).' WHERE `id_customization` = '.(int)($id_customization).' AND `id_cart` = '.(int)($this->id_cart).' AND `id_product` = '.(int)($orderDetail->product_id));
		if (!Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'customization` SET `quantity` = `quantity` - '.(int)($quantity).' WHERE `id_customization` = '.(int)($id_customization).' AND `id_cart` = '.(int)($this->id_cart).' AND `id_product` = '.(int)($orderDetail->product_id)))
			return false;
		if (!Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'customization` WHERE `quantity` = 0'))
			return false;
		return $this->_deleteProduct($orderDetail, (int)($quantity));
	}

	/**
	 * Get order history
	 *
	 * @param integer $id_lang Language id
	 * @param integer $id_order_state Filter a specific order state
	 * @param integer $no_hidden Filter no hidden status
	 * @param integer $filters Flag to use specific field filter
	 *
	 * @return array History entries ordered by date DESC
	 */
	public function getHistory($id_lang, $id_order_state = false, $no_hidden = false, $filters = 0)
	{
		if (!$id_order_state)
			$id_order_state = 0;
		
		$logable = false;
		$delivery = false;
		if ($filters > 0)
		{
			if ($filters & OrderState::FLAG_NO_HIDDEN)
				$no_hidden = true;
			if ($filters & OrderState::FLAG_DELIVERY)
				$delivery = true;
			if ($filters & OrderState::FLAG_LOGABLE)
				$logable = true;
		}
 		
		if (!isset(self::$_historyCache[$this->id.'_'.$id_order_state.'_'.$filters]) || $no_hidden)
		{
			$id_lang = $id_lang ? (int)($id_lang) : 'o.`id_lang`';
			$result = Db::getInstance()->ExecuteS('
			SELECT oh.*, e.`firstname` AS employee_firstname, e.`lastname` AS employee_lastname, osl.`name` AS ostate_name, DATE_FORMAT(oh.date_add, "%d-%b-%Y %h:%i %p") as date_added
			FROM `'._DB_PREFIX_.'orders` o
			LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON o.`id_order` = oh.`id_order`
			LEFT JOIN `'._DB_PREFIX_.'order_state` os ON os.`id_order_state` = oh.`id_order_state`
			LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)($id_lang).')
			LEFT JOIN `'._DB_PREFIX_.'employee` e ON e.`id_employee` = oh.`id_employee`
			WHERE oh.id_order = '.(int)($this->id).'
			'.($no_hidden ? ' AND os.hidden = 0' : '').'
			'.($logable ? ' AND os.logable = 1' : '').'
			'.($delivery ? ' AND os.delivery = 1' : '').'
			'.((int)($id_order_state) ? ' AND oh.`id_order_state` = '.(int)($id_order_state) : '').'
			ORDER BY oh.date_add DESC, oh.id_order_history DESC');
  			if ($no_hidden)
				return $result;
			self::$_historyCache[$this->id.'_'.$id_order_state.'_'.$filters] = $result;
		}
 		return self::$_historyCache[$this->id.'_'.$id_order_state.'_'.$filters];
	}
	
	public function getProductsDetail($orderid)
	{
 		if((int)($this->id)==0)
 			$orderid=$orderid;
 		else
		$orderid = (int)($this->id);
 		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'order_detail` od
		WHERE od.`id_order` = '.$orderid);
	}


	/**
	 * @return string
	 * @deprecated
	 */
	public function getLastMessage()
	{
		Tools::displayAsDeprecated();
		$sql = 'SELECT `message` FROM `'._DB_PREFIX_.'message` WHERE `id_order` = '.(int)($this->id).' ORDER BY `id_message` desc';
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
		return $result['message'];
	}

	public function getFirstMessage()
	{
		$sql = 'SELECT `message` FROM `'._DB_PREFIX_.'message` WHERE `id_order` = '.(int)($this->id).' ORDER BY `id_message` asc';
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
		return $result['message'];
	}

	public function setProductPrices(&$row)
	{
		if ($this->_taxCalculationMethod == PS_TAX_EXC)
			$row['product_price'] = Tools::ps_round($row['product_price'], 2);
		else
			$row['product_price_wt'] = Tools::ps_round($row['product_price'] * (1 + $row['tax_rate'] / 100), 2);

		$group_reduction = 1;
		if ($row['group_reduction'] > 0)
			$group_reduction =  1 - $row['group_reduction'] / 100;

		if ($row['reduction_percent'] != 0)
		{
			if ($this->_taxCalculationMethod == PS_TAX_EXC)
				$row['product_price'] = ($row['product_price'] - $row['product_price'] * ($row['reduction_percent'] * 0.01));
			else
			{
				$reduction = Tools::ps_round($row['product_price_wt'] * ($row['reduction_percent'] * 0.01), 2);
				$row['product_price_wt'] = Tools::ps_round(($row['product_price_wt'] - $reduction), 2);
			}
		}

		if ($row['reduction_amount'] != 0)
		{
			if ($this->_taxCalculationMethod == PS_TAX_EXC)
				$row['product_price'] = ($row['product_price'] - ($row['reduction_amount'] / (1 + $row['tax_rate'] / 100)));
			else
				$row['product_price_wt'] = Tools::ps_round(($row['product_price_wt'] - $row['reduction_amount']), 2);
		}

		if ($row['group_reduction'] > 0)
		{
			if ($this->_taxCalculationMethod == PS_TAX_EXC)
				$row['product_price'] = $row['product_price'] * $group_reduction;
			else
				$row['product_price_wt'] = Tools::ps_round($row['product_price_wt'] * $group_reduction , 2);
		}

		if (($row['reduction_percent'] OR $row['reduction_amount'] OR $row['group_reduction']) AND $this->_taxCalculationMethod == PS_TAX_EXC)
			$row['product_price'] = Tools::ps_round($row['product_price'], 2);

		if ($this->_taxCalculationMethod == PS_TAX_EXC)
			$row['product_price_wt'] = Tools::ps_round($row['product_price'] * (1 + ($row['tax_rate'] * 0.01)), 2) + Tools::ps_round($row['ecotax'] * (1 + $row['ecotax_tax_rate'] / 100), 2);
		else
		{
			$row['product_price_wt_but_ecotax'] = $row['product_price_wt'];
			$row['product_price_wt'] = Tools::ps_round($row['product_price_wt'] + $row['ecotax'] * (1 + $row['ecotax_tax_rate'] / 100), 2);
		}

		$row['total_wt'] = $row['product_quantity'] * $row['product_price_wt'];
		$row['total_price'] = $row['product_quantity'] * $row['product_price'];
	}


	/**
	 * Get order products
	 *
	 * @return array Products with price, quantity (with taxe and without)
	 */
	public function getProducts($products = false, $selectedProducts = false, $selectedQty = false, $orderid = false )
	{
		if (!$products)
		{	
 			$products = $this->getProductsDetail($orderid);
   		}
 		$resultArray = array();
		foreach ($products AS $key=> $row)
		{
			// Change qty if selected
			if ($selectedQty)
			{
				$row['product_quantity'] = 0;
				foreach ($selectedProducts AS $key => $id_product)
					if ($row['id_order_detail'] == $id_product)
						$row['product_quantity'] = (int)($selectedQty[$key]);
				if (!$row['product_quantity'])
					continue ;
			}
			$this->setProductPrices($row);

			/* Add information for virtual product */
			if ($row['download_hash'] AND !empty($row['download_hash']))
				$row['filename'] = ProductDownload::getFilenameFromIdProduct($row['product_id']);

			/* Stock product */
			if($orderid=="")
 			$resultArray[(int)($row['id_order_detail'])] = $row;
			else
			 $resultArray[$key] = $row;
		}
 
 		return $resultArray;
	}

	/**
	 * Returns the taxes rates average by using the historized products
   */
	public function getTaxesAverageUsed()
	{	
		$products = $this->getProducts();
		$total_products_moy = 0;
		$ratio_tax = 0;

		if (!count($products))
			return 0;

		foreach ($products as $product)
		{
			$product['total_wt'] = Tools::ps_round($product['product_price'] * (float)$product['product_quantity'] * (1 + (float)($product['tax_rate']) / 100), 2);
			$total_products_moy += $product['total_wt'];
			$ratio_tax += $product['total_wt'] * $product['tax_rate'];
		}

		if ($total_products_moy > 0)
			return $ratio_tax / $total_products_moy;

		return 0;
	} 

	/**
	 * Count virtual products in order
	 *
	 * @return int number of virtual products
	 */
	public function getVirtualProducts()
	{
		$sql = '
			SELECT `product_id`, `download_hash`, `download_deadline`
			FROM `'._DB_PREFIX_.'order_detail` od
			WHERE od.`id_order` = '.(int)($this->id).'
				AND `download_hash` <> \'\'';
		return Db::getInstance()->ExecuteS($sql);
	}

	/**
	* Check if order contains (only) virtual products
	*
	* @param boolean $strict If false return true if there are at least one product virtual
	* @return boolean true if is a virtual order or false
	*
	*/
	public function isVirtual($strict = true)
	{
		$products = $this->getProducts();
		if (count($products) < 1)
			return false;
		$virtual = true;
		foreach ($products AS $product)
		{
			$pd = ProductDownload::getIdFromIdProduct((int)($product['product_id']));
			if ($pd AND Validate::isUnsignedInt($pd) AND $product['download_hash'])
			{
				if ($strict === false)
					return true;
			}
			else
				$virtual &= false;
		}
		return $virtual;
	}


	/**
	 * Get order discounts
	 *
	 * @return array Discounts with price and quantity
	 */
	public function getDiscounts($details = false)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'order_discount` od '.
		($details ? 'LEFT JOIN `'._DB_PREFIX_.'discount` d ON (d.`id_discount` = od.`id_discount`)' : '').'
		WHERE od.`id_order` = '.(int)($this->id));
	}

	public static function getDiscountsCustomer($id_customer, $id_discount)
	{
		return Db::getInstance()->getValue('
			SELECT COUNT(*) FROM `'._DB_PREFIX_.'orders` o
			LEFT JOIN '._DB_PREFIX_.'order_discount od ON (od.id_order = o.id_order)
			WHERE o.id_customer = '.(int)($id_customer).'
			AND od.id_discount = '.(int)($id_discount));
	}

	/**
	 * Get current order state (eg. Awaiting payment, Delivered...)
	 *
	 * @return array Order state details
	 */
	public function getCurrentState()
	{
		$orderHistory = OrderHistory::getLastOrderState($this->id);
		
		if (!isset($orderHistory) OR !$orderHistory)
			return false;
		return $orderHistory->id;
			

	}

	/**
	 * Get current order state name (eg. Awaiting payment, Delivered...)
	 *
	 * @return array Order state details
	 */
	public function getCurrentStateFull($id_lang)
	{
		return Db::getInstance()->getRow('
		SELECT oh.`id_order_state`, osl.`name`, os.`logable`
		FROM `'._DB_PREFIX_.'order_history` oh
		LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (osl.`id_order_state` = oh.`id_order_state`)
		LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
		WHERE osl.`id_lang` = '.(int)($id_lang).' AND oh.`id_order` = '.(int)($this->id).'
		ORDER BY `date_add` DESC, `id_order_history` DESC');
	}

	/**
	 * @deprecated
	 */
	public function isLogable()
	{
		Tools::displayAsDeprecated();
		return $this->valid;
	}

	public function hasBeenDelivered()
	{
		return count($this->getHistory((int)($this->id_lang), false, false, OrderState::FLAG_DELIVERY));
	}
	
	public function hasBeenPartiallyDelivered()
	{
		return count($this->getHistory((int)($this->id_lang), false, false, OrderState::FLAG_PAR_DELIVERY));
	}

	public function hasBeenPaid()
	{
		return count($this->getHistory((int)($this->id_lang), false, false, OrderState::FLAG_LOGABLE));
	}

	public function hasBeenShipped()
	{
		return $this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_SHIPPING'));
	}
	
	public function hasBeenPartiallyShipped()
	{
		
		return $this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_PAR_SHIPPING'));
	}

	public function isInPreparation()
	{
		return sizeof($this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_PREPARATION')));
	}
	
	public function isInvoiceGenerated()
	{
		return sizeof($this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_INVOICE_GEN')));
	}
	public function packedandreadytobeshipped()
	{
		return $this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_PACKED_AND_READY_TO_SHIPPED'));		
	}
	

	public function checkIfAllProductsDelivered(){
		$products = $this->getProducts();
		foreach($products as $product){
			if(((int)$product['product_quantity_delivered'] + (int)$product['product_quantity_return']) != (int)$product['product_quantity'])
				return false;
		}
		return true;
	}
	
	/**
	 * Get customer orders
	 *
	 * @param integer $id_customer Customer id
	 * @param boolean $showHiddenStatus Display or not hidden order statuses
	 * @return array Customer orders
	 */
	public static function getCustomerOrders($id_customer, $showHiddenStatus = false, $limit= false)
	{
		global $cookie;
		if((int)$cookie->role !=2 && (int)$cookie->role !=3){
			$query = 'o.`id_customer` = '.(int)$id_customer.'';
		}
		else{
			$customer = new Customer($id_customer);
			$result = $customer->getChildCustomers();	
			$query = 'o.`id_customer` IN('.$result.')';
		}
		if($limit == true)//get only 3 order for dash-index.js
 			$set_limit = 'LIMIT 3';
 		else
			$set_limit = ' ';
		
 		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT o.*, DATE_FORMAT(o.date_add , "%d-%M-%Y") AS added_date,(SELECT SUM(od.`product_quantity`) FROM `'._DB_PREFIX_.'order_detail` od WHERE od.`id_order` = o.`id_order`) nb_products
		FROM `'._DB_PREFIX_.'orders` o
		WHERE '.$query.'
		GROUP BY o.`id_order`
		ORDER BY o.`date_add` DESC '.$set_limit.'');

		if (!$res)
			return array();

 		foreach ($res AS $key => $val)
		{
			

			$res2 = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT os.`id_order_state`, osl.`name` AS order_state, os.`invoice`, os.`delivery`,DATEDIFF(NOW(),oh.date_add) as  bill_age
			FROM `'._DB_PREFIX_.'order_history` oh
			LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
			INNER JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)($cookie->id_lang).')
			WHERE oh.`id_order` = '.(int)($val['id_order']).(!$showHiddenStatus ? ' AND os.`hidden` != 1' : '').'
			ORDER BY oh.`date_add` DESC, oh.`id_order_history` DESC
			LIMIT 1');
			
			if($res2[0]['id_order_state'] == OrderState::FLAG_INVOICE_SUBMITTED || $res2[0]['id_order_state'] == OrderState::FLAG_PENDING_PAYMENT )
			{
 				$remaining_credit_days = $cookie->credit_days - $res2[0]['bill_age'];
			}
			else if($res2[0]['id_order_state'] == OrderState::FLAG_ORDER_COMPLETED)
			{
				$remaining_credit_days = "Payment Received";
			}
			else if($res2[0]['id_order_state'] == OrderState::FLAG_CANCELED)
			{
				$remaining_credit_days = "Cancelled";
			}
			else
			{
				$remaining_credit_days = "Invoice Submission Pending";
			}
			
			$res2[0]['bill_age']=$remaining_credit_days;
			if ($res2)
				$res[$key] = array_merge($res[$key], $res2[0]);
		}

		return $res;

	}

	public static function getOrdersIdByDate($date_from, $date_to, $id_customer = NULL, $type = NULL)
	{
		$sql = '
		SELECT `id_order`
		FROM `'._DB_PREFIX_.'orders`
		WHERE DATE_ADD(date_upd, INTERVAL -1 DAY) <= \''.pSQL($date_to).'\' AND date_upd >= \''.pSQL($date_from).'\''
		.($type ? ' AND '.pSQL(strval($type)).'_number != 0' : '')
		.($id_customer ? ' AND id_customer = '.(int)($id_customer) : '');
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

		$orders = array();
		foreach ($result AS $order)
			$orders[] = (int)($order['id_order']);
		return $orders;
	}

	/*
	* @deprecated
	*/
	public static function getOrders($limit = NULL)
	{
		Tools::displayAsDeprecated();
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT *
			FROM `'._DB_PREFIX_.'orders`
			ORDER BY `date_add`
			'.((int)$limit ? 'LIMIT 0, '.(int)$limit : ''));
	}

	public static function getOrdersWithInformations($limit = NULL)
	{
		global $cookie;

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT *, (
				SELECT `name`
				FROM `'._DB_PREFIX_.'order_history` oh
				LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (osl.`id_order_state` = oh.`id_order_state`)
				WHERE oh.`id_order` = o.`id_order`
				AND osl.`id_lang` = '.(int)$cookie->id_lang.'
				ORDER BY oh.`date_add` DESC
				LIMIT 1
			) AS `state_name`
			FROM `'._DB_PREFIX_.'orders` o
			LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = o.`id_customer`)
			ORDER BY o.`date_add` DESC
			'.((int)$limit ? 'LIMIT 0, '.(int)$limit : ''));
	}

	public static function getOrdersIdInvoiceByDate($date_from, $date_to, $id_customer = NULL, $type = NULL)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT `id_order`
		FROM `'._DB_PREFIX_.'orders`
		WHERE DATE_ADD(invoice_date, INTERVAL -1 DAY) <= \''.pSQL($date_to).'\' AND invoice_date >= \''.pSQL($date_from).'\''
		.($type ? ' AND '.pSQL(strval($type)).'_number != 0' : '')
		.($id_customer ? ' AND id_customer = '.(int)($id_customer) : '').
		' ORDER BY invoice_date ASC');

		$orders = array();
		foreach ($result AS $order)
			$orders[] = (int)($order['id_order']);
		return $orders;
	}

	public static function getOrderIdsByStatus($id_order_state)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT id_order
		FROM '._DB_PREFIX_.'orders o
		WHERE '.(int)$id_order_state.' = (
			SELECT id_order_state
			FROM '._DB_PREFIX_.'order_history oh
			WHERE oh.id_order = o .id_order
			ORDER BY date_add DESC, id_order_history DESC
			LIMIT 1
		)
		ORDER BY invoice_date ASC');

		$orders = array();
		foreach ($result AS $order)
			$orders[] = (int)($order['id_order']);
		return $orders;
	}

	/**
	 * Get product total without taxes
	 *
	 * @return Product total with taxes
	 */
	public function getTotalProductsWithoutTaxes($products = false)
	{
		return $this->total_products;
	}

	/**
	 * Get product total with taxes
	 *
	 * @return Product total with taxes
	 */
	public function getTotalProductsWithTaxes($products = false)
	{
		if ($this->total_products_wt != '0.00' AND !$products)
			return $this->total_products_wt;
		/* Retro-compatibility (now set directly on the validateOrder() method) */
		if (!$products)
			$products = $this->getProductsDetail();

		$return = 0;
		foreach ($products AS $row)
		{
			$price = Tools::ps_round($row['product_price'] * (1 + $row['tax_rate'] / 100), 2);
			if ($row['reduction_percent'])
				$price -= $price * ($row['reduction_percent'] * 0.01);
			if ($row['reduction_amount'])
				$price -= $row['reduction_amount'];
			if ($row['group_reduction'])
				$price -= $price * ($row['group_reduction'] * 0.01);
			$price += $row['ecotax'] * (1 + $row['ecotax_tax_rate'] / 100);
			$return += Tools::ps_round($price, 2) * $row['product_quantity'];
		}
		if (!$products)
		{
			$this->total_products_wt = $return;
			$this->update();
		}
		return $return;
	}

	/**
	 * Get customer orders number
	 *
	 * @param integer $id_customer Customer id
	 * @return array Customer orders number
	 */
	public static function getCustomerNbOrders($id_customer)
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT COUNT(`id_order`) AS nb
		FROM `'._DB_PREFIX_.'orders`
		WHERE `id_customer` = '.(int)($id_customer));

		return isset($result['nb']) ? $result['nb'] : 0;
	}

	/**
	 * Get an order by its cart id
	 *
	 * @param integer $id_cart Cart id
	 * @return array Order details
	 */
	public static function getOrderByCartId($id_cart)
	{
		$result = Db::getInstance()->getRow('
		SELECT `id_order`
		FROM `'._DB_PREFIX_.'orders`
		WHERE `id_cart` = '.(int)($id_cart));

		return isset($result['id_order']) ? $result['id_order'] : false;
	}

	/**
	 * Add a discount to order
	 *
	 * @param integer $id_discount Discount id
	 * @param string $name Discount name
	 * @param float $value Discount value
	 * @return boolean Query sucess or not
	 */
	public function addDiscount($id_discount, $name, $value)
	{
		return Db::getInstance()->AutoExecute(_DB_PREFIX_.'order_discount', array('id_order' => (int)($this->id), 'id_discount' => (int)($id_discount), 'name' => pSQL($name), 'value' => (float)($value)), 'INSERT');
	}

	/**
	 * Get orders number last week
	 *
	 * @return integer Orders number last week
	 * @deprecated
	 */
	public static function getWeeklyOrders()
	{
		Tools::displayAsDeprecated();
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT COUNT(`id_order`) as nb
		FROM `'._DB_PREFIX_.'orders`
		WHERE YEARWEEK(`date_add`) = YEARWEEK(NOW())');

		return isset($result['nb']) ? $result['nb'] : 0;
	}

	/**
	 * Get sales amount last month
	 *
	 * @return float Sales amount last month
	 * @deprecated
	 */
	public static function getMonthlySales()
	{
		Tools::displayAsDeprecated();
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT SUM(`total_paid`) as nb
		FROM `'._DB_PREFIX_.'orders`
		WHERE MONTH(`date_add`) = MONTH(NOW())
		AND YEAR(`date_add`) = YEAR(NOW())');

		return isset($result['nb']) ? $result['nb'] : 0;
	}

	public function getNumberOfDays()
	{
		$nbReturnDays = (int)(Configuration::get('PS_ORDER_RETURN_NB_DAYS'));
		if (!$nbReturnDays)
			return true;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT TO_DAYS(NOW()) - TO_DAYS(`delivery_date`)  AS days FROM `'._DB_PREFIX_.'orders`
		WHERE `id_order` = '.(int)($this->id));
		if ($result['days'] <= $nbReturnDays)
			return true;
		return false;
	}


	public function isReturnable()
	{
		$payment = $this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_PAYMENT'));
		$delivred = $this->getHistory((int)($this->id_lang), Configuration::get('PS_OS_DELIVERED'));
		if ($payment AND $delivred AND strtotime($delivred[0]['date_add']) < strtotime($payment[0]['date_add']))
			return ((int)(Configuration::get('PS_ORDER_RETURN')) == 1 AND $this->getNumberOfDays());
		else
			return ((int)(Configuration::get('PS_ORDER_RETURN')) == 1 AND (int)($this->getCurrentState()) == Configuration::get('PS_OS_DELIVERED') AND $this->getNumberOfDays());
	}


	public static function getLastInvoiceNumber()
	{
		return (int)Db::getInstance()->getValue('
		SELECT MAX(`invoice_number`) AS `invoice_number`
		FROM `'._DB_PREFIX_.'orders`
		');
	}

	public function setInvoice()
	{
		$number = (int)Configuration::get('PS_INVOICE_START_NUMBER');
		if ($number)
 			Configuration::updateValue('PS_INVOICE_START_NUMBER', false);
 		else
			if (version_compare(Db::getInstance()->getServerVersion(), 5,'<'))
			{
				// I use mysql 4, I can't make sub query in FROM
			$number = Order::getLastInvoiceNumber() + 1;
			}
			else
			$number = '(SELECT `invoice_number`
						FROM (
							SELECT MAX(`invoice_number`) + 1 AS `invoice_number`
							FROM `'._DB_PREFIX_.'orders`)
						tmp )';
		// a way to avoid duplicate invoice number
		Db::getInstance()->Execute('
		UPDATE `'._DB_PREFIX_.'orders`
		SET `invoice_number` = '.$number.', `invoice_date` = \''.date('Y-m-d H:i:s').'\'
		WHERE `id_order` = '.(int)$this->id
		);
		$res = Db::getInstance()->getRow('
		SELECT `invoice_number`, `invoice_date`
		FROM `'._DB_PREFIX_.'orders`
		WHERE `id_order` = '.(int)$this->id
		);

		$this->invoice_date = $res['invoice_date'];
		$this->invoice_number = $res['invoice_number'];
	}

	public function setDelivery()
	{
		// Set delivery number if it does not exist
		if (!$this->delivery_number)
		{
			$number = (int)(Configuration::get('PS_DELIVERY_NUMBER'));
			if (!(int)($number))
				die(Tools::displayError('Invalid delivery number'));
			$this->delivery_number = $number;
			Configuration::updateValue('PS_DELIVERY_NUMBER', $number + 1);
		}

		// Set delivery date
		$this->delivery_date = date('Y-m-d H:i:s');
		// Update object
		$this->update();
	}

	public static function printPDFIcons($id_order, $tr)
	{
		$order = new Order($id_order);
		$orderState = OrderHistory::getLastOrderState($id_order);
		if (!Validate::isLoadedObject($orderState) OR !Validate::isLoadedObject($order))
			die(Tools::displayError('Invalid objects'));
		echo '<span style="width:20px; margin-right:5px;">';
		if (($orderState->invoice AND $order->invoice_number) AND (int)($tr['product_number']))
			echo '<a href="pdf.php?id_order='.(int)($order->id).'&pdf"><img src="../img/admin/tab-invoice.gif" alt="invoice" /></a>';
		else
			echo '&nbsp;';
		echo '</span>';
		echo '<span style="width:20px;">';
		if ($orderState->delivery AND $order->delivery_number)
			echo '<a href="pdf.php?id_delivery='.(int)($order->delivery_number).'"><img src="../img/admin/delivery.gif" alt="delivery" /></a>';
		else
			echo '&nbsp;';
		echo '</span>';
	}

	public static function getByDelivery($id_delivery)
	{
		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT id_order
		FROM `'._DB_PREFIX_.'orders`
		WHERE `delivery_number` = '.(int)($id_delivery));
		return new Order((int)($res['id_order']));
	}

	public function getTotalWeight()
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT SUM(product_weight * product_quantity) weight
		FROM '._DB_PREFIX_.'order_detail
		WHERE id_order = '.(int)($this->id));

		return (float)($result['weight']);
	}

	public static function getInvoice($id_invoice)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT `invoice_number`, `id_order`
		FROM `'._DB_PREFIX_.'orders`
		WHERE invoice_number = '.(int)($id_invoice));
	}

	public function isAssociatedAtGuest($email)
	{
		if (!$email)
			return false;
		return (bool)Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'orders` o
			LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = o.`id_customer`)
			WHERE o.`id_order` = '.(int)$this->id.'
			AND c.`email` = \''.pSQL($email).'\'
			AND c.`is_guest` = 1
		');
	}

	/**
	 * @param int $id_order
	 * @param int $id_customer optionnal
	 * @return int id_cart
	 */
	public static function getCartIdStatic($id_order, $id_customer = 0)
	{
		return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT `id_cart`
			FROM `'._DB_PREFIX_.'orders`
			WHERE `id_order` = '.(int)$id_order.'
			'.($id_customer ? 'AND `id_customer` = '.(int)$id_customer : ''));
	}

	public function getWsOrderRows()
	{
		$query = 'SELECT id_order_detail as `id`, `product_id`, `product_price`, `id_order`, `product_attribute_id`, `product_quantity`, `product_name`
		FROM `'._DB_PREFIX_.'order_detail`
		WHERE id_order = '.(int)$this->id;
		$result = Db::getInstance()->executeS($query);
		return $result;
	}

	/** Set current order state
	 * @param int $id_order_state
	 * @param int $id_employee (/!\ not optional except for Webservice.
	*/
	public function setCurrentState($id_order_state, $id_employee = 0)
	{
		if (empty($id_order_state))
			return false;
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = (int)$id_employee;
		$history->changeIdOrderState((int)$id_order_state, (int)$this->id);
		//var_dump($history);
		$res = Db::getInstance()->getRow('
		SELECT `invoice_number`, `invoice_date`, `delivery_number`, `delivery_date`
		FROM `'._DB_PREFIX_.'orders`
		WHERE `id_order` = '.(int)$this->id);
		$this->invoice_date = $res['invoice_date'];
		$this->invoice_number = $res['invoice_number'];
		$this->delivery_date = $res['delivery_date'];
		$this->delivery_number = $res['delivery_number'];
		$history->addWithemail();

	}

	public function addWs($autodate = true, $nullValues = false)
	{
		$paymentModule = Module::getInstanceByName($this->module);
		$customer = new Customer($this->id_customer);
		$paymentModule->validateOrder($this->id_cart, Configuration::get('PS_OS_WS_PAYMENT'), $this->total_paid, $this->payment, NULL, array(), null, false, $customer->secure_key);
		$this->id = $paymentModule->currentOrder;
		return true;
	}

	public function deleteAssociations()
	{
		return (Db::getInstance()->Execute('
				DELETE FROM `'._DB_PREFIX_.'order_detail`
				WHERE `id_order` = '.(int)($this->id)) !== false);
	}
	
	/*This will return the purchases level for that current customer*/
	public static function getHistoryReport($customerid, $duration, $addressId)
	{
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
		$day = 1;
		$month = date("m");
		$year = date("Y");
		$currentdate = ($year."-".$month."-".$day);
 		
		if($addressId !=0)
 			$add_qry = 'AND a.id_address_delivery = "'.$addressId.'"';
 		else
 			$add_qry ='';
  		if($duration == 1)
		{
			$due_query = 'AND a.date_add >= "'.$currentdate.'" -INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND a.date_add >= "'.$currentdate.'" -INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND a.date_add >= "'.$currentdate.'" -INTERVAL 1 YEAR';
		}
		else 
		{
			$due_query ='';
		}
		$result = Db::getInstance()->ExecuteS('SELECT sum(a.total_products) as y, sum(a.total_products) as indexLabel, monthname(a.date_add) AS label
															  FROM '._DB_PREFIX_.'orders AS a  
															  LEFT JOIN '._DB_PREFIX_.'order_history AS b ON a.id_order = b.id_order 
															  WHERE  b.id_Order_history IN (
																	SELECT  MAX(oha.`id_order_history`)
																	FROM '._DB_PREFIX_.'order_history AS oha
																	WHERE a.id_order = oha.id_order
																	GROUP BY oha.id_order) 
															AND  b.`id_order_state` IN(5,25,34,35,36,37,38,39,40 ) '.$add_qry.' AND a.`id_customer` IN('.$str.') '.$due_query.' GROUP BY label ORDER BY a.date_add ASC ');
		
 
		return $result;
	}
	
	/*This will return the parent category with purchases for that current customer*/
	public static function getRatioHistoryReport($customerid, $orderid,$duration, $addressId,$selected_category=NULL)
	{
		
 		if($addressId !=0)
 			$add_qry = 'AND orders.id_address_delivery = "'.$addressId.'"';
 		else
 			$add_qry ='';
		
		if($duration == 1)
		{
			$due_query = 'AND orders.date_add >= NOW()-INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND orders.date_add >= NOW()-INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND orders.date_add >= NOW()-INTERVAL 1 YEAR';
		}
		else 
		{
			$due_query ='';
		}
  		if($orderid == 1 || $orderid ==0 )
		{
			$ord_query = '';
		}
		else
		{
			$ord_query='And orders.`id_order`= "'.$orderid.'"';
		}
		if($selected_category !="")
		{
			/*qry_top_10_product*/
			$select_qry ='count(detail.product_id) as y, pro_lang.name as indexLabel , sum(detail.product_quantity - detail.product_quantity_return - detail.product_quantity_refunded)as qty, Round(sum(detail.product_price + (detail.product_price+detail.tax_rate/100))) as total, detail.product_price ';
			
			$where_qry ='AND parent.id_category ='.$selected_category.' '.$due_query.' group by product.id_product order by y desc limit 10';
		}
		else{
			/*$category_report*/
			$select_qry ='ROUND(SUM((detail.`product_quantity`-product_quantity_refunded - product_quantity_return)*((detail.product_price*tax_rate /100)+ detail.product_price))) AS y, cat_lang.`name` AS indexLabel  ,parent.id_category ';
			$where_qry=''.$add_qry.''.$ord_query.''.$due_query.' GROUP BY parent.id_category ORDER BY y DESC';
		}
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
		

 		$result = Db::getInstance()->ExecuteS('SELECT '.$select_qry.' 
												FROM '._DB_PREFIX_.'orders orders, '._DB_PREFIX_.'order_detail detail, '._DB_PREFIX_.'product product, '._DB_PREFIX_.'order_history history,
												'._DB_PREFIX_.'category node, '._DB_PREFIX_.'category parent, '._DB_PREFIX_.'category_lang cat_lang,'._DB_PREFIX_.'product_lang pro_lang
												WHERE   id_customer IN('.$str.')
												AND		orders.`id_order` = detail.id_order
												AND		product.`id_product` = detail.`product_id`
												AND		product.`id_product` = pro_lang.`id_product`
												AND		product.`id_category_default` = node.`id_category`
												AND		node.nleft BETWEEN parent.nleft AND parent.nright
												AND 	parent.level_depth=1
												AND 	parent.id_category = cat_lang.`id_category`
												AND     cat_lang.`id_lang`= 1												
												AND     pro_lang.`id_lang`= 1
												AND 	orders.`id_order`= history.`id_order`
												AND 	history.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																WHERE orders.id_order = oha.id_order
																GROUP BY oha.id_order)
												AND 	history.`id_order_state` IN (5,25,34,35,36,37,38,39,40 ) 
												'.$where_qry.'');
		
 
 		return $result;
	}
	/*this is use to get a order id, date, invoice value for a particular customer*/
	public static function getAllOrders($customerid)
	{
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
 		$result = Db::getInstance()->ExecuteS('SELECT DISTINCT(o.id_order) as orderid,DATE_FORMAT(o.date_add, "%d-%b-%Y") AS orderdate,o.total_paid_real as totalvalue, o.`id_address_delivery`
												FROM '._DB_PREFIX_.'orders AS o
												LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
												ON oh.`id_order`= o.`id_order`
												WHERE id_customer IN('.$str.') AND 	oh.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																where o.id_order = oha.id_order
																GROUP BY oha.id_order)
												AND 	 oh.`id_order_state` IN (5,25,34,35,36,37,38,39,40)');
		
	return $result;
	}
	public static function getTopOrderValueProducts($customerid,$duration, $addressId)
	{
		if($addressId !=0)
 			$add_qry = 'AND o.id_address_delivery = "'.$addressId.'"';
 		else
 			$add_qry ='';
			
 		if($duration == 1)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 1 YEAR';
		}
		else 
		{
			$due_query ='';
		}

		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();		
		$result = Db::getInstance()->ExecuteS('SELECT   ROUND(SUM((od.product_quantity * od.product_price))) AS y, pl.name AS name, pl.id_product,pl.`link_rewrite`, i.`id_image`, p.quantity,p.out_of_stock
												FROM '._DB_PREFIX_.'order_detail AS od
												JOIN '._DB_PREFIX_.'orders o
												ON o.id_order= od.id_order
												JOIN '._DB_PREFIX_.'product_lang pl
												ON pl.id_product = od.product_id
												JOIN '._DB_PREFIX_.'image i
												ON pl.id_product = i.`id_product`
												JOIN '._DB_PREFIX_.'order_history oh
												ON o.id_order= oh.id_order
												JOIN '._DB_PREFIX_.'product p
												ON p.id_product= pl.id_product
												WHERE o.id_customer IN('.$str.') AND p.discontinued = 0  AND p.active = 1 AND oh.id_order_state IN (5,25,34,35,36,37,38,39,40 ) '.$add_qry.' AND pl.id_lang=1 '.$due_query.' GROUP BY od.product_id ORDER BY y DESC LIMIT 10');	
	return $result;
	}
	
	public static function getLocationBasedReport($customerid,$duration)
	{
		if($duration == 1)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 1 YEAR';
		}
		else 
		{
			$due_query ='';
		}
		$customer=new Customer($customerid);
		$str=$customer->getChildCustomers();
		 

		return Db::getInstance()->ExecuteS('SELECT ROUND(SUM(o.total_paid)) AS y, o.`id_address_delivery`, a.`alias` AS indexLabel
											FROM '._DB_PREFIX_.'orders o
											LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
											ON o.`id_order` = oh.`id_order`
											LEFT JOIN '._DB_PREFIX_.'address AS a
											ON o.`id_address_delivery` = a.`id_address`
											WHERE o.id_customer IN('.$str.') AND oh.id_Order_history IN (
																SELECT  MAX(oha.`id_order_history`)
																FROM '._DB_PREFIX_.'order_history AS oha
																 where o.id_order = oha.id_order
																GROUP BY oha.id_order)
												AND oh.`id_order_state` IN ( 5,25,34,35,36,37,38,39,40 ) '.$due_query.' GROUP BY o.`id_address_delivery` ORDER BY Y DESC');
	}
	public static function getAllInvoice($customerid)
	{
		$result= Db::getInstance()->ExecuteS('SELECT o.`invoice_number`,DATE_FORMAT(o.invoice_date, "%d-%b-%Y") AS invoice_date,DATE_FORMAT(o.date_add , "%d-%M-%Y") AS added_date,
												o.`id_order`,o.`total_paid`, oh.id_order_state,os.delivery, os.invoice
												FROM '._DB_PREFIX_.'order_history AS oh
												LEFT JOIN '._DB_PREFIX_.'orders AS o
												ON oh.id_order = o.id_order
												LEFT JOIN `'._DB_PREFIX_.'order_state` AS os
												ON oh.id_order_state = os.id_order_state
												WHERE oh.id_Order_history IN (
												SELECT  MAX(oh.`id_order_history`)
												FROM '._DB_PREFIX_.'order_history AS oh
												where o.id_order = oh.id_order
												GROUP BY oh.id_order)  AND o.`id_customer`='.$customerid.' ORDER BY o.date_add DESC');
		
		
		return $result;
	}
	
	public static function getAllDeliveryData($customerid)
	{
		
		$result= Db::getInstance()->ExecuteS('SELECT d.`delivery_number`,oh.`id_order_state` AS status,DATE_FORMAT(o.`delivery_date`,"%d-%b-%Y") AS delivery_date,DATE_FORMAT(o.`date_add` , "%d-%M-%Y") AS added_date,os.`delivery`,od.`id_delivery`,o.`id_order`,oh.`id_order_history`,d.`dr_file_name`
												FROM '._DB_PREFIX_.'order_history AS oh
												LEFT JOIN '._DB_PREFIX_.'orders AS o
												ON o.id_order = oh.id_order
												LEFT JOIN '._DB_PREFIX_.'order_delivery AS od
												ON o.id_order = od.id_order
												LEFT JOIN '._DB_PREFIX_.'delivery AS d
												ON od.id_delivery = d.id_delivery
												LEFT JOIN '._DB_PREFIX_.'order_state AS os
												ON os.id_order_state = oh.id_order_state												
												WHERE oh.id_Order_history IN (
												SELECT  MAX(oh.`id_order_history`)
												FROM '._DB_PREFIX_.'order_history AS oh
												where o.id_order = oh.id_order
												GROUP BY oh.id_order)
												AND o.id_customer='.$customerid.' ORDER BY o.date_add DESC');
												
								
		return $result;
	}

/*	Done by mahesh for notification	
	public static function getRMId($subjectId)
	{
	return Db::getInstance()->ExecuteS('SELECT ke.`id_employee`,ke.`email`,ke.`phone`,ke.`firstname`,ke.`lastname`
											FROM `'._DB_PREFIX_.'customer` AS kc,
											`'._DB_PREFIX_.'orders` AS ko,
											`'._DB_PREFIX_.'employee` AS ke
											WHERE id_order='.$subjectId.'
											AND ko.`id_customer`=kc.`id_customer`
											AND ke.`id_employee`=kc.`id_relationship_manager`');
		
	}
	public static function getSCNId($subjectId)
	{
		return Db::getInstance()->ExecuteS('SELECT  ke.`id_employee`,ke.`email`,ke.`phone`,ke.`firstname`,ke.`lastname`
											FROM `'._DB_PREFIX_.'orders` AS ko,
											`'._DB_PREFIX_.'address` AS ka,
											`'._DB_PREFIX_.'pincode_master` AS kpm,
											`'._DB_PREFIX_.'scn_group_master` AS ksgm,
											`'._DB_PREFIX_.'scn_group_relational` AS ksgr,
											`'._DB_PREFIX_.'employee` AS ke
											WHERE ko.`id_order`='.$subjectId.'
											AND ka.`id_address`= ko.`id_address_delivery`
											AND ka.`postcode`BETWEEN kpm.`zone_pin_start` AND kpm.`zone_pin_end`
											AND kpm.`zone_id`=ksgm.`zone_id`
											AND ksgm.`id_scn_group`=ksgr.`id_scn_group`
											AND ke.`id_employee`=ksgr.`id_employee`');
	}*/
	/*Return the durations of orders status according to RM cusotmer */
	public function getRMCusomersOrderDurations($id_employee)
	{
		return Db::getInstance()->ExecuteS('SELECT id_order_state,hours, COUNT(orderid) as totalorder
											  FROM 
												(SELECT od.`id_order` AS orderid,MAX(oh.`id_order_state`) AS id_order_state,(TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())),
													CASE WHEN (TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())) < 24 THEN 24
														 WHEN (TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())) < 48 THEN 48
														 ELSE 72
													 END AS hours
													FROM `'._DB_PREFIX_.'orders` AS od
													LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
													ON oh.`id_order` = od.`id_order`
													LEFT JOIN `'._DB_PREFIX_.'customer` AS cus
													ON cus.id_customer = od.`id_customer`
													LEFT JOIN '._DB_PREFIX_.'employee AS emp
													ON emp.id_employee = cus.id_relationship_manager
													WHERE emp.id_employee='.$id_employee.'
													AND od.`date_add` >= NOW()-INTERVAL 1 MONTH AND oh.id_Order_history IN (
																				SELECT  MAX(oha.`id_order_history`)
																				FROM '._DB_PREFIX_.'order_history AS oha
																				where od.id_order = oha.id_order
																				GROUP BY oha.id_order)
													GROUP BY od.`id_order`) AS result
													where id_order_state NOT IN (5,6)
												GROUP BY id_order_state, hours;');
	}
	public function getStatusOrdersDetails($id_employee,$order_status,$duration,$buyer_type=NULL)
	{
 		if($order_status == "2118")
		{
			$status_qry= "IN(21,18)";
		}
		else
		{
			
			$status_qry = "= ".$order_status."";
		}
		if($buyer_type!="")
		{
			if($buyer_type==3)
			{
				$buyerqry = "AND buyer = 3";
			}
			else
			{
				$buyerqry = "AND buyer != 3";
			}
		}
		else
		{
			$buyerqry="";
		}
		if($id_employee != 0)
		{
			$empqry = "emp.id_employee=".$id_employee." AND ";
		}
		else
		{
			$empqry = " ";
		}
		
  		return Db::getInstance()->ExecuteS('SELECT orderid, id_customer,firstname,total_paid,DATE_ADD,hours,name,buyer FROM(
											SELECT od.`id_order` AS orderid,MAX(oh.`id_order_state`) AS id_order_state,cus.id_customer,cus.firstname,od.total_paid,cus.`Id_buyer` AS buyer,od.date_add,osl.name,
											CASE WHEN (TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())) < 24 THEN 24
												 WHEN (TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())) < 48 THEN 48
												 ELSE 72
												 END AS hours
											FROM `'._DB_PREFIX_.'orders` AS od
											LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
											ON oh.`id_order` = od.`id_order`
											LEFT JOIN `'._DB_PREFIX_.'customer` AS cus
											ON cus.id_customer = od.`id_customer`
											LEFT JOIN '._DB_PREFIX_.'employee AS emp
											ON emp.id_employee = cus.id_relationship_manager
											LEFT JOIN '._DB_PREFIX_.'order_state_lang AS osl
											ON osl.`id_order_state`= oh.`id_order_state`
											WHERE '.$empqry.' oh.`id_order_state`'.$status_qry.' AND osl.id_lang=1
											AND od.`date_add` >= NOW()-INTERVAL 1 MONTH AND oh.id_Order_history IN (
																		SELECT  MAX(oha.`id_order_history`)
																		FROM '._DB_PREFIX_.'order_history AS oha
																		where od.id_order = oha.id_order
																		GROUP BY oha.id_order)
											GROUP BY od.`id_order`) AS result WHERE hours='.$duration.' '.$buyerqry.' ORDER BY DATE_ADD  DESC');
	}
	public function getOrderStatusForScn($isFinanace = false )
	{
		if($isFinanace)
		{
			$order_status_id = 'IN ('.OrderState::FLAG_PENDING_INVOICE.','.OrderState::FLAG_PENDING_PAYMENT.','.OrderState::FLAG_INVOICE_SUBMISSION_PENDING.')';
			$interval ='3';
			
		}
		else
		{
 			$order_status_id = 'NOT IN ('.OrderState::FLAG_DELIVERY.','.OrderState::FLAG_CANCELED.')';
			$interval ='1';
		}
		
 		return DB::getInstance()->ExecuteS('SELECT id_order_state,hours, COUNT(orderid) AS totalorder, buyer
											FROM (
											SELECT od.id_order AS orderid,cus.`id_customer`,cus.`firstname`,cus.`Id_buyer` AS buyer, oh.id_order_state,(TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())),
												CASE WHEN (TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())) < 24 THEN 24
													 WHEN (TIMESTAMPDIFF(HOUR,oh.`date_add`,NOW())) < 48 THEN 48
													 ELSE 72
												 END AS hours 
											FROM `'._DB_PREFIX_.'customer` AS cus
											LEFT JOIN `'._DB_PREFIX_.'orders` AS od
											ON od.`id_customer` = cus.id_customer
											LEFT JOIN `'._DB_PREFIX_.'order_history` AS oh
											ON oh.id_order = od.`id_order`
											WHERE od.`date_add` >= NOW()-INTERVAL '.$interval.' MONTH AND oh.id_Order_history IN (
															SELECT  MAX(oha.`id_order_history`)
															FROM '._DB_PREFIX_.'order_history AS oha
															where od.id_order = oha.id_order
															GROUP BY oha.id_order)
											GROUP BY od.id_order)AS result
											where id_order_state '.$order_status_id.'
											GROUP BY id_order_state, hours,buyer ');
	}
	
	public static function getPendingBusinessOrders()
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT od.id_order, cus.id_customer, cus.firstname, NOW(), od.estimated_delivery_time, 
		TIMESTAMPDIFF(HOUR, NOW(), od.estimated_delivery_time) as hours, oh1.id_order_state
		FROM '._DB_PREFIX_.'order_history oh1, '._DB_PREFIX_.'customer cus, '._DB_PREFIX_.'orders od
		WHERE oh1.id_order_history = (SELECT MAX(oh2.id_order_history)
                 FROM '._DB_PREFIX_.'order_history oh2
                 WHERE oh1.id_order = oh2.id_order)
		AND oh1.id_order_state in (4,18,19,21,22,23,24)
		AND oh1.id_order = od.id_order
		AND od.id_customer = cus.id_customer
		AND cus.id_buyer = 3
		ORDER BY `oh1`.`id_order` DESC');
		
		return $result;
	}

	public function order_search($term)
	{
		$results = Db::getInstance()->ExecuteS("SELECT id_order FROM "._DB_PREFIX_."order_detail WHERE id_order LIKE '%".$term."%' GROUP BY id_order "); 
		$data = json_encode($results);
		$user_friend =  json_decode($data, true );
		    $data=array();
		    foreach($user_friend as $key=>$val)
		            $data[]=$val['id_order'];
		    $json_friends =json_encode($data);
		    return $json_friends;
	}
	public function savePoNumber($po_number,$id_order)
	{

		 Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'orders SET po_number="'.$po_number.'" WHERE id_order='.$id_order);

	}
	private function _getFormatedAddress(Address $the_address, $line_sep, $fields_style = array())
	{
		return AddressFormat::generateAddress($the_address, array('avoid' => array()), $line_sep, ' ', $fields_style);
	}
	
	public function approveOrder($id_customer,$payment_type = NULL,$order_id)
	{
		 global $cookie;
		//Change Order Status to Approved
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;

 		//$history->changeIdOrderState((int)(OrderState::FLAG_APPROVED), (int)$this->id);
		if($payment_type==5)
		{
			if($cookie->role==2)//Approver Level 2
				$order_status = OrderState::FLAG_LEVEL2_APPROVED;
			else if($cookie->role==3)//Approver Level 3
				$order_status = OrderState::FLAG_LEVEL3_APPROVED;
			else if($cookie->role==4)//Approver Level 4
				$order_status = OrderState::FLAG_LEVEL4_APPROVED;
		}
		else
			$order_status = OrderState::FLAG_APPROVED;//Approver Level 1
		
		$result = $history->changeIdOrderStateByApprover($order_status, (int)$this->id,$id_customer,NULL,$payment_type);
 		
 		/*//Persist the user who Approved the order
		$historyCustomer = new HistoryCustomer();
		$historyCustomer->id_history = $history->id;
		$historyCustomer->id_customer = $id_customer; */
		
		$customer = new Customer((int)($id_customer));
		/*
		$historyCustomer->add();
		*/
		//Change Order Status to Order Placed
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		//$history->changeIdOrderState((int)(OrderState::FLAG_ORDER_PLACED), (int)$this->id);
		if($payment_type != 5)
		{
			$old_orgin_order = Order::getOrginOrderId((int)$this->id);
			if($old_orgin_order != "")
				 Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO '._DB_PREFIX_.'orgin_orders (`id_old_order`, `id_new_order`, `id_customer`) VALUES ('.$old_orgin_order.','.$this->id.','.$cookie->id_customer.')');
			 
 			if($customer->verification_status != 2)
				$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_CUSTOMER_VERIFICATION_PENDING), (int)$this->id);
			else
			{
 				$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_ORDER_PLACED), (int)$this->id);
			}
		}
		else{
			$old_orgin_order = Order::getOrginOrderId((int)$this->id);
				Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO '._DB_PREFIX_.'orgin_orders (`id_old_order`, `id_new_order`, `id_customer`) VALUES ('.$old_orgin_order.','.(int)$this->id.','.(int)($id_customer).')');
		}
 		//Estimated delivery time
		//Setting estimated delivery time
		
		//Get current IST time
		date_default_timezone_set('Asia/Kolkata');
		$orderPlacedTime = new DateTime();
		$cutOffTime = new DateTime();
		$cutOffTime->setTime(12, 0, 0);
		
		$estimated_delivery_time = new DateTime();
		$estimated_delivery_time = $orderPlacedTime;
		
		if($orderPlacedTime < $cutOffTime){
			$estimated_delivery_time->modify('+1 day');
		}
		else{
			$estimated_delivery_time->modify('+2 day');
		}
		
		$estimated_delivery_time->setTime(18, 0, 0);
		$this->estimated_delivery_time = $estimated_delivery_time->format('Y-m-d H:i:s');
		$this->update();
		
		if((($cookie->role==2)&&($customer->getApprover())) || (!$customer->getApprover()))
		{
			$order=new Order($order_id);
			$customerNew=new Customer($order->id_customer);
			$cart=new Cart($order->id_cart);
			$vat_address = new Address((int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
			$products = $cart->getProducts();
			$productsList = '';
			$db = Db::getInstance();
			/*$query = 'INSERT INTO `'._DB_PREFIX_.'order_detail`
					(`id_order`, `product_id`, `product_attribute_id`, `product_name`, `product_quantity`, `product_quantity_in_stock`, `product_price`, `reduction_percent`, `reduction_amount`, `group_reduction`, `product_quantity_discount`, `product_ean13`, `product_upc`, `product_reference`, `product_supplier_reference`, `product_weight`, `tax_name`, `tax_rate`, `ecotax`, `ecotax_tax_rate`, `discount_quantity_applied`, `download_deadline`, `download_hash`)
					VALUES ';*/

			$customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
			Product::addCustomizationPrice($products, $customizedDatas);
			$outOfStock = false;

			$storeAllTaxes = array();

			foreach ($products AS $key => $product)
			{
				$productQuantity = (int)(Product::getQuantity((int)($product['id_product']), ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL)));
				$quantityInStock = ($productQuantity - (int)($product['cart_quantity']) < 0) ? $productQuantity : (int)($product['cart_quantity']);
				if ($id_order_state != Configuration::get('PS_OS_CANCELED') AND $id_order_state != Configuration::get('PS_OS_ERROR'))
				{
					if (Product::updateQuantity($product, (int)$order->id))
						$product['stock_quantity'] -= $product['cart_quantity'];
					if ($product['stock_quantity'] < 0 && Configuration::get('PS_STOCK_MANAGEMENT'))
						$outOfStock = true;

					Product::updateDefaultAttribute($product['id_product']);
				}
				$price = Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 6, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
				$price_wt = Product::getPriceStatic((int)($product['id_product']), true, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 2, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));

				/* Store tax info */
				$id_country = (int)Country::getDefaultCountryId();
				$id_state = 0;
				$id_county = 0;
				$rate = 0;
				$id_address = $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
				$address_infos = Address::getCountryAndState($id_address);
				if ($address_infos['id_country'])
				{
					$id_country = (int)($address_infos['id_country']);
					$id_state = (int)$address_infos['id_state'];
					$id_county = (int)County::getIdCountyByZipCode($address_infos['id_state'], $address_infos['postcode']);
				}
				$allTaxes = TaxRulesGroup::getTaxes((int)Product::getIdTaxRulesGroupByIdProduct((int)$product['id_product']), $id_country, $id_state, $id_county);
				$nTax = 0;
				foreach ($allTaxes AS $res)
				{
					if (!isset($storeAllTaxes[$res->id]))
					{
						$storeAllTaxes[$res->id] = array();
						$storeAllTaxes[$res->id]['amount'] = 0;
					}
					$storeAllTaxes[$res->id]['name'] = $res->name[(int)$order->id_lang];
					$storeAllTaxes[$res->id]['rate'] = $res->rate;

					if (!$nTax++)
						$storeAllTaxes[$res->id]['amount'] += ($price * ($res->rate * 0.01)) * $product['cart_quantity'];
					else
					{
						$priceTmp = $price_wt / (1 + ($res->rate * 0.01));
						$storeAllTaxes[$res->id]['amount'] += ($price_wt - $priceTmp) * $product['cart_quantity'];
					}
				}
				/* End */

				// Add some informations for virtual products
				$deadline = '0000-00-00 00:00:00';
				$download_hash = NULL;
				if ($id_product_download = ProductDownload::getIdFromIdProduct((int)($product['id_product'])))
				{
					$productDownload = new ProductDownload((int)($id_product_download));
					$deadline = $productDownload->getDeadLine();
					$download_hash = $productDownload->getHash();
				}

				// Exclude VAT
				if (Tax::excludeTaxeOption())
				{
					$product['tax'] = 0;
					$product['rate'] = 0;
					$tax_rate = 0;
				}
				else
					$tax_rate = Tax::getProductTaxRate((int)($product['id_product']), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                $ecotaxTaxRate = 0;
                if (!empty($product['ecotax']))
                    $ecotaxTaxRate = Tax::getProductEcotaxRate($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                $product_price = (float)Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, false, false);

				$group_reduction = (float)GroupReduction::getValueForProduct((int)$product['id_product'], $customerNew->id_default_group) * 100;
				if (!$group_reduction)
					$group_reduction = Group::getReduction((int)$order->id_customer);

				$quantityDiscount = SpecificPrice::getQuantityDiscount((int)$product['id_product'], Shop::getCurrentShop(), (int)$cart->id_currency, (int)$vat_address->id_country, (int)$customerNew->id_default_group, (int)$product['cart_quantity']);
				$unitPrice = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? intval($product['id_product_attribute']) : NULL), 2, NULL, false, true, 1, false, (int)$order->id_customer, NULL, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
				$quantityDiscountValue = $quantityDiscount ? ((Product::getTaxCalculationMethod((int)$order->id_customer) == PS_TAX_EXC ? Tools::ps_round($unitPrice, 2) : $unitPrice) - $quantityDiscount['price'] * (1 + $tax_rate / 100)) : 0.00;

				/*$query .= '('.(int)($order->id).',
					'.(int)($product['id_product']).',
					'.(isset($product['id_product_attribute']) ? (int)($product['id_product_attribute']) : 'NULL').',
					\''.pSQL($product['name'].((isset($product['attributes']) AND $product['attributes'] != NULL) ? ' - '.$product['attributes'] : '')).'\',
					'.(int)($product['cart_quantity']).',
					'.$quantityInStock.',
					'.$product_price.',
					'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'percentage') ? $specificPrice['reduction'] * 100 : 0.00).',
					'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'amount') ? (!$specificPrice['id_currency'] ? Tools::convertPrice($specificPrice['reduction'], $order->id_currency) : $specificPrice['reduction']) : 0.00).',
					'.$group_reduction.',
					'.$quantityDiscountValue.',
					'.(empty($product['ean13']) ? 'NULL' : '\''.pSQL($product['ean13']).'\'').',
					'.(empty($product['upc']) ? 'NULL' : '\''.pSQL($product['upc']).'\'').',
					'.(empty($product['reference']) ? 'NULL' : '\''.pSQL($product['reference']).'\'').',
					'.(empty($product['supplier_reference']) ? 'NULL' : '\''.pSQL($product['supplier_reference']).'\'').',
					'.(float)($product['id_product_attribute'] ? $product['weight_attribute'] : $product['weight']).',
					\''.(empty($tax_rate) ? '' : pSQL($product['tax'])).'\',
					'.(float)($tax_rate).',
					'.(float)Tools::convertPrice(floatval($product['ecotax']), intval($order->id_currency)).',
					'.(float)$ecotaxTaxRate.',
					'.(($specificPrice AND $specificPrice['from_quantity'] > 1) ? 1 : 0).',
					\''.pSQL($deadline).'\',
					\''.pSQL($download_hash).'\'),';*/

				$customizationQuantity = 0;
				if (isset($customizedDatas[$product['id_product']][$product['id_product_attribute']]))
				{
					$customizationText = '';
					foreach ($customizedDatas[$product['id_product']][$product['id_product_attribute']] AS $customization)
					{
						if (isset($customization['datas'][_CUSTOMIZE_TEXTFIELD_]))
							foreach ($customization['datas'][_CUSTOMIZE_TEXTFIELD_] AS $text)
								$customizationText .= $text['name'].':'.' '.$text['value'].'<br />';

						if (isset($customization['datas'][_CUSTOMIZE_FILE_]))
							$customizationText .= sizeof($customization['datas'][_CUSTOMIZE_FILE_]) .' '. Tools::displayError('image(s)').'<br />';

						$customizationText .= '---<br />';
					}

					$customizationText = rtrim($customizationText, '---<br />');

					$customizationQuantity = (int)($product['customizationQuantityTotal']);
					$productsList .=
						'<tr>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$product['reference'].'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').' - '.$this->l('Customized').(!empty($customizationText) ? ' - '.$customizationText : '').'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$customizationQuantity.'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice($customizationQuantity * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</span></div></td>
						</tr>';
				}

				if (!$customizationQuantity OR (int)$product['cart_quantity'] > $customizationQuantity)
					$productsList .=
						'<tr>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$product['reference'].'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container"> '.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" 
							class="editable_text"><span class="text_container">'.((int)($product['cart_quantity']) - $customizationQuantity).'</span></div></td>
							<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.Tools::displayPrice(((int)($product['cart_quantity']) - $customizationQuantity) * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</span></div></td>
						</tr>';
				} // end foreach ($products)
				/*$query = rtrim($query, ',');
				$result = $db->Execute($query);*/

				/* Add carrier tax */
				$shippingCostTaxExcl = $cart->getOrderShippingCost((int)$order->id_carrier, false);
				$allTaxes = TaxRulesGroup::getTaxes((int)Carrier::getIdTaxRulesGroupByIdCarrier((int)$order->id_carrier), $id_country, $id_state, $id_county);
				$nTax = 0;

				foreach ($allTaxes AS $res)
				{
					if (!isset($res->id))
						continue;

					if (!isset($storeAllTaxes[$res->id]))
						$storeAllTaxes[$res->id] = array();
					if (!isset($storeAllTaxes[$res->id]['amount']))
						$storeAllTaxes[$res->id]['amount'] = 0;
					$storeAllTaxes[$res->id]['name'] = $res->name[(int)$order->id_lang];
					$storeAllTaxes[$res->id]['rate'] = $res->rate;

					if (!$nTax++)
						$storeAllTaxes[$res->id]['amount'] += ($shippingCostTaxExcl * (1 + ($res->rate * 0.01))) - $shippingCostTaxExcl;
					else
					{
						$priceTmp = $order->total_shipping / (1 + ($res->rate * 0.01));
						$storeAllTaxes[$res->id]['amount'] += $order->total_shipping - $priceTmp;
					}
				}

				/* Store taxes */
				foreach ($storeAllTaxes AS $t)
					Db::getInstance()->Execute('
					INSERT INTO '._DB_PREFIX_.'order_tax (id_order, tax_name, tax_rate, amount)
					VALUES ('.(int)$order->id.', \''.pSQL($t['name']).'\', '.(float)($t['rate']).', '.(float)$t['amount'].')');

				// Insert discounts from cart into order_discount table
				$discounts = $cart->getDiscounts();
				$discountsList = '';
				$total_discount_value = 0;
				$shrunk = false;
				foreach ($discounts AS $discount)
				{
					$objDiscount = new Discount((int)$discount['id_discount']);
					$value = $objDiscount->getValue(sizeof($discounts), $cart->getOrderTotal(true, Cart::ONLY_PRODUCTS), $order->total_shipping, $cart->id);
					if ($objDiscount->id_discount_type == 2 AND in_array($objDiscount->behavior_not_exhausted, array(1,2)))
						$shrunk = true;

					if ($shrunk AND ($total_discount_value + $value) > ($order->total_products_wt + $order->total_shipping + $order->total_wrapping))
					{
						$amount_to_add = ($order->total_products_wt + $order->total_shipping + $order->total_wrapping) - $total_discount_value;
						if ($objDiscount->id_discount_type == 2 AND $objDiscount->behavior_not_exhausted == 2)
						{
							$voucher = new Discount();
							foreach ($objDiscount AS $key => $discountValue)
								$voucher->$key = $discountValue;
							$voucher->name = 'VSRK'.(int)$order->id_customer.'O'.(int)$order->id;
							$voucher->value = (float)$value - $amount_to_add;
							$voucher->add();
							$params['{voucher_amount}'] = Tools::displayPrice($voucher->value, $currency, false);
							$params['{voucher_num}'] = $voucher->name;
							$params['{firstname}'] = $customerNew->firstname;
							$params['{lastname}'] = $customerNew->lastname;
							$params['{id_order}'] = $order->id;
							@Mail::Send((int)$order->id_lang, 'voucher', Mail::l('New voucher regarding your order #', (int)$order->id_lang).$order->id, $params, $customerNew->email, $customerNew->firstname.' '.$customerNew->lastname);
						}
					}
					else
						$amount_to_add = $value;
					$order->addDiscount($objDiscount->id, $objDiscount->name, $amount_to_add);
					$total_discount_value += $amount_to_add;
					if ($id_order_state != Configuration::get('PS_OS_ERROR') AND $id_order_state != Configuration::get('PS_OS_CANCELED'))
						$objDiscount->quantity = $objDiscount->quantity - 1;
					$objDiscount->update();

					$discountsList .=
					'<tr style="background-color:#EBECEE;">
							<td colspan="4" style="padding: 0.6em 0.4em; text-align: right;">'.$this->l('Voucher code:').' '.$objDiscount->name.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.($value != 0.00 ? '-' : '').Tools::displayPrice($value, $currency, false).'</td>
					</tr>';
				}

			$invoice = new Address((int)($order->id_address_invoice));
			$delivery = new Address((int)($order->id_address_delivery));
			$carrier = new Carrier((int)($order->id_carrier), $order->id_lang);
			$delivery_state = $delivery->id_state ? new State((int)($delivery->id_state)) : false;
			$invoice_state = $invoice->id_state ? new State((int)($invoice->id_state)) : false;
			//set approver and child names for Mail purpose .
			$child = new Customer((int)$order->id_customer);
			$child_name = $child->firstname; 			
			$approver_name = new Customer($customer->getApprover());
			
			$approver_data_name =  $approver_name->firstname;
			
			$data = array(
				'{firstname}' => $customerNew->firstname,
				'{lastname}' => $customerNew->lastname,
				'{email}' => $customerNew->email,
				'{delivery_block_txt}' => $this->_getFormatedAddress($delivery, "\n"),
				'{invoice_block_txt}' => $this->_getFormatedAddress($invoice, "\n"),
				'{delivery_block_html}' => $this->_getFormatedAddress($delivery, "<br />",
				array(
					'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
					'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{invoice_block_html}' => $this->_getFormatedAddress($invoice, "<br />",
				array(
					'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
					'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{delivery_company}' => $delivery->company,
					'{delivery_firstname}' => $delivery->firstname,
					'{delivery_lastname}' => $delivery->lastname,
					'{delivery_address1}' => $delivery->address1,
					'{delivery_address2}' => $delivery->address2,
					'{delivery_city}' => $delivery->city,
					'{delivery_postal_code}' => $delivery->postcode,
					'{delivery_country}' => $delivery->country,
					'{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
					'{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
					'{delivery_other}' => $delivery->other,
					'{invoice_company}' => $invoice->company,
					'{invoice_vat_number}' => $invoice->vat_number,
					'{invoice_firstname}' => $invoice->firstname,
					'{invoice_lastname}' => $invoice->lastname,
					'{invoice_address2}' => $invoice->address2,
					'{invoice_address1}' => $invoice->address1,
					'{invoice_city}' => $invoice->city,
					'{invoice_postal_code}' => $invoice->postcode,
					'{invoice_country}' => $invoice->country,
					'{invoice_state}' => $invoice->id_state ? $invoice_state->name : '',
					'{invoice_phone}' => ($invoice->phone) ? $invoice->phone : $invoice->phone_mobile,
					'{invoice_other}' => $invoice->other,
					'{order_name}' => sprintf("#%06d", (int)($order->id)),
					'{date}' => Tools::displayDate(date('Y-m-d H:i:s'), (int)($order->id_lang), 1),
					'{carrier}' => $carrier->name,
					'{payment}' => Tools::substr($order->payment, 0, 32),
					'{products}' => $productsList,
					'{discounts}' => $discountsList,
					'{total_paid}' => Tools::displayPrice($order->total_paid, $currency, false),
					'{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_wrapping + $order->total_discounts, $currency, false),
					'{total_discounts}' => Tools::displayPrice($order->total_discounts, $currency, false),
					'{total_shipping}' => Tools::displayPrice($order->total_shipping, $currency, false),
					'{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $currency, false),
					'{approver_name}' => $approver_data_name,
					'{approved_by}' =>$customer->firstname,
					'{child_name}' => $child_name,
					'{old_order_id}' => $creator_old_order_id);
 
 			if($customer->getApprover())
 			{
 				$em_sub = 'Order confirmation | The Order with Kobster.com [#'. $order->id .'] is pending for approval level 1'; 
				Mail::Send(1, 'order_submit_approval', Mail::l($em_sub, 1), $data, $approver_name->email, $approver_name->firstname.' '.$approver_name->lastname, NULL, NULL);
				Mail::Send(1, 'order_pending_approval_level1', Mail::l($em_sub, 1), $data, $customerNew->email, $customerNew->firstname.' '.$customerNew->lastname, NULL, NULL);
 			}
 			else if(!$customer->getApprover())
 			{
				$sql='SELECT id_customer,id_new_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE id_old_order=(SELECT DISTINCT id_old_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE id_new_order='.$order_id.')';
				$result=Db::getInstance()->ExecuteS($sql);
				foreach($result as $resultArr)
				{
					$res=new Customer($resultArr['id_customer']);
					$em_sub = 'Order confirmation | Your Order with Kobster.com [#'. $order->id .'] has  been successfully placed!';
					Mail::Send(1, 'order_approve_conf', Mail::l($em_sub, 1), $data, $res->email, $res->firstname.' '.$res->lastname, NULL, NULL);
				}
 			}
			
			
		}

		//Send SMS Alert
		$creater = new Customer($this->id_customer);
		$msgtxt='Hello '.$creater->firstname.', your order # '.$this->id.' has been approved. - Kobster.com';
		SMSAlert::sendSMSAlert($creater->mobile, $msgtxt);
	}
	
	public function rejectOrder($id_customer,$reject_msg = NULL)
	{
		global $cookie;
		//Change Order Status to Rejected
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		//$history->changeIdOrderState((int)(OrderState::FLAG_REJECTED), (int)$this->id);
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_REJECTED), (int)$this->id,$id_customer);
		
		//Persist the user who Rejected the order
		/*$historyCustomer = new HistoryCustomer();
		$historyCustomer->id_history = $history->id;
		$historyCustomer->id_customer = $id_customer;
		$historyCustomer->add();*/
		
		//Change Order Status to Cancelled
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		//$history->changeIdOrderState((int)(OrderState::FLAG_CANCELED), (int)$this->id);
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_CANCELED), (int)$this->id);
		
		// save approver msg for cancel the order  in kob_message
		if($reject_msg)
		{
			$message = new Message();
			$message->message = $reject_msg;
			$message->id_customer = $id_customer;
			$message->id_employee= 0;
			$message->private= 1;
			$message->id_order= (int)$this->id;
			$message->add();
			$reason = $reject_msg;
		}
		else
			$reason = "No Reason Provided";
		/*Information part- SEND MAIL & SMS */
		$creater = new Customer($this->id_customer);
		$creater_name = ''.$creater->firstname.' '.$creater->lastname.'';
		$approver = new Customer($id_customer);
		$approver_name = ''.$approver->firstname.' '.$approver->lastname.'';

		$order_has_origin = Order::getOrginOrderId($history->id_order);

		if($order_has_origin)
		{
			$orgin_related_orders = Order::getOrginChildIds($order_has_origin);

			for($i = 0; $i < sizeof($orgin_related_orders); $i++)
			{
				if($orgin_related_orders[$i]['id_customer'])
				{
					$intermediate_approver = new Customer($orgin_related_orders[$i]['id_customer']);

					if($intermediate_approver)
					{
						$intermediate_approver_name = ''.$intermediate_approver->firstname.' '.$intermediate_approver->lastname.'';						
						//Send Mail to intermediate approvers who related to this order
						Mail::Send(1, 'rejectcreatororder', Mail::l('Order has been Rejected ', 1), array('{approver_name}' => $approver_name,'{creater_name}' => $intermediate_approver_name, '{order_id}' => (int)$this->id, '{reason}' => $reason), $intermediate_approver->email, 'Order has been Rejected', 'noreply@kobster.com');
			
						//Send SMS Alert to intermediate approvers who related to this order
				 		$msgtxt='Hello '.$intermediate_approver->firstname.', your order # '.$this->id.' has been rejected. Check email for more details. - Kobster.com';
						SMSAlert::sendSMSAlert($intermediate_approver->mobile, $msgtxt);
					}
				}
			}
		}
		else
		{ // if order has no origin
			$status = OrderHistory::getAllStatus((int)($history->id_order),1);
			$latest_status = array_reverse($status);

			for($i = 0; $i < sizeof($latest_status); $i++)
			{
				if($latest_status[$i]['id_order_state'] != 6 && $latest_status[$i]['id_order_state'] != 30 && $latest_status[$i]['id_order_state'] != 9 && $latest_status[$i]['id_order_state'] != 28 )
				{
					$history_customer = OrderHistory::getHistoryCustomer($latest_status[$i]['id_order_history']);

					for($j = 0 ; $j < sizeof($history_customer); $j++)
					{
						$intermediate_approver = new Customer((int)($history_customer[$j]['id_customer']));

						if($intermediate_approver)
						{
							$intermediate_approver_name = ''.$intermediate_approver->firstname.' '.$intermediate_approver->lastname.'';						
							//Send Mail to intermediate approvers who related to this order
							Mail::Send(1, 'rejectcreatororder', Mail::l('Order has been Rejected ', 1), array('{approver_name}' => $approver_name,'{creater_name}' => $intermediate_approver_name, '{order_id}' => (int)$this->id, '{reason}' => $reason), $intermediate_approver->email, 'Order has been Rejected', 'noreply@kobster.com');
				
							//Send SMS Alert to intermediate approvers who related to this order
					 		$msgtxt='Hello '.$intermediate_approver->firstname.', your order # '.$this->id.' has been rejected. Check email for more details. - Kobster.com';
							SMSAlert::sendSMSAlert($intermediate_approver->mobile, $msgtxt);
						}
					}
				}
			}		
		}

		//Send Mail to Creator
		Mail::Send(1, 'rejectcreatororder', Mail::l('Order has been Rejected ', 1), array('{approver_name}' => $approver_name,'{creater_name}' => $creater_name, '{order_id}' => (int)$this->id, '{reason}' => $reason), $creater->email, 'Order has been Rejected', 'noreply@kobster.com');			
		//Send SMS Alert
 		$msgtxt='Hello '.$creater->firstname.', your order # '.$this->id.' has been rejected. Check email for more details. - Kobster.com';
		SMSAlert::sendSMSAlert($creater->mobile, $msgtxt);
	}
	
	public function reviseChildOrder($id_customer)
	{
		//step 1 -> order revised
		$history = new OrderHistory();
		$history->id_order = (int)$this->id;
		$history->id_employee = 0;
		//self::$cookie->revised = 1;
		//$history->changeIdOrderState((int)(OrderState::FLAG_REJECTED), (int)$this->id);
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_ORDER_REVISED), (int)$this->id,$id_customer);
		
		//step 2 -> cancelled order
		$history->changeIdOrderStateByApprover((int)(OrderState::FLAG_CANCELED), (int)$this->id ,$id_customer);
	}
	public function updateOrderPayment($payment)
	{
 		$this->payment = $payment;
		$this->update();
	}
	public function getChildrenOrders($id_customer)
	{
 		

		global $cookie;
 		if($cookie->role == 2)
		{
			
 			$id_order_status = 28; 
		}
 		else if($cookie->role == 3)
		{
  			$id_order_status = 43;
		}
		
 		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('SELECT parent.id_customer ,cus.firstname, o.id_order,o.`id_address_delivery` as delivery,o.`id_address_invoice` as invoice, oh.id_order_history,DATE_FORMAT(o.date_add,"%d-%m-%Y") as date_add
																FROM `'._DB_PREFIX_.'customer_parent` parent , '._DB_PREFIX_.'orders o , '._DB_PREFIX_.'order_history oh, '._DB_PREFIX_.'customer cus
																where parent.id_parent = '.$id_customer.'
																and o.id_customer = parent.id_customer
																and oh.id_order = o.id_order
																and cus.id_customer = o.id_customer
																and oh.id_order_state = '.$id_order_status.'
																and oh.id_order_history in (
																	SELECT  MAX(oha.`id_order_history`)
																	FROM '._DB_PREFIX_.'order_history AS oha
																	WHERE o.id_order = oha.id_order
																	GROUP BY oha.id_order) ORDER BY o.id_order DESC');
		
		return 	$result;											
		
	}
	
	public function getCusIdForOrder($id_order){
		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
		SELECT o.id_customer FROM `'._DB_PREFIX_.'orders` o
		WHERE o.`id_order`='.$id_order.'
		GROUP BY o.`id_order`
		ORDER BY o.`date_add` DESC');
		return $res;
	}
	/*public function getTopProductInCategory($customerid,$duration,$selected_category)
	{
		if($duration == 1)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 3 MONTH';
		}
		else if($duration == 2)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 6 MONTH';
		}
		else if($duration == 3)
		{
			$due_query = 'AND o.date_add >= NOW()-INTERVAL 1 YEAR';
		}
		else 
		{
			$due_query ='';
		}
		 return Db::getInstance()->ExecuteS('SELECT count(od.product_id) as y,pl.name AS indexLabel,sum(od.product_quantity-od.product_quantity_return-product_quantity_refunded) as qty, round(sum((od.product_quantity-od.product_quantity_return-product_quantity_refunded)*od.product_price+(od.product_price*od.tax_rate/100))) as total
												FROM '._DB_PREFIX_.'order_detail od
												left join '._DB_PREFIX_.'orders o on o.id_order=od.id_order
												left join '._DB_PREFIX_.'product_lang pl on pl.id_product = od.product_id
												left join '._DB_PREFIX_.'order_history oh on od.id_order = oh.id_order 
												where id_customer = '.$customerid.' and pl.id_lang=1 and od.product_id IN (SELECT id_product FROM '._DB_PREFIX_.'category_product WHERE id_category IN (SELECT c.id_category FROM `'._DB_PREFIX_.'category` c LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = 1) WHERE `id_parent` ='.$selected_category.')) and oh.id_order_history in(SELECT  MAX(oha.`id_order_history`)
																									FROM '._DB_PREFIX_.'order_history AS oha
																									LEFT JOIN '._DB_PREFIX_.'orders AS oa
																									ON oa.id_order = oha.id_order 
																									where oa.id_customer = '.$customerid.'
																									GROUP BY oha.id_order)
												AND oh.`id_order_state` IN ( 5,25 ) '.$due_query.'
												group by od.product_id order by y desc limit 10');
												
	}
	*/
	

	public function getCusOrders($id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT a.`id_order` FROM `'._DB_PREFIX_.'orders` a WHERE a.`id_customer` = '.$id_customer.'');

	}
	/*if the order get revised then the old oder id and new order id will save with whom place the order. so we can retervie for future purpose */
	public function getOrginOrderId($new_order_id)
	{
   		return Db::getInstance()->getValue('Select id_old_order FROM `'._DB_PREFIX_.'orgin_orders` WHERE  id_new_order='.$new_order_id.'');
	}
	public function getOrginChildIds($orgin_order_id)
	{
 		$result = Db::getInstance()->ExecuteS('Select *  FROM `'._DB_PREFIX_.'orgin_orders` WHERE  id_old_order='.$orgin_order_id.'');
 		
		$res_str='';
		foreach($result AS $res)
				$res_str = $res_str.$res['id_new_order'].',';
		$res_str = $res_str.$orgin_order_id;
		 $res_str;
		 
 		 
		return Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'orgin_orders where id_new_order in ('.$res_str.') ORDER BY `id_new_order` DESC ');
	}
}

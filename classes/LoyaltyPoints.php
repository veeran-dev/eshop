<?php
/**
 * Modified for elite v2
 * Author: Elumalai K
**/
class LoyaltyPointsCore extends ObjectModel
{
	public $id_loyalty_state;
	public $id_customer;
	public $id_order;
	public $id_cart_rule;
	public $points;
	public $date_add;
	public $date_upd;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'loyalty',
		'primary' => 'id_loyalty',
		'fields' => array(
			'id_loyalty_state' =>	array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'id_customer' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'id_order' =>			array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'id_cart_rule' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'points' =>				array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'date_add' =>			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'date_upd' =>			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
		)
	);

	public function save($nullValues = false, $autodate = true)
	{
		parent::save($nullValues, $autodate);
		$this->historize();
	}

	public function getPointsByCustomer($id_customer)
	{
		$validity_period = Configuration::get('PS_LOYALTY_VALIDITY_PERIOD');

		$sql_period = ((int)$validity_period > 0) ? ' AND datediff(NOW(),f.date_add) <= '.$validity_period : "";

		$available = Db::getInstance()->getValue('SELECT SUM(f.points) points
												  FROM `'._DB_PREFIX_.'loyalty` f
												  WHERE f.id_customer = '.(int)($id_customer).'
												  AND f.id_loyalty_state IN ('.(int)($this->getValidationId()).', '.(int)($this->getNoneAwardId()).')
												  '.$sql_period.'');

		$cancelled = Db::getInstance()->getValue('SELECT SUM(f.points) points
												  FROM `'._DB_PREFIX_.'loyalty` f
												  WHERE f.id_customer = '.(int)($id_customer).'
												  AND f.id_loyalty_state = '.(int)$this->getCancelId().'
												  AND points < 0
												 '.$sql_period.'');

		// return (int)$available + (int)$cancelled;
		return (int)$available;
	}

	public function getDefaultId() { return 1; }
	public function getValidationId() { return 2; }
	public function getCancelId() { return 3; }
	public function getConvertId() { return 4; }
	public function getNoneAwardId() { return 5; }
	
	public function getDiscountId($id_customer)
	{
		$value = Db::getInstance()->Execute('SELECT id_discount FROM `'._DB_PREFIX_.' discount d WHERE id_customer ='.(int)id_customer);
		return $value;
	}
	
	public function historize()
	{
		$value = Db::getInstance()->Execute('
		INSERT INTO `'._DB_PREFIX_.'loyalty_history` (`id_loyalty`, `id_loyalty_state`, `points`, `date_add`)
		VALUES ('.(int)($this->id).', '.(int)($this->id_loyalty_state).', '.(int)($this->points).', NOW())');			
	}
	
	public function getAllByIdCustomer($id_customer, $id_lang, $onlyValidate , $pagination , $nb = 10, $page = 1)
	{
		$validity_period = Configuration::get('PS_LOYALTY_VALIDITY_PERIOD');

		$filterQuery = "";
		$filterQuery .= (int)$validity_period > 0 ? ' AND datediff(NOW(),f.`date_add`) <= '.$validity_period : "";
		$filterQuery .= $onlyValidate === true ? ' AND f.`id_loyalty_state` = '.(int)($this->getValidationId()) : "";
		$filterQuery .= ' GROUP BY f.`id_loyalty` '.($pagination ? 'LIMIT '.(((int)($page) - 1) * (int)($nb)).', '.(int)($nb) : '');

		$query = 'SELECT f.`id_order` AS id, DATE_FORMAT(f.`date_add`, "%M %d, %Y") AS date_add, (o.`total_paid` - o.`total_shipping`) total_without_shipping, f.`points`, f.`id_loyalty`, f.`id_loyalty_state`, fsl.`name` state
				  FROM `'._DB_PREFIX_.'loyalty` f
				  LEFT JOIN `'._DB_PREFIX_.'orders` o ON (f.`id_order` = o.`id_order`)
		          LEFT JOIN `'._DB_PREFIX_.'loyalty_state_lang` fsl ON (f.`id_loyalty_state` = fsl.`id_loyalty_state` AND fsl.`id_lang` = '.(int)($id_lang).')
		          WHERE f.`points` > 0 AND f.`id_customer` = '.(int)($id_customer).' '.$filterQuery.'';

		return Db::getInstance()->executeS($query);
	}

	public function getDiscountByIdCustomer($id_customer, $last=false)
	{
		$query = 'SELECT f.`id_discount` AS id_discount, f.`date_upd` AS date_add
				  FROM `'._DB_PREFIX_.'loyalty` f
				  LEFT JOIN `'._DB_PREFIX_.'orders` o ON (f.`id_order` = o.`id_order`)
				  WHERE f.`id_customer` = '.(int)($id_customer).' 
				  AND f.`id_discount` > 0
				  AND o.`valid` = 1';
	    if ($last === true)
			$query.= ' ORDER BY f.`id_loyalty` DESC LIMIT 0,1';
		$query.= ' GROUP BY f.`id_discount`';

		return Db::getInstance()->ExecuteS($query);
	}

	public function getVoucherValue($nbPoints, $id_currency=NULL)
	{
		$currency = $id_currency ? new Currency($id_currency) : Context::getContext()->currency->id;

		return (int)$nbPoints * (float)Tools::convertPrice(Configuration::get('PS_LOYALTY_POINT_VALUE'), $currency);
	}
	
	public function registerDiscount($cartRule, $orderIDs)
	{
		if (!Validate::isLoadedObject($cartRule))
			die(Tools::displayError('Incorrect object CartRule.'));
		
		$associated = false;

		$orders = explode(",", $orderIDs);

		foreach ($orders AS $item)
		{

			$loyaltyArray = explode("-", $item);

			$loyaltyObj = new LoyaltyPoints((int)$loyaltyArray[2]);

			/* Check for negative points for this order */
			$negativePoints = (int)Db::getInstance()->getValue('SELECT SUM(points) points FROM '._DB_PREFIX_.'loyalty WHERE id_order = '.(int)$loyaltyArray[0].' AND id_loyalty_state = '.(int)$this->getCancelId().' AND points < 0');

			if ($loyaltyObj->points + $negativePoints <= 0)
				continue;

			$loyaltyObj->id_cart_rule = (int)$cartRule->id;
			$loyaltyObj->id_loyalty_state = (int)$this->getConvertId();
			$loyaltyObj->save();
			$associated = true;
		}

		return $associated;
	}
	
	public function dateAdd($id_customer)
	{
		return Db::getInstance()->getValue('SELECT UNIX_TIMESTAMP(date_add) n
												 FROM '._DB_PREFIX_.'loyalty 
												 WHERE id_discount = 0 AND id_customer = '.(int)$id_customer.'
												 ORDER BY date_add DESC');
	}
	
	public function displayVoucher($id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT name,value FROM '._DB_PREFIX_.'discount d
											WHERE id_customer='.(int)$id_customer);
	}

	public function countVoucher($id_customer)
	{
		$current_used_voucher = self::$cart->getDiscounts(false,true);
		
		$count_voucher = Db::getInstance()->getValue('SELECT count(id_discount) FROM '._DB_PREFIX_.'discount d WHERE id_customer = '.(int)$id_customer);

		return $count_voucher;
	
	}
	
	public function getNbPointsByPrice($price)
	{
		global $cookie;

		if (Configuration::get('PS_CURRENCY_DEFAULT') != $cookie->id_currency)
		{
			$currency = new Currency((int)($cookie->id_currency));
			if ($currency->conversion_rate)
				$price = $price / $currency->conversion_rate;
		}

		// Prevent division by zero 
		$points = 0;
		if ($pointRate = (float)(Configuration::get('PS_LOYALTY_POINT_RATE')))
			$points = floor(number_format($price, 2, '.', '') / $pointRate);

		return (int)$points;	
	}
	
}
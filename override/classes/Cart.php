<?php
Class Cart extends CartCore
{
	public function updateNewAddressId($id_address_delivery)
    {
        $sql = 'UPDATE `'._DB_PREFIX_.'cart_product`
		SET `id_address_delivery` = '.(int)$id_address_delivery.'
		WHERE  `id_cart` = '.(int)$this->id.'';
			
        return Db::getInstance()->execute($sql);
    }

	public function getReorderProducts($old_cart, $id_supplier = 0)
	{
		$context = Context::getContext();
		$where = '';

    	if(isset($context->cookie->delivery_region) && $context->cookie->delivery_region){
            $fc = new FulfillmentCentre($context->cookie->delivery_region);
    		$where = ' AND ka.id_state = '.$fc->id_state.' ';
    	}

		return Db::getInstance()->ExecuteS('SELECT p.`discontinued`, p.`reference`, pl.`name`, cp.* 
			FROM `'._DB_PREFIX_.'product` as p
			LEFT JOIN `'._DB_PREFIX_.'cart_product` as cp on (cp.`id_product` = p.`id_product`)
			LEFT JOIN `'._DB_PREFIX_.'elite_supplier` kes on (kes.id_supplier = cp.id_supplier)
			LEFT JOIN `'._DB_PREFIX_.'elite_supplier_address` ksa on (ksa.id_supplier = kes.id_supplier)
    		LEFT JOIN `'._DB_PREFIX_.'address` ka on (ka.id_address = ksa.id_address)
			LEFT JOIN `'._DB_PREFIX_.'product_lang` as pl on (p.`id_product` = pl.`id_product`)
			WHERE cp.id_cart = '.$old_cart.'
			'.($id_supplier ? 'AND cp.`id_supplier` = '.$id_supplier.'' : '').' 
			'.$where.'
			AND pl.`id_lang` = 1' 
		);	
	}

	public function getCartProducts($old_cart, $product_list, $product_attribute_list)
	{
		return Db::getInstance()->ExecuteS('Select p.discontinued, p.reference, pl.name, cp.* 
												from `'._DB_PREFIX_.'product` as p
												left join `'._DB_PREFIX_.'cart_product` as cp
												on cp.id_product = p.id_product
												left join `'._DB_PREFIX_.'product_lang` as pl
												on p.id_product = pl.id_product
												WHERE cp.id_cart='.$old_cart.' and cp.id_product in('.$product_list.')
												and cp.id_product_attribute in('.$product_attribute_list.')
												and pl.id_lang=1' ); 

	}
	public static function removeCartProducts($id_cart, $id_product, $qty, $id_product_attribute)
	{
		return Db::getInstance()->Execute('update `'._DB_PREFIX_.'cart_product` set quantity = quantity-'.$qty.' where id_product='.$id_product.' and id_product_attribute='.$id_product_attribute.' and id_cart='.$id_cart.'');

	}
	public static function deleteCartProducts($id_cart, $id_product, $id_product_attribute)
	{
		return Db::getInstance()->Execute('delete from `'._DB_PREFIX_.'cart_product` where id_product='.$id_product.' and id_product_attribute='.$id_product_attribute.' and id_cart='.$id_cart.'');

	}

	public function checkSameProductSupplier($id_supplier, $id_product)
	{
		$result = Db::getInstance()->ExecuteS('Select id_supplier from `'._DB_PREFIX_.'cart_product` WHERE id_cart='.$this->id.' and id_product='.$id_product ); 
        if(!$result){
            return false;
        }
		return $result['0']['id_supplier'] != $id_supplier ? true:false;	
	}

	public function getProductsWithSummary() {
		if(!$this->context) {
			$this->context = Context::getContext();
		}

		$total_with_tax = $this->context->cart->getOrderTotal(true);
		$total_without_tax = $this->context->cart->getOrderTotal(false);
		$discount = $this->context->cart->getDiscounts(false,true);
		$cart_products = $this->context->cart->getProducts(true);
		$cart_summary = array(
			'shippingPrice' => Tools::displayPrice($this->context->cart->getOrderTotal($useTax, Cart::ONLY_SHIPPING)),
			'totalTax' => Tools::displayPrice($total_with_tax - $total_without_tax),
			'totalPrice' => Tools::displayPrice($total_with_tax),
			'discounts' => $this->context->cart->getDiscounts(false,true),
			'loyaltyPoints' => 0,
			'totalProducts' => count($cart_products)
		);

		return array('products' => $cart_products, 'summary' => $cart_summary);
	}
}
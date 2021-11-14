<?php
/*
*
* Payment module override created by Elumalai Kaliyaperumal.
*
*/
abstract class PaymentModule extends PaymentModuleCore

{
    /**
     * Validate an order in database
     * Function called from a payment module
     *
     * @param int $id_cart
     * @param int $id_order_state
     * @param float   $amount_paid    Amount really paid by customer (in the default currency)
     * @param string  $payment_method Payment method (eg. 'Credit card')
     * @param null    $message        Message to attach to order
     * @param array   $extra_vars
     * @param null    $currency_special
     * @param bool    $dont_touch_amount
     * @param bool    $secure_key
     * @param Shop    $shop
     *
     * @return bool
     * @throws PrestaShopException
     */
    const PENDING_FOR_APPROVAL = 5;

    public

    function validateOrder($id_cart, $id_order_state, $amount_paid, $payment_method = 'Unknown', $message = null, $extra_vars = array() , $currency_special = null, $dont_touch_amount = false, $secure_key = false, $dash = 0, Shop $shop = null, $split_order = false)
    {
        $logger = new FileLogger();
        $logger->setFilename('order_history_track.txt');
        $logger->logError('-------------PaymentModule---------------');
        $logger->logError('id_cart==>' . $id_cart);
        $logger->logError('id_order_state_pm==>' . $id_order_state);
        $logger->logError('-------------END---------------');
        if (self::DEBUG_MODE) {
            PrestaShopLogger::addLog('PaymentModule::validateOrder - Function called', 1, null, 'Cart', (int)$id_cart, true);
        }

        if (!isset($this->context)) {
            $this->context = Context::getContext();
        }

        if ($dash == 1) {
            if ($secure_key != $this->context->cart->secure_key) {
                $this->context->cart->secure_key = $secure_key;

                // $cart->update();

            }
        }

        $this->context->cart = new Cart((int)$id_cart);
        $this->context->customer = new Customer((int)$this->context->cart->id_customer);

        // The tax cart is loaded before the customer so re-cache the tax calculation method

        $this->context->cart->setTaxCalculationMethod();
        $this->context->language = new Language((int)$this->context->cart->id_lang);
        $this->context->shop = ($shop ? $shop : new Shop((int)$this->context->cart->id_shop));
        ShopUrl::resetMainDomainCache();
        $id_currency = $currency_special ? (int)$currency_special : (int)$this->context->cart->id_currency;
        $this->context->currency = new Currency((int)$id_currency, null, (int)$this->context->shop->id);
        if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery') {
            $context_country = $this->context->country;
        }

        $order_status = new OrderState((int)$id_order_state, (int)$this->context->language->id);
        if (!Validate::isLoadedObject($order_status)) {
            PrestaShopLogger::addLog('PaymentModule::validateOrder - Order Status cannot be loaded', 3, null, 'Cart', (int)$id_cart, true);
            throw new PrestaShopException('Can\'t load Order status');
        }

        // Does order already exists ?

        if (Validate::isLoadedObject($this->context->cart) && $this->context->cart->OrderExists() == false) {

            // For each package, generate an order

            $delivery_option_list = $this->context->cart->getDeliveryOptionList();
            $package_list = $this->context->cart->getPackageList();
            $cart_delivery_option = $this->context->cart->getDeliveryOption();
            $supplier_wise_products = array();
            $ordered_products = array();
            $order_carrier = 0;

            foreach($package_list as $id_address => $packageByAddress) {
                foreach($packageByAddress as $id_package => $package) {
                    /*** Separate products by supplier ***/
                    $supplier_wise_products = Tools::group_by($package['product_list'], 'id_supplier');
                    $ordered_products = $package['product_list'];
                    $order_carrier = $package['id_carrier'];
                }
            }

            /*** Create orders supplier wise ***/
            if(isset($supplier_wise_products) && sizeof($supplier_wise_products) > 0) {

                $placed_orders = array();
                $products_with_supplier_name = '';

                foreach($supplier_wise_products as $key => $products) {
                    $elite_supplier = new EliteSupplier(intval($key));
                    $order_creation_failed = false;
                    $order_list = array();
                    $order_detail_list = array();

                    /** Create order reference **/
                    do {
                        $reference = Order::generateReference();
                    } while (Order::getByReference($reference)->count());

                    $this->currentOrderReference = $reference;
                    
                    /* Create new order Object */
                    $order = new Order();
                    $order->product_list = $products;

                    if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery') {
                        $address = new Address((int)$id_address);
                        $this->context->country = new Country((int)$address->id_country, (int)$this->context->cart->id_lang);
                        if (!$this->context->country->active) {
                            throw new PrestaShopException('The delivery address country is not active.');
                        }
                    }

                    $carrier = null;
                    if (!$this->context->cart->isVirtualCart() && isset($order_carrier)) {
                        if($order_carrier) {
                            $carrier = new Carrier((int)$order_carrier, (int)$this->context->cart->id_lang);
                            $order->id_carrier = (int)$carrier->id;
                            $id_carrier = (int)$carrier->id;
                        }
                    }
                    else {
                        $order->id_carrier = 0;
                        $id_carrier = 0;
                    }

                    $order->id_customer = (int)$this->context->cart->id_customer;
                    $order->id_address_invoice = (int)$this->context->cart->id_address_invoice;
                    $order->id_address_delivery = (int)$this->context->cart->id_address_delivery;
                    $order->id_currency = $this->context->currency->id;
                    $order->id_lang = (int)$this->context->cart->id_lang;
                    $order->id_cart = (int)$this->context->cart->id;
                    $order->reference = $this->currentOrderReference;
                    $order->id_shop = (int)$this->context->shop->id;
                    $order->id_shop_group = (int)$this->context->shop->id_shop_group;
                    $order->secure_key = ($secure_key ? pSQL($secure_key) : pSQL($this->context->customer->secure_key));
                    $order->payment = $payment_method;
                    if (isset($this->name)) {
                        $order->module = $this->name;
                    }

                    $order->recyclable = $this->context->cart->recyclable;
                    $order->gift = (int)$this->context->cart->gift;
                    $order->gift_message = $this->context->cart->gift_message;
                    $order->mobile_theme = $this->context->cart->mobile_theme;
                    $order->conversion_rate = $this->context->currency->conversion_rate;
                    $amount_paid = !$dont_touch_amount ? Tools::ps_round((float)$amount_paid, 2) : $amount_paid;
                    $order->total_paid_real = 0;
                    $order->total_products = (float)$this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS, $order->product_list, $id_carrier);
                    $order->total_products_wt = (float)$this->context->cart->getOrderTotal(true, Cart::ONLY_PRODUCTS, $order->product_list, $id_carrier);
                    $order->total_discounts_tax_excl = (float)abs($this->context->cart->getOrderTotal(false, Cart::ONLY_DISCOUNTS, $order->product_list, $id_carrier));
                    $order->total_discounts_tax_incl = (float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS, $order->product_list, $id_carrier));
                    $order->total_discounts = $order->total_discounts_tax_incl;
                    if ($this->context->customer->id_buyer != 3) {
                        $order->total_shipping_tax_excl = (float)$this->context->cart->getPackageShippingCost((int)$id_carrier, false, null, $order->product_list);
                        $order->total_shipping_tax_incl = (float)$this->context->cart->getPackageShippingCost((int)$id_carrier, true, null, $order->product_list);
                    }
                    else {
                        $order->total_shipping_tax_excl = 0;
                        $order->total_shipping_tax_incl = 0;
                    }

                    $order->total_shipping = $order->total_shipping_tax_incl;
                    if (!is_null($carrier) && Validate::isLoadedObject($carrier)) {
                        $order->carrier_tax_rate = $carrier->getTaxesRate(new Address((int)$this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE') }));
                    }

                    $order->total_wrapping_tax_excl = (float)abs($this->context->cart->getOrderTotal(false, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
                    $order->total_wrapping_tax_incl = (float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
                    $order->total_wrapping = $order->total_wrapping_tax_incl;
                    $order->total_paid_tax_excl = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(false, Cart::BOTH, $order->product_list, $id_carrier) , _PS_PRICE_COMPUTE_PRECISION_); //Cart::BOTH changed to ONLY_PRODUCTS Ref #685
                    $order->total_paid_tax_incl = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(true, Cart::BOTH, $order->product_list, $id_carrier) , _PS_PRICE_COMPUTE_PRECISION_); //Cart::BOTH changed to ONLY_PRODUCTS Ref #685
                    $order->total_paid = $order->total_paid_tax_incl;
                    $order->round_mode = Configuration::get('PS_PRICE_ROUND_MODE');
                    $order->round_type = Configuration::get('PS_ROUND_TYPE');
                    $order->invoice_date = '0000-00-00 00:00:00';
                    $order->delivery_date = '0000-00-00 00:00:00';
                    /*
                    * Order fulfillment Center done by veeran.b
                    * Modified on 27th Feb, 2018 by Elumalai K
                    */
                    if (isset($this->context->cookie->id_state) && $this->context->cookie->id_state) {
                        $stateObj = new State(intval($this->context->cookie->id_state));
                        $order->id_fc = intval($stateObj->getFcIdByState());
                    }
                    else {
                        $id_fc = Order::getFulfillmentCenter((int)$this->context->cart->id_address_delivery);
                        $order->id_fc = $id_fc['id_fulfillment_centre'];
                    }

                    /** Add employee id if order created from employee **/
                    if (isset($this->context->cookie->id_employee) && $this->context->cookie->id_employee) {
                        $order->id_employee = $this->context->cookie->id_employee;
                    }

                    if (self::DEBUG_MODE) {
                        PrestaShopLogger::addLog('PaymentModule::validateOrder - Order is about to be added', 1, null, 'Cart', (int)$id_cart, true);
                    }

                    /*** Creating order master ***/
                    $result = $order->add();

                    if (!$result) {
                        PrestaShopLogger::addLog('PaymentModule::validateOrder - Order cannot be created', 3, null, 'Cart', (int)$id_cart, true);
                        throw new PrestaShopException('Can\'t save Order');
                    }

                    // Amount paid by customer is not the right one -> Status = payment error
                    // We don't use the following condition to avoid the float precision issues : http://www.php.net/manual/en/language.types.float.php
                    // if ($order->total_paid != $order->total_paid_real)
                    // We use number_format in order to compare two string

                    if ($order_status->logable && number_format($cart_total_paid, _PS_PRICE_COMPUTE_PRECISION_) != number_format($amount_paid, _PS_PRICE_COMPUTE_PRECISION_)) {
                        $id_order_state = Configuration::get('PS_OS_ERROR');
                    }

                    $order_list[] = $order;
                    if (self::DEBUG_MODE) {
                        PrestaShopLogger::addLog('PaymentModule::validateOrder - OrderDetail is about to be added', 1, null, 'Cart', (int)$id_cart, true);
                    }

                    // Insert new Order detail list using cart for the current order
                    $order_detail = new OrderDetail(null, null, $this->context);
                    $fc = new FulfillmentCentre($this->context->cookie->delivery_region);
                    $sez_address = new Address($this->context->cart->id_address_delivery);
                    $use_taxes = ($fc->lut != '' && $sez_address->isez == 1) ? false : true;
                    $order_detail->createList($order, $this->context->cart, $id_order_state, $order->product_list, 0, $use_taxes, $package_list[$id_address][$id_package]['id_warehouse']);
                    $order_detail_list[] = $order_detail;
                    
                    if (self::DEBUG_MODE) {
                        PrestaShopLogger::addLog('PaymentModule::validateOrder - OrderCarrier is about to be added', 1, null, 'Cart', (int)$id_cart, true);
                    }

                    // Adding an entry in order_carrier table

                    if (!is_null($carrier)) {
                        $order_carrier = new OrderCarrier();
                        $order_carrier->id_order = (int)$order->id;
                        $order_carrier->id_carrier = (int)$id_carrier;
                        $order_carrier->weight = (float)$order->getTotalWeight();
                        $order_carrier->shipping_cost_tax_excl = (float)$order->total_shipping_tax_excl;
                        $order_carrier->shipping_cost_tax_incl = (float)$order->total_shipping_tax_incl;
                        $order_carrier->add();
                    }

                    // The country can only change if the address used for the calculation is the delivery address, and if multi-shipping is activated
                    if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery') {
                        $this->context->country = $context_country;
                    }

                    if (!$this->context->country->active) {
                        PrestaShopLogger::addLog('PaymentModule::validateOrder - Country is not active', 3, null, 'Cart', (int)$id_cart, true);
                        throw new PrestaShopException('The order address country is not active.');
                    }

                    if (self::DEBUG_MODE) {
                        PrestaShopLogger::addLog('PaymentModule::validateOrder - Payment is about to be added', 1, null, 'Cart', (int)$id_cart, true);
                    }

                    // Register Payment only if the order status validate the order

                    if ($order_status->logable) {
                        // $order is the last order loop in the foreach
                        // The method addOrderPayment of the class Order make a create a paymentOrder
                        // linked to the order reference and not to the order id
                        if (isset($extra_vars['transaction_id'])) {
                            $transaction_id = $extra_vars['transaction_id'];
                        }
                        else {
                            $transaction_id = null;
                        }

                        if (!$order->addOrderPayment($amount_paid, null, $transaction_id)) {
                            PrestaShopLogger::addLog('PaymentModule::validateOrder - Cannot save Order Payment', 3, null, 'Cart', (int)$id_cart, true);
                            throw new PrestaShopException('Can\'t save Order Payment');
                        }
                    }

                    // Next !
                    $only_one_gift = false;
                    $cart_rule_used = array();

                    // Make sure CartRule caches are empty
                    CartRule::cleanCache();

                    foreach($order_detail_list as $key => $order_detail) {
                        /** @var OrderDetail $order_detail */
                        $order = $order_list[$key];
                        if (!$order_creation_failed && isset($order->id)) {
                            if (!$secure_key) {
                                $message.= '<br />' . Tools::displayError('Warning: the secure key is empty, check your payment account before validation');
                            }

                            // Optional message to attach to this order
                            if (isset($message) & !empty($message)) {
                                $msg = new Message();
                                $message = strip_tags($message, '<br />');
                                if (Validate::isCleanHtml($message)) {
                                    if (self::DEBUG_MODE) {
                                        PrestaShopLogger::addLog('PaymentModule::validateOrder - Message is about to be added', 1, null, 'Cart', (int)$id_cart, true);
                                    }

                                    $msg->message = $message;
                                    $msg->id_cart = (int)$id_cart;
                                    $msg->id_customer = (int)($order->id_customer);
                                    $msg->id_order = (int)$order->id;
                                    $msg->private = 1;
                                    $msg->add();
                                }
                            }

                            // Insert new Order detail list using cart for the current order
                            // $orderDetail = new OrderDetail(null, null, $this->context);
                            // $orderDetail->createList($order, $this->context->cart, $id_order_state);
                            // Construct order detail table for the email
                            $products_list = '';
                            $virtual_product = true;
                            $product_var_tpl_list = array();
                            $link = new Link();
                            $productsList = '';
                            $supplier_name = '<tr style="background-color:ffffff;">   
                                <td colspan="4" align="left" style="text-align: left;padding-top: 5px;padding-bottom: 5px;"></td>
                            </tr>                                                                                         
                            <tr style="background-color:f2f2f2;">
                                <td colspan="4" align="left" style="text-align: left;padding-top: 10px;padding-bottom: 10px;">
                                    <table>
                                       <tbody>
                                          <tr>
                                            <td align="left" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px; line-height:18px; color: #DC2D3C; text-align:center; padding-left: 0px; padding-right: 30px; padding-top:0px; padding-bottom: 0px;">
                                                    '.$elite_supplier->name.' (#'.$order->id.')
                                            </td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>';

                            foreach($order->product_list as $product) {
                                $product['imageLink'] = $link->getImageLink($product['link_rewrite'], $product['id_image'], 'small');
                                $price = Product::getPriceStatic((int)$product['id_product'], false, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null) , 6, null, false, true, $product['cart_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE') });
                                $price_wt = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null) , 2, null, false, true, $product['cart_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE') });
                                $product_price = Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt;
                                $product_var_tpl = array(
                                    'reference' => $product['reference'],
                                    'name' => $product['name'] . (isset($product['attributes']) ? ' - ' . $product['attributes'] : '') ,
                                    'unit_price' => Tools::displayPrice($product_price, $this->context->currency, false) ,
                                    'price' => Tools::displayPrice($product_price * $product['quantity'], $this->context->currency, false) ,
                                    'quantity' => $product['quantity'],
                                    'customization' => array()
                                );
                                $customized_datas = Product::getAllCustomizedDatas((int)$order->id_cart);
                                if (isset($customized_datas[$product['id_product']][$product['id_product_attribute']])) {
                                    $product_var_tpl['customization'] = array();
                                    foreach($customized_datas[$product['id_product']][$product['id_product_attribute']][$order->id_address_delivery] as $customization) {
                                        $customization_text = '';
                                        if (isset($customization['datas'][Product::CUSTOMIZE_TEXTFIELD])) {
                                            foreach($customization['datas'][Product::CUSTOMIZE_TEXTFIELD] as $text) {
                                                $customization_text.= $text['name'] . ': ' . $text['value'] . '<br />';
                                            }
                                        }

                                        if (isset($customization['datas'][Product::CUSTOMIZE_FILE])) {
                                            $customization_text.= sprintf(Tools::displayError('%d image(s)') , count($customization['datas'][Product::CUSTOMIZE_FILE])) . '<br />';
                                        }

                                        $customization_quantity = (int)$product['customization_quantity'];
                                        $product_var_tpl['customization'][] = array(
                                            'customization_text' => $customization_text,
                                            'customization_quantity' => $customization_quantity,
                                            'quantity' => Tools::displayPrice($customization_quantity * $product_price, $this->context->currency, false)
                                        );
                                    }
                                }

                                $product_var_tpl_list[] = $product_var_tpl;

                                // Check if is not a virutal product for the displaying of shipping

                                if (!$product['is_virtual']) {
                                    $virtual_product&= false;
                                }

                                $productsList .= '<tr style="background-color: ' . ($key % 2 ? '#DDE2E6' : '#FFFFFF') . ';">
                                    <td style="padding: 0.6em 0.4em;">
                                        <img src="' . $product['imageLink'] . '" alt="Image"/>
                                    </td>
                                    <td style="width:240px; padding: 0.6em 0.4em;">
                                        <strong>' . $product['name'] . (isset($product['attributes']) ? ' - ' . $product['attributes'] : '') . '</strong>
                                    </td>
                                    <td style="padding: 0.6em 0.4em; text-align: right;">
                                        ' . Tools::displayPrice($product_price, $this->context->currency, false) . ' x ' . $product['quantity'] . '
                                    </td>
                                    <td style="padding: 0.6em 0.4em; text-align: right;">
                                        ' . Tools::displayPrice($product_price * $product['quantity'], $this->context->currency, false) . '
                                    </td>
                                </tr>';
                            } // end foreach ($products)

                            $products_with_supplier_name .= $supplier_name.$productsList;

                            $cart_rules_list = array();
                            $total_reduction_value_ti = 0;
                            $total_reduction_value_tex = 0;
                            foreach($cart_rules as $cart_rule) {
                                $package = array(
                                    'id_carrier' => $order->id_carrier,
                                    'id_address' => $order->id_address_delivery,
                                    'products' => $order->product_list
                                );
                                $values = array(
                                    'tax_incl' => $cart_rule['obj']->getContextualValue(true, $this->context, CartRule::FILTER_ACTION_ALL_NOCAP, $package) ,
                                    'tax_excl' => $cart_rule['obj']->getContextualValue(false, $this->context, CartRule::FILTER_ACTION_ALL_NOCAP, $package)
                                );

                                // If the reduction is not applicable to this order, then continue with the next one

                                if (!$values['tax_excl']) {
                                    continue;
                                }

                                // IF
                                //  This is not multi-shipping
                                //  The value of the voucher is greater than the total of the order
                                //  Partial use is allowed
                                //  This is an "amount" reduction, not a reduction in % or a gift
                                // THEN
                                //  The voucher is cloned with a new value corresponding to the remainder

                                if (count($order_list) == 1 && $values['tax_incl'] > ($order->total_products_wt - $total_reduction_value_ti) && $cart_rule['obj']->partial_use == 1 && $cart_rule['obj']->reduction_amount > 0) {

                                    // Create a new voucher from the original

                                    $voucher = new CartRule((int)$cart_rule['obj']->id); // We need to instantiate the CartRule without lang parameter to allow saving it
                                    unset($voucher->id);

                                    // Set a new voucher code

                                    $voucher->code = empty($voucher->code) ? substr(md5($order->id . '-' . $order->id_customer . '-' . $cart_rule['obj']->id) , 0, 16) : $voucher->code . '-2';
                                    if (preg_match('/\-([0-9]{1,2})\-([0-9]{1,2})$/', $voucher->code, $matches) && $matches[1] == $matches[2]) {
                                        $voucher->code = preg_replace('/' . $matches[0] . '$/', '-' . (intval($matches[1]) + 1) , $voucher->code);
                                    }

                                    // Set the new voucher value

                                    if ($voucher->reduction_tax) {
                                        $voucher->reduction_amount = ($total_reduction_value_ti + $values['tax_incl']) - $order->total_products_wt;

                                        // Add total shipping amout only if reduction amount > total shipping

                                        if ($voucher->free_shipping == 1 && $voucher->reduction_amount >= $order->total_shipping_tax_incl) {
                                            $voucher->reduction_amount-= $order->total_shipping_tax_incl;
                                        }
                                    }
                                    else {
                                        $voucher->reduction_amount = ($total_reduction_value_tex + $values['tax_excl']) - $order->total_products;

                                        // Add total shipping amout only if reduction amount > total shipping

                                        if ($voucher->free_shipping == 1 && $voucher->reduction_amount >= $order->total_shipping_tax_excl) {
                                            $voucher->reduction_amount-= $order->total_shipping_tax_excl;
                                        }
                                    }

                                    if ($voucher->reduction_amount <= 0) {
                                        continue;
                                    }

                                    if ($this->context->customer->isGuest()) {
                                        $voucher->id_customer = 0;
                                    }
                                    else {
                                        $voucher->id_customer = $order->id_customer;
                                    }

                                    $voucher->quantity = 1;
                                    $voucher->reduction_currency = $order->id_currency;
                                    $voucher->quantity_per_user = 1;
                                    $voucher->free_shipping = 0;
                                    if ($voucher->add()) {

                                        // If the voucher has conditions, they are now copied to the new voucher

                                        CartRule::copyConditions($cart_rule['obj']->id, $voucher->id);
                                        $params = array(
                                            '{voucher_amount}' => Tools::displayPrice($voucher->reduction_amount, $this->context->currency, false) ,
                                            '{voucher_num}' => $voucher->code,
                                            '{firstname}' => $this->context->customer->firstname,
                                            '{lastname}' => $this->context->customer->lastname,
                                            '{id_order}' => $order->reference,
                                            '{order_name}' => $order->getUniqReference()
                                        );
                                        $notifyType = new Notifications(6);
                                        $notificationData = array(
                                            'id_customer' => $this->context->customer->id_customer,
                                            'notification_type' => $notifyType->id,
                                            'url' => $notifyType->url . "/" . $params['{voucher_num}'],
                                            'content' => 'New voucher ' . $params['{voucher_num}'] . ' for your order # ' . $order->reference . ' has been created. Amount: ' . $params['{voucher_amount}'] . '. Check email for more details. - Kobster.com'
                                        );
                                        Notifications::addNotification($notificationData);
                                        Mail::Send((int)$order->id_lang, 'voucher', sprintf(Mail::l('New voucher for your order %s', (int)$order->id_lang) , $order->reference) , $params, $this->context->customer->email, $this->context->customer->firstname . ' ' . $this->context->customer->lastname, null, null, null, null, _PS_MAIL_DIR_, false, (int)$order->id_shop);
                                    }

                                    $values['tax_incl'] = $order->total_products_wt - $total_reduction_value_ti;
                                    $values['tax_excl'] = $order->total_products - $total_reduction_value_tex;
                                }

                                $total_reduction_value_ti+= $values['tax_incl'];
                                $total_reduction_value_tex+= $values['tax_excl'];
                                $order->addCartRule($cart_rule['obj']->id, $cart_rule['obj']->name, $values, 0, $cart_rule['obj']->free_shipping);
                                if ($id_order_state != Configuration::get('PS_OS_ERROR') && $id_order_state != Configuration::get('PS_OS_CANCELED') && !in_array($cart_rule['obj']->id, $cart_rule_used)) {
                                    $cart_rule_used[] = $cart_rule['obj']->id;

                                    // Create a new instance of Cart Rule without id_lang, in order to update its quantity

                                    $cart_rule_to_update = new CartRule((int)$cart_rule['obj']->id);
                                    $cart_rule_to_update->quantity = max(0, $cart_rule_to_update->quantity - 1);
                                    $cart_rule_to_update->update();
                                }

                                $cart_rules_list[] = array(
                                    'voucher_name' => $cart_rule['obj']->name,
                                    'voucher_reduction' => ($values['tax_incl'] != 0.00 ? '-' : '') . Tools::displayPrice($values['tax_incl'], $this->context->currency, false)
                                );
                                $discountsList.= '<tr style="background-color:#EBECEE;">
                                            <td colspan="4" style="padding: 0.6em 0.4em; text-align: right;">' . $this->l('Voucher code:') . ' ' . $cart_rule['obj']->name . '</td>
                                            <td style="padding: 0.6em 0.4em; text-align: right;">' . ($values['tax_incl'] != 0.00 ? '-' : '') . Tools::displayPrice($values['tax_incl'], $this->context->currency, false) . '</td>
                                    </tr>';
                            }

                            // Specify order id for message

                            $old_message = Message::getMessageByCartId((int)$this->context->cart->id);
                            if ($old_message && !$old_message['private']) {
                                $update_message = new Message((int)$old_message['id_message']);
                                $update_message->id_order = (int)$order->id;
                                $update_message->update();

                                // Add this message in the customer thread

                                $customer_thread = new CustomerThread();
                                $customer_thread->id_contact = 0;
                                $customer_thread->id_customer = (int)$order->id_customer;
                                $customer_thread->id_shop = (int)$this->context->shop->id;
                                $customer_thread->id_order = (int)$order->id;
                                $customer_thread->id_lang = (int)$this->context->language->id;
                                $customer_thread->email = $this->context->customer->email;
                                $customer_thread->status = 'open';
                                $customer_thread->token = Tools::passwdGen(12);
                                $customer_thread->add();
                                $customer_message = new CustomerMessage();
                                $customer_message->id_customer_thread = $customer_thread->id;
                                $customer_message->id_employee = 0;
                                $customer_message->message = $update_message->message;
                                $customer_message->private = 0;
                                if (!$customer_message->add()) {
                                    $this->errors[] = Tools::displayError('An error occurred while saving message');
                                }
                            }

                            if (self::DEBUG_MODE) {
                                PrestaShopLogger::addLog('PaymentModule::validateOrder - Hook validateOrder is about to be called', 1, null, 'Cart', (int)$id_cart, true);
                            }

                            // Hook validate order

                            Hook::exec('actionValidateOrder', array(
                                'cart' => $this->context->cart,
                                'order' => $order,
                                'customer' => $this->context->customer,
                                'currency' => $this->context->currency,
                                'orderStatus' => $order_status
                            ));

                            foreach($this->context->cart->getProducts() as $product) {
                                if ($order_status->logable) {
                                    ProductSale::addProductSale((int)$product['id_product'], (int)$product['cart_quantity']);
                                }
                            }

                            if (self::DEBUG_MODE) {
                                PrestaShopLogger::addLog('PaymentModule::validateOrder - Order Status is about to be added', 1, null, 'Cart', (int)$id_cart, true);
                            }

                            // Set the order status

                            $new_history = new OrderHistory();
                            $new_history->id_order = (int)$order->id;
                            $new_history->changeIdOrderState((int)$id_order_state, $order, true);
                            $new_history->addWithemail(true, $extra_vars);

                            unset($order_detail);

                            // Order is reloaded because the status just changed
                            $order = new Order((int)$order->id);
                            $customer = new Customer($order->id_customer);

                            // Send an e-mail to customer (one order = one email)
                            if ($id_order_state != Configuration::get('PS_OS_ERROR') && $id_order_state != Configuration::get('PS_OS_CANCELED') && $this->context->customer->id) {
                                $invoice = new Address((int)$order->id_address_invoice);
                                $delivery = new Address((int)$order->id_address_delivery);
                                $delivery_state = $delivery->id_state ? new State((int)$delivery->id_state) : false;
                                $invoice_state = $invoice->id_state ? new State((int)$invoice->id_state) : false;
                                /******************************************************************************/

                                // set approver and child names for Mail purpose .
                                if ($this->context->cookie->creator_customer_id != 0) {
                                    $child = new Customer((int)$this->context->cookie->creator_customer_id);
                                    $child_name = $child->firstname;
                                    $approver_data_name = $customer->firstname;
                                    $creator_old_order_id = $this->context->cookie->creator_old_order_id;
                                }
                                else {
                                    $approver_name = new Customer($customer->getApprover());
                                    $approver_data_name = $approver_name->firstname;
                                    $creator_old_order_id = 0;
                                }

                                $payment_informations = '';
                                if (isset($extra_vars['cheque_name'])) {
                                    $payment_informations = "Cheque Name: <span style='color:#333333;font-weight:bold;'>" . $extra_vars['cheque_name'] . "</span><br />Cheque Address: <span style='color:#333333;font-weight:bold;''>" . $extra_vars['address'] . "</span><br />";
                                }
                                elseif (isset($extra_vars['bankwire_owner'])) {
                                    $payment_informations = "Bank Name: <span style='color:#333333;font-weight:bold;'>" . $extra_vars['bankwire_owner'] . "</span><br />Cheque Address: <span style='color:#333333;font-weight:bold;''>" . $extra_vars['bankwire_details'] . "</span><br /><br />Cheque Address: <span style='color:#333333;font-weight:bold;''>" . $extra_vars['bankwire_address'] . "</span><br />";
                                }

                                $checkAccount = $this->context->customer->checkCustomercredibility($order->id);

                                // Temp code APS check disabled
                                $checkAccount = false;

                                $data = array(
                                    '{firstname}' => $this->context->customer->firstname,
                                    '{lastname}' => $this->context->customer->lastname,
                                    '{email}' => $this->context->customer->email,
                                    '{delivery_block_txt}' => $this->_getFormatedAddress($delivery, "\n") ,
                                    '{invoice_block_txt}' => $this->_getFormatedAddress($invoice, "\n") ,
                                    '{delivery_block_html}' => $this->_getFormatedAddress($delivery, '<br />', array(
                                        'firstname' => '<span style="font-weight:bold;">%s</span>',
                                        'lastname' => '<span style="font-weight:bold;">%s</span>'
                                    )) ,
                                    '{invoice_block_html}' => $this->_getFormatedAddress($invoice, '<br />', array(
                                        'firstname' => '<span style="font-weight:bold;">%s</span>',
                                        'lastname' => '<span style="font-weight:bold;">%s</span>'
                                    )) ,
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
                                    '{order_name}' => sprintf("#%06d", (int)($order->id)) ,
                                    '{date}' => Tools::displayDate(date('Y-m-d H:i:s') , null, 1) ,
                                    '{carrier}' => ($virtual_product || !isset($carrier->name)) ? Tools::displayError('No carrier') : $carrier->name,
                                    '{payment}' => Tools::substr($order->payment, 0, 32) ,
                                    '{products}' => $productsList,
                                    '{total_paid}' => Tools::displayPrice($order->total_paid, $this->context->currency, false) ,
                                    '{total_products}' => Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $order->total_products : $order->total_products_wt, $this->context->currency, false) ,
                                    '{total_discounts}' => Tools::displayPrice($order->total_discounts, $this->context->currency, false) ,
                                    '{total_shipping}' => Tools::displayPrice($order->total_shipping, $this->context->currency, false) ,
                                    '{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $this->context->currency, false) ,
                                    '{total_tax_paid}' => Tools::displayPrice(($order->total_products_wt - $order->total_products) + ($order->total_shipping_tax_incl - $order->total_shipping_tax_excl) , $this->context->currency, false) ,
                                    '{approver_name}' => $approver_data_name,
                                    '{child_name}' => $child_name,
                                    '{payment_informations}' => $payment_informations,
                                    '{old_order_id}' => $creator_old_order_id,
                                    '{block_account}' => $checkAccount ? 'We have received your order, however it can not be processed at this moment, as your company has outstanding payment dues with Kobster. We request you to clear these dues to resume services. Please get in touch with your relationship manager for more details' : '',
                                    '{hide}' => $checkAccount ? 'display: none;' : '',
                                    '{tax_type}' => Product::getTaxCalculationMethod() == PS_TAX_EXC ? 'Tax Excl.' : 'Tax Incl.',
                                    '{supplier}' => $elite_supplier->name
                                );
                                if (is_array($extra_vars)) {
                                    $data = array_merge($data, $extra_vars);
                                }

                                // Join PDF invoice
                                if ((int)Configuration::get('PS_INVOICE') && $order_status->invoice && $order->invoice_number) {
                                    $order_invoice_list = $order->getInvoicesCollection();
                                    Hook::exec('actionPDFInvoiceRender', array(
                                        'order_invoice_list' => $order_invoice_list
                                    ));
                                    $pdf = new PDF($order_invoice_list, PDF::TEMPLATE_INVOICE, $this->context->smarty);
                                    $file_attachement['content'] = $pdf->render(false);
                                    $file_attachement['name'] = Configuration::get('PS_INVOICE_PREFIX', (int)$order->id_lang, null, $order->id_shop) . sprintf('%06d', $order->invoice_number) . '.pdf';
                                    $file_attachement['mime'] = 'application/pdf';
                                }
                                else {
                                    $file_attachement = null;
                                }

                                if (self::DEBUG_MODE) {
                                    PrestaShopLogger::addLog('PaymentModule::validateOrder - Mail is about to be sent', 1, null, 'Cart', (int)$id_cart, true);
                                }

                                /*************Default prestashop 1.6 coding**********************/
                                $status_order = New Order($order->id);
                                if (!(int)$status_order->getCurrentState()) {
                                    Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('INSERT INTO ' . _DB_PREFIX_ . 'order_history (`id_employee`,`id_order`,`id_order_state`,`date_add`) VALUES ("0",' . $order->id . ',' . $id_order_state . ',NOW())');
                                }

                                //Trigger email to sellers
                                if($this->context->cookie->payment_type != 5) {
                                    $elite_supplier->triggerOrderConfEmail($data, $order, (int)$this->context->cart->id_lang, (int)$this->context->shop->id);
                                }

                                // Add entry to order supplier table. This is used for data populating in orders list elite
                                Order::addSupplier((int)$order->id, (int)$elite_supplier->id);

                            }

                            // updates stock in shops

                            if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
                                $product_list = $order->getProducts();
                                foreach($product_list as $product) {
                                    // if the available quantities depends on the physical stock
                                    if (StockAvailable::dependsOnStock($product['product_id'])) {
                                        // synchronizes
                                        StockAvailable::synchronize($product['product_id'], $order->id_shop);
                                    }
                                }
                            }

                            $order->updateOrderDetailTax();
                        }
                        else {
                            $error = Tools::displayError('Order creation failed');
                            PrestaShopLogger::addLog($error, 4, '0000002', 'Cart', intval($order->id_cart));
                            die($error);
                        }
                    } // End foreach $order_detail_list

                    // Use the last order as currentOrder

                    if (isset($order) && $order->id) {
                        $this->currentOrder = (int)$order->id;
                    }

                    if (self::DEBUG_MODE) {
                        PrestaShopLogger::addLog('PaymentModule::validateOrder - End of validateOrder', 1, null, 'Cart', (int)$id_cart, true);
                    }

                    // Configure budget values
                    if($this->context->cookie->budget_configured == 1) {
                        /** Update PO Number **/
                        if(isset($this->context->cookie->id_purchase_order) && $this->context->cookie->id_purchase_order) {
                            $purchaseOrderObj = new PurchaseOrder(intval($this->context->cookie->id_purchase_order));
                        }
                        else {
                            $purchaseOrderObj = new PurchaseOrder();
                        }
                        
                        $customerObj = new Customer(intval($this->context->cookie->id_customer));
                        $po_option = $purchaseOrderObj->getPoOption(intval($customerObj->id_default_group));

                        if($po_option == 1) /*** Purchase orders product based - Quantities updation***/
                        {
                            $poProducts = $purchaseOrderObj->getPurchaseOrderProducts($this->context->cookie->id_address_budget, $this->context->cookie->budget_option);
                            $po_numbers_used = array();
                            foreach ($order->product_list as $key => $product) 
                            {
                                $quantity_ordered = $product['product_quantity'];

                                foreach ($poProducts as $key => $poProduct) 
                                {
                                    if($product['id_product'] == $poProduct['id_product']) 
                                    {
                                        if($poProduct['available_quantity'] > 0) 
                                        {
                                            if($poProduct['available_quantity'] <= $quantity_ordered) {
                                                $quantity_to_insert = $poProduct['available_quantity'];
                                            } 
                                            else if($poProduct['available_quantity'] > $quantity_ordered) {
                                                $quantity_to_insert = $quantity_ordered;
                                            }

                                            $insert_data = array('id_purchase_order' => $poProduct['id_purchase_order'], 'id_order' => $this->currentOrder,
                                                    'id_product' => $product['id_product'],
                                                    'quantity' => $quantity_to_insert);

                                            $insert_quantity_to_history = Db::getInstance()->insert('po_products_history', $insert_data);

                                            $quantity_ordered = $quantity_ordered - $quantity_to_insert;

                                            $po_numbers_used[] = $poProduct['id_purchase_order'];
                                            
                                            if($quantity_ordered == 0)
                                                break;
                                        }
                                    }
                                }
                            }

                            $po_numbers_used_unique = array_unique($po_numbers_used);
                            $po_numbers_used_order = array();
                            foreach ($po_numbers_used_unique as $key => $po) {
                                $purchaseOrder = new PurchaseOrder(intval($po));
                                array_push($po_numbers_used_order, $purchaseOrder->po_number);
                            }

                            if(sizeof($po_numbers_used_order) > 0) {
                                $orderObject->po_number = implode(',', $po_numbers_used_order);
                            }
                        }
                        else if($po_option == 2) /*** Purchase orders value based - values updation***/
                        {
                            $orderObject->po_number = $this->context->cookie->po_number;
                            $poValues = $purchaseOrderObj->getPurchaseOrderValues($this->context->cookie->id_address_budget, $this->context->cookie->budget_option, true);

                            $value_ordered = $order->total_paid_tax_incl;

                            foreach ($poValues as $key => $poValue) 
                            {
                                if($poValue['available_value'] > 0) 
                                {
                                    if($poValue['available_value'] <= $value_ordered) 
                                        $value_to_insert = $poValue['available_value'];
                                    else if($poValue['available_value'] > $value_ordered) 
                                        $value_to_insert = $value_ordered;

                                    $value_ordered = $value_ordered - $value_to_insert;

                                    $insert_data = array('id_purchase_order' => $poValue['id_purchase_order'], 'id_order' => $this->currentOrder, 'value' => $value_to_insert);

                                    $insert_value_to_history = Db::getInstance()->insert('po_values_history', $insert_data);
                                    
                                    if($value_ordered == 0)
                                        break;
                                }
                            }
                        }
                    }

                    if($this->context->cookie->payment_type != $this::PENDING_FOR_APPROVAL) {
                        /* Entry in supplier orders */
                        Order::addSupplier((int)$this->currentOrder, (int)$elite_supplier->id);

                        /** Estimated delivery time update **/
                        date_default_timezone_set('Asia/Kolkata');
                        // $orderPlacedTime = new DateTime();
                        // $cutOffTime = new DateTime();
                        // $cutOffTime->setTime(12, 0, 0);
                        
                        // $estimated_delivery_time = new DateTime();
                        // $estimated_delivery_time = $orderPlacedTime;
                        
                        // if($orderPlacedTime < $cutOffTime){
                            // $estimated_delivery_time->modify('+1 day');
                        // }
                        // else{
                            // $estimated_delivery_time->modify('+2 day');
                        // }
                        
                        // $estimated_delivery_time->setTime(22, 0, 0);
                        // $order->estimated_delivery_time = $estimated_delivery_time->format('Y-m-d H:i:s');
                        $order->estimated_delivery_time = '0000-00-00 00:00';
                        if($split_order == true){
                            $d = new DateTime(Tools::getValue('edt'));
                            $order->estimated_delivery_time = $d->format('Y-m-d H:i:s');
                        }
                        $order->update();
                    }

                    $placed_orders[] = $this->currentOrder;
                }

                /*** Send email to customer as consolidated orders with suppliers ***/
                $data['{products}'] = $products_with_supplier_name;
                $this->context->customer->triggerOrderConfEmail($id_order_state, $placed_orders, $data, $split_order, (int)$this->context->cart->id_lang, (int)$this->context->shop->id, $invoice, $ordered_products, $id_carrier);

                return $placed_orders;
            }
            else {
                Tools::displayError('Please add some products in cart to continue.');
            }
        }
        else {
            $error = Tools::displayError('Cart cannot be loaded or an order has already been placed using this cart');
            PrestaShopLogger::addLog($error, 4, '0000001', 'Cart', intval($this->context->cart->id));
            die($error);
        }
    }
}

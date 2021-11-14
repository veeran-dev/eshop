<?php
/**
 * 2007-2015 PrestaShop
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
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2015 PrestaShop SA
 *  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

/**
 * @since 1.5
 */
class HTMLTemplateInvoiceCore extends HTMLTemplate
{
    public $order;
    public $order_invoice;
    public $available_in_your_account = false;
    public $prefix;
    /**
     * @param OrderInvoice $order_invoice
     * @param $smarty
     * @throws PrestaShopException
     */
    public function __construct(OrderInvoice $order_invoice, $smarty, $bulk_mode = false)
    {
        $this->order_invoice = $order_invoice;
        $this->order = new Order((int)$this->order_invoice->id_order);
        $this->smarty = $smarty;
        $context=Context::getContext();
        $this->_iso = strtoupper(Language::getIsoById($context->cookie->id_lang));
        // If shop_address is null, then update it with current one.
        // But no DB save required here to avoid massive updates for bulk PDF generation case.
        // (DB: bug fixed in 1.6.1.1 with upgrade SQL script to avoid null shop_address in old orderInvoices)
        if (!isset($this->order_invoice->shop_address) || !$this->order_invoice->shop_address) {
            $this->order_invoice->shop_address = OrderInvoice::getCurrentFormattedShopAddress((int)$this->order->id_shop);
            if (!$bulk_mode) {
                OrderInvoice::fixAllShopAddresses();
            }
        }

        // header informations
        $this->prefix ="";
        $this->date = Tools::displayDate($order_invoice->date_add);
        $today_i = Configuration::get('PS_INVOICE_PREFIX_DATE');
        $date_i = date($this->order->invoice_date);
        if(strtotime($today_i) < strtotime($date_i)){
            $this->prefix =FulfillmentCentre::getInvoicePrefix($this->order->id_fc)[0]['prefix'].sprintf('%06d',$this->order_invoice->number);
        }
        else{
            $this->prefix = "";
        }

        $id_lang = Context::getContext()->language->id;
        $this->title = $order_invoice->getInvoiceNumberFormatted($id_lang);
        $this->gst_passed = true;
        $order_date = strtotime(Date($this->order->date_add));
        $vat_expiry = strtotime(Date('2017-07-01 00:00:00'));
        if($order_date <= $vat_expiry){
            $this->gst_passed = false;
        }
        
        $this->shop = new Shop((int)$this->order->id_shop);
    }

    /**
     * Returns the template's HTML header
     *
     * @return string HTML header
     */
    public function getHeader()
    {
        $this->assignCommonHeaderData();
        $this->smarty->assign(array('header' => HTMLTemplateInvoice::l('INVOICE')));

        return $this->smarty->fetch($this->getTemplate('header'));
    }

    /**
     * Compute layout elements size
     *
     * @param $params Array Layout elements
     *
     * @return Array Layout elements columns size
     */
    protected function computeLayout($params)
    {
        $layout = array(
            'reference' => array(
                'width' => 13,
            ),
            'product' => array(
                'width' => 40,
            ),
            'quantity' => array(
                'width' => 7,
            ),
            'sno' => array(
                'width' => 6,
            ),
            'tax_code' => array(
                'width' => 7,
            ),
            'unit_price_tax_excl' => array(
                'width' => 0,
            ),
            'total_tax_excl' => array(
                'width' => 0,
            )

        );

        /*if (isset($params['has_discount']) && $params['has_discount']) {
            $layout['before_discount'] = array('width' => 0);
            $layout['product']['width'] -= 7;
            $layout['reference']['width'] -= 3;
        }*/

        $total_width = 0;
        $free_columns_count = 0;
        foreach ($layout as $data) {
            if ($data['width'] === 0) {
                ++$free_columns_count;
            }

            $total_width += $data['width'];
        }

        $delta = 100 - $total_width;

        foreach ($layout as $row => $data) {
            if ($data['width'] === 0) {
                $layout[$row]['width'] = $delta / $free_columns_count;
            }
        }

        $layout['_colCount'] = count($layout);

        return $layout;
    }

    /**
     * Returns the template's HTML content
     *
     * @return string HTML content
     */
    public function getContent()
    {
        $invoiceAddressPatternRules = Tools::jsonDecode(Configuration::get('PS_INVCE_INVOICE_ADDR_RULES'), true);
        $deliveryAddressPatternRules = Tools::jsonDecode(Configuration::get('PS_INVCE_DELIVERY_ADDR_RULES'), true);

        $invoice_address = new Address((int)$this->order->id_address_invoice);
        $country = new Country((int)$invoice_address->id_country);

        if ($this->order_invoice->invoice_address) {
            $formatted_invoice_address = $this->order_invoice->invoice_address;
        } else {
            $formatted_invoice_address = AddressFormat::generateAddress($invoice_address, $invoiceAddressPatternRules, '<br />', ' ');
        }

        $delivery_address = null;
        $formatted_delivery_address = '';
        if (isset($this->order->id_address_delivery) && $this->order->id_address_delivery) {
            if ($this->order_invoice->delivery_address) {
                $formatted_delivery_address = $this->order_invoice->delivery_address;
            } else {
                $delivery_address = new Address((int)$this->order->id_address_delivery);
                $formatted_delivery_address = AddressFormat::generateAddress($delivery_address, $deliveryAddressPatternRules, '<br />', ' ');
            }
        }

        $customer = new Customer((int)$this->order->id_customer);

        $order_details = $this->order_invoice->getProducts();

        $has_discount = false;
        $i=0;
        foreach ($order_details as $id => &$order_detail) {
            //S.no added//
            $i++;
            $order_detail['i']=$i;
            // Find out if column 'price before discount' is required
            if ($order_detail['reduction_amount_tax_excl'] > 0) {
                $has_discount = true;
                $order_detail['unit_price_tax_excl_before_specific_price'] = $order_detail['unit_price_tax_excl_including_ecotax'] + $order_detail['reduction_amount_tax_excl'];
            } elseif ($order_detail['reduction_percent'] > 0) {
                $has_discount = true;
                $order_detail['unit_price_tax_excl_before_specific_price'] = (100 * $order_detail['unit_price_tax_excl_including_ecotax']) / (100 - $order_detail['reduction_percent']);
            }

            // Set tax_code
            $taxes = OrderDetail::getTaxListStatic($id);
            $tax_temp = array();
            foreach ($taxes as $tax) {
                $obj = new Tax($tax['id_tax']);
                $tax_temp[] = sprintf($this->l('%1$s%2$s%%'), ($obj->rate + 0), '&nbsp;');
            }

            $order_detail['order_detail_tax'] = $taxes;
            $order_detail['order_detail_tax_label'] = implode(', ', $tax_temp);
        }
        unset($tax_temp);
        unset($order_detail);

        if (Configuration::get('PS_PDF_IMG_INVOICE')) {
            foreach ($order_details as &$order_detail) {
                if ($order_detail['image'] != null) {
                    $name = 'product_mini_'.(int)$order_detail['product_id'].(isset($order_detail['product_attribute_id']) ? '_'.(int)$order_detail['product_attribute_id'] : '').'.jpg';
                    $path = _PS_PROD_IMG_DIR_.$order_detail['image']->getExistingImgPath().'.jpg';

                    $order_detail['image_tag'] = preg_replace(
                        '/\.*'.preg_quote(__PS_BASE_URI__, '/').'/',
                        _PS_ROOT_DIR_.DIRECTORY_SEPARATOR,
                        ImageManager::thumbnail($path, $name, 45, 'jpg', false),
                        1
                    );

                    if (file_exists(_PS_TMP_IMG_DIR_.$name)) {
                        $order_detail['image_size'] = getimagesize(_PS_TMP_IMG_DIR_.$name);
                    } else {
                        $order_detail['image_size'] = false;
                    }
                }
            }
            unset($order_detail); // don't overwrite the last order_detail later
        }

        $cart_rules = $this->order->getCartRules($this->order_invoice->id);
        $free_shipping = false;
        foreach ($cart_rules as $key => $cart_rule) {
            if ($cart_rule['free_shipping']) {
                $free_shipping = true;
                /**
                 * Adjust cart rule value to remove the amount of the shipping.
                 * We're not interested in displaying the shipping discount as it is already shown as "Free Shipping".
                 */
                $cart_rules[$key]['value_tax_excl'] -= $this->order_invoice->total_shipping_tax_excl;
                $cart_rules[$key]['value'] -= $this->order_invoice->total_shipping_tax_incl;

                /**
                 * Don't display cart rules that are only about free shipping and don't create
                 * a discount on products.
                 */
                if ($cart_rules[$key]['value'] == 0) {
                    unset($cart_rules[$key]);
                }
            }
        }

        $product_taxes = 0;
        foreach ($this->order_invoice->getProductTaxesBreakdown($this->order) as $details) {
            $product_taxes += $details['total_amount'];
        }

        $product_discounts_tax_excl = $this->order_invoice->total_discount_tax_excl;
        $product_discounts_tax_incl = $this->order_invoice->total_discount_tax_incl;
        if ($free_shipping) {
            $product_discounts_tax_excl -= $this->order_invoice->total_shipping_tax_excl;
            $product_discounts_tax_incl -= $this->order_invoice->total_shipping_tax_incl;
        }

        $products_after_discounts_tax_excl = $this->order_invoice->total_products - $product_discounts_tax_excl;
        $products_after_discounts_tax_incl = $this->order_invoice->total_products_wt - $product_discounts_tax_incl;

        $shipping_tax_excl = $free_shipping ? 0 : $this->order_invoice->total_shipping_tax_excl;
        $shipping_tax_incl = $free_shipping ? 0 : $this->order_invoice->total_shipping_tax_incl;
        $shipping_taxes = $shipping_tax_incl - $shipping_tax_excl;

        $wrapping_taxes = $this->order_invoice->total_wrapping_tax_incl - $this->order_invoice->total_wrapping_tax_excl;

        $total_taxes = $this->order_invoice->total_paid_tax_incl - $this->order_invoice->total_paid_tax_excl;
        /** gst **/
        $igst = 0 ;
        $cgst = 0;
        $sgst = 0;
        $isez = 0;
        $d_address = new Address((int)$this->order->id_address_delivery);
        $fc = new FulfillmentCentre((int)$this->order->id_fc);
        $address_gst = $d_address->vat_number;

        if($fc->id_state == $d_address->id_state && $d_address->isez == 0){
            $cPercent = Configuration::get('CGST');
            $sPercent = Configuration::get('SGST');
            $cgst = $total_taxes * ($cPercent/100);
            $sgst = $total_taxes * ($sPercent/100);
        }
        else
        {
            $igst = $total_taxes;
        }
        $order_date = strtotime(Date($this->order->invoice_date));
        $order_date = date('Y-m-d', $order_date);
        $result = $fc->getLutDetails($order_date);
        $lut_n = $result[0]['lut_number'];
        $lut_exp = $result[0]['expiry'];
        
        if($d_address->isez == 1 && $lut_n == ''){
            $isez = 1;
        }
        $order_date = strtotime(Date($this->order->date_add));
        $target1 = strtotime(Date('2017-07-01 00:00:00'));
        $gst = 0;
        
        if($order_date <= $target1){
            $gst = 0;
        }
        else{
            $gst = 1;
        }

        /**sez zone **/
        $sez = 0;
        $sez_date = strtotime(Date('2017-07-15 00:00:00'));
        if($lut_n != '' && $order_date >= $sez_date && $d_address->isez == 1)
        {
            $sez = 1;
        }
        $total_in_words = $this->getIndianCurrency($this->order_invoice->total_paid_tax_incl);
        
        $footer = array(
            'products_before_discounts_tax_excl' => $this->order_invoice->total_products,
            'product_discounts_tax_excl' => $product_discounts_tax_excl,
            'products_after_discounts_tax_excl' => $products_after_discounts_tax_excl,
            'products_before_discounts_tax_incl' => $this->order_invoice->total_products_wt,
            'product_discounts_tax_incl' => $product_discounts_tax_incl,
            'products_after_discounts_tax_incl' => $products_after_discounts_tax_incl,
            'product_taxes' => $product_taxes,
            'shipping_tax_excl' => $shipping_tax_excl,
            'shipping_taxes' => $shipping_taxes,
            'shipping_tax_incl' => $shipping_tax_incl,
            'wrapping_tax_excl' => $this->order_invoice->total_wrapping_tax_excl,
            'wrapping_taxes' => $wrapping_taxes,
            'wrapping_tax_incl' => $this->order_invoice->total_wrapping_tax_incl,
            'ecotax_taxes' => $total_taxes - $product_taxes - $wrapping_taxes - $shipping_taxes,
            'total_taxes' => $total_taxes,
            'total_paid_tax_excl' => $this->order_invoice->total_paid_tax_excl,
            'total_paid_tax_incl' => $this->order_invoice->total_paid_tax_incl,
            'total_in_words' => ucfirst($total_in_words),
            'igst'  => $igst,
            'cgst'  => $cgst,
            'sgst'  => $sgst,
            'gst'  => $gst,
            'address_gst' =>$address_gst,
            'sez' => $sez,
            'isez' => $isez,
            'gst_passed' => $this->gst_passed
        );

        foreach ($footer as $key => $value) {
            if($key != 'address_gst'|| $key != 'total_in_words'){
            }
            else{
                $footer[$key] = Tools::ps_round($value, _PS_PRICE_COMPUTE_PRECISION_, $this->order->round_mode);
            }
        }

        /**
         * Need the $round_mode for the tests.
         */
        $round_type = null;
        switch ($this->order->round_type) {
        case Order::ROUND_TOTAL:
                $round_type = 'total';
            break;
        case Order::ROUND_LINE:
                $round_type = 'line';
            break;
        case Order::ROUND_ITEM:
                $round_type = 'item';
            break;
        default:
                $round_type = 'line';
            break;
        }

        $display_product_images = Configuration::get('PS_PDF_IMG_INVOICE');
        $tax_excluded_display = Group::getPriceDisplayMethod($customer->id_default_group);

        $layout = $this->computeLayout(array('has_discount' => $has_discount));

        $legal_free_text = Hook::exec('displayInvoiceLegalFreeText', array('order' => $this->order));
        if (!$legal_free_text) {
            $legal_free_text = Configuration::get('PS_INVOICE_LEGAL_FREE_TEXT', (int)Context::getContext()->language->id, null, (int)$this->order->id_shop);
        }


        /*** ORDER INFORMATIONS ***/
        $context=Context::getContext();
        $order_id=sprintf('%06d', $this->order->id);

        $shipping_date=0;
        $history = $this->order->getHistory($this->order->id_lang);
        foreach($history as $h){
            if ($h['id_order_state'] == Configuration::get('PS_OS_SHIPPING')){
                $shipping_date = $h['date_add'];
            }
        }

        $dr_number=$this->order->getDrNumber();
        $dr_num='';
        foreach($dr_number as $dr)
            $dr_num .=$dr['dr_prefix'].sprintf('%06d', $dr['delivery_number']).", ";
        
        $fc = new FulfillmentCentre($this->order->id_fc);
        $fc_address = new Address($fc->id_address);        
        $inv_address = new Address($this->order->id_address_invoice);
        $state_fc = new State($fc->id_state);
        $state_of_bill = new State($inv_address->id_state);
        $state_of_supply = new State($d_address->id_state);

        $fc_address =  AddressFormat::generateAddress($fc_address, $invoiceAddressPatternRules, '<br />', ' ');
        if($this->gst_passed){
            $fc_address = $fc_address. "<br/> GST STATE: ".$state_fc->code." / ". $state_fc->name." <br/> GSTIN: ".$fc->gst."";
        }
        else{
            $fc_address = $fc_address. "<br/> CST: ".$fc->cst." <br/> TIN: ".$fc->tin."";
        }
        
        if($this->gst_passed)
        {
            $formatted_delivery_address = $formatted_delivery_address."<br/> GST STATE: ".$state_of_supply->code." / ".$state_of_supply->name."<br/> GSTIN: ".$d_address->vat_number;
            $formatted_invoice_address = $formatted_invoice_address."<br/> GST STATE: ".$state_of_bill->code." / ".$state_of_bill->name."<br/> GSTIN: ".$inv_address->vat_number;
        }

        $tin=$fc->tin;
        $cst=$fc->cst;
        $gst=$fc->gst;
        $lut_number = "NA";
        $lut_expiry = "--";
        $order_date = strtotime(Date($this->order->invoice_date));
        $lut_date = strtotime(Date($fc->lut_date));
        if($fc->lut && ($order_date >= $lut_date) && $sez == 1)
        {
            $order_date = date('Y-m-d', $order_date);
            $result = $fc->getLutDetails($order_date);
            $lut_number = $result[0]['lut_number'];
            $lut_expiry = $result[0]['expiry'];
        }
        $dr=rtrim($dr_num, ", ")."\n";

        $today_j = Configuration::get('PS_INVOICE_PREFIX_DATE');
        $date_j = date($this->order->invoice_date);
        $title_new = "";
        if(strtotime($today_j) < strtotime($date_j)){
            $title_new =FulfillmentCentre::getInvoicePrefix($this->order->id_fc)[0]['prefix'].sprintf('%06d',$this->order_invoice->number);
        }
        else{
            $title_new = $this->title;
        }
        $data = array(
            'order_id' => $order_id,
            'shipping_date'=>$shipping_date,
            'tin'=> $tin,
            'cst'=>$cst,
            'gst'=>$gst,
            'dr'=>$dr,
            'order' => $this->order,
            'prefix' => $title_new,
            'order_invoice' => $this->order_invoice,
            'order_details' => $order_details,
            'cart_rules' => $cart_rules,
            'delivery_address' => $formatted_delivery_address,
            'invoice_address' => $formatted_invoice_address,
            'fc_address' => $fc_address,
            'addresses' => array('invoice' => $invoice_address, 'delivery' => $delivery_address),
            'tax_excluded_display' => $tax_excluded_display,
            'display_product_images' => $display_product_images,
            'layout' => $layout,
            'tax_tab' => $this->getTaxTabContent(),
            'customer' => $customer,
            'footer' => $footer,
            'ps_price_compute_precision' => _PS_PRICE_COMPUTE_PRECISION_,
            'round_type' => $round_type,
            'legal_free_text' => $legal_free_text,
            'textFooter'=>$textFooter,
            'lut_number' => $lut_number,
            'lut_expiry' => $lut_expiry,
            'state_of_supply'=>$state_of_supply->name,
        );

        if (Tools::getValue('debug')) {
            die(json_encode($data));
        }

        $this->smarty->assign($data);

        $tpls = array(
            'style_tab' => $this->smarty->fetch($this->getTemplate('invoice.style-tab')),
            'addresses_tab' => $this->smarty->fetch($this->getTemplate('invoice.addresses-tab')),
            'summary_tab' => $this->smarty->fetch($this->getTemplate('invoice.summary-tab')),
            'product_tab' => $this->smarty->fetch($this->getTemplate('invoice.product-tab')),
            'tax_tab' => $this->getTaxTabContent(),
            'payment_tab' => $this->smarty->fetch($this->getTemplate('invoice.payment-tab')),
            'total_tab' => $this->smarty->fetch($this->getTemplate('invoice.total-tab')),
        );
        $this->smarty->assign($tpls);

        return $this->smarty->fetch($this->getTemplateByCountry($country->iso_code));
    }

    /**
     * Returns the tax tab content
     *
     * @return String Tax tab html content
     */
    public function getTaxTabContent()
    {
        $debug = Tools::getValue('debug');

        $address = new Address((int)$this->order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
        $tax_exempt = Configuration::get('VATNUMBER_MANAGEMENT')
                            && !empty($address->vat_number)
                            && $address->id_country != Configuration::get('VATNUMBER_COUNTRY');
        $carrier = new Carrier($this->order->id_carrier);

        $tax_breakdowns = $this->getTaxBreakdown();

        $data = array(
            'tax_exempt' => $tax_exempt,
            'use_one_after_another_method' => $this->order_invoice->useOneAfterAnotherTaxComputationMethod(),
            'display_tax_bases_in_breakdowns' => $this->order_invoice->displayTaxBasesInProductTaxesBreakdown(),
            'product_tax_breakdown' => $this->order_invoice->getProductTaxesBreakdown($this->order),
            'shipping_tax_breakdown' => $this->order_invoice->getShippingTaxesBreakdown($this->order),
            'ecotax_tax_breakdown' => $this->order_invoice->getEcoTaxTaxesBreakdown(),
            'wrapping_tax_breakdown' => $this->order_invoice->getWrappingTaxesBreakdown(),
            'tax_breakdowns' => $tax_breakdowns,
            'order' => $debug ? null : $this->order,
            'order_invoice' => $debug ? null : $this->order_invoice,
            'carrier' => $debug ? null : $carrier
        );

        if ($debug) {
            return $data;
        }

        $this->smarty->assign($data);
        return $this->smarty->fetch($this->getTemplate('invoice.tax-tab'));
    }

    /**
     * Returns different tax breakdown elements
     *
     * @return Array Different tax breakdown elements
     */
    protected function getTaxBreakdown()
    {
        $breakdowns = array(
            'product_tax' => $this->order_invoice->getProductTaxesBreakdown($this->order),
            'shipping_tax' => $this->order_invoice->getShippingTaxesBreakdown($this->order),
            'ecotax_tax' => $this->order_invoice->getEcoTaxTaxesBreakdown(),
            'wrapping_tax' => $this->order_invoice->getWrappingTaxesBreakdown(),
        );

        foreach ($breakdowns as $type => $bd) {
            if (empty($bd)) {
                unset($breakdowns[$type]);
            }
        }

        if (empty($breakdowns)) {
            $breakdowns = false;
        }

        if (isset($breakdowns['product_tax'])) {
            foreach ($breakdowns['product_tax'] as &$bd) {
                $bd['total_tax_excl'] = $bd['total_price_tax_excl'];
            }
        }

        if (isset($breakdowns['ecotax_tax'])) {
            foreach ($breakdowns['ecotax_tax'] as &$bd) {
                $bd['total_tax_excl'] = $bd['ecotax_tax_excl'];
                $bd['total_amount'] = $bd['ecotax_tax_incl'] - $bd['ecotax_tax_excl'];
            }
        }
        return $breakdowns;
    }

    /*
    protected function getTaxLabel($tax_breakdowns)
    {
        $tax_label = '';
        $all_taxes = array();

        foreach ($tax_breakdowns as $type => $bd)
            foreach ($bd as $line)
                if(isset($line['id_tax']))
                    $all_taxes[] = $line['id_tax'];

        $taxes = array_unique($all_taxes);

        foreach ($taxes as $id_tax) {
            $tax = new Tax($id_tax);
            $tax_label .= $tax->id.': '.$tax->name[$this->order->id_lang].' ('.$tax->rate.'%) ';
        }

        return $tax_label;
    }
    */

    /**
     * Returns the invoice template associated to the country iso_code
     *
     * @param string $iso_country
     */
    protected function getTemplateByCountry($iso_country)
    {
        $file = Configuration::get('PS_INVOICE_MODEL');

        // try to fetch the iso template
        $template = $this->getTemplate($file.'.'.$iso_country);

        // else use the default one
        if (!$template) {
            $template = $this->getTemplate($file);
        }

        return $template;
    }

    /**
     * Returns the template filename when using bulk rendering
     *
     * @return string filename
     */
    public function getBulkFilename()
    {
        return 'invoices.pdf';
    }

    /**
     * Returns the template filename
     *
     * @return string filename
     */
    public function getFilename()
    {
        $id_lang = Context::getContext()->language->id;
        $id_shop = (int)$this->order->id_shop;
        $format = '%1$s%2$06d';

        if (Configuration::get('PS_INVOICE_USE_YEAR')) {
            $format = Configuration::get('PS_INVOICE_YEAR_POS') ? '%1$s%3$s-%2$06d' : '%1$s%2$06d-%3$s';
        }

        if($this->prefix != ""){
            // var_dump($this->prefix);
            return $this->prefix.'.pdf';
        }
        else{
            return sprintf(
                $format,
                Configuration::get('PS_INVOICE_PREFIX', $id_lang, null, $id_shop),
                $this->order_invoice->number,
                date('Y', strtotime($this->order_invoice->date_add))
            ).'.pdf';
        }
    }
    
    protected function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $dec = array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","30","40","50","60","70","80","90");
        if(in_array($decimal, $dec)){
            $paise = $words[$decimal];
        }
        else if($decimal == 0.00){
            $paise = '';
        }
        else{
            $paise = $words[$decimal - ($decimal%10)].' '.$words[($decimal%10)];    
        }
        return ($Rupees ? 'Rupees '.$Rupees : '') . ($paise != '' ? 'and '.$paise . ' paise ' : '').'only';
    }
}

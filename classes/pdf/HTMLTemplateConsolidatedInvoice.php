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
class HTMLTemplateConsolidatedInvoiceCore extends HTMLTemplate
{
    public $orders;
    public $order_invoice;
    public $available_in_your_account = false;

    /**
     * @param OrderInvoice $order_invoice
     * @param $smarty
     * @throws PrestaShopException
     */
    public function __construct($orders, $smarty, $bulk_mode = false)
    {
        $this->orders=$orders;

        $order=new Order($orders[0]);
        $this->order=$order;
        $id_order_invoice=$order->getInvoiceId();        
        $this->number=$id_order_invoice;
        $order_invoice=new OrderInvoice($id_order_invoice);
        $this->order_invoice = $order_invoice;
        //$this->order = new Order((int)$this->order_invoice->id_order);
        $this->smarty = $smarty;
        
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
        $this->date = Tools::displayDate($order_invoice->date_add);

        $id_lang = Context::getContext()->language->id;
        $this->number=
        $this->title = $this->getInvoiceNumberFormatted($id_lang);

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
        $this->smarty->assign(array('header' => HTMLTemplateInvoice::l('Invoice')));

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

        $order_details = $this->getProducts();
        $has_discount = false;
        $i=0;
        foreach ($order_details as $id => &$order_detail) {
            //S.no added//
            $i++;
            $order_detail['i']=$i;
            // Find out if column 'price before discount' is required
            /** BASE PRICE REMOVED **/
            /*
            if ($order_detail['reduction_amount_tax_excl'] > 0) {
                $has_discount = true;
                $order_detail['unit_price_tax_excl_before_specific_price'] = $order_detail['unit_price_tax_excl_including_ecotax'] + $order_detail['reduction_amount_tax_excl'];
            } elseif ($order_detail['reduction_percent'] > 0) {
                $has_discount = true;
                $order_detail['unit_price_tax_excl_before_specific_price'] = (100 * $order_detail['unit_price_tax_excl_including_ecotax']) / (100 - $order_detail['reduction_percent']);
            }*/

            // Set tax_code
            $taxes = OrderDetail::getTaxListStatic($order_detail['id_order_detail']);
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

        $product_taxes = 0;
        $product_discounts_tax_excl = 0;
        $product_discounts_tax_incl = 0;
        $products_after_discounts_tax_excl = 0;
        $products_after_discounts_tax_incl = 0;
        $shipping_tax_excl = 0;
        $shipping_tax_incl =0;
        $shipping_taxes = 0;
        $wrapping_taxes =0;
        $total_taxes = 0;
        $total_taxes =0;
        $total_products_wt =0;
        $total_wrapping_tax_excl=0;
        $total_wrapping_tax_incl=0;
        $total_paid_tax_incl=0;
        $total_paid_tax_excl=0;

        foreach($this->orders as $order){
            $order=new Order($order);
            $id_order_invoice=$order->getInvoiceId();
            $invoice=new OrderInvoice($id_order_invoice);
            foreach ($invoice->getProductTaxesBreakdown($this->order) as $details) {
                $product_taxes += $details['total_amount'];
            }

            $product_discounts_tax_excl += $invoice->total_discount_tax_excl;
            $product_discounts_tax_incl += $invoice->total_discount_tax_incl;
            if ($free_shipping) {
                $product_discounts_tax_excl -= $invoice->total_shipping_tax_excl;
                $product_discounts_tax_incl -= $invoice->total_shipping_tax_incl;
            }

            $products_after_discounts_tax_excl += $invoice->total_products - $product_discounts_tax_excl;
            $products_after_discounts_tax_incl += $invoice->total_products_wt - $product_discounts_tax_incl;

            $shipping_tax_excl += $free_shipping ? 0 : $invoice->total_shipping_tax_excl;
            $shipping_tax_incl += $free_shipping ? 0 : $invoice->total_shipping_tax_incl;
            $shipping_taxes += $shipping_tax_incl - $shipping_tax_excl;

            $wrapping_taxes += $invoice->total_wrapping_tax_incl - $invoice->total_wrapping_tax_excl;

            $total_taxes += $invoice->total_paid_tax_incl - $invoice->total_paid_tax_excl;
            $total_products_wt +=$invoice->total_products_wt;
            $total_wrapping_tax_excl +=$invoice->total_wrapping_tax_excl;
            $total_wrapping_tax_incl +=$invoice->total_wrapping_tax_incl;
            $total_paid_tax_incl +=$invoice->total_paid_tax_incl;
            $total_paid_tax_excl +=$invoice->total_paid_tax_excl;
            $total_products +=$invoice->total_products;
        }
        /*
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
        */

        $footer = array(
            'products_before_discounts_tax_excl' => $total_products,
            'product_discounts_tax_excl' => $product_discounts_tax_excl,
            'products_after_discounts_tax_excl' => $products_after_discounts_tax_excl,
            'products_before_discounts_tax_incl' => $total_products_wt,
            'product_discounts_tax_incl' => $product_discounts_tax_incl,
            'products_after_discounts_tax_incl' => $products_after_discounts_tax_incl,
            'product_taxes' => $product_taxes,
            'shipping_tax_excl' => $shipping_tax_excl,
            'shipping_taxes' => $shipping_taxes,
            'shipping_tax_incl' => $shipping_tax_incl,
            'wrapping_tax_excl' => $total_wrapping_tax_excl,
            'wrapping_taxes' => $wrapping_taxes,
            'wrapping_tax_incl' => $total_wrapping_tax_incl,
            'ecotax_taxes' => $total_taxes - $product_taxes - $wrapping_taxes - $shipping_taxes,
            'total_taxes' => $total_taxes,
            'total_paid_tax_excl' => $total_paid_tax_excl,
            'total_paid_tax_incl' => $total_paid_tax_incl
        );

        foreach ($footer as $key => $value) {
            $footer[$key] = Tools::ps_round($value, _PS_PRICE_COMPUTE_PRECISION_, $this->order->round_mode);
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
		$terms="(i) This is a Computer generated Invoice; No Seal & Signature required"."\n";
        $terms="(i) Cash on Delivery - 100% payment at the time of delivery"."\n";
        $terms .="(ii) Cheque/DD - Should be drawn in favour of 'Kobster E-Shop Private Limited' payable at chennai"."\n";
        $terms .="(iii) For NEFT/RTGS/IMPS, Please find account details below :"."\n";
        $terms .=Configuration::get('BANK_WIRE_DETAILS');

        //$legal_free_text .="\n\n\n".$terms;

        /*** ORDER INFORMATIONS ***/
        $context=Context::getContext();
        $shipping_date=0;
        $dr_num='';
        $dr_number='';
        $order_id='';
        $po='';

        foreach($this->orders as $order){
            $order=new Order($order);
            $order_id .=sprintf('%06d', $order->id).",";
            $po .=$order->po_number.", ";

            foreach($order->getDrNumber() as $dr)
                $dr_num .=Configuration::get('PS_DELIVERY_PREFIX', (int)($context->cookie->id_lang)).sprintf('%06d', $dr['delivery_number']).", ";
            
            $history = $order->getHistory($this->order->id_lang);
            foreach($history as $h){
                if ($h['id_order_state'] == Configuration::get('PS_OS_SHIPPING')){
                    $shipping_date = $h['date_add'];
                }
            }    
        }                
        
        $order=new Order($this->orders[0]);
        $fc=new FulfillmentCentre($order->id_fc);
        $tin=$fc->tin;
        $cst=$fc->cst;
        $po=rtrim($po, ", ")."\n";
        $dr=rtrim($dr_num, ", ")."\n";
        $order_id=rtrim($order_id, ", ")."\n";
        
        $data = array(
            'order_id' => $order_id,
            'shipping_date'=>$shipping_date,
            'tin'=> $tin,
            'cst'=>$cst,
            'dr'=>$dr,
            'order' => $order,
            'po'=>$po,
            'order_invoice' => $this->order_invoice,
            'order_details' => $order_details,
            'cart_rules' => $cart_rules,
            'delivery_address' => $formatted_delivery_address,
            'invoice_address' => $formatted_invoice_address,
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
        );

        if (Tools::getValue('debug')) {
            die(json_encode($data));
        }

        $this->smarty->assign($data);

        $tpls = array(
            'style_tab' => $this->smarty->fetch($this->getTemplate('invoice.style-tab')),
            'addresses_tab' => $this->smarty->fetch($this->getTemplate('invoice.addresses-tab')),
            'product_tab' => $this->smarty->fetch($this->getTemplate('invoice.product-tab')),
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
        $id_lang = Context::getContext()->language->id;
        $id_shop = (int)$this->order->id_shop;
        $format = '%1$s%2$06d';

        if (Configuration::get('PS_INVOICE_USE_YEAR')) {
            $format = Configuration::get('PS_INVOICE_YEAR_POS') ? '%1$s%3$s-%2$06d' : '%1$s%2$06d-%3$s';
        }

        return sprintf(
            $format,
            Configuration::get('PS_INVOICE_PREFIX', $id_lang, null, $id_shop),
            $this->order_invoice->number,
            date('Y', strtotime($this->order_invoice->date_add))
        ).'.pdf';
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
        return sprintf(
            $format,
            Configuration::get('PS_INVOICE_PREFIX', $id_lang, null, $id_shop),
            $this->order_invoice->number,
            date('Y', strtotime($this->order_invoice->date_add))
        ).'.pdf';
    }

    public function getInvoiceNumberFormatted($id_lang, $id_shop = null)
    {
        $invoice_formatted_number = Hook::exec('actionInvoiceNumberFormatted', array(
            get_class($this) => $this,
            'id_lang' => (int)$id_lang,
            'id_shop' => (int)$id_shop,
            'number' => (int)$this->number
        ));

        if (!empty($invoice_formatted_number)) {
            return $invoice_formatted_number;
        }

        $format = '%1$s%2$06d';

        if (Configuration::get('PS_INVOICE_USE_YEAR')) {
            $format = Configuration::get('PS_INVOICE_YEAR_POS') ? '%1$s%3$s/%2$06d' : '%1$s%2$06d/%3$s';
        }

        return sprintf($format, Configuration::get('PS_INVOICE_PREFIX', (int)$id_lang, null, (int)$id_shop), $this->number, date('Y', strtotime($this->date_add)));
    }

    public function getProducts(){

        $order=new Order($this->orders[0]);
        $id_order_invoice=$order->getInvoiceId();
        $invoice=new OrderInvoice($id_order_invoice);

        $products=array();
        $products=$invoice->getProducts();
        
        $i=0;
        foreach($this->orders as &$order)
        {
            if($i!=0)
            {
                $order_obj=new Order($order);
                $id_order_invoice=$order_obj->getInvoiceId();
                $invoice_details=new OrderInvoice($id_order_invoice);
                $getProducts=$invoice_details->getProducts();

                foreach($getProducts as $product){
                    array_push($products,$product);
                }
            }
            $i++;
        }
        return $products;
    }
}
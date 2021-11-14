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
class HTMLTemplatePartialDeliverySlipCore extends HTMLTemplate
{
    public $order;
    public $id_delivery;

    /**
     * @param OrderInvoice $order_invoice
     * @param $smarty
     * @throws PrestaShopException
     */
    public function __construct(Delivery $delivery, $smarty, $bulk_mode = false)
    {

        //$this->order_invoice = $order_invoice;
        $this->delivery=$delivery;
        $this->order = new Order($delivery->getOrderId());
        $this->smarty = $smarty;

        // If shop_address is null, then update it with current one.
        // But no DB save required here to avoid massive updates for bulk PDF generation case.
        // (DB: bug fixed in 1.6.1.1 with upgrade SQL script to avoid null shop_address in old orderInvoices)
        /*if (!isset($this->order_invoice->shop_address) || !$this->order_invoice->shop_address) {
            $this->order_invoice->shop_address = OrderInvoice::getCurrentFormattedShopAddress((int)$this->order->id_shop);
            if (!$bulk_mode) {
                OrderInvoice::fixAllShopAddresses();
            }
        }*/

        // header informations
        $this->date = Tools::displayDate($this->delivery->delivery_date);


        // $prefix = Configuration::get('PS_DELIVERY_PREFIX', Context::getContext()->language->id);
        $id_supplier = EliteSupplierOrders::getOrderSupplier($this->order->id);
        $supplier = new EliteSupplier($id_supplier);
        $prefix = $supplier->getDeliveryPrefix();
        $this->title = sprintf(HTMLTemplatePartialDeliverySlip::l('%1$s%2$06d'), $prefix, $delivery->delivery_number);

        // footer informations
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
        $this->smarty->assign(array('header' => HTMLTemplatePartialDeliverySlip::l('Delivery Slip'), 'delivery_slip' => true));

        return $this->smarty->fetch($this->getTemplate('header'));
    }

    /**
     * Returns the template's HTML content
     *
     * @return string HTML content
     */
    public function getContent()
    {
        $delivery_address = new Address((int)$this->order->id_address_delivery);
        $formatted_delivery_address = AddressFormat::generateAddress($delivery_address, array(), '<br />', ' ');
        $formatted_invoice_address = '';

        if ($this->order->id_address_delivery != $this->order->id_address_invoice) {
            $invoice_address = new Address((int)$this->order->id_address_invoice);
            $formatted_invoice_address = AddressFormat::generateAddress($invoice_address, array(), '<br />', ' ');
        }

        /*$carrier = new Carrier($this->order->id_carrier);
        $carrier->name = ($carrier->name == '0' ? Configuration::get('PS_SHOP_NAME') : $carrier->name);*/

        $order_details = $this->delivery->getProducts();
        $i=0;
        foreach ($order_details as &$order_detail) {
            $i++;
            $order_detail['i'] =$i;
        }
        
        /*if (Configuration::get('PS_PDF_IMG_DELIVERY')) {
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
        }*/

        $d_address = new Address((int)$this->order->id_address_delivery);
        $state_of_supply = new State($d_address->id_state);
        $formatted_delivery_address = $formatted_delivery_address."<br/> GST STATE: ".$state_of_supply->code." / ".$state_of_supply->name."<br/> GSTIN: ".$d_address->vat_number;

        $this->smarty->assign(array(
            'order' => $this->order,
            'order_details' => $order_details,
            'gst'=>$delivery_address->vat_number,
            'fc_address'=>$fc_address,
            'delivery_address' => $formatted_delivery_address,
            'invoice_address' => $formatted_invoice_address,
            'order_invoice' => $this->order_invoice,
            'shipping_date'=> $this->delivery->delivery_date,
            //'carrier' => $carrier,
            //'display_product_images' => Configuration::get('PS_PDF_IMG_DELIVERY')
        ));

        $tpls = array(
            'style_tab' => $this->smarty->fetch($this->getTemplate('delivery-slip.style-tab')),
            'addresses_tab' => $this->smarty->fetch($this->getTemplate('delivery-slip.addresses-tab')),
            'summary_tab' => $this->smarty->fetch($this->getTemplate('delivery-slip.summary-tab')),
            'product_tab' => $this->smarty->fetch($this->getTemplate('delivery-slip.product-tab')),
            //'payment_tab' => $this->smarty->fetch($this->getTemplate('delivery-slip.payment-tab')),
        );
        $this->smarty->assign($tpls);

        return $this->smarty->fetch($this->getTemplate('delivery-slip'));
    }

    /**
     * Returns the template filename when using bulk rendering
     *
     * @return string filename
     */
    public function getBulkFilename()
    {
        return 'deliveries.pdf';
    }

    /**
     * Returns the template filename
     *
     * @return string filename
     */
    public function getFilename()
    {
        return $this->title.".pdf";
    }
}

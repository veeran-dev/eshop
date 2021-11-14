<?php
/*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class PdfInvoiceControllerCore extends FrontController
{
    public $php_self = 'pdf-invoice';
    protected $display_header = false;
    protected $display_footer = false;

    public $content_only = true;

    protected $template;
    public $filename;

    public function postProcess()
    {
        if (!$this->context->customer->isLogged() && !Tools::getValue('secure_key') && !$this->context->cookie->s_id) {
            Tools::redirect('index.php?controller=authentication&back=pdf-invoice');
        }

        if (!(int)Configuration::get('PS_INVOICE')) {
            die(Tools::displayError('Invoices are disabled in this shop.'));
        }
        
        $id_order=0;
        $this->invoice=0;
        if(isset($_GET['id_order'])){
            $id_order=$_GET['id_order'];
        }
        
        if(is_array($id_order))
        {
            $this->invoice=1;
            $this->order = new Order($id_order[0]);
        }
        else if(isset($_GET['id_par_delivery']))
        {
            $this->processGeneratePartialDeliverySlip=1;
        }
        else
        {
            if (Validate::isUnsignedId($id_order)) {
                $order = new Order((int)$id_order);
            }

            if (!isset($order) || !Validate::isLoadedObject($order)) {
                die(Tools::displayError('The invoice was not found.'));
            }

            if (!OrderState::invoiceAvailable($order->getCurrentState()) && !$order->invoice_number) {
                die(Tools::displayError('No invoice is available.'));
            }

            $this->order = $order;
        }
    }

    public function display()
    {
        $logger=new FileLogger();
        $logger->setFilename("test.txt");
        $logger->logError("display");
        

        if(isset($this->processGeneratePartialDeliverySlip))
        {
            $logger->logError("89");
            if(isset($_GET['id_par_delivery']))
            {
                $logger->logError("92");
                $this->processGeneratePartialDeliverySlipPDF();
            }
        }
        elseif($this->invoice==1)
        {
            $consolidated_Invoice=$this->order->getConsolidatedInvoice();
            $orders=array();
            $logger->logError("100");
            if(sizeof($consolidated_Invoice)>1)
            {
                foreach ($consolidated_Invoice as $cin) {
                    array_push($orders, $cin['id_order']);
                }
                $logger->logError("106");
                $this->generateConsolidatedInvoicePDFByIdOrder($orders);
            }                
        }      
        else
        {
            $logger->logError("112");
            $order_invoice_list = $this->order->getInvoicesCollection();
            Hook::exec('actionPDFInvoiceRender', array('order_invoice_list' => $order_invoice_list));

            $pdf = new PDF($order_invoice_list, PDF::TEMPLATE_INVOICE, $this->context->smarty);
            $pdf->render();
        }
    }
    public function generateConsolidatedInvoicePDFByIdOrder($id_order)
    {
        foreach($id_order as $order){
            $order = new Order((int)$order);
            if (!Validate::isLoadedObject($order)) {
                die(Tools::displayError('The order cannot be found within your database.'));
            }
        }
        $this->generatePDF($id_order, PDF::TEMPLATE_CONSOLIDATED_INVOICE);
    }
    public function generatePDF($object, $template)
    {
        $pdf = new PDF($object, $template, Context::getContext()->smarty);
        if($template=='ConsolidatedInvoice')
            $pdf->renderPdf();
        else
            $pdf->render();
    }
     public function processGeneratePartialDeliverySlipPDF()
    {
        if (Tools::isSubmit('id_par_delivery')) {
            $this->generateDeliverySlipPDFByIdDelivery((int)Tools::getValue('id_par_delivery'));
        }
        else{
            die(Tools::displayError('Invalid Partial Delivery Slip'));   
        }        
    }
    public function generateDeliverySlipPDFByIdDelivery($id_delivery)
    {
        $delivery = new Delivery((int)$id_delivery);
        $this->generatePDF($delivery, PDF::TEMPLATE_PARTIAL_DELIVERY_SLIP);
    }
}

<?php
class docsDownloadControllerCore extends BackController
{
 	public $RM_auth = true;
	
 	public function displayContent()
  {
    parent::displayContent();
    self::$smarty->display('rm/rm-docs.tpl');	
  }
  public function ajaxReturn()
  {
    $token = Tools::getAdminTokenLiteCustom('AdminPdf', (int)(self::$cookie->id_employee));
    if(Tools::getValue('invoice'))
    {
      /** check invoice available **/
      $order_invoice = OrderInvoice::getInvoiceByNumber(Tools::getValue('invoice'));
      if($order_invoice)
      {
        $order = $order_invoice->getOrder();
        $result['token'] = $token;
        $result['order'] = $order->id;
        echo json_encode($result);
      }
      else{
        echo "0";
      }
    }
    elseif (Tools::getValue('dr')) {
      /** check drs available  **/
      $id_delivery = Delivery::getDrId(Tools::getValue('dr'));
      if($id_delivery['0']['id_delivery'])
      {
        $delivery = new Delivery($id_delivery['0']['id_delivery']);
        $id_order = $delivery->getOrderId();
        $result['token'] = $token;
        $result['order'] = $id_order;
        $result['id_delivery'] = $id_delivery['0']['id_delivery'];
        echo json_encode($result);
      }
      else
      {
        echo "0";
      }
    }
  }
}
 
?>
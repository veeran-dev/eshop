<?php
class FinanceVatControllerCore extends BackController
{	
	public function displayContent()
	{
		self::$smarty->display('finance/finance-vat.tpl');	
 	}
 	public function ajaxReturn()
 	{
        $order_id = !empty($_GET['order_id']) ? $_GET['order_id'] : "";
        if($order_id)
        {
            $order = new Order($order_id);
            $invoice_submitted = count($order->getHistory((int)$order->id_lang, OrderState::FLAG_INVOICE_SUBMITTED));
            if(!$invoice_submitted)
            {
                $sql = 'SELECT kod.`id_order_detail`,kod.`product_name`,kod.`product_quantity`,kod.`total_price_tax_excl`,kod.`total_price_tax_incl`,kt.`rate` FROM '._DB_PREFIX_.'order_detail kod 
                    LEFT JOIN '._DB_PREFIX_.'order_detail_tax kodt ON(kod.`id_order_detail`=kodt.`id_order_detail`)
                    LEFT JOIN '._DB_PREFIX_.'tax kt ON(kt.`id_tax`=kodt.`id_tax`)
                    WHERE kod.`id_order`='.$order_id.'';
                $data=Db::getInstance()->executeS($sql);
                $tax=Tax::getTaxes();

                $this->context->smarty->assign('data',$data);
                $this->context->smarty->assign('tax',$tax);
                $this->context->smarty->assign('id_order',$order_id);
            }
            else
            {
                $error = "Invoice submitted for this order #".$order_id;
                $this->context->smarty->assign('error',$error);
            }
            self::$smarty->display('finance/finance-vat.tpl');  
        }
        if(!empty($_POST['values']))
        {            
            $order = new Order(Tools::getValue('id_order'));
            $customer = new Customer($order->id_customer);
            $values_array = explode(",", Tools::getValue('values'));
            $shipping = 0;
            $changingVat = array();
            if($customer->id_buyer !=3 && (int)$order->total_paid < 1500)
            {
                $shipping = 1;
            }
            
            foreach($values_array as $values)
            {
                $vat_detail = explode("-", $values);                
                $order_detail = new OrderDetail($vat_detail[0]);
                $vat_id = $vat_detail[1];
                $vat_rate = $vat_detail[2];

                $product_vat = $order_detail->product_id."~".$vat_rate;
                array_push($changingVat, $product_vat);
                $unit_tax_excl = $order_detail->unit_price_tax_excl;
                $total_tax_excl = $order_detail->total_price_tax_excl;

                $unit_tax = $unit_tax_excl*$vat_rate/100;
                $total_tax = $total_tax_excl*$vat_rate/100;
                $unit_tax_incl = $unit_tax_excl + $unit_tax;
                $total_tax_incl = $total_tax_excl + $total_tax;

                $order_detail ->unit_tax_incl = $unit_tax_incl;
                $order_detail ->total_tax_incl = $total_tax_incl;
                if($order_detail ->save())
                {
                    $result = 1;
                }
                else{
                    $result = 0;
                }               

                if($result == 1)
                {
                    $sql = "update "._DB_PREFIX_."order_detail set unit_price_tax_incl=".$unit_tax_incl.",total_price_tax_incl=".$total_tax_incl." where id_order_detail=".$vat_detail[0]."";
                    $data = Db::getInstance()->execute($sql);
                    if($data){
                        $result = 1;
                    }
                    else
                    {
                        $result = 0;
                    }
                }
                if($result == 1)
                {
                    $sql_query="select * from "._DB_PREFIX_."order_detail_tax where id_order_detail=".$vat_detail[0]." ";
                    $data_available = Db::getInstance()->getRow($sql_query);
                    
                    if($data_available){
                        $sql = "update "._DB_PREFIX_."order_detail_tax set id_tax=".$vat_id.",unit_amount=".$unit_tax.",total_amount=".$total_tax." where id_order_detail=".$vat_detail[0]."";

                        $data = Db::getInstance()->execute($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `kob_order_detail_tax`(id_order_detail,id_tax,unit_amount,total_amount) VALUES(".$vat_detail[0].",".$vat_id.",".$unit_tax.",".$total_tax.")";
                        $data = Db::getInstance()->execute($sql);   
                    }
                    if($data){
                        $result = 1;
                    }
                    else
                    {
                        $result = 0;
                    }                
                }                
            }
            if($result == 1){
                $order_total = Db::getInstance()->getRow("SELECT SUM(total_price_tax_incl) AS total FROM "._DB_PREFIX_."order_detail WHERE id_order=".$order->id." ");
                if($order_total){
                    $result = 1;
                }
                else
                {
                    $result = 0;
                }  
            }
            $order_total_shipping_incl = $order_total['total'];
            if($shipping == 1)
            {                
                $order_total_shipping_incl = $order_total['total'] + 75;
                $order->total_paid_real = $order_total_shipping_incl;    
                $order->total_paid = $order_total_shipping_incl;
                $order->total_paid_tax_incl = $order_total_shipping_incl;
                $order->total_products_wt = $order_total_shipping_incl - 75;
            }
            else
            {
                $order->total_paid_real = $order_total_shipping_incl;    
                $order->total_paid = $order_total_shipping_incl;
                $order->total_paid_tax_incl = $order_total_shipping_incl;      
                $order->total_products_wt = $order_total_shipping_incl;
            }
            
            

            if($order->save())
            {
                $result = 1;
            }
            if($order->isInvoiceGenerated() && $result == 1)
            {
                global $cookie;
                $order_total = Db::getInstance()->execute("update "._DB_PREFIX_."order_invoice set total_paid_tax_incl=".$order_total_shipping_incl." where id_order=".$order->id."");


                $table_name='change_tax';
                $product_detail ='<tr style="text-align: left;line-height: 28px;">
                                    <th style="text-align: left;padding-left: 30px;background: #ebebeb;width: 50%;height: 10px;">Product ID</th>
                                    <th style="text-align: left;background-color: #ebebeb;width: 50%;">GST Rate</th>
                                </tr>';
                foreach($changingVat as $vat)
                {
                    $change_detail = explode("~", $vat);                
                    $data = array(
                    'id_order'       => $order->id,
                    'id_product'     => $change_detail[0],
                    'vat_rate'       => $change_detail[1],
                    'id_employee'    => (int)($cookie->id_employee),
                    'date'           => date("Y-m-d h:i:s")
                    );
                    $change=Db::getInstance()->insert($table_name, $data);

                    $product_detail .= '<tr><td align="left" style="font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:20px;color:#dc2d3c;text-align: left;padding-left:30px;/* padding-right:30px; */padding-top: 4px;padding-bottom: 4px;">'.$change_detail[0].' </td><td align="left" style="font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:20px;color:#dc2d3c;text-align:left;/* padding-left:30px; *//* padding-right:30px; */padding-top: 4px;padding-bottom: 4px;"> '.$change_detail[1].' </td><tr>';
                }

                $fc = new FulfillmentCentre($order->id_fc);

                $data = array(
                    '{order_id}' => $order->id,
                    '{product_detail}' => $product_detail,
                    '{fc}'  => $fc->name
                );

                Mail::Send((int)$cookie->id_lang, 'vat_change_info', Mail::l("GST Changes", (int)$cookie->id_lang), $data, 'catalog@kobster.com', 'GST changes', 'noreply@kobster.com');
                
                if($order_total)
                {
                    $result = 1;
                }
                else
                {
                    $result = 2;
                }


            }
            echo $result;
        }
    }
}
?>
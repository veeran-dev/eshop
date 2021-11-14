<?php
class ScnOrderStatusControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		parent::ajaxReturn();
		/*Vendor Details*/
		$type = Tools::getValue('type');
		$order_status = Tools::getValue('order_status');
		$duration = Tools::getValue('duration');
		$buyer_type = Tools::getValue('buyer_type');
		$orderid = Tools::getValue('orderid');
		$qty = Tools::getValue('qty');
		$delivery_number=Tools::getValue('delivery_number');
		$id_order_detail=Tools::getValue('idorderdetail');
		$sign_img=Tools::getValue('sign_img');
		$name =Tools::getValue('name');
		$Replacearray =Tools::getValue('Replacearray');
		$Cancelarray =Tools::getValue('Cancelarray');
		$id_fc = Tools::getValue('id_fc');
		if($id_fc == 0)
			$id_fc = NULL;
 		if($type==1)
		{
			$result = array();
 			$scn_orderstatus= Order::getOrderStatusForScn($isFinanace = false,$id_fc);
 			$states = OrderState::getOrderStates(1);
			array_push($result, $scn_orderstatus, $states);
 			echo Tools::jsonEncode($result);
		}
		elseif($type==2)
		{
			$tab = 'AdminOrders';
			$token = Tools::getAdminTokenLiteCustom($tab, (int)(self::$cookie->id_employee));
			$result=array();
			$scn_orderdetails= Order::getStatusOrdersDetails(0,$order_status,$duration,$id_fc);
			array_push($result,$scn_orderdetails,$token);
			echo Tools::jsonEncode($result);
		}
		elseif($type==3)
		{
				$deliverynumber=Delivery::getDeilveryId($delivery_number);
				$result=array();
				$pdetails=array();
				$deliverydetails=DeliveryDetails::getDeliveryDetails($deliverynumber['id_delivery']);
				/*setcookie('delivery_number',$delivery_number);
				setcookie('id_delivery',$deliverynumber['id_delivery']);*/
				self::$cookie->delivery_number=$delivery_number;
				self::$cookie->id_delivery=$deliverynumber['id_delivery'];

				$i=0;
				foreach($deliverydetails as $d)
				{
					$productdetails=Product::getProductDetail($d['id_product']);
					$id_order_detail=OrderDetail::getIdOrderDetail($d['id_order'],$d['id_product']);
					$deliverydetails[$i]['reference']=$productdetails['reference'];
					$deliverydetails[$i]['Product_name']=$productdetails['product_name'];
					$deliverydetails[$i]['id_order_detail']=$id_order_detail['id_order_detail'];
					$i++;
				}
				//setcookie('id_order',$deliverydetails[0]['id_order']);
				self::$cookie->id_order=$deliverydetails[0]['id_order'];
				$state=OrderHistory::getLastOrderState($deliverydetails[0]['id_order']);			
				if(($state->id==4 || $state->id==18 || $state->id==21 || $state->id==25) && !(Delivery::CheckDeliverNumber($delivery_number)))
				{
					$order=new Order($deliverydetails[0]['id_order']);
					$id_delivery_address=$order->id_address_delivery;
					$address=Address::getParticularAddress($id_delivery_address);
					$paymentoption=$order->payment;
					array_push($deliverydetails, $address,$paymentoption);
					echo json_encode($deliverydetails);
				}
				else
				{
					echo "2";
				}

			
		}
		elseif($type==6)
		{
			$order=new Order(self::$cookie->id_order);
			if(!empty($Cancelarray))
			{
				$Cancelarray=explode(",",$Cancelarray);   			
				for ($i=0;sizeof($Cancelarray)>$i;$i++ )
				{
				   $Cancelarray[$i]=explode("-",$Cancelarray[$i]);
				   $id_order_detail=$Cancelarray[$i][1];
				   $qty=$Cancelarray[$i][0];
				   $orderdetail=new OrderDetail($id_order_detail);
				   if(!$order->deleteProduct($order,$orderdetail,$qty))
				   {
				   	echo "1";
				   }
				}
			}
			if(!empty($Replacearray))
			{
				$Replacearray=explode(",",$Replacearray);
				for ($i=0;sizeof($Replacearray)>$i;$i++ )
				{
				   $Replacearray[$i]=explode("-",$Replacearray[$i]);
				   $id_order_detail=$Replacearray[$i][1];
				   $qty=$Replacearray[$i][0];
				   $orderdetail=new OrderDetail($id_order_detail);
				   $qty=($orderdetail->product_quantity_delivered)-$qty;
				   if(!$orderdetail->updateQtyDelivered($qty))
				   {
				   	echo "1";
				   }
				}
			}

			if(Delivery::setdeliverysignature(self::$cookie->id_delivery,self::$cookie->$delivery_number,$sign_img,$name))
			{
				echo "2";
			}
		}
		elseif($type == 7){
			$fullfillment_centre = FulfillmentCentre::getAllFCentres();
			echo Tools::jsonEncode($fullfillment_centre);
		}
	}
}
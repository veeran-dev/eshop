<?php 
class OrderCarrier extends OrderCarrierCore
{
	public function UpdateOrderCarrier($id_order,$id_carrier,$tracking_number)
	{
		return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'order_carrier` set id_carrier="'.$id_carrier.'", tracking_number="'.$tracking_number.'" WHERE  id_order="'.$id_order.'"');
	}
}
?>
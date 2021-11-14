<?php
	$id_order = $_POST['order-id'];
	new WordDocAPI($id_order."-invoice.rtf","application/rtf",$id_order);
?> 

<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility
include(PS_ADMIN_DIR.'/../config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');

if(sizeof($_POST)>0)
{
	$selectedOrders = $_POST;
	/*$sql = '
	SELECT op.reference, od.product_name, od.product_quantity, om.name, 
		   op.supplier_reference, o.id_order, op.price, op.wholesale_price
	FROM `'._DB_PREFIX_.'orders` o, `'._DB_PREFIX_.'order_detail` od, `'._DB_PREFIX_.'product` op,  
	     `'._DB_PREFIX_.'manufacturer` om 
	WHERE o.id_order IN ('.implode(",", $selectedOrders).')
		   and o.id_order=od.id_order and od.product_id=op.id_product and 
		   op.id_manufacturer=om.id_manufacturer
	ORDER BY om.id_manufacturer, od.product_id';*/
	$sql = 'SELECT op.reference, od.product_name, sum(od.product_quantity-od.product_quantity_delivered) as product_quantity, om.name, 
		   op.supplier_reference, GROUP_CONCAT(o.id_order SEPARATOR ",") as id_order, op.price, op.wholesale_price
			FROM `'._DB_PREFIX_.'orders` o, `'._DB_PREFIX_.'order_detail` od, `'._DB_PREFIX_.'product` op LEFT OUTER JOIN `'._DB_PREFIX_.'manufacturer` om ON op.id_manufacturer=om.id_manufacturer
			WHERE o.id_order IN ('.implode(",", $selectedOrders).')
			AND o.id_order=od.id_order AND od.product_id=op.id_product and (od.product_quantity-od.product_quantity_delivered)>0
			GROUP BY op.reference ORDER BY om.id_manufacturer, od.product_id';
}
else{
	$sql = '
	SELECT op.reference, od.product_name, sum(od.product_quantity-od.product_quantity_delivered) as product_quantity, om.name, 
		   op.supplier_reference, GROUP_CONCAT(o.id_order SEPARATOR ",") as id_order, op.price, op.wholesale_price
	FROM `'._DB_PREFIX_.'orders` o, `'._DB_PREFIX_.'order_detail` od, 
		`'._DB_PREFIX_.'product` op LEFT OUTER JOIN `'._DB_PREFIX_.'manufacturer` om  
		ON op.id_manufacturer=om.id_manufacturer
	WHERE o.id_order IN (SELECT t.id_order
						 FROM   '._DB_PREFIX_.'order_history t
						 INNER JOIN (
								SELECT id_order, max(date_add) as MaxDate
								FROM '._DB_PREFIX_.'order_history
								GROUP BY id_order
							) tm ON t.id_order = tm.id_order AND 
									t.date_add = tm.MaxDate AND
									t.id_order_state in (18,19,21,22,24)
						)
		   and o.id_order=od.id_order and od.product_id=op.id_product 
		   and (od.product_quantity-od.product_quantity_delivered)>0
	GROUP BY op.reference
	ORDER BY om.id_manufacturer, od.product_id';
}
echo PDF::purchasePlan(Db::getInstance()->ExecuteS($sql));
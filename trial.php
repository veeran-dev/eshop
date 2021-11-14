<?php
require(dirname(__FILE__).'/config/config.inc.php');
$sql = 'SELECT kgl.`name`,kc.`id_customer`,ko.`id_order`, koi.`total_paid_tax_incl` as invoice_amount,ko.`credit_days`,DATEDIFF(NOW(),koi.`date_add`) AS age, DATE_ADD("SELECT oha.date_add from '._DB_PREFIX_.'order_history oha WHERE oha.id_order=ko.id_order",INTERVAL '.oh.credit_days.' Day) AS Due_date
						 FROM '._DB_PREFIX_.'orders ko 
						 LEFT JOIN '._DB_PREFIX_.'order_invoice koi on koi.id_order = ko.id_order 
						 LEFT JOIN '._DB_PREFIX_.'order_history koh on koh.id_order = ko.id_order 
						 LEFT JOIN '._DB_PREFIX_.'customer kc on kc.id_customer = ko.id_customer 
						 LEFT JOIN '._DB_PREFIX_.'group_lang kgl on kgl.id_group = kc.id_default_group 
						 WHERE koh.id_order_history in (SELECT max(id_order_history) FROM '._DB_PREFIX_.'order_history oh WHERE oh.id_order = ko.id_order ) 
						 AND kgl.id_lang=1 
						 AND koh.id_order_state NOT IN(6,7,38) 
						 AND ko.date_add >= "2017-07-01 00:00:00" 
						 AND kgl.id_group NOT IN(1,0)
						 ORDER BY kgl.id_group ';
			echo $sql;

			?>
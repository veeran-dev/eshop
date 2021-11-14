SELECT o.id_order,c.firstname,p.reference,pl.description_short,od.product_price,fc.city_name FROM `kob_order_detail` as od
left join kob_orders as o on o.id_order = od.id_order
left join kob_customer as c on c.id_customer = o.id_customer
left join kob_order_history  as h on h.id_order = o.id_order
left join kob_product as p on p.id_product = od.product_id
left join kob_product_lang as pl on pl.id_product = od.product_id
left join kob_fulfillment_centre as fc on fc.id_fulfillment_centre = o.id_fc 
where o.date_add between "2015-07-01 00:00:00" and "2015-07-31 00:00:00"

AND  h.id_Order_history IN (SELECT  MAX(oha.`id_order_history`)
																FROM kob_order_history AS oha
																WHERE o.id_order = oha.id_order
																GROUP BY oha.id_order)
AND 	h.`id_order_state` IN (38) 
and pl.id_lang = 1
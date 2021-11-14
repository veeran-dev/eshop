SELECT detail.product_id as product_id,product.reference as produt_code, pro_lang.name as product_name , sum(detail.product_quantity - detail.product_quantity_return - detail.product_quantity_refunded)as qty , detail.product_price , cat_lang.name,count(Distinct(orders.id_order))as total_orders,round((sum(detail.product_quantity - detail.product_quantity_return - detail.product_quantity_refunded)/count(Distinct(orders.id_order)))) as average_consuption
 	From kob_order_detail detail 
	left join kob_orders orders on detail.id_order = orders.id_order
	left join kob_product product on detail.product_id = product.id_product
	left join kob_order_history history on orders.id_order = history.id_order
	left join kob_product_lang pro_lang on product.`id_product` = pro_lang.`id_product`
	left join kob_category node on product.`id_category_default` = node.`id_category`
	left join kob_category parent on node.nleft BETWEEN parent.nleft AND parent.nright
	left join kob_category_lang cat_lang on parent.id_category = cat_lang.`id_category`
	left join kob_customer cus on cus.id_customer = orders.id_customer
	WHERE   orders.id_customer IN (3131,2705,2989,2140,2143)
	AND     pro_lang.`id_lang`= 1												
	AND 	history.id_Order_history IN (
					SELECT  MAX(oha.`id_order_history`)
					FROM kob_order_history AS oha
					WHERE orders.id_order = oha.id_order
					GROUP BY oha.id_order)
	AND 	history.`id_order_state` IN ( 5,25) 
	AND 	orders.date_add >= NOW()-INTERVAL 3 MONTH
	AND     cat_lang.`id_lang` = 1
	AND 	parent.level_depth=1
	 
	 group by product.id_product  order by qty desc limit 400
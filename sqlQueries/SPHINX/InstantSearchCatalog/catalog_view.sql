CREATE OR REPLACE VIEW kob_catalog_view AS
SELECT 
	Product.id_product ,P_lang.name ,Product.reference ,Product.price, Category.id_category ,Category.name as category ,Brand.id_manufacturer ,Brand.name as brand,Tag.id_tag ,Tag.name as tag, zone.zone_id, (CASE WHEN zone.zone_id=0 THEN 'PAN India' ELSE kfc.city_name END) AS city_name
	FROM
        kob_product Product
        LEFT join kob_product_lang P_lang ON P_lang.id_product = Product.id_product AND P_lang.id_lang = 1
        LEFT join kob_category_lang Category ON Category.id_category = Product.id_category_default AND Category.id_lang = 1
        LEFT join kob_manufacturer Brand ON Brand.id_manufacturer = Product.id_manufacturer
        LEFT join kob_product_tag P_tag ON P_tag.id_product = Product.id_product AND P_tag.id_lang = 1
        LEFT join kob_tag Tag ON Tag.id_tag = P_tag.id_tag AND Tag.id_lang = 1
		LEFT join kob_product_zone_mapping zone ON zone.product_id = Product.id_product
        LEFT JOIN kob_fulfillment_centre kfc on kfc.id_fulfillment_centre=zone.zone_id
		
CREATE OR REPLACE VIEW catalog AS
SELECT 
	Product.id_product ,P_lang.name ,Product.reference ,Product.price, Category.id_category ,Category.name as category ,Brand.id_manufacturer ,Brand.name as brand, GROUP_CONCAT(DISTINCT Tag.name) as tag,
	((SELECT if(SUM(kod.product_quantity) IS NULL, 0,SUM(kod.product_quantity)) FROM `kob_order_detail` kod LEFT JOIN kob_orders ko on ko.id_order=kod.id_order WHERE ko.current_state=38 AND kod.product_id=Product.id_product) +
		(SELECT COUNT(*) FROM kob_specific_price ksp WHERE ksp.id_product=Product.id_product AND ksp.to >= CURDATE()) +
		(SELECT if(DATEDIFF(CURDATE(), date_upd) < 5, 1000, 0 ) FROM kob_product WHERE id_product=Product.id_product)+
		(SELECT if(ksa.out_of_stock = 0,-100000,0) FROM kob_stock_available ksa WHERE ksa.id_product=Product.id_product AND ksa.id_product_attribute=0)
	)as score
	FROM
        kob_product Product
        LEFT join kob_product_lang P_lang ON P_lang.id_product = Product.id_product AND P_lang.id_lang = 1
        LEFT join kob_category_lang Category ON Category.id_category = Product.id_category_default AND Category.id_lang = 1
        LEFT join kob_manufacturer Brand ON Brand.id_manufacturer = Product.id_manufacturer
        LEFT join kob_product_tag P_tag ON P_tag.id_product = Product.id_product AND P_tag.id_lang = 1
        LEFT join kob_tag Tag ON Tag.id_tag = P_tag.id_tag AND Tag.id_lang = 1
        GROUP BY Product.id_product
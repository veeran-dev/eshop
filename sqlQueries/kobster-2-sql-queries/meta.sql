
ALTER TABLE  `kob_meta_lang` CHANGE  `title`  `title` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE  `kob_meta_lang` CHANGE  `description`  `description` VARCHAR( 400 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

UPDATE `kob_meta_lang` set title='Buy Wholesale Electronics, Office Furniture, Tools, Lab Equipment & Supplies, Construction, Automobiles, Educational, Stationery Items Online', description='Bulk Office Supplies, Electronics and Machines, Furniture, Safety, Tools, Electrical, Lab Supplies, Plumbing, Construction, Automobiles, Educational Products Online at Wholesale Prices for Corporate Buyers, Retailers, SMEs, Schools, Colleges, Hospitals and Hotels. Free Shipping. Credit Facility Available.' where id_meta=4 and id_lang=1;

UPDATE `kob_category_lang` set meta_title=concat(name," - Buy ", name, " Online") where id_lang=1;
UPDATE `kob_category_lang` set meta_description=concat("Bulk ", name, " at Wholesale Prices for Corporate Buyers, Retailers, Product Managers, SMEs, Manufacturers, Hospitals and Hotels. Free Shipping. Credit Facility Available.") where id_lang=1;

UPDATE `kob_product_lang` a, kob_product b 
SET a.meta_title=concat(name,' (',b.reference,')', ' | Kobster.com'), a.meta_description=concat('Buy Wholesale ', name,' (',b.reference,')', ' Online at Best Prices in India at Kobster.com')
where id_lang=1 and a.id_product=b.id_product;
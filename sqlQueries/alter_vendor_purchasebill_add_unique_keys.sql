ALTER TABLE `kob_vendor_purchase_bill` ADD CONSTRAINT purchase_bill_unique_keys UNIQUE (id_vendor, id_bill_no, id_product);
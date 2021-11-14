<?php
require(dirname(__FILE__).'/config/config.inc.php');
$products = Db::getInstance()->executeS('SELECT p.`id_product`,p.`id_category_default`,pl.`name` FROM kob_product p
										 LEFT JOIN kob_product_lang pl ON p.`id_product` = pl.`id_product` AND pl.`id_lang` = 1');
foreach($products as $product){
	$logger = new FileLogger();
	$logger->setFilename('test1.txt');
	$logger->logError("-------id_product--------".Tools::getPath((int)$product['id_category_default'], $product['name']));
}
<?php
require('../config/config.inc.php');

$id_category 			= $_POST["id_category"];
$query 					= "SELECT `associated_products` FROM `"._DB_PREFIX_."category_sub_listing` WHERE `subCategory_id` = ".$id_category;
$category_details	 	= Db::getInstance()->getRow($query);
if(!empty($category_details['associated_products'])){
$associated_products 	= unserialize($category_details['associated_products']);
}

if (isset($_POST["action"]) && $_POST["action"] == 'add' ){
	
	$image_id 			= $_POST["associated_products_id"];
	
	$uploads_dir 		= '../themes/default-bootstrap/img/all-category/products';
	$fileAttachment 	= $_FILES['associated_products']['tmp_name'];
	$fileName 			= uniqid()."_".$_FILES['associated_products']['name'];
	$file_dir 			= _PS_BASE_URL_.__PS_BASE_URI__.$uploads_dir."/".$fileName;
	$status 			= move_uploaded_file($fileAttachment, $uploads_dir."/".$fileName);
	
	$associated_products[$image_id] 	=  $fileName;
	if(!$status) { $report_action = "Error in image upload"; } 
	else { 
		$report_action = "New Product added";
	}
}

if (isset($_POST["action"]) && $_POST["action"] == 'delete' ){
	$id_delete = $_POST["id_delete"];
	/*if(($key = array_search($id_delete, $list_category)) !== false) {
		unset($list_category[$key]);
	}*/
	unset($associated_products[$id_delete]);
	$report_action = "Product deleted"; 
}

if (isset($_POST["action"])){

	$update_query 	= "UPDATE `"._DB_PREFIX_."category_sub_listing` SET associated_products = '".serialize($associated_products)."' WHERE `subCategory_id` = ".$id_category;
	$status_update 	= Db::getInstance()->ExecuteS($update_query);
	
	if(!$status_update) { $report = "Error in Updating detail to db"; } else { $report = $report_action; }
}


$associated_products_string = implode(',',array_keys($associated_products));

$query_product = "SELECT a.`id_product`, b.`name` AS `product_name` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$associated_products_string.")";
$associated_products_array = Db::getInstance()->ExecuteS($query_product);

foreach($associated_products_array as $associated_prodcts){
?>
<li><?php echo $associated_prodcts['product_name']; ?> <span class="slider_remove" onClick="product_remove(<?php echo $associated_prodcts['id_product']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span>
<img src="../themes/default-bootstrap/img/all-category/products/<?php echo $associated_products[$associated_prodcts['id_product']]; ?>" class="img-responsive" ><br />
</li>
<?php } ?>
<div class="col-md-12 ajax_report" style="padding-left:0;"><?php echo $report; ?></div>
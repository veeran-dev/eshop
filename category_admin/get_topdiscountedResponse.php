<?php
require('../config/config.inc.php');

$id_category 			= $_POST["id_category"];
$query 					= "SELECT `list_top_discounted` FROM `"._DB_PREFIX_."category_listing` WHERE `category_id` = ".$id_category;
$category_details	 	= Db::getInstance()->ExecuteS($query);
$list_category 			= unserialize($category_details[0]['list_top_discounted']);

if (isset($_POST["action"]) && $_POST["action"] == 'add' ){
	
	$list_category[] = $_POST["list_top_discounted"];
	$report_action = "Product added";

}
if (isset($_POST["action"]) && $_POST["action"] == 'delete' ){

	$id_delete = $_POST["id"];
	if(($key = array_search($id_delete, $list_category)) !== false) {
		unset($list_category[$key]);
	}
	//unset($list_category[$id_delete]);
	$report_action = "Product deleted";
	 
}

if (isset($_POST["action"])){

	$updateData 	=  serialize($list_category);
	$table_name 	= "category_listing";
	$update_query 	= "UPDATE `"._DB_PREFIX_."category_listing` SET list_top_discounted = '".$updateData."' WHERE `category_id` = ".$id_category;
	$status_update 	= Db::getInstance()->ExecuteS($update_query);
	
	if(!$status_update) { $report = "Error in Updating detail to db"; } else { $report = $report_action; }
}
?>
<ol>
<?php
$list = implode(',',$list_category);
$query_product = "SELECT a.`id_product`, b.`name` AS `product_name`, sa.`active` AS `active` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$list.")";

$product_details = Db::getInstance()->ExecuteS($query_product);
$total_products = Db::getInstance()->numRows();
			
foreach($product_details as $products)
{
?>


    <li><?php echo $products['product_name']; ?> <span class="slider_remove" onClick="top_discounted(<?php echo $products['id_product']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span> </li>

<?php } ?>
</ol> 
<div class="col-md-12 ajax_report" style="padding-left:0;"><?php echo $report; ?></div>
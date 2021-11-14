<?php
require('../config/config.inc.php');

$id_category 			= $_POST["id_category"];
$query 					= "SELECT `associated_brands` FROM `"._DB_PREFIX_."category_sub_listing` WHERE `subCategory_id` = ".$id_category;
$category_details	 	= Db::getInstance()->getRow($query);
$list_category 			= unserialize($category_details['associated_brands']);

if (isset($_POST["action"]) && $_POST["action"] == 'add' ){
	
	$list_category[] = $_POST["associated_brands"];
	$report_action = "Brand added";

}
if (isset($_POST["action"]) && $_POST["action"] == 'delete' ){

	$id_delete = $_POST["id"];
	if(($key = array_search($id_delete, $list_category)) !== false) {
		unset($list_category[$key]);
	}
	//unset($list_category[$id_delete]);
	$report_action = "Brand deleted";
	 
}

if (isset($_POST["action"])){

	$updateData 	=  serialize($list_category);
	if (!empty($list_category)) { $is_branded = 1; } else { $is_branded = 0; }
	$update_query 	= "UPDATE `"._DB_PREFIX_."category_sub_listing` SET associated_brands = '".$updateData."', `is_branded` = '".$is_branded."'  WHERE `subCategory_id` = ".$id_category;
	$status_update 	= Db::getInstance()->ExecuteS($update_query);
	
	if(!$status_update) { $report = "Error in Updating detail to db"; } else { $report = $report_action; }
}
?>
<ol>
<?php
$list = implode(',',$list_category);
$query_product = "SELECT name, id_manufacturer FROM `kob_manufacturer` WHERE id_manufacturer IN (".$list.") ORDER BY `name` ASC";

$product_details = Db::getInstance()->ExecuteS($query_product);
$total_products = Db::getInstance()->numRows();
			
foreach($product_details as $products)
{
?>


    <li><?php echo $products['name']; ?> <span class="slider_remove" onClick="brands(<?php echo $products['id_manufacturer']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span> </li>

<?php } ?>
</ol> 
<div class="col-md-12 ajax_report" style="padding-left:0;"><?php echo $report; ?></div>
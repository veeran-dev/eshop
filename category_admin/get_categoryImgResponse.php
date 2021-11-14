<?php
require('../config/config.inc.php');

$id_category 			= $_POST["id_category"];


if (isset($_POST["action"]) && $_POST["action"] == 'add' ){
	
	$category_image_id 	= $_POST["category_image_id"];
	
	$uploads_dir 		= '../themes/default-bootstrap/img/all-category';
	$fileAttachment 	= $_FILES['category_image']['tmp_name'];
	$fileName 			= uniqid()."_".$_FILES['category_image']['name'];
	$file_dir 			= _PS_BASE_URL_.__PS_BASE_URI__.$uploads_dir."/".$fileName;
	$status 			= move_uploaded_file($fileAttachment, $uploads_dir."/".$fileName);

	if(!$status) { $report_action = "Error in image upload"; } 
	else { 
		$report_action = "New sub Category added";
	}
	
	$update_query 	= "INSERT INTO `"._DB_PREFIX_."category_sub_listing` (link_category_id, subCategory_id, subCategory_image) VALUES (".$id_category.", ".$category_image_id.", '".$fileName."')";
	
}

if (isset($_POST["action"]) && $_POST["action"] == 'delete' ){
	
	$delete_id 	= $_POST["id_delete"];
	$report_action = "Sub Category deleted";

	$update_query 	= "DELETE FROM `"._DB_PREFIX_."category_sub_listing` WHERE `subCategory_id` = ".$delete_id;
	
}

if (isset($_POST["action"])){

	$status_update 	= Db::getInstance()->ExecuteS($update_query);
	if(!$status_update) { $report = "Error in Updating detail to db"; } else { $report = $report_action; }
}
?>
<ol>
<?php
$query_sub 	= "SELECT `subCategory_id` FROM `"._DB_PREFIX_."category_sub_listing` WHERE `link_category_id` = ".$id_category;
$subCategory_details = Db::getInstance()->ExecuteS($query_sub);
//print_r($subCategory_details);
foreach($subCategory_details as $subCategory){
$subCategory_id[] = $subCategory['subCategory_id'];	
}
$subCategory_string = implode(',',$subCategory_id);

$query_sub2 = "SELECT a.`id_category`, `name` FROM `kob_category` a LEFT JOIN `kob_category_lang` b ON (b.`id_category` = a.`id_category` AND b.`id_lang` = 1 AND b.`id_shop` = 1) LEFT JOIN `kob_category_shop` sa ON (a.`id_category` = sa.`id_category` AND sa.id_shop = 1) WHERE a.`id_category` IN (".$subCategory_string.") ORDER BY `name` ASC";
$subCategory_details2 = Db::getInstance()->ExecuteS($query_sub2);
foreach($subCategory_details2 as $subCategory2){
?>
<li><a href="edit_subcategory.php?id=<?php echo $subCategory2['id_category']; ?>"><?php echo $subCategory2['name']; ?> <span class="label label-success">Edit</span></a> &nbsp; &nbsp; <span class="slider_remove" onClick="category_remove(<?php echo $subCategory2['id_category']; ?>, 'delete');"><i class="fa fa-trash-o"></i></span></li>
<?php }?>
</ol>
<div class="col-md-12 ajax_report" style="padding-left:0;"><?php echo $report; ?></div>
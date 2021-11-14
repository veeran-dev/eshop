<?php
require('../config/config.inc.php');

$id_category 			= $_POST["id_category"];
$query 					= "SELECT `list_category_slider` FROM `"._DB_PREFIX_."category_listing` WHERE `category_id` = ".$id_category;
$category_details	 	= Db::getInstance()->ExecuteS($query);
$list_category_slider 	= unserialize($category_details[0]['list_category_slider']);

if (isset($_POST["action"]) && $_POST["action"] == 'add' ){
	
	$uploads_dir 		= '../themes/default-bootstrap/img/all-category/slider';
	$fileAttachment 	= $_FILES['slider']['tmp_name'];
	$fileName 			= uniqid()."_".$_FILES['slider']['name'];
	$file_dir 			= _PS_BASE_URL_.__PS_BASE_URI__.$uploads_dir."/".$fileName;
	$status 			= move_uploaded_file($fileAttachment, $uploads_dir."/".$fileName);

	if(!$status) { $report_action = "Error in image upload"; } 
	else { 
		$list_category_slider[] = $fileName;
		$report_action = "New slider added";
	}
}
if (isset($_POST["action"]) && $_POST["action"] == 'delete' ){
	$id_delete = $_POST["id_delete"];
	unset($list_category_slider[$id_delete]);
	
	$report_action = "Slider deleted"; 
}

if (isset($_POST["action"])){

	$updateData 	=  serialize($list_category_slider);
	$table_name 	= "category_listing";
	$update_query 	= "UPDATE `"._DB_PREFIX_."category_listing` SET list_category_slider = '".$updateData."' WHERE `category_id` = ".$id_category;
	$status_update 	= Db::getInstance()->ExecuteS($update_query);
	
	if(!$status_update) { $report = "Error in Updating detail to db"; } else { $report = $report_action; }
}

foreach($list_category_slider as $key => $category_slider) { ?>
<div class="col-md-4 col-sm-4 col-xs-6" style="padding-left:0;">
<img src="../themes/default-bootstrap/img/all-category/slider/<?php echo $category_slider; ?>" class="img-responsive" >
<span class="slider_remove" id="slid<?php echo $key; ?>" onClick="slider_remove(<?php echo $key; ?>);">remove <i class="fa fa-trash-o"></i></span>
</div>
<?php } ?>
<div class="col-md-12 ajax_report" style="padding-left:0;"><?php echo $report; ?></div>
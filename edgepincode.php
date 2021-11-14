<?php
 
	$pincode = $_POST['pincode'];
	$url="http://pin-codes.in/api/pincode/".$pincode ;
	$ch = curl_init($url);
 	$outputpincode = curl_exec($ch);
 	$pin=explode(",", $outputpincode);
	return json_encode($pin); 
	
?>
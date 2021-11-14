<?php
class SupplierSettingsControllerCore extends FrontController
{
	public function  ajaxReturn(){
		$context = Context::getContext();
 		$type= Tools::getValue('type');
 		$prefix = Tools::getValue('drPrefix');
 		$number = Tools::getValue('drNumber');
		$file = $_FILES['file']['name'];
		$temp_name  = $_FILES['file']['tmp_name'];
		
		if($type == 1) {
			if($file != "" && isset($file)){
				$allowed =  array('jpg', "JPG", "JPEG",'png', "PNG", "svg", "SVG");
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				if(!in_array($ext, $allowed) ) {
				    $result = json_encode(array('error'=>'Sorry, File format not supported'));
				    echo $result;
				    return false;
				}
				else{
					if($_FILES['file']['size'] > 512000){
						$result = json_encode(array('error'=>'Sorry, File Size should be less than 500kb'));
					    echo $result;
					    return false;
					}
					else{
						$supplier = new EliteSupplier((int)($context->cookie->s_id));
						$file_name = $supplier->id;
						$splitName = explode(".", $file);
						$fileExt = end($splitName);
						if(count($splitName) > 1)
							$newFileName  = strtolower($file_name.'.'.$fileExt);  
						else
							$newFileName  = strtolower($file_name);

						$location = _PS_ROOT_DIR_."/supplier/src/logo/"; 

						$logos = glob($location.$newFileName);
						
						if (count($logos)) {
						    array_map('unlink', $logos);
						}
						if(move_uploaded_file($temp_name, $location.$newFileName)){
							$result = json_encode(array('success'=>'Your Profile picture uploaded successfully'));
						    echo $result;
						    return false;
						}
						else{
						    $result = json_encode(array('error'=>'Sorry something went wrong'));
						    echo $result;
						    return false;
						}
					}
				}
			}
		}
		else if($type == 2) {
			$supplier = new EliteSupplier($context->cookie->s_id);
			$file_name = $supplier->id;
			$location = "./supplier/src/logo/"; 
			if(glob($location.$file_name.'.*')){
    			$result = json_encode(array('logo'=>'../'.glob($location.$file_name.'.*')[0]."?".rand(1000, 10000)));
    		    echo $result;
    		    return false;
			}
			else{
			    $result = json_encode(array('error'=>'Sorry no logos available'));
			    echo $result;
			    return false;
			}
		}
 		if($type ==3){
 			$supplier = new EliteSupplier($context->cookie->s_id);
 			if($supplier->getDeliveryPrefix() && $number = $supplier->getDeliveryNumber()){
 			    $result = json_encode(array(
 			    						'success'=>'DR details updated successfully',
 			    						'prefix' => $supplier->getDeliveryPrefix(),
 			    						'number' => $number
 			    						));
    		    echo $result;
    		    return false;
 			}
 			else{
 			   //  $result = json_encode(array('error'=>'Sorry something went wrong'));
			    // echo $result;
			    return false;
 			}
 		}

 		if($type ==4){
 			$test = preg_match("/^[A-Z]+$/", $prefix);
 			if(!$test){
 				$result = json_encode(array('error'=>'DR prefix should contain only alphabets'));
			    echo $result;
			    return false;
 			}
 			$test = preg_match("/^[0-9]+$/", $number);
 			if(!$test){
 				$result = json_encode(array('error'=>'DR number should contain only numbers'));
			    echo $result;
			    return false;
 			}
 			if(strlen((string)$number) > 6){
 				$result = json_encode(array('error'=>'DR number should be within 6 digits'));
			    echo $result;
			    return false;
 			}
 			if($number <= 0){
 				$result = json_encode(array('error'=>'DR number should be greater than 0'));
			    echo $result;
			    return false;
 			}

 			$supplier = new EliteSupplier($context->cookie->s_id);
 			if($supplier->drConfiguration($prefix, $number)){
 			    $result = json_encode(array('success'=>'DR details updated successfully'));
    		    echo $result;
    		    return false;
 			}
 			else{
 			    $result = json_encode(array('error'=>'Sorry something went wrong'));
			    echo $result;
			    return false;
 			}
 		}
	}
}
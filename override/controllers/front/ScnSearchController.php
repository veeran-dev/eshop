<?php
class ScnSearchControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		$start_memory = memory_get_usage();
	
		$type=$_GET['type'];
		$case=$_POST['case'];
		$vendorId=$_POST['vendorId'];
		$categoryId=$_POST['categoryId'];
		$brandId=$_POST['brandId'];

		if($type==1)// search for product
		{
			$productName=$_GET['q'];
			$getProduct=ScnVendorInfo::getProduct($productName);
		}
		else if($type==2)// search for vendor
		{
			
			$vendorName=$_GET['q'];
			$getVendor=ScnVendorInfo::getVendor($vendorName);
		}
		else if($type==3)// search for category
		{
			
			$categoryName=$_GET['q'];
			$getCategory=ScnVendorInfo::getCategory($categoryName);
		}
		else if($type==4)// search for brand
		{
			
			$brandName=$_GET['q'];
			$getCategory=ScnVendorInfo::getManufacture($brandName);
		}

		if($case==1)// get products for that brand
		{
			$result=ScnVendorInfo::getManufacturerProducts($brandId);
						echo Tools::jsonEncode($result);
		}
		else if($case==2)// get products for that category
		{
			 
			$category=new Category($categoryId);
			//$category->id=$categoryId;
 			$getTotalProducts=$category->getCategoryProductVendorMapping($categoryId,true);
 			if($getTotalProducts>300)
			{
				echo 1;
			}
			else
			{
				 
			$getCategoryProducts=$category->getCategoryProductVendorMapping($categoryId,false);
 			echo Tools::jsonEncode($getCategoryProducts);
			}
		}
		else if($case==3)// get address and poc for vendor
		{
			$getVendorAddressPoc=ScnVendorInfo::getVendorAddressPoc($vendorId);
		}
	}
}
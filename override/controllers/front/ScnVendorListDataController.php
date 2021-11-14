<?php 
class ScnVendorListDataControllerCore extends BackController
{
	public function ajaxReturn()
	{	 
		$type = $_POST['type'];
		$vendorId = $_POST['vendorId'];
		$addressId = $_POST['addressId'];
		$poc = $_POST['poc'];
		$language = $_POST['language'];
		
		$pocName = $_POST['pocName'];
		$designation = $_POST['designation'];
		$pocMobile1 = $_POST['pocMobile1'];
		$pocMobile2 = $_POST['pocMobile2'];
		$pocEmail = $_POST['pocEmail'];
		$pocSmartPhone = $_POST['pocSmartPhone'];
		$pocComment = $_POST['pocComment'];
		$defaultPoc = $_POST['defaultPoc'];
		
		
		
		/*Vendor Bank Details*/
		$bankName = $_POST['bankName'];
		$bankBranch = $_POST['bankBranch'];
		$bankAddress = $_POST['bankAddress'];
		$accountName = $_POST['accountName'];
		$accountType = $_POST['accountType'];
		$accountNumber = $_POST['accountNumber'];
		$ifsccode = $_POST['ifsccode'];
		$selectVendor = $_POST['selectVendor'];
		$vendorAddress= $_POST['vendorAddress'];
		$bankId = $_POST['bankId'];
 		
 		/*to get all the vendor list*/
		if($type==1)
		{
 			$vendorDetails=array();
			$vendor_list =  ScnVendorInfo::getVendorList();
			$paymentMode = ScnVendorInfo::getPaymentMode();
			$centres=FulfillmentCentre::getAllFCentres();
			array_push($vendorDetails,$vendor_list,$paymentMode,$centres);
			echo Tools::jsonEncode($vendorDetails);
			
		}
		/*to delete particular vendor*/
		if($type==2)
		{
			$deletVendor = ScnVendorInfo::deletVendor($vendorId);
			echo $vendor_list;
		}
		/*to get all the  address for particular vendor*/
		if($type==3)
		{
			$getVendorAddress =  ScnVendorInfo::getVendorAddress($vendorId);
			echo Tools::jsonEncode($getVendorAddress);
		}
		/*to get particular address fore vendor*/
		if($type==4)
		{
			$getAddress = ScnVendorInfo::getAddress($addressId,$vendorId);
			echo Tools::jsonEncode($getAddress);
		}
		/*TO get all the poc According to that vendor*/
		if($type==5)
		{
			$getVendorPocDetail=array();
			$getVendorPoc =  ScnVendorInfo::getVendorPOC($vendorId);
			$getAddress=ScnVendorInfo::getVendorAddress($vendorId);
			array_push($getVendorPocDetail,$getVendorPoc,$getAddress);
			echo Tools::jsonEncode($getVendorPocDetail);
		}
		/*To get particualr POC details*/
		if($type==6)
		{
			$pocDetails=array();
			$getPOC = ScnVendorInfo::getPOCDetail($poc,$vendorId);
			$getPocLang = ScnVendorInfo::getPOCLang($poc);
			$getAddress=ScnVendorInfo::getVendorAddress($vendorId);
			array_push($pocDetails,$getPOC,$getPocLang,$getAddress);
			echo Tools::jsonEncode($pocDetails);
			
		}
		if($type==7)
		{
			$pocLang=ScnVendorInfo::addLang($poc,$language);
			echo Tools::jsonEncode($pocLang);
		}
		if($type==8)
		{
			$deletLang=ScnVendorInfo::deletePocLang($poc,$language);
			echo $deletLang;
		}
		if($type==9)
		{
 			$updatePOC=ScnVendorInfo::updateVendorPoc($pocName,$designation,$pocMobile1,$pocMobile2,0,$pocEmail,$pocSmartPhone,$pocComment,$poc,$addressId);
 			$defaultPocValueUpdate=ScnVendorInfo::defaultPoc($vendorId,$updatePOC);
			echo $defaultPocValueUpdate;
		}
		if($type==10)
		{
 			$vendorPocAdd=ScnVendorInfo::addVendorPoc($pocName,$designation,$pocMobile1,$pocMobile2,$pocLang,$pocEmail,$pocSmartPhone,$pocComment,$vendorId,$addressId);
			echo $vendorPocAdd;
			if($defaultPoc==1)
			{
				

				$defaultPocValueUpdate=ScnVendorInfo::defaultPoc($vendorId,$vendorPocAdd);
			}
 			$langId=explode(",",$language);
			for($i=0; $i<sizeof($langId);$i++)
			{
 				$langAdd=ScnVendorInfo::addLang($vendorPocAdd,$langId[$i]);
			}
 		}
		if($type==11)
		{
			$deletePoc=ScnVendorInfo::deleteVendorPoc($poc);
			echo $deletePoc;
		}
		if($type==12)
		{
			$getBank=array();
			$Bank=ScnVendorInfo::getBankName($vendorId);
			$getVendoraddress=ScnVendorInfo::getVendorAddress($vendorId);
			array_push($getBank,$Bank,$getVendoraddress);
			echo Tools::jsonEncode($getBank);
		}
		if($type==13)
		{
			$getBankDetails=array();
			$getBank=ScnVendorInfo::getBankDetails($bankId,$vendorId);
			$getVendoraddress=ScnVendorInfo::getVendorAddress($vendorId);
			array_push($getBankDetails,$getBank,$getVendoraddress);
			echo Tools::jsonEncode($getBankDetails);
		}
		if($type==14)// to save bank details for vendor
		{
 			$vendorBankDetails=ScnVendorInfo::updateBankDetails($bankId,$bankName,$bankBranch,$bankAddress,$accountName,$accountType,$accountNumber,$ifsccode,$selectVendor,$vendorAddress);
			echo $vendorBankDetails;
		}
		if($type==15)// to save bank details for vendor
		{
 			$deleteBankDetails=ScnVendorInfo::deleteBank($bankId);
			echo $deleteBankDetails;
		}
		if($type==16)
		{
			$addbankDetails=ScnVendorInfo::addBankDetails($bankName,$bankBranch,$bankAddress,$accountName,$accountType,$accountNumber,$ifsccode,$selectVendor,$vendorAddress);
 
			echo $addbankDetails;
		}
	}
}
 ?>
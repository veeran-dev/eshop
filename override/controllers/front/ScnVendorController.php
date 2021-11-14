<?php
class ScnVendorControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		/*Vendor Details*/
		$type = $_POST['type'];
		$vendorName = $_POST['vendorName'];
		$gstNo = Tools::getValue('gstNo');
		$website = $_POST['website'];
		$creditDays = $_POST['creditDays'];
		$fc = $_POST['fc'];
		$paymentMode = $_POST['paymentMode'];
		$replacement = $_POST['replacement'];
		$delivery = $_POST['delivery'];
		$vendorComment = $_POST['vendorComment'];
		$vendorId = $_POST['vendorId'];
		$phoneNo = $_POST['phoneNo'];
		$panNo = $_POST['panNo'];

		/*Vendor Address Details*/
		$addressAlise = $_POST['addressAlise'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode'];
		$landmark = $_POST['landmark'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$workingHours = $_POST['workingHours'];
		$workingDays = $_POST['workingDays'];
		$addressComment = $_POST['addressComment'];
		$defaultAddress = $_POST['defaultAddress'];
		$addressdelivery = $_POST['addressDelivery'];
		$addressId = $_POST['addressId'];

		/*Vendor Poc Details*/
		$pocName = $_POST['pocName'];
		$designation = $_POST['designation'];
		$pocMobile1 = $_POST['pocMobile1'];
		$pocMobile2 = $_POST['pocMobile2'];
		$pocLang = $_POST['pocLang'];
		$pocEmail = $_POST['pocEmail'];
		$pocSmartPhone = $_POST['pocSmartPhone'];
		$pocComment = $_POST['pocComment'];
		$pocId = $_POST['pocId'];
		$defaultPoc = $_POST['defaultPoc'];
		$languagesId = $_POST['languages'];
		$pocAddress = $_POST['pocAddress'];
		
		/*Vendor Bank Details*/
		$bankName = $_POST['bankName'];
		$bankBranch = $_POST['bankBranch'];
		$bankAddress = $_POST['bankAddress'];
		$accountName = $_POST['accountName'];
		$accountType = $_POST['accountType'];
		$accountNumber = $_POST['accountNumber'];
		$ifsccode = $_POST['ifsccode'];
		$selectVendor = $_POST['selectVendor'];
		$vendorAddress = $_POST['vendorAddress'];

		if($type == 1)// to add vendor details
		{
			$vendor = new ScnVendorInfo();
			$vendor->name = $vendorName;
			$vendor->gst = $gstNo;
			$vendor->website = $website;
			$vendor->credit_days = $creditDays;
			$vendor->id_fulfillment_centre = $fc;
			$vendor->id_payment = $paymentMode;
			$vendor->replacement = $replacement;
			$vendor->comments = $vendorComment;
			$vendor->delivery = $delivery;
			$vendor->pan = $panNo;
			$vendor->phone = $phoneNo;
			$vendor->date_add = date('Y-m-d H:i:s');
			if ($vendor_added = $vendor->addVendor()) {
				echo $vendor_added;
			}	
		}
		if($type == 2)// to update vendor details
		{
			$vendor = new ScnVendorInfo();
			$vendor->name = $vendorName;
			$vendor->gst = $gstNo;
			$vendor->website = $website;
			$vendor->credit_days = $creditDays;
			$vendor->id_fulfillment_centre = $fc;
			$vendor->id_payment = $paymentMode;
			$vendor->replacement = $replacement;
			$vendor->comments = $vendorComment;
			$vendor->delivery = $delivery;
			$vendor->pan = $panNo;
			$vendor->phone = $phoneNo;
			$vendor->id = $vendorId;
			if ($vendor_updated = $vendor->updateVendor()) {
				echo $vendor_updated;
			}					
		}
		if($type==3)// to add vendor address
		{
			$vendorAddressAdd=ScnVendorInfo::addVendorAddress($addressAlise,$address,$city,$state,$country,$pincode,$landmark,$phone,$fax,$workingHours,$addressdelivery,$workingDays,$addressComment,$vendorId);
			echo $vendorAddressAdd;
			if($defaultAddress==1)
			{
				

				$defaultValueUpdate=ScnVendorInfo::defaultAddress($vendorId,$vendorAddressAdd);
			}
			
		}
		if($type==4)// to update vendor address
		{
				$vendorAddressUpdate=ScnVendorInfo::updateVendorAddress($addressAlise,$address,$city,$state,$country,$pincode,$landmark,$phone,$fax,$workingHours,$addressdelivery,$workingDays,$addressComment,$vendorId,$addressId);
				echo $vendorAddressUpdate;
		if($defaultAddress==1)
			{
				$defaultValueUpdate=ScnVendorInfo::defaultAddress($vendorId,$vendorAddressUpdate);
			}	
		}
		if($type==5)// to delete vendor address
		{
			$vendorAddressDelete=ScnVendorInfo::deleteVendorAddress($addressId);
		}
		if($type==6)// to add vendor poc
		{
			
			$vendorPocAdd=ScnVendorInfo::addVendorPoc($pocName,$designation,$pocMobile1,$pocMobile2,$pocLang,$pocEmail,$pocSmartPhone,$pocComment,$vendorId,$pocAddress);
			echo $vendorPocAdd;
			if($defaultPoc==1)
			{
				

				$defaultPocValueUpdate=ScnVendorInfo::defaultPoc($vendorId,$vendorPocAdd);
			}
			foreach($languagesId AS $languageId)
				{

					$langAdd=ScnVendorInfo::addLang($vendorPocAdd,$languageId);
				}
		}
		if($type==7)// to update vendor poc
		{
			
			$vendorPocUpdate=ScnVendorInfo::updateVendorPoc($pocName,$designation,$pocMobile1,$pocMobile2,$pocLang,$pocEmail,$pocSmartPhone,$pocComment,$pocId,$pocAddress);
			echo $vendorPocUpdate;
			if($defaultPoc==1)
			{
				$defaultPocValueUpdate=ScnVendorInfo::defaultPoc($vendorId,$vendorPocUpdate);
			}
			foreach($languagesId AS $languageId)
				{
					$langAdd=ScnVendorInfo::addLang($vendorPocUpdate,$languageId);
				}
		}
		if($type==8)// to delete vendor poc
		{
			$vendorPocDelete=ScnVendorInfo::deleteVendorPoc($pocId);
		}
		if($type==9)// to map vendor product
		{
		
			$data=$_POST['data'];
			$vendorProductMap=ScnVendorInfo::mapMultipleProducts($data);
			
		}
		if($type==10)// to map vendor product by brand
		{
			$data=$_POST['data'];
			$vendorProductMap=ScnVendorInfo::mapVendorProduct($data);
		}
		if($type==11)// to get  address for vendor poc
		{
			$getVendorAddress=ScnVendorInfo::getVendorAddress($vendorId);
			echo Tools::jsonEncode($getVendorAddress);
		}
		if($type==12)// to map vendor product by category
		{
			$data=$_POST['data'];
			$categoryId=$_POST['categoryId'];
			$vendorProductMap=ScnVendorInfo::mapVendorProduct($data);
		}
		if($type==13)// to save bank details for vendor
		{
 			$vendorBankDetails=ScnVendorInfo::addBankDetails($bankName,$bankBranch,$bankAddress,$accountName,$accountType,$accountNumber,$ifsccode,$selectVendor,$vendorAddress);
		}
		
	}
}
<?php
class DashCustomerReportControllerCore extends DashController
{
	
	public function ajaxReturn()
	{
		$invoice=array();
		$category=array();
		$topProduct=array();
		$id_customer=$_POST['id_customer'];
		$invoice=$this->getOrderDetailInvoice($id_customer,"-invoice");
		$category=$this->getOrderDetailCategory($id_customer,"-category");
		$topProduct=$this->getOrderDetailTopProduct($id_customer,"-top-product");
		$start_memory = memory_get_usage();
		$result=array();
		array_push($result,$invoice,$category,$topProduct);
		echo Tools::jsonEncode($result);
		$logger = new FileLogger();
	$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
	$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	

	
	}
	public function getOrderDetailInvoice($id_customer,$type)
	{	$values=array();
		$file = fopen("dash/report-files/monthly/".$id_customer.$type.".csv", "r");
		while(!feof($file))//read the file till end of the line
		{
		$line = fgets($file);//get each line of a file
		$values[]=explode(";",str_replace("\r\n","",$line));//separate each word in a line by space using explode function
		}
		return $values;
	}
	public function getOrderDetailCategory($id_customer,$type)
	{
		$values=array();
		$file = fopen("dash/report-files/category/".$id_customer.$type.".csv", "r");
		while(!feof($file))//read the file till end of the line
		{
		$line = fgets($file);//get each line of a file
		$values[]=explode(";",str_replace("\r\n","",$line));//separate each word in a line by space using explode function
		}
		return $values;
	}
	public function getOrderDetailTopProduct($id_customer,$type)
	{
		$values=array();
		$file = fopen("dash/report-files/top/".$id_customer.$type.".csv", "r");
		while(!feof($file))//read the file till end of the line
		{
		$line = fgets($file);//get each line of a file
		$values[]=explode(";",str_replace("\r\n","",$line));//separate each word in a line by space using explode function
		}
		return $values;
	}
}
?>
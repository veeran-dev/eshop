<?php
/*
By Karthik R
Kobster.com 2012-2016
*/

class DeliveryReportControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		global $smarty;

		$type = Tools::getValue('type');
		
		if($type == 0)
		{
			$result = self::getMiniDeliveryReport(date('Y-m-01', strtotime(date('Y-m-d H:i:s'))), date('Y-m-t', strtotime(date('Y-m-d H:i:s'))));
			$smarty->assign(array('result' => $result));
			$smarty->display('scn/scn-delivery-report.tpl');
		}
		
		if($type == 1)
		{
			$from_date = Tools::getValue('from_date');
			$to_date = Tools::getValue('to_date');
			$result = self::getMiniDeliveryReport(date("Y-m-d", strtotime($from_date)), date("Y-m-d", strtotime($to_date)));
			$smarty->assign(array('result' => $result));
			$smarty->display('scn/scn-delivery-report.tpl');
		}
	}
	
	public function getMiniDeliveryReport($from_date, $to_date)
	{		
		$sqlQuery = "SELECT No.id_fulfillment_centre, No.fc, (No.nos + Yes.yeses) as total, No.nos, Yes.yeses  
						FROM (
								SELECT id_fulfillment_centre, fc, Success, count(*) as nos 
								FROM (
										SELECT fc.id_fulfillment_centre, fc.city_name AS FC, 
										IF(delivered.date_add <= concat_ws(' ', DATE(ADDDATE(placed.date_add, (CASE 
																												WHEN DAYOFWEEK(placed.date_add) = 7 THEN 2
																												WHEN DATE_FORMAT(placed.date_add, '%H:%i:%s') > '12:00:00' THEN 2
																												ELSE 1
																											  END))), '22:00:00'), 'Yes', 'No') as Success
											FROM (SELECT * FROM `kob_order_history` placed WHERE placed.`id_order_state` = 22 ORDER BY placed.`id_order_history` DESC) AS placed, 
											 	 (SELECT * FROM `kob_order_history` delivered WHERE delivered.`id_order_state` = 5 ORDER BY delivered.`id_order_history` DESC) AS delivered, 
												 `kob_orders` orders, 
												 `kob_fulfillment_centre` fc,
												 `kob_customer` cust
											WHERE delivered.id_order = placed.id_order 
											AND placed.id_order_state=22 
											AND delivered.id_order_state=5 
											AND orders.id_order=placed.id_order
											AND orders.id_fc = fc.id_fulfillment_centre
											AND orders.id_customer = cust.id_customer
 											AND cust.id_buyer = 3
											AND DATE(placed.date_add) BETWEEN '".$from_date."' AND '".$to_date."'
											GROUP BY orders.id_order) AS result
											
								WHERE result.success='No'
								GROUP BY fc, Success) AS No,
								(
								SELECT id_fulfillment_centre, fc, Success, count(*) as yeses 
									FROM (
										SELECT fc.id_fulfillment_centre, fc.city_name AS FC, 
										IF(delivered.date_add <= concat_ws(' ', DATE(ADDDATE(placed.date_add, (CASE 
																												WHEN DAYOFWEEK(placed.date_add) = 7 THEN 2
																												WHEN DATE_FORMAT(placed.date_add, '%H:%i:%s') > '12:00:00' THEN 2
																												ELSE 1
																											  END))), '22:00:00'), 'Yes', 'No') as Success
										FROM (SELECT * FROM `kob_order_history` placed WHERE placed.`id_order_state` = 22 ORDER BY placed.`id_order_history` DESC) AS placed, 
											 (SELECT * FROM `kob_order_history` delivered WHERE delivered.`id_order_state` = 5 ORDER BY delivered.`id_order_history` DESC) AS delivered, 
											 `kob_orders` orders, 
											 `kob_fulfillment_centre` fc,
											 `kob_customer` cust
										WHERE delivered.id_order = placed.id_order 
											  AND placed.id_order_state=22 
											  AND delivered.id_order_state=5 
											  AND orders.id_order=placed.id_order
											  AND orders.id_fc = fc.id_fulfillment_centre
											  AND orders.id_customer = cust.id_customer
 											  AND cust.id_buyer = 3
											  AND DATE(placed.date_add) BETWEEN '".$from_date."' AND '".$to_date."'
											  GROUP BY orders.id_order) AS result
									WHERE result.success='Yes'
									GROUP BY fc, Success) As Yes
					WHERE No. id_fulfillment_centre = Yes. id_fulfillment_centre";
		
		$result = Db::getInstance()->ExecuteS($sqlQuery);
		
		if($result)
		{
			return $result;
		}
		else
		{
			return 0;
		}
	}
	
	public function generateReport()
	{	
		$from_date = Tools::getValue('from_date');
		$to_date = Tools::getValue('to_date');
		$id_fc = Tools::getValue('id_fc');

		$sqlQuery = "SELECT orders.id_order, cust.firstname, placed.date_add as placed_date, delivered.date_add as delivered_date,
										IF(delivered.date_add <= concat_ws(' ', DATE(ADDDATE(placed.date_add, (CASE 
																												WHEN DAYOFWEEK(placed.date_add) = 7 THEN 2
																												WHEN DATE_FORMAT(placed.date_add, '%H:%i:%s') > '12:00:00' THEN 2
																												ELSE 1
																											  END)
																							)), '22:00:00'), 'Yes', 'No') as Success,
										fc.city_name AS FC
										FROM (SELECT * FROM `kob_order_history` placed WHERE placed.`id_order_state` = 22 ORDER BY placed.`id_order_history` DESC) AS placed, 
											 (SELECT * FROM `kob_order_history` delivered WHERE delivered.`id_order_state` = 5 ORDER BY delivered.`id_order_history` DESC) AS delivered, 
											 `kob_orders` orders, 
											 `kob_fulfillment_centre` fc,
											 `kob_customer` cust
										WHERE delivered.id_order = placed.id_order 
											  AND (placed.`id_order_state` = 22)
											  AND (delivered.`id_order_state` = 5)
											  AND orders.id_order=placed.id_order
											  AND orders.id_fc = fc.id_fulfillment_centre
											  AND DATE(placed.date_add) BETWEEN '". date("Y-m-d", strtotime($from_date) )."' AND '". date("Y-m-d", strtotime($to_date) )."'
											  AND fc.id_fulfillment_centre = ". $id_fc ."
											  AND orders.id_customer = cust.id_customer
 											  AND cust.id_buyer = 3 GROUP BY orders.id_order";
											  
		/** Include PHPExcel */
        require_once (_PS_ROOT_DIR_.'/classes/PHPExcel/Classes/PHPExcel.php');
        
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster.com")->setLastModifiedBy("Kobster.com")->setTitle("Ops Delivery Report")->setSubject("Ops Delivery Report")->setDescription("Ops Delivery Report")->setKeywords("Ops Delivery Report")->setCategory("Ops Delivery Report");
        
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
		//Write Data
		//Header
		$objPHPExcel->getActiveSheet()->setCellValue('A'.'1', "Order ID");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.'1', "Customer Name");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.'1', "Order Placed On");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.'1', "Order Delivered On");
		$objPHPExcel->getActiveSheet()->setCellValue('E'.'1', "On-Time?");
		$objPHPExcel->getActiveSheet()->setCellValue('F'.'1', "FC Name");
		
		$cols = array("A", "B", "C", "D", "E", "F");
		$result = Db::getInstance()->ExecuteS($sqlQuery);
		//echo sizeof($result);
		
		if($result)
		{
			$j = 2;
			foreach($result as $row)
			{
				$i = 0;
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['id_order']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['firstname']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['placed_date']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['delivered_date']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['Success']);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['FC']);
				$j++;
			}
		}
		
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $download_filename  = $id_fc . "-Ops-Performace-Report" . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
	}
}
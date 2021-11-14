<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

class FinanceProcurement
{
    
    public function downloadProcurementExcel()
    {
 
		$this->result_array = $this->financeProcurementPlan();
		//var_dump($result_array);
		$this->download_file();
        return;
    }
    public static function financeProcurementPlan($order_limit = Null)
	{
		if($order_limit !="")
			$order_limit = 'Limit 10';
		else
			$order_limit = '';
		return Db::getInstance()->ExecuteS('SELECT o.`id_order`, c.firstname,o.`total_paid`,o.`id_fc`, fc.city_name
																FROM `'._DB_PREFIX_.'orders` as o
																LEFT JOIN '._DB_PREFIX_.'customer as c on o.id_customer = c.id_customer 
																LEFT JOIN '._DB_PREFIX_.'fulfillment_centre as fc on fc.id_fulfillment_centre = o.id_fc
																LEFT JOIN '._DB_PREFIX_.'order_detail as od on o.id_customer = od.id_order
																LEFT JOIN '._DB_PREFIX_.'order_history AS oh ON o.id_order = oh.id_order
																where  	
																oh.id_Order_history IN (SELECT  MAX(oha.`id_order_history`)
																								FROM '._DB_PREFIX_.'order_history AS oha
																								WHERE o.id_order = oha.id_order
																								GROUP BY oha.id_order) 
																						AND  oh.`id_order_state` IN(18,19,21,22,24)GROUP BY o.id_order ORDER BY o.id_order DESC '.$order_limit.'');
	}
    public function download_file()
    {		
		//var_dump($this->result_array);
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        /** Include PHPExcel */
        require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster Tech Team")->setLastModifiedBy("Kobster Finance Team")->setTitle("Kobster Procurment Data")->setSubject("Kobster finance Procurement Plan")->setDescription("finance Procurement Plan kobster.com, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->setShowGridlines(false);
      //  $purchase_plan_array = $this->result_array;
		$purchase_plan_array = $this->result_array;		
		//$j_limit = 5;
		$cell_value =0;
		$cell_value++;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value.':D'.$cell_value)->applyFromArray(array(           
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )),
				'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF'),'size'=>16,'name' => 'Verdana'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F'))
				));
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Procurement Plan-finance");
		$cell_value++;
		 ###############################################################################
		 $objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value.':D'.$cell_value)->applyFromArray(array(
				'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF')),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN )),'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F'))));
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Order id")->setCellValue('B'.$cell_value, "UserName")->setCellValue('C'.$cell_value, "Fulfillment Center")->setCellValue('D'.$cell_value, "Value");
 		$cell_value++;
 		$i=0;
 		$logger = new FileLogger();
		$logger->setFilename('test.txt');
		$logger->logError("85");
 		for($k=0; $k<sizeof($purchase_plan_array); $k++ )
 		{
 			$logger->logError("---");
 			$id_order='';
 			$company='';
 			$fc = "";
 			$total_paid='';
 			if($purchase_plan_array[$i]['id_order'])
				$id_order =$purchase_plan_array[$i]['id_order'];
			 else
				 $id_order = "Other";			 
			 
			if($purchase_plan_array[$i]['firstname'])
				$company =$purchase_plan_array[$i]['firstname'];
			 else
				 $company = "---";
			 
 			if($purchase_plan_array[$i]['city_name'])
				$fc =$purchase_plan_array[$i]['city_name'];
			 else
				 $fc = "---";
			 
 			if($purchase_plan_array[$i]['total_paid'])
				$total_paid =$purchase_plan_array[$i]['total_paid'];
			 else
				 $total_paid = "---";

 			$objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value.':D'.$cell_value)->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
 			
			$objPHPExcel->getActiveSheet()->getStyle('D1:D256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
					
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, $id_order)->setCellValue('B'.$cell_value, $company)->setCellValue('C'.$cell_value, $fc)->setCellValue('D'.$cell_value, $total_paid);
			$i++;
			$cell_value++;
 		}
        
        ################################## /HEADER TABLE ################################
        
        
         // Set fills
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
         
        // Set autofilter
        // Always include the complete filter range!
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $download_filename  = "financeProcurementPlan.xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
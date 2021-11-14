<?php
class WaterDeliveryReport
{
    public function generateReport($id_group, $id_fc, $month, $year)
    {
 
        $this->id_group = $id_group;
        $this->id_fc = $id_fc;
        $this->month = $month;
        $this->year = $year;

        $logger = new FileLogger();
        $logger->setFilename("test.txt");
        $logger->logError("generateReport");
        
        $this->download_file();
        return;
    }
    
    private function download_file()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        /** Include PHPExcel */
        require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
        
        $logger = new FileLogger();
        $logger->setFilename("test.txt");
        $logger->logError("download_file result");   
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Elumalai Kaliyaperumal")->setLastModifiedBy("Pramoth Kumar")->setTitle("Kobster Quotation")->setSubject("Kobster Quotation")->setDescription("Original Quotation for kobster.com, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
         $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $column="";
    
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Company")->setCellValue('C1', "Alias")->setCellValue('D1', "Address")->setCellValue('E1', "Product")->setCellValue('F1', "Delivered")->setCellValue('G1', "Received")->setCellValue('H1', "Employee")->setCellValue('I1', "Date");
		  
        $result =  WaterDelivery::getAllCustomerOrders($this->id_group, $this->id_fc, $this->month, $this->year);
		
        $logger->logError($result);

         $original_array = array(
            '0',
            '1'
        );
		array_splice($original_array, 2, 0, $result);
		
		$i = 2;
		$j = 0;
		for ($i = $i; $i < sizeof($original_array); $i++) 
		{
			$total_product_price = $original_array[$i]['unit_price'] * $original_array[$i]['product_qty'];
			
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)->setCellValue('B' . $i, $original_array[$i]['company'])->setCellValue('C' . $i, $original_array[$i]['alias'])->setCellValue('D' . $i, $original_array[$i]['address_format'])->setCellValue('E' . $i, $original_array[$i]['product_name'])->setCellValue('F' . $i, $original_array[$i]['delivered'])->setCellValue('G' . $i,$original_array[$i]['empty'])->setCellValue('H' . $i, $original_array[$i]['employee'])->setCellValue('I' . $i,$original_array[$i]['date_add']);
		}
        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('CF000F');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $column="A1:I1";
        
        ################################## /HEADER TABLE ################################
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        // Set style for header row using alternative method
        $objPHPExcel->getActiveSheet()->getStyle($column)->applyFromArray(array(
            'font' => array(
                'bold' => false,
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'CF000F'
                ),
                'endcolor' => array(
                    'argb' => 'CF000F'
                )
            )
        ));
        $logger->logError("done with here");
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $download_filename  = "WaterDeliveryReport.xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
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

class PaymentRequestExcel
{
    
    public function __construct($id_request)
    {
        $this->id_request = $id_request;
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
        
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Elumalai Kaliyaperumal")->setLastModifiedBy("Pramoth Kumar")->setTitle("Kobster Quotation")->setSubject("Kobster Quotation")->setDescription("Original Quotation for kobster.com, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
         $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        		
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Name")->setCellValue('C1', "Amount")->setCellValue('D1', "Account Number")->setCellValue('E1', "IFSC Code")->setCellValue('F1', "Bank")->setCellValue('G1', "Branch");
		 
		if($this->id_request != "") {
            $result =  Db::getInstance()->ExecuteS('SELECT pr.*, v.`name` as vendor_name, emp.`firstname` as emp_first_name,
                                                emp.`lastname` as emp_last_name,fc.`city_name` as fc_city, va.`city` as vendor_city, vbd.*,
                                                pr.`date_add` as eq_date_add,pr.`date_upd` as req_date_upd
                                                FROM `'._DB_PREFIX_.'payment_request` pr
                                                LEFT JOIN `'._DB_PREFIX_.'vendor` v ON pr.`id_vendor` = v.`id_vendor`
                                                LEFT JOIN `'._DB_PREFIX_.'vendor_address` va ON v.`id_default_address` = va.`id_address`
                                                LEFT JOIN `'._DB_PREFIX_.'vendor_bank_details` vbd ON pr.`id_bank` = vbd.`id_bank`
                                                LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` fc ON v.`id_fulfillment_centre` = fc.`id_fulfillment_centre`
                                                LEFT JOIN `'._DB_PREFIX_.'employee` emp ON pr.`req_made_by` = emp.`id_employee`
                                                WHERE pr.`id_request` IN('.$this->id_request.') ORDER BY pr.`id_request` ASC');
        }
		
			 $original_array = array(
				'0',
				'1'
			);
			array_splice($original_array, 2, 0, $result);
			
			$i = 2;
			$j = 0;
			for ($i = $i; $i < sizeof($original_array); $i++) 
			{
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)->setCellValue('B' . $i, $original_array[$i]['account_name'])->setCellValue('C' . $i, $original_array[$i]['amount'])->setCellValue('D' . $i, $original_array[$i]['account_no'])->setCellValue('E' . $i,$original_array[$i]['ifsc_code'])->setCellValue('F' . $i, $original_array[$i]['bank_name'])->setCellValue('G' . $i, $original_array[$i]['branch']);
			}
		
		 

        
        ################################## /HEADER TABLE ################################
        
        
         // Set fills
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('CF000F');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        // Set autofilter
        // Always include the complete filter range!
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        // Set style for header row using alternative method
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(array(
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
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $download_filename  = $this->filename."_".$this->month_name.".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= payment-request-'.date("Y:m:d").'.xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
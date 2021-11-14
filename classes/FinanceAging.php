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

class FinanceAging 
{
    
    public function FinanceAging()
    {
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
        $objPHPExcel->getProperties()->setCreator("Kobster Tech Team")->setLastModifiedBy("Lakshmi.sg")->setTitle("Kobster Fpp")->setSubject("Kobster Fpp")->setDescription("Finance Pending Payment, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);

        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        
        $styleArrayTable = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'top' => array(     
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        
        ################################## HEADER TABLE #################################
        $objPHPExcel->getActiveSheet()->getStyle('B10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('C10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('D10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('E10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('F10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('G10')->applyFromArray($styleArrayTable);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B10', "Company")->setCellValue('C10', "0-30 Days")->setCellValue('D10', "30-60 Days")->setCellValue('E10', "60-90 Days")->setCellValue('F10', "90+ Days")->setCellValue('G10', "Total");
       
        $result_array   = Finance::agingData();
        $original_array = array('0','1','2','3','4','5','6','7','8','9','10');
        array_splice($original_array, 11, 0, $result_array);
        
        $i = 11;
        $j = 0;
                
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i.':B'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i.':C'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i.':D'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i.':E'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $i.':F'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i.':G'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        for ($i = $i; $i < sizeof($original_array); $i++) {            
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $original_array[$i]['name'])->setCellValue('C' . $i, $original_array[$i]['0-30'])->setCellValue('D' . $i, $original_array[$i]['30-60'])->setCellValue('E' . $i,$original_array[$i]['60-90'])->setCellValue('F' . $i, $original_array[$i]['90+'])->setCellValue('G' . $i, $original_array[$i]['Total']);
        }
        ################################## /HEADER TABLE ################################
        
        // Set page orientation and size
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        // Set fills
        $objPHPExcel->getActiveSheet()->getStyle('B10:G10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('B10:G10')->getFill()->getStartColor()->setARGB('CF000F');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);        
        
        // Set autofilter
        // Always include the complete filter range!
        //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        // Set style for header row using alternative method
        $objPHPExcel->getActiveSheet()->getStyle('B10:G10')->applyFromArray(array(
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
        
        ############################# HEADER TABLE #######################################
        
        $styleArrayDate = array(
            'font' => array(
                'bold' => false,
                'color' => array(
                    'rgb' => 'FFFFFF'
                ),
                'size' => 10,
                'name' => 'Verdana'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'CF000F'
                ),
                'endcolor' => array(
                    'rgb' => 'CF000F'
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('C1:C256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     
        $objPHPExcel->getActiveSheet()->getStyle('D1:D256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     
        $objPHPExcel->getActiveSheet()->getStyle('E1:E256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     
        $objPHPExcel->getActiveSheet()->getStyle('F1:F256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     
        $objPHPExcel->getActiveSheet()->getStyle('G1:G256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     

        $objPHPExcel->getActiveSheet()->setCellValue('B2', "Ageing Data");
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArrayDate);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Dated : " . date("Y/m/d"));
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArrayDate);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        ############################# /HEADER TABLE ######################################
        
       // Redirect output to a client's web browser (Excel2007)        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= FinanceAgingSheet.xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
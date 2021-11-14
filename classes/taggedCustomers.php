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

class TaggedCustomers 
{    
    public function getDownloadLink($content)
    {
        $this->download_file($content);
        return;
    }
    private function download_file($content)
    {
        error_reporting(E_ALL);
        /*ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');*/
        
        //define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        /** Include PHPExcel */
        require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Elumalai Kaliyaperumal")->setLastModifiedBy("Pramoth Kumar")->setTitle("Kobster Quotation")->setSubject("Kobster Quotation")->setDescription("Original Quotation for kobster.com, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product 
            .Based");
        
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $column="";
        
         $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Product ID")->setCellValue('C1', "Product Name")->setCellValue('D1', "Company")->setCellValue('E1', "Price Tax Excl")->setCellValue('F1', "Expires")->setCellValue('G1', "From")->setCellValue('H1', "To");

            //$logger = new FileLogger();
        //$logger->setFilename("test.txt");
        //$logger->logError("download file");
        //$logger->logError($content);
             $original_array = array(
                '0',
                '1'
            );
            array_splice($original_array, 2, 0, $content);
            
            $i = 2;
            $j = 0;
            for ($i = $i; $i < sizeof($original_array); $i++) 
            {               
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)->setCellValue('B' . $i, $original_array[$i]['id_product'])->setCellValue('C' . $i, $original_array[$i]['product_name'])->setCellValue('D' . $i, $original_array[$i]['company'])->setCellValue('E' . $i, $original_array[$i]['price_tax_excl'])->setCellValue('F' . $i, $original_array[$i]['expires'])->setCellValue('G' . $i, $original_array[$i]['from'])->setCellValue('H' . $i, $original_array[$i]['to']);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('CF000F');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $column="A1:H1";
        
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
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);

        $download_filename  = "ProductChange-".date("Y-m-d h:i:sa").".xlsx";
        //$logger->logError($download_filename);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('./productChangeRecords/'.$download_filename);

        return 'https://www.kobster.online/kobster_admin/productChangeRecords/'.$download_filename;
    }
}
?> 
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

class CortexQuotationExcel
{
    
    public function __construct($id_quotation)
    {
        $this->id_quotation = $id_quotation;
        $this->download_file();
    }
    
    private function download_file()
    {
        // error_reporting(E_ALL);
        // ini_set('display_errors', TRUE);
        // ini_set('display_startup_errors', TRUE);
        // date_default_timezone_set('Europe/London');
        
        // define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        /** Include PHPExcel */
        require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
        
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Elumalai Kaliyaperumal")->setLastModifiedBy("Pramoth Kumar")->setTitle("Kobster Quotation")->setSubject("Kobster Quotation")->setDescription("Original Quotation for kobster.com, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
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
        $objPHPExcel->getActiveSheet()->getStyle('H10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->setCellValue('B10', "S.No.")->setCellValue('C10', "Product Description")->setCellValue('D10', "Product Code")->setCellValue('E10', "Unit Price (Rs.)")->setCellValue('F10', "GST %")->setCellValue('G10', "Remarks")->setCellValue('H10', "Valid Till");
        
        
        $result_array = Db::getInstance()->ExecuteS("SELECT v.*,vp.`id_product` AS product_id,vp.`product_price` AS price,vp.`remarks` AS remarks,DATE_FORMAT(vp.`to`, '%d-%m-%Y') as expire,kpl.`name` AS product_name,p.reference AS product_code 
                                                     FROM " . _DB_PREFIX_ . "quotation AS v 
                                                     LEFT JOIN " . _DB_PREFIX_ . "quotation_detail AS vp ON vp.`id_quotation`=v.`id_quotation` 
                                                     LEFT JOIN " . _DB_PREFIX_ . "product_lang AS kpl ON kpl.`id_product` = vp.`id_product` 
                                                     LEFT JOIN " . _DB_PREFIX_ . "product AS p ON p.id_product = vp.id_product
                                                     WHERE vp.`id_quotation`=" . $this->id_quotation . " 
                                                     GROUP BY kpl.`id_product` ORDER BY `id_quotation` ASC");

        $quotation = new ScnQuotation((int)($this->id_quotation));
        $regions = $quotation->getRegions();
        $company = new Group((int)($quotation->id_group));

        for($p = 0; $p < sizeof($result_array); $p++){
           $result_array[$p]['tax_value'] = $quotation->getProductTaxRate((int)$result_array[$p]['product_id']);
        }

        $original_array = array(
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10'
        );

        array_splice($original_array, 11, 0, $result_array);
        
        $i = 11;
        $j = 0;
        for ($i = $i; $i < sizeof($original_array); $i++) {
            
            if ($original_array[$i]['remarks'] == undefined) {
                $remarks = "--";
            } else {
                $remarks = $original_array[$i]['remarks'];
            }

            if($original_array[$i]['tax_value'] != "NA")
                $original_array[$i]['tax_value'] = $original_array[$i]['tax_value']."%";
            
            $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArrayTable);

            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode('0.00');
            
            $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, ++$j)->setCellValue('C' . $i, $original_array[$i]['product_name'])->setCellValue('D' . $i, $original_array[$i]['product_code'])->setCellValue('E' . $i,$original_array[$i]['price'])->setCellValue('F' . $i, $original_array[$i]['tax_value'])->setCellValue('G' . $i, $remarks)->setCellValue('H' . $i,$original_array[$i]['expire']);
        }
        ################################## /HEADER TABLE ################################
        
        
        // Set page orientation and size
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        // Set fills
        $objPHPExcel->getActiveSheet()->getStyle('B10:H10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('B10:H10')->getFill()->getStartColor()->setARGB('CF000F');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(57.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14.86);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16.00);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        
        // Set autofilter
        // Always include the complete filter range!
        //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        // Set style for header row using alternative method
        $objPHPExcel->getActiveSheet()->getStyle('B10:H10')->applyFromArray(array(
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
        
        $objPHPExcel->getActiveSheet()->getStyle('B4:G4')->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'CF000F'
                ),
                'endcolor' => array(
                    'rgb' => 'CF000F'
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        
        // Add a drawing to the worksheet
        $objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:F2');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:G3');

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(dirname(__FILE__) . '/PHPExcel/img/logo_invoice.jpg');
        $objDrawing->setCoordinates('B1');
        $objDrawing->setHeight(75);
        $objDrawing->setWidth(170);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
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
        
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Dated : " . date("Y/m/d"));
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArrayDate);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        ############################# /HEADER TABLE ######################################
        
        ############################# DETAIL PAGE REPORT #####################################
        
        $objPHPExcel->getActiveSheet()->mergeCells('B4:G4');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', "www.kobster.com - Your Single Source Provider For All Your Business Needs");
        $objPHPExcel->getActiveSheet()->getStyle('B4:G4')->getFont()->setName('Verdana');
        $objPHPExcel->getActiveSheet()->getStyle('B4:G4')->getFont()->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('B4:G4')->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('B4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        ############################# /DETAIL PAGE REPORT ####################################
        
        $styleArray = array(
            'font' => array(
                'bold' => false,
                'color' => array(
                    'rgb' => 'CF000F'
                ),
                'size' => 13,
                'name' => 'Verdana',
                'italic' => 10,
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );

        $styleArrayContact = array(
            'font' => array(
                'bold' => false,
                'color' => array(
                    'rgb' => 'CF000F'
                ),
                'size' => 10,
                'name' => 'Verdana',
                'italic' => 10
            )
        );

        $objPHPExcel->getActiveSheet()->mergeCells('B5:G5');
        $objPHPExcel->getActiveSheet()->mergeCells('B6:G6');
        $objPHPExcel->getActiveSheet()->mergeCells('B7:G7');
        $objPHPExcel->getActiveSheet()->mergeCells('B8:G8');
        $objPHPExcel->getActiveSheet()->mergeCells('B9:G9');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', "Price List");
        $objPHPExcel->getActiveSheet()->setCellValue('B6', "Company Name : ".$company->name[1]);
        $objPHPExcel->getActiveSheet()->setCellValue('B7', "Contact Person / Mobile : ");
        $objPHPExcel->getActiveSheet()->setCellValue('B8', "");
        $objPHPExcel->getActiveSheet()->setCellValue('B9', "Quotation Name : " . $original_array[11]['quote_name']);
        $objPHPExcel->getActiveSheet()->getStyle('B5:G5')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B6:G6')->applyFromArray($styleArrayContact);
        $objPHPExcel->getActiveSheet()->getStyle('B7:G7')->applyFromArray($styleArrayContact);
        $objPHPExcel->getActiveSheet()->getStyle('B9:G9')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B9:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => 'CF000F'
                ),
                'size' => 9,
                'name' => 'Verdana'
            )
        );
        
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $i . ':' . 'G' . $i);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 1) . ':' . 'G' . ($i + 1));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 1), "Note : Unit price is exclusive of TAX");
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 2) . ':' . 'G' . ($i + 2));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), "The price of paper will get revised from time to time.");
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 1) . ':' . 'G' . ($i + 1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 1) . ':' . 'G' . ($i + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 2) . ':' . 'G' . ($i + 2))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 2) . ':' . 'G' . ($i + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 3) . ':' . 'G' . ($i + 3));
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 4) . ':' . 'G' . ($i + 4));
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 5) . ':' . 'G' . ($i + 5));
        
        $styleArrayMinimum = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => 'CF000F'
                ),
                'size' => 8,
                'name' => 'Verdana'
            )
        );
        
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 6) . ':' . 'G' . ($i + 6));
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 7) . ':' . 'G' . ($i + 7));
        $objPHPExcel->getActiveSheet()->getRowDimension($i + 6)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 6) . ':' . 'G' . ($i + 6))->applyFromArray($styleArrayMinimum);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 6) . ':' . 'G' . ($i + 6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => 'CF000F'
                ),
                'size' => 9,
                'name' => 'Verdana'
            )
        );
        
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 8) . ':' . 'G' . ($i + 8));
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 9) . ':' . 'G' . ($i + 9));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 8), "Thank you for your business!");
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 8) . ':' . 'G' . ($i + 8))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 8) . ':' . 'G' . ($i + 8))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 10) . ':' . 'G' . ($i + 10));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 10), " If you have any questions concerning this Price List, please contact at the below address:-");
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 10) . ':' . 'G' . ($i + 10))->applyFromArray($styleArrayMinimum);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 10) . ':' . 'G' . ($i + 10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 11) . ':' . 'G' . ($i + 11));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 11), "Head Office: # 51-B, Mount Poonamallee Main Road, ST Thomas Mount, Chennai - 600016");
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 11) . ':' . 'G' . ($i + 11))->applyFromArray($styleArrayMinimum);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 11) . ':' . 'G' . ($i + 11))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 12) . ':' . 'G' . ($i + 12));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 12), " Phone: 1800 121 0405, E-mail: sales@kobster.com, Website: www.kobster.com");
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 12) . ':' . 'G' . ($i + 12))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 12) . ':' . 'G' . ($i + 12))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 13) . ':' . 'G' . ($i + 13));
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 14) . ':' . 'G' . ($i + 14));
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($i + 15) . ':' . 'G' . ($i + 15));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 13), "Branch Address:- Chennai: Guindy & Parrys Corner. Bangalore: HSR Layout- 560102");
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 13) . ':' . 'G' . ($i + 13))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 13) . ':' . 'G' . ($i + 13))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 15) . ':' . 'G' . ($i + 15))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'CF000F'
                ),
                'endcolor' => array(
                    'rgb' => 'CF000F'
                )
            )
        ));
        
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 15), "www.kobster.com - Your Single Source Provider For All Your Business Needs");
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 15) . ':' . 'G' . ($i + 15))->getFont()->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 15) . ':' . 'G' . ($i + 15))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Redirect output to a client's web browser (Excel2007)
        $str_to_array = explode(' ', $quotation->quote_name);
        $filename  = $this->id_quotation."-".$company->name[1]."( ".$regions." )-".join('',$str_to_array).".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('./../quotationOriginal/'.$filename);
        // return $filename;
        exit;
    }
}
?> 
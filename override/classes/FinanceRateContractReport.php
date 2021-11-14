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

class FinanceRateContractReport
{
    
    public function __construct($status, $id_group)
    {   
        $this->status = $status;
        $this->id_group = $id_group;
        $this->download_file($this->status, $this->id_group);
        return;
    }
    
    private function download_file($status = false, $id_group = null)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        //Active sheet
        $activeSheet = $objPHPExcel->getActiveSheet();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster Tech Team")->setLastModifiedBy("Lakshmi.sg")->setTitle("Kobster Fpp")->setSubject("Kobster Fpp")->setDescription("Finance Rate Contract, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
        $activeSheet->getPageMargins()->setTop(1);
        $activeSheet->getPageMargins()->setRight(0.75);
        $activeSheet->getPageMargins()->setLeft(0.75);
        $activeSheet->getPageMargins()->setBottom(1);

        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setFitToPage(true);

        // Set style for header row using alternative method
        $activeSheet->getStyle('A1:V1')->applyFromArray(array(
            'font' => array(
                'bold' => false, 
                'color' => array('rgb' => 'FFFFFF')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_NONE)
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startcolor' => array('argb' => 'CF000F'),
                'endcolor' => array('argb' => 'CF000F')
            ),
            'borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
                
        $activeSheet->setCellValue('A1', "Comany ID")
            ->setCellValue('B1', "Company Name")
            ->setCellValue('C1', "User ID")
            ->setCellValue('D1', "User Name")
            ->setCellValue('E1', "Product Code")
            ->setCellValue('F1', "Product ID")
            ->setCellValue('G1', "Product Name")
            ->setCellValue('H1', "HSN Code")
            ->setCellValue('I1', "Brand")
            ->setCellValue('J1', "L0")
            ->setCellValue('K1', "L1")
            ->setCellValue('L1', "L2")
            ->setCellValue('M1', "L3")
            ->setCellValue('N1', "L4")
            ->setCellValue('O1', "Unit Price(Tax Excl.)")
            ->setCellValue('P1', "GST %")
            ->setCellValue('Q1', "MRP")
            ->setCellValue('R1', "Buying Price(Tax Excl.)")
            ->setCellValue('S1', "Location Availabe")
            ->setCellValue('T1', "Location Buying Price(Tax Excl.)")
            ->setCellValue('U1', "Contract Expiry Date")
            ->setCellValue('V1', "Last Updated");

        if(isset($status)) {
            if($status == 1) {
                $sql_append = "AND (sp.`to` = '0000-00-00 00:00:00' OR NOW() <= sp.`to`)";
            }
            else if($status == 2) {
                $sql_append = "AND (sp.`to` != '0000-00-00 00:00:00' OR NOW() >= sp.`to`)";
            }
        }
        
        $sql = "SELECT sp.`id_group` AS 'Company ID',
                    IFNULL(gl.`name`, '') AS 'Company Name',
                    IF(sp.`id_customer` = 0, '', sp.`id_customer`) AS 'Customer ID', 
                    IFNULL(cust.`firstname`, '') AS 'Customer Name',
                    IF (c5.`level_depth` = 1, cl5.`name`, IF(c4.`level_depth`=1, cl4.`name`, IF(c3.`level_depth`=1, cl3.`name`, IF(c2.`level_depth`=1, cl2.`name`, IF(c1.`level_depth`=1, cl1.`name`, ''))))) AS 'L0',
                    IF (c5.`level_depth` = 2, cl5.`name`, IF(c4.`level_depth`=2, cl4.`name`, IF(c3.`level_depth`=2, cl3.`name`, IF(c2.`level_depth`=2, cl2.`name`, IF(c1.`level_depth`=2, cl1.`name`, ''))))) as 'L1',
                    IF (c5.`level_depth` = 3, cl5.`name`, IF(c4.`level_depth`=3, cl4.`name`, IF(c3.`level_depth`=3, cl3.`name`, IF(c2.`level_depth`=3, cl2.`name`, IF(c1.`level_depth`=3, cl1.`name`, ''))))) as 'L2',
                    IF (c5.`level_depth` = 4, cl5.`name`, IF(c4.`level_depth`=4, cl4.`name`, IF(c3.`level_depth`=4, cl3.`name`, IF(c2.`level_depth`=4, cl2.`name`, IF(c1.`level_depth`=4, cl1.`name`, ''))))) as 'L3',
                    IF (c5.`level_depth` = 5, cl5.`name`, IF(c4.`level_depth`=5, cl4.`name`, IF(c3.`level_depth`=5, cl3.`name`, IF(c2.`level_depth`=5, cl2.`name`, IF(c1.`level_depth`=5, cl1.`name`, ''))))) as 'L4',
                    prod.`reference` as 'Product Code', 
                    prod.`hsn_code` AS 'HSN Code',
                    prod.`id_product` as 'Product ID', 
                    pl.`name` as 'Product Name',
                    man.`name` as 'Brand Name',
                    ROUND(prod.`wholesale_price`, 2) as 'Buying Price(Tax Excl.)',
                    ROUND(sp.`price`, 2) as 'Unit Price(Tax Excl.)',
                    IFNULL(IF(pzm.`zone_id` = 0, 'PAN India', fc.`city_name`), '') AS 'Location Availabe',
                    IFNULL(zp.`price`, '') AS 'Location Buying Price(Tax Excl.)',
                    sp.`to` AS 'Contract Expiry Date',
                    ROUND(t.`rate`) AS 'GST %',
                    ROUND((prod.`price` * ((ROUND(t.`rate`) / 100) + 1)), 2) AS 'MRP',
                    sp.`date_update` AS 'Last Updated'
                FROM `"._DB_PREFIX_."specific_price` sp
                CROSS JOIN `"._DB_PREFIX_."product_zone_mapping` pzm
                LEFT JOIN `"._DB_PREFIX_."zonal_price` zp ON (pzm.`product_id` = zp.`id_product` AND pzm.`zone_id` = zp.`id_fulfillment_centre`)
                LEFT JOIN `"._DB_PREFIX_."group_lang` gl ON sp.`id_group` = gl.`id_group` AND gl.`id_lang` = 1
                LEFT JOIN `"._DB_PREFIX_."customer` cust ON sp.`id_customer` = cust.`id_customer`
                LEFT JOIN `"._DB_PREFIX_."product` prod ON sp.`id_product` = prod.`id_product`
                LEFT JOIN `"._DB_PREFIX_."product_lang` pl ON prod.`id_product` = pl.`id_product`
                LEFT JOIN `"._DB_PREFIX_."manufacturer` man ON prod.`id_manufacturer` = man.`id_manufacturer`
                LEFT JOIN `"._DB_PREFIX_."category` c1 ON c1.`id_category` = prod.`id_category_default`
                LEFT JOIN `"._DB_PREFIX_."category` c2 ON c2.`id_category` = c1.`id_parent`
                LEFT JOIN `"._DB_PREFIX_."category` c3 ON c3.`id_category` = c2.`id_parent`
                LEFT JOIN `"._DB_PREFIX_."category` c4 ON c4.`id_category` = c3.`id_parent`
                LEFT JOIN `"._DB_PREFIX_."category` c5 ON c5.`id_category` = c4.`id_parent`
                LEFT JOIN `"._DB_PREFIX_."category_lang` cl1 ON c1.`id_category` = cl1.`id_category` and cl1.`id_lang` = 1
                LEFT JOIN `"._DB_PREFIX_."category_lang` cl2 ON c2.`id_category` = cl2.`id_category` and cl2.`id_lang` = 1
                LEFT JOIN `"._DB_PREFIX_."category_lang` cl3 ON c3.`id_category` = cl3.`id_category` and cl3.`id_lang` = 1
                LEFT JOIN `"._DB_PREFIX_."category_lang` cl4 ON c4.`id_category` = cl4.`id_category` and cl4.`id_lang` = 1
                LEFT JOIN `"._DB_PREFIX_."category_lang` cl5 ON c5.`id_category` = cl5.`id_category` and cl5.`id_lang` = 1 
                LEFT JOIN `"._DB_PREFIX_."fulfillment_centre` fc ON pzm.`zone_id` = fc.`id_fulfillment_centre`
                LEFT JOIN `"._DB_PREFIX_."tax_rule` tr ON prod.`id_tax_rules_group` = tr.`id_tax_rules_group`
                LEFT JOIN `"._DB_PREFIX_."tax` t ON tr.`id_tax` = t.`id_tax`
                WHERE pl.`id_lang` = 1 
                AND sp.`id_product` = pzm.`product_id`
                ".(isset($id_group) && $id_group ? "AND sp.`id_group` IN(".$id_group.")" : "")."
                ".$sql_append."
                ORDER BY gl.`name` ASC";
       
        $result_array = Db::getInstance()->ExecuteS($sql);
        
        $original_array = array('0','1');
        array_splice($original_array, 2, 0, $result_array);
        
        $i = 2;
        $j = 0;
        
        $activeSheet->getStyle('A' . $i.':V'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        for ($i = $i; $i < sizeof($original_array); $i++) 
        {    
            $activeSheet->setCellValue('A' . $i, $original_array[$i]['Company ID'])
                ->setCellValue('B' . $i, $original_array[$i]['Company Name'])
                ->setCellValue('C' . $i, $original_array[$i]['Customer ID'])
                ->setCellValue('D' . $i, $original_array[$i]['Customer Name'])
                ->setCellValue('E' . $i, $original_array[$i]['Product Code'])
                ->setCellValue('F' . $i,$original_array[$i]['Product ID'])
                ->setCellValue('G' . $i, $original_array[$i]['Product Name'])
                ->setCellValue('H' . $i, $original_array[$i]['HSN Code'])
                ->setCellValue('I' . $i, $original_array[$i]['Brand Name'])
                ->setCellValue('J' . $i, $original_array[$i]['L0'])
                ->setCellValue('K' . $i, $original_array[$i]['L1'])
                ->setCellValue('L' . $i, $original_array[$i]['L2'])
                ->setCellValue('M' . $i, $original_array[$i]['L3'])
                ->setCellValue('N' . $i, $original_array[$i]['L4'])
                ->setCellValue('O' . $i, $original_array[$i]['Unit Price(Tax Excl.)'])
                ->setCellValue('P' . $i, $original_array[$i]['GST %'])
                ->setCellValue('Q' . $i, $original_array[$i]['MRP'])
                ->setCellValue('R' . $i, $original_array[$i]['Buying Price(Tax Excl.)'])
                ->setCellValue('S' . $i, $original_array[$i]['Location Availabe'])
                ->setCellValue('T' . $i, $original_array[$i]['Location Buying Price(Tax Excl.)'])
                ->setCellValue('U' . $i, $original_array[$i]['Contract Expiry Date'])
                ->setCellValue('V' . $i, $original_array[$i]['Last Updated']);
        }

        ################################## /HEADER TABLE ################################
        
        // Set page orientation and size
        $activeSheet->getPageMargins()->setTop(0.25);
        $activeSheet->getPageMargins()->setRight(0.25);
        $activeSheet->getPageMargins()->setLeft(0.25);
        $activeSheet->getPageMargins()->setBottom(0.25);
        $activeSheet->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        // Set fills
        $activeSheet->getStyle('A1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $activeSheet->getStyle('A1:V1')->getFill()->getStartColor()->setARGB('CF000F');

        $activeSheet->getColumnDimension('A')->setAutoSize(true);
        $activeSheet->getColumnDimension('B')->setAutoSize(true);
        $activeSheet->getColumnDimension('C')->setAutoSize(true);
        $activeSheet->getColumnDimension('D')->setAutoSize(true);
        $activeSheet->getColumnDimension('E')->setAutoSize(true);
        $activeSheet->getColumnDimension('F')->setAutoSize(true);
        $activeSheet->getColumnDimension('G')->setAutoSize(true);
        $activeSheet->getColumnDimension('H')->setAutoSize(true);
        $activeSheet->getColumnDimension('I')->setAutoSize(true);
        $activeSheet->getColumnDimension('J')->setAutoSize(true);
        $activeSheet->getColumnDimension('K')->setAutoSize(true);
        $activeSheet->getColumnDimension('L')->setAutoSize(true);
        $activeSheet->getColumnDimension('M')->setAutoSize(true);
        $activeSheet->getColumnDimension('N')->setAutoSize(true);
        $activeSheet->getColumnDimension('O')->setAutoSize(true);
        $activeSheet->getColumnDimension('P')->setAutoSize(true);
        $activeSheet->getColumnDimension('Q')->setAutoSize(true);
        $activeSheet->getColumnDimension('R')->setAutoSize(true);
        $activeSheet->getColumnDimension('S')->setAutoSize(true);
        $activeSheet->getColumnDimension('T')->setAutoSize(true);
        $activeSheet->getColumnDimension('U')->setAutoSize(true);
        $activeSheet->getColumnDimension('V')->setAutoSize(true);

        // Set autofilter
        // Always include the complete filter range!
        //$activeSheet->setAutoFilter($activeSheet->calculateWorksheetDimension());
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $activeSheet->setShowGridlines(true);
        
       // Redirect output to a client's web browser (Excel2007)        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= RateContractReport.xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
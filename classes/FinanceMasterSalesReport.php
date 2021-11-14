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

class FinanceMasterSalesReport
{
    
    public function __construct($from,$to)
    {        
        $this->from = $from.' 00:00:00';
        $this->to = $to.' 23:59:59';

        $this->download_file($this->from,$this->to);
        return;
    }
    
    private function download_file($from=NULL,$to=NULL)
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

        //Active sheet
        $activeSheet = $objPHPExcel->getActiveSheet();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster Tech Team")->setLastModifiedBy("Lakshmi.sg")->setTitle("Kobster Fpp")->setSubject("Kobster Fpp")->setDescription("Finance Pending Payment, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
        $activeSheet->getPageMargins()->setTop(1);
        $activeSheet->getPageMargins()->setRight(0.75);
        $activeSheet->getPageMargins()->setLeft(0.75);
        $activeSheet->getPageMargins()->setBottom(1);

        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setFitToPage(true);

        // Set style for header row using alternative method
        $activeSheet->getStyle('A1:AD1')->applyFromArray(array(
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
                
        $activeSheet->setCellValue('A1', "Order ID")
            ->setCellValue('B1', "Placed Date")
            ->setCellValue('C1', "Delivered Date")
            ->setCellValue('D1', "User ID")
            ->setCellValue('E1', "Company Name")
            ->setCellValue('F1', "User Name")
            ->setCellValue('G1', "Relationship Manager")
            ->setCellValue('H1', "Company type")
            ->setCellValue('I1', "Current Order Status")
            ->setCellValue('J1', "City")
            ->setCellValue('K1', "State")
            ->setCellValue('L1', "Payment Mode")
            ->setCellValue('M1', "L0")
            ->setCellValue('N1', "L1")
            ->setCellValue('O1', "L2")
            ->setCellValue('P1', "L3")
            ->setCellValue('Q1', "L4")
            ->setCellValue('R1', "Product Code")
            ->setCellValue('S1', "HSN Code")
            ->setCellValue('T1', "Product ID")
            ->setCellValue('U1', "Product Name")
            ->setCellValue('V1', "Brand")
            ->setCellValue('W1', "Buying Price(Tax Excl.)")
            ->setCellValue('X1', "Selling Price(Tax Excl.)")
            ->setCellValue('Y1', "Quantity")
            ->setCellValue('Z1', "Total Buying Price(Tax Excl.)")
            ->setCellValue('AA1', "Total Selling Price(Tax Excl.)")
            ->setCellValue('AB1', "Profit Margin")
            ->setCellValue('AC1', "Fulfillment Centre")
            ->setCellValue('AD1', "MRP");
        
        $sql = "SELECT ord.`id_order` AS 'Order ID', 
                    ord.`date_add` AS 'Placed Date',
                    koh.`date_add` AS 'Delivered Date', 
                    ord.`id_customer` AS 'Customer ID', 
                    emp.`firstname` AS 'firstname',
                    gl.`name` AS 'Company Name', 
                    cust.`firstname` AS 'Customer Name',
                    ord_state.`name` AS 'Current Order Status', 
                    address.`city` AS 'City',
                    state.`name` AS 'State',
                    ord.`payment` AS 'Payment Mode',  
                    CASE cust.`id_buyer`
                        WHEN 3 THEN 'Elite'
                        ELSE 'Non-Elite' 
                    END AS cust_type,
                    IF (c5.`level_depth` = 1, cl5.`name`, IF(c4.`level_depth`=1, cl4.`name`, IF(c3.`level_depth`=1, cl3.`name`, IF(c2.`level_depth`=1, cl2.`name`, IF(c1.`level_depth`=1, cl1.`name`, ''))))) AS 'L0',
                    IF (c5.`level_depth` = 2, cl5.`name`, IF(c4.`level_depth`=2, cl4.`name`, IF(c3.`level_depth`=2, cl3.`name`, IF(c2.`level_depth`=2, cl2.`name`, IF(c1.`level_depth`=2, cl1.`name`, ''))))) as 'L1',
                    IF (c5.`level_depth` = 3, cl5.`name`, IF(c4.`level_depth`=3, cl4.`name`, IF(c3.`level_depth`=3, cl3.`name`, IF(c2.`level_depth`=3, cl2.`name`, IF(c1.`level_depth`=3, cl1.`name`, ''))))) as 'L2',
                    IF (c5.`level_depth` = 4, cl5.`name`, IF(c4.`level_depth`=4, cl4.`name`, IF(c3.`level_depth`=4, cl3.`name`, IF(c2.`level_depth`=4, cl2.`name`, IF(c1.`level_depth`=4, cl1.`name`, ''))))) as 'L3',
                    IF (c5.`level_depth` = 5, cl5.`name`, IF(c4.`level_depth`=5, cl4.`name`, IF(c3.`level_depth`=5, cl3.`name`, IF(c2.`level_depth`=5, cl2.`name`, IF(c1.`level_depth`=5, cl1.`name`, ''))))) as L4,
                    ord_det.`product_reference` as 'Product Code', 
                    prod.`hsn_code` AS 'HSN Code',
                    ord_det.`product_id` as 'Product ID', 
                    ord_det.`product_name` as 'Product Name',
                    man.`name` as 'Brand Name',
                    ROUND(prod.`wholesale_price`, 2) as 'Buying Price (Tax Excl)',
                    ROUND(ord_det.`unit_price_tax_excl`, 2) as 'Unit Price (Tax Excl)',
                    ord_det.`product_quantity` as 'Product Qty',
                    ROUND(prod.`wholesale_price` * ord_det.`product_quantity`, 2) as 'Total Buying Price (Tax Excl)',
                    ROUND(ord_det.`unit_price_tax_excl` * ord_det.`product_quantity`, 2) as 'Total Selling Price (Tax Excl)',
                    ROUND(((ord_det.`unit_price_tax_excl` - prod.`wholesale_price`) / ord_det.`unit_price_tax_excl`) * 100, 2) as 'Profit Margin',
                    fc.`city_name` AS 'Fulfillment Centre',
                    (prod.`price` * (( tax.`rate` / 100) + 1 )) AS MRP
                FROM `kob_orders` ord 
                LEFT JOIN `kob_order_history` koh ON ord.`id_order` = koh.`id_order` 
                LEFT OUTER JOIN `kob_order_state_lang` ord_state ON ord.`current_state` = ord_state.`id_order_state`
                LEFT JOIN `kob_customer` cust ON ord.`id_customer` = cust.`id_customer`
                LEFT JOIN `kob_employee` emp ON cust.`id_relationship_manager` = emp.`id_employee`
                LEFT JOIN `kob_group_lang` gl ON cust.`id_default_group` = gl.`id_group` AND gl.`id_lang` = 1
                LEFT JOIN `kob_address` address ON ord.`id_address_delivery` = address.`id_address`
                LEFT JOIN `kob_state` state ON address.`id_state` = state.`id_state`
                LEFT JOIN `kob_order_detail` ord_det ON ord.`id_order` = ord_det.`id_order`
                LEFT JOIN `kob_product` prod ON ord_det.`product_id` = prod.`id_product`
                LEFT JOIN `kob_tax_rule` tr ON (prod.`id_tax_rules_group` = tr.`id_tax_rules_group`) AND tr.`id_state` = 0
                LEFT JOIN `kob_tax` tax ON tr.`id_tax` = tax.`id_tax`
                LEFT JOIN `kob_manufacturer` man ON prod.`id_manufacturer` = man.`id_manufacturer`
                LEFT JOIN `kob_fulfillment_centre` fc ON ord.`id_fc` = fc.`id_fulfillment_centre`
                LEFT JOIN `kob_category` c1 ON c1.`id_category` = prod.`id_category_default`
                LEFT JOIN `kob_category` c2 ON c2.`id_category` = c1.`id_parent`
                LEFT JOIN `kob_category` c3 ON c3.`id_category` = c2.`id_parent`
                LEFT JOIN `kob_category` c4 ON c4.`id_category` = c3.`id_parent`
                LEFT JOIN `kob_category` c5 ON c5.`id_category` = c4.`id_parent`
                LEFT JOIN `kob_category_lang` cl1 ON c1.`id_category` = cl1.`id_category` and cl1.`id_lang` = 1
                LEFT JOIN `kob_category_lang` cl2 ON c2.`id_category` = cl2.`id_category` and cl2.`id_lang` = 1
                LEFT JOIN `kob_category_lang` cl3 ON c3.`id_category` = cl3.`id_category` and cl3.`id_lang` = 1
                LEFT JOIN `kob_category_lang` cl4 ON c4.`id_category` = cl4.`id_category` and cl4.`id_lang` = 1
                LEFT JOIN `kob_category_lang` cl5 ON c5.`id_category` = cl5.`id_category` and cl5.`id_lang` = 1
                WHERE ord.`date_add` BETWEEN '".$from."' AND '".$to."'
                AND koh.id_order_history IN(SELECT MAX(id_order_history) FROM kob_order_history WHERE `id_order_state` = 5 AND id_order=koh.id_order)
                AND ord_state.id_lang = 1";
       
        $result_array = Db::getInstance()->ExecuteS($sql);
        
        $original_array = array('0','1');
        array_splice($original_array, 2, 0, $result_array);
        
        $i = 2;
        $j = 0;
        
        $activeSheet->getStyle('A' . $i.':AC'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
        
        for ($i = $i; $i < sizeof($original_array); $i++) 
        {    
            $activeSheet->setCellValue('A' . $i, $original_array[$i]['Order ID'])
                ->setCellValue('B' . $i, $original_array[$i]['Placed Date'])
                ->setCellValue('C' . $i, $original_array[$i]['Delivered Date'])
                ->setCellValue('D' . $i, $original_array[$i]['Customer ID'])
                ->setCellValue('E' . $i, $original_array[$i]['Company Name'])
                ->setCellValue('F' . $i,$original_array[$i]['Customer Name'])
                ->setCellValue('G' . $i, $original_array[$i]['firstname'])
                ->setCellValue('H' . $i, $original_array[$i]['cust_type'])
                ->setCellValue('I' . $i, $original_array[$i]['Current Order Status'])
                ->setCellValue('J' . $i, $original_array[$i]['City'])
                ->setCellValue('K' . $i, $original_array[$i]['State'])
                ->setCellValue('L' . $i, $original_array[$i]['Payment Mode'])
                ->setCellValue('M' . $i, $original_array[$i]['L0'])
                ->setCellValue('N' . $i, $original_array[$i]['L1'])
                ->setCellValue('O' . $i, $original_array[$i]['L2'])
                ->setCellValue('P' . $i, $original_array[$i]['L3'])
                ->setCellValue('Q' . $i, $original_array[$i]['L4'])
                ->setCellValue('R' . $i, $original_array[$i]['Product Code'])
                ->setCellValue('S' . $i, $original_array[$i]['HSN Code'])
                ->setCellValue('T' . $i, $original_array[$i]['Product ID'])
                ->setCellValue('U' . $i, $original_array[$i]['Product Name'])
                ->setCellValue('V' . $i, $original_array[$i]['Brand Name'])
                ->setCellValue('W' . $i, $original_array[$i]['Buying Price (Tax Excl)'])
                ->setCellValue('X' . $i, $original_array[$i]['Unit Price (Tax Excl)'])
                ->setCellValue('Y' . $i, $original_array[$i]['Product Qty'])
                ->setCellValue('Z' . $i, $original_array[$i]['Total Buying Price (Tax Excl)'])
                ->setCellValue('AA' . $i, $original_array[$i]['Total Selling Price (Tax Excl)'])
                ->setCellValue('AB' . $i, $original_array[$i]['Profit Margin'])
                ->setCellValue('AC' . $i, $original_array[$i]['Fulfillment Centre'])
                ->setCellValue('AD' . $i, $original_array[$i]['MRP']);
        }

        ################################## /HEADER TABLE ################################
        
        // Set page orientation and size
        $activeSheet->getPageMargins()->setTop(0.25);
        $activeSheet->getPageMargins()->setRight(0.25);
        $activeSheet->getPageMargins()->setLeft(0.25);
        $activeSheet->getPageMargins()->setBottom(0.25);
        $activeSheet->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        // Set fills
        $activeSheet->getStyle('A1:AD1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $activeSheet->getStyle('A1:AD1')->getFill()->getStartColor()->setARGB('CF000F');

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
        $activeSheet->getColumnDimension('W')->setAutoSize(true);
        $activeSheet->getColumnDimension('X')->setAutoSize(true);
        $activeSheet->getColumnDimension('y')->setAutoSize(true);
        $activeSheet->getColumnDimension('Z')->setAutoSize(true);
        $activeSheet->getColumnDimension('AA')->setAutoSize(true);
        $activeSheet->getColumnDimension('AB')->setAutoSize(true);
        $activeSheet->getColumnDimension('AC')->setAutoSize(true);

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
        header('Content-Disposition: attachment; filename= MasterSalesReport.xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
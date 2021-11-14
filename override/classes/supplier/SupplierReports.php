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

class SupplierReports
{
    public function generateExcelReport($type, $from_date, $to_date, $id_group, $id_supplier)
    {
 
        $this->type = $type;
        $this->from = $from_date." 00:00:00";
        $this->to = $to_date." 23:59:59";
        $this->id_group = $id_group;
        $this->id_supplier = $id_supplier;

        $logger = new FileLogger();
        $logger->setFilename("testbo.txt");
        $logger->logError($this);

        $this->filename = "sample";
        if($this->type == 1){
            $this->filename = "Procurement Plan";
        }
        else if($this->type == 2){
            $this->filename = "Sales Reports ( ".$from_date." - ".$to_date." )";
        }
        else if($this->type == 3){
            $this->filename = "Delivery Reports ( ".$from_date." - ".$to_date." )";
        }
        else if($this->type == 4){
            $group = new Group($id_group);
            $logger->logError($group->name);
            $this->filename = "Rate Contract ( ".$group->name[1]." )";
        }
        

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
        require_once _PS_ROOT_DIR_ . '/classes/PHPExcel/Classes/PHPExcel.php';
        
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Powered By kobster E-Shop")->setLastModifiedBy("Senior Developer")->setTitle("Reports")->setSubject("Reports")->setDescription("Reports.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $column="";
        $logger = new FileLogger();
        $logger->setFilename("testbo.txt");
        $logger->logError("download_file =>");
        if($this->type == 1){
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Order ID.")->setCellValue('C1', "Product Name")->setCellValue('D1', "Product Reference")->setCellValue('E1', "Product Quantity")->setCellValue('F1', "Unit Price Tax Excl")->setCellValue('G1', "Total Price Tax Excl")->setCellValue('H1', "GST %")->setCellValue('I1', "HSN Code")->setCellValue('J1', "Estimated Delivery Time")->setCellValue('K1', "Company")->setCellValue('L1', "User")->setCellValue('M1', "Address")->setCellValue('N1', "City")->setCellValue('O1', "SEZ")->setCellValue('P1', "Brand")->setCellValue('Q1', "Category");

            $result = Db::getInstance()->ExecuteS("SELECT ksd.id_parent as parent_order, kod.product_id, kod.product_name,kod.product_reference, kod.product_quantity, kod.unit_price_tax_excl, kod.total_price_tax_excl, ktrg.name as gst, kp.hsn_code, DATE_FORMAT(koa.estimated_delivery_time, '%d/%m/%Y') as edt, kgl.name as company , kc.firstname, kc.email, ka.address1, ka.city, if(ka.isez, 'SEZ', '--') as sez, km.name as brand, kcl.name as cat
                        FROM kob_elite_supplier_orders keso
                        LEFT JOIN kob_split_details ksd ON ksd.id_order=keso.id_order
                        LEFT JOIN kob_orders koa ON koa.id_order=ksd.id_order
                        LEFT JOIN kob_order_history koh ON koh.id_order=koa.id_order
                        LEFT JOIN kob_order_detail kod ON kod.id_order=koa.id_order
                        LEFT JOIN kob_product kp ON kp.id_product = kod.product_id
                        LEFT JOIN kob_manufacturer km ON km.id_manufacturer=kp.id_manufacturer
                        LEFT JOIN kob_category_lang kcl ON kcl.id_category=kp.id_category_default AND kcl.id_lang=1
                        LEFT JOIN kob_tax_rules_group ktrg ON ktrg.id_tax_rules_group=kod.id_tax_rules_group
                        LEFT JOIN kob_customer kc ON kc.id_customer=koa.id_customer
                        LEFT JOIN kob_group_lang kgl ON kgl.id_group = kc.id_default_group AND kgl.id_lang=1
                        LEFT JOIN kob_address ka ON ka.id_address=koa.id_address_delivery
                        WHERE koh.id_order_history IN(SELECT MAX(id_order_history) FROM kob_order_history WHERE id_order=koa.id_order)
                        AND koh.id_order_state=22
                        AND keso.id_supplier=".$this->id_supplier);
            $original_array = array('0','1');
            array_splice($original_array, 2, 0, $result);
            $i = 2;
            $j = 0;
            for ($i = $i; $i < sizeof($original_array); $i++) 
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)
                                            ->setCellValue('B' . $i, $original_array[$i]['parent_order'])
                                            ->setCellValue('C' . $i, $original_array[$i]['product_name'])
                                            ->setCellValue('D' . $i, $original_array[$i]['product_reference'])
                                            ->setCellValue('E' . $i, $original_array[$i]['product_quantity'])
                                            ->setCellValue('F' . $i, $original_array[$i]['unit_price_tax_excl'])
                                            ->setCellValue('G' . $i, $original_array[$i]['total_price_tax_excl'])
                                            ->setCellValue('H' . $i, $original_array[$i]['gst'])
                                            ->setCellValue('I' . $i, $original_array[$i]['hsn_code'])
                                            ->setCellValue('J' . $i, $original_array[$i]['edt'])
                                            ->setCellValue('K' . $i, $original_array[$i]['company'])
                                            ->setCellValue('L' . $i, $original_array[$i]['firstname']."(".$original_array[$i]['email'].")")
                                            ->setCellValue('M' . $i, $original_array[$i]['address1'])
                                            ->setCellValue('N' . $i, $original_array[$i]['city'])
                                            ->setCellValue('O' . $i, $original_array[$i]['sez'])
                                            ->setCellValue('P' . $i, $original_array[$i]['brand'])
                                            ->setCellValue('Q' . $i, $original_array[$i]['cat']);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFill()->getStartColor()->setARGB('CF000F');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            $column="A1:O1";
        }
        if($this->type == 2){
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Order ID.")->setCellValue('C1', "Invoice Number")->setCellValue('D1', "Invoice Date")->setCellValue('E1', "Product Name")->setCellValue('F1', "Product Reference")->setCellValue('G1', "Product Quantity")->setCellValue('H1', "Unit Price Tax Excl")->setCellValue('I1', "Total Price Tax Excl")->setCellValue('J1', "GST %")->setCellValue('K1', "HSN")->setCellValue('L1', "GSTIN")->setCellValue('M1', "Company")->setCellValue('N1', "User")->setCellValue('O1', "Address")->setCellValue('P1', "City")->setCellValue('Q1', "SEZ")->setCellValue('R1', "Ordered On")->setCellValue('S1', "Payment")->setCellValue('T1', "Brand")->setCellValue('U1', "Category");

            $result = Db::getInstance()->ExecuteS("SELECT DISTINCT(kod.id_order_detail),ksd.root as parent_order, ko.id_order, kd.delivery_number, kd.dr_prefix, kod.id_order, kod.product_name, kod.product_reference, kod.product_quantity, kod.unit_price_tax_excl, kod.total_price_tax_excl, ktrg.name as gst, kp.hsn_code,  kc.email, kc.firstname, kg.name as company, koi.number as invoice_number, DATE_FORMAT(koha.date_add, '%d/%m/%Y %H:%i:%s') as invoice_date, ka.address1, ka.city, ka.vat_number, if(ka.isez, 'SEZ', '--') as sez, DATE_FORMAT(kohb.date_add, '%d/%m/%Y %H:%i:%s') as ordered, ko.payment, km.name as brand, kcl.name as cat
                    FROM `kob_elite_supplier_orders` keso
                    LEFT JOIN kob_split_details ksd ON ksd.id_order=keso.id_order
                    LEFT JOIN kob_order_detail kod ON kod.id_order = ksd.id_order
                    LEFT JOIN kob_order_invoice koi ON koi.id_order=kod.id_order
                    LEFT JOIN kob_product kp ON kp.id_product=kod.product_id
                    LEFT JOIN kob_manufacturer km ON km.id_manufacturer=kp.id_manufacturer
                    LEFT JOIN kob_category_lang kcl ON kcl.id_category=kp.id_category_default and kcl.id_lang=1
                    LEFT JOIN kob_orders ko ON ko.id_order=ksd.id_parent
                    LEFT JOIN kob_address ka ON ka.id_address=ko.id_address_delivery
                    LEFT JOIN kob_delivery_details kdd ON kdd.id_order=kod.id_order
                    LEFT JOIN kob_delivery kd ON kd.id_delivery=kdd.id_delivery
                    LEFT JOIN kob_tax_rules_group ktrg ON ktrg.id_tax_rules_group=kod.id_tax_rules_group
                    LEFT JOIN kob_order_history koha ON koha.id_order=kod.id_order AND koha.id_order_state = 25
                    LEFT JOIN kob_order_history kohb ON kohb.id_order=kod.id_order AND kohb.id_order_state = 22
                    LEFT JOIN kob_order_state_lang kosl ON kosl.id_order_state=koha.id_order_state AND kosl.id_lang=1
                    LEFT JOIN kob_customer kc ON kc.id_customer=ko.id_customer
                    LEFT JOIN kob_group_lang kg ON kg.id_group=kc.id_default_group AND kg.id_lang=1
                    WHERE keso.id_supplier=".$this->id_supplier."
                    AND koha.date_add BETWEEN '".$this->from."' AND '".$this->to."'");
            
            $original_array = array('0','1');
            array_splice($original_array, 2, 0, $result);
            $i = 2;
            $j = 0;
            for ($i = $i; $i < sizeof($original_array); $i++) 
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)
                                            ->setCellValue('B' . $i, $original_array[$i]['parent_order'])
                                            ->setCellValue('C' . $i, $original_array[$i]['invoice_number'])
                                            ->setCellValue('D' . $i, $original_array[$i]['invoice_date'])
                                            ->setCellValue('E' . $i, $original_array[$i]['product_name'])
                                            ->setCellValue('F' . $i, $original_array[$i]['product_reference'])
                                            ->setCellValue('G' . $i, $original_array[$i]['product_quantity'])
                                            ->setCellValue('H' . $i, $original_array[$i]['unit_price_tax_excl'])
                                            ->setCellValue('I' . $i, $original_array[$i]['total_price_tax_excl'])
                                            ->setCellValue('J' . $i, $original_array[$i]['gst'])
                                            ->setCellValue('K' . $i, $original_array[$i]['hsn_code'])
                                            ->setCellValue('L' . $i, $original_array[$i]['vat_number'])
                                            ->setCellValue('M' . $i, $original_array[$i]['company'])
                                            ->setCellValue('N' . $i, $original_array[$i]['firstname']."(".$original_array[$i]['email'].")")
                                            ->setCellValue('O' . $i, $original_array[$i]['address1'])
                                            ->setCellValue('P' . $i, $original_array[$i]['city'])
                                            ->setCellValue('Q' . $i, $original_array[$i]['sez'])
                                            ->setCellValue('R' . $i, $original_array[$i]['ordered'])
                                            ->setCellValue('S' . $i, $original_array[$i]['payment'])
                                            ->setCellValue('T' . $i, $original_array[$i]['brand'])
                                            ->setCellValue('U' . $i, $original_array[$i]['cat']);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFill()->getStartColor()->setARGB('CF000F');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
            $column="A1:U1";
        }
        if($this->type == 3){
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Order ID")->setCellValue('C1', "Delivery Number")->setCellValue('D1', "Product Name")->setCellValue('E1', "Product Reference")->setCellValue('F1', "Product Quantity")->setCellValue('G1', "Company")->setCellValue('H1', "User")->setCellValue('I1', "Address")->setCellValue('J1', "City")->setCellValue('K1', "Ordered ON")->setCellValue('L1', "Delivered ON");

            $result = Db::getInstance()->ExecuteS("SELECT DISTINCT(kod.id_order_detail), keso.id_supplier, ksd.root as parent_order, kod.id_order, kod.product_name, kod.product_reference, kod.product_quantity, koh_ordered.date_add as ordered, koh.date_add as delivered, kd.dr_prefix, kd.delivery_number, kgl.name as company, kc.firstname, kc.email,  ka.address1, ka.city
                            FROM kob_split_details ksd
                            LEFT JOIN kob_order_history koh ON koh.id_order=ksd.id_order
                            LEFT JOIN kob_order_detail kod ON kod.id_order=koh.id_order
                            LEFT JOIN kob_delivery_details kdd ON kdd.id_order=kod.id_order
                            LEFT JOIN kob_delivery kd ON kd.id_delivery=kdd.id_delivery
                            LEFT JOIN kob_elite_supplier_orders keso ON keso.id_order=ksd.id_order
                            LEFT JOIN kob_orders ko ON ko.id_order=ksd.id_parent
                            LEFT JOIN kob_address ka ON ka.id_address=ko.id_address_delivery
                            LEFT JOIN kob_order_history koh_ordered ON koh_ordered.id_order=ko.id_order AND koh_ordered.id_order_state=22
                            LEFT JOIN kob_customer kc ON kc.id_customer=ko.id_customer
                            LEFT JOIN kob_group_lang kgl ON kgl.id_group=kc.id_default_group AND kgl.id_lang=1
                            WHERE koh.id_order_state=5 
                            AND koh.date_add BETWEEN '".$this->from."' AND '".$this->to."'
                            AND keso.id_supplier=".$this->id_supplier);
            $original_array = array('0','1');
            array_splice($original_array, 2, 0, $result);
            $i = 2;
            $j = 0;
            for ($i = $i; $i < sizeof($original_array); $i++) 
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)
                                            ->setCellValue('B' . $i, $original_array[$i]['parent_order'])
                                            ->setCellValue('C' . $i, $original_array[$i]['dr_prefix'].sprintf('%06d', $original_array[$i]['delivery_number']))
                                            ->setCellValue('D' . $i, $original_array[$i]['product_name'])
                                            ->setCellValue('E' . $i, $original_array[$i]['product_reference'])
                                            ->setCellValue('F' . $i, $original_array[$i]['product_quantity'])
                                            ->setCellValue('G' . $i, $original_array[$i]['company'])
                                            ->setCellValue('H' . $i, $original_array[$i]['firstname']."(".$original_array[$i]['email'].")")
                                            ->setCellValue('I' . $i, $original_array[$i]['address1'])
                                            ->setCellValue('J' . $i, $original_array[$i]['city'])
                                            ->setCellValue('K' . $i, $original_array[$i]['ordered'])
                                            ->setCellValue('L' . $i, $original_array[$i]['delivered']);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('CF000F');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $column="A1:L1";
        }
        if($this->type == 4){
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Product Reference")->setCellValue('C1', "Product Name")->setCellValue('D1', "Contract Price")->setCellValue('E1', "GST %")->setCellValue('F1', "Expiry Date")->setCellValue('G1', "HSN Code");

            $result =  Db::getInstance()->ExecuteS("SELECT kp.reference, kpl.name as product_name, ksp.price, ktrg.name as gst, DATE_FORMAT(ksp.`to`, '%d/%m/%Y') as expiry, kp.hsn_code
                                                            from "._DB_PREFIX_."specific_price ksp 
                                                            LEFT JOIN "._DB_PREFIX_."product kp ON ksp.id_product=kp.id_product
                                                            LEFT JOIN "._DB_PREFIX_."product_lang kpl on kpl.id_product=kp.id_product
                                                            LEFT JOIN "._DB_PREFIX_."tax_rules_group ktrg ON ktrg.id_tax_rules_group=kp.id_tax_rules_group
                                                            WHERE ksp.id_group=".$this->id_group." AND ksp.id_supplier=".$this->id_supplier."");
            $original_array = array('0','1');
            array_splice($original_array, 2, 0, $result);
            
            $i = 2;
            $j = 0;
            for ($i = $i; $i < sizeof($original_array); $i++) 
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)
                                            ->setCellValue('B' . $i, $original_array[$i]['reference'])
                                            ->setCellValue('C' . $i, $original_array[$i]['product_name'])
                                            ->setCellValue('D' . $i, $original_array[$i]['price'])
                                            ->setCellValue('E' . $i, $original_array[$i]['gst'])
                                            ->setCellValue('F' . $i, $original_array[$i]['expiry'])
                                            ->setCellValue('G' . $i, $original_array[$i]['hsn_code']);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('CF000F');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $column="A1:G1";
        }
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
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $this->filename.'.xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
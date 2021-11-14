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

class DashPendingPayments 
{
    
    public function DashPendingPayments()
    {
        $id_customer = Tools::getValue('id_customer');
        $this->download_file($id_customer);
        return;
    }
    
    private function download_file($id_customer)
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
        $objPHPExcel->getProperties()->setCreator("kobzo Tech Team")->setLastModifiedBy("Lakshmi.sg")->setTitle("kobzo Fpp")->setSubject("kobzo Fpp")->setDescription("Finance Pending Payment, generated using PHP classes.")->setKeywords("office PHPExcel php")->setCategory("Product Based");
        
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
        
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No")->setCellValue('B1', "Invoice Number")->setCellValue('C1', "Invoice Date")->setCellValue('D1', "Invoice Value")->setCellValue('E1', "Due Date")->setCellValue('F1', "Invoice Status")->setCellValue('G1', "Order Number")->setCellValue('H1', "Outstanding");
       
        // $result_array   = $this->fetchPendingPayments($id_customer);
        $customer = new Customer($id_customer);
        $str = $customer->getChildCustomers();

        $sql = "SELECT CONCAT('IN', LPAD(oi.`number`, 6, 0)) as invoice_number,o.`id_order`,
                        DATE_FORMAT(o.`invoice_date`, '%b %d, %Y') AS invoice_date,
                        DATE_FORMAT(DATE_ADD(o.`invoice_date`, INTERVAL o.credit_days DAY), '%b %d, %Y') as due_date,
                        DATEDIFF(NOW(),oi.`date_add`) AS age,o.`credit_days`,
                        o.`id_order` as order_number,o.`total_paid_tax_incl`as invoice_value, 
                        oh.`id_order_state`,os.name as invoice_status, (CASE WHEN os.id_order_state=6 THEN '0.00' ELSE (o.`total_paid` - 0) END) AS outstanding , d.`dr_file_name` as dr_file,d.`delivery_number`,d.`id_delivery`  FROM `kob_order_history` AS oh
                LEFT JOIN `kob_orders` AS o ON oh.`id_order` = o.`id_order`
                LEFT JOIN `kob_order_state` AS ostate ON oh.`id_order_state` = ostate.`id_order_state`
                LEFT JOIN `kob_order_state_lang` AS os ON oh.`id_order_state` = os.`id_order_state` and os.`id_lang`=1
                LEFT JOIN `kob_order_invoice` AS oi ON oi.`id_order`= o.`id_order`
                LEFT JOIN `kob_delivery_details` AS dd ON dd.id_order = o.`id_order`
                LEFT JOIN `kob_delivery` As d ON d.`id_delivery` = dd.`id_delivery`
                
                WHERE oh.id_order_history IN (
                                                SELECT  MAX(oh.`id_order_history`)
                                                FROM `kob_order_history` AS oh
                                                where o.`id_order` = oh.`id_order` 
                                                GROUP BY oh.`id_order`
                                            )
                AND o.`id_customer` IN (".$str.") 
                AND o.`invoice_number`!=0 
                AND ostate.`hidden` != 1                
                AND o.`invoice_date` <> '0000-00-00 00:00:00'
                GROUP BY o.`id_order` 
                ORDER BY o.`id_order` DESC";

        // $sql = "SELECT CONCAT('IN', LPAD(oi.`number`, 6, 0)) as invoice_number,
        //                 DATE_FORMAT(o.`invoice_date`, '%M %d, %Y') AS invoice_date,
        //                 DATE_FORMAT(DATE_ADD(o.`invoice_date`, INTERVAL o.credit_days DAY), '%M %d, %Y') as due_date,
        //                 DATEDIFF(NOW(),oi.`date_add`) AS age,o.`credit_days`,
        //                 o.`id_order` as order_number,o.`total_paid_tax_incl`as invoice_value, 
        //                 oh.`id_order_state`,os.name as invoice_status, (o.`total_paid` - 0) as outstanding ,
        //                 d.`dr_file_name` as dr_file,d.`delivery_number`,d.`id_delivery`  FROM `kob_order_history` AS oh
        //         LEFT JOIN `kob_orders` AS o ON oh.`id_order` = o.`id_order`
        //         LEFT JOIN `kob_order_state_lang` AS os ON oh.`id_order_state` = os.`id_order_state` and os.`id_lang`=1
        //         LEFT JOIN `kob_order_invoice` AS oi ON oi.`id_order`= o.`id_order`
        //         LEFT JOIN `kob_delivery_details` AS dd ON dd.id_order = o.`id_order`
        //         LEFT JOIN `kob_delivery` As d ON d.`id_delivery` = dd.`id_delivery`
                
        //         WHERE oh.id_Order_history IN (
        //                                         SELECT  MAX(oh.`id_order_history`)
        //                                         FROM `kob_order_history` AS oh
        //                                         where o.`id_order` = oh.`id_order`
        //                                         GROUP BY oh.`id_order`
        //                                     )
        //         AND o.`id_customer` IN (".$str.") 
        //          AND os.id_order_state IN(35,36,39,40)
        //         AND o.`invoice_date` <> '0000-00-00 00:00:00'
        //         GROUP BY o.`id_order` 
        //         ORDER BY o.`id_order` DESC";

        $result_array = Db::getInstance()->ExecuteS($sql);
        $original_array = array('0','1');
        array_splice($original_array, 2, 0, $result_array);
        
        $i = 2;
        $j = 0;
        
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i.':A'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);        
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i.':B'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i.':C'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i.':D'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i.':E'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $i.':F'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i.':G'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $i.':H'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        for ($i = $i; $i < sizeof($original_array); $i++) {            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1)->setCellValue('B' . $i, $original_array[$i]['invoice_number'])->setCellValue('C' . $i, $original_array[$i]['invoice_date'])->setCellValue('D' . $i, $original_array[$i]['invoice_value'])->setCellValue('E' . $i,$original_array[$i]['due_date'])->setCellValue('F' . $i, $original_array[$i]['invoice_status'])->setCellValue('G' . $i, $original_array[$i]['id_order'])->setCellValue('H' . $i, $original_array[$i]['outstanding']);
        }
        ################################## /HEADER TABLE ################################
        
        // Set page orientation and size
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        // Set fills
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
        
        // Set autofilter
        // Always include the complete filter range!
        //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        // Set style for header row using alternative method
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(array(
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
        $objPHPExcel->getActiveSheet()->getStyle('A1:C256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);     
        $objPHPExcel->getActiveSheet()->getStyle('B1:C256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);     
        $objPHPExcel->getActiveSheet()->getStyle('C1:C256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);     
        $objPHPExcel->getActiveSheet()->getStyle('D1:D256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     
        $objPHPExcel->getActiveSheet()->getStyle('E1:E256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     
        $objPHPExcel->getActiveSheet()->getStyle('F1:F256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);     
        $objPHPExcel->getActiveSheet()->getStyle('G1:G256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getStyle('H1:H256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);     

        // $objPHPExcel->getActiveSheet()->setCellValue('B2', "Payment Pending Details");
        // $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArrayDate);
        // $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        // $objPHPExcel->getActiveSheet()->setCellValue('G2', "Dated : " . date("Y/m/d"));
        // $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArrayDate);
        // $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        ############################# /HEADER TABLE ######################################
        
        $filename = $customer->firstname." Pending Payments ".date("Y-m-d");
       // Redirect output to a client's web browser (Excel2007)        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= '.$filename.'.xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
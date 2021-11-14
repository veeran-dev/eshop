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

class FinancePendingPayment
{
    
    public function __construct($id_group,$from,$to)
    {
        $this->id_group = $id_group;
        $this->from = $from;
        $this->to = $to;
        $this->download_file($id_group,$from,$to);
        return;
    }
    
    private function download_file($id_group=NULL,$from=NULL,$to=NULL)
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
        $objPHPExcel->getActiveSheet()->getStyle('H10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('I10')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('J10')->applyFromArray($styleArrayTable);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B10', "S.No.")->setCellValue('C10', "Company")->setCellValue('D10', "Order id")->setCellValue('E10', "Invoice Number")->setCellValue('F10', "Invoice Date")->setCellValue('G10', "Invoice Value")->setCellValue('H10', "Credit days")->setCellValue('I10', "Aging")->setCellValue('J10', "Status");
        
        $sql='SELECT g.`id_group`,gl.`name`,(SELECT oha.`date_add` FROM '._DB_PREFIX_.'order_history oha WHERE  o.`id_order` = oha.`id_order` AND oha.`id_order_state`=25 limit 1) as date_add,o.`id_order`,concat("#IN00",o.`invoice_number`) as invoice_number,FORMAT(o.`total_paid`,2) AS total_paid,osl.`name` AS order_status,o.`credit_days`,DATEDIFF(DATE_ADD((SELECT oha.`date_add` FROM '._DB_PREFIX_.'order_history oha WHERE  o.`id_order` = oha.`id_order` AND oha.`id_order_state`=25 limit 1) ,INTERVAL o.`credit_days` DAY),NOW()) AS aging
                FROM '._DB_PREFIX_.'orders o
                LEFT JOIN '._DB_PREFIX_.'order_history oh ON (o.`id_order` = oh.`id_order`)
                LEFT JOIN '._DB_PREFIX_.'order_state_lang osl ON (osl.`id_order_state` = oh.`id_order_state`)
                LEFT JOIN '._DB_PREFIX_.'customer c ON(c.`id_customer` = o.`id_customer`)
                LEFT JOIN '._DB_PREFIX_.'group g ON(g.`id_group`=c.`id_default_group`)
                LEFT JOIN '._DB_PREFIX_.'group_lang gl ON(gl.`id_group`=g.`id_group`)   
                WHERE 
                oh.id_Order_history IN (
                SELECT  MAX(oha.`id_order_history`) FROM '._DB_PREFIX_.'order_history AS oha
                WHERE o.id_order = oha.id_order GROUP BY oha.id_order
                )
                AND oh.`id_order_state` IN (35,37,39)
                AND gl.`id_lang`=1
                AND osl.`id_lang`=1';
        if($id_group)       
        {
            $sql .=" AND g.`id_group`=".$id_group;
        }
        if($from & $to)     
        {
            $to.=" 23:59:59";
            $sql .=" AND oh.`date_add` BETWEEN '".$from."' AND '".$to."'";
        }
       
        $result_array   = Db::getInstance()->ExecuteS($sql);
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
        $objPHPExcel->getActiveSheet()->getStyle('H' . $i.':H'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $i.':I'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $i.':J'.sizeof($original_array))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        for ($i = $i; $i < sizeof($original_array); $i++) {            
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, ++$j)->setCellValue('C' . $i, $original_array[$i]['name'])->setCellValue('D' . $i, $original_array[$i]['id_order'])->setCellValue('E' . $i,$original_array[$i]['invoice_number'])->setCellValue('F' . $i, $original_array[$i]['date_add'])->setCellValue('G' . $i, $original_array[$i]['total_paid'])->setCellValue('H' . $i, $original_array[$i]['credit_days'])->setCellValue('I' . $i, $original_array[$i]['aging'])->setCellValue('J' . $i, $original_array[$i]['order_status']);
        }
        ################################## /HEADER TABLE ################################
        
        // Set page orientation and size
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        // Set fills
        $objPHPExcel->getActiveSheet()->getStyle('B10:J10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('B10:J10')->getFill()->getStartColor()->setARGB('CF000F');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(57.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14.86);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18.00);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        
        
        // Set autofilter
        // Always include the complete filter range!
        //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        // Set style for header row using alternative method
        $objPHPExcel->getActiveSheet()->getStyle('B10:J10')->applyFromArray(array(
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
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Company's Outstanding Payment");
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($styleArrayDate);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Dated : " . date("Y/m/d"));
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArrayDate);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        ############################# /HEADER TABLE ######################################
        $group=new Group();
        $name=$group->getGroupById($this->id_group,1);
        if($name[0]['name'])
            $group_name=$name[0]['name'];
        else
            $group_name="Default";

       // Redirect output to a client's web browser (Excel2007)        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= '.$group_name.'Finance_PP.xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
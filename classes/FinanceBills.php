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

class FinanceBills
{
    
    public function FinanceBillsExcel($id_fc,$selected_month,$report_type)
    {
 
        $this->id_fc = $id_fc;
		$this->month = date("m", strtotime($selected_month));
		$this->month_name = date("F", strtotime($selected_month));
		if($report_type == 1)
			$this->filename="Purchase_Bill";
		else
			$this->filename="Sales_Bill";
  		$this->year =  date("Y", strtotime($selected_month));
        $this->report_type = $report_type;
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
        $column="";
        
        if($this->report_type == 1)// Purchase Bill
		{			
         $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Vendor Name")->setCellValue('C1', "GST No")->setCellValue('D1', "Bill No")->setCellValue('E1', "Bill Date")->setCellValue('F1', "Product Name")->setCellValue('G1', "Product Quantity")->setCellValue('H1', "Unit Price(Tax Excl.)")->setCellValue('I1', "Total Price(Tax Excl.)")->setCellValue('J1', "Tax Rate")->setCellValue('K1', "Tax value")->setCellValue('L1', "HSN Code");
		  
		 $fc="";
         if($this->id_fc!=0)
         {
            $fc=" AND b.id_fulfillment_centre = ".$this->id_fc." ";
         }

		 $result =  Db::getInstance()->ExecuteS("SELECT a.`id_bill_no`, pr.`hsn_code`, 
                                        DATE_FORMAT(a.`bill_date`, '%d/%m/%Y') AS bill_date, a.`product_qty`, a.`unit_price`, 
                                        a.`tax`, b.`name`  as vendor_name, IFNULL(b.`gst`, 0) AS gst, c.`name` as product_name,
                                        (CASE WHEN (a.`tax`) THEN (a.`unit_price` * a.`tax` * a.`product_qty`) / 100 ELSE '0.00' END) AS tax_value
								        FROM `"._DB_PREFIX_."vendor_purchase_bill` a, `"._DB_PREFIX_."vendor` b, 
                                        `"._DB_PREFIX_."product_lang` c , `"._DB_PREFIX_."product` pr  
										WHERE a.`active` = 1 
                                        AND a.`id_vendor` = b.`id_vendor`  
                                        AND a.`id_product` = c.`id_product` 
                                        AND a.`id_product` = pr.`id_product`
                                        AND c.`id_lang` = 1 ".$fc."
                                        AND month(a.`bill_date`) = ".$this->month." 
                                        AND YEAR(a.`bill_date`) = ".$this->year."
                                        GROUP BY a.`id_vendor`, a.`id_bill_no`, a.`id_product`
                                        ORDER BY a.`id_vendor`, a.`id_bill_no` ASC"
                                    );
 		
        $id_state =new FulfillmentCentre($this->id_fc);
        
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
				
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)->setCellValue('B' . $i, $original_array[$i]['vendor_name'])->setCellValue('C' . $i, $original_array[$i]['gst'])->setCellValue('D' . $i, $original_array[$i]['id_bill_no'])->setCellValue('E' . $i, $original_array[$i]['bill_date'])->setCellValue('F' . $i, $original_array[$i]['product_name'])->setCellValue('G' . $i,$original_array[$i]['product_qty'])->setCellValue('H' . $i, $original_array[$i]['unit_price'])->setCellValue('I' . $i, $total_product_price)->setCellValue('J' . $i, $original_array[$i]['tax'])->setCellValue('K' . $i, $original_array[$i]['tax_value'])->setCellValue('L' . $i, $original_array[$i]['hsn_code']);
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
		else// Sales Bill
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Delivered City")->setCellValue('C1', "User Name")->setCellValue('D1', "Company Name")->setCellValue('E1', "Invoice Number")->setCellValue('F1', "Invoice Date")->setCellValue('G1', "Order Status")->setCellValue('H1', "Order Number")->setCellValue('I1', "Product Name")->setCellValue('J1', "HSN Code")->setCellValue('K1', "Product Quantity")->setCellValue('L1', "Unit Price (Tax Excl.)")->setCellValue('M1', "Product Value (Tax Excl.)")->setCellValue('N1', "Discount value")->setCellValue('O1', "Shipping")->setCellValue('P1', "Tax Rate")->setCellValue('Q1', "Tax Value")->setCellValue('R1', "GST")->setCellValue('S1', "GST Number")->setCellValue('T1', "SEZ")->setCellValue('U1', "LUT Number");
    		 $fc="";
             if($this->id_fc!=0)
             {
                $fc="a.id_fc = ".$this->id_fc." and";
             }
			$result =  Db::getInstance()->ExecuteS("SELECT a.id_order, CONCAT(b.firstname,' ',b.lastname) AS cus_name, g.name as company_name, d.city, CONCAT('# IN',LPAD(a.invoice_number,6,'0')) AS invoice_number, DATE_FORMAT(a.invoice_date, '%d/%m/%Y') AS invoice_date,c.`unit_price_tax_excl`,c.product_name,kp.hsn_code, c.`unit_price_tax_excl`*c.`product_quantity` AS product_value, case when(t.rate) then t.rate else '0' END AS tax_rate,c.`total_price_tax_incl`-c.`total_price_tax_excl` as tax_value,c.`product_quantity`,a.`total_discounts_tax_incl` AS discount_value,a.`total_shipping_tax_excl` AS shipping,CASE WHEN(d.`isez` = 1) THEN 'IGST' WHEN(d.`id_state`=fc.`id_state`) THEN 'SGST-CGST' ELSE 'IGST' END AS 'GST', os.`name` AS order_status, CASE WHEN(d.`isez`=1) THEN 'YES' ELSE '--' END AS 'SEZ/IGST', d.`vat_number` as 'GST_NUM',CASE WHEN(d.`isez`=1) THEN fc.`lut` ELSE '' END AS lut
                FROM kob_orders a
                LEFT JOIN `kob_order_detail` c ON(a.`id_order` = c.`id_order`)
                LEFT JOIN `kob_product` kp on(kp.`id_product` = c.`product_id`)
                LEFT JOIN kob_order_detail_tax AS od ON(od.`id_order_detail` = c.`id_order_detail`)
                LEFT JOIN kob_order_history koh ON koh.`id_order` = a.`id_order`
                LEFT JOIN kob_order_state_lang AS os ON(os.`id_order_state` = koh.`id_order_state` and os.`id_lang` = 1)
                LEFT JOIN kob_tax AS t ON(t.`id_tax`=od.`id_tax`)
                LEFT JOIN kob_customer b ON(b.`id_customer`=a.`id_customer`)
                LEFT JOIN kob_group_lang g on g.`id_group` = b.`id_default_group` and g.`id_lang` = 1
                LEFT JOIN kob_address d ON(d.`id_address`=a.`id_address_delivery`) 
                LEFT JOIN `kob_fulfillment_centre` fc ON(fc.`id_fulfillment_centre`=a.`id_fc`)
                WHERE ".$fc."
                MONTH(a.invoice_date) =".$this->month." 
                AND YEAR(a.invoice_date) =".$this->year." 
                AND koh.id_order_history
                    IN (
                        SELECT MAX( oha.`id_order_history` ) 
                        FROM kob_order_history AS oha
                        WHERE a.id_order = oha.id_order
                        GROUP BY oha.id_order
                    )
                ORDER BY a.id_order");

			 $original_array = array(
				'0',
				'1'
			);	
			array_splice($original_array, 2, 0, $result);
			
			$i = 2;
			$j = 0;
			
			for ($i = $i; $i < sizeof($original_array); $i++) 
			{
				//$product_value = (round($original_array[$i]['product_value'],2));
				 $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)->setCellValue('B' . $i,$original_array[$i]['city'])->setCellValue('C' . $i, $original_array[$i]['cus_name'])->setCellValue('D' . $i, $original_array[$i]['company_name'])->setCellValue('E' . $i, $original_array[$i]['invoice_number'])->setCellValue('F' . $i, $original_array[$i]['invoice_date'])->setCellValue('G' . $i, $original_array[$i]['order_status'])->setCellValue('H' . $i, $original_array[$i]['id_order'])->setCellValue('I' . $i, $original_array[$i]['product_name'])->setCellValue('J' . $i, $original_array[$i]['hsn_code'])->setCellValue('K' . $i, $original_array[$i]['product_quantity'])->setCellValue('L' . $i, $original_array[$i]['unit_price_tax_excl'])->setCellValue('M' . $i, $original_array[$i]['product_value'])->setCellValue('N' . $i, $original_array[$i]['discount_value'])->setCellValue('O' . $i, $original_array[$i]['shipping'])->setCellValue('P' . $i, $original_array[$i]['tax_rate'])->setCellValue('Q' . $i, $original_array[$i]['tax_value'])->setCellValue('R' . $i, $original_array[$i]['GST'])->setCellValue('S' . $i, $original_array[$i]['GST_NUM'])->setCellValue('T' . $i, $original_array[$i]['SEZ/IGST'])->setCellValue('U' . $i, $original_array[$i]['lut']);
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
		 

        
        ################################## /HEADER TABLE ################################
        
        
         // Set fills
        
        
        
        
        // Set autofilter
        // Always include the complete filter range!
        
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
        $download_filename  = $this->filename."_".$this->month_name.".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
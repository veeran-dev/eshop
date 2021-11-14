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

class ProcurementExcel
{
    
    public function downloadProcurementExcel($id_fc)
    {
 
 		 
		$this->id_fc = $id_fc;
		$this->result_array = Procurement::generatePurchasePlan($id_fc);
		//var_dump($result_array);
		$this->download_file();
        return;
    }
    
    public function download_file()
    {
		$logger=new FileLogger();
		$logger->setFilename("test.txt");
		
		//var_dump($this->result_array);
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
          $objPHPExcel->getActiveSheet()->setShowGridlines(false);
      //  $purchase_plan_array = $this->result_array;
		$purchase_plan_array = Procurement::structurePurchasePlan($this->result_array); 
		$logger=new FileLogger();
		$logger->setFilename("test.txt");
		$default_starting_cell_value = 1;
		$details_header_section = 1;
		$j_limit = 5;
		$cell_value =0;
		$fulfillmentCenter = new FulfillmentCentre($this->id_fc);
		$cell_value++;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value.':G'.$cell_value)->applyFromArray(array(           
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )),
				'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF'),'size'=>14,'name' => 'Verdana'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F'))
				));
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$cell_value.':D'.$cell_value);
		$objPHPExcel->getActiveSheet()->mergeCells('E'.$cell_value.':G'.$cell_value);
		 $objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Procurement Plan-".$fulfillmentCenter->city_name);
		 $objPHPExcel->getActiveSheet()->setCellValue('E'.$cell_value, "Date:".date("d/m/Y"));
		 $cell_value++;
		 $total_buying_price=array();
		 $total_selling_price_summary=array();
		 $total_summary_vendor = array();
		 $total_summary=array();
		 $count = sizeof($purchase_plan_array);

 		for($i = $count - 1; $i >= 0; $i--)
		{
			$vendor_header_limit = $default_starting_cell_value + $j_limit;
 			/*Each vendor Header Part Starts Here*/
			 if($purchase_plan_array[$i]['name_vendor'])
				$vendor_name =$purchase_plan_array[$i]['name_vendor'];
			 else
				 $vendor_name = "Other";
			 
 			 if($purchase_plan_array[$i]['details'][0]['vendor'][0]['address1'])
				$vendor_address =$purchase_plan_array[$i]['details'][0]['vendor'][0]['address1'];
			 else
				 $vendor_address = "---";
			 
			if($purchase_plan_array[$i]['details'][0]['vendor'][0]['phone'])
				$vendor_phone =$purchase_plan_array[$i]['details'][0]['vendor'][0]['phone'];
			 else
				 $vendor_phone = "---";
			 
 			if($purchase_plan_array[$i]['details'][0]['vendor'][0]['Payment_Name'])
				$vendor_payment_name =$purchase_plan_array[$i]['details'][0]['vendor'][0]['Payment_Name'];
			 else
				 $vendor_payment_name = "---";
			 
 			if($purchase_plan_array[$i]['details'][0]['vendor'][0]['comments'])
				$vendor_comments =$purchase_plan_array[$i]['details'][0]['vendor'][0]['comments'];
			 else
				 $vendor_comments = "---";
 			
 			
			 
  			  $cell_value++;
			   $objPHPExcel->getActiveSheet()->mergeCells('B'.$cell_value.':F'.$cell_value);
			  $objPHPExcel->getActiveSheet()->getStyle('B'.$cell_value.':F'.$cell_value)->applyFromArray(array(           
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF')),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F'))
				));
 			  $objPHPExcel->getActiveSheet()->setCellValue('B'.$cell_value, "Vendor Details");
			  
 			  $cell_value++;
			   $objPHPExcel->getActiveSheet()->mergeCells('B'.$cell_value.':D'.$cell_value)->mergeCells('E'.$cell_value.':F'.$cell_value);
 				$objPHPExcel->getActiveSheet()->getStyle('B'.$cell_value.':F'.$cell_value)->applyFromArray(array(           
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
 			  $objPHPExcel->getActiveSheet()->setCellValue('B'.$cell_value, "Vendor Name");
			  $objPHPExcel->getActiveSheet()->setCellValue('E'.$cell_value,  $vendor_name);
			  
 			  $cell_value++;
			   $objPHPExcel->getActiveSheet()->mergeCells('B'.$cell_value.':D'.$cell_value)->mergeCells('E'.$cell_value.':F'.$cell_value);
			 $objPHPExcel->getActiveSheet()->getStyle('B'.$cell_value.':F'.$cell_value)->applyFromArray(array(           
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
			  $objPHPExcel->getActiveSheet()->setCellValue('B'.$cell_value, "Address"); 
			  $objPHPExcel->getActiveSheet()->setCellValue('E'.$cell_value, $vendor_address);
			  
 			  $cell_value++;
			   $objPHPExcel->getActiveSheet()->mergeCells('B'.$cell_value.':D'.$cell_value)->mergeCells('E'.$cell_value.':F'.$cell_value);
			  $objPHPExcel->getActiveSheet()->getStyle('B'.$cell_value.':F'.$cell_value)->applyFromArray(array(           
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
			  $objPHPExcel->getActiveSheet()->setCellValue('B'.$cell_value, "Phone No");
			  $objPHPExcel->getActiveSheet()->setCellValue('E'.$cell_value, $vendor_phone);
			  
 			  $cell_value++;
			   $objPHPExcel->getActiveSheet()->mergeCells('B'.$cell_value.':D'.$cell_value)->mergeCells('E'.$cell_value.':F'.$cell_value);
			  $objPHPExcel->getActiveSheet()->getStyle('B'.$cell_value.':F'.$cell_value)->applyFromArray(array(           
				'borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
				
			  $objPHPExcel->getActiveSheet()->setCellValue('B'.$cell_value, "Payment Mode");
			  $objPHPExcel->getActiveSheet()->setCellValue('E'.$cell_value, $vendor_payment_name);
			  
 			  $cell_value++;
			   $objPHPExcel->getActiveSheet()->mergeCells('B'.$cell_value.':D'.$cell_value)->mergeCells('E'.$cell_value.':F'.$cell_value);
			 $objPHPExcel->getActiveSheet()->getStyle('B'.$cell_value.':F'.$cell_value)->applyFromArray(array(           
				'borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
				 
			  $objPHPExcel->getActiveSheet()->setCellValue('B'.$cell_value, "Comments");
			  $objPHPExcel->getActiveSheet()->setCellValue('E'.$cell_value, $vendor_comments);
			  $cell_value = $cell_value +2;
 		 /*Each vendor Header Part Ends Here*/
		 
		 /*Vendor Wise Details Starts here*/
		 $details_header_section = $default_starting_cell_value + 1;
 		  
 		  
			    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value.':G'.$cell_value)->applyFromArray(array(
				'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF')),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN )),'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F'))));
 				$objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Product Name")->setCellValue('B'.$cell_value, "Reference")->setCellValue('C'.$cell_value, "Order Id's")->setCellValue('D'.$cell_value, "QTY")->setCellValue('E'.$cell_value, "Buying Price")->setCellValue('F'.$cell_value, "Selling Price")->setCellValue('G'.$cell_value, "Alternate Vendor");
				$cell_value++;
				$total_buying_price =0;
				$total_selling_price =0;
				for($k=0; $k<sizeof($purchase_plan_array[$i]['details']); $k++ )
				{
 					if(!(float)( $purchase_plan_array[$i]['details'][$k]['buying_vendor1_price']))
						$buyingprice = 0;
					else
						$buyingprice = $purchase_plan_array[$i]['details'][$k]['buying_vendor1_price'];
					
					if(!(float)($purchase_plan_array[$i]['details'][$k]['buying_vendor2_price']))
						$buyingprice2 = 0;
					else
						$buyingprice2 = $purchase_plan_array[$i]['details'][$k]['buying_vendor2_price'];
					
				
					$selling_price = $purchase_plan_array[$i]['details'][$k]['selling_price'];
					$total_buying_price += floatval($buyingprice);
					$total_selling_price += floatval($selling_price);
					
					$order_id = $purchase_plan_array[$i]['details'][$k]['id_order'];
					$productname = $purchase_plan_array[$i]['details'][$k]['product_name'];
					$reference = $purchase_plan_array[$i]['details'][$k]['reference'];
					$product_quantity = $purchase_plan_array[$i]['details'][$k]['product_quantity'];
					$buying_vendor2_name = $purchase_plan_array[$i]['details'][$k]['buying_vendor2_name'];
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value.':G'.$cell_value)->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
					
					
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, $productname)->setCellValue('B'.$cell_value, $reference)->setCellValue('C'.$cell_value, $order_id)->setCellValue('D'.$cell_value, $product_quantity)->setCellValue('E'.$cell_value, $buyingprice)->setCellValue('F'.$cell_value, $selling_price)->setCellValue('G'.$cell_value, $buying_vendor2_name."/".$buyingprice2);
					
					
					 $objPHPExcel->getActiveSheet()->getStyle('G'.$cell_value)->applyFromArray(array(           
		'borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
					$cell_value++;
					 
					if($k == (sizeof($purchase_plan_array[$i]['details'])-1))
					{
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value .':G'.$cell_value)->applyFromArray(array( 
						'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF')),
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
						'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F')),
						'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));			
	
						 $objPHPExcel->getActiveSheet()->mergeCells('A'.$cell_value.':D'.$cell_value)->setCellValue('E'.$cell_value, $total_buying_price)->setCellValue('F'.$cell_value, $total_selling_price);
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Total Value");
						$cell_value++;
						$total_summary[$i]['summary_vendor'] = $vendor_name;
						$total_summary[$i]['summary_buying_price'] = $total_buying_price;
						$total_summary[$i]['summary_selling_price'] = $total_selling_price;
						//array_push($total_summary,$vendor_name,$total_buying_price_summary,$total_selling_price );
						
					}
				}
		
		}
		 $cell_value++;
		 $objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value .':F'.$cell_value)->applyFromArray(array( 
		'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF')),
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F')),
		'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
		 $objPHPExcel->getActiveSheet()->mergeCells('A' . $cell_value. ':' . 'F' . $cell_value);
		 $objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Procurement Plan Summary");
		 $cell_value++;
		 
		  $objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value .':F'.$cell_value)->applyFromArray(array( 
		'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF')),
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F')),
		'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
		
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $cell_value. ':' . 'D' . $cell_value)->mergeCells('E' . $cell_value. ':' . 'F' . $cell_value);
		 $objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Vendor Name")->setCellValue('B'.$cell_value,"Buying Total")->setCellValue('E'.$cell_value,"Selling Total");
		 $cell_value++;
		 //$logger->logError("sizeof summary".sizeof($total_summary));
		 $summary_total_buying_price =0;
		 $summary_total_selling_price =0;
  		for($n =0;$n<sizeof($total_summary);$n++)
		{
			 
			$objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value.':F'.$cell_value)->applyFromArray(array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
			$objPHPExcel->getActiveSheet()->mergeCells('B' . $cell_value. ':' . 'D' . $cell_value)->mergeCells('E' . $cell_value. ':' . 'F' . $cell_value);
			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, $total_summary[$n]['summary_vendor'])->setCellValue('B'.$cell_value, $total_summary[$n]['summary_buying_price'])->setCellValue('E'.$cell_value, $total_summary[$n]['summary_selling_price']);
			$summary_total_buying_price += floatval($total_summary[$n]['summary_buying_price']);
			$summary_total_selling_price += floatval($total_summary[$n]['summary_selling_price']);
			$cell_value++;
		}
		  
		
		
		 $objPHPExcel->getActiveSheet()->getStyle('A'.$cell_value .':F'.$cell_value)->applyFromArray(array( 
		'font' => array('bold' => true,'color' => array('rgb' => 'FFFFFF')),
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'CF000F'),'endcolor' => array('argb' => 'CF000F')),
		'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN ))));
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $cell_value. ':' . 'D' . $cell_value)->mergeCells('E' . $cell_value. ':' . 'F' . $cell_value);
		
		 $objPHPExcel->getActiveSheet()->setCellValue('A'.$cell_value, "Total Summary")->setCellValue('B'.$cell_value, $summary_total_buying_price)->setCellValue('E'.$cell_value, $summary_total_selling_price);

        
        ################################## /HEADER TABLE ################################
        
        
         // Set fills
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
         
        // Set autofilter
        // Always include the complete filter range!
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $sharedStyle2 = new PHPExcel_Style();
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $download_filename  = $fulfillmentCenter->city_name."-Procurementplan-".date("d/m/Y").".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
    }
}
?> 
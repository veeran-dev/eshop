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

class RmCustomerBills
{
    
    public function CustomerBillsExcel($id_group,$id_month,$id_relationship_manager)
    {
 
        $this->id_group = $id_group;
        $this->id_month = $id_month;
        $this->id_relationship_manager = $id_relationship_manager;
		 
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
		
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "S.No.")->setCellValue('B1', "Product Name")->setCellValue('C1', "Product Code")->setCellValue('D1', "QTY")->setCellValue('E1', "Unit Price (Tax Excl.)")->setCellValue('F1', "Tax Rate")->setCellValue('G1', "Unit Price (Tax Incl.)")->setCellValue('H1', "Category Path")->setCellValue('I1', "User Name")->setCellValue('J1', "Location");
		
		if(date('m')==1 && $this->id_month==12 || date('m')==1 && $this->id_month==11)
			$year = date('Y')-1;
		elseif(date('m')==2 && $this->id_month==12 )
			$year = date('Y')-1;
		else
			$year = date('Y');
        $sql = 'SELECT pl.`name`,p.`reference` , SUM(`product_quantity`-`product_quantity_refunded`-`product_quantity_return`) AS qty,`unit_price_tax_excl` AS unit_price,t.rate as tax_rate,((`unit_price_tax_excl`*t.rate/100)+`unit_price_tax_excl`) AS unit_price_tax_incl,
		(SELECT REPLACE(GROUP_CONCAT(cl.name," > "),",","")
		FROM '._DB_PREFIX_.'category c
		LEFT JOIN '._DB_PREFIX_.'category_lang cl ON (cl.id_category = c.id_category)
		WHERE c.nleft <= (SELECT m.`nleft` FROM '._DB_PREFIX_.'category m WHERE m.`id_category` = p.`id_category_default`)
		AND c.nright >= (SELECT n.`nright` FROM '._DB_PREFIX_.'category n WHERE n.`id_category` = p.`id_category_default`)
		AND c.nleft >= 2
		AND c.nright <= 4101
		AND cl.id_lang = 1
		AND c.active = 1
		AND c.level_depth > 0
		ORDER BY c.level_depth ASC) AS Category_path , c.`firstname` AS user_name , a.`city`, gl.name as group_name
		FROM '._DB_PREFIX_.'product p, '._DB_PREFIX_.'customer c, '._DB_PREFIX_.'orders AS o , '._DB_PREFIX_.'product_lang pl,'._DB_PREFIX_.'order_detail AS od,'._DB_PREFIX_.'address a, '._DB_PREFIX_.'group_lang as gl ,'._DB_PREFIX_.'order_history as oh,`'._DB_PREFIX_.'order_detail_tax` odt, `'._DB_PREFIX_.'tax` t	
		WHERE  
		 o.id_customer = c.id_customer
		AND o.`id_order` = od.id_order
		AND od.product_id = p.id_product
		AND t.id_tax = odt.id_tax
		AND od.`id_order_detail` = odt.id_order_detail
		AND pl.`id_lang` = 1
		AND c.`id_relationship_manager`='.$this->id_relationship_manager.'
		AND MONTH(o.`date_add`) = '.$this->id_month.'
		AND YEAR(o.`date_add`) = '.$year.'
		AND c.`id_default_group` = '.$this->id_group.'
		AND gl.id_group =  c.`id_default_group`
		AND p.`id_product` = pl.`id_product` 
		AND a.id_address = o.`id_address_delivery`
		AND gl.id_lang = 1
		AND oh.`id_order` = o.`id_order`
		AND oh.id_Order_history IN(
										SELECT  MAX(oha.`id_order_history`)
										FROM '._DB_PREFIX_.'order_history AS oha
										WHERE o.id_order = oha.id_order
										GROUP BY oha.id_order
									)
		AND  oh.`id_order_state` NOT IN(6,7,8,9,10,11,12,13,14,15,16,23,24,27,30,45 )
		GROUP BY od.`product_id`';
 
		$result = Db::getInstance()->ExecuteS($sql);
           ################################## /HEADER TABLE ################################
        $original_array = array(
				'0',
				'1'
			);
			array_splice($original_array, 2, 0, $result);
			
			$i = 2;
			$j = 0;
			$groupname;
			for ($i = $i; $i < sizeof($original_array); $i++) 
			{
 				$groupname = $original_array[$i]['group_name'];
				$groupname=str_replace(" ","_",$groupname);
 				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ++$j)->setCellValue('B' . $i, $original_array[$i]['name'])->setCellValue('C' . $i, $original_array[$i]['reference'])->setCellValue('D' . $i, $original_array[$i]['qty'])->setCellValue('E' . $i, $original_array[$i]['unit_price'])->setCellValue('F' . $i, $original_array[$i]['tax_rate'])->setCellValue('G' . $i, $original_array[$i]['unit_price_tax_incl'])->setCellValue('H' . $i, $original_array[$i]['Category_path'])->setCellValue('I' . $i,$original_array[$i]['user_name'])->setCellValue('J' . $i, $original_array[$i]['city']);
			}
			
             $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('CF000F');
            
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
            $column="A1:H1";
        
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
         $date_month =date('M',mktime(0, 0, 0, $this->id_month, 10));
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
         $download_filename  = $groupname.'_'.$date_month.'_Bills.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
     }
}
?> 
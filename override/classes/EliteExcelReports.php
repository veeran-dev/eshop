<?php
/*
* Author: Elumalai K
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class EliteExcelReportsCore extends FrontController
{
    public $customerid;
    public $duration;
    public $orderid;
    public $from_date;
    public $to_date;
    public $location;
    public $addressId;
    public $mailTo;
    public $sendMail;
    public $message;

    public function generatePurchaseReport() 
    {
        $customerObj = new Customer((int)($this->customerid));
        $customerGroup = new Group((int)($customerObj->id_default_group));

        $durationText = "Nil";

        if($this->from_date == "" || $this->to_date == "") 
        {
            if($this->duration == 5)
                $durationText = "All Time";
            else if($this->duration == 4)
                $durationText = "Month";
            else if($this->duration == 3)
                $durationText = "Week";
            else if($this->duration == 2)
                $durationText = "Day";
            else
                $durationText = "Now";
        }

        // Specific price object initialization
        $orderObj = new Order();

        if($this->location != "") {
            $stateObj = new State((int)($this->location));
            $locationName = $stateObj->name;
        }
        else {
            $locationName = "All";
        }

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster.com")->setLastModifiedBy("Kobster.com")->setTitle("Purchase history report")->setSubject("Purchase history report")->setDescription("Purchase history report")->setKeywords("Purchase history report")->setCategory("Purchase history report");
        
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

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

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(14.86);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:C5');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:C6');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:C7');
        $objPHPExcel->getActiveSheet()->mergeCells('A8:C8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:C9');
        $objPHPExcel->getActiveSheet()->mergeCells('A10:C10');

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(_PS_ROOT_DIR_.'/classes/PHPExcel/img/logo_invoice.jpg');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(75);
        $objDrawing->setWidth(170);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setCellValue('C1', "Dated : " . date("Y/m/d"));
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue('A4', "Purchase History Report");
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFont()->setName('Verdana');
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.'6', "Duration: ".$durationText)
                                      ->setCellValue('A'.'7', "From Date: ".($this->from_date ? $this->from_date : "Nil"))
                                      ->setCellValue('A'.'8', "To Date: ".($this->to_date ? $this->to_date : "Nil"))
                                      ->setCellValue('A'.'9', "Location: ".($locationName ? $locationName : "Nil"));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.'10', "");

        $objPHPExcel->getActiveSheet()->getStyle('A11:C11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A11:C11')->getFill()->getStartColor()->setARGB('CF000F');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.'11', "S.No")
                                      ->setCellValue('B'.'11', "Month")
                                      ->setCellValue('C'.'11', "Purchase Value (Rs)");
        $objPHPExcel->getActiveSheet()->getStyle('A11')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('B11')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray($styleArrayTable);
        $cols = array("A", "B", "C");
        $result = $orderObj->getHistoryReport($this->customerid, $this->duration, $this->addressId, $this->from_date, $this->to_date, $this->location);
        
        $totalValue = 0;

        if($result){
            $j = 12; $k = 1;
            foreach($result as $row)
            {
                $i = 0;
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $k);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['label']);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['y']);
                $totalValue += $row['y'];
                $j++; $k++;
            }

            $objPHPExcel->getActiveSheet()->getStyle('A' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('B' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('C' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . (int)($j), "Total");
            $objPHPExcel->getActiveSheet()->setCellValue('C' . (int)($j), $totalValue);
        }

        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $download_filename  = $this->customerid . "-purchase-history" . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        
        if($this->sendMail) {
            $objWriter->save(_PS_ROOT_DIR_.'/temp/'.$download_filename);
            $templateVars['{firstname}'] = $customerObj->firstname;
            $templateVars['{lastname}'] = $customerObj->lastname;
            $templateVars['{message}'] = $this->message;
            $templateVars['{report_img}'] = ""; //Image to be displayed in the message 
            $templateVars['{mailTo}'] = $this->mailTo;
            $templateVars['{company}'] = $customerGroup->name[1];
         
            $id_lang = Language::getIdByIso('en');  //Set the English mail template
            $template_name = 'elite_email_share'; //Specify the template file name
            $title = Mail::l('Purchase History Report from '.$customerObj->firstname.' - Kobster.com'); //Mail subject with translation
            $from = $customerObj->email;   //Sender's email
            $fromName = $customerObj->firstname." ".$customerObj->lastname; //Sender's name
         
            $fileAttachment['content'] = file_get_contents(_PS_ROOT_DIR_.'/temp/'.$download_filename); //File path
            $fileAttachment['name'] = $download_filename; //Attachment filename
            $fileAttachment['mime'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'; //mime file type
         
            $send = Mail::Send(
                            $id_lang, 
                            $template_name, 
                            $title, 
                            $templateVars, 
                            explode(",", $this->mailTo),
                            NULL, 
                            NULL, 
                            NULL, 
                            $fileAttachment
                        );
         
            if ($send)
                echo 1;
            else
                echo 2;
        }
        else {
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename= ' . $download_filename . '');
            $objWriter->save('php://output');
        }

        exit;
    }

    public function generateCategoryReport() 
    {
        $customerObj = new Customer((int)($this->customerid));
        $customerGroup = new Group((int)($customerObj->id_default_group));

        $durationText = "Nil";

        if($this->from_date == "" || $this->to_date == "") 
        {
            if($this->duration == 5)
                $durationText = "All Time";
            else if($this->duration == 4)
                $durationText = "Month";
            else if($this->duration == 3)
                $durationText = "Week";
            else if($this->duration == 2)
                $durationText = "Day";
            else
                $durationText = "Now";
        }

        // Specific price object initialization
        $orderObj = new Order();

        if($this->location != "") {
            $stateObj = new State((int)($this->location));
            $locationName = $stateObj->name;
        }
        else {
            $locationName = "All";
        }

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster.com")->setLastModifiedBy("Kobster.com")->setTitle("Categories Report")->setSubject("Categories Report")->setDescription("Categories Report")->setKeywords("Categories Report")->setCategory("Categories Report");
        
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        //Write Data
        //Header
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

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(14.86);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:C5');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:C6');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:C7');
        $objPHPExcel->getActiveSheet()->mergeCells('A8:C8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:C9');
        $objPHPExcel->getActiveSheet()->mergeCells('A10:C10');

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(_PS_ROOT_DIR_.'/classes/PHPExcel/img/logo_invoice.jpg');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(75);
        $objDrawing->setWidth(170);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setCellValue('C1', "Dated : " . date("Y/m/d"));
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue('A4', "Categories Report");
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFont()->setName('Verdana');
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.'6', "Duration: ".$durationText)
                                      ->setCellValue('A'.'7', "From Date: ".($this->from_date ? $this->from_date : "Nil"))
                                      ->setCellValue('A'.'8', "To Date: ".($this->to_date ? $this->to_date : "Nil"))
                                      ->setCellValue('A'.'9', "Location: ".($locationName ? $locationName : "Nil"));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.'10', "");

        $objPHPExcel->getActiveSheet()->getStyle('A11:C11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A11:C11')->getFill()->getStartColor()->setARGB('CF000F');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.'11', "S.No")
                                      ->setCellValue('B'.'11', "Category")
                                      ->setCellValue('C'.'11', "Purchase Value (Rs)");
        $objPHPExcel->getActiveSheet()->getStyle('A11')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('B11')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray($styleArrayTable);
        $cols = array("A", "B", "C");

        $result = $orderObj->getRatioHistoryReport($this->customerid, $this->orderid, $this->duration, $this->addressId, 0, $this->from_date, $this->to_date, $this->location);
        
        $totalValue = 0;

        if($result){
            $j = 12; $k = 1;
            foreach($result as $row)
            {
                $i = 0;
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $k);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['category']);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['y']);
                $totalValue += $row['y'];
                $j++; $k++;
            }

            $objPHPExcel->getActiveSheet()->getStyle('A' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('B' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('C' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . (int)($j), "Total");
            $objPHPExcel->getActiveSheet()->setCellValue('C' . (int)($j), $totalValue);
        }
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $download_filename  = $this->customerid . "-category-report" . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        
        if($this->sendMail) {
            $objWriter->save(_PS_ROOT_DIR_.'/temp/'.$download_filename);
            $templateVars['{firstname}'] = $customerObj->firstname;
            $templateVars['{lastname}'] = $customerObj->lastname;
            $templateVars['{message}'] = $this->message;
            $templateVars['{report_img}'] = ""; //Image to be displayed in the message 
            $templateVars['{mailTo}'] = $this->mailTo;
            $templateVars['{company}'] = $customerGroup->name[1];
         
            $id_lang = Language::getIdByIso('en');  //Set the English mail template
            $template_name = 'elite_email_share'; //Specify the template file name
            $title = Mail::l('Purchase History Report from '.$customerObj->firstname.' - Kobster.com'); //Mail subject with translation
            $from = $customerObj->email;   //Sender's email
            $fromName = $customerObj->firstname." ".$customerObj->lastname; //Sender's name
         
            $fileAttachment['content'] = file_get_contents(_PS_ROOT_DIR_.'/temp/'.$download_filename); //File path
            $fileAttachment['name'] = $download_filename; //Attachment filename
            $fileAttachment['mime'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'; //mime file type
         
            $send = Mail::Send(
                            $id_lang, 
                            $template_name, 
                            $title, 
                            $templateVars, 
                            explode(",", $this->mailTo),
                            NULL, 
                            NULL, 
                            NULL, 
                            $fileAttachment
                        );
         
            if ($send)
                echo 1;
            else
                echo 2;
        }
        else {
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename= ' . $download_filename . '');
            $objWriter->save('php://output');
        }

        exit;
    }

    public function generateLocationReport() 
    {
        $customerObj = new Customer((int)($this->customerid));
        $customerGroup = new Group((int)($customerObj->id_default_group));

        $durationText = "Nil";

        if($this->from_date == "" || $this->to_date == "") 
        {
            if($this->duration == 5)
                $durationText = "All Time";
            else if($this->duration == 4)
                $durationText = "Month";
            else if($this->duration == 3)
                $durationText = "Week";
            else if($this->duration == 2)
                $durationText = "Day";
            else
                $durationText = "Now";
        }

        // Specific price object initialization
        $orderObj = new Order();

        if($this->location != "") {
            $stateObj = new State((int)($this->location));
            $locationName = $stateObj->name;
        }
        else {
            $locationName = "All";
        }

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster.com")->setLastModifiedBy("Kobster.com")->setTitle("Location Based Report")->setSubject("Location Based Report")->setDescription("Location Based Report")->setKeywords("Location Based Report")->setCategory("Location Based Report");
        
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        //Write Data
        //Header
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

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(14.86);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);


        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:D6');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:D7');
        $objPHPExcel->getActiveSheet()->mergeCells('A8:D8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:C9');
        $objPHPExcel->getActiveSheet()->mergeCells('A10:C10');

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(_PS_ROOT_DIR_.'/classes/PHPExcel/img/logo_invoice.jpg');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(75);
        $objDrawing->setWidth(170);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Dated : " . date("Y/m/d"));
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue('A4', "Location Based Report");
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFont()->setName('Verdana');
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.'6', "Duration: ".$durationText)
                                      ->setCellValue('A'.'7', "From Date: ".($this->from_date ? $this->from_date : "Nil"))
                                      ->setCellValue('A'.'8', "To Date: ".($this->to_date ? $this->to_date : "Nil"))
                                      ->setCellValue('A'.'9', "Location: ".($locationName ? $locationName : "Nil"));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.'10', "");

        $objPHPExcel->getActiveSheet()->getStyle('A11:D11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A11:D11')->getFill()->getStartColor()->setARGB('CF000F');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.'11', "S.No")
                                      ->setCellValue('B'.'11', "City")
                                      ->setCellValue('C'.'11', "State")
                                      ->setCellValue('D'.'11', "Purchase Value (Rs)");
        $objPHPExcel->getActiveSheet()->getStyle('A11')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('B11')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray($styleArrayTable);
        $objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray($styleArrayTable);
        $cols = array("A", "B", "C", "D");

        $result = $orderObj->getLocationBasedReport($this->customerid, $this->duration, $this->from_date, $this->to_date, $this->location);
        
        $totalValue = 0;

        if($result){
            $j = 12; $k = 1;
            foreach($result as $row)
            {
                $i = 0;
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $j)->applyFromArray($styleArrayTable);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $k);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['city']);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['state_name']);
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i++]."".$j, $row['y']);
                $totalValue += $row['y'];
                $j++; $k++;
            }

            $objPHPExcel->getActiveSheet()->getStyle('A' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('B' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('C' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->getStyle('D' . (int)($j))->applyFromArray($styleArrayTable);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . (int)($j), "Total");
            $objPHPExcel->getActiveSheet()->setCellValue('D' . (int)($j), $totalValue);
        }
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $download_filename  = $this->customerid . "-location-report" . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        if($this->sendMail) {
            $objWriter->save(_PS_ROOT_DIR_.'/temp/'.$download_filename);
            $templateVars['{firstname}'] = $customerObj->firstname;
            $templateVars['{lastname}'] = $customerObj->lastname;
            $templateVars['{message}'] = $this->message;
            $templateVars['{report_img}'] = ""; //Image to be displayed in the message 
            $templateVars['{mailTo}'] = $this->mailTo;
            $templateVars['{company}'] = $customerGroup->name[1];
         
            $id_lang = Language::getIdByIso('en');  //Set the English mail template
            $template_name = 'elite_email_share'; //Specify the template file name
            $title = Mail::l('Purchase History Report from '.$customerObj->firstname.' - Kobster.com'); //Mail subject with translation
            $from = $customerObj->email;   //Sender's email
            $fromName = $customerObj->firstname." ".$customerObj->lastname; //Sender's name
         
            $fileAttachment['content'] = file_get_contents(_PS_ROOT_DIR_.'/temp/'.$download_filename); //File path
            $fileAttachment['name'] = $download_filename; //Attachment filename
            $fileAttachment['mime'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'; //mime file type
         
            $send = Mail::Send(
                            $id_lang, 
                            $template_name, 
                            $title, 
                            $templateVars, 
                            explode(",", $this->mailTo),
                            NULL, 
                            NULL, 
                            NULL, 
                            $fileAttachment
                        );
         
            if ($send)
                echo 1;
            else
                echo 2;
        }
        else {
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename= ' . $download_filename . '');
            $objWriter->save('php://output');
        }
        exit;
    }
}
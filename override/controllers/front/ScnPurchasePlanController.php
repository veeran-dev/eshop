<?php
class ScnPurchasePlanControllerCore extends BackController
{
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$id_fc = Tools::getValue('id_fc');

		if($type == 1)
		{
			$fc = new FulfillmentCentre();
			$result = $fc->getAllFCentres();
			echo Tools::jsonEncode($result);
		}
		else if($type == 2)
		{
			$vendor_details = Procurement::generatePurchasePlan($id_fc);
			$vendor_details_structure = Procurement::structurePurchasePlan($vendor_details);		
			echo Tools::jsonEncode($vendor_details_structure);
		}
	}

	public function generateNewPurchasePlanReport() {
 		$id_fc = Tools::getValue('id_fc');

 		$result = Procurement::getNewPurchasePlan($id_fc);

		// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Initialize active sheet
		$activeSheet = $objPHPExcel->getActiveSheet();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kobster.com")->setLastModifiedBy("Kobster.com")->setTitle("New Purchase Plan")->setSubject("New Purchase Plan")->setDescription("New Purchase Plan")->setKeywords("New Purchase Plan")->setCategory("New Purchase Plan");
        
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setFitToPage(true);
        $activeSheet->setShowGridlines(true);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

		//Write Data header
		$activeSheet->setCellValue('A'.'1', "S. No")
			->setCellValue('B'.'1', "Order No")
			->setCellValue('C'.'1', "Product Code")
			->setCellValue('D'.'1', "Product Name")
			->setCellValue('E'.'1', "Quantity")
			->setCellValue('F'.'1', "Selling Price (Tax Excl)")
			->setCellValue('G'.'1', "GST Rate %")
			->setCellValue('H'.'1', "Vendor Name")
			->setCellValue('I'.'1', "Buying Price (Tax Excl)")
			->setCellValue('J'.'1', "Payment Mode")
			->setCellValue('K'.'1', "Procurement Executive")
			->setCellValue('L'.'1', "EOD Report")
			->setCellValue('M'.'1', "Reason")
			->setCellValue('N'.'1', "Vendors Enquired");

		$activeSheet->getStyle('A1:N1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $activeSheet->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('008000');
        $activeSheet->getStyle('H1:K1')->getFill()->getStartColor()->setARGB('F7CA18');
        $activeSheet->getStyle('L1:N1')->getFill()->getStartColor()->setARGB('C0504D');
		
		$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N");

		if($result){
			$j = 2; $k = 0;
			foreach($result as $row)
			{
				$i = 0;
				$activeSheet->setCellValue($cols[$i++]."".$j, (++$k))
					->setCellValue($cols[$i++]."".$j, $row['id_order'])
					->setCellValue($cols[$i++]."".$j, $row['reference'])
					->setCellValue($cols[$i++]."".$j, $row['product_name'])
					->setCellValue($cols[$i++]."".$j, $row['product_quantity'])
					->setCellValue($cols[$i++]."".$j, Tools::ps_round($row['selling_tax_exclusive'], _PS_PRICE_COMPUTE_PRECISION_))
					->setCellValue($cols[$i++]."".$j, $row['gst_rate']);
				$j++;
			}
		}

		// Set auto expand size for columns
		foreach ($cols as $key => $column) {
			$activeSheet->getColumnDimension($column)->setAutoSize(true);
		}
		
		$fc = new FulfillmentCentre($id_fc);
        $fc_string_to_array = explode(' ', $fc->city_name);
        $download_filename  = join('-', $fc_string_to_array)."-".date("d-m-Y")."-procurement-plan" . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= ' . $download_filename . '');
        $objWriter->save('php://output');
        exit;
	}
 }
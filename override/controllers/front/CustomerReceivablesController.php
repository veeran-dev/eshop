<?php
Class CustomerReceivablesController extends BackController{
	public function ajaxReturn(){

		$type = isset($_POST['type'])?$_POST['type']:0;
		$invoice_number = isset($_POST['invoice_number'])?$_POST['invoice_number']:0;
		$id_group = isset($_POST['id_group'])?$_POST['id_group']:0;
		$id_employee = isset($_POST['id_employee'])?$_POST['id_employee']:0;
		$total_amount = isset($_POST['total_amount'])?$_POST['total_amount']:0;
		$invoice_amount = isset($_POST['invoice_amount'])?$_POST['invoice_amount']:0;
		$mode = isset($_POST['mode'])?$_POST['mode']:0;
		$particulars = isset($_POST['particulars'])?$_POST['mode']:"";
		$bank_name = isset($_POST['bank_name'])?$_POST['bank_name']:0;
		$acc_no = isset($_POST['acc_no'])?$_POST['acc_no']:0;
		$reference = isset($_POST['reference'])?$_POST['reference']:0;
		$received_on = isset($_POST['received_on'])?$_POST['received_on']:0;
		$id_customer_receivables = isset($_POST['id_customer_receivables'])?$_POST['id_customer_receivables']:0;
		$id_customer_receivables_details = isset($_POST['id_customer_receivables_details'])?$_POST['id_customer_receivables_details']:0;

		if($type == 1){
			$customerReceivables = new CustomerReceivables();
			$customerReceivables->id_group = $id_group;
			$customerReceivables->amount = $total_amount;
			$customerReceivables->particulars = $particulars;
			$customerReceivables->id_employee = $id_employee;
			if($customerReceivables->save()){
				$result = 0;
				foreach ($invoices as $invoice_details) {
					if(!$customerReceivables->addPaymentDetails($customerReceivables->id, $invoice_details['invoice_number'], $invoice_details['amount'], $mode, $bank_name, $acc_no, $reference, $received_on )){
						$result = 1;
						break;
					}
				}
				if($result == 1){
					echo "404";
				}
			}
			else{
				echo "404";
			}
		}
		else if($type == 2){
			$customerReceivables = new CustomerReceivables($id_customer_receivables_details);
			$customerReceivables->id_group = $id_group;
			$customerReceivables->amount = $total_amount;
			$customerReceivables->particulars = $particulars;
			$customerReceivables->id_employee = $id_employee;
			if($customerReceivables->update()){
				$result = 0;
				foreach ($invoices as $invoice_details) {
					if($invoice_details['deleted'] == 1){
						if(!$customerReceivables->deletePaymentDetails($id_customer_receivables_details)){
							$result = 1;
							break;
						}
						else{
							continue;
						}
					}
					else if(!$customerReceivables->addPaymentDetails($customerReceivables->id, $invoice_details['invoice_number'], $invoice_details['amount'], $mode, $bank_name, $acc_no, $reference, $received_on )){
						$result = 1;
						break;
					}
				}
				if($result == 1){
					echo "404";
				}
			}
			else{
				echo "404";
			}
		}
		else if($type == 3){
			echo json_encode($customerReceivables::customerReceivablesLedgerDetails($id_group));
		}


	}
}
?>
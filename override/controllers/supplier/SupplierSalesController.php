<?php
class SupplierSalesControllerCore extends FrontController
{
	public function  ajaxReturn(){
		$type = Tools::getValue("type");
		$id_supplier = $this->context->cookie->s_id;
		if($type == 1){
			$topCustomer = EliteSupplierCustomer::getTopCustomer();
			$result = json_encode(array('topCustomer'=>$topCustomer,));
 			echo $result;
		}

		if($type == 2){
			$monthlySales = EliteSupplierCustomer::monthlySales();
			$result = json_encode(array('monthlySales'=>$monthlySales,));
 			echo $result;
		}
		if($type == 3){
			$topSoldProducts = EliteSupplierProducts::topSoldProducts($id_supplier);
			$result = json_encode(array('topSoldProducts'=>$topSoldProducts,));
 			echo $result;
		}
		//payments, orders, quotations, monthlyRevenue, ActiveCustomers, SellingProducts
		if($type == 4){

			$supplier = new EliteSupplier($id_supplier);
			$supplierOrders = new EliteSupplierOrders($id_supplier);
			$payments = array(
				'totalDue' => $supplier->totalDue(), 
				'pending' => $supplier->PendingPayment()
				);
			$orders = array(
				'orderStateCount'=>$supplierOrders->getOrdersCountWithStates()
				);
			$quotations = array(
				'newCount' => $supplier->getQuotationRequestsCount($id_supplier, null, null, null),
				'Submitted' => $supplier->getQuotationSubmitted(),
				);
			$monthlyRevenue = array(
				'currentMonthRevenue' => $supplier->currentMonthRevenue(),
				'previousMonthRevenue' => $supplier->previousMonthRevenue(),
				);
			$activeCustomers = array(
				'activeCustomerCurrentMonth' => $supplier->activeCustomerCurrentMonth(),
				'activeCustomerPreviousMonth' => $supplier->activeCustomerPreviousMonth(),
				);
			$sellingProducts = array(
				'currentMonthSellingProducts' => $supplier->currentMonthSellingProducts(),
				'lastMonthSellingProducts' => $supplier->lastMonthSellingProducts(),
				);

			$result = json_encode(
						array('payments' => $payments,
							'orders' => $orders,
							'quotations' => $quotations,
							'monthlyRevenue' => $monthlyRevenue,
							'activeCustomers' => $activeCustomers,
							'sellingProducts' => $sellingProducts)
						);
 			echo $result;
		}
	}	
}
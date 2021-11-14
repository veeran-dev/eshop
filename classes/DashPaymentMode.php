<?php
class DashPaymentModeCore extends PaymentModule
{
	public function cashOnDelivery($cartid, $os_preparation, $total, $name, $mailVars, $currencyid, $sec_key, $split_order = false)
	{
		$this->context->cookie->payment_type = 1;
		return $this->validateOrder($cartid, $os_preparation, $total, $name, NULL, $mailVars, $currencyid, false, $sec_key, $dash = 1, NULL, $split_order);
	}

	public function Cheque($cartid, $os_cheque, $total, $name, $mailVars, $currencyid, $sec_key, $split_order = false)
	{
		$this->context->cookie->payment_type=2;
		return $this->validateOrder($cartid, $os_cheque, $total, $name, NULL, $mailVars, $currencyid, false, $sec_key,$dash = 1, NULL, $split_order);
	}

	public function NEFT($cartid, $os_bankwire, $total, $name, $mailVars, $currencyid, $sec_key, $split_order = false)
	{
		$this->context->cookie->payment_type=3;
		return $this->validateOrder($cartid, $os_bankwire, $total, $name, NULL, $mailVars, $currencyid, false, $sec_key,$dash = 1, NULL, $split_order);
	}

	public function PFA($cartid, $os_pfa, $total, $name, $mailVars, $currencyid, $sec_key, $split_order = false)//Pending for approval
	{
		$this->context->cookie->payment_type=5;
		return $this->validateOrder($cartid, $os_pfa, $total, $name, NULL, $mailVars, $currencyid, false, $sec_key,$dash = 1, NULL, $split_order);
	}

	public function Credit($cartid, $os_credit, $total, $name, $mailVars, $currencyid, $sec_key, $split_order = false)//Pending for approval
	{
		return $this->validateOrder($cartid, $os_credit, $total, $name, NULL, $mailVars, $currencyid, false, $sec_key, $dash = 1, NULL, $split_order);
	}

	public function EBS($cartid, $os_ebs, $total, $name, $mailVars, $currencyid, $sec_key, $split_order = false) {
		$this->context->cookie->payment_type = 4;
		return $this->validateOrder($cartid, $os_ebs, $total, $name, NULL, $mailVars, $currencyid, false, $sec_key, $dash = 1, NULL, $split_order);
	}
}
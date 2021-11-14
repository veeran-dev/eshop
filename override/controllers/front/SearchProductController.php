<?php
class SearchProductControllerCore extends DashController
{
public function ajaxReturn()
{	
		$q=$q=$_GET['q'];
		$customerid = $_GET['id_customer'];
		$search=new CorporateUser();
		$search->search($q,$customerid);

	}
}
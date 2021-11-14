<?php
require(dirname(__FILE__).'/config/config.inc.php');

if( Tools::getValue('values') || !empty($_GET['order_id']))
{
	ControllerFactory::getController('FinanceVatController')->ajaxCall();
}
else
{
	ControllerFactory::getController('FinanceVatController')->getViewPortContent();	
}
?>
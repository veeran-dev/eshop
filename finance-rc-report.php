<?php
require(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

$active = Tools::getValue('status');
$company_id = Tools::getValue('id_group');

new FinanceRateContractReport($active, $company_id);
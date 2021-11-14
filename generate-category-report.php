<?php
/*
By Elumalai K
Kobster.com 2012-2016
*/

require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('DashReportController')->generateCategoryReport();
<?php

require(dirname(__FILE__).'/config/config.inc.php');
$report = new MonthlyKPI();
$data = $report->reportKPI();
?>
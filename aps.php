<?php

require(dirname(__FILE__).'/config/config.inc.php');
$alerts = new MailAlerts();
$data = $alerts->fetchAllPendingPayments();
$alerts->classifyEmails($data);

?>

<?php
/* Created By sreeni. */
require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('PriceUpdateController')->ajaxCall();
?>
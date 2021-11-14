<!--This is for update the corporate userprofile  multiple addresses -->
<?php 
/*<!--This page is use to update the address from the corporateuserprofile.tpl-->*/
require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('AddressController')->ajaxCall();
?>

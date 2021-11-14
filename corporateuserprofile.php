<!--This for Corporate user profile -->
<!--It access the AddressesController to load the user profile and other stuff-->
<?php 
require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('AddressesController')->copprofile();
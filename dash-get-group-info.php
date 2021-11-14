<?php
/*
* 2016-2017 Kobster.com
*
*  @author Elumalai K <elumalai.k@kobster.com>
*  @copyright  2016-2017 Kobster.com
*  @version  Release: $Revision:  $
*/
require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('DashPurchaseController')->ajaxCall();

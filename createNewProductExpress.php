<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Karthik R <karthik@kobster.com>
*  @copyright  2002-2015 Kobster.com
*/

require(dirname(__FILE__).'/config/config.inc.php');
echo ControllerFactory::getController('RMPlaceOrderController')->createNewProductExpress();

<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14006 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class DashIndexControllerCore extends DashController
{
	public $php_self = 'dash-index';
	public $dash = true;
	

	public function displayContent()
	{	
		$customer = new Customer($this->context->cookie->id_customer);
		$buyer_id = $customer->getBuyerId($customer->email);
		
		$this->context->cookie->id_default_group = $customer->id_default_group;
		
		if($buyer_id != 3)
		{
			Tools::redirect('index.php?controller=dash-login');
		}
		else
		{
			parent::displayContent();
			$this->context->smarty->display('dash/dash-index.tpl');	
			$this->context->cookie->payment_type = 0;
		}
	}
}
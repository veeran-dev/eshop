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

class NotificationsController extends FrontController
{
	//public $auth = true;
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$id_notification = Tools::getValue('id_notification');
		$customer = new Customer((int)($this->context->cookie->id_customer));
		$idPage = Tools::getValue('idPage');
		$limit = Tools::getValue('limit');
		$limit && $limit != undefined ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
		$offset = PAGE_PER_NO * $idPage;

		$notificationObj = new Notifications();

		/*** Get notifications on elite topbar ***/
		if($type == 1) {
			$result = $notificationObj->getNotifications($customer->id, false, false, true, true);
			echo Tools::jsonEncode($result);
		}
		/*** Get notifications for individual page ***/
		else if($type == 2) {
			$result = $notificationObj->getNotifications($customer->id, $limit, $offset, false, false);
			if($result['results'])
				$result['total'] = ceil($result['total'] / PAGE_PER_NO);
			echo Tools::jsonEncode($result);
		}
		/*** Notification read updation ***/
		else if($type == 3) {
			$result = $notificationObj->readNotification($id_notification);
			echo Tools::jsonEncode($result);
		}
 	}
}
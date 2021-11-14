<?php
/*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class NotificationsCore extends ObjectModel
{
    /** @var date string for notification add */
    public $name;

    /** @var date string for notification update */
    public $url;
	
    public static $definition = array(
        'table' => 'notification_type_master',
        'primary' => 'id_notification_type',
        'multilang' => false,
        'fields' => array(
            /* Classic fields */
            'name' =>                array('type' => self::TYPE_STRING, 'required' => true),
            'url' =>                    array('type' => self::TYPE_STRING, 'required' => true)
        )
    );

    public function getNotifications($id_customer, $limit = false, $offset = false, $status = false, $notification_get_range = false) 
    {
        $status = $status ? ' AND n.`status` = 0' : '';
        
        if($notification_get_range == true)
            $dataLimit = ($limit && $offset) ? 'LIMIT '.$offset.', '.$limit.'' : 'LIMIT 5';
        else
            $dataLimit = "";

        $sql = 'SELECT SQL_CALC_FOUND_ROWS n.`id_notification`, n.*, c.`firstname`
                FROM `'._DB_PREFIX_.'notification_user` n
                LEFT JOIN `'._DB_PREFIX_.'notification_type_master` nt ON n.`id_notification_type` = nt.`id_notification_type`
                LEFT JOIN `'._DB_PREFIX_.'customer` c ON n.`id_customer` = c.`id_customer`
                WHERE (n.`id_customer` = '.(int)$id_customer.' OR n.`id_customer` = 0) 
                '.$status.'  
                ORDER BY n.`id_notification` DESC '.$dataLimit.'';
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT FOUND_ROWS()');

        if (!$result)
            return array('total' => 0, 'results' => []);

        return array('total' => $total, 'results' => $result);
    }

    public static function addNotification($data) 
    {
        $data = array(
                        'id_customer' => $data['id_customer'], 
                        'id_notification_type' => $data['notification_type'], 
                        'content' => $data['content'],
                        'url' => $data['url'],
                        'status' => 0,
                        'date_add' => date("Y-m-d H:i:s"), 
                        'date_upd' => date("Y-m-d H:i:s")
                    );
        Db::getInstance()->autoExecute(_DB_PREFIX_.'notification_user', $data, 'INSERT');
    }

    public function readNotification($id_notification){
        return Db::getInstance()->autoExecute(_DB_PREFIX_.'notification_user', array('status' => 1), 'UPDATE', 'id_notification = '.$id_notification.'');
    }
}

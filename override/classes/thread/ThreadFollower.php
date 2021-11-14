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

class ThreadFollowerCore extends ObjectModel
{
    /** @var int thread id */
    public $id_thread;

    /** @var int follower of thread */
    public $id_follower;

    /** @var datetime date add **/
    public $date_add;
	
    public static $definition = array(
        'table' => 'thread_followers',
        'primary' => 'id_thread_follower',
        'multilang' => false,
        'fields' => array(
        	'id_thread'	=>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
        	'id_follower'	=>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'date_add'  =>  array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );
}
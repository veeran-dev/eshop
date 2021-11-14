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

class ThreadRequestTypeCore extends ObjectModel
{
    /** @var string name of thread change type **/
    public $name;
	
    /** @const request types **/
    const THREAD_TIMELINE_REQUEST = 1;
    
    public static $definition = array(
        'table' => 'thread_request_types',
        'primary' => 'id_request_type',
        'multilang' => false,
        'fields' => array(
            'name' =>   array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 45)
        )
    );
}
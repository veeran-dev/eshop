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

class BottomLineCore extends ObjectModel
{
    /** @var int is default widget */
    public $firstname;

    /** @var int type of widget. i.e. dashboard widget */
    public $lastname;

    /** @var int widget role */
    public $email;

    /** @var int ratings */
    public $id_country;

    /** @var decimal price */
    public $designation;

    /** @var int widget publishing status **/
    public $date_add;
	
    public static $definition = array(
        'table' => 'bottomline',
        'primary' => 'id_line',
        'multilang' => false,
        'fields' => array(
            /* Classic fields */
            'lastname' =>                    array('type' => self::TYPE_STRING, 'size' => 32),
            'firstname' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'email' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
            'id_country' =>                array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'),
            'designation' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
            'date_add' =>                    array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        )
    );

    public static function alreadyRegistered($email) {
        return Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'bottomline WHERE `email` = \''.pSQL($email).'\'');
    }
}
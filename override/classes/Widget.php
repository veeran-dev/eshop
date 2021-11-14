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

class WidgetCore extends ObjectModel
{
    /** @var int is default widget */
    public $default;

    /** @var int type of widget. i.e. dashboard widget */
    public $type;

    /** @var int widget role */
    public $id_role;

    /** @var decimal price */
    public $price;

    /** @var int ratings */
    public $ratings;

    /** @var int widget publishing status **/
    public $new;

    /** @var int configure variable **/
    public $configure;

    /** @var int active */
    public $active;

    /** @var int Lang id */
    public $id_lang;

    /** @var string Long description */
    public $description;

    /** @var string Short description */
    public $description_short;

     /** @var String name */
    public $name;

    const BUDGET = 17;

	
    public static $definition = array(
        'table' => 'widget',
        'primary' => 'id_widget',
        'multilang' => true,
        'fields' => array(
            /* Classic fields */
            'default' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'type' =>  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'), 
            'id_role' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'price' =>                        array('type' => self::TYPE_FLOAT, 'shop' => true, 'validate' => 'isPrice', 'required' => true),
            'ratings' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'new' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'configure' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active' =>                    array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
            'name' =>                        array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
            'description' =>                array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'description_short' =>            array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'date_add' =>                    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'),
            'date_upd' =>                    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate')
        )
    );

    public function getAllWidgets($is_default = false)
    {    
        $query = $is_default ? ' AND w.`default` = 1' : "";

        return Db::getInstance()->executeS('SELECT w.*, wl.`name`, wl.`description`, wl.`description_short`
                                     FROM `'._DB_PREFIX_.'widget` w 
                                     LEFT JOIN `'._DB_PREFIX_.'widget_lang` wl ON w.`id_widget` = wl.`id_widget`
                                     WHERE wl.`id_lang` = 1 AND w.`active` = 1 '.$query.'');
    }

    public function getChildWidgets() {
        return Db::getInstance()->executeS('SELECT w.*, wl.`name`, wl.`description`, wl.`description_short`
                                     FROM `'._DB_PREFIX_.'widget` w 
                                     LEFT JOIN `'._DB_PREFIX_.'widget_lang` wl ON w.`id_widget` = wl.`id_widget`
                                     WHERE wl.`id_lang` = 1 AND w.`active` = 1 AND w.`id_parent` = '.$this->id.'');
    }

    public function getWidgetById() {
        return Db::getInstance()->executeS('SELECT w.*, wl.`name`, wl.`description`, wl.`description_short`
                                         FROM `'._DB_PREFIX_.'widget` w 
                                         LEFT JOIN `'._DB_PREFIX_.'widget_lang` wl ON w.`id_widget` = wl.`id_widget`
                                         WHERE w.`id_widget` = '.$this->id.' AND wl.`id_lang` = 1 AND w.`active` = 1');
    }

    public function isDefault(){
        return Db::getInstance()->getValue('SELECT IF(w.`default` = 0, 1, 0)
                                     FROM `'._DB_PREFIX_.'widget` w
                                     WHERE w.`id_widget` = '.(int)($this->id).'');
    }

    public function userHasWidget($idUser, $isActive){
        return Db::getInstance()->getValue('SELECT IF(wu.`id_widget` != "", 1, 0)
                                   FROM `'._DB_PREFIX_.'widget_user` wu
                                   WHERE wu.active = '.$isActive.' AND wu.`id_user` = '.$idUser.' 
                                   AND wu.`id_widget` = '.(int)($this->id).'');
    }

    public function getDashboardWidgetsByUser($idUser){
        return Db::getInstance()->executeS('SELECT w.*, wl.`name`, wl.`technical_name`, wl.`description`, wl.`description_short`
                                     FROM `'._DB_PREFIX_.'widget_user` wu 
                                     LEFT JOIN `'._DB_PREFIX_.'widget` w ON wu.`id_widget` = w.`id_widget`
                                     LEFT JOIN `'._DB_PREFIX_.'widget_lang` wl ON w.`id_widget` = wl.`id_widget`
                                     WHERE wl.`id_lang` = 1 AND wu.active = 1 AND w.`active` = 1 
                                     AND wu.`id_user` = '.(int)($idUser).' AND w.`type` = 1');
    }

    public function installNewWidget($data)
    {
        $widget = new Widget((int)($data['id_widget']));

        $widget->installChildWidgets($data['id_user']);

        if($widget->userHasWidget($data['id_user'], 0)) {
            return Db::getInstance()->autoExecute(_DB_PREFIX_.'widget_user', array('active' => 1), 'UPDATE', 'id_widget = '.$data['id_widget'].' AND id_user = '.$data['id_user'].'');
        }
        else if($widget->userHasWidget($data['id_user'], 1)) {
            return true;
        }
        
        return Db::getInstance()->autoExecute(_DB_PREFIX_.'widget_user', $data, 'INSERT');
    }

    public function installChildWidgets($id_user) {
        if($this->id_parent == 0) 
        {
            $childWidgets = $this->getChildWidgets();

            if(is_array($childWidgets) && sizeof($childWidgets) > 0) 
            {
                foreach ($childWidgets as $key => $child) 
                {
                    $child_data = array(
                        'id_widget' => $child['id_widget'],
                        'id_user' => $id_user,
                        'paid' => 0,
                        'position' => 0,
                        'active' => 1,
                        'date_add' => date("Y-m-d H:i:s"), 
                        'date_upd' => date("Y-m-d H:i:s")
                    );

                    $this->installNewWidget($child_data);
                }
            }
        }
    }

    public function uninstallWidget($idWidget, $idUser) {
        $widget = new Widget((int)($idWidget));

        $result = Db::getInstance()->autoExecute(_DB_PREFIX_.'widget_user', array('active' => 0), 'UPDATE', 'id_widget = '.$idWidget.' AND id_user = '.$idUser.'');

        if($result) {
            $widget->uninstallChildWidgets($idUser);
            return true;
        }
        else
            return false;
    }

    public function uninstallChildWidgets($id_user) {
        if($this->id_parent == 0) 
        {
            $childWidgets = $this->getChildWidgets();

            if(is_array($childWidgets) && sizeof($childWidgets) > 0) 
            {
                foreach ($childWidgets as $key => $child) 
                {
                    $this->uninstallWidget($child['id_widget'], $id_user);
                }
            }
        } 
    }

    public function isBudgetConfigured($idUser) {
        // Required Objects Initialization
        $customerObj = new Customer((int)($idUser));
        $purchaseObj = new PurchaseOrder();
        $addresses = $customerObj->getAddresses(1);

        $address_array = array();
        $po_configured = false;

        foreach ($addresses as $address) {
            $address_array[] = $address['id_address'];
        }       
        
        $address_string = implode(",", $address_array);

        if($address_string == "")
            $address_string = 0;

        $po_configured = $purchaseObj->isAddressPoConfigured($address_string, PurchaseOrder::getPoOption($customerObj->id_default_group), true);

        $widgetInstalled = Db::getInstance()->getValue('SELECT IF(wu.`active`, 1, 0) AS configuration
                               FROM `'._DB_PREFIX_.'widget_user` wu 
                               WHERE wu.`id_widget` = 17 AND wu.`id_user` = '.$customerObj->id.' AND wu.`active` = 1');

        if($po_configured && $widgetInstalled) {
            return true;
        }

        return false;
    }
}

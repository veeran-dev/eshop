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

class Employee extends EmployeeCore
{
    public function hasMultiProfileAccess() {
        return Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'employee_multi_profile_mode` em WHERE em.`id_employee` = '.$this->id.'');
    }

    public function getProfileById($id_profile) {
        return Db::getInstance()->getValue('SELECT id_profile FROM `'._DB_PREFIX_.'employee_multi_profile_mode` 
            WHERE id_employee = '.$this->id.' AND id_profile = '.$id_profile.'');
    }

    public function canLogin($flag) {
        $error = true;

        if($this->hasMultiProfileAccess()) {
            $profileId = $this->getProfileById($flag);
            if($profileId != $flag) {
                $error = false;
            }
        }
        else {
            if($this->id_profile != $flag) {
                $error = false;
            }
        }

        return $error;
    }
    public static function getEmployeesWithId($ids){
        $sql = 'SELECT email, firstname  FROM kob_employee WHERE id_employee in('.$ids.')';
        return Db::getInstance()->executeS($sql);
    }
    public static function getEmployeeByName ($name, $active_only = true)
    {
        $logger = new FileLogger();
        $logger->setFilename('test.txt');
        $logger->logError('query'.$name);
        $WHERE = $active_only ? ' AND `active` = 1' : '';

        
        $sql = 'SELECT `id_employee` as id, concat(`firstname`, `lastname`, "[",email,"]") as name FROM kob_employee 
                    WHERE firstname like "%'.$name.'%"
                    OR lastname like "%'.$name.'%"
                    OR email like "%'.$name.'%" '.$WHERE.'';
        return Db::getInstance()->executeS($sql);

    }
    public static function getRmHead(){
        $sql = 'SELECT email FROM kob_employee WHERE rm_head=1';
        return Db::getInstance()->executeS($sql);        
    }
    
    public static function getSalesHead(){
        $sql = 'SELECT email FROM kob_employee WHERE sales_head=1';
        return Db::getInstance()->executeS($sql);        
    }
}

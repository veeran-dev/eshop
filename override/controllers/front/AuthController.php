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

class AuthController extends AuthControllerCore
{
    public function authenticateCheck($email, $password)
    {
        $customer = new Customer();
        $authentication = $customer->getByEmail(trim($email), trim($password));
        if (!$authentication OR !$customer->id)
        {
            /* Handle brute force attacks */
            sleep(1);
            echo 0;
        }
        else
            echo 1;
    }
    public function createNewAccount()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        /*$type = $_POST['type'];*//*commented by veeran.b*/
        
        if (Customer::customerExists($email))
        {
            echo 2;
        }   
        else
        {
            $customer = new Customer();
            $customer->email = $email;
            $customer->passwd = md5(_COOKIE_KEY_.$password);
            $customer->firstname = $name;
            $customer->mobile = $phone;
            if($customer->add())
            {
                /*commented by veeran.b*/
                /*if($type == 1)
                echo $customer->id;
                else*/
                echo 1;
            }
            else 
                echo 0;
        }
    }
}

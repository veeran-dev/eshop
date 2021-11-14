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

class RateContractControllercore extends FrontController
{
	public $auth = true;
	public $php_self = 'addtorate.php';
	public $authRedirection = '/';
	public $ssl = true;
	public $rate;
	public $id_customer;
	public $id_product;
	
	public function process() 
 {
    parent::init();  //First you have to call the parent init to initialize resources
      $this->addto(); 
 }
 public function addto()
 {
	 	$id_customer=$_POST["id_customer"];
	 	$id_product=$_POST["id_product"];
		//$purchaseListId=$_POST['purchaseListId'];
		$rate=new RateContract();
  		$addtolist=$rate->addratecontract($id_product,$id_customer);
 		echo $addtolist;
	 }
}




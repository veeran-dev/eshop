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
* versions in the future. If you wish to customerIdtomize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14903 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & productIdperty of PrestaShop SA
*/

class RateContractCore
{
	public $productId;
	public $customerId;
	
	public function addratecontract($id_product,$id_customer, $mode=0)
	{		
			$productId=$id_product;
			$customerId=$id_customer;	
						
		
		//Note:Below SQL Query should be replaced with this commented query after clarifying few doubts.
		
	/*	$insertRateContract=	Db::getInstance()->Execute(	'INSERT INTO `'._DB_PREFIX_.'rate_contract` (`id_product`, `id_customer`)SELECT * FROM (SELECT '.$productId.', '.$customerId.') AS tmp WHERE NOT EXISTS ( SELECT id_customer,id_product FROM `'._DB_PREFIX_.'rate_contract` WHERE id_customer='.$customerId.' AND id_product='.$productId.') LIMIT 1');
		
		$getRateContractId=Db::getInstance()->getValue('SELECT id_rate_contract FROM `'._DB_PREFIX_.'rate_contract` WHERE id_customer='.$customerId.' AND id_product='.$productId.'');
		
		$insertPurchaseList=Db::getInstance()->Execute(	'INSERT INTO `'._DB_PREFIX_.'rate_contract_list_mapping` (`id_rate_contract`, `id_pur_list`)SELECT * FROM (SELECT '.$getRateContractId.', '.$purchaseListId.') AS tmp WHERE NOT EXISTS ( SELECT id_rate_contract,id_pur_list FROM `'._DB_PREFIX_.'rate_contract_list_mapping` WHERE id_rate_contract='.$getRateContractId.' AND id_pur_list='.$purchaseListId.') LIMIT 1');
		
		echo $insertPurchaseList;*/
			$checkExistance=Db::getInstance()->getValue('SELECT COUNT(id_product) FROM `'._DB_PREFIX_.'rate_contract` WHERE id_customer='.$customerId.' AND id_product='.$productId.'');
  			if($checkExistance==0)
			{
 				$result = Db::getInstance()->Execute('
				INSERT INTO `'._DB_PREFIX_.'rate_contract` (`id_product`, `id_customer`)	VALUES ('.$productId.', '.$customerId.') ');
				
				/*$getRateContractId=Db::getInstance()->getValue('SELECT MAX(id_rate_contract) FROM `'._DB_PREFIX_.'rate_contract` WHERE id_customer='.$customerId.'');
				
				$result=Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'rate_contract_list_mapping` (`id_rate_contract`,`id_pur_list`)	VALUES ('.$getRateContractId.','.$purchaseListId.')');*/
		
				return $result;
			}
			else
			{
 					$getRateContractId=Db::getInstance()->getRow('SELECT id_rate_contract,active FROM `'._DB_PREFIX_.'rate_contract` WHERE id_customer='.$customerId.' AND id_product='.$productId.'');
 
  					if($getRateContractId['active']==0)
					{
 						Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'rate_contract` SET active=1 WHERE id_rate_contract = '.$getRateContractId['id_rate_contract'].'');
						

					}
					
 					/*$checkProductInList=Db::getInstance()->getRow('SELECT id_rate_contract,active FROM `'._DB_PREFIX_.'rate_contract_list_mapping` WHERE id_rate_contract='.$getRateContractId['id_rate_contract'].' AND id_pur_list='.$purchaseListId.' ');
					
 					if($checkProductInList['id_rate_contract'] !="" && $checkProductInList['active']==0)
					{
 						$result = Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'rate_contract_list_mapping` SET active=1 WHERE id_rate_contract = '.$getRateContractId['id_rate_contract'].' AND id_pur_list='.$purchaseListId.'');
						
						return $result;
					}
					elseif($checkProductInList['id_rate_contract'] == "")
					{
						$result=Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'rate_contract_list_mapping` (`id_rate_contract`,`id_pur_list`)	VALUES('.$getRateContractId['id_rate_contract'].', '.$purchaseListId.')');
 						 
  						return $result;
					}
					else
					{
						if($mode == 0)
							return "false";
						else
							return 0;
					}*/
			}
	}
	public static function toCheckProductInList($productId,$customerId)
	{
		$checkExistance=Db::getInstance()->getValue('SELECT COUNT(id_rate_contract) FROM `'._DB_PREFIX_.'rate_contract` WHERE id_customer='.$customerId.' AND id_product='.$productId.' AND active=1');
		$checkProductInList=Db::getInstance()->getValue('SELECT COUNT(id_rate_contract) FROM `'._DB_PREFIX_.'rate_contract_list_mapping` WHERE id_rate_contract=(SELECT id_rate_contract FROM `'._DB_PREFIX_.'rate_contract` WHERE id_customer='.$customerId.' AND active=1 AND id_product='.$productId.') AND active = 1');
		
		if($checkExistance==0)
		{
			return $checkExistance;
		}
		else if($checkProductInList==0)
		{
		return $checkProductInList;
		}
		else
		{
			return 1;
		}

	}

	public function rmAlertDisabledProduct($productId)
	{
		$query='SELECT c.id_customer,c.email as customer_email,c.firstname,e.email,e.id_employee FROM `kob_rate_contract` AS r 
				LEFT JOIN `kob_customer` AS c ON c.`id_customer` = r.`id_customer`
				LEFT JOIN `kob_employee` AS e ON e.`id_employee` = c.`id_relationship_manager`
				WHERE r.`id_product` = '.$productId.' ORDER BY e.`id_employee`';

		$result=Db::getInstance()->ExecuteS($query);
		return $result;
	}

	public static function isExistsInRateContract($id_product,$id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT `id_product`,`id_customer` FROM '._DB_PREFIX_.'rate_contract WHERE id_customer='.$id_customer.' AND id_product='.$id_product.'');
	}

	public static function createRateContract($id_product,$id_customer)
	{

		return Db::getInstance()->ExecuteS('INSERT INTO '._DB_PREFIX_.'rate_contract(`id_customer`,`id_product`,`active`) VALUES ('.$id_customer.','.$id_product.',1)');

	}
	public static function productAvailable($id_product,$id_customer,$purList)
	{
        $pur_list='';
        if($purList)
        {
        	$pur_list =' AND rc.id_pur_list='.$purList.' ';
        }

		$query='select rc.* from `'._DB_PREFIX_.'rate_contract` rclm
					LEFT JOIN `'._DB_PREFIX_.'rate_contract_list_mapping` rc ON rc.id_rate_contract=rclm.id_rate_contract
					where rclm.id_customer='.$id_customer.' 
					AND rclm.id_product='.$id_product.'
                                        '.$pur_list.'					
					AND rc.`active`=1
					AND rclm.`active`=1';
		$result=Db::getInstance()->ExecuteS($query);
		return $result;
	}
}
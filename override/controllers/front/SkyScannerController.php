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

class SkyScannerControllerCore extends FrontController
{
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');

		if(isset($type)) 
		{
			$suggestions = Tools::getValue('suggestions');
			$search = Tools::getValue('search');
			$origin_place = Tools::getValue('originplace');
			$destination_place = Tools::getValue('destinationplace');
			$outbound_date = Tools::getValue('outbounddate');
			$inbound_date = Tools::getValue('inbounddate');
			$cabinclass = Tools::getValue('cabinclass');
			$adults = Tools::getValue('adults');
			$children = Tools::getValue('children');
			$infants = Tools::getValue('infants');
			$q = Tools::getValue('q');
			$session_key = Tools::getValue('session_key');
			$pagesize = Tools::getValue('pagesize');
			$pageindex = Tools::getValue('pageindex');

			$skyscannerObj = new SkyScanner();

			if($type == 1) // For skyscanner API
			{
				// Request to create and get session id
				
				$session_url = "";

				do {
					$skyscannerObj->origin_place = $origin_place;
					$skyscannerObj->destination_place = $destination_place;
					$skyscannerObj->outbound_date = $outbound_date;
					$skyscannerObj->inbound_date = $inbound_date;
					$skyscannerObj->cabinclass = $cabinclass;
					$skyscannerObj->adults = $adults;
					$skyscannerObj->children = $children;
					$skyscannerObj->infants = $infants;
					$session_url = $skyscannerObj->createSession();
					if($session_url != "") {
						break;
					}
				} while(0);

				// Request to poll booking details
				if($session_url != "") {
					$result = $skyscannerObj->pollSession($session_url);
					echo $result;
				}
			}
			else if($type == 2) 
			{
				$result = $skyscannerObj->getLocationSuggestions($q);
				echo $result;
			}
			else if($type == 3)
			{
				$url = $skyscannerObj->_pricing_url.$session_key;
				$result = $skyscannerObj->pollSession($url);
				echo $result;
			}
		}
 	}
}
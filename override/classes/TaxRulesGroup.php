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
*  @version  Release: $Revision: 14001 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/


class TaxRulesGroup extends TaxRulesGroupCore
{
    
	public static function getTaxes($id_tax_rules_group, $id_country, $id_state, $county = NULL)
	{
	    if (empty($id_tax_rules_group) OR empty($id_country))
	        return array(new Tax()); // No Tax

       if (isset(self::$_taxes[$id_tax_rules_group.'-'.$id_country.'-'.$id_state]))
            return self::$_taxes[$id_tax_rules_group.'-'.$id_country.'-'.$id_state];

		$order = 'DESC';

		 

	    $rows = Db::getInstance()->ExecuteS('
	    SELECT *
	    FROM `'._DB_PREFIX_.'tax_rule`
	    WHERE `id_country` = '.(int)$id_country.'
	    AND `id_tax_rules_group` = '.(int)$id_tax_rules_group.'
	    AND `id_state` IN (0, '.(int)$id_state.')
	   
	    ORDER BY  `id_state` '.$order);

	    $taxes = array();
	    foreach ($rows AS $row)
	    {
          if ($row['id_state'] != 0)
	       {
	            switch($row['state_behavior'])
	            {
	                case PS_STATE_TAX: // use only product tax
                        $taxes[] = new Tax($row['id_tax']);
    	                break 2; // switch + foreach

    	            case PS_BOTH_TAX:
    	                $taxes[] = new Tax($row['id_tax']);
    	                break;

	                case PS_PRODUCT_TAX: // do nothing use country tax
	                    break;
	            }
	       }
	       else
	            $taxes[] = new Tax((int)$row['id_tax']);
	    }

	    self::$_taxes[$id_tax_rules_group.'-'.$id_country.'-'.$id_state.'-'.$id_county] = $taxes;
       return $taxes;
	}

	
}


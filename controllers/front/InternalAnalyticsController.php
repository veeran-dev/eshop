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

class InternalAnalyticsControllerCore extends BackController
{
    /** string Internal controller name */
    public $php_self = 'internalAnalytics';

    public $auth =true;

    public function displayContent()
    {
        // var_dump($this->context->smarty);
        $this->context->smarty->assign('month', date('F Y'));
		$this->context->smarty->display('kobster_kpi/index.tpl'); 
    }

    public function ajaxReturn()
    {
        $type = isset($_GET['type'])?$_GET['type']:0;
        if($type == 1){         //top section

            echo json_encode($this->topSection());
        }
        else if ($type == 2){  //second section
            echo json_encode($this->secondSection());
        }
        else if ($type == 3){  //third section
            echo json_encode($this->thirdSection());
        }
    }

    public function topSection(){

        $result = array();
        $internalAnalytics = new Analytics();
        $topLineRevenue = $internalAnalytics::topLineRevenue();
        $fcWiseRevenue = $internalAnalytics::fcWiseRevenue();
        $rmWiseRevenue = $internalAnalytics::rmWiseRevenue();
        $kamWiseRevenue = $internalAnalytics::kamWiseRevenue();
        $categoryWiseRevenue = $internalAnalytics::categoryWiseRevenue();
        $topCustomerRevenue = $internalAnalytics::topCustomerRevenue();
        $annualRevenueTarget = $internalAnalytics::annualRevenueTarget();

        array_push($result, $topLineRevenue, $fcWiseRevenue, $rmWiseRevenue, $kamWiseRevenue, $topCustomerRevenue, $annualRevenueTarget, $categoryWiseRevenue);
        return $result;
    }

    public function secondSection(){

        $result = array();
        $internalAnalytics = new Analytics();

        $activeCompaniesCount = $internalAnalytics::activeCompaniesCount();
        $activeUsersCount = $internalAnalytics::activeUsersCount();
        $newCustomers = $internalAnalytics::newCustomers();

        $averageAdt = $internalAnalytics::averageAdt();
        $fcWiseAverageAdt = $internalAnalytics::fcWiseAverageAdt();

        $ordersPendingWithOps = $internalAnalytics::ordersPendingWithOps();
        $ordersPendingWithCategory = $internalAnalytics::ordersPendingWithCategory();
        $ordersPendingWithFinance = $internalAnalytics::ordersPendingWithFinance();
        $ordersPendingWithRm = $internalAnalytics::ordersPendingWithRm();

        $averageCollectionPeriod = $internalAnalytics::averageCollectionPeriod();
        $receivablesPending = $internalAnalytics::receivablesPending();
        $paymentsPending = $internalAnalytics::paymentsPending();

        array_push($result, $activeCompaniesCount, $activeUsersCount, $newCustomers, $averageAdt, $fcWiseAverageAdt, $ordersPendingWithOps, $ordersPendingWithCategory, $ordersPendingWithFinance, $ordersPendingWithRm, $averageCollectionPeriod, $receivablesPending, $paymentsPending);
        return $result;
    }

    public function thirdSection(){

        $result = array();
        $internalAnalytics = new Analytics();

        $activeProducts = $internalAnalytics::activeProducts();
        $totalBrands = $internalAnalytics::totalBrands();
        $totalOosProducts = $internalAnalytics::totalOosProducts();

        $totalVendors = $internalAnalytics::totalVendors();
        $currentVendors = $internalAnalytics::currentVendors();
        $newVendors = $internalAnalytics::newVendors();
        $annualRevenueTarget = $internalAnalytics::annualRevenueTarget();
        array_push($result, $activeProducts, $totalBrands, $totalOosProducts, $totalVendors, $currentVendors, $newVendors, $annualRevenueTarget);
        return $result;
    }

    public function displayHeader($display = false){

    }
    public function displayFooter($display = false){

    }

}

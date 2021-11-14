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

if (!defined('_PS_ADMIN_DIR_')) {
    define('_PS_ADMIN_DIR_', getcwd());
}
include(_PS_ADMIN_DIR_.'/../config/config.inc.php');

/* Getting cookie or logout */
require_once(_PS_ADMIN_DIR_.'/init.php');

$context = Context::getContext();
if (Tools::isSubmit('ajaxReferrers')) {
    require(_PS_CONTROLLER_DIR_.'admin/AdminReferrersController.php');
}

if (Tools::getValue('page') == 'prestastore' and @fsockopen('addons.prestashop.com', 80, $errno, $errst, 3)) {
    readfile('http://addons.prestashop.com/adminmodules.php?lang='.$context->language->iso_code);
}

if (Tools::isSubmit('getAvailableFields') and Tools::isSubmit('entity')) {
    $jsonArray = array();
    $import = new AdminImportController();

    $fields = $import->getAvailableFields(true);
    foreach ($fields as $field) {
        $jsonArray[] = '{"field":"'.addslashes($field).'"}';
    }
    die('['.implode(',', $jsonArray).']');
}

if (Tools::isSubmit('ajaxProductPackItems')) {
    $jsonArray = array();
    $products = Db::getInstance()->executeS('
	SELECT p.`id_product`, pl.`name`
	FROM `'._DB_PREFIX_.'product` p
	NATURAL LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
	WHERE pl.`id_lang` = '.(int)(Tools::getValue('id_lang')).'
	'.Shop::addSqlRestrictionOnLang('pl').'
	AND NOT EXISTS (SELECT 1 FROM `'._DB_PREFIX_.'pack` WHERE `id_product_pack` = p.`id_product`)
	AND p.`id_product` != '.(int)(Tools::getValue('id_product')));

    foreach ($products as $packItem) {
        $jsonArray[] = '{"value": "'.(int)($packItem['id_product']).'-'.addslashes($packItem['name']).'", "text":"'.(int)($packItem['id_product']).' - '.addslashes($packItem['name']).'"}';
    }
    die('['.implode(',', $jsonArray).']');
}

if (Tools::isSubmit('getChildrenCategories') && Tools::isSubmit('id_category_parent')) {
    $children_categories = Category::getChildrenWithNbSelectedSubCat(Tools::getValue('id_category_parent'), Tools::getValue('selectedCat'), Context::getContext()->language->id, null, Tools::getValue('use_shop_context'));
    die(Tools::jsonEncode($children_categories));
}

if (Tools::isSubmit('getNotifications')) {
    $notification = new Notification;
    die(Tools::jsonEncode($notification->getLastElements()));
}

if (Tools::isSubmit('updateElementEmployee') && Tools::getValue('updateElementEmployeeType')) {
    $notification = new Notification;
    die($notification->updateEmployeeLastElement(Tools::getValue('updateElementEmployeeType')));
}

if (Tools::isSubmit('searchCategory')) {
    $q = Tools::getValue('q');
    $limit = Tools::getValue('limit');
    $results = Db::getInstance()->executeS('SELECT c.`id_category`, cl.`name`
		FROM `'._DB_PREFIX_.'category` c
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category`'.Shop::addSqlRestrictionOnLang('cl').')
		WHERE cl.`id_lang` = '.(int)$context->language->id.' AND c.`level_depth` <> 0
		AND cl.`name` LIKE \'%'.pSQL($q).'%\'
		GROUP BY c.id_category
		ORDER BY c.`position`
		LIMIT '.(int)$limit);
    if ($results) {
        foreach ($results as $result) {
            echo trim($result['name']).'|'.(int)$result['id_category']."\n";
        }
    }
}

if (Tools::isSubmit('getParentCategoriesId') && $id_category = Tools::getValue('id_category')) {
    $category = new Category((int)$id_category);
    $results = Db::getInstance()->executeS('SELECT `id_category` FROM `'._DB_PREFIX_.'category` c WHERE c.`nleft` < '.(int)$category->nleft.' AND c.`nright` > '.(int)$category->nright.'');
    $output = array();
    foreach ($results as $result) {
        $output[] = $result;
    }

    die(Tools::jsonEncode($output));
}

if (Tools::isSubmit('getZones')) {
    $html = '<select id="zone_to_affect" name="zone_to_affect">';
    foreach (Zone::getZones() as $z) {
        $html .= '<option value="'.$z['id_zone'].'">'.$z['name'].'</option>';
    }
    $html .= '</select>';
    $array = array('hasError' => false, 'errors' => '', 'data' => $html);
    die(Tools::jsonEncode($array));
}

if (Tools::isSubmit('getEmailHTML') && $email = Tools::getValue('email')) {
    $email_html = AdminTranslationsController::getEmailHTML($email);
    die($email_html);
}
if (Tools::isSubmit('submitRelationshipManger') AND $id_customer = (int)Tools::getValue('id_customer'))
{
    $logger=new FileLogger();
    $logger->setFilename("test.txt");
    $logger->logError("submitRelationshipManger");
    $relationshipManger = Tools::getValue('submitRelationshipManger');
    $logger->logError($relationshipManger);
    $logger->logError($id_customer);

    if (!empty($relationshipManger) AND !Validate::isCleanHtml($relationshipManger)){
        die ('error:validation');
    }
    if (!Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'customer SET `id_relationship_manager` = "'.pSQL($relationshipManger, true).'" , Id_buyer = 3 WHERE id_customer = '.(int)$id_customer.' LIMIT 1'))
        die ('error:update');
    die('ok');
}
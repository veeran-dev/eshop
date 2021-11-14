<?php
/**
  * PM_AdvancedTopMenu Front Office Feature
  *
  * @category menu
  * @authors Jean-Sebastien Couvert & Stephan Obadia / Presta-Module.com <support@presta-module.com>
  * @copyright Presta-Module 2011-2012
  * +
  * +Languages: EN, FR
  * +PS version: 1.4, 1.3, 1.2, 1.1
  **/
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/pm_advancedtopmenu.php');

$action = Tools::getValue('action',false);;

switch($action) {
	case 'get_select_columns':
		$id_menu = Tools::getValue('id_menu',false);
		if(!$id_menu) die;
		$columns = AdvancedTopMenuColumnClass::getMenuColumsByIdMenu($id_menu, $cookie->id_lang, false);
		$column_selected = Tools::getValue('column_selected',false);
		$smarty->assign(
			array(
				'columns'			=> $columns,
				'column_selected'	=> $column_selected,
				'objADTM'			=> new PM_AdvancedTopMenu()
			)
		);
		$rootTpl = (is_dir(_PS_THEME_DIR_.'modules/pm_advancedtopmenu/')?_PS_THEME_DIR_.'modules/pm_advancedtopmenu': dirname(__FILE__));

		$smarty->display($rootTpl.'/column_select.tpl');
	break;
	case 'get_select_columnsWrap':
		$id_menu = Tools::getValue('id_menu',false);
		if(!$id_menu) die;
		$columnsWrap = AdvancedTopMenuColumnWrapClass::getMenuColumnsWrap($id_menu, $cookie->id_lang, false);
		$columnWrap_selected = Tools::getValue('columnWrap_selected',false);
		$smarty->assign(
			array(
				'columnsWrap'			=> $columnsWrap,
				'columnWrap_selected'	=> $columnWrap_selected
			)
		);
		$rootTpl = (is_dir(_PS_THEME_DIR_.'modules/pm_advancedtopmenu/')?_PS_THEME_DIR_.'modules/pm_advancedtopmenu': dirname(__FILE__));

		$smarty->display($rootTpl.'/columnwrap_select.tpl');
	break;
}
?>
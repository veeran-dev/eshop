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

/**
 * @property Zone $object
 */
class AdminFCControllerCore extends AdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'fulfillment_centre';
        $this->className = 'FulfillmentCentre';
        $this->lang = true;
        $this->requiredDatabase = true;
        

        $this->_select = 's.`name` AS state, e.`name` AS head';
        $this->_join = '
        LEFT JOIN `'._DB_PREFIX_.'state` s ON (s.`id_state` = a.`id_state`)
        LEFT JOIN `'._DB_PREFIX_.'employee` e ON (e.`id_employee`=a.`id_employee`)';

        /** get State name **/
        $state_array = array();
        $this->state = State::getStatesByIdCountry(110);
        foreach ($this->state as $state) {
            $state_array[$state['id_state']] = $state['name'];
        }

        $this->fields_list = array(
            'id_fulfillment_centre' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'state' => array(
                'title' => $this->l('State'),
                'type' => 'select',
                'list' => $state_array,
                'filter_key' => 's!id_state',
                'filter_type' => 'int',
                'order_key' => 's!name'
            ),
            'city_name' => array(
                'title' => $this->l('city name'),
            )
        );
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            )
        );

        parent::__construct();
    }
    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_fulfillment_centre'] = array(
                'href' => self::$currentIndex.'&addfulfillment_centre&token='.$this->token,
                'desc' => $this->l('Add new state', null, null, false),
                'icon' => 'process-icon-new'
            );
        }

        parent::initPageHeaderToolbar();
    }
    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->_select = 's.`name` AS state';
        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'state` s ON (s.`id_state` = a.`id_state`)';
        $this->_use_found_rows = false;

        //$this->tpl_list_vars['state'] = State::getStatesByIdCountry(110);
        //var_dump($this);
        return parent::renderList();
    }
    public function renderForm()
    {
        //var_dump(State::getStatesByIdCountry(110));
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('FulfillmentCentre'),
                'icon' => 'icon-globe'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Center'),
                    'name' => 'city_name',
                    'required' => true,                    
                    'hint' => $this->l('City of Fulfillment Centre ')
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('State'),
                    'name' => 'id_state',
                    'options' => array(
                        'query' => State::getStatesByIdCountry(110),
                        'id' => 'id_state',
                        'name' => 'name'
                    ),
                    'hint' => $this->l('State of Fulfillment Centre ')
                ),           
                array(
                    'type' => 'select',
                    'label' => $this->l('Employee'),
                    'name' => 'id_employee',
                    'options' => array(
                        'query' => Employee::getEmployees(),
                        'id' => 'id_employee',
                        'name' => 'firstname'
                    ),
                    'hint' => $this->l('Regional Head.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('CST'),
                    'name' => 'cst',
                    'required' => true,
                    'maxlength' => 12,
                    'hint' => $this->l('CST number')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('TIN'),
                    'name' => 'tin',
                    'maxlength' => 12,
                    'required' => true,                    
                    'hint' => $this->l('1 to 4 letter ISO code.').' '.$this->l('You can prefix it with the country ISO code if needed.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('GST'),
                    'name' => 'gst',
                    'maxlength' => 12,
                    'required' => true,                    
                    'hint' => $this->l('1 to 4 letter ISO code.').' '.$this->l('You can prefix it with the country ISO code if needed.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('LUT'),
                    'name' => 'lut',
                    'maxlength' => 64,
                    'required' => true,                    
                    'hint' => $this->l('1 to 4 letter ISO code.').' '.$this->l('You can prefix it with the country ISO code if needed.')
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('LUT Date'),
                    'name' => 'lut_date',                    
                    'required' => true,                    
                    'hint' => $this->l('LUT issued Date of Fulfillment Centre ')
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('LUT Expiry Date'),
                    'name' => 'lut_expiry',                    
                    'required' => true,                    
                    'hint' => $this->l('LUT Expiry Date of Fulfillment Centre ')
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('CST Date'),
                    'name' => 'cst_date',                    
                    'required' => true,                    
                    'hint' => $this->l('Cst issued Date of Fulfillment Centre ')
                ),
                array(
                    'type' => 'text',                    
                    'name' => 'id_address',                    
                    'value' => '0',
                    'class' => 'hidden',
                    'required' => true,                    
                    'hint' => $this->l('Cst issued Date of Fulfillment Centre ')
                )
            )

        );

        /*if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
            );
        }*/        

        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );

        return parent::renderForm();
    }
}

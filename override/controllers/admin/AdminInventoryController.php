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
class AdminInventoryControllerCore extends AdminController
{
    protected $position_identifier = 'id_product';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'inventory';
        $this->className = 'Inventory';
        $this->lang = false;
        $this->requiredDatabase = true;
        

        $this->_select = 'a.`id_product`, f.`city_name`, a.quantity, a.added, a.removed, a.date, a.date_add';
        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` f ON (f.`id_fulfillment_centre`=a.`id_fulfillment_centre`)';

        $this->fields_list = array(
            'id_product' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
                'type' => 'int',
                'filter_key' => 'a!id_product'
            ),
            'city_name' => array(
                'title' => $this->l('city name'),
                'filter_key' => 'f!city_name'
            ),
            'quantity' => array(
                'title' => $this->l('Quantity'),
                'filter_key' => 'a!quantity',
                'type' => 'int'
            ),
            'added' => array(
                'title' => $this->l('Added'),
                'active' => 'status',
                'filter_key' => 'a!added',
                'align' => 'text-center',
                'type' => 'bool',
                'class' => 'fixed-width-sm',
                'orderby' => false
            ),
            'removed' => array(
                'title' => $this->l('Removed'),
                'active' => 'status',
                'filter_key' => 'a!removed',
                'align' => 'text-center',
                'type' => 'bool',
                'class' => 'fixed-width-sm',
                'orderby' => false
            ),
            'date' => array(
                'title' => $this->l('Entered'),
                'align' => 'text-right',
                'type' => 'datetime',
                'filter_key' => 'a!date'
            ),
            'date_add' => array(
                'title' => $this->l('Date'),
                'align' => 'text-right',
                'type' => 'datetime',
                'filter_key' => 'a!date_add'
            ),

        );

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            )
        );
        // var_dump($this);
        parent::__construct();
    }
    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_inventory'] = array(
                'href' => self::$currentIndex.'&addinventory&token='.$this->token,
                'desc' => $this->l('Add new inventory', null, null, false),
                'icon' => 'process-icon-new'
            );
        }

        parent::initPageHeaderToolbar();
    }
    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->_select = 'a.`id_product`, a.`id_fulfillment_centre`, f.`city_name`, a.quantity, a.added, a.removed, a.date';
        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'fulfillment_centre` f ON (f.`id_fulfillment_centre`=a.`id_fulfillment_centre`)';
        $this->_use_found_rows = false;
        return parent::renderList();
    }
    public function renderForm()
    {
        //var_dump(State::getStatesByIdCountry(110));
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Inventory'),
                'icon' => 'icon-globe'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Product ID'),
                    'name' => 'id_product',
                    'class' => 'fixed-width-sm',
                    'required' => true,                    
                    'hint' => $this->l("Product's ID")
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Fulfillment Centre'),
                    'name' => 'id_fulfillment_centre',
                    'options' => array(
                        'query' => FulfillmentCentre::getAllFCentres(),
                        'id' => 'id_fulfillment_centre',
                        'name' => 'city_name'
                    ),
                    'required' => true,                    
                    'hint' => $this->l('State of Fulfillment Centre ')
                ),           
                array(
                    'type' => 'text',
                    'label' => $this->l('Quantity'),
                    'class' => 'fixed-width-sm',
                    'name' => 'quantity',                    
                    'required' => true,                    
                    'hint' => $this->l('Quantity added or removed')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Added'),
                    'class' => 'fixed-width-xs',
                    'name' => 'added',                    
                    'required' => false,                    
                    'hint' => $this->l('Mark if inventory added')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Removed'),
                    'class' => 'fixed-width-xs',
                    'name' => 'removed',                    
                    'required' => false,                    
                    'hint' => $this->l('Mark if inventory removed')
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Date'),
                    'name' => 'date',                    
                    'required' => true,                    
                    'hint' => $this->l('Date inventory added or removed')
                )
            )

        );     

        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );

        return parent::renderForm();
    }

    public function initProcess()
    {
        if(Tools::isSubmit('submitAddinventory') === true){
            if((Tools::getValue('added') == Tools::getValue('removed')) || (Tools::getValue('added') >1) || (Tools::getValue('removed') >1)){
                $this->errors[] = (Tools::displayError('Please check added / removed field'));   
            }
            if(Tools::getValue('added') < 0){
                $this->errors[] = (Tools::displayError('Please check added field, negative value not allowed'));
            }

            if(Tools::getValue('removed') < 0){
                $this->errors[] = (Tools::displayError('Please check removed field, negative value not allowed'));
            }
            
            if(Tools::getValue('quantity') < 0){
                $this->errors[] = (Tools::displayError('Please check quantity field'));
            }
            
            if(!Product::isValidProduct(Tools::getValue('id_product'))){
                $this->errors[] = (Tools::displayError('Please check id_product'));   
            }
            $date=date_create(Tools::getValue('date'));
            $current_date = new DateTime();
            if(strtotime(date_format($date,"Y-m-d H:i:s")) > strtotime($current_date->format("Y-m-d H:i:s"))){
                $this->errors[] = (Tools::displayError('Please check date field'));      
            }

        }
        parent::initProcess();
    }
}

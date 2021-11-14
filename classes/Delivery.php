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

class DeliveryCore extends ObjectModel
{

    /** @var int **/
    public $id_shop;

    /** @var int **/
    public $id_shop_group;

    /** @var int */
    public $id_carrier;

    /** @var int */
    public $id_range_price;

    /** @var int */
    public $id_range_weight;

    /** @var int */
    public $id_zone;

    /** @var float */
    public $price;

    /*** added by veeran.b ***/
    /** @var DR Scan Upload File Name */
    public $dr_file_name;
    
    public $dr_prefix;

    /** @var integer */
    public $delivery_number;

    /** @var integer 
     ** kobster boxes */
    public $kob_boxes;

    /** @var integer 
     ** other boxes */
    public $other_boxes;
    
    /** @var date */
    public $delivery_date;

    public $delivered;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'delivery',
        'primary' => 'id_delivery',
        'fields' => array(
            'id_carrier' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_range_price' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_range_weight' =>array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_zone' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_shop' =>        array('type' => self::TYPE_INT),
            'id_shop_group' =>    array('type' => self::TYPE_INT),
            'price' =>            array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
            'delivery_number' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'delivered' =>        array('type' => self::TYPE_INT),
            'delivery_date' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            'dr_file_name' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
            'dr_prefix' =>                    array('type' => self::TYPE_STRING),
            'kob_boxes' =>        array('type' => self::TYPE_INT),
            'other_boxes' =>        array('type' => self::TYPE_INT)
        ),
    );

    protected $webserviceParameters = array(
        'objectsNodeName' => 'deliveries',
        'fields' => array(
            'id_carrier' => array('xlink_resource' => 'carriers'),
            'id_range_price' => array('xlink_resource' => 'price_ranges'),
            'id_range_weight' => array('xlink_resource' => 'weight_ranges'),
            'id_zone' => array('xlink_resource' => 'zones'),
        )
    );

    public function getFields()
    {
        $fields = parent::getFields();

        // @todo add null management in definitions
        if ($this->id_shop) {
            $fields['id_shop'] = (int)$this->id_shop;
        } else {
            $fields['id_shop'] = null;
        }

        if ($this->id_shop_group) {
            $fields['id_shop_group'] = (int)$this->id_shop_group;
        } else {
            $fields['id_shop_group'] = null;
        }

        return $fields;
    }

    public function getOrderId()
    {
        $query='SELECT dd.`id_order` FROM `kob_delivery_details` dd WHERE dd.`id_delivery`='.$this->id;
        return Db::getInstance()->getValue($query);
    }
    public function getDeliveryBoxDetails($from_date = false, $to_date = false, $fc = false, $id_order = false, $view, $company = false)
    {
        $query = "";
        $query .= $id_order ? ' AND od.`id_order` LIKE "%'.$id_order.'%"' : '';
        $query .= $company ? ' AND (a.`company` LIKE "%'.$company.'%" OR c.`company` LIKE "%'.$company.'%" OR gl.`name` LIKE "%'.$company.'%")' : '';
        $query .= $fc ? ' AND o.`id_fc` = '.$fc.'' : '';
        $query .= ($from_date && $to_date == false) ? ' AND DATE(d.`delivery_date`) = "'.$from_date.'"' : '';
        $query .= ($from_date == false && $to_date) ? ' AND DATE(d.`delivery_date`) = "'.$to_date.'"' : '';
        $query .= ($from_date && $to_date) ? ' AND DATE(d.`delivery_date`) BETWEEN "'.$from_date.'" AND "'.$to_date.'"' : '';
        $limit = $view ? 'LIMIT 1500' : '';

        return Db::getInstance()->ExecuteS('SELECT o.`id_order` AS order_id,c.`company` AS cus_company,c.`firstname` AS cus_firstname,a.`company` AS address_company, SUM(d.`kob_boxes`) AS kob_boxes, SUM(d.`other_boxes`) AS other_boxes
                                            FROM `'._DB_PREFIX_.'order_delivery` od
                                            LEFT JOIN `'._DB_PREFIX_.'delivery` d ON od.`id_delivery` = d.`id_delivery`
                                            LEFT JOIN `'._DB_PREFIX_.'orders` o ON o.`id_order` = od.`id_order`
                                            LEFT JOIN `'._DB_PREFIX_.'customer` c ON o.`id_customer` = c.`id_customer`
                                            LEFT JOIN `'._DB_PREFIX_.'group_lang` gl ON c.`id_default_group` = gl.`id_group` AND gl.`id_lang` = 1
                                            LEFT JOIN `'._DB_PREFIX_.'address` a ON o.`id_address_invoice` = a.`id_address`
                                            WHERE c.`active` = 1 '.$query.' GROUP BY o.`id_order` ORDER BY o.`id_order` DESC '.$limit.'');
    }

    public function getBoxDetailsForCustomer($id_customer)
    {
        return Db::getInstance()->ExecuteS('SELECT c.`id_customer`, c.`company` AS cus_company,c.`firstname` AS cus_firstname,a.`company` AS address_company,
                                            SUM(d.`kob_boxes`) AS total_box,br.`box_returned` AS returned_boxes
                                            FROM `'._DB_PREFIX_.'order_delivery` od
                                            LEFT JOIN `'._DB_PREFIX_.'delivery` d ON od.`id_delivery` = d.`id_delivery`
                                            LEFT JOIN `'._DB_PREFIX_.'orders` o ON o.`id_order` = od.`id_order`
                                            LEFT JOIN `'._DB_PREFIX_.'customer` c ON o.`id_customer` = c.`id_customer`
                                            LEFT JOIN `'._DB_PREFIX_.'address` a ON o.`id_address_invoice` = a.`id_address`
                                            LEFT JOIN `'._DB_PREFIX_.'box_returned` br ON br.`id_customer` = c.`id_customer`
                                            WHERE c.`id_customer` = '.$id_customer.' AND c.`active` = 1 ORDER BY o.`id_order` ASC');
    }
    public function getProducts()
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT *,kdd.*
            FROM `'._DB_PREFIX_.'order_detail` od
            LEFT JOIN `'._DB_PREFIX_.'delivery_details` kdd ON(kdd.`id_order`=od.`id_order` AND kdd.`id_product`=od.`product_id` and kdd.id_product_attribute=od.product_attribute_id)
            LEFT JOIN `'._DB_PREFIX_.'delivery` kod ON(kod.`id_delivery`=kdd.`id_delivery`)
            LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.id_product = od.product_id)
            LEFT JOIN `'._DB_PREFIX_.'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop)
            WHERE kod.`id_delivery`='.(int)$this->id);
        
    }

    public function getDeliverySlips($id_order)
    {
        $drs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                    'SELECT d.`delivery_number`, d.`id_delivery`, d.`dr_file_name` ,d.`dr_prefix`
                    FROM `'._DB_PREFIX_.'delivery` d, `'._DB_PREFIX_.'order_delivery` od 
                    WHERE d.`id_delivery`=od.`id_delivery` 
                    AND od.`id_order` = '.$id_order);

            foreach($drs as &$dr)
            {
                if (strpos($dr['dr_file_name'], '.') !== false) {
                    $dr['dr_file_name'] = substr($dr['dr_file_name'], 0, strpos($dr['dr_file_name'], "."));
                }
                if(glob('scanedDRs/'.$dr['dr_file_name'].'.*')){
                    $files  = glob('scanedDRs/'.$dr['dr_file_name'].'.*');
                }
                else if(glob('scanedDRs/'.$dr['dr_file_name'].'_*.*')){
                    $files  = glob('scanedDRs/'.$dr['dr_file_name'].'_*.*');
                }
                else if(glob('scanedDRs/'.$dr['delivery_number'].'_*.*')){
                    $files  = glob('scanedDRs/'.$dr['delivery_number'].'_*.*');
                }
                else if(glob('scanedDRs/'.$dr['delivery_number'].'_*.*')){
                    $files  = glob('scanedDRs/'.$dr['delivery_number'].'_*.*');
                }
                $dr['files'] = $files;
            }
        return $drs;
    }

    public function updateLabels($delivery_id,$kob_box,$other_box){
        return Db::getInstance()->executeS('UPDATE `'._DB_PREFIX_.'delivery` SET `kob_boxes` = '.$kob_box.', `other_boxes` = '.$other_box.' 
                                            WHERE `id_delivery` = '.(int)($delivery_id).'');
    }
    public function getDeliveDetailFromOrderId($id_order)
    {
        // $logger = new FileLogger();
        // $logger->setFilename('test_rakesh.txt');
        // $logger->logError('SELECT dr_file_name as total FROM '._DB_PREFIX_.'delivery  as d
        // LEFT JOIN kob_order_delivery as od on od.id_delivery = d.id_delivery WHERE od.id_order = '.$id_order);
        
        //$delivery = new Order($id_order);
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("SELECT count(*) FROM `kob_delivery_details` kdd
             left join `kob_delivery` kd on(kdd.id_delivery = kd.id_delivery)
             where kdd.id_order = ".$id_order."
             and kd.dr_file_name = '' ");
    }
    public static function getDrId($dr_number)
    {
        //var_dump('select id_delivery from `'._DB_PREFIX_.'delivery` where delivery_number='.$dr_number.'');   
        return Db::getInstance()->executeS('select id_delivery from `'._DB_PREFIX_.'delivery` where delivery_number='.$dr_number.'');   
    }
    public function checkStatus()
    {
        $query = 'SELECT oh.`id_order_state` FROM '._DB_PREFIX_.'delivery_details d
                    LEFT JOIN '._DB_PREFIX_.'order_history oh ON(d.`id_order` = oh.`id_order`)
                    WHERE d.`id_delivery` = '.$this->id.'
                    ORDER BY id_order_history DESC
                    LIMIT 1';
        $result = Db::getInstance()->executeS($query);
        if($result[0]['id_order_state'] == 4 || $result[0]['id_order_state'] == 8 || $result[0]['id_order_state'] == 25 || $result[0]['id_order_state'] == 33 )
        {
            return '1';
        }
        else{
            return '0';
        }
    }

    
     public function generateFilename(){
        $query = 'SELECT kd.dr_file_name as dr_file_name,concat(ko.id_order,"-",if(ko.invoice_number,concat(ko.invoice_number,"-"),""),kd.delivery_number) as name, SUBSTRING_INDEX(kd.dr_file_name, ".", 1) as org_name
                    FROM '._DB_PREFIX_.'delivery_details d
                    LEFT JOIN '._DB_PREFIX_.'delivery kd on kd.id_delivery=d.id_delivery
                    left JOIN '._DB_PREFIX_.'orders ko on ko.id_order = d.id_order
                    WHERE d.`id_delivery` = '.$this->id.'';
        $result = Db::getInstance()->executeS($query);
        
        return $result[0]['dr_file_name']!="" ? $result[0]['org_name'] : $result[0]['name'];
    }
}

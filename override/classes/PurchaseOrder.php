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

class PurchaseOrderCore extends ObjectModel
{
    /** @var String PO number */
    public $po_number;

    /** @var Date PO date */
    public $po_date;

    /** @var int PO Uploaded by User */
    public $uploaded_by;

    /** @var Date PO valid from */
    public $valid_from;

    /** @var Date PO valid through */
    public $valid_through;

    /** @var Date PO date added */
    public $date_add;

    /** @var int PO status */
    public $active;

    /** @var boolean PO delete **/
    public $delete;

    /** @var int PO address **/
    public $id_address;

    /** @var array product details **/
    public $product_details;

    /** @var decimal PO Value - for value based configs **/
    public $po_value;
	
    public static $definition = array(
        'table' => 'po',
        'primary' => 'id_purchase_order',
        'fields' => array(
            /* Classic fields */
            'po_number' =>            array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true),
            'po_date' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'uploaded_by' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'valid_from' =>                    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'),
            'valid_through' =>                    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'),
            'date_add' =>                    array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'),
            'active' =>                    array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
            'delete' =>                    array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool')
        )
    );

    public function dateValidationString($alias) {
        $string = 'CASE 
                       WHEN ('.$alias.'.`valid_from` != "0000-00-00 00:00:00" AND '.$alias.'.`valid_through` != "0000-00-00 00:00:00")
                       THEN ('.$alias.'.`valid_from` <= CURRENT_TIMESTAMP AND '.$alias.'.`valid_through` >= CURRENT_TIMESTAMP)
                       WHEN ('.$alias.'.`valid_from` != "0000-00-00 00:00:00" AND '.$alias.'.`valid_through` = "0000-00-00 00:00:00")
                       THEN ('.$alias.'.`valid_from` <= CURRENT_TIMESTAMP)
                       WHEN ('.$alias.'.`valid_from` = "0000-00-00 00:00:00" AND '.$alias.'.`valid_through` != "0000-00-00 00:00:00")
                       THEN ('.$alias.'.`valid_through` >= CURRENT_TIMESTAMP)
                       WHEN ('.$alias.'.`valid_from` = "0000-00-00 00:00:00" AND '.$alias.'.`valid_through` = "0000-00-00 00:00:00")
                       THEN TRUE
                   END';
        return $string;
    }

    public function mapAddressWithPurchaseOrder() {
        /* Looping products array */
        $insert_keyword = 'INSERT IGNORE';
        $fields_to_insert = '`id_purchase_order`, `id_address`, `id_option`';
        return $this->insertDetails('po_addresses', $fields_to_insert, $this->id_address, $insert_keyword);
    }

    public function addProductsToPurchaseOrder() {
        /* Looping products array */
        $insert_keyword = 'INSERT IGNORE';
        $fields_to_insert = '`id_purchase_order`, `id_product`, `quantity`';
        return $this->insertDetails('po_products', $fields_to_insert, $this->product_details, $insert_keyword);
    }

    public function addValueToPurchaseOrder() {
        return Db::getInstance()->insert('po_values', array('id_purchase_order' => $this->id, 'value' => $this->po_value));
    }

    protected function insertDetails($table, $fields_to_insert, $rows, $insert_keyword) 
    {
        /* Looping products array */
        if(is_array($rows)) {
            $values = array(); 
            foreach ($rows as $rowdata)
               $values[] = "(".implode(",", $rowdata).")"; 

            $sql = $insert_keyword.' INTO `'._DB_PREFIX_.$table.'` ('.$fields_to_insert.') VALUES '.implode(",", $values);
            return (bool)Db::getInstance()->execute($sql);
        }
        else { 
            return false;
        }
    }

    /*
    * Function to check address for po configured or not
    * Param 1 - Address ID
    */
    public function isAddressPoConfigured($id_address, $id_option = 0, $is_valid_now = true) {
        $sql = 'SELECT po.*, poa.`id_address`
               FROM `'._DB_PREFIX_.'po_addresses` poa
               LEFT JOIN `'._DB_PREFIX_.'po` po ON poa.`id_purchase_order` = po.`id_purchase_order`
               WHERE poa.`id_address` IN('.$id_address.') 
               AND po.`active` = 1
               AND po.`delete` = 0
               AND poa.`id_option` = '.$id_option.'
               AND '.($is_valid_now ? '('.$this->dateValidationString('po').')' : 'po.`valid_through` >= CURRENT_TIMESTAMP');
        $result = Db::getInstance()->executeS($sql);

        $configured = false;

        if(sizeof($result) > 0) {
            if($id_option == 1) {}
            else if($id_option == 2) {
                foreach($result as $po) {
                    $purchase_order = new PurchaseOrder(intval($po['id_purchase_order']));
                    $po_values = $purchase_order->getPurchaseOrderValues($po['id_address'], $id_option, true, $is_valid_now = true);
                    if($po_values[0]['available_value'] > 0) {
                        $configured = true;
                        break;
                    }
                }
            }
        }
        
        return $configured;
    }

    /*
    * Function to get po products by address and product Id (Optional)
    * Param 1 - Mandatory, Param 2 - Optional
    */
    public function getPurchaseOrderProducts($id_address, $id_option, $group_po = false, $id_product = NULL, $is_valid_now = true) {
        $sql = 'SELECT p.`id_product`, p.`available_quantity`, p.`id_purchase_order`
                FROM (
                    SELECT pod.`id_product`, 
                    (SUM(pod.`quantity`) - IF(ph.`product_quantity` != "", ph.`product_quantity`, 0)) AS available_quantity,
                    pod.`id_purchase_order`
                    FROM `'._DB_PREFIX_.'po_products` pod
                    LEFT JOIN (
                        SELECT SUM(ph.`quantity`) AS product_quantity, ph.`id_product`, ph.`id_purchase_order`
                        FROM '._DB_PREFIX_.'po_products_history ph
                        LEFT JOIN '._DB_PREFIX_.'orders o ON ph.`id_order` = o.`id_order`
                        LEFT JOIN `'._DB_PREFIX_.'po` ipo ON ph.`id_purchase_order` = ipo.`id_purchase_order`
                        LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON ipo.`id_purchase_order` = poa.`id_purchase_order`
                        WHERE o.`current_state` NOT IN(6, 49, 7, 8) 
                        AND poa.`id_address` = '.intval($id_address).'
                        AND ph.`quantity` > 0
                        AND '.($is_valid_now ? '('.$this->dateValidationString('ipo').')' : 'ipo.`valid_through` >= CURRENT_TIMESTAMP').'
                        '.($group_po ? 'GROUP BY ph.`id_product`' : 'GROUP BY ph.`id_product`, ph.`id_purchase_order`').'
                    )ph ON '.($group_po ? 'pod.`id_product` = ph.`id_product`' : '(pod.`id_product` = ph.`id_product`) AND (pod.`id_purchase_order` = ph.`id_purchase_order`)').'
                    LEFT JOIN `'._DB_PREFIX_.'po` po ON pod.`id_purchase_order` = po.`id_purchase_order`
                    LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON po.`id_purchase_order` = poa.`id_purchase_order`
                    WHERE poa.`id_address` = '.(int)$id_address.' 
                    '.((int)$id_product != "" ? ' AND pod.`id_product` = '.(int)$id_product.'' : "").' 
                    AND po.`active` = 1
                    AND po.`delete` = 0
                    AND poa.`id_option` = '.$id_option.'
                    AND '.($is_valid_now ? '('.$this->dateValidationString('po').')' : 'po.`valid_through` >= CURRENT_TIMESTAMP').' 
                    '.($group_po ? 'GROUP BY pod.`id_product`' : 'GROUP BY pod.`id_product`, pod.`id_purchase_order`').'
                )p '.(!$group_po ? 'WHERE p.`available_quantity` > 0' : '').'';
        $result = Db::getInstance()->executeS($sql);
        return $result;
    }

    /*
    * Function to get PO value for Values based configuration
    */
    public function getPurchaseOrderValues($id_address, $id_option, $group_po = false, $is_valid_now = true) {
        $sql = 'SELECT p.`available_value`, p.`id_purchase_order` FROM (
                    SELECT (SUM(pov.`value`) - IF(pvh.`value` != "", pvh.`value`, 0)) AS available_value,
                    pov.`id_purchase_order`
                    FROM `'._DB_PREFIX_.'po_values` pov
                    LEFT JOIN (
                        SELECT SUM(pvh.`value`) AS value, pvh.`id_purchase_order`
                        FROM '._DB_PREFIX_.'po_values_history pvh
                        LEFT JOIN '._DB_PREFIX_.'orders o ON pvh.`id_order` = o.`id_order`
                        LEFT JOIN `'._DB_PREFIX_.'po` ipo ON pvh.`id_purchase_order` = ipo.`id_purchase_order`
                        LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON ipo.`id_purchase_order` = poa.`id_purchase_order`
                        WHERE o.`current_state` NOT IN(6, 49, 7, 8)
                        AND poa.`id_address` = '.intval($id_address).'
                        '.(isset($this->id) && $this->id ? 'AND ipo.`id_purchase_order` = '.$this->id.'' : '').'
                        AND pvh.`value` > 0
                        AND '.($is_valid_now ? '('.$this->dateValidationString('ipo').')' : 'ipo.`valid_through` >= CURRENT_TIMESTAMP').'
                        '.($group_po ? 'GROUP BY pvh.`id_purchase_order`' : "").'
                    )pvh ON pov.`id_purchase_order` = pvh.`id_purchase_order`
                    LEFT JOIN `'._DB_PREFIX_.'po` po ON pov.`id_purchase_order` = po.`id_purchase_order`
                    LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON po.`id_purchase_order` = poa.`id_purchase_order`
                    WHERE poa.`id_address` = '.(int)$id_address.' 
                    AND po.`active` = 1
                    AND po.`delete` = 0
                    '.(isset($this->id) && $this->id ? 'AND po.`id_purchase_order` = '.$this->id.'' : '').'
                    AND poa.`id_option` = '.$id_option.'
                    AND '.($is_valid_now ? '('.$this->dateValidationString('po').')' : 'po.`valid_through` >= CURRENT_TIMESTAMP').'
                    '.($group_po ? 'GROUP BY pov.`id_purchase_order`' : "").'
                )p '.($group_po ? 'WHERE p.`available_value` > 0' : "").'';  
        $result = Db::getInstance()->executeS($sql);
        return $result;
    }

    /* 
    * Function to get PO Numbers associated to Address
    * Param 1 - Address ID
    * Result - String of one or more po numbers
    */
    public function getPoStringByAddress($id_address, $id_option) {
        $sql = 'SELECT GROUP_CONCAT(po.`po_number`) AS po_numbers
                FROM `'._DB_PREFIX_.'po` po
                LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON po.`id_purchase_order` = poa.`id_purchase_order`
                WHERE poa.`id_address` = '.(int)$id_address.'
                AND poa.`id_option` = '.$id_option.'
                AND po.`delete` = 0
                AND po.`active` = 1
                AND ('.$this->dateValidationString('po').')';
        $result = Db::getInstance()->getValue($sql);
        return $result;
    }

    /*
    * Function to get history quantity by Order ID and Product ID
    */
    public function getPurchaseHistoryOrderQuantity($id_product, $id_purchase_order) {
        $sql = 'SELECT SUM(IF(ph.`quantity` IS NOT NULL, ph.`quantity`, 0)) AS quantity
                FROM `'._DB_PREFIX_.'po_products_history` ph
                WHERE ph.`id_product` = '.$id_product.' AND ph.`id_purchase_order` = '.$id_purchase_order.'';
        return Db::getInstance()->getValue($sql);
    }

    /*
    * Function to check whether order is under BUDGET SYSTEM
    */
    public static function orderExists($id_order) {
        $products_history = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'po_products_history` WHERE id_order = '.$id_order.'');
        $values_history = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'po_values_history` WHERE id_order = '.$id_order.'');
        if($products_history != "") {
            return 1;
        }
        else if($values_history != "") {
            return 2;
        }
        return false;
    }

    /*
    * Function to update purchase order history when cancelling some quantity in order - product wise
    */
    public static function updateHistoryByIdProduct($id_order, $id_product, $quantity_to_revert) {
        $sql = 'SELECT id_purchase_order, id_product, quantity, id_order FROM `'._DB_PREFIX_.'po_products_history`
                WHERE id_order = '.$id_order.' AND id_product = '.$id_product.' 
                ORDER BY id_purchase_order DESC';
        $products = Db::getInstance()->executeS($sql);

        foreach ($products as $key => $product) 
        {
            if($product['quantity'] > 0) {
                if($product['quantity'] <= $quantity_to_revert) {
                    $quantity_to_update = 0;
                    $quantity_deducted = $product['quantity'];
                }
                else if($product['quantity'] > $quantity_to_revert) {
                    $quantity_to_update = $product['quantity'] - $quantity_to_revert;
                    $quantity_deducted = $quantity_to_revert;
                }

                $quantity_to_revert = $quantity_to_revert - $quantity_deducted;

                Db::getInstance()->update('po_products_history', array('quantity' => $quantity_to_update), 
                                        'id_purchase_order = '.$product['id_purchase_order'].' 
                                        AND id_product = '.$id_product.' AND id_order = '.$id_order.'');

                if($quantity_to_revert == 0)
                    break;
            }
        }
    }

    /*
    * Function to update purchase order history when cancelling some quantity in order - value based
    */
    public static function updateHistoryByIdOrder($id_order, $unit_price_tax_incl, $quantity_to_cancel) {
        $sql = 'SELECT id_purchase_order, value, id_order FROM `'._DB_PREFIX_.'po_values_history`
                WHERE id_order = '.$id_order.' ORDER BY id_purchase_order DESC';
        $values = Db::getInstance()->executeS($sql);

        $total_price_to_reduce = $unit_price_tax_incl * $quantity_to_cancel;
        
        foreach ($values as $key => $value) 
        {
            if($value['value'] > 0) {
                if($value['value'] <= $total_price_to_reduce) {
                    $value_to_update = 0;
                    $value_deducted = $value['value'];
                }
                else if($value['value'] > $total_price_to_reduce) {
                    $value_to_update = $value['value'] - $total_price_to_reduce;
                    $value_deducted = $total_price_to_reduce;
                }

                $total_price_to_reduce = $total_price_to_reduce - $value_deducted;

                Db::getInstance()->update('po_values_history', 
                    array('value' => $value_to_update), 
                    'id_purchase_order = '.$value['id_purchase_order'].' AND id_order = '.$id_order.''
                );

                if($total_price_to_reduce == 0)
                    break;
            }
        }
    }

    /*
    * Function to get all PO details
    */
    public function getAllPO($active = 1) {
        $sql = 'SELECT po.*, DATE_FORMAT(po.`po_date`, "%M %d, %Y") AS po_date, 
            DATE_FORMAT(po.`valid_through`, "%M %d, %Y") AS validity_date,
            c.`firstname`, c.`lastname`, c.`email`, c.`id_customer`, c.`id_default_group`,
            IF(pog.`id_option` = 1, "Product Based", "Value Based") AS budget_type, pog.`id_option`
            FROM `'._DB_PREFIX_.'po` po
            LEFT JOIN `'._DB_PREFIX_.'customer` c ON po.`uploaded_by` = c.`id_customer`
            LEFT JOIN `'._DB_PREFIX_.'po_options_group` pog ON c.`id_default_group` = pog.`id_group`
            WHERE po.`delete` = 0
            AND po.`active` = '.$active.'
            AND po.`valid_through` >= CURRENT_TIMESTAMP
            AND ('.$this->dateValidationString('po').')
            GROUP BY po.`id_purchase_order`';
        return Db::getInstance()->executeS($sql);
    } 

    /* 
    * Function to get PO details by address and option
    */
    public function getPurchaseOrdersByAddress($id_address, $id_option, $is_valid_now = true) {
        $sql = 'SELECT (CASE 
                    WHEN (po.`valid_through` = "0000-00-00 00:00:00") THEN "Unlimited" 
                    WHEN (po.`valid_through` >= CURRENT_TIMESTAMP) THEN DATE_FORMAT(po.`valid_through`, "%M %d, %Y")
                    WHEN (po.`valid_through` < CURRENT_TIMESTAMP) THEN "Expired"
                END) AS validity,
            po.`id_purchase_order`, po.`po_number`, DATE_FORMAT(po.`po_date`, "%M %d, %Y") AS po_date
            FROM `'._DB_PREFIX_.'po` po
            LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON po.`id_purchase_order` = poa.`id_purchase_order` 
            WHERE poa.`id_address` = '.$id_address.'
            '.(isset($id_option) && $id_option ? 'AND poa.`id_option` = '.$id_option.'' : "").'
            AND po.`delete` = 0
            AND po.`active` = 1
            AND '.($is_valid_now ? '('.$this->dateValidationString('po').')' : 'po.`valid_through` >= CURRENT_TIMESTAMP').'
            GROUP BY po.`id_purchase_order`';
        return Db::getInstance()->executeS($sql);
    }

    /*
    * Function to get All PO Options
    */
    public function getAllPoOptions($id_company) {
        $sql = 'SELECT poo.*, IF(poog.`id_group` IS NULL OR poog.`id_group` = "", 0, 1) AS active_option
                FROM `'._DB_PREFIX_.'po_options` poo
                LEFT JOIN(
                    SELECT poog.* FROM `'._DB_PREFIX_.'po_options_group` poog WHERE poog.`id_group` = '.$id_company.'
                )poog ON poo.`id_option` = poog.`id_option`';
        return Db::getInstance()->executeS($sql);
    }

    /*
    * Function to get PO Option by company
    */
    public static function getPoOption($id_company) {
        $sql = 'SELECT IF(poog.`id_group` IS NULL OR poog.`id_group` = "", 0, poog.`id_option`) AS active_option
                FROM `'._DB_PREFIX_.'po_options_group` poog WHERE poog.`id_group` = '.$id_company.'';
        $result = Db::getInstance()->getValue($sql);
        if($result != "") {
            return $result;
        }
        else {
            return 0;
        }
    }

    /*
    * Function to update PO options
    */
    public function setPoOption($id_customer, $id_option) {
        $customerObj = new Customer($id_customer);
        
        $existing_po_option = Db::getInstance()->getValue('SELECT id_option FROM `'._DB_PREFIX_.'po_options_group` WHERE id_group = '.$customerObj->id_default_group.'');
        
        if($existing_po_option != "")
            $set_po_option = Db::getInstance()->update('po_options_group', array('id_option' => $id_option), 'id_group = '.$customerObj->id_default_group.'');
        else
            $set_po_option = Db::getInstance()->insert('po_options_group', array('id_group' => $customerObj->id_default_group, 'id_option' => $id_option));
        
        if($set_po_option) {
            return Db::getInstance()->insert(
                'po_options_group_history', 
                array('id_option_old' => $existing_po_option, 'id_option_new' => $id_option, 'id_customer' => $id_customer)
            );
        }
    }

    public static function getPoHistoryValues($id_order) {
        $sql = 'SELECT povh.* FROM `'._DB_PREFIX_.'po_values_history` povh WHERE povh.`id_order` = '.$id_order.' ORDER BY povh.`id_purchase_order` DESC';
        return Db::getInstance()->executeS($sql);
    }

    public static function getPoHistoryProducts($id_order) {
        $sql = 'SELECT poph.* FROM `'._DB_PREFIX_.'po_products_history` poph WHERE poph.`id_order` = '.$id_order.' ORDER BY poph.`id_purchase_order` DESC';
        return Db::getInstance()->executeS($sql);
    }

    public function uploadPo($po_number, $file_array) {
        $file = $file_array['file']['name'];
        $temp_name  = $file_array['file']['tmp_name'];
        if($file != "" && isset($file)) {
            // Allowed file formats
            $allowed =  array('xls','xlsx', 'png', 'jpg', 'jpeg', 'pdf', 'zip', 'rar');
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            if(!in_array(strtolower($ext), $allowed)) 
                return "File format not supported."; // File format not supported
            else 
            {
                if($file_array['file']['size'] > (5 * 1024 * 1024)) 
                    return 1; // Size is too large. Allowed file size - <= 5MB
                else 
                {
                    $file_name = $po_number."-BUDGET_PO";
                    $splitName = explode(".", $file);
                    $fileExt = end($splitName);

                    if(count($splitName) > 1)
                        $newFileName  = strtolower($file_name.'.'.$fileExt);  
                    else
                        $newFileName  = strtolower($file_name);

                    $location = "customer_PO/"; 

                    if(!move_uploaded_file($temp_name, "$location/$newFileName"))
                        return 2; // Upload error
                    else
                        return 3;
                }
            }
        }
        else {
            return "Please upload file to proceed.";
        }
    }

    public function downloadPoById($po_numbers) {
        $po_numbers_array = explode(',', $po_numbers);
        $files_array = array();
        foreach ($po_numbers_array as $key => $po) {
            $file_po = glob("customer_PO/$po-budget_po*.*");
            if(!empty($file_po)) {
                foreach ($file_po as $file_po_info) {
                   $info = pathinfo($file_po_info);
                   array_push($files_array, $file_po_info);
                }
            }
        }
        $zipname = 'Budget-PO-'.str_replace(',', '-', $po_numbers).'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        foreach ($files_array as $file) {
          $zip->addFile($file);
        }
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);
    }

    public static function getAllPoHistory($id_address, $po_option = 0, $limit = 0, $offset = 0, $orderBy = NULL, $orderWay = NULL, $fromDate = NULL, $toDate = NULL) {
        $dataLimit = ($limit && ($offset == 0 || $offset)) ? ' LIMIT '.$offset.', '.$limit.'' : "";
        $count_rows = 'SELECT FOUND_ROWS() AS total';
       
        if($po_option == 1) {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS po.`id_purchase_order`, po.`po_number`, DATE_FORMAT(po.`po_date`, "%M %d, %Y") AS po_date, 
                    FORMAT(((IF(pph.`quantity` IS NOT NULL, pph.`quantity`, 0) * 100) / SUM(pp.`quantity`)), 0) AS po_consumption,
                    (CASE 
                        WHEN (po.`valid_through` = "0000-00-00 00:00:00") THEN "Unlimited" 
                        WHEN (po.`valid_through` >= CURRENT_TIMESTAMP) THEN DATE_FORMAT(po.`valid_through`, "%M %d, %Y")
                        WHEN (po.`valid_through` < CURRENT_TIMESTAMP) THEN "Expired"
                    END) AS po_validity, poa.`id_address`, po.`active`
                    FROM `'._DB_PREFIX_.'po` po
                    LEFT JOIN `'._DB_PREFIX_.'po_products` pp ON po.`id_purchase_order` = pp.`id_purchase_order`
                    LEFT JOIN (
                      SELECT SUM(pph.`quantity`) AS quantity, pph.`id_product`, pph.`id_purchase_order`
                      FROM `'._DB_PREFIX_.'po_products_history` pph
                      LEFT JOIN `'._DB_PREFIX_.'orders` o ON pph.`id_order` = o.`id_order`
                      WHERE o.`current_state` NOT IN(6, 49, 7, 8) GROUP BY pph.`id_purchase_order`
                    ) pph ON po.`id_purchase_order` = pph.`id_purchase_order`
                    LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON po.`id_purchase_order` = poa.`id_purchase_order`
                    WHERE poa.`id_address` = '.($id_address != '' ? $id_address : 0).' 
                    AND poa.`id_option` = '.$po_option.'
                    AND po.`delete` = 0
                    GROUP BY po.`id_purchase_order` ORDER BY po.`date_add` DESC';
        }
        else if($po_option == 2) {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS po.`id_purchase_order`, po.`po_number`, DATE_FORMAT(po.`po_date`, "%M %d, %Y") AS po_date, 
                    FORMAT(((IF(pvh.`value` IS NOT NULL, pvh.`value`, 0) * 100) / SUM(pv.`value`)), 0) AS po_consumption,
                    (CASE 
                        WHEN (po.`valid_through` = "0000-00-00 00:00:00") THEN "Unlimited" 
                        WHEN (po.`valid_through` >= CURRENT_TIMESTAMP) THEN DATE_FORMAT(po.`valid_through`, "%M %d, %Y")
                        WHEN (po.`valid_through` < CURRENT_TIMESTAMP) THEN "Expired"
                    END) AS po_validity, poa.`id_address`, po.`active`
                    FROM `'._DB_PREFIX_.'po` po
                    LEFT JOIN `'._DB_PREFIX_.'po_values` pv ON po.`id_purchase_order` = pv.`id_purchase_order`
                    LEFT JOIN (
                      SELECT SUM(pvh.`value`) AS value, pvh.`id_purchase_order`
                      FROM `'._DB_PREFIX_.'po_values_history` pvh
                      LEFT JOIN `'._DB_PREFIX_.'orders` o ON pvh.`id_order` = o.`id_order`
                      WHERE o.`current_state` NOT IN(6, 49, 7, 8) GROUP BY pvh.`id_purchase_order`
                    ) pvh ON po.`id_purchase_order` = pvh.`id_purchase_order`
                    LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON po.`id_purchase_order` = poa.`id_purchase_order`
                    WHERE poa.`id_address` = '.($id_address != '' ? $id_address : 0).' 
                    AND poa.`id_option` = '.$po_option.'
                    AND po.`delete` = 0
                    GROUP BY po.`id_purchase_order` ORDER BY po.`date_add` DESC';
        }
        else {
            return false;
        }
        
        $data_sql = $sql.$dataLimit;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($data_sql);
        $total = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($count_rows);
        return array('total' => $total, 'results' => $result);
    }

    public function getProducts($id_address = null) {
        $sql = 'SELECT p.`reference`, pl.`name`, pp.`id_product`, pp.`quantity`, IFNULL(pph.`quantity`, 0) AS consumed_quantity,
                (pp.`quantity` - IFNULL(pph.`quantity`, 0)) AS remaining_quantity,
                pp.`id_purchase_order`
                FROM `'._DB_PREFIX_.'po_products` pp
                LEFT JOIN (
                    SELECT SUM(pph.`quantity`) AS quantity, pph.`id_product`
                    FROM `'._DB_PREFIX_.'po_products_history` pph
                    LEFT JOIN `'._DB_PREFIX_.'orders` o ON pph.`id_order` = o.`id_order`
                    WHERE o.`current_state` NOT IN(6, 49, 7, 8) AND pph.`id_purchase_order` = '.$this->id.' GROUP BY pph.`id_product` 
                )pph ON pp.`id_product` = pph.`id_product`
                LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON pp.`id_purchase_order` = poa.`id_purchase_order`
                LEFT JOIN `'._DB_PREFIX_.'product` p ON pp.`id_product` = p.`id_product`
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pp.`id_product` = pl.`id_product`) AND pl.`id_lang` = 1
                WHERE pp.`id_purchase_order` = '.$this->id.' 
                '.(isset($id_address) && $id_address != '' ? 'AND poa.`id_address` = '.$id_address.'' : '').'
                AND poa.`id_option` = 1';
        return Db::getInstance()->executeS($sql);
    }

    public function getValues($id_address = null) {
        $sql = 'SELECT pv.`id_purchase_order`, pv.`value`, IFNULL(pvh.`value`, 0) AS consumed_value, 
                (pv.`value` - IFNULL(pvh.`value`, 0)) AS remaining_value
                FROM `'._DB_PREFIX_.'po_values` pv
                LEFT JOIN (
                    SELECT SUM(pvh.`value`) AS value, pvh.`id_purchase_order`
                    FROM `'._DB_PREFIX_.'po_values_history` pvh
                    LEFT JOIN `'._DB_PREFIX_.'orders` o ON pvh.`id_order` = o.`id_order`
                    WHERE o.`current_state` NOT IN(6, 49, 7, 8) AND pvh.`id_purchase_order` = '.$this->id.' GROUP BY pvh.`id_purchase_order`
                )pvh ON pv.`id_purchase_order` = pvh.`id_purchase_order`
                LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON pv.`id_purchase_order` = poa.`id_purchase_order`
                WHERE pv.`id_purchase_order` = '.$this->id.' 
                '.(isset($id_address) && $id_address != '' ? 'AND poa.`id_address` = '.$id_address.'' : '').' 
                AND poa.`id_option` = 2';
        return Db::getInstance()->executeS($sql);
    }

    public function getOrders($id_address, $id_option) {
        $sql = 'SELECT poh.`id_order`, DATE_FORMAT(o.`date_add`, "%M %d, %Y") AS ordered_date,
                '.($id_option == 1 ? 'o.`total_paid_tax_incl` AS total_spent' : 'SUM(poh.`value`) AS total_spent').'
                FROM `'._DB_PREFIX_.'po_'.($id_option == 1 ? 'products' : 'values').'_history` poh
                LEFT JOIN `'._DB_PREFIX_.'orders` o ON poh.`id_order` = o.`id_order`
                LEFT JOIN `'._DB_PREFIX_.'po_addresses` poa ON poh.`id_purchase_order` = poa.`id_purchase_order`
                WHERE o.`current_state` NOT IN(6, 49, 7, 8)
                AND poh.`id_purchase_order` = '.$this->id.' 
                AND poa.`id_address` = '.$id_address.' 
                AND poa.`id_option` = '.$id_option.'
                GROUP BY poh.`id_order`, poh.`id_purchase_order` ORDER BY poh.`id_order` DESC';
        return Db::getInstance()->executeS($sql);
    }

    public function addActionHistory($action_type, $id_user) {
        return Db::getInstance()->autoExecute(_DB_PREFIX_.'po_action_history', 
            array('id_purchase_order' => $this->id, 'id_user' => $id_user, 'action_type' => $action_type), 'INSERT'
        );
    }

    public function isExists($po_number, $id_address) {
        return Db::getInstance()->getValue('SELECT po.`id_purchase_order` 
            FROM `'._DB_PREFIX_.'po` po 
            LEFT JOIN `'._DB_PREFIX_.'po_addresses` pa ON po.`id_purchase_order` = pa.`id_purchase_order`
            WHERE po.po_number = "'.$po_number.'" 
            AND pa.`id_address` = '.intval($id_address).'
        ');
    }
}

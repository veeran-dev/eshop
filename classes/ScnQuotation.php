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
*  @version  Release: $Revision: 14850 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class ScnQuotationCore extends ObjectModel
{

	public 		$id_quotation;

	/** @var int id_customer */
	public		$id_customer;

	/** @var int id_company */
	public		$id_group;

	/** @var string quote name */
	public		$quote_name;

	/** @var integer Quote version ID */
	public		$quote_version;

	/** @var integer employee ID */
	public      $id_employee;

	/** @var Boolean published status */
	public      $published;

	/** @var Date generated */
	public      $date_generated;

	/** @var Boolean active/inactive */
	public      $active;

	/** @var integer rm publish status */
	public      $rm_published;

	public 		$expiry;

	public 		$deadline;

	public 		$file;

	/** @var integer id_product */
	public 		$id_product;

	protected $tables = array ('quotation');

 	protected 	$fieldsRequired = array('quote_name', 'id_group', 'id_employee');
	protected 	$table = 'quotation';
	protected 	$identifier = 'id_quotation';

	public function getFields()
	{
		parent::validateFields();
		$fields['id_quotation'] = (int)$this->id_quotation;
		$fields['id_customer'] = (int)$this->id_customer;
		$fields['id_group'] = (int)$this->id_group;
		$fields['quote_name'] = pSQL($this->quote_name);
		$fields['quote_version'] = (int)$this->quote_version;
		$fields['id_employee'] = (int)$this->id_employee;
		$fields['date_generated'] = pSQL($this->date_generated);
		$fields['published'] = (int)$this->published;
		$fields['rm_published'] = (int)$this->rm_published;
		$fields['active'] = (int)$this->active;
		$fields['expiry'] = (int)$this->expiry;
		$fields['deadline'] = (int)$this->deadline;
		$fields['file'] = (int)$this->file;
		return $fields;
	}

	public function isExistsQuote($quotation_name,$id_company)
	{
		return Db::getInstance()->getValue('SELECT count(`id_quotation`) FROM `'._DB_PREFIX_.'quotation` WHERE `quote_name` = "'.$quotation_name.'" AND `id_group` = "'.$id_company.'"');
	}

	public function addProdToQuotation($id_quotation, $id_product, $price, $remarks, $date)
	{	
        $result = Db::getInstance()->ExecuteS('SELECT COUNT(id_product) as id_product_count FROM '._DB_PREFIX_.'quotation_detail WHERE id_product='.$id_product.' AND `id_quotation`= '.$id_quotation.'');
        
        if($result[0]['id_product_count'] > 0)
        {
        	return Db::getInstance()->autoExecute(_DB_PREFIX_.'quotation_detail', array('id_product' => $id_product, 'remarks' => $remarks, 'product_price' => $price, 'to' => $date), 'UPDATE', 'id_product ='.$id_product.' AND id_quotation ='.$id_quotation.'');
        }
        else
        {
        	return Db::getInstance()->autoExecute(_DB_PREFIX_.'quotation_detail', array('id_quotation' => $id_quotation,'id_product' => $id_product, 'remarks' => $remarks, 'product_price' => $price, 'to' => $date), 'INSERT');
        }
   	}

	public function getQuotations($id_group, $type, $id_employee = NULL)
	{
 			if($type == 4) {
				$result = Db::getInstance()->ExecuteS('SELECT v.*,vp.`id_product` AS product_id,vp.`product_price` AS price, gl.`name` AS company
													   FROM '._DB_PREFIX_.'quotation v 
													   LEFT JOIN '._DB_PREFIX_.'group_lang gl ON v.`id_group` = gl.`id_group` AND gl.`id_lang` = 1
													   LEFT JOIN '._DB_PREFIX_.'quotation_detail vp ON vp.`id_quotation`=v.`id_quotation`
													   WHERE v.`id_group`='.$id_group.' AND v.`active` = 1 
													   GROUP BY `id_quotation` 
													   ORDER BY `id_quotation` DESC');
			}
			else {
				$result = Db::getInstance()->ExecuteS('SELECT a.`id_group`, gl.`name` as firstname , b.* 
													FROM '._DB_PREFIX_.'group a 
													LEFT JOIN '._DB_PREFIX_.'group_lang AS gl ON gl.id_group = a.id_group
													LEFT JOIN '._DB_PREFIX_.'quotation b ON a.`id_group` = b.`id_group`													
													WHERE  b.`published` = 1 
													AND a.id_group = '.$id_group.'
													AND gl.id_lang = 1');										   
			}

			return $result;
	}

	public function reviseViewQuotation($id_quotation, $type)
	{
		if($type == 4)
			$query = 'vp.`id_quotation`='.(int)$id_quotation.' AND v.published = 1';
		else
			$query = 'vp.`id_quotation`='.(int)$id_quotation.' AND v.active = 1'; 

		$result = Db::getInstance()->ExecuteS('SELECT v.*,vp.`id_product` AS product_id,vp.`product_price` AS price,kpl.`name` AS product_name,
											   p.`reference` AS product_code,vp.`to`,vp.`remarks` AS remarks, p.`price` AS product_price 
											   FROM '._DB_PREFIX_.'quotation AS v 
											   LEFT JOIN '._DB_PREFIX_.'quotation_detail AS vp ON vp.`id_quotation` = v.`id_quotation` 
											   LEFT JOIN '._DB_PREFIX_.'product_lang AS kpl ON kpl.`id_product` = vp.`id_product` 
											   LEFT JOIN '._DB_PREFIX_.'product AS p ON p.id_product = vp.id_product
											   WHERE '.$query.' GROUP BY kpl.`id_product` ORDER BY `id_quotation` ASC');
		
		for($i = 0; $i < sizeof($result); $i++)
		{
			$get_product_tax[$i][0]['tax_rate'] = $this->getProductTaxRate((int)$result[$i]['product_id']);
		}

		$result = array($result, $get_product_tax);

		return $result;
	}

	public static function getLastAddedQuotVersion($search_string,$id_company)
	{
			return Db::getInstance()->ExecuteS('SELECT `quote_version` FROM '._DB_PREFIX_.'quotation WHERE `quote_name` = "'.$search_string.'" AND `id_group` = '.$id_company.' ORDER BY `quote_version` DESC LIMIT 1');
	}
	
	public static function getProdPiceDetail($id_product)
	{
		$now = date('Y-m-d H:i:s');
		$sql = 'SELECT p.`reference`, 
				IF(p.`price` > 0 AND (tax_country.`rate` != "" OR tax_country.`rate` = 0.000) , ROUND((p.`price` * ((tax_country.`rate` / 100) + 1 )), 2), "NA") AS mrp,
				IF(tax_country.`rate` != "" OR tax_country.`rate` = 0.000, tax_country.`rate`, "NA") AS tax,
				IF(p.`wholesale_price` != 0, ROUND(p.`wholesale_price`, 2), "NA") AS agreed_buying_price,
				IF(cus_price.`low_price` != "", ROUND(cus_price.`low_price`, 2), "NA") AS cus_price_low,
				IF(cus_price.`high_price` != "", ROUND(cus_price.`high_price`, 2), "NA") AS cus_price_high,
				IF(sa.`out_of_stock` = 0 AND sa.`quantity` <= 0, 1, 0) AS product_current_status
				FROM `'._DB_PREFIX_.'product` p
				LEFT JOIN (
					SELECT MIN(b.`price`) AS low_price, MAX(b.`price`) AS high_price, b.`id_product`
					FROM `'._DB_PREFIX_.'group` a 
					LEFT JOIN '._DB_PREFIX_.'specific_price b ON a.`id_group` = b.`id_group` 
					WHERE b.`id_product`='.$id_product.' AND ((b.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= b.`from`) 
					AND (b.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= b.`to`)) AND b.`id_group` NOT IN(0,1)
				)cus_price ON p.`id_product` = cus_price.`id_product`
				LEFT JOIN (
					SELECT t.`rate`,tr.`id_tax_rules_group` FROM `kob_tax_rule` tr
					LEFT JOIN `kob_tax` t ON tr.`id_tax` = t.`id_tax`
					WHERE tr.`id_country` = 110 AND tr.`id_state` = 0 AND t.`active` = 1 AND t.`deleted` = 0
				)tax_country ON p.`id_tax_rules_group` = tax_country.`id_tax_rules_group`
				LEFT JOIN `kob_stock_available` sa ON p.`id_product` = sa.`id_product`
				WHERE p.`id_product` = "'.$id_product.'" GROUP BY p.`id_product`';

		return Db::getInstance()->executeS($sql);
	}

	public static function getQuoteDetail($id_quotation)
	{
		return Db::getInstance()->ExecuteS('SELECT `id_product`,`product_price`,`to` FROM '._DB_PREFIX_.'quotation_detail WHERE id_quotation = '.$id_quotation.'');
	}

	public function deleteQuoteProduct($id_product = false,$id_quotation = false)
	{
		return Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'quotation_detail` WHERE `id_quotation` = '.$id_quotation.' AND `id_product` = '.$id_product.'');
	}

	public function getProductTaxRate($id_product)
	{
		return Db::getInstance()->getValue('SELECT IF(tax_country.`rate` != "", tax_country.`rate`, "NA") AS tax_rate
											FROM `'._DB_PREFIX_.'product` p
											LEFT JOIN (
												SELECT t.`rate`,tr.`id_tax_rules_group` FROM `kob_tax_rule` tr
												LEFT JOIN `kob_tax` t ON tr.`id_tax` = t.`id_tax`
												WHERE tr.`id_country` = 110 AND tr.`id_state` = 0 AND t.`active` = 1 AND t.`deleted` = 0
											)tax_country ON p.`id_tax_rules_group` = tax_country.`id_tax_rules_group`
											WHERE p.`id_product` = "'.$id_product.'"');
	}

	public function getRegions() {
		return Db::getInstance()->getValue('SELECT IF(pm.`zone_name` != "", GROUP_CONCAT(pm.`zone_name`), "PAN India") AS region_name
											FROM '._DB_PREFIX_.'quotation_regions qr
											LEFT JOIN '._DB_PREFIX_.'pincode_master pm ON qr.`id_region` = pm.`zone_id`
											WHERE qr.`id_quotation` = '.$this->id);
	}

	public function addRegion($region_ids) {
		$region_array = explode(",", $region_ids);
		$region_ids_to_insert = "";
		foreach ($region_array as $key => $value) {
			$region_ids_to_insert .= "(".$this->id.",".$value."), ";
		}

		return Db::getInstance()->execute('INSERT INTO '._DB_PREFIX_.'quotation_regions(`id_quotation`, `id_region`) 
										   VALUES '.rtrim($region_ids_to_insert, ", "));
	}

	public function getPrices($id_product, $id_company, $type)
	{
		if($type == 1) {
			$now = date('Y-m-d H:i:s');
			$result = Db::getInstance()->executeS('SELECT b.`price`, 
				IF(b.`date_update` != "0000-00-00 00:00:00", DATE_FORMAT(b.`date_update`, "%D %M, %Y"), "Not Available") AS date_update, 
				IF(b.`to` != "0000-00-00 00:00:00", DATE_FORMAT(b.`to`, "%D %M, %Y"), "Unlimited") AS valid_till, gl.`name` AS company
				FROM `'._DB_PREFIX_.'group` a 
				LEFT JOIN `'._DB_PREFIX_.'group_lang` gl ON a.`id_group` = gl.`id_group` AND gl.`id_lang` = 1
				LEFT JOIN '._DB_PREFIX_.'specific_price b ON a.`id_group` = b.`id_group` 
				WHERE b.`id_product`='.$id_product.' AND b.`id_group` NOT IN(0,1)
				AND((b.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= b.`from`) 
           		AND (b.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= b.`to`))');
		}

		return array($result);
	}

	public static function getZoneIds() {
		return Db::getInstance()->getValue('SELECT GROUP_CONCAT(zone_id) AS zone_ids FROM `'._DB_PREFIX_.'pincode_master`');
	}

	public function getRegionsById($zone_id) {
		return Db::getInstance()->getValue('SELECT IF(pm.`zone_name` != "", GROUP_CONCAT(pm.`zone_name`), "PAN India") AS region_name
											FROM '._DB_PREFIX_.'pincode_master pm
											WHERE pm.`zone_id` IN('.$zone_id.')');
	}

	public function getQuotationDetailById($id_quotation) {
		return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'quotation_detail` WHERE id_quotation = '.$id_quotation);
	}

	public static function removeProductFromQuote($id_quotation, $id_product) {
		return Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'quotation_detail` 
										   WHERE id_quotation = '.$id_quotation.' AND id_product = '.$id_product);
	}

	public function isQuotedDateExpired($id_product) {
    	$now = date('Y-m-d H:i:s');
    	$sql = 'SELECT IF((qd.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= qd.`to`), 0, 1) AS expired 
				FROM `'._DB_PREFIX_.'quotation_detail` qd
				WHERE qd.`id_quotation` = '.intval($this->id).'
				AND qd.`id_product` = '.intval($id_product).'';
		return Db::getInstance()->getValue($sql);
    }

    public static function isQuotedPriceExceededMRP($id_product, $quoted_price) {
    	$product = new Product(intval($id_product));
    	if($quoted_price > $product->price) {
    		return true;
    	}
    	else {
    		return false;
    	}
	}
	
	public function quotations($query, $pageSize = NULL, $pageNum = NULL){
		$result = Db::getInstance()->ExecuteS('SELECT v.*,vp.`id_product` AS product_id,vp.`product_price` AS price, gl.`name` AS company
													   FROM '._DB_PREFIX_.'quotation v 
													   LEFT JOIN '._DB_PREFIX_.'group_lang gl ON v.`id_group` = gl.`id_group` AND gl.`id_lang` = 1
													   LEFT JOIN '._DB_PREFIX_.'quotation_detail vp ON vp.`id_quotation`=v.`id_quotation`
													   WHERE v.`id_group`='.$id_group.' AND v.`active` = 1 
													   GROUP BY `id_quotation` 
													   ORDER BY `id_quotation` DESC');
	}
}
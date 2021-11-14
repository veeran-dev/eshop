<?php
if (!defined('_CAN_LOAD_FILES_'))
	exit;
	
class EBS extends PaymentModule
{
	private	$_html = '';
	private $_postErrors = array();
	private $_responseReasonText = null;

	public function __construct(){
		$this->name = 'ebs';
		$this->tab = 'payments_gateways';
		$this->version = '3';
		$this->author = 'EBS Development Team';
        parent::__construct();
		$this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('EBS');
        $this->description = $this->l('Module for accepting payments by EBS');
	}
	
	public function getEBSUrl(){
		return 'https://secure.ebs.in/pg/ma/payment/request/';
	}
	
	public function install(){
		if(parent::install()){
			Configuration::updateValue('ACCOUNT_ID', '');
			Configuration::updateValue('SECRET_KEY', '');
			Configuration::updateValue('MODE', '');
            Configuration::updateValue('PAGE_ID', '');
            Configuration::updateValue('HASH_TYPE', '');
			$this->registerHook('payment');
			$this->registerHook('PaymentReturn');
			$this->registerHook('ShoppingCartExtra');
			if(!Configuration::get('EBS_ORDER_STATE')){
				$this->setEbsOrderState('EBS_ID_ORDER_SUCCESS','Payment Received','#b5eaaa');
				$this->setEbsOrderState('EBS_ID_ORDER_FAILED','Payment Failed','#E77471');
				$this->setEbsOrderState('EBS_ID_ORDER_PENDING','Payment Pending','#F4E6C9');			
				Configuration::updateValue('EBS_ORDER_STATE', '1');
			}		
			return true;
		}
		else {
			return false;
		}
	}
	
	public function uninstall(){
		if (!Configuration::deleteByName('ACCOUNT_ID') OR 
			!Configuration::deleteByName('SECRET_KEY') OR 
			!Configuration::deleteByName('MODE') OR 
            !Configuration::deleteByName('PAGE_ID') OR 
            !Configuration::deleteByName('HASH_TYPE') OR 
			!parent::uninstall()){
				return false;
		}	
		return true;
	}
	
	public function setEbsOrderState($var_name,$status,$color){
		$orderState = new OrderState();
		$orderState->name = array();
		foreach(Language::getLanguages() AS $language){
			$orderState->name[$language['id_lang']] = $status;
		}
		$orderState->send_email = false;
		$orderState->color = $color;
		$orderState->hidden = false;
		$orderState->delivery = false;
		$orderState->logable = true;
		$orderState->invoice = true;
		if ($orderState->add())
			Configuration::updateValue($var_name, (int)$orderState->id);
		return true;
	}
	
	public function getContent(){
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		if (isset($_POST['submitEBS'])){
			if (empty($_POST['account_id']))
				$this->_postErrors[] = $this->l('Please Enter the Account ID.');
			if (empty($_POST['secret_key']))
				$this->_postErrors[] = $this->l('Please Enter the Secret Key.');
			if (empty($_POST['mode']))
				$this->_postErrors[] = $this->l('Please Select the Mode.');
            if (empty($_POST['page_id']))
				$this->_postErrors[] = $this->l('Please Select the Page ID.');
            if (empty($_POST['hash_type']))
				$this->_postErrors[] = $this->l('Please Select the Hash Type.');
				
			if (!sizeof($this->_postErrors)){
				Configuration::updateValue('ACCOUNT_ID', $_POST['account_id']);
				Configuration::updateValue('SECRET_KEY', $_POST['secret_key']);
				Configuration::updateValue('MODE', $_POST['mode']);
                Configuration::updateValue('PAGE_ID', $_POST['page_id']);
                 Configuration::updateValue('HASH_TYPE', $_POST['hash_type']);
				$this->displayConf();
			}
			else{
				$this->displayErrors();
			}
		}
		$this->_displayEBS();
		$this->_displayFormSettings();
		return $this->_html;
	}
	
	public function displayConf(){
		$this->_html .= '
		<div class="conf confirm">
			<img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />
			'.$this->l('Settings updated').'
		</div>';
	}
	
	public function displayErrors(){
		$nbErrors = sizeof($this->_postErrors);
		$this->_html .= '
		<div class="alert error">
			<h3>'.($nbErrors > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbErrors.' '.($nbErrors > 1 ? $this->l('errors') : $this->l('error')).'</h3>
			<ol>';
		foreach ($this->_postErrors AS $error)
			$this->_html .= '<li>'.$error.'</li>';
		$this->_html .= '
			</ol>
		</div>';
	}
	
	public function _displayEBS(){
		$this->_html .= '
		<img src="../modules/ebs/logo_ebs.png" style="float:left; padding: 0px; margin-right:15px;" />
		<b>'.$this->l('This module allows you to accept payments by EBS.').'</b><br /><br />
		'.$this->l('If the client chooses this payment mode, your EBS account will be automatically credited.').'<br />
		'.$this->l('You need to configure your EBS account first before using this module.').'
		<br /><br /><br />';
	}
	
	public function _displayFormSettings(){
		$mod = Configuration::get('MODE');
		$acc_id = Configuration::get('ACCOUNT_ID');
		$sec_key = Configuration::get('SECRET_KEY');
        $page_id = Configuration::get('PAGE_ID');
        $hash_type = Configuration::get('HASH_TYPE');
		if(!empty($acc_id)){ $account_id = $acc_id; } else { $account_id = ''; }
		if(!empty($sec_key)){ $secret_key = $sec_key; } else { $secret_key = ''; }
		if(!empty($mod)){ 
			if($mod=='TEST'){
				$test_attr = "selected='selected'";
				$live_attr = '';
			}
			if($mod=='LIVE'){
				$live_attr = "selected='selected'";
				$test_attr = '';
			}
		}
		else{
			$live_attr = '';
			$test_attr = '';
		}

        if(!empty($hash_type)){ 
			if($hash_type=='MD5'){
				$md5 = "selected='selected'";
				$sha512 = '';
                $sha1 = '';
			}
			if($hash_type=='SHA512'){
				$md5 = '';
				$sha512 = "selected='selected'";
                $sha1 = '';
			}
            if($hash_type=='SHA1'){
				$md5 = '';
				$sha512 = '';
                $sha1 = "selected='selected'";
			}
		}
		else{
			$live_attr = '';
			$test_attr = '';
		}

		$this->_html .= '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Configuration Settings').'</legend>
				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">
					<tr><td colspan="2">'.$this->l('Please specify the Account ID and Secret Key to which Merchant must send their ebs.').'<br /><br /></td></tr>
					<tr><td width="130" style="height: 25px;">'.$this->l('Account ID').'</td><td><input type="text" name="account_id" value="'.$account_id.'" style="width: 150px;" /></td></tr>
					<tr>
						<td width="130" style="height: 25px;">'.$this->l('Secret Key').'</td>
						<td><input type="text" name="secret_key" value="'.$secret_key.'" style="width: 150px;" /></td>
					</tr>
					<tr>
						<td width="130" style="height: 25px;">'.$this->l('Mode').'</td>
						<td>
							<select name="mode" style="width: 100px;">
								<option value="">-Select-</option>
								<option value="TEST" '.$test_attr.'>TEST</option>
								<option value="LIVE" '.$live_attr.'>LIVE</option>
							</select>
						</td>
					</tr>
                    <tr><td width="130" style="height: 25px;">'.$this->l('Page ID').'</td><td><input type="text" name="page_id" value="'.$page_id.'" style="width: 150px;" /></td></tr>
                    <tr>
						<td width="130" style="height: 25px;">'.$this->l('Hash Type').'</td>
						<td>
							<select name="hash_type" style="width: 100px;">
								<option value="">-Select-</option>
								<option value="MD5" '.$md5.'>MD5</option>
								<option value="SHA512" '.$sha512.'>SHA512</option>
                                <option value="SHA1" '.$sha1.'>SHA1</option>
							</select>
						</td>
					</tr>
					<tr><td colspan="2" align="center"><br /><input class="button" name="submitEBS" value="'.$this->l('Update settings').'" type="submit" /></td></tr>
				</table>
			</fieldset>
		</form>
		';
	}
	
	public function hookPayment($params){
		global $smarty;
		$smarty->assign(array(
	        'this_path' 		=> $this->_path,
	        'this_path_ssl' 	=> Configuration::get('PS_FO_PROTOCOL').$_SERVER['HTTP_HOST'].__PS_BASE_URI__."modules/{$this->name}/"));
	
		return $this->display(__FILE__, 'payment.tpl');
    }
	
	public function execPayment($cart){
		global $smarty,$cart;      
        
		$bill_address = new Address(intval($cart->id_address_invoice));
		//$ship_address = new Address(intval($cart->id_address_delivery));
		$bc = new Country($bill_address->id_country);
		//$sc = new Country($ship_address->id_country);				
		$customer = new Customer(intval($cart->id_customer));
		
		$account_id= Configuration::get('ACCOUNT_ID');
		$secret_key = Configuration::get('SECRET_KEY');		
		$mode = Configuration::get('MODE');
        $page_id = Configuration::get('PAGE_ID');
		$id_currency = intval(Configuration::get('PS_CURRENCY_DEFAULT'));		
		//$currency = new Currency(intval($id_currency));
        $currency = 'INR';		
		
		$first_name = $bill_address->firstname;
		$last_name = $bill_address->lastname;
		$name = $first_name." ".$last_name;
		$address1 = $bill_address->address1;
		$address2 = $bill_address->address2;
		$address = $address1." ".$address2;		
		$city = $bill_address->city;		
		$country = $bc->iso_code;
		$state_obj = new State($bill_address->id_state);
		//$state = $state_obj->name;
		if($this->context->cookie->isPerks == 1)
			$phone = $bill_address->phone_mobile;
		else
			$phone = $bill_address->phone;
		$postal_code = $bill_address->postcode;
		$email = $customer->email;			
        $return_url = urldecode(Context::getContext()->link->getModuleLink('ebs', 'response'));
		
		//$ship_first_name = $ship_address->firstname;
		//$ship_last_name = $ship_address->lastname;
		//$ship_name = $ship_first_name." ".$ship_last_name;
		//$ship_address1 = $ship_address->address1;
		//$ship_address2 = $ship_address->address2;
		//$ship_addr = $ship_address1." ".$ship_address2;		
		//$ship_city = $ship_address->city;		
		//$ship_country = $sc->iso_code;
		//$ship_state_obj = new State($ship_address->id_state);
		//$ship_state = $state_obj->name;
		//$ship_phone = $ship_address->phone_mobile;
		//$ship_postal_code = $ship_address->postcode;
		
		
		if (!Validate::isLoadedObject($bill_address) OR !Validate::isLoadedObject($customer))
			return $this->l('EBS error: (invalid address or customer)');
		
		$amount = $cart->getOrderTotal(true,Cart::BOTH);
		$ref_no = intval($cart->id);

		$reference_no = intval($cart->id);
		$description = "Order ID is ".$reference_no;
        $channel = 0;

        $Code = array("AF" =>  "AFG", "AL" => "ALB", "DZ" => "DZA", "AS" => "ASM", "AD" => "AND", "AO" => "AGO", "AI" => "AIA", "AQ" => "ATA", "AG" => "ATG", "AR" => "ARG", "AM" => "ARM","AW" => "ABW", "AU" => "AUS", "AT" => "AUT", "AZ" => "AZE", "BS" => "BHS", "BH" => "BHR","BD" => "BGD", "BB" => "BRB", "BY" => "BLR", "BE" => "BEL", "BZ" => "BLZ", "BJ" => "BEN", "BM" => "BMU", "BT" => "BTN", "BO" => "BOL", "BA" => "BIH", "BW" => "BWA", "BV" => "BVT", "BR" => "BRA", "IO" => "IOT", "VG" => "VGB", "BN" => "BRN", "BG" => "BGR", "BF" => "BFA", "BI" => "BDI","KH" => "KHM", "CM" => "CMR", "CA" => "CAN", "CV" => "CPV", "KY" => "CYM", "CF" => "CAF", "TD" => "TCD", "CL" => "CHL", "CN" => "CHN", "CX" => "CXR", "CC" => "CCK", "CO" => "COL", "KM" => "COM", "CG" => "COG", "CK" => "COK", "CR" => "CRI", "CI" => "CIV", "HR" => "HRV", "CU" => "CUB", "CY" => "CYP", "CZ" => "CZE", "DK" => "DNK", "DM" => "DMA","DO" => "DOM", "TL" => "TLS", "EC" => "ECU", "EG" => "EGY", "SV" => "SLV", "GQ" => "GNQ","ER" => "ERI", "EE" => "EST", "ET" => "ETH", "FK" => "FLK","FO" => "FRO","FJ" => "FJI","FI" => "FIN","FR => FRA","FX" => "FXX","GF" => "GUF","PF" => "PYF","TF" => "ATF","GA" => "GAB","GE" => "GEO","GM" => "GMB","PS" => "PSE","DE" => "DEU","GH" => "GHA","GI" => "GIB","GR" => "GRC","GL" => "GRL","GD" => "GRD","GP" => "GLP","GU" => "GUM","GT" => "GTM","GN" => "GIN","GW" => "GNB","GY" => "GUY","HT" => "HTI","HM" => "HMD","HN" => "HND","HK" => "HKG","HU" => "HUN","IS" => "ISL","IN" => "IND","ID" => "IDN","IQ" => "IRQ","IE" => "IRL","IR" => "IRN","IL" => "ISR","IT" => "ITA","JM" => "JAM","JP" => "JPN","JO" => "JOR","KZ" => "KAZ","KE" => "KEN","KI" => "KIR","KP" => "PRK","KR" => "KOR","KW" => "KWT","KG" => "KGZ","LA" => "LAO","LV" => "LVA","LB" => "LBN","LS" => "LSO","LR" => "LBR","LY" => "LBY","LI" => "LIE","LT"=>"LTU","LU" => "LUX","MO" => "MAC","MK" => "MKD","MG" => "MDG","MW" => "MWI","MY" => "MYS","MV" => "MDV","ML" => "MLI","MT" => "MLT","MH" => "MHL","MQ" => "MTQ","MR" => "MRT","MU" => "MUS","YT" => "MYT","MX" => "MEX","FM" => "FSM","MD" => "MDA","MC" => "MCO","MN" => "MNG","MS" => "MSR","MA" => "MAR","MZ" => "MOZ","MM" => "MMR","NA" => "NAM","NR" => "NRU","NP" => "NPL","NL" => "NLD","NC" => "NCL","NZ" => "NZL","NI" => "NIC","NE" => "NER","NG" => "NGA","NU" => "NIU","NF" => "NFK","MP" => "MNP","NO" => "NOR","OM" => "OMN","PK" => "PAK","PW" => "PLW","PA" => "PAN","PG" => "PNG","PY" => "PRY","PE" => "PER","PH" => "PHL","PN" => "PCN","PL" => "POL","PT" => "PRT","PR" => "PRI","QA" => "QAT","RE" => "REU","RO" => "ROU","RU" => "RUS","RW" => "RWA","LC" => "LCA","WS" => "WSM","SM" => "SMR","ST" => "STP","SA" => "SAU","SN" => "SEN","SC" => "SYC","SL" => "SLE","SG" => "SGP","SK" => "SVK","SI" => "SVN","SB" => "SLB","SO" => "SOM","ZA" => "ZAF","ES" => "ESP","LK" => "LKA","SH" => "SHN","KN" => "KNA","PM" => "SPM","VC" => "VCT","SD" => "SDN","SR"=> "SUR","SJ" => "SJM","SZ" => "SWZ","SE" => "SWE","CH" => "CHE","SY" => "SYR","TW" => "TWN","TJ" => "TJK","TZ" => "TZA","TH" => "THA","TG" => "TGO","TK" => "TKL","TO" => "TON","TT" => "TTO","TN" => "TUN","TR" => "TUR","TM" => "TKM","TC" => "TCA","TV" => "TUV","UG" => "UGA","UA" => "UKR","AE" => "ARE","GB" => "GBR","US" => "USA","VI" => "VIR","UY" => "URY","UZ" => "UZB","VU" => "VUT","VA" => "VAT","VE" => "VEN","VN" => "VNM","WF" => "WLF","EH" => "ESH","YE" => "YEM","CS" => "SCG","ZR" => "ZAR","ZM" => "ZMB","ZW" => "ZWE","AP" => "   ","RS" => "SRB","AX" => "ALA" , "EU" => "" ,"ME" => "MNE","GG" => "GGY","JE" => "JEY","IM" => "IMN","CW" => "CUW","SX" => "SXM"); 

        $country = $Code[$country];
        //$ship_country = $Code[$ship_country];
        //$state = iconv("utf-8", "ascii//TRANSLIT", $state);
        // $ship_state = iconv("utf-8", "ascii//TRANSLIT", $ship_state);
    
        $ebs_args =  array(
                    'channel' => $channel,
					'account_id' => $account_id,
                    'page_id' => $page_id,
					'mode' => $mode,
                    'currency' => $currency,
					'reference_no' => $reference_no,
					'amount' => $amount,
			        'description' => $description,
			        'name'=>$name,
			        'address' => $address,
			        'city' => $city,
			        //'state'	=> $state,
			        'postal_code' => $postal_code,
			        'country' => $country,
			        'email' => $email,
			        'phone' => $phone,
			        //'ship_name'=>$ship_name,
			        //'ship_address' => $ship_addr,
			        //'ship_city' => $ship_city,
			        //'ship_state' => $ship_state,
			        //'ship_postal_code' => $ship_postal_code,
			        //'ship_country' => $ship_country,
			        //'ship_phone' => $ship_phone,	
					'return_url' => $return_url,
			);	
            
            $hashData = Configuration::get('SECRET_KEY');		
            $hashType = Configuration::get('HASH_TYPE');		
		ksort($ebs_args);		
		foreach ($ebs_args as $key => $value){
			if (strlen($value) > 0) {
				$hashData .= '|'.$value;
			}
		}

		if (strlen($hashData) > 0) {
                if($hashType == "MD5")
			        $hashValue = strtoupper(md5($hashData));
                if($hashType == "SHA512")
				    $hashValue = strtoupper(hash('SHA512',$hashData));	
			    if($hashType == "SHA1")
				    $hashValue = strtoupper(sha1($hashData));			
		    }	
                
          $smarty->assign(array(
                    'channel' => $channel,
                    'cancel_text' => 'Cancel',                    
					'account_id' => $account_id,
                    'page_id' => $page_id,
					'mode' => $mode,
                    'currency' => $currency,
					'reference_no' => $reference_no,
					'amount' => $amount,
			        'description' => $description,
			        'name'=>$name,
			        'address' => $address,
			        'city' => $city,
			        //'state'	=> $state,
			        'postal_code' => $postal_code,
			        'country' => $country,
			        'email' => $email,
			        'phone' => $phone,
			        //'ship_name'=>$ship_name,
			        //'ship_address' => $ship_addr,
			        //'ship_city' => $ship_city,
			        //'ship_state' => $ship_state,
			        //'ship_postal_code' => $ship_postal_code,
			        //'ship_country' => $ship_country,
			        //'ship_phone' => $ship_phone,	
					'return_url' => $return_url,
                    'products' => $cart->getProducts(),		
                    'secure_hash' => $hashValue,
                    //'total' => number_format(Tools::convertPrice($cart->getOrderTotal(true, 3), $currency), 2, '.', ''),
			        'ebsurl' => $this->getEBSUrl(),
                    
			));	
				
		return $this->display(__FILE__, 'payment_execution.tpl');
    }
}
?>

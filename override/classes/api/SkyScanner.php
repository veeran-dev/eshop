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

class SkyScanner extends FrontController
{
    /** @var string API key */
    public $_api_key = "ko679661579342688138023225892267";

    /** @var string country */
    public $_country = "IN";

    /** @var string currency */
    public $_currency = "INR";

    /** @var decimal price */
    public $_locale = "en-GB";

    /** @var string pricing URL */
    public $_pricing_url = "http://skyscanner.kobster.com/apiservices/pricing/v1.0/";

    /** @var string pricing type */
    public $_group_pricing = true;

    /** @var string session url */
    public $_session_url = "";

    /** @var string origin place */
    public $origin_place;

    /** @var string destination place */
    public $destination_place;

    /** @var string outbound date */
    public $outbound_date = "";

    /** @var string inbound date */
    public $inbound_date = "";

    /** @var string cabinclass */
    public $cabinclass;

    /** @var int adults*/
    public $adults;

    /** @var int children */
    public $children;

    /** @var int infants */
    public $infants;

    /** @var int infants */
    public $pagesize;

    /** @var int infants */
    public $pageindex;

    public function __construct()
    {
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36"
          )
        );

        $this->context = stream_context_create($opts);
    }

    public function createSession() 
    {
        $postData = array(
            'country' => urlencode($this->_country),
            'currency' => urlencode($this->_currency),
            'locale' => urlencode($this->_locale),
            'apiKey' => urlencode($this->_api_key),
            'originplace' => urlencode($this->origin_place),
            'destinationplace' => urlencode($this->destination_place),
            'outbounddate' => urlencode($this->outbound_date),
            'inbounddate' => urlencode($this->inbound_date),
            'cabinclass' => urlencode($this->cabinclass),
            'adults' => urlencode($this->adults),
            'children' => urlencode($this->children),
            'infants' => urlencode($this->infants),
            'groupPricing' => $this->_group_pricing
        );

        $httpdata = http_build_query($postData);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->_pricing_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $httpdata);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $headers = explode("\n", $response);
        foreach($headers as $header) {
            if (stripos($header, 'Location:') !== false) {
                $this->_session_url = str_replace("Location: ", "", $header);
            }
        }

        return $this->_session_url;
    } 

    public function pollSession($session_url) 
    {
        sleep(10);

        $postData = array(
            'apiKey' => urlencode($this->_api_key)
        );

        $httpdata = http_build_query($postData);

        $url = $session_url."?".$httpdata;

        $resultStatus = "UpdatesComplete";
                    
        do {
            $result = Tools::file_get_contents($url, false, $this->context);
            $resultObject = json_decode($result);
            $resultStatus = $resultObject->Status;
            if($resultStatus  == "UpdatesComplete") {
                break;
            }
        } while(0);
        
        return $result;
    }

    public function getLocationSuggestions($q) 
    {
        $url = "http://skyscanner.kobster.com/apiservices/autosuggest/v1.0/IN/INR/en-GB?includeAirports=true&includeCities=true&includeCountries=false&query=".$q."";
        return Tools::file_get_contents($url, false, $this->context);
    }  
}
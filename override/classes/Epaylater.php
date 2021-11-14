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

class Epaylater extends FrontController
{
    /** @var boolean customer worth */
    public $customerWorthy = false;

    /** @var boolean mobile verified */
    public $customerMobileVerified = false;

    /** @var boolean email verified */
    public $customerEmailVerified = false;

    /** @var boolean is customer logged in */
    public $customerLoggedin = false;

    /** @var string order amount */
    public $amount = "";

    /** @var string currency code */
    public $_currencyCode = "INR";

    /** @var string date ISO 8601 format */
    public $date = "";

    /** @var string category of transaction */
    public $category = "";

    /** @var array customer details */
    public $customer = array( "firstName" => "", "lastName" => "", "emailAddress" => "", "telephoneNumber" => "" );

    /** @var array device details */
    public $device = array( "deviceType" => "", "deviceClient" => "", "deviceNumber" => "", "deviceId" => "", "deviceMake" => "", "deviceModel" => "", "osVersion" => "" );

    /** @var array address */
    public $address = array( "line1" => "", "line2" => "", "line3" => "", "city" => "", "postcode" => "" );

    /** @var string payment method */
    public $paymentMethod = "";

    /** @var boolean returned*/
    public $returned = false;

    /** @var enum returning reason */
    public $returnReason = "";

    /** @var string kobster order ID */
    public $marketplaceOrderId = "";

    /** @var array merchant details */
    public $merchant = array( "marketplaceMerchantId" => 0, "name" => "Kobster Eshop Pvt Ltd");

    /** @var array market place customer id */
    public $marketplaceSpecificSection = array( "marketplaceCustomerId" => 0 );

     /** @var array shipping information */
    public $shippingInfo = array( "invoiceNumber" => 0, "AWBNumber" => 0, "amount" => 0, "shippingDate" => "", "deliveryDate" => "" );

     /** @var string epaylater id */
    public $id = "";

     /** @var string transaction status */
    public $status = "";

     /** @var boolean epaylater or not */
    public $paylater = false;

     /** @var epaylater transaction status date */
    public $statusDate = "";

    /** @var order history **/
    public $orderHistory = array( 
        "amount" => "", 
        "currencyCode" => "", 
        "date" => "", 
        "category" => "", 
        "paymentMethod" => "", 
        "returned" => "", 
        "returnReason" => "", 
        "address" => "", 
        "device" => ""
    );

    /** @var string URL **/
    protected $_url = "https://api-sandbox.epaylater.in";

    /** @var array HTTP Headers **/
    protected $httpHeaders = array(
      'postman-token: 51529181-8d46-007e-82b7-bbbfe7674e9d',
      'cache-control: no-cache',
      'content-type: application/json',
      'authorization: Bearer 63d82619-4ee6-48a4-b2df-9639283a499e'
    );

    public function __construct()
    {
        $getRequestHeader = array(
          'http'=>array(
            'method'=>"GET",
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36"
          )
        );

        $this->context = stream_context_create($opts);
    }

    public function uploadCustomerInfo() {
        $postData =  array( "customerEmailVerified" => $this->customerEmailVerified,
             "customerMobileVerified" => $this->customerMobileVerified,
             "customer" => $this->customer,
             "address" => $this->address,
             "marketplaceSpecificSection" => $this->marketplaceSpecificSection);

        $httpdata = Tools::jsonEncode($postData);

        // more details at http://php.net/curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->_url."/customerinfo");
        curl_setopt($ch, CURLOPT_PORT, 443);  
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHeaders);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $httpdata);

        // fetch response and close the socket
        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        return $body;
    }

    public function getCustomerEligibility() 
    {
        $postData =  array( "customerWorthy" => $this->customerWorthy,
             "amount" => $this->amount,
             "date" => $this->date,
             "category" => $this->category, // Send the category of the item in the order
             "device" => $this->device,
             "customer" => $this->customer,
             "address" => $this->address,
             "marketplaceSpecificSection" => $this->marketplaceSpecificSection);

        $httpdata = Tools::jsonEncode($postData);

        // more details at http://php.net/curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
        curl_setopt($ch, CURLOPT_URL, $this->_url."/transaction");
        curl_setopt($ch, CURLOPT_PORT, 443);  
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHeaders);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $httpdata);

        // fetch response and close the socket
        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        return $body;
    }

    public function sendOTP() {

        $postData =  array( 
             "id" => $this->id,
             "customerWorthy" => $this->customerWorthy,
             "customerLoggedin" => $this->customerLoggedin,
             "customerEmailVerified" => $this->customerEmailVerified,
             "amount" => $this->amount,
             "date" => $this->date,
             "customer" => $this->customer,
             "address" => $this->address,
             "paylater" => $this->paylater,
             "status" => $this->status,
             "statusDate" => $this->statusDate,
             "category" => $this->category);

        $httpdata = Tools::jsonEncode($postData);

        array_push($httpHeaders, 'X-HTTP-Method-Override: PUT');

        // more details at http://php.net/curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_URL, $this->_url."/transaction/".$this->id."/agreed?sendOtp=true");
        curl_setopt($ch, CURLOPT_PORT, 443);  
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHeaders);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $httpdata);

        // fetch response and close the socket
        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        return $body;
    }

    public function orderConfirm($otp) { 

        $postData =  array( 
             "id" => $this->id,
             "customerWorthy" => $this->customerWorthy,
             "customerLoggedin" => $this->customerLoggedin,
             "customerEmailVerified" => $this->customerEmailVerified,
             "amount" => $this->amount,
             "date" => $this->date,
             "customer" => $this->customer,
             "address" => $this->address,
             "paylater" => $this->paylater,
             "status" => $this->status,
             "statusDate" => $this->statusDate,
             "category" => $this->category);

        $httpdata = Tools::jsonEncode($postData);

        array_push($httpHeaders, 'X-HTTP-Method-Override: PUT');

        // more details at http://php.net/curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_URL, $this->_url."/transaction/".$this->id."/confirmed/".$this->marketplaceOrderId."?otp=".$otp);
        curl_setopt($ch, CURLOPT_PORT, 443);  
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHeaders);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $httpdata);

        // fetch response and close the socket
        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        return $body;
    } 

    public function getDeviceType() {
        $tablet_browser = 0;
        $mobile_browser = 0;
         
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }
         
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }
         
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }
         
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');
         
        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }
         
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
              $tablet_browser++;
            }
        }
         
        if ($tablet_browser > 0) {
           // do something for tablet devices
           return "TABLET";
        }
        else if ($mobile_browser > 0) {
           // do something for mobile devices
           return "MOBILE";
        }
        else {
           // do something for everything else
           return "DESKTOP";
        }  
    }
}
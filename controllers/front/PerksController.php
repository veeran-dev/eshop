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

class PerksControllerCore extends FrontController
{
    public $ssl = true;
    public $php_self = 'perks';
    public $auth = false;
    public $confirmation;
    
    public function init()
    {
        parent::init();

        if (!Tools::getIsset('step') && $this->context->customer->isLogged() && !$this->ajax) {
            Tools::redirect('index.php?controller='.(($this->authRedirection !== false) ? urlencode($this->authRedirection) : 'my-account'));
        }

        if (Tools::getValue('create_account')) {
            $this->create_account = true;
        }
    }

    /**
     * Set default medias for this controller
     * @see FrontController::setMedia()
     */
    public function setMedia()
    {
        parent::setMedia();
        if (!$this->useMobileTheme()) {
            $this->addCSS(_THEME_CSS_DIR_.'authentication.css');
        }
        $this->addJqueryPlugin('typewatch');
        $this->addJS(array(
            _THEME_JS_DIR_.'tools/vatManagement.js',
            _THEME_JS_DIR_.'tools/statesManagement.js',
            _THEME_JS_DIR_.'authentication.js',
            _PS_JS_DIR_.'validate.js'
        ));
    }

    /**
     * Run ajax process
     * @see FrontController::displayAjax()
     */
    public function displayAjax()
    {
        $this->display();
    }

    /**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();
        $confirmation = Tools::getValue('confirmation');
        $email_create = Tools::getValue('email_create');
        $customer_id = Tools::getValue('cus');
        $false_domain = Tools::getValue('fdmn');
        $error = Tools::getValue('error');

        $state = new State();
        $state_names = $state->getStatesByIdCountry($this->context->country->id);
        $countries = Country::getCountries($this->context->language->id);
        $resendPassword = 0;

        if(Tools::isSubmit('resendPassword'))
        {
            $this->processVerificationEmail(Tools::getValue('resendPassword'));
            $resendPassword = 1;
        }
        
        if($email_create)
        {
            $customer_id = base64_decode($customer_id);
            $customer_id = str_replace("kobsterSecretKey", "", $customer_id);
            $customer = new Customer($customer_id);
            $customer->active = 1;
            $customer->update();

            $company_details = PerksCompanies::getDomains($customer->email)[0];
            $hasAddress = $customer->getAddressesTotalById($customer->id);
            $this->sendConfirmationEmail($customer_id);
            if($company_details['address1'] && $hasAddress == 0)
            {
                $address = new Address();
                $address->id_customer = $customer->id;
                $address->address1 = $company_details['address1'];
                $address->firstname = $customer->firstname;
                $address->city = $company_details['city'];
                $address->id_state = $company_details['state'];
                $address->id_country = 110;
                $address->postcode = $company_details['postcode'];
                $address->phone_mobile = $customer->mobile;
                $address->active = 1;
                $address->save();
            }
            PerksCustomer::addToPerks($customer_id,$company_details['id_group']);
        }
        $this->context->smarty->assign('email_create', $email_create);
        $this->context->smarty->assign('resendPassword', $resendPassword);
        $this->context->smarty->assign('error', $error);
        $this->context->smarty->assign('cus_id', $customer_id);
        $this->context->smarty->assign('confirmation', $confirmation);
        $this->context->smarty->assign('false_domain', $false_domain);
        $this->context->smarty->assign('states',$state_names);
        $this->context->smarty->assign('countries',$countries);
        $this->setTemplate(_PS_THEME_DIR_.'perks.tpl');
    }

    public function ajaxReturn()
    {

        $firstname = Tools::getValue('firstname');
        $mobile = Tools::getValue('phone_mobile');
        $email = Tools::getValue('email');
        $password = Tools::getValue('passwd1');
        $newsletter = Tools::getValue('newsletter');
        $id_customer = Tools::getValue('id_customer');
        $message = Tools::getValue('message');
        $result = array();

        if(Tools::isSubmit('perks_feedback'))
        {
            $customer = new Customer($this->context->customer->id);
            $feedback = new Feedback();
            $feedback->name = $customer->firstname;
            $feedback->email = $customer->email;
            $feedback->message = $message;
            if($feedback->save())
            {
                Mail::Send(1, 'feedback', Mail::l('Feedback from Kobster Perks', 1), 
                                    array(
                                        '{name}' => $customer->firstname." ".$customer->lastname,
                                        '{email}' => $customer->email,
                                        '{message}' => $message
                                    ), 'feedback@kobster.com');
                $result['success'] = "Thank you, we have taken your feedback.";
                echo json_encode($result);
                return true;
            }
            else
            {
                $result['error'] = "Sorry, something went wrong.";
                echo json_encode($result);
                return false;
            }
        }
        if(Tools::getValue('forgotPassword'))
        {
            if (Tools::isSubmit('email')) {
                if (!($email = trim(Tools::getValue('email'))) || !Validate::isEmail($email)) {
                    echo 'Invalid email address.';
                    return false;
                } else {
                    $customer = new Customer();
                    $customer->getByemail($email);
                    $checkDomain = PerksCompanies::getDomains(Tools::getValue('email'));
                    if (!Validate::isLoadedObject($customer)) {
                        echo 'There is no account registered for this email address.';
                        return false;
                    }                    
                    elseif(empty($checkDomain))
                    {
                        echo 'Sorry your company is not configured, we will intimate you once it is done';
                        return false;
                    } 
                    elseif (!$customer->active) {
                        echo 'You cannot regenerate the password for this account.';
                        return false;
                    } else {
                        $mail_params = array(
                            '{email}' => $customer->email,
                            '{lastname}' => $customer->lastname,
                            '{firstname}' => $customer->firstname,
                            '{url}' => $this->context->link->getPageLink('password', true, null, 'token='.$customer->secure_key.'&id_customer='.(int)$customer->id)
                        );
                        if (Mail::Send($this->context->language->id, 'password_query', Mail::l('Password query confirmation'), $mail_params, $customer->email, $customer->firstname.' '.$customer->lastname)) {
                            $this->context->smarty->assign(array('confirmation' => 2, 'customer_email' => $customer->email));

                            echo 'An email has been sent to your account to retrieve your password';
                            return false;
                        } else {
                            echo 'An error occurred while sending the email.';
                            return false;
                        }
                    }
                }
            }
        }
        if(Tools::getValue('perksRegister'))
        {
            
            if (Validate::isEmail($email = Tools::getValue('email')) && !empty($email)) {
                if (Customer::customerExists($email)) {
                    $result['error'] = "An account using this email address has already been registered.";
                    echo Tools::jsonEncode($result);
                    return false;
                }
            }

            $customer = new Customer();
            // $google_captcha_response = Tools::getValue('g-recaptcha-response');
            // if(!$customer->verifyIsHuman($google_captcha_response)) {
            //     $result['error'] = 'Please verify that you are not a robot by clicking "I am not a robot".';
            //     echo Tools::jsonEncode($result);
            //     return false;
            // }

            $customer->email = $email;
            $customer->passwd = Tools::encrypt($password);
            $customer->firstname = $firstname;
            $customer->id_default_group = Configuration::get('perks_group');
            $customer->mobile = $mobile;
            $customer->id_buyer = 10;
            $customer->active = 0;
            if($newsletter == 1){
                $customer->newsletter = $newsletter;
                $customer->newsletter = true;
                $customer->ip_registration_newsletter = pSQL(Tools::getRemoteAddr());
                $customer->newsletter_date_add = pSQL(date('Y-m-d H:i:s'));
            }

            if($customer->add())
            {
                $checkDomain = PerksCompanies::getDomains($_POST['email']);
                if(empty($checkDomain))
                {
                    $this->intimateMarketingTeam($customer->id);

                    $result['error'] = 'Sorry your company is not configured, we will intimate you once it is done';
                    echo Tools::jsonEncode($result);
                    return false;
                }
                else if($this->processVerificationEmail($customer->id))
                {
                    $result['success'] = "We have sent you an confirmation email, kindly please verify your email-id.";
                    $result['id_customer'] = $customer->id;
                    echo Tools::jsonEncode($result);
                    return true;
                }
            }
            else
            {
                $result['error'] = "error in creating account.";
                echo Tools::jsonEncode($result);
                return false;
            }
        }
        if (Tools::isSubmit('SubmitLogin'))
        {
            $passwd = trim($_POST['passwd']);
            $email = trim($_POST['email']);
            $goToAfterLogin = $_POST['gotoPageAfterLogin'];

            if ($email != "")            
            {
                $customer = new Customer();
                $authentication = $customer->getByEmail(trim($email), trim($passwd));
                $buyer = $customer->getBuyerId(trim($email));
                
                if (!$authentication OR !$customer->id OR $buyer != 10 )
                {
                    echo "authentication failed";
                    return false;
                    //$login_error = 1;
                    //self::$smarty->assign(array('login_error' => 1, 'email' => $email));
                    //$this->errors[] = Tools::displayError('The Email or Password you entered is incorrect, please try again.');
                    
                }
                else
                {
                    $customer->is_logged = 1;
                    $customer->update();
                    $this->context->cookie->id_compare = isset($this->context->cookie->id_compare) ? $this->context->cookie->id_compare: CompareProduct::getIdCompareByIdCustomer($customer->id);
                    $this->context->cookie->id_customer = (int)($customer->id);
                    $this->context->cookie->customer_lastname = $customer->lastname;
                    $this->context->cookie->customer_firstname = $customer->firstname;
                    $this->context->cookie->id_buyer = $customer->id_buyer;
                    $this->context->cookie->logged = 1;
                    $this->context->cookie->is_guest = $customer->isGuest();
                    $this->context->cookie->passwd = $customer->passwd;
                    $this->context->cookie->email = $customer->email;
                    $this->context->cookie->role = $customer->getCustomerRole();
                    
                    $credit_days = new Group((int)($customer->id_default_group));
                    $this->context->cookie->credit_days = (int)$credit_days->credit_days;
                    $this->context->cookie->companyName = $credit_days->name[1];
                    
                    if (Configuration::get('PS_CART_FOLLOWING') AND (empty($this->context->cookie->id_cart) OR Cart::getNbProducts($this->context->cookie->id_cart) == 0))
                        $this->context->cookie->id_cart = (int)(Cart::lastNoneOrderedCart((int)($customer->id)));
                    /* Update cart address */
                    $this->context->cart->id_carrier = 0;
                    $this->context->cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
                    $this->context->cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
                    // If a logged guest logs in as a customer, the cart secure key was already set and needs to be updated
                    $this->context->cart->secure_key = $customer->secure_key;
                    $this->context->cart->update();
                    Module::hookExec('authentication');
                    
                    $logger = new FileLogger();
                    $logger->setFilename('log-files/'.$this->context->cookie->id_customer.'-'.$this->context->cookie->customer_firstname.'.txt');
                    $logger->logInfo("-------------------------------------------");
                    $logger->logInfo("");
                    $logger->logInfo("Customer Logged In. IP Address: ".$_SERVER['REMOTE_ADDR']);
                    //Tools::redirect('index.php?controller=perksDeals'.$goToAfterLogin);                    
                    echo "success";
                    return true;
                }
            }
        }
        if(Tools::isSubmit('resendPassword'))
        {
            $this->processVerificationEmail(Tools::getValue('resendPassword'));
        }

        
    }
    protected function sendConfirmationEmail($id_customer)
    {
        $link = new Link();        
        $customer = new Customer($id_customer);
        
        return Mail::Send($this->context->language->id,'perksWelcome',
                        Mail::l('Confirmation Email!'),
                        array(),
                        $customer->email,
                        $customer->firstname);
    }
    protected function processVerificationEmail($id_customer)
    {
        $link = new Link();        
        $customer = new Customer($id_customer);
        $customer_id = base64_encode('kobsterSecretKey'.$id_customer);

        return Mail::Send($this->context->language->id,'perksConfirmation',
                        Mail::l('Verify your email address!'),
                        array('{verificationUrl}' => $link->getPageLink('perks&email_create=1&cus='.$customer_id.'')),
                        $customer->email,
                        $customer->firstname);
    }


    protected function intimateMarketingTeam($id_customer)
    {
        $link = new Link();        
        $customer = new Customer($id_customer);
        
        return Mail::Send($this->context->language->id,'perksRequest',
                        Mail::l('New perks registration request!'),
                        array(
                            '{email}' => $customer->email,
                            '{mobile}' => $customer->mobile
                            ),
                        'marketing@kobster.com',
                        'Marketing Team');
    }

}

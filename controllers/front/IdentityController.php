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

class IdentityControllerCore extends FrontController
{
    public $auth = true;
    public $php_self = 'identity';
    public $authRedirection = 'identity';
    public $ssl = true;

    /** @var Customer */
    protected $customer;

    public function init()
    {
        parent::init();
        $this->customer = $this->context->customer;
    }

    /**
     * Start forms process
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        $origin_newsletter = (bool)$this->customer->newsletter;
        $logger = new FileLogger();
        $logger->setFilename("test.txt");
        $logger->logError("postProcess");

        if(Tools::isSubmit('submitIdentity')) {
            $email = trim(Tools::getValue('email'));

            if (Tools::getValue('months') != '' && Tools::getValue('days') != '' && Tools::getValue('years') != '') {
                $this->customer->birthday = (int)Tools::getValue('years').'-'.(int)Tools::getValue('months').'-'.(int)Tools::getValue('days');
            } elseif (Tools::getValue('months') == '' && Tools::getValue('days') == '' && Tools::getValue('years') == '') {
                $this->customer->birthday = null;
            } else {
                $this->errors[] = Tools::displayError('Invalid date of birth.');
            }

            if (Tools::getIsset('old_passwd')) {
                $old_passwd = trim(Tools::getValue('old_passwd'));
            }

            if (!Validate::isEmail($email)) {
                $this->errors[] = Tools::displayError('This email address is not valid');
            } elseif ($this->customer->email != $email && Customer::customerExists($email, true)) {
                $this->errors[] = Tools::displayError('An account using this email address has already been registered.');
            } elseif (!Tools::getIsset('old_passwd') || (Tools::encrypt($old_passwd) != $this->context->cookie->passwd)) {
                $this->errors[] = Tools::displayError('The password you entered is incorrect.');
            } elseif (Tools::getValue('passwd') != Tools::getValue('confirmation')) {
                $this->errors[] = Tools::displayError('The password and confirmation do not match.');
            } else {
                $prev_id_default_group = $this->customer->id_default_group;

                // Merge all errors of this file and of the Object Model
                $this->errors = array_merge($this->errors, $this->customer->validateController());
            }

            if (!count($this->errors)) {
                $this->customer->id_default_group = (int)$prev_id_default_group;
                $this->customer->firstname = Tools::ucwords($this->customer->firstname);

                if (Configuration::get('PS_B2B_ENABLE')) {
                    $this->customer->website = Tools::getValue('website'); // force update of website, even if box is empty, this allows user to remove the website
                    $this->customer->company = Tools::getValue('company');
                }

                if (!Tools::getIsset('newsletter')) {
                    $this->customer->newsletter = 0;
                } elseif (!$origin_newsletter && Tools::getIsset('newsletter')) {
                    if ($module_newsletter = Module::getInstanceByName('blocknewsletter')) {
                        /** @var Blocknewsletter $module_newsletter */
                        if ($module_newsletter->active) {
                            $module_newsletter->confirmSubscription($this->customer->email);
                        }
                    }
                }

                if (!Tools::getIsset('optin')) {
                    $this->customer->optin = 0;
                }
                if (Tools::getValue('passwd')) {
                    $this->context->cookie->passwd = $this->customer->passwd;
                }
                if ($this->customer->update()) {
                    $this->context->cookie->customer_lastname = $this->customer->lastname;
                    $this->context->cookie->customer_firstname = $this->customer->firstname;
                    $this->context->smarty->assign('confirmation', 1);
                } else {
                    $this->errors[] = Tools::displayError('The information cannot be updated.');
                }
            }
        }
        elseif (Tools::isSubmit('submitProof') && $this->context->cookie->voucherCode == '') {
            
            $logger->logError("submit proof");

            $file_tmp =$_FILES['upload-proof']['tmp_name'];
            $file_ext=strtolower(end(explode('.',$_FILES['upload-proof']['name'])));
            $file_name = $this->context->customer->id.".".$file_ext;
            $file_size = $_FILES['upload-proof']['size'];
            $expensions= array("jpeg","jpg","png","pdf");
            //var_dump($_FILES['upload-proof']['tmp_name']);
            //var_dump($file_ext);
            $logger->logError("128");
            if(in_array($file_ext,$expensions) === false){
                $this->errors[] = Tools::displayError('File format not supported');
                return false;
            }
            elseif (($file_size > 2097152)){      
                $logger->logError("134");
                $this->errors[] = Tools::displayError('File too large. File must be less than 2 megabytes.');

            }
            $logger->logError("137");
            $customer = new Customer($this->context->customer->id);
            $customer->id_proof = $file_name;

            $fileLocation = "./perks-identity/".$file_name;

            if($customer->update() && move_uploaded_file($file_tmp, $fileLocation))
            {

                $voucher_code = null;
                do
                    $voucher_code = 'PERKS'.rand(1000, 100000);
                while (CartRule::cartRuleExists($voucher_code));
                
                // Voucher creation and affectation to the customer
                $cart_rule = new CartRule();
                $cart_rule->code = $voucher_code;
                $cart_rule->id_customer = (int)$this->context->customer->id;
                $cart_rule->reduction_currency = 4;
                $cart_rule->reduction_amount = 100;
                $cart_rule->quantity = 1;
                $cart_rule->highlight = 1;
                $cart_rule->quantity_per_user = 1;
                $cart_rule->date_from = date('Y-m-d H:i:s');
                $cart_rule->date_to = date('Y-m-d H:i:s', strtotime($cart_rule->date_from.' +1 year'));
                $cart_rule->reduction_tax= 1;
                $cart_rule->minimum_amount = 0.00;
                $cart_rule->minimum_amount_currency = 4;
                $cart_rule->active = 1;

                $languages = Language::getLanguages(true);
                $default_text = "Perks Voucher";

                foreach ($languages as $language)
                {
                    $text = "Perks Voucher";
                    $cart_rule->name[(int)$language['id_lang']] = $text ? strval($text) : strval($default_text);
                }
                $cart_rule->add();
                $this->context->cookie->voucherCode = $cart_rule->id;
                $this->context->customer->id_proof = $file_name;
                $this->context->cookie->write();

                /***Voucher Mail***/
                Mail::Send($this->context->language->id,'voucher-for-deals',Mail::l('Kobster Perks voucher code'),array('{firstname}' => $customer->firstname,'{voucher_num}' => $cart_rule->code),$customer->email,$customer->firstname);

                $this->context->smarty->assign(array(
                    'success'     => 1,
                    'hasProof'    => true,
                    'voucher_num' => $cart_rule->code
                ));
                if(Tools::getValue('shoppingCart') == 1)
                    $this->setTemplate(_PS_THEME_DIR_.'shopping-cart.tpl');
                else
                    $_POST = array_map('stripslashes', $this->customer->getFields());
                    $this->setTemplate(_PS_THEME_DIR_.'identity.tpl');
            }
            else{
                //var_dump($customer);
                $_POST = array_map('stripslashes', $this->customer->getFields());
                $this->errors[] = Tools::displayError('unable to upload your proof');
            }            
        }
        elseif(Tools::isSubmit('submitProof') && $this->context->cookie->voucherCode != '')
        {
            $this->errors[] = Tools::displayError('Proof already uploaded');
            $_POST = array_map('stripslashes', $this->customer->getFields());
        }
         else {            
            $_POST = array_map('stripslashes', $this->customer->getFields());
        }

        return $this->customer;
    }
    /**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        if ($this->customer->birthday) {
            $birthday = explode('-', $this->customer->birthday);
        } else {
            $birthday = array('-', '-', '-');
        }

        /* Generate years, months and days */
        $this->context->smarty->assign(array(
                'years' => Tools::dateYears(),
                'sl_year' => $birthday[0],
                'months' => Tools::dateMonths(),
                'sl_month' => $birthday[1],
                'days' => Tools::dateDays(),
                'sl_day' => $birthday[2],
                'errors' => $this->errors,
                'genders' => Gender::getGenders(),
            ));

        // Call a hook to display more information
        $this->context->smarty->assign(array(
            'HOOK_CUSTOMER_IDENTITY_FORM' => Hook::exec('displayCustomerIdentityForm'),
        ));

        $newsletter = Configuration::get('PS_CUSTOMER_NWSL') || (Module::isInstalled('blocknewsletter') && Module::getInstanceByName('blocknewsletter')->active);
        $this->context->smarty->assign('newsletter', $newsletter);
        $this->context->smarty->assign('optin', (bool)Configuration::get('PS_CUSTOMER_OPTIN'));

        $this->context->smarty->assign('field_required', $this->context->customer->validateFieldsRequiredDatabase());

        $this->setTemplate(_PS_THEME_DIR_.'identity.tpl');
    }

    public function ajaxReturn()
    {

        $file_tmp =$_FILES['upload-proof']['tmp_name'];
        $file_ext=strtolower(end(explode('.',$_FILES['upload-proof']['name'])));
        $file_name = $this->context->customer->id.".".$file_ext;
        $file_size = $_FILES['upload-proof']['size'];
        $expensions= array("jpeg","jpg","png","pdf");

        if(in_array($file_ext,$expensions) === false){
            $result['errors'] = 'File format not supported';
            echo json_encode($result);
            return false;
        }
        elseif (($file_size > 2097152)){      
            $result['errors'] = 'File too large. File must be less than 2 megabytes.'; 
            echo json_encode($result);
        }
        $customer = new Customer($this->context->customer->id);
        $customer->id_proof = $file_name;

        $fileLocation = "./perks-identity/".$file_name;

        if($customer->update() && move_uploaded_file($file_tmp, $fileLocation))
        {

            $voucher_code = null;
            do
                $voucher_code = 'PERKS'.rand(1000, 100000);
            while (CartRule::cartRuleExists($voucher_code));
            
            // Voucher creation and affectation to the customer
            $cart_rule = new CartRule();
            $cart_rule->code = $voucher_code;
            $cart_rule->id_customer = (int)$this->context->customer->id;
            $cart_rule->reduction_currency = 4;
            $cart_rule->reduction_amount = 100;
            $cart_rule->quantity = 1;
            $cart_rule->highlight = 1;
            $cart_rule->quantity_per_user = 1;
            $cart_rule->date_from = date('Y-m-d H:i:s');
            $cart_rule->date_to = date('Y-m-d H:i:s', strtotime($cart_rule->date_from.' +1 year'));
            $cart_rule->reduction_tax=1;
            $cart_rule->minimum_amount = 0.00;
            $cart_rule->minimum_amount_currency = 4;
            $cart_rule->active = 1;

            $languages = Language::getLanguages(true);
            $default_text = "Perks Voucher";

            foreach ($languages as $language)
            {
                $text = "Perks Voucher";
                $cart_rule->name[(int)$language['id_lang']] = $text ? strval($text) : strval($default_text);
            }
            $cart_rule->add();
            $this->context->cookie->voucherCode = $cart_rule->id;
            $this->context->cookie->write();

            /***Voucher Mail***/
            Mail::Send($this->context->language->id,'voucher-for-deals',Mail::l('Kobster Perks voucher code'),array('{firstname}' => $customer->firstname,'{voucher_num}' => $cart_rule->code),$customer->email,$customer->firstname);

            $result['voucher_num'] = $cart_rule->code;
            echo json_encode($result);
            return true;
        }
        else
        {
            $result['errors'] = 'unable to update your profile';
            echo json_encode($result);
            return false;
        }

    }

    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS(_THEME_CSS_DIR_.'identity.css');
        $this->addJS(_PS_JS_DIR_.'validate.js');
    }
}

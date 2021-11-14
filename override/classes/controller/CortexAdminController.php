<?php
/**
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
 *  @author 	PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2015 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class CortexAdminControllerCore extends Controller
{
    /** @var string */
    public $path;

    /** @var string */
    public static $currentIndex;

    /** @var string */
    public $content;

    /** @var array */
    public $warnings = array();

    /** @var array */
    public $informations = array();

    /** @var array */
    public $confirmations = array();

    /** @var string|false */
    public $shopShareDatas = false;

    /** @var array */
    public $_languages = array();

    /** @var int */
    public $default_form_language;

    /** @var bool */
    public $allow_employee_form_lang;

    /** @var string */
    public $layout = 'layout.tpl';

    /** @var bool */
    public $bootstrap = false;

    /** @var string|array */
    protected $meta_title = array();

    /** @var string */
    public $template = 'content.tpl';

    /** @var string Associated table name */
    public $table = 'configuration';

    /** @var string */
    public $list_id;

    /** @var string|false Object identifier inside the associated table */
    protected $identifier = false;

    /** @var string */
    protected $identifier_name = 'name';

    /** @var string Associated object class name */
    public $className;

    /** @var array */
    public $tabAccess;

    /** @var int Tab id */
    public $id = -1;

    /** @var bool */
    public $required_database = false;

    /** @var string Security token */
    public $token;

    /** @var string "shop" or "group_shop" */
    public $shopLinkType;

    /** @var string Default ORDER BY clause when $_orderBy is not defined */
    protected $_defaultOrderBy = false;

    /** @var string */
    protected $_defaultOrderWay = 'ASC';

    /** @var array */
    public $tpl_form_vars = array();

    /** @var array */
    public $tpl_list_vars = array();

    /** @var array */
    public $tpl_delete_link_vars = array();

    /** @var array */
    public $tpl_option_vars = array();

    /** @var array */
    public $tpl_view_vars = array();

    /** @var array */
    public $tpl_required_fields_vars = array();

    /** @var string|null */
    public $base_tpl_view = null;

    /** @var string|null */
    public $base_tpl_form = null;

    /** @var bool If you want more fieldsets in the form */
    public $multiple_fieldsets = false;

    /** @var array|false */
    public $fields_value = false;

    /** @var array Errors displayed after post processing */
    public $errors = array();

    /** @var bool Define if the header of the list contains filter and sorting links or not */
    protected $list_simple_header;

    /** @var array List to be generated */
    protected $fields_list;

    /** @var array Modules list filters */
    protected $filter_modules_list = null;

    /** @var array Modules list filters */
    protected $modules_list = array();

    /** @var array Edit form to be generated */
    protected $fields_form;

    /** @var array Override of $fields_form */
    protected $fields_form_override;

    /** @var string Override form action */
    protected $submit_action;

    /** @var array List of option forms to be generated */
    protected $fields_options = array();

    /** @var string */
    protected $shopLink;

    /** @var string SQL query */
    protected $_listsql = '';

    /** @var array Cache for query results */
    protected $_list = array();

    /** @var string|array Toolbar title */
    protected $toolbar_title;

    /** @var array List of toolbar buttons */
    protected $toolbar_btn = null;

    /** @var bool Scrolling toolbar */
    protected $toolbar_scroll = true;

    /** @var bool Set to false to hide toolbar and page title */
    protected $show_toolbar = true;

    /** @var bool Set to true to show toolbar and page title for options */
    protected $show_toolbar_options = false;

    /** @var int Number of results in list */
    protected $_listTotal = 0;

    /** @var bool Automatically join language table if true */
    public $lang = false;

    /** @var array WHERE clause determined by filter fields */
    protected $_filter;

    /** @var string */
    protected $_filterHaving;

    /** @var array Temporary SQL table WHERE clause determined by filter fields */
    protected $_tmpTableFilter = '';

    /** @var array Number of results in list per page (used in select field) */
    protected $_pagination = array(20, 50, 100, 300, 1000);

    /** @var int Default number of results in list per page */
    protected $_default_pagination = 50;

    /** @var string ORDER BY clause determined by field/arrows in list header */
    protected $_orderBy;

    /** @var string Order way (ASC, DESC) determined by arrows in list header */
    protected $_orderWay;

    /** @var array List of available actions for each list row - default actions are view, edit, delete, duplicate */
    protected $actions_available = array('view', 'edit', 'duplicate', 'delete');

    /** @var array List of required actions for each list row */
    protected $actions = array();

    /** @var array List of row ids associated with a given action for witch this action have to not be available */
    protected $list_skip_actions = array();

    /* @var bool Don't show header & footer */
    protected $lite_display = false;

    /** @var bool List content lines are clickable if true */
    protected $list_no_link = false;

    /** @var bool */
    protected $allow_export = false;

    /** @var array Cache for translations */
    public static $cache_lang = array();

    /** @var array Required_fields to display in the Required Fields form */
    public $required_fields = array();

    /** @var HelperList */
    protected $helper;

    /**
     * Actions to execute on multiple selections.
     *
     * Usage:
     *
     * array(
     *      'actionName' => array(
     *      'text' => $this->l('Message displayed on the submit button (mandatory)'),
     *      'confirm' => $this->l('If set, this confirmation message will pop-up (optional)')),
     *      'anotherAction' => array(...)
     * );
     *
     * If your action is named 'actionName', you need to have a method named bulkactionName() that will be executed when the button is clicked.
     *
     * @var array
     */
    protected $bulk_actions;

    /* @var array Ids of the rows selected */
    protected $boxes;

    /** @var string Do not automatically select * anymore but select only what is necessary */
    protected $explicitSelect = false;

    /** @var string Add fields into data query to display list */
    protected $_select;

    /** @var string Join tables into data query to display list */
    protected $_join;

    /** @var string Add conditions into data query to display list */
    protected $_where;

    /** @var string Group rows into data query to display list */
    protected $_group;

    /** @var string Having rows into data query to display list */
    protected $_having;

    /** @var string Use SQL_CALC_FOUND_ROWS / FOUND_ROWS to count the number of records */
    protected $_use_found_rows = true;

    /** @var bool */
    protected $is_cms = false;

    /** @var string Identifier to use for changing positions in lists (can be omitted if positions cannot be changed) */
    protected $position_identifier;

    /** @var string|int */
    protected $position_group_identifier;

    /** @var bool Table records are not deleted but marked as deleted if set to true */
    protected $deleted = false;

    /**  @var bool Is a list filter set */
    protected $filter;

    /** @var bool */
    protected $noLink;

    /** @var bool|null */
    protected $specificConfirmDelete = null;

    /** @var bool */
    protected $colorOnBackground;

    /** @var bool If true, activates color on hover */
    protected $row_hover = true;

    /** @var string Action to perform : 'edit', 'view', 'add', ... */
    protected $action;

    /** @var string */
    protected $display;

    /** @var bool */
    protected $_includeContainer = true;

    /** @var array */
    protected $tab_modules_list = array('default_list' => array(), 'slider_list' => array());

    /** @var string */
    public $tpl_folder;

    /** @var string */
    protected $bo_theme;

    /** @var bool Redirect or not after a creation */
    protected $_redirect = true;

    /** @var array Name and directory where class image are located */
    public $fieldImageSettings = array();

    /** @var string Image type */
    public $imageType = 'jpg';

    /** @var ObjectModel Instantiation of the class associated with the AdminController */
    protected $object;

    /** @var int Current object ID */
    protected $id_object;

    /** @var string Current controller name without suffix */
    public $controller_name;

    /** @var int */
    public $multishop_context = -1;

    /** @var false */
    public $multishop_context_group = true;

    /** @var array Current breadcrumb position as an array of tab names */
    protected $breadcrumbs;

    /** @var bool Bootstrap variable */
    public $show_page_header_toolbar = false;

    /** @var string Bootstrap variable */
    public $page_header_toolbar_title;

    /** @var array|Traversable Bootstrap variable */
    public $page_header_toolbar_btn = array();

    /** @var bool Bootstrap variable */
    public $show_form_cancel_button;

    /** @var string */
    public $admin_webpath;

    /** @var array */
    protected $list_natives_modules = array();

    /** @var array */
    protected $list_partners_modules = array();

    /** @var array */
    public $modals = array();

    /** @var bool */
    protected $logged_on_addons = false;

    /** @var bool if logged employee has access to AdminImport */
    protected $can_import = false;

    /** @var bool if logged employee from internal portal **/
    public $logged_internal = false;

    public function __construct()
    {
        global $timer_start;
        $this->timer_start = $timer_start;
        // Has to be remove for the next Prestashop version
        global $token;

        $this->controller_type = 'admin';
        $this->controller_name = get_class($this);
        if (strpos($this->controller_name, 'Controller')) {
            $this->controller_name = substr($this->controller_name, 0, -10);
        }
        parent::__construct();

        $default_theme_name = 'default';

        // $this->context->smarty->setTemplateDir(array(
        //     _PS_BO_ALL_THEMES_DIR_.$this->bo_theme.DIRECTORY_SEPARATOR.'template',
        //     _PS_OVERRIDE_DIR_.'controllers'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'
        // ));

        $this->id = Tab::getIdFromClassName($this->controller_name);
        $this->token = Tools::getAdminToken($this->controller_name.(int)$this->id.(int)$this->context->employee->id);
        $token = $this->token;

        $this->_conf = array(
            1 => $this->l('Successful deletion'),
            2 => $this->l('The selection has been successfully deleted.'),
            3 => $this->l('Successful creation'),
            4 => $this->l('Successful update'),
            5 => $this->l('The status has been successfully updated.'),
            6 => $this->l('The settings have been successfully updated.'),
            7 => $this->l('The image was successfully deleted.'),
            8 => $this->l('The module was successfully downloaded.'),
            9 => $this->l('The thumbnails were successfully regenerated.'),
            10 => $this->l('The message was successfully sent to the customer.'),
            11 => $this->l('Comment successfully added'),
            12 => $this->l('Module(s) installed successfully.'),
            13 => $this->l('Module(s) uninstalled successfully.'),
            14 => $this->l('The translation was successfully copied.'),
            15 => $this->l('The translations have been successfully added.'),
            16 => $this->l('The module transplanted successfully to the hook.'),
            17 => $this->l('The module was successfully removed from the hook.'),
            18 => $this->l('Successful upload'),
            19 => $this->l('Duplication was completed successfully.'),
            20 => $this->l('The translation was added successfully, but the language has not been created.'),
            21 => $this->l('Module reset successfully.'),
            22 => $this->l('Module deleted successfully.'),
            23 => $this->l('Localization pack imported successfully.'),
            24 => $this->l('Localization pack imported successfully.'),
            25 => $this->l('The selected images have successfully been moved.'),
            26 => $this->l('Your cover image selection has been saved.'),
            27 => $this->l('The image\'s shop association has been modified.'),
            28 => $this->l('A zone has been assigned to the selection successfully.'),
            29 => $this->l('Successful upgrade'),
            30 => $this->l('A partial refund was successfully created.'),
            31 => $this->l('The discount was successfully generated.'),
            32 => $this->l('Successfully signed in to PrestaShop Addons')
        );

        $this->context->smarty->setTemplateDir(array(
            _PS_CORTEX_ADMIN_DIR_.'cortex'
        ));

        if (!$this->identifier) {
            $this->identifier = 'id_'.$this->table;
        }
        if (!$this->_defaultOrderBy) {
            $this->_defaultOrderBy = $this->identifier;
        }
        $this->tabAccess = Profile::getProfileAccess($this->context->employee->id_profile, $this->id);

        // Fix for homepage
        if ($this->controller_name == 'CortexDashboard') {
            $_POST['token'] = $this->token;
        }

        if (!Shop::isFeatureActive()) {
            $this->shopLinkType = '';
        }

        //$this->base_template_folder = _PS_BO_ALL_THEMES_DIR_.$this->bo_theme.'/template';
        $this->override_folder = Tools::toUnderscoreCase(substr($this->controller_name, 5)).'/';
        // Get the name of the folder containing the custom tpl files
        $this->tpl_folder = Tools::toUnderscoreCase(substr($this->controller_name, 5)).'/';

        $this->initShopContext();

        $this->context->currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));

        $this->admin_webpath = str_ireplace(_PS_CORE_DIR_, '', _PS_CORTEX_ADMIN_DIR_);
        $this->admin_webpath = preg_replace('/^'.preg_quote(DIRECTORY_SEPARATOR, '/').'/', '', $this->admin_webpath);

        // Check if logged on Addons
        $this->logged_on_addons = false;
        if (isset($this->context->cookie->username_addons) && isset($this->context->cookie->password_addons) && !empty($this->context->cookie->username_addons) && !empty($this->context->cookie->password_addons)) {
            $this->logged_on_addons = true;
        }

        // Set context mode
        if (defined('_PS_HOST_MODE_') && _PS_HOST_MODE_) {
            if (isset($this->context->cookie->is_contributor) && (int)$this->context->cookie->is_contributor === 1) {
                $this->context->mode = Context::MODE_HOST_CONTRIB;
            } else {
                $this->context->mode = Context::MODE_HOST;
            }
        } elseif (isset($this->context->cookie->is_contributor) && (int)$this->context->cookie->is_contributor === 1) {
            $this->context->mode = Context::MODE_STD_CONTRIB;
        } else {
            $this->context->mode = Context::MODE_STD;
        }

        //* Check if logged employee has access to AdminImport controller */
        $import_access = Profile::getProfileAccess($this->context->employee->id_profile, Tab::getIdFromClassName('AdminImport'));
        if (is_array($import_access) && isset($import_access['view']) && $import_access['view'] == 1) {
            $this->can_import = true;
        }

        $this->context->smarty->assign(array(
            'context_mode' => $this->context->mode,
            'logged_on_addons' => $this->logged_on_addons,
            'can_import' => $this->can_import,
        ));
    }

    /**
     * Check rights to view the current tab
     *
     * @param bool $disable
     * @return bool
     */
    public function viewAccess($disable = false)
    {
        if ($disable) {
            return true;
        }

        if ($this->tabAccess['view'] === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check for security token
     *
     * @return bool
     */
    public function checkToken()
    {
        $token = Tools::getValue('token');
        if (!empty($token) && $token === $this->token) {
            return true;
        }

        if (count($_POST) || !isset($_GET['controller']) || !Validate::isControllerName($_GET['controller']) || $token) {
            return false;
        }

        foreach ($_GET as $key => $value) {
            if (is_array($value) || !in_array($key, array('controller', 'controllerUri'))) {
                return false;
            }
        }

        $cookie = Context::getContext()->cookie;
        $whitelist = array('date_add', 'id_lang', 'id_employee', 'email', 'profile', 'passwd', 'remote_addr', 'shopContext', 'collapse_menu', 'checksum');
        foreach ($cookie->getAll() as $key => $value) {
            if (!in_array($key, $whitelist)) {
                unset($cookie->$key);
            }
        }

        $cookie->write();

        return true;
    }

    /**
     * @TODO uses redirectAdmin only if !$this->ajax
     * @return bool
     */
    public function postProcess()
    {
        try {
            if ($this->ajax) {
                // from ajax-tab.php
                $action = Tools::getValue('action');
                // no need to use displayConf() here
                if (!empty($action) && method_exists($this, 'ajaxProcess'.Tools::toCamelCase($action))) {
                    Hook::exec('actionAdmin'.ucfirst($this->action).'Before', array('controller' => $this));
                    Hook::exec('action'.get_class($this).ucfirst($this->action).'Before', array('controller' => $this));

                    $return = $this->{'ajaxProcess'.Tools::toCamelCase($action)}();

                    Hook::exec('actionAdmin'.ucfirst($this->action).'After', array('controller' => $this, 'return' => $return));
                    Hook::exec('action'.get_class($this).ucfirst($this->action).'After', array('controller' => $this, 'return' => $return));

                    return $return;
                } elseif (!empty($action) && $this->controller_name == 'AdminModules' && Tools::getIsset('configure')) {
                    $module_obj = Module::getInstanceByName(Tools::getValue('configure'));
                    if (Validate::isLoadedObject($module_obj) && method_exists($module_obj, 'ajaxProcess'.$action)) {
                        return $module_obj->{'ajaxProcess'.$action}();
                    }
                } elseif (method_exists($this, 'ajaxProcess')) {
                    return $this->ajaxProcess();
                }
            } else {
                // Process list filtering
                if ($this->filter && $this->action != 'reset_filters') {
                    $this->processFilter();
                }

                if (isset($_POST) && count($_POST) && (int)Tools::getValue('submitFilter'.$this->list_id) || Tools::isSubmit('submitReset'.$this->list_id)) {
                    $this->setRedirectAfter(self::$currentIndex.'&token='.$this->token.(Tools::isSubmit('submitFilter'.$this->list_id) ? '&submitFilter'.$this->list_id.'='.(int)Tools::getValue('submitFilter'.$this->list_id) : ''));
                }

                // If the method named after the action exists, call "before" hooks, then call action method, then call "after" hooks
                if (!empty($this->action) && method_exists($this, 'process'.ucfirst(Tools::toCamelCase($this->action)))) {
                    // Hook before action
                    Hook::exec('actionAdmin'.ucfirst($this->action).'Before', array('controller' => $this));
                    Hook::exec('action'.get_class($this).ucfirst($this->action).'Before', array('controller' => $this));
                    // Call process
                    $return = $this->{'process'.Tools::toCamelCase($this->action)}();
                    // Hook After Action
                    Hook::exec('actionAdmin'.ucfirst($this->action).'After', array('controller' => $this, 'return' => $return));
                    Hook::exec('action'.get_class($this).ucfirst($this->action).'After', array('controller' => $this, 'return' => $return));
                    return $return;
                }
            }
        } catch (PrestaShopException $e) {
            $this->errors[] = $e->getMessage();
        };
        return false;
    }

    /**
     * Load class object using identifier in $_GET (if possible)
     * otherwise return an empty object, or die
     *
     * @param bool $opt Return an empty object if load fail
     * @return ObjectModel|false
     */
    protected function loadObject($opt = false)
    {
        if (!isset($this->className) || empty($this->className)) {
            return true;
        }

        $id = (int)Tools::getValue($this->identifier);
        if ($id && Validate::isUnsignedId($id)) {
            if (!$this->object) {
                $this->object = new $this->className($id);
            }
            if (Validate::isLoadedObject($this->object)) {
                return $this->object;
            }
            // throw exception
            $this->errors[] = Tools::displayError('The object cannot be loaded (or found)');
            return false;
        } elseif ($opt) {
            if (!$this->object) {
                $this->object = new $this->className();
            }
            return $this->object;
        } else {
            $this->errors[] = Tools::displayError('The object cannot be loaded (the identifier is missing or invalid)');
            return false;
        }
    }

    /**
     * Check if the token is valid, else display a warning page
     *
     * @return bool
     */
    public function checkAccess()
    {

        // if (!$this->checkToken()) {
        //     // If this is an XSS attempt, then we should only display a simple, secure page
        //     // ${1} in the replacement string of the regexp is required,
        //     // because the token may begin with a number and mix up with it (e.g. $17)
        //     $url = preg_replace('/([&?]token=)[^&]*(&.*)?$/', '${1}'.$this->token.'$2', $_SERVER['REQUEST_URI']);

        //     if (false === strpos($url, '?token=') && false === strpos($url, '&token=')) {
        //         $url .= '&token='.$this->token;
        //     }
        //     if (strpos($url, '?') === false) {
        //         $url = str_replace('&token', '?controller=CortexDashboard&token', $url);
        //     }
        //     $this->context->smarty->assign('url', htmlentities($url));
        //     return false;
        // }
        return true;
    }

    /**
     * @return void
     */
    public function displayAjax()
    {
        if ($this->json) {
            $this->context->smarty->assign(array(
                'json' => true,
                'status' => $this->status,
            ));
        }
        $this->layout = 'layout-ajax.tpl';
        $this->display_header = false;
        $this->display_header_javascript = false;
        $this->display_footer = false;
        return $this->display();
    }

    protected function redirect()
    {
        Tools::redirectAdmin($this->redirect_after);
    }

    /**
     * @return void
     * @throws Exception
     * @throws SmartyException
     */
    public function display()
    {
        $this->context->smarty->assign(array(
            'display_header' => $this->display_header,
            'display_header_javascript'=> $this->display_header_javascript,
            'display_footer' => $this->display_footer,
            'js_def' => Media::getJsDef(),
        ));
    }

    /**
     * Assign smarty variables for the header
     */
    public function initHeader()
    {
        header('Cache-Control: no-store, no-cache');

        // Shop::initialize() in config.php may empty $this->context->shop->virtual_uri so using a new shop instance for getBaseUrl()
        $this->context->shop = new Shop((int)$this->context->shop->id);
        $this->context->smarty->assign(array(
            'token' => $this->token,
            'profile' => Context::getContext()->cookie->profile,
            'img_dir' => _PS_IMG_,
            'iso' => $this->context->language->iso_code,
            'class_name' => $this->className,
            'iso_user' => $this->context->language->iso_code,
            'country_iso_code' => $this->context->country->iso_code,
            'version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'full_language_code' => $this->context->language->language_code,
            'link' => $this->context->link,
            'shop_name' => Configuration::get('PS_SHOP_NAME'),
            'base_url' => $this->context->shop->getBaseURL(),
            'tab' => isset($tab) ? $tab : null, // Deprecated, this tab is declared in the foreach, so it's the last tab in the foreach
            'pic_dir' => _THEME_PROD_PIC_DIR_,
            'controller_name' => htmlentities(Tools::getValue('controller')),
            'currentIndex' => self::$currentIndex,
            'default_language' => (int)Configuration::get('PS_LANG_DEFAULT')
        ));
    }

    /**
     * Assign smarty variables for all default views, list and form, then call other init functions
     */
    public function initContent()
    {
        if (!$this->viewAccess()) {
            $this->errors[] = Tools::displayError('You do not have permission to view this.');
            return;
        }

        $cookie = Context::getContext()->cookie;

        $this->context->smarty->assign(array(
            'maintenance_mode' => !(bool)Configuration::get('PS_SHOP_ENABLE'),
            'content' => $this->content
        ));
    }

    /**
     * Assign smarty variables for the footer
     */
    public function initFooter()
    {
        // We assign js and css files on the last step before display template, because controller can add many js and css files
        $this->context->smarty->assign('css_files', $this->css_files);
        $this->context->smarty->assign('js_files', array_unique($this->js_files));

        $this->context->smarty->assign(array(
            'ps_version' => _PS_VERSION_,
            'timer_start' => $this->timer_start,
            'iso_is_fr' => strtoupper($this->context->language->iso_code) == 'FR'
        ));
    }

    /**
     * Initialize the invalid doom page of death
     *
     * @return void
     */
    public function initCursedPage()
    {
        $this->layout = 'invalid_token.tpl';
    }

    public function setMedia()
    {
        //Bootstrap
        //$this->addCSS('css path');

       // $this->addJS(array('array of js files'));
    }

    /**
     * Non-static method which uses AdminController::translate()
     *
     * @param string  $string Term or expression in english
     * @param string|null $class Name of the class
     * @param bool $addslashes If set to true, the return value will pass through addslashes(). Otherwise, stripslashes().
     * @param bool $htmlentities If set to true(default), the return value will pass through htmlentities($string, ENT_QUOTES, 'utf-8')
     * @return string The translation if available, or the english default text.
     */
    protected function l($string, $class = null, $addslashes = false, $htmlentities = true)
    {
        if ($class === null || $class == 'AdminTab') {
            $class = substr(get_class($this), 0, -10);
        } elseif (strtolower(substr($class, -10)) == 'controller') {
            /* classname has changed, from AdminXXX to AdminXXXController, so we remove 10 characters and we keep same keys */
            $class = substr($class, 0, -10);
        }
        return Translate::getAdminTranslation($string, $class, $addslashes, $htmlentities);
    }

    /**
     * Init context and dependencies, handles POST and GET
     */
    public function init()
    {
        // Has to be removed for the next Prestashop version
        global $currentIndex;

        parent::init();

        if (Tools::getValue('ajax')) {
            $this->ajax = '1';
        }

        /* Server Params */
        $protocol_link = (Tools::usingSecureMode() && Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
        $protocol_content = (Tools::usingSecureMode() && Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';

        $this->context->link = new Link($protocol_link, $protocol_content);

        if (isset($_GET['logout'])) {

            $this->context->employee->logout();
        }
        $logger = new FileLogger();
        $logger->setFilename('logout.txt');
        $logger->logError(Context::getContext()->cookie->last_activity);
        if (isset(Context::getContext()->cookie->last_activity) && !$this->logged_internal) {

            if ($this->context->cookie->last_activity + 15000 < time()) { // 20 seconds inactivity -> logout
                $logger->logError("LOGGED OUT because of last activity expired");
                $this->context->employee->logout();
            } else {
                $this->context->cookie->last_activity = time();
            }
        }

        if ($this->controller_name != 'CortexLogin' && (!isset($this->context->employee) || !$this->context->employee->isLoggedBack())) {
            if (isset($this->context->employee)) {
                $logger->logError("LOGGED OUT because of line 863 cortex admin controller");
                $this->context->employee->logout();
            }

            $email = false;
            if (Tools::getValue('email') && Validate::isEmail(Tools::getValue('email'))) {
                $email = Tools::getValue('email');
            }
            $logger->logError("LOGGED OUT at line 874 cortex Admin controller");
            Tools::redirectAdmin($this->context->link->getAdminLink('CortexLogin').((!isset($_GET['logout']) && $this->controller_name != 'CortexNotFound' && Tools::getValue('controller')) ? '&redirect='.$this->controller_name : '').($email ? '&email='.$email : ''));
        }

        // Set current index
        $current_index = 'index.php'.(($controller = Tools::getValue('controller')) ? '?controller='.$controller : '');
        if ($back = Tools::getValue('back')) {
            $current_index .= '&back='.urlencode($back);
        }
        self::$currentIndex = $current_index;
        $currentIndex = $current_index;

        $this->context->smarty->assign(array(
            // Usef5ul for layout.tpl
            'link'                => new Link(),
            'cookie'              => $this->context->cookie,
            'base_dir'            => _PS_BASE_URL_.__PS_BASE_URI__,
            'base_dir_ssl'        => $protocol_link.Tools::getShopDomainSsl().__PS_BASE_URI__,
            'force_ssl'           => Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE'),
            'content_dir'         => $protocol_content.Tools::getHttpHost().__PS_BASE_URI__,
            'base_uri'            => $protocol_content.Tools::getHttpHost().__PS_BASE_URI__.(!Configuration::get('PS_REWRITING_SETTINGS') ? 'index.php' : ''),
            'lang_id'             => (int)$this->context->language->id,
            'language_code'       => $this->context->language->language_code ? $this->context->language->language_code : $this->context->language->iso_code,
            'come_from'           => Tools::getHttpHost(true, true).Tools::htmlentitiesUTF8(str_replace(array('\'', '\\'), '', urldecode($_SERVER['REQUEST_URI']))),
            'currencies'          => Currency::getCurrencies(),
            'roundMode'           => (int)Configuration::get('PS_PRICE_ROUND_MODE'),
            'use_taxes'           => (int)Configuration::get('PS_TAX')
        ));

        Employee::setLastConnectionDate($this->context->employee->id);

        $this->initProcess();
    }

    /**
     * @throws PrestaShopException
     */
    public function initShopContext()
    {
        // Replace current default country
        $this->context->country = new Country((int)Configuration::get('PS_COUNTRY_DEFAULT'));
    }

    /**
     * Retrieve GET and POST value and translate them to actions
     */
    public function initProcess() { }

    /**
     * Copy data values from $_POST to object
     *
     * @param ObjectModel &$object Object
     * @param string $table Object table
     */
    protected function copyFromPost(&$object, $table)
    {
        /* Classical fields */
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, $object) && $key != 'id_'.$table) {
                /* Do not take care of password field if empty */
                if ($key == 'passwd' && Tools::getValue('id_'.$table) && empty($value)) {
                    continue;
                }
                /* Automatically encrypt password in MD5 */
                if ($key == 'passwd' && !empty($value)) {
                    $value = Tools::encrypt($value);
                }
                $object->{$key} = $value;
            }
        }

        /* Multilingual fields */
        $class_vars = get_class_vars(get_class($object));
        $fields = array();
        if (isset($class_vars['definition']['fields'])) {
            $fields = $class_vars['definition']['fields'];
        }

        foreach ($fields as $field => $params) {
            if (array_key_exists('lang', $params) && $params['lang']) {
                foreach (Language::getIDs(false) as $id_lang) {
                    if (Tools::isSubmit($field.'_'.(int)$id_lang)) {
                        $object->{$field}[(int)$id_lang] = Tools::getValue($field.'_'.(int)$id_lang);
                    }
                }
            }
        }
    }
}

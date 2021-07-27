<?php
/**
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once 'config_prod.php';

require_once dirname(__FILE__) . '/parameters.php';
require_once dirname(__FILE__) . '/classes/tsid.php';
require_once dirname(__FILE__) . '/classes/TSMember.php';
require_once dirname(__FILE__) . '/vendor/lib/totwebpack.php';

class TrustedShopsIntegration extends Module
{

    protected $variants = array();
    protected $errors = array();
    protected $locale = array();
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'trustedshopsintegration';
        $this->tab = 'front_office_features';
        $this->version = '2.1.5';
        $this->author = 'Trusted Shops GmbH';
        $this->need_instance = 0;
        $this->module_key = 'c76df2ef7f4bb33432eea49dd8d0e3b5';

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Trusted Shops Reviews Toolkit');
        $this->description = $this->l('This module integrates Trusted Shops into your Prestashop installation.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

        if (Configuration::get('PS_SSL_ENABLED') == 1) {
            $this->shopPath = _PS_BASE_URL_SSL_;
        } else {
            $this->shopPath = _PS_BASE_URL_;
        }
        // Error array
        $this->errors = array();

        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            require_once realpath(dirname(__FILE__) .'/smarty/plugins') . '/function.get_multilang_var.php';
            require_once realpath(dirname(__FILE__) .'/smarty/plugins') . '/function.input_color.php';
            require_once realpath(dirname(__FILE__) .'/smarty/plugins') . '/function.radio_slide.php';
            require_once realpath(dirname(__FILE__) .'/smarty/plugins') . '/modifier.prettyJSON.php';
            require_once realpath(dirname(__FILE__) .'/smarty/plugins') . '/modifier.totlreplace.php';
        }

        $this->productShoppingAttributes = array('gtin', 'mpn', 'brand');

        // Possible lang 2 country combinations
        $possibleLocaleValues = array(
            'de' => 'DE',
            'en' => 'GB',
            'gb' => 'GB',
            'fr' => 'FR',
            'nl' => 'NL',
            'es' => 'ES',
            'it' => 'IT',
            'pl' => 'PL',
        );
        // Get locale key for product sticker js
        $this->locale = $this->context->language->iso_code.'_'.$possibleLocaleValues[$this->context->language->iso_code];
    }

    /**
     * Saving related links to configuration and install database.
     */
    public function install()
    {
        if (version_compare(phpversion(), '5.5', '<')) {
            $multilang_vars = TSParameters::get();

            $this->context->smarty->assign('lang', $this->context->language->iso_code);
            if (false === isset($multilang_vars['php-version-min'][$this->context->language->iso_code])) {
                $multilang_vars['php-version-min'][$this->context->language->iso_code] = $multilang_vars['php-version-min']['en'];
            }
            $this->context->smarty->assign(array(
                'failed_link' => $multilang_vars['php-version-min'][$this->context->language->iso_code]
            ));

            $this->_errors[] = $this->display(__FILE__, 'views/templates/admin/install_failed.tpl');
            return false;
        }

        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        Configuration::updateValue('TRUSTEDSHOPS_IMAGE_ALLOCATION', ImageType::getFormatedName('large'));
        Configuration::updateValue('TRUSTEDSHOPS_GTIN_ALLOCATION', 'product_ean13');
        Configuration::updateValue('TRUSTEDSHOPS_BRAND_ALLOCATION', 'product_manufacturer_name');
        Configuration::updateValue('TRUSTEDSHOPS_MPN_ALLOCATION', 'product_upc');
        Configuration::updateValue('TRUSTEDSHOPS_MEMBER_FAILED', 1);

        include dirname(__FILE__).'/sql/install.php';
        $this->installTabs();

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('actionOrderStatusUpdate') &&
            $this->registerHook('displayLeftColumn') &&
            $this->registerHook('displayRightColumn') &&
            $this->registerHook('displayProductExtraContent') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('displayProductButtons') &&
            $this->registerHook('displayProductTabContent') &&
            $this->registerHook('displayOrderConfirmation') &&
            $this->registerHook('displayInvoice');
    }

    /**
     * Uninstalls the module
     * Delete config entries.
     */
    public function uninstall()
    {
        // Remove default trusted shops links and default product attribute allocations
        Configuration::deleteByName('TRUSTEDSHOPS_IMAGE_ALLOCATION');
        Configuration::deleteByName('TRUSTEDSHOPS_GTIN_ALLOCATION');
        Configuration::deleteByName('TRUSTEDSHOPS_BRAND_ALLOCATION');
        Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
        Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_CREATEDAT');
        Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_TRIAL');
        Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_UUID');
        Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_FAILED');
        Configuration::deleteByName('TRUSTEDSHOPS_CURRENT_ID_CONFIG');

        include dirname(__FILE__).'/sql/uninstall.php';
        if (isset($_SESSION['TRUSTEDSHOPS_SHOPS'])) {
            unset($_SESSION['TRUSTEDSHOPS_SHOPS']);
        }
        $this->uninstallTabs();

        return parent::uninstall() &&
            $this->unregisterHook('header') &&
            $this->unregisterHook('actionOrderStatusUpdate') &&
            $this->unregisterHook('displayLeftColumn') &&
            $this->unregisterHook('displayRightColumn') &&
            $this->unregisterHook('displayProductExtraContent') &&
            $this->unregisterHook('displayHeader') &&
            $this->unregisterHook('displayFooter') &&
            $this->unregisterHook('displayProductButtons') &&
            $this->unregisterHook('displayProductTabContent') &&
            $this->unregisterHook('displayOrderConfirmation') &&
            $this->unregisterHook('displayInvoice');
    }

    public function installTabs()
    {
        $trads = array(
            'main' => array(
                'en' => 'Trusted Shops Reviews Toolkit',
                'fr' => 'Avis clients Validés',
                'de' => 'Trusted Shops Reviews Toolkit',
                'pl' => 'Moduł Trusted Shops',
                'it' => 'Recensioni Trusted Shops'
            ),
            'home' => array(
                'en' => 'Home',
                'fr' => 'Accueil',
                'de' => 'Start',
                'pl' => 'Strona główna',
                'it' => 'Pagina inziale'
            ),
            'signin' => array(
                'en' => 'Sign in',
                'fr' => 'Se connecter',
                'de' => 'Anmelden',
                'pl' => 'Zaloguj się',
                'it' => 'Accedi'
            ),
            'invites' => array(
                'en' => 'Invites',
                'fr' => 'Demandes d\'évaluation',
                'de' => 'Bewertungsanfragen',
                'pl' => 'Prośby o opinię',
                'it' => 'Richieste di recensioni'
            ),
            'site' => array(
                'en' => 'Service reviews',
                'fr' => 'Avis Site',
                'de' => 'Shopbewertungen',
                'pl' => 'Opinie o sklepie',
                'it' => 'Recensioni sul negozio'
            ),
            'products' => array(
                'en' => 'Product reviews',
                'fr' => 'Avis Produits',
                'de' => 'Produktbewertungen',
                'pl' => 'Opinie o produktach',
                'it' => 'Recensioni di prodotto'
            ),
            'configuration' => array(
                'en' => 'Trusted Shops ID configuration',
                'fr' => 'Identifiants Trusted Shops',
                'de' => 'Konfigurieren Sie Ihre Trusted Shops-IDs',
                'pl' => 'Konfiguracja Trusted Shops ID',
                'it' => 'Configura i tuoi ID Trusted Shops'
            )
        );

        // tab Home TS
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'trustedshopsintegration';
        foreach (Language::getLanguages(true) as $lang) {
            if (array_key_exists($lang['iso_code'], $trads['main'])) {
                $tab->name[$lang['id_lang']] = $trads['main'][$lang['iso_code']];
            } else {
                $tab->name[$lang['id_lang']] = 'Trusted Shops Reviews Toolkit';
            }
        }

        $tab->id_parent = Tab::getIdFromClassName('AdminParentModulesSf');
        $tab->module = $this->name;
        $tab->add();

        $idTabHome = Tab::getIdFromClassName('trustedshopsintegration');
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminTrustedshopsintegrationHome';
        foreach (Language::getLanguages(true) as $lang) {
            if (array_key_exists($lang['iso_code'], $trads['home'])) {
                $tab->name[$lang['id_lang']] = $trads['home'][$lang['iso_code']];
            } else {
                $tab->name[$lang['id_lang']] = 'Home';
            }
        }
        $tab->id_parent = $idTabHome;
        $tab->module = $this->name;
        $tab->position = 1;
        $tab->add();

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminTrustedshopsintegrationInvites';
        foreach (Language::getLanguages(true) as $lang) {
            if (array_key_exists($lang['iso_code'], $trads['invites'])) {
                $tab->name[$lang['id_lang']] = $trads['invites'][$lang['iso_code']];
            } else {
                $tab->name[$lang['id_lang']] = 'Invites';
            }
        }
        $tab->id_parent = $idTabHome;
        $tab->module = $this->name;
        $tab->position = 2;
        $tab->add();

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminTrustedshopsintegrationSite';
        foreach (Language::getLanguages(true) as $lang) {
            if (array_key_exists($lang['iso_code'], $trads['site'])) {
                $tab->name[$lang['id_lang']] = $trads['site'][$lang['iso_code']];
            } else {
                $tab->name[$lang['id_lang']] = 'Service reviews';
            }
        }
        $tab->id_parent = $idTabHome;
        $tab->module = $this->name;
        $tab->position = 3;
        $tab->add();

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminTrustedshopsintegrationProducts';
        foreach (Language::getLanguages(true) as $lang) {
            if (array_key_exists($lang['iso_code'], $trads['products'])) {
                $tab->name[$lang['id_lang']] = $trads['products'][$lang['iso_code']];
            } else {
                $tab->name[$lang['id_lang']] = 'Products reviews';
            }
        }
        $tab->id_parent = $idTabHome;
        $tab->module = $this->name;
        $tab->position = 4;
        $tab->add();

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminTrustedshopsintegrationConfiguration';
        foreach (Language::getLanguages(true) as $lang) {
            if (array_key_exists($lang['iso_code'], $trads['configuration'])) {
                $tab->name[$lang['id_lang']] = $trads['configuration'][$lang['iso_code']];
            } else {
                $tab->name[$lang['id_lang']] = 'Trusted Shops ID configuration';
            }
        }
        $tab->id_parent = $idTabHome;
        $tab->position = 5;
        $tab->module = $this->name;
        $tab->add();

        // tab login - invisible tab
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminTrustedshopsintegrationAccount';
        foreach (Language::getLanguages(true) as $lang) {
            if (array_key_exists($lang['iso_code'], $trads['signin'])) {
                $tab->name[$lang['id_lang']] = $trads['signin'][$lang['iso_code']];
            } else {
                $tab->name[$lang['id_lang']] = 'Sign in';
            }
        }
        $tab->id_parent = -1;
        $tab->module = $this->name;
        $tab->add();
    }

    /**
     * Fix a bug on breadcrumb in PS 1.6
     * @return true
     */
    public function viewAccess()
    {
        $homeURL = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');
        Tools::redirectAdmin($homeURL);
        return true;
    }

    /**
     * Uninstall Tab
     */
    public function uninstallTabs()
    {
        $tabNames = array(
                    'trustedshopsintegration', 'AdminTrustedshopsintegrationHome',
                    'AdminTrustedshopsintegrationInvites', 'AdminTrustedshopsintegrationSite',
                    'AdminTrustedshopsintegrationProducts', 'AdminTrustedshopsintegrationConfiguration',
                    'AdminTrustedshopsintegrationAccount');

        foreach ($tabNames as $tabName) {
            $idTab = Tab::getIdFromClassName($tabName);
            if ($idTab != 0) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }
    }

     /**
      * Loads the configuration form.
      * @return string Module Layout
      */
    public function getContent()
    {

        require_once dirname(__FILE__) . '/classes/TSMember.php';
        $accountUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        if (TSMember::hasAccess() == false) {
            Tools::redirectAdmin($accountUrl);
        }

        $homeURL = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');
        Tools::redirectAdmin($homeURL);
    }

    /**
     * Hooks the header content
     * @param mixed[] $param Site Information
     * @return null
     */
    public function hookHeader($param)
    {
        $cssRequired = array(
            'product'
        );
        if (isset($this->context->controller->php_self)
            && in_array($this->context->controller->php_self, $cssRequired)) {
            $this->context->controller->addCSS($this->_path . 'views/css/front.css', 'all');
        }

        if ((version_compare(_PS_VERSION_, '1.7.0', '>=') === true)) {
            $js_def = array(
                'controller' => $this->context->controller->php_self
            );

            Media::addJsDef($js_def);

            if (Configuration::get('PS_SSL_ENABLED')) {
                $url = 'https://';
            } else {
                $url = 'http://';
            }
            $url .= $this->context->shop->domain_ssl.$this->context->shop->physical_uri;

            $pos = array('server' => 'remote', 'position' => 'bottom', 'priority' => 0);
            $this->context->controller->registerJavascript(
                'product-bottom',
                $url.'modules/'.$this->name.'/views/js/product_bottom.js',
                $pos
            );
            $this->context->controller->registerJavascript(
                'remote-bootstrap',
                'https://widgets.trustedshops.com/reviews/tsSticker/tsProductStickerSummary.js',
                $pos
            );
        } else {
            $this->context->controller->addJS($this->_path . 'views/js/product_bottom.js');
        }
    }

    public function hookdisplayHeader($params, $back_office = false)
    {
        $tsconfig = $this->getTSConfig();
        $pages = array();
        if ($tsconfig['enable_rich_snippets'] == 1) {
            if ($tsconfig['enable_rich_snippets_listing'] == 1) {
                array_push($pages, 'category', 'search');
            }
            if ($tsconfig['enable_rich_snippets_product'] == 1) {
                array_push($pages, 'product');
            }
            if ($tsconfig['enable_rich_snippets_homepage'] == 1) {
                array_push($pages, 'index');
            }
        }

        $this->hookHeader($params);

        if (isset($this->context->controller->php_self)
            && in_array($this->context->controller->php_self, $pages)
            || (empty($pages) && $tsconfig['enable_rich_snippets'] == 1)) {
            require_once dirname(__FILE__) . '/classes/TSSnippets.php';
            $TSSnippets = new TSSnippets();
            return $TSSnippets->getSnippets($tsconfig['id_trusted_shops']);
        }
    }

    /**
     * @todo description
     */
    public function hookActionOrderStatusUpdate($param)
    {
        if (Configuration::get('TRUSTEDSHOPS_MEMBER_CREDENTIALS') == null) {
            return true;
        }

        $uuid = Configuration::get('TRUSTEDSHOPS_MEMBER_UUID');
        $order = new Order($param['id_order']);
        $id_shop = $order->id_shop;
        $id_lang = $order->id_lang;
        $trigger_infos = TSID::getTriggerInfos($uuid, $id_shop, $id_lang);

        if ($trigger_infos['trigger_reviews_active'] == '0') {
            return true;
        }

        TrustedShopsIntegration::log('==hookActionOrderStatusUpdate==');
        TrustedShopsIntegration::log('OrderID:' . $param['id_order']);
        TrustedShopsIntegration::log('TS CONFIG FOR :' . print_r($trigger_infos, true));
        if ($trigger_infos == false) {
            TrustedShopsIntegration::log('No invitation send : TS config empty');
            return true;
        }
        $trigger_reviews_step = $trigger_infos['trigger_reviews_step'];
        $trigger_reviews_carriers = json_decode($trigger_infos['trigger_reviews_carriers'], true);

        if ($trigger_reviews_step != $param['newOrderStatus']->id) {
            TrustedShopsIntegration::log('No invitation send : trigger_reviews_step != new order status');
            return true;
        }

        if ($trigger_infos['trigger_reviews_active'] === 1) {
            TrustedShopsIntegration::log('No invitation send : trigger_reviews_active disabled');
            return true;
        }
        $protocol_link = (Configuration::get('PS_SSL_ENABLED') || Tools::usingSecureMode()) ? 'https://' : 'http://';

        if ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED'))
            || Tools::usingSecureMode()) {
            $useSSL = true;
        } else {
            $useSSL = false;
        }

        $protocol_content = ($useSSL) ? 'https://' : 'http://';
        $link = new Link($protocol_link, $protocol_content);

        $orderDate = explode(' ', $order->date_add);
        /* $deliveryDate = explode(' ', $order->delivery_date);
        if ($deliveryDate[0] == '0000-00-00') {
            $reminderDate = date("Y-m-d");
        } */

        $orderCarrier = $order->id_carrier;
        if (!isset($trigger_reviews_carriers[$orderCarrier])) {
            $carrier_delay = 3;
        } else {
            $carrier_delay = $trigger_reviews_carriers[$orderCarrier];
        }

        //$reminderDate = new DateTime($reminderDate);
        $reminderDate = new DateTime();
        $reminderDate->modify('+'.$carrier_delay.' day');
        $reminderDate = $reminderDate->format('Y-m-d');
        $datas = array();
        $datas[0]['reminderDate'] = $reminderDate;
        $datas[0]['template']['variant'] = 'DEFAULT_TEMPLATE';
        $datas[0]['order']['orderReference'] = $order->reference;
        $datas[0]['order']['amount'] = $order->total_paid;
        $datas[0]['order']['currency'] = $this->getOrderCurrency($order->id_currency);
        $datas[0]['order']['paymentType'] = $order->module;
        $datas[0]['order']['orderDate'] = $orderDate[0];
        $datas[0]['order']['estimatedDeliveryDate'] = $reminderDate;

        if ($trigger_infos['collect_reviews'] == true) {
            $tsconfig = $this->getTSConfig();
            $orderProducts = $order->getProducts();
            $cmpt = 0;
            foreach ($orderProducts as $product) {
                $productObj = new Product($product['product_id'], false, $id_lang);
                $imagePath = $link->getImageLink($productObj->link_rewrite, $product['image']->id_image);
                $datas[0]['order']['products'][$cmpt]['name'] = $product['product_name'];
                $datas[0]['order']['products'][$cmpt]['imageUrl'] = $imagePath;
                if ($product['reference'] != false) {
                    $datas[0]['order']['products'][$cmpt]['sku'] = $product['reference'];
                } else {
                    $datas[0]['order']['products'][$cmpt]['sku'] = $product['id'] ? $product['id'] : $product['product_id'];
                }
                $datas[0]['order']['products'][$cmpt]['gtin'] = $product['product_ean13'];
                $datas[0]['order']['products'][$cmpt]['mpn'] = $this->getProductShoppingAttribute(
                    'mpn',
                    $product,
                    $tsconfig
                );
                $datas[0]['order']['products'][$cmpt]['brand'] = Manufacturer::getNameById($product['id_manufacturer']);
                $datas[0]['order']['products'][$cmpt]['url'] = $link->getProductLink((int)$product['product_id']);
                $cmpt++;
            }
        }
        $customer = new Customer($order->id_customer);
        $datas[0]['consumer']['contact']['email'] = $customer->email;
        $datas[0]['consumer']['contact']['firstName'] = $customer->firstname;
        $datas[0]['consumer']['contact']['lastName'] = $customer->lastname;

        $data = array();
        $data['reviewCollectorRequest']['reviewCollectorReviewRequests'] = $datas;
        $tsconfig = new TSID($trigger_infos['id_ts_config']);
        $client = new TSApiClient();
        $webservice = $client->getWrapper('trigger')
                                    ->setCredentials(Configuration::get('TRUSTEDSHOPS_MEMBER_CREDENTIALS'))
                                    ->setTsId($tsconfig->id_trusted_shops)
                                    ->setInput($data);
        $client->call($webservice);
        TrustedShopsIntegration::log('Data sent to the API :' . print_r($data, true));
        TrustedShopsIntegration::log('RESPONSE of the API :' . print_r($client->getResponse()->getContent(), true));

        $errors = $client->getResponse()->getErrors();
        if (count($errors) == 0) {
            return true;
        }
        TrustedShopsIntegration::log('ERROR of the API :' . print_r($errors, true));
        foreach ($errors as $error) {
            if ($error != 'Authentication failed') {
                continue;
            }
            Configuration::updateValue('TRUSTEDSHOPS_MEMBER_FAILED', 1);
            Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
        }
    }


    /**
     * @desc   show a message if authentication failed
     * @return html content
     */
    public function hookDisplayInvoice()
    {
        if (Configuration::get('TRUSTEDSHOPS_MEMBER_FAILED') != 1) {
            return;
        }

        $adminTsUrl = array();
        $adminTsUrl['account'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        $this->context->smarty->assign('adminTsUrl', $adminTsUrl);

        return $this->display(__FILE__, 'views/templates/admin/order_error.tpl');
    }

    /**
     *  @desc  Get Currency of orders
     */
    protected function getOrderCurrency($id_currency)
    {
        $sql = "SELECT iso_code FROM "._DB_PREFIX_."currency
                WHERE id_currency=". (int) $id_currency;

        return Db::getInstance()->getValue($sql);
    }

    protected function getRealJSON($json)
    {
        return str_replace("'", '"', $json);
    }

    /**
     * Returns the trustedshops config as associative array.
     * @param boolean $be Get Ts COnfig for backend or frontend?
     */
    protected function getTSConfig($be = false)
    {
        if ($be === false) {
            $query = new DbQuery();
            $query->select('*');
            $query->from($this->name);
            $where = 'id_shop = '.(int)$this->context->shop->id.' AND id_lang = '.(int)$this->context->language->id;
        } else {
            $id_ts_config = pSQL(Tools::getValue('id_ts_config'));

            $query = new DbQuery();
            $query->select('*');
            $query->from($this->name);
            $where = 'id_ts_config = "'.pSQL($id_ts_config).'"';
        }
        if (Configuration::get('TRUSTEDSHOPS_MEMBER_UUID')) {
            $where .= ' AND uuid = "'.pSQL(Configuration::get('TRUSTEDSHOPS_MEMBER_UUID')).'"';
        }

        $query->where($where);
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query->build());
        return $result;
    }

    /**
     * Hooks the footer content and adds the trustbadge js code.
     * @return string Trustbadge JS Template
     */
    public function hookDisplayFooter()
    {
        $tsconf = $this->getTSConfig();
        if (!empty($tsconf)) {
            $this->smarty->assign($tsconf);
            if ($tsconf['display_trustbadge'] != true) {
                $this->smarty->assign('variant', 'hide');
            }
            if ($tsconf['trustbadge_advanced_configuration'] == 1) {
                // Expert mode
                $trustbadge_config = Tools::jsonDecode($this->getRealJSON($tsconf['trustbadge_code']), true);
                $this->smarty->assign('trustbadge_config', $trustbadge_config);
                return $this->display(__FILE__, 'views/templates/hook/trustbadge_js_expert.tpl');
            } else {
                // Standard mode
                return $this->display(__FILE__, 'views/templates/hook/trustbadge_js.tpl');
            }
        }
    }

    /**
     * Hooks the product buttons content and display product star rating.
     *
     * @param $params array page information
     */
    public function hookDisplayProductButtons($params)
    {
        if (is_array($params['product'])) {
            $product_sku = $params['product']['reference'];
        } elseif (is_object($params['product'])) {
            $product_sku = $params['product']->reference;
        }
        $tsconf = $this->getTSConfig();
        // Show Rating or the expert mode must be enabled
        if (!empty($tsconf) &&
            $tsconf['show_rating'] == 1 &&
            $tsconf['collect_reviews'] == 1) {
            // General assignments
            $this->smarty->assign($tsconf);
            $this->smarty->assign('ts_product_sku', $product_sku);
            $this->smarty->assign('action', Tools::getValue('action'));

            if ($tsconf['rating_stars_advanced_configuration'] == 1) {
                // Expert mode
                $this->smarty->assign(array(
                    'product_widget_config' => Tools::jsonDecode($this->getRealJSON($tsconf['product_widget_code']))
                ));
                return $this->display(__FILE__, 'views/templates/hook/product_widget_js_expert.tpl');
            } else {
                // standard mode
                return $this->display(__FILE__, 'views/templates/hook/product_widget_js.tpl');
            }
        }
    }

    /**
     * Hooks column trustbadge js code.
     * @return string Trustbadge JS Template
     */
    public function hookDisplayLeftColumn()
    {
        return $this->hookDisplayColumn();
    }

    /**
     * Hooks column trustbadge js code.
     * @return string Trustbadge JS Template
     */
    public function hookDisplayRightColumn()
    {
        return $this->hookDisplayColumn();
    }

    /**
     * Hooks column trustbadge js code.
     * @return string Trustbadge JS Template
     */
    public function hookDisplayColumn()
    {
        $tsconf = $this->getTSConfig();
        if (empty($tsconf) || $tsconf['display_shop_reviews'] == false) {
            return;
        }

        $this->smarty->assign($tsconf);
        if ($tsconf['review_advanced_configuration'] == 1) {
            // Expert mode
            $site_review_configuration_code = Tools::jsonDecode(
                $this->getRealJSON($tsconf['site_review_configuration_code']),
                true
            );
            $this->smarty->assign('site_review_configuration_code', $site_review_configuration_code);
            return $this->display(__FILE__, 'views/templates/hook/review_sticker_js_expert.tpl');
        } else {
            // Standard mode
            return $this->display(__FILE__, 'views/templates/hook/review_sticker_js.tpl');
        }
    }

    /**
     * Hooks the footer content and adds the trustbadge js code.
     * @return string Trustbadge JS Template
     */
    public function hookDisplayProductExtraContent($params)
    {
        if (is_array($params['product'])) {
            $product_sku = $params['product']['reference'];
        } elseif (is_object($params['product'])) {
            $product_sku = $params['product']->reference;
        }
        $tsconf = $this->getTSConfig();
        if (empty($tsconf) || $tsconf['show_reviews'] == false || $tsconf['collect_reviews'] == false) {
            return array();
        }
        $this->context->smarty->assign('ts_product_sku', $product_sku);
        $this->context->smarty->assign('locale', $this->locale);
        $this->context->smarty->assign($tsconf);
        $array = array();
        if (!empty($tsconf['review_tab_name'])) {
            $tabName = $tsconf['review_tab_name'];
        } else {
            $tabName = $this->l('Trusted Shops Reviews');
        }
        $this->context->smarty->assign('hasWidgetTitle', false);
        $productExtraContent = new PrestaShop\PrestaShop\Core\Product\ProductExtraContent();
        if ($tsconf['products_reviews_advanced_configuration'] == 1) {
            $product_sticker_config = Tools::jsonDecode($this->getRealJSON($tsconf['product_sticker_code']));
            $this->context->smarty->assign('product_sticker_config', $product_sticker_config);
            $array[] = $productExtraContent->setTitle($tabName)
                ->setContent($this->context->smarty->fetch(
                    $this->local_path.'views/templates/hook/product_sticker_js_expert.tpl'
                ));
            return $array;
        } else {
            $array[] = $productExtraContent->setTitle($tabName)
                ->setContent($this->context->smarty->fetch(
                    $this->local_path.'views/templates/hook/product_sticker_js.tpl'
                ));
            return $array;
        }
    }

    /**
     * Hooks the Product Tab Content and displays product review
     * product_sticker_js.tpl.
     * @param mixed[] $params
     */
    public function hookDisplayProductTabContent($params)
    {
        if (is_array($params['product'])) {
            $product_sku = $params['product']['reference'];
        } elseif (is_object($params['product'])) {
            $product_sku = $params['product']->reference;
        }
        $tsconf = $this->getTSConfig();
        if (empty($tsconf) || $tsconf['show_reviews'] == false || $tsconf['collect_reviews'] == false) {
            return;
        }

        // General assignments
        $this->context->smarty->assign($tsconf);
        $this->context->smarty->assign('ts_product_sku', $product_sku);
        $this->context->smarty->assign('locale', $this->locale);

        $this->context->smarty->assign('hasWidgetTitle', true);
        if ($tsconf['products_reviews_advanced_configuration'] == 1) {
            // Expert mode
            $product_sticker_config = Tools::jsonDecode($this->getRealJSON($tsconf['product_sticker_code']));
            $this->context->smarty->assign('product_sticker_config', $product_sticker_config);
            return $this->display(__FILE__, 'views/templates/hook/product_sticker_js_expert.tpl');
        } else {
            // Standard mode
            return $this->display(__FILE__, 'views/templates/hook/product_sticker_js.tpl');
        }
    }

    /**
     * Hooks the order confirmation page and inserts order and product related
     * information to the checkout_trustcard, which will be recognized by the main trustcard js code.
     *
     * @param mixed[] $params information about the current order
     */
    public function hookDisplayOrderConfirmation($params)
    {
        $tsconfig = $this->getTSConfig();
        if (!empty($tsconfig) && isset($params['objOrder'])) {
            //PS 1.6
            $orderObj = $params['objOrder'];
            $total_to_pay = $params['total_to_pay'];
        } elseif (!empty($tsconfig) && isset($params['order'])) {
            //PS 1.7
            $orderObj = $params['order'];
            $total_to_pay = $params['order']->getOrdersTotalPaid();
        } else {
            return;
        }
        $id_currency = pSQL($orderObj->id_currency);
        $currency = new Currency($id_currency);
        $orderDetails = array(
            'order_number' => $orderObj->reference,
            'customer_email' => $this->context->customer->email,
            'order_amount' => Tools::ps_round($total_to_pay, 2),
            'order_currency' => $currency->iso_code,
            'payment_method' => $orderObj->payment,
            /* estimated delivery date is not supported in prestashop yet */
            'delivery_date' => '',
        );
        $orderProducts = $this->getOrderProductDetails($orderObj->id, $tsconfig);
        $this->context->smarty->assign('collect_reviews', $tsconfig['collect_reviews']);
        $this->context->smarty->assign($orderDetails);
        $this->context->smarty->assign('products', $orderProducts);

        return $this->display(__FILE__, 'views/templates/hook/checkout_trustcard.tpl');
    }

    /**
     * Gets order product details for the checkout trustcard.
     * @param int $id_order
     * @param mixed[] $tsconfig
     */
    protected function getOrderProductDetails($id_order, $tsconfig)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_."order_detail WHERE id_order = '".pSQL($id_order)."'";
        $result = Db::getInstance()->executeS($sql, true, false);
        $image_type_default = Configuration::get('TRUSTEDSHOPS_IMAGE_ALLOCATION');
        $products = array();
        $i = 0;
        foreach ($result as $row) {
            $products[$i] = $row;
            $id_product = (int) pSQL($row['product_id']);
            $product = new Product($id_product);
            $product_link_rewrite = $product->link_rewrite[$this->context->language->id];
            $default_category_rewrite = Category::getLinkRewrite(
                (int) $product->id_category_default,
                $this->context->language->id
            );
            $products[$i]['url'] = $this->context->link->getProductLink($product, null, $default_category_rewrite);
            /* Add image allocation */
            $coverImageID = (int) $this->getCoverImage($product->id);
            /* Image URL Location */
            $products[$i]['id_image'] = $coverImageID;
            $products[$i]['link_rewrite'] = $product_link_rewrite;
            $products[$i]['image_type_default'] = $image_type_default;
            // Removed GTIN Allocation / EAN-13 is GTIN
            // Get gtin from variant! //
            //$products[$i]['gtin'] = $this->getProductShoppingAttribute('gtin', $product, $tsconfig);
            $products[$i]['gtin'] = $row['product_ean13'];
            // Removed Brand Allocation / manufacturer_name = brand
            //$products[$i]['brand'] = $this->getProductShoppingAttribute('brand', $product, $tsconfig);
            $products[$i]['brand'] = Manufacturer::getNameById($product->id_manufacturer);
            // SKU = product_reference
            /* GET SKU FROM PARENT OBJECT */
            $products[$i]['sku'] = $product->reference;
            // MPN is not set in prestashop standard
            $products[$i]['mpn'] = $this->getProductShoppingAttribute('mpn', $product, $tsconfig);
            ++$i;
        }
        return $products;
    }

    /**
     * Gets the product cover image.
     * @param int $id_product Id of the product
     * @return int id_image
     */
    protected function getCoverImage($id_product)
    {
        return Db::getInstance()->getValue('SELECT i.id_image
                                            FROM '._DB_PREFIX_.'image i
                                            INNER JOIN '._DB_PREFIX_.'image_lang il
                                             ON i.id_image = il.id_image
                                             LEFT JOIN '._DB_PREFIX_."image_shop ish
                                             ON i.id_image = ish.id_image WHERE
                                             i.id_product = '".pSQL($id_product)."' AND
                                             i.cover = '1' AND
                                             il.id_lang = '".pSQL($this->context->language->id)."' AND
                                             ish.id_shop = '".pSQL($this->context->shop->id)."'", false);
    }

    /**
     * Gets a feature value.
     *
     * @param id_feature id of feature
     * @param id_product id of product
     */
    protected function getFeature($id_feature, $id_product)
    {
        $featureSelect = "SELECT fvl.value
            FROM "._DB_PREFIX_."feature_value_lang fvl
            INNER JOIN "._DB_PREFIX_."feature_product fp
            ON fvl.id_feature_value = fp.id_feature_value
            WHERE fp.id_feature = '".pSQL($id_feature)."' AND fvl.id_lang = '".pSQL($this->context->language->id)."'
            AND fp.id_product = '".pSQL($id_product)."'";

        return Db::getInstance()->getValue($featureSelect, false);
    }

    /**
     * Gets a product shopping attribute which is needed for additional
     * data analysis, google shopping and trusted shops checkout.
     *
     * used in getOrderProductDetails for getting the mpn
     * @param $type
     * @param $objProduct instance of product object
     */
    protected function getProductShoppingAttribute($type, $objProduct, $tsconfig = array())
    {
        if (!in_array($type, $this->productShoppingAttributes)) {
            return false;
        }
        $configValue = $tsconfig[$type.'_allocation'];
        // Nothing selected
        if ($configValue == 'none') {
            return '';
        }
        $getType = explode('_', $configValue);
        // Product property
        if ($getType[0] == 'product') {
            // for example: product_ean13
            // Add atribute
            $property = str_replace('product_', '', $configValue);
            if (is_array($objProduct)) {
                $result = $objProduct[$property];
            } else {
                $result = $objProduct->$property;
            }
        // Product feature
        } elseif ($getType[0] == 'feature') {
            // for example: feature_2, getType[1] is id_feature
            $id_feature = $getType[1];
            if (is_array($objProduct)) {
                $prod_id = $objProduct['product_id'];
            } else {
                $prod_id = $objProduct->id;
            }
            $result = $this->getFeature($id_feature, $prod_id);
        }

        if (isset($result)) {
            return $result;
        }

        return false;
    }

    /**
     * Log data into logs dir if TS_LOG is defined (only for dev)
     * @param $value
     */
    public static function log($value)
    {
        if (defined('TS_LOG') && TS_LOG == true) {
            $handle = fopen(dirname(__FILE__).'/logs/log-'.date('Y-m-d').'.log', 'a+');
            fwrite($handle, '[' . date('y-m-d H:i:s') . '] ' . print_r($value, true)."\r");
            fclose($handle);
        }
    }
}

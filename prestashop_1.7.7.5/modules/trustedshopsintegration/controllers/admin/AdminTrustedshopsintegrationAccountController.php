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

/**
 * @desc Manage login an create account page
 */
class AdminTrustedshopsintegrationAccountController extends ModuleAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->name = 'trustedshopsintegration';

        $this->client = new TSApiClient();

        $this->actionPath = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');
        $this->accountUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        $this->template = 'login.tpl';
        $this->bootstrap = true;
        $this->meta_title = $this->l('Sign in');
        $this->context->smarty->assign('ts_page', 'login');
    }

    public function initContent()
    {
        $this->context->smarty->addPluginsDir(realpath(dirname(__FILE__) .'/../../smarty/plugins'));

        if (version_compare(phpversion(), '5.5', '<')) {
            $multilang_vars = TSParameters::get();

            $this->context->smarty->assign('lang', $this->context->language->iso_code);
            if (false === isset($multilang_vars['php-version-min'][$this->context->language->iso_code])) {
                $multilang_vars['php-version-min'][$this->context->language->iso_code] = $multilang_vars['php-version-min']['en'];
            }
            $this->context->smarty->assign(array(
                'failed_link' => $multilang_vars['php-version-min'][$this->context->language->iso_code]
            ));
            $this->errors[] = $this->context->smarty->fetch(
                _PS_MODULE_DIR_. 'trustedshopsintegration/views/templates/admin/install_failed.tpl'
            );
        }

        if (Tools::getValue('ts_logout') == true) {
            // LOGOUT
            Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
            Configuration::updateValue('TRUSTEDSHOPS_MEMBER_FAILED', 1);
            //Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_UUID');
            if (isset($_SESSION['TRUSTEDSHOPS_SHOPS'])) {
                unset($_SESSION['TRUSTEDSHOPS_SHOPS']);
            }
            Configuration::deleteByName('TRUSTEDSHOPS_CURRENT_ID_CONFIG');
            Tools::redirectAdmin($this->accountUrl);
        } elseif (Tools::isSubmit('submit_ts_infos')) {
            // login form
            $this->context->smarty->assign('ts_page', 'login');
            $data = array();
            $data['login'] = Tools::getValue('ts_login_email');
            $data['password'] = Tools::getValue('ts_login_password');

            $webservice = $this->client->getWrapper('memberships');
            $webservice->setCredentials(Tools::htmlentitiesUTF8($data['login'].':'.$data['password']));
            $this->client->call($webservice);
            $response = $this->client->getResponse();

            if ($response->isSuccess() == false) {
                Configuration::deleteByName('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
                $errors = $this->client->getResponse()->getErrors();
                foreach ($errors as $error) {
                    if ($error == 'Authentication failed') {
                        $this->errors[] = $this->l('The credentials are not correct. Please try again or click on "Forgot your password"');
                    } elseif ($error == 'Internal failed') {
                        $this->errors[] = $this->l('We are sorry! Our service is not available at the moment. Please try again later');
                    } else {
                        $this->errors[] = $error;
                    }
                }
                $this->content = $this->renderView();
                Configuration::updateValue('TRUSTEDSHOPS_MEMBER_FAILED', 1);

                return parent::initContent();
            }

            $content = $response->getContent();
            $status = 'NO_TRIAL';
            foreach ($content['retailer']['memberships'][0]['serviceItems'] as $item) {
                if ($item['type'] == 'MEMBERSHIP_TRIAL') {
                    $status = 'TRIAL';
                    break;
                }
            }
            Configuration::updateValue('TRUSTEDSHOPS_MEMBER_CREDENTIALS', Tools::htmlentitiesUTF8($data['login'].':'.$data['password']));
         
            if (!Configuration::hasKey('TRUSTEDSHOPS_MEMBER_CREATEDAT')) {
                Configuration::updateValue('TRUSTEDSHOPS_MEMBER_CREATEDAT', Date('Y-m-d H:i:s'));
            }
            Configuration::updateValue('TRUSTEDSHOPS_MEMBER_FAILED', 0);
            Configuration::updateValue('TRUSTEDSHOPS_MEMBER_TRIAL', $status);
            Configuration::updateValue('TRUSTEDSHOPS_MEMBER_UUID', $content['retailer']['memberships'][0]['uuid']);

            Tools::redirectAdmin($this->actionPath);
        }

        $this->content = $this->renderView();

        return parent::initContent();
    }

    public function renderView()
    {


        $this->context->controller->addJS(_MODULE_DIR_ . $this->name .'/'.TotWebpack::getJSByName('validate'));
        $this->context->controller->addJS(_MODULE_DIR_ . $this->name .'/'.TotWebpack::getJSByName('back'));
        $this->context->controller->addCSS(_MODULE_DIR_ . $this->name .'/'.TotWebpack::getCSSByName('back'));
        // If PS version > 1.7, hide auto generated controller menu (in the top bar).
        if ((version_compare(_PS_VERSION_, '1.7.0', '>=') === true)) {
            $this->context->controller->addCSS(_MODULE_DIR_ . '/' . $this->name . '/views/css/ps_17_specific.css');
        }
        if (Configuration::get('TRUSTEDSHOPS_MEMBER_TRIAL') == 'EXPIRED_TRIAL') {
            $this->context->smarty->assign('ts_page', 'expiredTrial');
        }

        $this->context->smarty->assign('actionURL', $this->actionPath);

        $this->context->smarty->assign('possibleShopsLangs', $this->getPossibleLanguages());
        $this->context->smarty->assign('accountUrl', $this->accountUrl);
        $this->context->smarty->assign('module_dir', _MODULE_DIR_);

        $ts_img_dir = _MODULE_DIR_ . '/' . $this->name . '/views/img/';
        $this->context->smarty->assign('ts_img_dir', $ts_img_dir);

        $iso_code = $this->context->language->iso_code;
        if (!in_array($iso_code, array('de', 'en', 'fr', 'pl'))) {
            $iso_code = 'en';
        }

        $this->context->smarty->assign('iso_lang', $iso_code);

        $tpl = $this->createTemplate($this->template);
        return $tpl->fetch();
    }

    /**
     * Gets a choosen ts link.
     * @param string $type Linktype
     * @return string URL
     */
    private function getTSLink($type = 'information')
    {
        $typeArray = array('information', 'product_review_information', 'trustbadge_options');
        $lang_iso = $this->context->language->iso_code;

        if (!in_array($lang_iso, array('de', 'en', 'fr', 'pl'))) {
            $lang_iso = 'en';
        }
        if (in_array($type, $typeArray)) {
            $key = 'TRUSTEDSHOPS_'.Tools::strtoupper($type).'_LINK_'.Tools::strtoupper($lang_iso);
            return Configuration::get($key);
        } else {
            return false;
        }
    }

    /**
     * Gets the available languages for a shop instance
     * @return mixed[] Array of choosable languages for linking a trusted shops id
     */
    private function getPossibleLanguages()
    {
        $querystr = 'SELECT s.id_shop, l.id_lang, l.name AS lang_name, s.name AS shop_name FROM '._DB_PREFIX_.'shop s
            LEFT JOIN '._DB_PREFIX_.'lang_shop ls ON ls.id_shop = s.id_shop
            LEFT JOIN '._DB_PREFIX_.'lang l ON ls.id_lang = l.id_lang';

        $shopsLangs = Db::getInstance()->executeS($querystr, true, false);

        return $shopsLangs;
    }
}

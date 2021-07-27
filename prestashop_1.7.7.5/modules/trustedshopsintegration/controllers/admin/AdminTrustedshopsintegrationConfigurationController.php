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

class AdminTrustedshopsintegrationConfigurationController extends ModuleAdminController
{

    protected $position_identifier = 'id_trusted_shops';

    /**
     * @desc constructor to init configuration behaviours
     */
    public function __construct()
    {
        parent::__construct();
        $this->name = 'trustedshopsintegration';
        $this->bootstrap = true;
        $this->meta_title = $this->l('Trusted Shops ID configuration');
        $this->display = 'list';

        $this->defaultValues = array(
            'review_tab_border_color' => '#0DBEDC',
            'review_tab_background_color' => '#FFFFFF',
            'rating_star_color' => '#FFDC0F',
            'review_tab_star_color' => '#FFDC0F',
            'rating_star_size' => '14',
            'rating_font_size' => '12',
            'variant' => 'reviews'
        );
        $this->_defaultOrderBy = 'id_trusted_shops';


        $this->table = 'trustedshopsintegration';
        $this->_select .=  'shop.name AS shopname, l.name AS langname, ';
        $this->_join .= ' LEFT JOIN '._DB_PREFIX_.'lang AS l ON a.id_lang = l.id_lang
                        LEFT JOIN `'._DB_PREFIX_.'shop` AS shop ON (shop.id_shop = a.id_shop) ';
        $this->className = 'TSID';
        $this->context = Context::getContext();
        $this->fields_list = $this->fieldList();
        $this->toolbar_title[] = $this->l('Shops configuration');

        $this->allow_export = false;
        $this->actions = array('edit');
        $this->delete = false;
        $this->homeUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');
        $this->siteUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationSite');
    }

    /**
     * @desc define list of data for ts_config
     */
    public function fieldList()
    {
        // @needed because PrestaShop 1.7 remove session data / used to retrieve uuid
        $adminTsUrl = array();
        $adminTsUrl['account'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        if (TSMember::hasAccess() == false) {
            Tools::redirectAdmin($adminTsUrl['account']);
        }
        // @endneeded
        $fields_list = array(
           /* 'uuid' => array(
                'title' => $this->l('Trusted Shops UUID'),
                'type' => 'text',
                'havingFilter' => true,
            ),*/
            'id_trusted_shops' => array(
                'title' => $this->l('Trusted Shops ID'),
                'type' => 'text',
                'class' => 'word-break-all',
            ),
            'api_lang' => array(
                'title' => $this->l('Trusted Shops Language'),
                'type' => 'text',
            ),
            'api_url' => array(
                'title' => $this->l('Trusted Shops URL'),
                'type' => 'text',
                'class' => 'word-break-all',
            ),
            'shopname' => array(
                'title' => $this->l('PrestaShop Shop'),
                'filter_key' => 'shop!name',
            ),
            'langname' => array(
                'title' => $this->l('Shop Language'),
                'filter_key' => 'l!name',
            ),
        );

        $this->_filterHaving = 'uuid="'.pSQL(Configuration::get('TRUSTEDSHOPS_MEMBER_UUID')).'"';
        $this->orderBy = 'id_trusted_shops'; // DB column field which hold my object ID
        $this->_orderWay = 'DESC';
        $this->identifier = 'id_ts_config';

        $this->tpl_list_vars = array('toolbar_btn' => array());

        return $fields_list;
    }


    /**
     * Assign smarty variables for all default views, list and form, then call other init functions
     */
    public function initContent()
    {
        $this->context->smarty->addPluginsDir(realpath(dirname(__FILE__) .'/../../smarty/plugins'));
        $adminTsUrl = array();
        $adminTsUrl['home'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');
        $adminTsUrl['site'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationSite');
        $adminTsUrl['products'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationProducts');
        $adminTsUrl['account'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        $adminTsUrl['configuration'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationConfiguration');
        $adminTsUrl['invites'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationInvites');
        $this->context->smarty->assign('adminTsUrl', $adminTsUrl);

        if (!$this->viewAccess()) {
            $this->errors[] = $this->trans(
                'You do not have permission to view this.',
                array(),
                'Admin.Notifications.Error'
            );
            return;
        }

        if ($this->display != 'edit') {
            $this->template  = 'list.tpl';
            return parent::initContent();
        }
        $this->context->smarty->assign('id_ts_config', (int) Tools::getValue('id_ts_config'));
        $this->context->smarty->assign('possibleShopsLangs', $this->getPossibleLanguages());
        $this->template  = 'edit.tpl';

        $tsconfig = new TSID((int) Tools::getValue('id_ts_config'));

        if (!empty(Tools::getValue('submit')) || !empty(Tools::getValue('submit_and_stay'))) {
            if (Tools::getValue('shop_lang') == false) {
                $id_shop = 0;
                $id_lang = 0;
            } else {
                $shopLang = explode('_', Tools::getValue('shop_lang'));
                $id_shop = (int) $shopLang[0];
                $id_lang = (int) $shopLang[1];
            }
            $tsconfig->id_shop = $id_shop;
            $tsconfig->id_lang = $id_lang;
            try {
                $tsconfig->save();

                if (Tools::isSubmit('submit')) {
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminTrustedshopsintegrationHome'));
                }
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminTrustedshopsintegrationConfiguration'));
            } catch (Exception $e) {
                $this->errors[] = $e->getMessage();
            }
        }
        $this->context->smarty->assign('tsconfig', $tsconfig);
        $this->context->smarty->assign('content', $this->content);

        $this->content = $this->renderView();
        return parent::initContent();
    }

    public function setMedia($isNewTheme = false)
    {
        $this->context->controller->addCSS(_MODULE_DIR_ . $this->name .'/'.TotWebpack::getCSSByName('back'));
        if (version_compare(_PS_VERSION_, '1.7.4', '>=') === true) {
            $this->context->controller->addCSS(_MODULE_DIR_ . '/' . $this->name . '/views/css/ps_174_specific.css');
        } elseif ((version_compare(_PS_VERSION_, '1.7.0', '>=') === true)) {
        // If PS version > 1.7, hide auto generated controller menu (in the top bar).
            $this->context->controller->addCSS(_MODULE_DIR_ . '/' . $this->name . '/views/css/ps_17_specific.css');
        }

        parent::setMedia();
    }

    /**
     * Gets the available languages for a shop instance
     * @return mixed[] Array of choosable languages for linking a trusted shops id
     */
    private function getPossibleLanguages()
    {
        $query = new DbQuery();
        $query->select('s.id_shop, l.id_lang, l.name AS lang_name, s.name AS shop_name');
        $query->from('shop', 's');
        $query->leftJoin('lang_shop', 'ls', 'ls.id_shop = s.id_shop');
        $query->leftJoin('lang', 'l', 'ls.id_lang = l.id_lang');

        $shopsLangs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query->build(), true, false);

        $query = new DbQuery();
        $query->select('id_lang, id_shop');
        $query->from('trustedshopsintegration');
        $query->where('id_shop != 0');
        $query->where('id_lang != 0');
        $query->where('uuid="'.pSQL(Configuration::get('TRUSTEDSHOPS_MEMBER_UUID')).'"');
        $query->where('id_ts_config != "'. (int) Tools::getValue('id_ts_config') .'"');

        $existingTsConfigs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query->build());
        foreach ($existingTsConfigs as $existingTsConfig) {
            foreach ($shopsLangs as $key => $shopsLang) {
                if ($existingTsConfig['id_lang'] == $shopsLang['id_lang']
                    && $existingTsConfig['id_shop'] == $shopsLang['id_shop']) {
                    unset($shopsLangs[$key]);
                }
            }
        }

        return $shopsLangs;
    }
}

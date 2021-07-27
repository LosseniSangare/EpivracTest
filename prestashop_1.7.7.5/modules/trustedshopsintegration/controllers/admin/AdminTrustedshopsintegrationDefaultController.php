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

class AdminTrustedshopsintegrationDefaultController extends ModuleAdminController
{

    /**
     *  @desc Initial check for all admin authenticated controllers
     */
    public function init()
    {
        $this->context->smarty->addPluginsDir(realpath(dirname(__FILE__) .'/../../smarty/plugins'));
        $adminTsUrl = array();
        $adminTsUrl['account'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        if (TSMember::hasAccess() == false) {
            Tools::redirectAdmin($adminTsUrl['account']);
        }
        $id_ts_config = Tools::getValue('id_ts_config');
        if (!empty($id_ts_config)) {
            $TSIDs = $this->getTSIDs();
            foreach ($TSIDs as $TSID) {
                // check if data is valid and present in db
                if (Tools::getValue('id_ts_config') == $TSID['id_ts_config']) {
                    Configuration::updateValue('TRUSTEDSHOPS_CURRENT_ID_CONFIG', $TSID['id_ts_config']);
                }
            }
        }

        if (!Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG')) {
            $TSIDs = $this->getTSIDs();
            // no TSID well configured = redirection on config page
            if (count($TSIDs) == 0) {
                $adminTsUrl['configuration'] = $this->context->link->getAdminLink(
                    'AdminTrustedshopsintegrationConfiguration'
                );
                Tools::redirectAdmin($adminTsUrl['configuration']);
            }
            // take the first well configured
            $TSID = array_shift($TSIDs);
            Configuration::updateValue('TRUSTEDSHOPS_CURRENT_ID_CONFIG', $TSID['id_ts_config']);
        }
        $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));
        $this->context->smarty->assign(array(
            'tsconfig' => $tsconfig,
            'self' => _PS_MODULE_DIR_.'trustedshopsintegration/views/templates'
        ));

        return parent::init();
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();

        $this->context->controller->addJquery();
        $this->context->controller->addJqueryPlugin('colorpicker');
        $this->context->controller->addJS(_MODULE_DIR_ . $this->name .'/'.TotWebpack::getJSByName('validate'));
        $this->context->controller->addJS(_MODULE_DIR_ . $this->name .'/'.TotWebpack::getJSByName('back'));
        $this->context->controller->addCSS(_MODULE_DIR_ . $this->name .'/'.TotWebpack::getCSSByName('back'));
        if (version_compare(_PS_VERSION_, '1.7.4', '>=') === true) {
            $this->context->controller->addCSS(_MODULE_DIR_ . '/' . $this->name . '/views/css/ps_174_specific.css');
        } elseif ((version_compare(_PS_VERSION_, '1.7.0', '>=') === true)) {
        // If PS version > 1.7, hide auto generated controller menu (in the top bar).
            $this->context->controller->addCSS(_MODULE_DIR_ . '/' . $this->name . '/views/css/ps_17_specific.css');
        }
    }

    /**
     * @desc assign default data in the layout
     */
    public function renderView()
    {
        $adminTsUrl = array();
        // @needed because PrestaShop 1.7 remove session data
        $adminTsUrl['account'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        if (TSMember::hasAccess() == false) {
            Tools::redirectAdmin($adminTsUrl['account']);
        }
        // @endneeded
        $adminTsUrl['home'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');
        $adminTsUrl['site'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationSite');
        $adminTsUrl['products'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationProducts');
        $adminTsUrl['account'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationAccount');
        $adminTsUrl['configuration'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationConfiguration');
        $adminTsUrl['invites'] = $this->context->link->getAdminLink('AdminTrustedshopsintegrationInvites');
        $this->context->smarty->assign('adminTsUrl', $adminTsUrl);

        $ts_img_dir = _MODULE_DIR_ . $this->name . '/views/img/';
        $this->context->smarty->assign('ts_img_dir', $ts_img_dir);

        if (isset($this->currentPage)) {
            $this->context->smarty->assign('currentPage', $this->currentPage);
        }
        $this->context->smarty->assign('trial', Configuration::get('TRUSTEDSHOPS_MEMBER_TRIAL'));
        $this->context->smarty->assign('errors', $this->errors);
        $this->context->smarty->assign('TSIDs', $this->getTSIDs());

        $tpl = $this->createTemplate($this->template);
        return $tpl->fetch();
    }

    /**
     * @desc Get all TSID from data base
     */
    protected function getTSIDs()
    {
        $query = new DbQuery();
        $query->select('a.id_ts_config, a.id_trusted_shops, shop.name AS shopname, l.name AS langname');
        $query->from('trustedshopsintegration', 'a');
        $query->innerJoin('lang', 'l', 'a.id_lang = l.id_lang');
        $query->innerJoin('shop', 'shop', 'shop.id_shop = a.id_shop');
        $query->where('uuid="'.pSQL(Configuration::get('TRUSTEDSHOPS_MEMBER_UUID')).'"');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($query->build());
    }
    /**
     * @throws Exception
     * @throws SmartyException
     */
    public function initModal()
    {
    }
}

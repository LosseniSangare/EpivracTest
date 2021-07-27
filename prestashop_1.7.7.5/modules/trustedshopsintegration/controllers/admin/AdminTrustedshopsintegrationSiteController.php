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

require_once 'AdminTrustedshopsintegrationDefaultController.php';
require_once dirname(__FILE__) . '/../../classes/TrustedShopUtils.php';

class AdminTrustedshopsintegrationSiteController extends AdminTrustedshopsintegrationDefaultController
{

    public function __construct()
    {
        parent::__construct();
        $this->name = 'trustedshopsintegration';
        $this->currentPage = 'site';
        $this->bootstrap = true;
        $this->meta_title = $this->l('Trusted shops - Site reviews');

        $this->homeUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');
        $this->siteUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationSite');

        $this->template = 'index.tpl';
    }

    public function initContent()
    {
        parent::init();
        $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));
        $this->context->smarty->assign('tsconfig', $tsconfig);
        $this->content = $this->renderView();

        // Save Trustbadge
        if (Tools::isSubmit('trustbadge_save_and_stay') || Tools::isSubmit('trustbadge_save')) {
            $tsconfig->display_trustbadge = Tools::getValue('display_trustbadge');
            if (Tools::getValue('trustbadge_advanced_configuration') == 0) {
                $tab = array(
                    'display_trustbadge',
                    'variant',
                    'y_offset'
                );
                $result = TrustedShopUtils::validateConfigurationForm($tab);
                if ($result !== true) {
                    foreach ($result as $res) {
                        $this->errors[] = $res;
                        return false;
                    }
                }

                $tsconfig->variant = Tools::getValue('variant');
                $tsconfig->y_offset = (int)Tools::getValue('y_offset');
            } else {
                if (TrustedShopUtils::isJson(Tools::getValue('trustbadge_code')) !== false
                    && Tools::getValue('trustbadge_code') != '') {
                    $tsconfig->trustbadge_code = json_encode(TrustedShopUtils::isJson(Tools::getValue('trustbadge_code')));
                } else {
                    $this->errors = $this->l('Please enter a valid JSON configuration.');
                    return false;
                }
            }
            $tsconfig->tick_configure_trustedbadge = 1;
            $tsconfig->trustbadge_advanced_configuration = Tools::getValue('trustbadge_advanced_configuration');

            $tsconfig->save();

            if (Tools::isSubmit('trustbadge_save')) {
                Tools::redirectAdmin($this->homeUrl);
            }
        }

        // Save Review sticker
        if (Tools::isSubmit('review_save_and_stay') || Tools::isSubmit('review_save')) {
            $tsconfig->display_shop_reviews = Tools::getValue('display_shop_reviews');
            if (Tools::getValue('review_advanced_configuration') == 0) {
                $tab = array(
                    'display_shop_reviews',
                    'review_sticker_font',
                    'number_of_reviews',
                    'maximum_rating',
                    'site_review_background_color'
                );
                $result = TrustedShopUtils::validateConfigurationForm($tab);
                if ($result !== true) {
                    foreach ($result as $res) {
                        $this->errors[] = $res;
                        return false;
                    }
                }

                $tsconfig->review_sticker_font = Tools::getValue('review_sticker_font');
                $tsconfig->number_of_reviews = Tools::getValue('number_of_reviews');
                $tsconfig->maximum_rating = Tools::getValue('maximum_rating');
                $tsconfig->site_review_background_color = Tools::getValue('site_review_background_color');
            } else {
                if (TrustedShopUtils::isJson(Tools::getValue('site_review_configuration_code')) !== false
                    && Tools::getValue('site_review_configuration_code') != '') {
                    $tsconfig->site_review_configuration_code = json_encode(TrustedShopUtils::isJson(Tools::getValue('site_review_configuration_code')));
                } else {
                    $this->errors = $this->l('Please enter a valid JSON configuration.');
                    return false;
                }
            }
            $tsconfig->review_advanced_configuration = Tools::getValue('review_advanced_configuration');

            $tsconfig->save();

            if (Tools::isSubmit('review_save')) {
                Tools::redirectAdmin($this->homeUrl);
            }
        }

        // Save Rich Snippets
        if (Tools::isSubmit('richsnippet_save_and_stay') || Tools::isSubmit('richsnippet_save')) {
            $tsconfig->enable_rich_snippets = (Tools::getValue('enable_rich_snippets')) ? 1 : 0;
            $tsconfig->enable_rich_snippets_listing = (Tools::getValue('enable_rich_snippets_listing')) ? 1 : 0;
            $tsconfig->enable_rich_snippets_product = (Tools::getValue('enable_rich_snippets_product')) ? 1 : 0;
            $tsconfig->enable_rich_snippets_homepage = (Tools::getValue('enable_rich_snippets_homepage')) ? 1 : 0;

            $tsconfig->save();

            if (Tools::isSubmit('richsnippet_save')) {
                Tools::redirectAdmin($this->homeUrl);
            }
        }

        return parent::initContent();
    }

    public function renderView()
    {
        return parent::renderView();
    }
}

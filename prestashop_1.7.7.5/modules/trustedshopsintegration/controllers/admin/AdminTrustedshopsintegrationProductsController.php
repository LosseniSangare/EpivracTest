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

class AdminTrustedshopsintegrationProductsController extends AdminTrustedshopsintegrationDefaultController
{

    public function __construct()
    {
        parent::__construct();
        $this->name = 'trustedshopsintegration';
        $this->currentPage = 'products';
        $this->bootstrap = true;
        $this->meta_title = $this->l('Trusted shops - Products reviews');

        $this->homeUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');

        $this->template = 'index.tpl';
    }

    public function initContent()
    {
        parent::init();
        $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));

        $this->context->smarty->assign(array(
            'tsconfig' => $tsconfig,
            'MPNProductFeatures' => $this->getMPNProductFeatures($this->context->language->id)
        ));

        $this->content = $this->renderView();

        if (Tools::isSubmit('submitOptionsimage_type_stay') || Tools::isSubmit('submitOptionsimage_type')) {
            $tsconfig->collect_reviews = Tools::getValue('collect_reviews');
            $tsconfig->show_reviews = Tools::getValue('show_reviews');
            $tsconfig->show_rating = Tools::getValue('show_rating');
            $tsconfig->mpn_allocation = Tools::getValue('mpn_allocation');
            if (Tools::getValue('products_reviews_advanced_configuration') == 0) {
                $tab = array(
                    'collect_reviews',
                    'show_reviews',
                    'mpn_allocation',
                    'review_tab_border_color',
                    'review_tab_star_color',
                    'review_tab_background_color',
                    'review_tab_name'
                );
                $result = TrustedShopUtils::validateConfigurationForm($tab);
                if ($result !== true) {
                    foreach ($result as $res) {
                        $this->errors[] = $res;
                        return false;
                    }
                }

                $tsconfig->review_tab_border_color = Tools::getValue('review_tab_border_color');
                $tsconfig->review_tab_star_color = Tools::getValue('review_tab_star_color');
                $tsconfig->review_tab_background_color = Tools::getValue('review_tab_background_color');
                $tsconfig->review_tab_name = Tools::getValue('review_tab_name');
            } else {
                if (TrustedShopUtils::isJson(Tools::getValue('product_sticker_code')) !== false
                    && Tools::getValue('product_sticker_code') != '') {
                    $tsconfig->product_sticker_code = json_encode(TrustedShopUtils::isJson(Tools::getValue('product_sticker_code')));
                    $tsconfig->review_tab_name = Tools::getValue('review_tab_name');
                } else {
                    $this->errors = $this->l('Please enter a valid JSON configuration.');
                    return false;
                }
            }

            if (Tools::getValue('rating_stars_advanced_configuration') == 0) {
                $tab = array(
                    'collect_reviews',
                    'show_reviews',
                    'mpn_allocation',
                    'show_rating',
                    'rating_star_color',
                    'rating_star_size',
                    'rating_font_size',
                    'hide_empty_ratings'
                );
                $result = TrustedShopUtils::validateConfigurationForm($tab);
                if ($result !== true) {
                    foreach ($result as $res) {
                        $this->errors[] = $res;
                        return false;
                    }
                }

                $tsconfig->rating_star_color = Tools::getValue('rating_star_color');
                $tsconfig->rating_star_size = Tools::getValue('rating_star_size');
                $tsconfig->rating_font_size = Tools::getValue('rating_font_size');
                $tsconfig->hide_empty_ratings = Tools::getValue('hide_empty_ratings');
            } else {
                if (TrustedShopUtils::isJson(Tools::getValue('product_widget_code')) !== false
                    && Tools::getValue('product_widget_code') != '') {
                    $tsconfig->product_widget_code = json_encode(TrustedShopUtils::isJson(Tools::getValue('product_widget_code')));
                } else {
                    $this->errors = $this->l('Please enter a valid JSON configuration.');
                    return false;
                }
            }
            $tsconfig->products_reviews_advanced_configuration = Tools::getValue(
                'products_reviews_advanced_configuration'
            );
            $tsconfig->rating_stars_advanced_configuration = Tools::getValue(
                'rating_stars_advanced_configuration'
            );
            $tsconfig->tick_configure_request = 1;
            $tsconfig->save();

            if (Tools::isSubmit('submitOptionsimage_type')) {
                Tools::redirectAdmin($this->homeUrl);
            }
        }

        return parent::initContent();
    }

    private function getMPNProductFeatures($id_lang)
    {
        $query = new DbQuery();
        $query->select('id_feature, name');
        $query->from('feature_lang');
        $query->where('id_lang='.(int) $id_lang);
        $query->orderBY('id_feature ASC');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query->build());
    }
}

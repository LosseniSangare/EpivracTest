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

class TSID extends ObjectModel
{

    public $id_ts_config;
    public $uuid;
    public $id_shop;
    public $id_lang;
    public $api_lang;
    public $api_url;
    public $id_trusted_shops;
    public $display_trustbadge;
    public $display_shop_reviews;
    public $trustbadge_advanced_configuration;
    public $review_advanced_configuration;
    public $products_reviews_advanced_configuration;
    public $rating_stars_advanced_configuration;
    public $enable_rich_snippets;
    public $enable_rich_snippets_listing;
    public $enable_rich_snippets_product;
    public $enable_rich_snippets_homepage;
    public $variant = 'reviews';
    public $y_offset;
    public $review_sticker_font = 'Arial';
    public $number_of_reviews = 5;
    public $maximum_rating = '3.0';
    public $site_review_background_color = '#ffdc0f';
    public $trigger_reviews_active;
    public $trigger_reviews_step;
    public $trigger_reviews_carriers;
    public $collect_reviews;
    public $show_reviews;
    public $show_rating;
    public $review_tab_name;
    public $review_tab_border_color = '#0DBEDC';
    public $review_tab_star_color = '#FFDC0F';
    public $review_tab_background_color = '#FFFFFF';
    public $hide_empty_reviews;
    public $rating_star_color = '#FFDC0F';
    public $rating_star_size = '14';
    public $rating_font_size = '12';
    public $hide_empty_ratings;
    public $trustbadge_code = '{"customElementId" : "", "trustcardDirection" : "", "customBadgeWidth" : "", "disableResponsive" : "", "disableTrustbadge": "", "variant" : "reviews", "yOffset" : "0", "responsive":{"variant":"default"}}';
    public $site_review_configuration_code = '{"element": "#ts_review_sticker", "variant": "testimonial", "reviews": "5", "betterThan": "3.0", "richSnippets": "on", "backgroundColor": "#ffdc0f", "linkColor": "#000000", "quotationMarkColor": "#FFFFFF", "fontFamily": "Arial", "reviewMinLength": "10"}';
    public $product_sticker_code = '{"variant" : "productreviews", "borderColor" : "#0DBEDC", "backgroundColor" : "#FFFFFF", "starColor" : "#FFDC0F", "starSize" : "15px", "richSnippets" : "on", "ratingSummary" : "false", "maxHeight" : "600px", "filter" : "true", "introtext" : ""}';
    public $product_widget_code = '{"starColor" : "#FFDC0F", "starSize" : "14px", "fontSize" : "12px", "showRating" : "false", "scrollToReviews" : "false", "enablePlaceholder" : "false", "element" : "#ts_product_widget"}';
    public $gtin_allocation;
    public $brand_allocation;
    public $mpn_allocation;
    public $tick_first_reviews;
    public $tick_configure_trustedbadge;
    public $tick_configure_request;
    /** keep for retropcompatibility between v1 and v2 */
    public $current_mode;

    public static $definition = array(
        'table' => 'trustedshopsintegration',
        'primary' => 'id_ts_config',
        'fields' => array(
            'id_ts_config' => array('type' => self::TYPE_INT, 'required' => false),
            'uuid' => array('type' => self::TYPE_STRING, 'required' => false),
            'id_shop' => array('type' => self::TYPE_INT, 'required' => true),
            'id_lang' => array('type' => self::TYPE_INT, 'required' => true),
            'api_lang' => array('type' => self::TYPE_STRING, 'required' => false),
            'api_url' => array('type' => self::TYPE_STRING, 'required' => false),
            'id_trusted_shops' => array('type' => self::TYPE_STRING, 'required' => true),
            'display_trustbadge' => array('type' => self::TYPE_INT, 'required' => false),
            'display_shop_reviews' => array('type' => self::TYPE_INT, 'required' => false),
            'trustbadge_advanced_configuration' => array('type' => self::TYPE_INT, 'required' => false),
            'review_advanced_configuration' => array('type' => self::TYPE_INT, 'required' => false),
            'products_reviews_advanced_configuration' => array('type' => self::TYPE_INT, 'required' => false),
            'rating_stars_advanced_configuration' => array('type' => self::TYPE_INT, 'required' => false),
            'enable_rich_snippets' => array('type' => self::TYPE_INT, 'required' => false),
            'enable_rich_snippets_listing' => array('type' => self::TYPE_INT, 'required' => false),
            'enable_rich_snippets_product' => array('type' => self::TYPE_INT, 'required' => false),
            'enable_rich_snippets_homepage' => array('type' => self::TYPE_INT, 'required' => false),
            'variant' => array('type' => self::TYPE_STRING, 'required' => false),
            'y_offset' => array('type' => self::TYPE_INT, 'required' => false),
            'review_sticker_font' => array('type' => self::TYPE_STRING, 'required' => false),
            'number_of_reviews' => array('type' => self::TYPE_STRING, 'required' => false),
            'maximum_rating' => array('type' => self::TYPE_FLOAT, 'required' => false),
            'site_review_background_color' => array('type' => self::TYPE_STRING, 'required' => false),
            'trigger_reviews_active' => array('type' => self::TYPE_INT, 'required' => false),
            'trigger_reviews_step' => array('type' => self::TYPE_INT, 'required' => false),
            'trigger_reviews_carriers' => array('type' => self::TYPE_HTML, 'required' => false),
            'collect_reviews' => array('type' => self::TYPE_INT, 'required' => false),
            'show_reviews' => array('type' => self::TYPE_INT, 'required' => false),
            'show_rating' => array('type' => self::TYPE_INT, 'required' => false),
            'review_tab_name' => array('type' => self::TYPE_STRING, 'required' => false),
            'review_tab_border_color' => array('type' => self::TYPE_STRING, 'required' => false),
            'review_tab_star_color' => array('type' => self::TYPE_STRING, 'required' => false),
            'review_tab_background_color' => array('type' => self::TYPE_STRING, 'required' => false),
            'hide_empty_reviews' => array('type' => self::TYPE_INT, 'required' => false),
            'rating_star_color' => array('type' => self::TYPE_STRING, 'required' => false),
            'rating_star_size' => array('type' => self::TYPE_INT, 'required' => false),
            'rating_font_size' => array('type' => self::TYPE_INT, 'required' => false),
            'hide_empty_ratings' => array('type' => self::TYPE_INT, 'required' => false),
            'trustbadge_code' => array('type' => self::TYPE_HTML, 'required' => false),
            'site_review_configuration_code' => array('type' => self::TYPE_HTML, 'required' => false),
            'product_sticker_code' => array('type' => self::TYPE_HTML, 'required' => false),
            'product_widget_code' => array('type' => self::TYPE_HTML, 'required' => false),
            'gtin_allocation' => array('type' => self::TYPE_STRING, 'required' => false),
            'brand_allocation' => array('type' => self::TYPE_STRING, 'required' => false),
            'mpn_allocation' => array('type' => self::TYPE_STRING, 'required' => false),
            'tick_first_reviews' => array('type' => self::TYPE_INT, 'required' => false),
            'tick_configure_trustedbadge' => array('type' => self::TYPE_INT, 'required' => false),
            'tick_configure_request' => array('type' => self::TYPE_INT, 'required' => false),
            'current_mode' => array('type' => self::TYPE_STRING, 'required' => false),
        ),
    );

    /**
     * @desc Get config by TSID
     */
    public static function getTSId($id_trusted_shops)
    {
        $query = new DbQuery();
        $query->select('id_ts_config');
        $query->from('trustedshopsintegration');
        $query->where('id_trusted_shops="'.pSQL($id_trusted_shops).'"');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query->build());
    }

    public static function getTriggerInfos($uuid, $id_shop, $id_lang)
    {
        $query = new DbQuery();
        $query->select('trigger_reviews_step, trigger_reviews_carriers, id_ts_config, trigger_reviews_active, collect_reviews');
        $query->from('trustedshopsintegration');
        $query->where('uuid="'.pSQL($uuid).'" AND id_shop='.(int)$id_shop.' AND id_lang='.(int)$id_lang);

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query->build());
    }
}

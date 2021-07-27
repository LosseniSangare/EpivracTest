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

function upgrade_module_2_0_0($module)
{

    Configuration::updateValue('TRUSTEDSHOPS_MEMBER_FAILED', 1);

    $module->unregisterHook('backOfficeHeader') &&
    $module->registerHook('actionOrderStatusUpdate') &&
    $module->registerHook('displayLeftColumn') &&
    $module->registerHook('displayRightColumn') &&
    $module->registerHook('displayProductExtraContent') &&
    $module->registerHook('displayInvoice');

    $module->installTabs();

    Db::getInstance()->execute('ALTER TABLE '._DB_PREFIX_.'trustedshopsintegration
            ADD `api_lang` varchar(5) NOT NULL,
            ADD `api_url` varchar(250) NOT NULL,
            ADD `uuid` varchar(40) NOT NULL,
            ADD `trustbadge_advanced_configuration` tinyint(1) NOT NULL,
            ADD `review_advanced_configuration` tinyint(1) NOT NULL,
            ADD `products_reviews_advanced_configuration` tinyint(1) NOT NULL,
            ADD `rating_stars_advanced_configuration` tinyint(1) NOT NULL,
            ADD `display_trustbadge` tinyint(1) NOT NULL,
            ADD `display_shop_reviews` tinyint(1) NOT NULL,
            ADD `review_sticker_font` varchar(32) NOT NULL,
            ADD `number_of_reviews` varchar(32) NOT NULL,
            ADD `maximum_rating` double NOT NULL,
            ADD `site_review_background_color` varchar(7) NOT NULL,
            ADD `trigger_reviews_active` tinyint(1) NOT NULL,
            ADD `trigger_reviews_step` tinyint(1) NOT NULL,
            ADD `trigger_reviews_carriers` text NOT NULL,
            ADD `site_review_configuration_code` text NOT NULL,
            ADD `tick_first_reviews` tinyint(1) NOT NULL,
            ADD `tick_configure_trustedbadge` tinyint(1) NOT NULL,
            ADD `tick_configure_request` tinyint(1) NOT NULL');

    $languages = array('DE', 'EN', 'FR', 'PL');
    foreach ($languages as $language) {
        Configuration::deleteByName('TRUSTEDSHOPS_TRUSTBADGE_OPTIONS_LINK_'.$language);
        Configuration::deleteByName('TRUSTEDSHOPS_PRODUCT_REVIEW_INFORMATION_LINK_'.$language);
        Configuration::deleteByName('TRUSTEDSHOPS_INFORMATION_LINK_'.$language);
        Configuration::deleteByName('TRUSTEDSHOPS_HELP_LINK_'.$language);
    }

    // fix upgrade v1 to V2 to force display if variant not hide
    $querystr = 'SELECT id_ts_config FROM '._DB_PREFIX_.'trustedshopsintegration t';
    $tsConfigs = Db::getInstance()->executeS($querystr, true, false);
    foreach ($tsConfigs as $tsConfig) {
        $tsid = new TSID($tsConfig['id_ts_config']);
        if ($tsid->current_mode == '') {
            continue;
        }
        if ($tsid->variant != 'hide') {
            $tsid->display_trustbadge = 1;
        }
        if ($tsid->current_mode == 'expert') {
            $tsid->display_trustbadge = 1;
            $tsid->trustbadge_advanced_configuration = 1;
            $tsid->products_reviews_advanced_configuration = 1;
            $tsid->rating_stars_advanced_configuration = 1;
        }

        if (empty($tsid->review_sticker_font)) {
            $tsid->review_sticker_font = 'Arial';
        }
        if (empty($tsid->number_of_reviews)) {
            $tsid->number_of_reviews = 5;
        }
        if (empty($tsid->maximum_rating)) {
            $tsid->maximum_rating = '3.0';
        }
        if (empty($tsid->site_review_background_color)) {
            $tsid->site_review_background_color = '#ffdc0f';
        }
        if (empty($tsid->review_tab_border_color)) {
            $tsid->review_tab_border_color = '#0DBEDC';
        }
        if (empty($tsid->review_tab_star_color)) {
            $tsid->review_tab_star_color = '#FFDC0F';
        }
        if (empty($tsid->review_tab_background_color)) {
            $tsid->review_tab_background_color = '#FFFFFF';
        }
        if (empty($tsid->rating_star_color)) {
            $tsid->rating_star_color = '#FFDC0F';
        }
        if (empty($tsid->rating_star_size)) {
            $tsid->rating_star_size = '14';
        }
        if (empty($tsid->rating_font_size)) {
            $tsid->rating_font_size = '12';
        }
        if (empty($tsid->trustbadge_code)) {
            $tsid->trustbadge_code = '{"customElementId" : "", "trustcardDirection" : "", "customBadgeWidth" : "", "disableResponsive" : "", "disableTrustbadge": "", "variant" : "reviews", "yOffset" : "0"}';
        }
        if (empty($tsid->site_review_configuration_code)) {
            $tsid->site_review_configuration_code = '{"element": "#ts_review_sticker", "variant": "testimonial", "reviews": "5", "betterThan": "3.0", "richSnippets": "on", "backgroundColor": "#ffdc0f", "linkColor": "#000000", "quotationMarkColor": "#FFFFFF", "fontFamily": "Arial", "reviewMinLength": "10"}';
        }
        if (empty($tsid->product_sticker_code)) {
            $tsid->product_sticker_code = '{"variant" : "productreviews", "borderColor" : "#0DBEDC", "backgroundColor" : "#FFFFFF", "starColor" : "#FFDC0F", "starSize" : "15px", "richSnippets" : "on", "ratingSummary" : "false", "maxHeight" : "600px", "filter" : "true", "introtext" : ""}';
        }
        if (empty($tsid->product_widget_code)) {
            $tsid->product_widget_code = '{"starColor" : "#FFDC0F", "starSize" : "14px", "fontSize" : "12px", "showRating" : "false", "scrollToReviews" : "false", "enablePlaceholder" : "false"}';
        }

        $tsid->current_mode = '';
        $tsid->save();
    }

    return true; // Return true if success.
}

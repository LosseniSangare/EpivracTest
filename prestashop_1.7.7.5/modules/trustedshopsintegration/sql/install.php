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

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'trustedshopsintegration` (
  `id_ts_config` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(40) NOT NULL,
  `id_shop` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `api_lang` varchar(5) NOT NULL,
  `api_url` varchar(250) NOT NULL,
  `id_trusted_shops` varchar(40) NOT NULL,
  `display_trustbadge` tinyint(1) NOT NULL,
  `display_shop_reviews` tinyint(1) NOT NULL,
  `trustbadge_advanced_configuration` tinyint(1) NOT NULL,
  `review_advanced_configuration` tinyint(1) NOT NULL,
  `products_reviews_advanced_configuration` tinyint(1) NOT NULL,
  `rating_stars_advanced_configuration` tinyint(1) NOT NULL,
  `enable_rich_snippets` tinyint(1) NOT NULL,
  `enable_rich_snippets_listing` tinyint(1) NOT NULL,
  `enable_rich_snippets_product` tinyint(1) NOT NULL,
  `enable_rich_snippets_homepage` tinyint(1) NOT NULL,
  `variant` varchar(32) NOT NULL,
  `y_offset` int(11) NOT NULL,
  `review_sticker_font` varchar(32) NOT NULL,
  `number_of_reviews` varchar(32) NOT NULL,
  `maximum_rating` double NOT NULL,
  `site_review_background_color` varchar(7) NOT NULL,
  `trigger_reviews_active` tinyint(1) NOT NULL,
  `trigger_reviews_step` tinyint(1) NOT NULL,
  `trigger_reviews_carriers` text NOT NULL,
  `collect_reviews` tinyint(1) NOT NULL,
  `show_reviews` tinyint(1) NOT NULL,
  `show_rating` tinyint(1) NOT NULL,
  `review_tab_name` varchar(50) NOT NULL,
  `review_tab_border_color` varchar(7) NOT NULL,
  `review_tab_star_color` varchar(7) NOT NULL,
  `review_tab_background_color` varchar(7) NOT NULL,
  `hide_empty_reviews` int(11) NOT NULL,
  `rating_star_color` varchar(7) NOT NULL,
  `rating_star_size` double NOT NULL,
  `rating_font_size` double NOT NULL,
  `hide_empty_ratings` tinyint(1) NOT NULL,
  `trustbadge_code` text NOT NULL,
  `site_review_configuration_code` text NOT NULL,
  `product_sticker_code` text NOT NULL,
  `product_widget_code` text NOT NULL,
  `gtin_allocation` varchar(32) NOT NULL,
  `brand_allocation` varchar(32) NOT NULL,
  `mpn_allocation` varchar(32) NOT NULL,
  `tick_first_reviews` tinyint(1) NOT NULL,
  `tick_configure_trustedbadge` tinyint(1) NOT NULL,
  `tick_configure_request` tinyint(1) NOT NULL,
  `current_mode` varchar(32) NOT NULL,
  PRIMARY KEY (`id_ts_config`),
  UNIQUE KEY `id_trusted_shops` (`id_trusted_shops`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}

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

function upgrade_module_2_0_7($module)
{

    Db::getInstance()->execute('ALTER TABLE '._DB_PREFIX_.'trustedshopsintegration
            ADD `enable_rich_snippets` tinyint(1) NOT NULL,
            ADD `enable_rich_snippets_listing` tinyint(1) NOT NULL,
            ADD `enable_rich_snippets_product` tinyint(1) NOT NULL,
            ADD `enable_rich_snippets_homepage` tinyint(1) NOT NULL');

    return true; // Return true if success.
}

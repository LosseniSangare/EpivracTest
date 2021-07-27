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

function upgrade_module_1_0_2($module)
{

    $module->unregisterHook('displayBeforeBodyClosingTag') &&
    $module->unregisterHook('displayFooterProduct') &&
    $module->registerHook('displayFooter') &&
    $module->registerHook('displayProductButtons');

    return true; // Return true if success.
}

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

require_once dirname(__FILE__) . '/../parameters.php';
require_once dirname(__FILE__) . '/../classes/TrustedShopUtils.php';

function upgrade_module_2_0_8($module)
{
    // fix upgrade v1 to V2 to force display if variant not hide
    $querystr = 'SELECT id_ts_config, trustbadge_code FROM '._DB_PREFIX_.'trustedshopsintegration t';
    $tsConfigs = Db::getInstance()->executeS($querystr, true, false);

    $trustbadgeJSONArray = TSParameters::getDefaultTrustbadge();

    foreach ($tsConfigs as $tsConfig) {
        $tsid = new TSID($tsConfig['id_ts_config']);

        $trustbadge_code = TrustedShopUtils::compareJSON($trustbadgeJSONArray, $tsConfig['trustbadge_code']);
        $tsid->trustbadge_code = json_encode($trustbadge_code);
        $tsid->save();
    }

    return true; // Return true if success.
}

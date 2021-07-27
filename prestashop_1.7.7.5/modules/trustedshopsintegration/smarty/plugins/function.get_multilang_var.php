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

/**
 * Gets multilang variable.
 * @usage {$tsid|getGeneralHelpLink}
 * @param string $varName variable name
 * @param string $tsid Trusted Shops ID
 * @return string
*/

if (!function_exists('smarty_function_get_multilang_var')) {
    function smarty_function_get_multilang_var($params, &$smarty)
    {
        $varName = isset($params['varName']) ? $params['varName'] : '';
        $langID  = isset($params['langID']) ? (int) $params['langID'] : 0;
        $tsid    = isset($params['tsid']) ? $params['tsid'] : '';

        $availableVarName = array(
            'phone-number',
            'phone-number-test',
            'test-link',
            'trustbadge-link',
            'review-link',
            'price-link',
            'help-link',
            'upgrade-link',
            'review-sticker-link',
            'forgotten-password-link',
            'seo-profile-link',
            'sign-in-image',
            'contact-link',
            'cgu-link'
        );

        if (!in_array($varName, $availableVarName)) {
            return '#';
        }

        $multilang_vars = TSParameters::get();
        $context = Context::getContext();
        $lang_iso = ($langID == true) ? Language::getIsoById($langID) : $context->language->iso_code;

        // If lang is not supported, default to EN instead.
        if (!isset($multilang_vars[$varName][$lang_iso])) {
            if (isset($multilang_vars[$varName]['en'])) {
                $lang_iso = 'en';
            } else {
                return '#';
            }
        }
        $output = $multilang_vars[$varName][$lang_iso];

        // Search for dynamic parts in the output and replace them.
        $arrSearch = array('{tsid}', '{iso_lang}', '{ps_version}', '{plugin_version}');
        $arrReplace = array($tsid, $context->language->iso_code, Configuration::get('PS_INSTALL_VERSION'), '');
        $output = str_replace($arrSearch, $arrReplace, $output);

        return $output;
    }
}

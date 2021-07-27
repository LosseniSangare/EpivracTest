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
 * Smarty modifier to replace HTML tags in translations.
 * @usage {{l='test'}|totlreplace}
 * @param.value string
 * @param.name string
 */

if (!function_exists('smarty_modifier_totlreplace')) {
    function smarty_modifier_totlreplace($string, $replaces = array())
    {

        $search = array(
            '[b]',
            '[/b]',
            '[br]',
            '[em]',
            '[/em]',
            '[a]',
            '[/a]',
            '[small]',
            '[/small]',
            '[strong]',
            '[/strong]',
            '[i]',
            '[/i]'
        );
        $replace = array(
            '<b>',
            '</b>',
            '<br>',
            '<em>',
            '</em>',
            '<a href="@href@" @target@>',
            '</a>',
            '<small>',
            '</small>',
            '<strong>',
            '</strong>',
            '<i>',
            '</i>'
        );
        $string = str_replace($search, $replace, $string);
        foreach ($replaces as $k => $v) {
            $string = str_replace($k, $v, $string);
        }
        $string = str_replace(' @target@', '', $string);

        return $string;
    }
}

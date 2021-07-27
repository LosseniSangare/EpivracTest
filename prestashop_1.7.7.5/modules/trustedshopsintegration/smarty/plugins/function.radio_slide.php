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
 * Smarty function to display Prestashop switch.
 * @usage {radio_slide name='my_input_name' value=true dataAttr=''}
 * @param.value boolean
 * @param.name string
 * @param.dataAttr string optional
 */

if (!function_exists('smarty_function_radio_slide')) {
    function smarty_function_radio_slide($params, &$smarty)
    {
        $name  = $params['name'];
        $value = $params['value'];
        if (!isset($params['on'])) {
            $params['on'] = 'On';
        }
        if (!isset($params['off'])) {
            $params['off'] = 'Off';
        }
        if (isset($params['dataAttr'])) {
            $attr  = $params['dataAttr'];
        } else {
            $attr = false;
        }

        $output = '<span class="switch prestashop-switch fixed-width-lg" ' . ($attr ? 'data-' . $attr . '' : '')  . '>';
            $output .= '<input type="radio" name="' . $name . '" id="' . $name . '_on" value="1"' . ($value ? 'checked="checked"' : '')  . '>';
            $output .= '<label for="' . $name . '_on" class="radioCheck">'.$params['on'].'</label>';

            $output .= '<input type="radio" name="' . $name . '" id="' . $name . '_off" value="0"' . (!$value ? 'checked="checked"' : '')  . '>';
            $output .= '<label for="' . $name . '_off" class="radioCheck">'.$params['off'].'</label>';

            $output .= '<a class="slide-button btn"></a>';
        $output .= '</span>';

        return $output;
    }
}

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
 * Smarty function to display color input with colorpicker.
 * @usage {input_color name='my_input_name' value=true}
 * @param.value string
 * @param.name string
 */

if (!function_exists('smarty_function_input_color')) {
    function smarty_function_input_color($params, &$smarty)
    {
        $name  = $params['name'];
        $value = $params['value'];

        $output = '<div class="input-group color-picker fixed-width-lg">';
            $output .= '<input
                            class="mColorPicker"
                            id="'. $name . '"
                            data-hex="true"
                            type="text"
                            value="' . $value . '"
                            name="'. $name . '"
                            style="background-color: ' . $value . ';"
                  >';
            $output .= '</span>';
        $output .= '</div>';
        $output .= '<script>
            $("input#'.$name.'").mColorPicker({
                imageFolder: "../img/admin/"
            });
        </script>';

        return $output;
    }
}

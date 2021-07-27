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

require_once dirname(__FILE__) . '/tsid.php';

class TrustedShopUtils
{
    /**
     * Validates the configuration form.
     * @param String[] $existingFields Form Input fields
     * @return bool Validation result
     */
    public static function validateConfigurationForm($existingFields)
    {
        // Rules from the TS ID Config Object
        $rules = TSID::$definition;
        $errors = array();

        // Check every field for rule
        foreach ($rules['fields'] as $inputField => $rule) {
            if (!in_array($inputField, $existingFields)) {
                continue;
            }
            // the input value
            $ipValue = Tools::getValue($inputField);
            if ($rule['type'] == TSID::TYPE_INT) {
                if (!Validate::isInt($ipValue) && $ipValue != '') {
                    $errors[] = self::error($inputField, TSID::TYPE_INT);
                }
            }
            if ($rule['type'] == TSID::TYPE_STRING || $rule['type'] == TSID::TYPE_HTML) {
                // Color in field name, check for hex color value
                if (strpos($inputField, 'color') !== false) {
                    if (self::isHexColor($ipValue) === false) {
                        $errors[] = self::error($inputField, 'hex');
                        continue;
                    }
                }
                if (!Validate::isString($ipValue)) {
                    $errors[] = self::error($inputField, TSID::TYPE_STRING);
                }
            }
        }
        if (!empty($errors)) {
            return $errors;
        }
        return true;
    }

    /**
     * Translation for error reports
     * @param string $field input field name
     * @param int $expectedType expected type
     * @return string error message
     */
    public static function error($field, $expectedType)
    {
        $strError = $field.' : ';
        if ($expectedType == TSID::TYPE_STRING) {
            $strError .= 'Please enter a valid string.';
        }
        if ($expectedType == TSID::TYPE_INT) {
            $strError .= 'Please enter a valid number.';
        }
        if ($expectedType == 'hex') {
            $strError .= 'Please enter a valid hex color.';
        }
        if ($expectedType == 'json') {
            $strError .= 'Please enter a valid JSON configuration.';
        }

        return $strError;
    }

    /**
     * Is a value a valid hex color?
     *
     * @param $ip input value
     */
    public static function isHexColor($ip)
    {
        if (preg_match('/^#[a-f0-9]{6}$/i', $ip) || $ip == '') {
            return true;
        }
        return false;
    }

    public static function isJson($string)
    {
        json_decode(self::getRealJSON($string));
        if (json_last_error() == JSON_ERROR_NONE) {
            return json_decode(self::getRealJSON($string));
        } else {
            return false;
        }
    }

    public static function getRealJSON($json)
    {
        return str_replace("'", '"', $json);
    }

    public static function compareJSON($standard_json, $send_json)
    {
        $decode_send_json = (array)json_decode($send_json);
        $missing_fields = array_diff_key($standard_json, $decode_send_json);
        $json = array_merge($decode_send_json, $missing_fields);

        return $json;
    }
}

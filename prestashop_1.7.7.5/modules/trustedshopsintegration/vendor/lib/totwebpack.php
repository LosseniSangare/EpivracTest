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

require_once dirname(__FILE__) . '/../../views/assets-manifest.php';

class TotWebpack
{
    public static function getCSSByName($name = 'back')
    {
        $cssFiles = WebpackBuiltFiles::$cssFiles;
        foreach ($cssFiles as $cssFile) {
            if (strpos($cssFile, $name)) {
                return $cssFile;
            }
        }
    }

    public static function getJSByName($name = 'back')
    {
        $jsFiles = WebpackBuiltFiles::$jsFiles;
        foreach ($jsFiles as $jsFile) {
            if (strpos($jsFile, $name)) {
                return $jsFile;
            }
        }
    }
}

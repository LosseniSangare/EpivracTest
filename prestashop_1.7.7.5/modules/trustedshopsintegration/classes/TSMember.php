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

require_once 'Api/TSApiClient.php';

class TSMember
{
    /**
     * @desc Check if user has access and complete tsconfig
     *
     * @param boolean
     */
    public static function hasAccess()
    {
        $uuid = Configuration::get('TRUSTEDSHOPS_MEMBER_UUID');
        if (!empty($uuid)
            && Configuration::get('TRUSTEDSHOPS_MEMBER_FAILED') == 0
            && isset($_SESSION['TRUSTEDSHOPS_SHOPS'])) {
            return true;
        }
        $ts_credentials = Configuration::get('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
        if ($ts_credentials == false) {
            return false;
        }
        $client = new TSApiClient();
        $webservice = $client->getWrapper('memberships');
        $webservice->setCredentials($ts_credentials);
        $client->call($webservice);

        if ($client->getResponse()->isSuccess() == false
            && Configuration::get('TRUSTEDSHOPS_MEMBER_TRIAL') == 'TRIAL') {
            Configuration::updateValue('TRUSTEDSHOPS_MEMBER_TRIAL', 'EXPIRED_TRIAL');
            return false;
        } elseif ($client->getResponse()->isSuccess() == false) {
            return false;
        }

        $content = $client->getResponse()->getContent();
        Configuration::updateValue('TRUSTEDSHOPS_MEMBER_UUID', $content['retailer']['memberships'][0]['uuid']);
        $status = 'NO_TRIAL';
        foreach ($content['retailer']['memberships'][0]['serviceItems'] as $item) {
            if ($item['type'] == 'MEMBERSHIP_TRIAL') {
                $status = 'TRIAL';
                break;
            }
        }
        Configuration::updateValue('TRUSTEDSHOPS_MEMBER_TRIAL', $status);

        $webservice = $client->getWrapper('shops');
        $webservice->setCredentials($ts_credentials);
        $client->call($webservice);
        $response = $client->getResponse();
        $shops = $response->getContent();
        if (!is_array($shops)) {
            // API unavailable
            return false;
        }
        $shops = $shops['retailer']['shops'];
        $_SESSION['TRUSTEDSHOPS_SHOPS'] = $shops;
        foreach ($shops as $shop) {
            $idTsConfig = TSID::getTSId($shop['tsId']);
            if ($idTsConfig == true) {
                $tsid = new TSID($idTsConfig);
                // fix upgrade v1 to V2 to force display if variant not hide
                if ($tsid->current_mode != '') {
                    if ($tsid->variant != 'hide') {
                        $tsid->display_trustbadge = 1;
                    }
                    if ($tsid->current_mode == 'expert') {
                        $tsid->display_trustbadge = 1;
                        $tsid->trustbadge_advanced_configuration = 1;
                        $tsid->products_reviews_advanced_configuration = 1;
                        $tsid->rating_stars_advanced_configuration = 1;
                    }
                    $tsid->current_mode = '';
                }
            } else {
                $tsid = new TSID();
                // check if id_lang exists
                $idLang = Language::getIdByIso($shop['languageISO2']);
                if (!$idLang) {
                    continue;
                }
                $idShop = self::domainExists($shop['url']);
                $tsid->id_lang = $idLang;
                $tsid->id_shop = $idShop;
                $tsid->id_trusted_shops = $shop['tsId'];
                $tsid->api_url = $shop['url'];
                $tsid->api_lang = $shop['languageISO2'];
            }
            $tsid->uuid = Configuration::get('TRUSTEDSHOPS_MEMBER_UUID');
            $tsid->save();
        }

        return true;
    }

    /**
     * @desc get id_shop from domain
     * @param string $domain domain return by API
     *
     * @return int id of the shop
     */
    private static function domainExists($domain)
    {
        $query = new DbQuery();
        $query->select('id_shop');
        $query->from('shop_url');
        $query->where('domain="'.pSQL($domain).'"');

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query->build());
        if ($result != null) {
            return $result;
        }

        return 0;
    }
}

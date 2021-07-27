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

class TSParameters
{
    public static function get()
    {
        $parameters = array(
            'phone-number' => array(
                'en' => '+44 (0) 203 364 5906',
                'fr' => '01 70 70 70 50',
                'de' => '+49 (0) 221 77 53 65 8',
                'pl' => '+48 22 462 64 07',
                'it' => '+39 029 47 54 586',
            ),
            'phone-number-test' => array(
                'en' => '+44 (0) 203 364 5906',
                'fr' => '03 22 33 49 00',
                'de' => '+49 (0) 221 77 53 65 8',
                'pl' => '+48 22 462 64 07',
                'it' => '+39 029 47 54 586',
            ),
            'test-link' => array(
                'en' => 'https://www.trustedshops.com/reviewsticker/preview',
            ),
            'review-sticker-link' => array(
                'en' => 'https://www.trustedshops.com/reviewsticker/preview',
            ),
            'trustbadge-link' => array(
                'de' => 'http://www.trustedshops.de/shopbetreiber/integration/trustbadge/trustbadge-custom/',
                'en' => 'http://www.trustedshops.co.uk/support/trustbadge/trustbadge-custom/',
                'fr' => 'http://www.trustedshops.fr/support/trustbadge/trustbadge-custom/',
                'pl' => 'http://www.trustedshops.pl/handlowcy/integracja/trustbadge/trustbadge-custom/',
                'it' => 'https://www.trustedshops.it/venditori/integrazione/trustbadge/trustbadge-custom/',
            ),
            'review-link' => array(
                'de' => 'http://www.trustedshops.de/shopbetreiber/integration/product-reviews/',
                'en' => 'http://www.trustedshops.co.uk/support/product-reviews/',
                'fr' => 'http://www.trustedshops.fr/support/integrer-les-avis-produits/',
                'pl' => 'http://www.trustedshops.pl/handlowcy/integracja/integracja-opinii-o-produktach',
                'it' => 'https://www.trustedshops.it/features/recensioni-di-prodotto/',
            ),
            'price-link' => array(
                'de' => 'http://www.trustedshops.de/shopbetreiber/bestellen.html/?a_aid=546a2b2c79731&a_bid=0a270ca8',
                'en' => 'http://business.trustedshops.co.uk/pricing/?a_aid=546a2b2c79731&a_bid=0a270ca8',
                'fr' => 'http://business.trustedshops.fr/tarifs/?a_aid=546a2b2c79731&a_bid=0a270ca8',
                'pl' => 'https://www.trustedshops.pl/handlowcy/zamowienie.html?a_aid=546a2b2c79731&a_bid=0a270ca8',
            ),
            'help-link' => array(
                'de' => 'http://support.trustedshops.com/de/apps/prestashop?utm_source=shopsoftwarebackend&utm_medium=link&utm_term=de&utm_campaign=shopsoftware&utm_content=PRESTASHOP&shop_id={tsid}&backend_language={iso_lang}&shopsw=prestashop&shopsw_version={ps_version}&plugin_version={plugin_version}&context=trustbadge&Google_Analytics',
                'en' => 'http://support.trustedshops.com/en/apps/prestashop?utm_source=shopsoftwarebackend&utm_medium=link&utm_term=en&utm_campaign=shopsoftware&utm_content=PRESTASHOP&shop_id={tsid}&backend_language={iso_lang}&shopsw=prestashop&shopsw_version={ps_version}&plugin_version={plugin_version}&context=trustbadge&Google_Analytics',
                'fr' => 'http://support.trustedshops.com/fr/apps/prestashop?utm_source=shopsoftwarebackend&utm_medium=link&utm_term=fr&utm_campaign=shopsoftware&utm_content=PRESTASHOP&shop_id={tsid}&backend_language={iso_lang}&shopsw=prestashop&shopsw_version={ps_version}&plugin_version={plugin_version}&context=trustbadge&Google_Analytics',
                'pl' => 'http://support.trustedshops.com/pl/apps/prestashop?utm_source=shopsoftwarebackend&utm_medium=link&utm_term=pl&utm_campaign=shopsoftware&utm_content=PRESTASHOP&shop_id={tsid}&backend_language={iso_lang}&shopsw=prestashop&shopsw_version={ps_version}&plugin_version={plugin_version}&context=trustbadge&Google_Analytics',
            ),
            'upgrade-link' => array(
                'de' => 'https://business.trustedshops.de/preise/',
                'en' => 'https://business.trustedshops.co.uk/pricing/',
                'fr' => 'https://business.trustedshops.fr/tarifs/',
                'pl' => 'https://www.trustedshops.pl/handlowcy/zamowienie.html?a_aid=546a2b2c79731&a_bid=0a270ca8',
            ),
            'forgotten-password-link' => array(
                'de' => 'https://www.trustedshops.com/de/shop/login.html',
                'en' => 'https://www.trustedshops.com/en/shop/login.html',
                'fr' => 'https://www.trustedshops.com/fr/shop/login.html',
                'pl' => 'https://www.trustedshops.com/pl/shop/login.html',
            ),
            'seo-profile-link' => array(
                'at' => 'https://www.trustedshops.at/bewertung/info_{tsid}.html',
                'be-fr' => 'https://www.trustedshops.be/fr/evaluation/info_{tsid}.html',
                'be-nl' => 'https://www.trustedshops.be/nl/verkopersbeoordeling/info_{tsid}.html',
                'ch' => 'https://www.trustedshops.ch/bewertung/info_{tsid}.html',
                'de' => 'https://www.trustedshops.de/bewertung/info_{tsid}.html',
                'en' => 'https://www.trustedshops.co.uk/buyerrating/info_{tsid}.html',
                'es' => 'https://www.trustedshops.es/evaluacion/info_{tsid}.html',
                'fr' => 'https://www.trustedshops.fr/evaluation/info_{tsid}.html',
                'it' => 'https://www.trustedshops.it/valutazione-del-negozio/info_{tsid}.html',
                'nl' => 'https://www.trustedshops.nl/verkopersbeoordeling/info_{tsid}.html',
                'pl' => 'https://www.trustedshops.pl/opinia/info_{tsid}.html'
            ),
            'contact-link' => array(
                'de' => 'https://business.trustedshops.de/kontakt/',
                'en' => 'https://business.trustedshops.co.uk/contact/',
                'fr' => 'https://business.trustedshops.fr/contact/',
                'pl' => 'http://www.trustedshops.pl/handlowcy/kontakt/',
            ),
            'sign-in-image' => array(
                'de' => 'aside_sign-in_DE.png',
                'en' => 'aside_sign-in_EN.png',
                'fr' => 'aside_sign-in_FR.png',
                'pl' => 'aside_sign-in_PL.png'
            ),
            'cgu-link' => array(
                'de' => 'http://www.trustedshops.com/tsdocument/TS_PRIME_TIME_MEMBERSHIP_TERMS_de_DEU.pdf',
                'en' => 'http://www.trustedshops.com/tsdocument/TS_PRIME_TIME_TERMS_en_EUO.pdf',
                'fr' => 'http://www.trustedshops.com/tsdocument/TS_PRIME_TIME_TERMS_fr_EUO.pdf',
                'pl' => 'http://www.trustedshops.com/tsdocument/TS_PRIME_TIME_TERMS_pl.pdf',
            ),
            'php-version-min' => array(
                'de' => 'http://support.trustedshops.com/de/apps/prestashop/PHP5.4',
                'en' => 'http://support.trustedshops.com/en/apps/prestashop/PHP5.4',
                'fr' => 'http://support.trustedshops.com/fr/apps/prestashop/PHP5.4',
                'pl' => 'http://support.trustedshops.com/pl/apps/prestashop/PHP5.4',
            ),
        );

        return $parameters;
    }

    public static function getDefaultTrustbadge()
    {
        $trustbadgeJSONArray = array(
            'customElementId' => '',
            'trustcardDirection' => '',
            'customBadgeWidth' => '',
            'disableResponsive' => '',
            'disableTrustbadge' => '',
            'variant' => 'reviews',
            'yOffset' => 0,
            "responsive" => array(
                "variant" => "default"
            )
        );

        return $trustbadgeJSONArray;
    }
}

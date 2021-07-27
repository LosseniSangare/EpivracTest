<?php
/**
 * 2016-2021 Trusted Shops GmbH
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
 */

require_once 'Api/TSApiClient.php';

class TSSnippets
{

    public function getSnippets($id)
    {
        $response = $this->getInfoApi($id);
        $content = $response['response']['data'];
        $count = $content['shop']['qualityIndicators']['reviewIndicator']['activeReviewCount'];
        if ($count < 1) {
            return false;
        }

        $tpl_vars = array(
            'result' =>$content['shop']['qualityIndicators']['reviewIndicator']['overallMark'],
            'count' => $count,
            'shopName' => $content['shop']['name'],
            'max' => "5.00"
        );
        $context = Context::getContext();
        $context->smarty->assign($tpl_vars);

        return $context->smarty->fetch(dirname(__FILE__).'/../views/templates/hook/product_rich_snippets_js.tpl');
    }

    public function getInfoApi($tsId)
    {

        $ts_credentials = Configuration::get('TRUSTEDSHOPS_MEMBER_CREDENTIALS');

        if ($ts_credentials == false) {
            return false;
        }
        $client = new TSApiClient();

        $webservice = $client->getWrapper('richsnippets');
        $webservice->setTsId($tsId);
        $webservice->setCredentials($ts_credentials);

        $client->call($webservice);

        if ($client->getResponse()->isSuccess() == false) {
            return false;
        }

        return $client->getResponse()->getContent();
    }
}

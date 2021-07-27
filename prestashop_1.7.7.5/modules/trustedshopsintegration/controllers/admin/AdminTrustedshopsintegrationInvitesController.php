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

require_once 'AdminTrustedshopsintegrationDefaultController.php';

require_once dirname(__FILE__) . '/../../classes/tsid.php';

class AdminTrustedshopsintegrationInvitesController extends AdminTrustedshopsintegrationDefaultController
{
    /**
     * @desc constructor to init invites behaviours
     */
    public function __construct()
    {
        parent::__construct();
        $this->name = 'trustedshopsintegration';
        $this->currentPage = 'invites';

        $this->client = new TSApiClient();
        $this->template = 'index.tpl';
        $this->bootstrap = true;
        $this->meta_title = $this->l('Trusted Shops - Reviews');
        $this->homeUrl = $this->context->link->getAdminLink('AdminTrustedshopsintegrationHome');

        $this->productShoppingAttributes = array('gtin', 'mpn', 'brand');
    }

    public function initContent()
    {
        parent::init();
        if (Tools::getValue('invites_step') && !empty(Tools::getValue('invites_step'))) {
            $step = Tools::getValue('invites_step');
        } else {
            $step = null;
        }

        switch ($step) {
            case "step1":
                return $this->renderStep1();
            case "step2":
                $orders = $this->validate();
                if (count($this->errors)) {
                    return $this->renderStep1();
                }

                return $this->renderStep2($orders);
            case "step3":
                $orders = $this->validate();
                if (count($this->errors)) {
                    return $this->renderStep1();
                }
                return $this->renderStep3($orders);

            case "step4":
                $orders = $this->validate();
                if (count($this->errors)) {
                    return $this->renderStep1();
                }
                if (Tools::getValue('invites') == false || count(Tools::getValue('invites')) == 0) {
                    $this->errors['step4'] = $this->l('Please select an order.');
                    return $this->renderStep3($orders);
                }

                return $this->renderStep4($orders);
            case "step5":
                $orders = $this->validate();
                if (count($this->errors)) {
                    return $this->renderStep1();
                }
                if (Tools::getValue('invites') == false || count(Tools::getValue('invites')) == 0) {
                    $this->errors['step4'] = $this->l('Please select an order.');
                    return $this->renderStep3($orders);
                }

                return $this->renderStep5($orders);
            case "thanks":
                return $this->renderThanks();
            case "preview":
                return $this->renderPreview();
            default:
                return $this->renderInvites();
        }

        return parent::initContent();
    }

    private function renderInvites()
    {
        $this->template = 'index.tpl';
        $availableOrderStatus = OrderState::getOrderStates($this->context->language->id);
        $this->context->smarty->assign('availableOrderStatus', $availableOrderStatus);
        $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));

        //$carriers = Carrier::getCarriers($this->context->language->id, true);
        $carriers = Carrier::getCarriers($this->context->language->id, true, false, false, null, Carrier::ALL_CARRIERS);
        $ids = array();
        foreach ($carriers as $carrier) {
            $ids[] = $carrier['id_carrier'];
        }

        $query = new DbQuery();
        $query->select('id_carrier');
        $query->from('carrier_shop');
        $query->where('id_carrier IN ('.pSQL(implode(',', $ids)).') AND id_shop = '.(int) $tsconfig->id_shop);

        $expectedCarriers = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query->build());
        $ids = array();
        foreach ($expectedCarriers as $expectedCarrier) {
            $ids[] = $expectedCarrier['id_carrier'];
        }
        foreach ($carriers as $key => $carrier) {
            if (!in_array($carrier['id_carrier'], $ids)) {
                unset($carriers[$key]);
            }
        }
        $this->context->smarty->assign('carriers', $carriers);
        $triggerReviewsCarriers = array();
        if (!empty($tsconfig->trigger_reviews_carriers)) {
            $triggerReviewsCarriers = json_decode($tsconfig->trigger_reviews_carriers, true);
        }
        $this->context->smarty->assign('tsconfig', $tsconfig);
        if (!empty(Tools::getValue('submit')) || !empty(Tools::getValue('submit_and_stay'))) {
            if (!empty(Tools::getValue('trigger_reviews_carriers'))) {
                foreach (Tools::getValue('trigger_reviews_carriers') as $key => $triggerReviewsCarrier) {
                    $triggerReviewsCarriers[$key] = (int) $triggerReviewsCarrier;
                }
            }
            $this->context->smarty->assign('trigger_reviews_active', (int) Tools::getValue('trigger_reviews_active'));
            $this->context->smarty->assign('trigger_reviews_step', (int) Tools::getValue('trigger_reviews_step'));
            $tsconfig->trigger_reviews_step = (int) Tools::getValue('trigger_reviews_step');
            $tsconfig->trigger_reviews_active = (int) Tools::getValue('trigger_reviews_active');
            $tsconfig->trigger_reviews_carriers = json_encode($triggerReviewsCarriers);
            $tsconfig->save();
            if (!empty(Tools::getValue('submit'))) {
                Tools::redirectAdmin($this->homeUrl);
            }
            $triggerReviewsCarriers = json_decode($tsconfig->trigger_reviews_carriers, true);
        }
        if (!empty($tsconfig->trigger_reviews_carriers)) {
            $this->context->smarty->assign('trigger_reviews_carriers', $triggerReviewsCarriers);
        } else {
            $triggerReviewsCarriers = array();
            $this->context->smarty->assign('trigger_reviews_carriers', $triggerReviewsCarriers);
        }
        $this->context->smarty->assign('trigger_reviews_carriers', $triggerReviewsCarriers);

        $this->content = $this->renderView();

        return parent::initContent();
    }

    private function renderThanks()
    {
        $this->context->smarty->assign('invitesCount', (int) Tools::getValue('count'));
        $this->template = 'thanks.tpl';
        $this->content = $this->renderView();

        return parent::initContent();
    }

    /**
     * @desc validate criteria
     */
    private function validate()
    {
        $orders = array();
        if (empty(Tools::getValue('orders_last'))) {
            $this->errors['orders_last'] = $this->l('Please select a send invites duration.');
        }
        if (Tools::getValue('payments') == false || count(Tools::getValue('payments')) == 0) {
            $this->errors['payments'] = $this->l('Please select an order state.');
        } else {
            $status = implode(', ', Tools::getValue('payments'));
            $tsIdConfig = Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG');
            $orders = $this->getSelectedOrders(Tools::getValue('orders_last'), $status, $tsIdConfig);
            if (count($orders) == 0) {
                $this->errors['orders'] = $this->l('No orders corresponding to your criteria.');
            }
        }

        return $orders;
    }

    /**
     * @desc display step 1
     */
    private function renderStep1()
    {
        $this->template = 'invites_step1.tpl';
        $availableOrderStatus = OrderState::getOrderStates($this->context->language->id);
        $this->context->smarty->assign('availableOrderStatus', $availableOrderStatus);
        $this->context->smarty->assign('orders_last', Tools::getValue('orders_last'));
        $this->context->smarty->assign('retrieve_reviews', Tools::getValue('retrieve_reviews'));
        $this->content = $this->renderView();

        return parent::initContent();
    }

    /**
     * @desc display step 2
     */
    private function renderStep2($orders)
    {
        $this->template = 'invites_step2.tpl';

        $orderDate = explode(' ', $orders[0]['date_add']);

        $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));
        $data = array();
        $data['tsId'] = $tsconfig->id_trusted_shops;
        $data['shopName'] = Configuration::get('PS_SHOP_NAME');
        $data['targetMarket'] = 'test';
        $data['language'] = $this->context->language->iso_code;
        $data['orderDate'] = $orderDate[0];
        $data['shopOrderId'] = $orders[0]['reference'];
        $data['firstName'] = 'firstName';
        $data['lastName'] = 'lastName';
        $data['variant'] = 1;

        $webservice = $this->client->getWrapper('generator');
        $credentials = Configuration::get('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
        $webservice->setCredentials($credentials)
                    ->setTsId($data['tsId'])
                    ->setInput($data);
        $this->client->call($webservice);
        $response = $this->client->getResponse();

        foreach ($response->getErrors() as $error) {
            $this->errors[] = $error;
        }

        $content = preg_replace("#url\('(.+)'\)#", "url($1)", $response->getContent());
        $content = str_replace("'", '’', $content);

        $this->context->smarty->assign('emailContent', $content);
        $this->context->smarty->assign('orders_last', Tools::getValue('orders_last'));
        $this->context->smarty->assign('payments', Tools::getValue('payments'));
        $this->context->smarty->assign('retrieve_reviews', Tools::getValue('retrieve_reviews'));

        $this->content = $this->renderView();

        return parent::initContent();
    }

    /**
     * @desc display preview
     */
    private function renderPreview()
    {
        $this->template = 'preview.tpl';
        $status = implode(', ', Tools::getValue('payments'));
        $tsIdConfig = Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG');
        $orders = $this->getSelectedOrders(
            Tools::getValue('orders_last'),
            $status,
            $tsIdConfig,
            Tools::getValue('id_order')
        );

        $orderDate = explode(' ', $orders[0]['date_add']);

        $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));
        $data = array();
        $data['tsId'] = $tsconfig->id_trusted_shops;
        $data['shopName'] = Configuration::get('PS_SHOP_NAME');
        $data['targetMarket'] = 'test';
        $data['language'] = $this->context->language->iso_code;
        $data['orderDate'] = $orderDate[0];
        $data['shopOrderId'] = $orders[0]['reference'];
        $data['firstName'] = $orders[0]['firstname'];
        $data['lastName'] = $orders[0]['lastname'];
        $data['variant'] = 1;

        $webservice = $this->client->getWrapper('generator');
        $credentials = Configuration::get('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
        $webservice->setCredentials($credentials)
                    ->setTsId($data['tsId'])
                    ->setInput($data);
        $this->client->call($webservice);
        $this->context->smarty->assign('errors', $this->client->getResponse()->getErrors());
        $response = $this->client->getResponse();
        $content = preg_replace("#url\('(.+)'\)#", "url($1)", $response->getContent());
        $content = str_replace("'", '’', $content);
        $this->content = $content;

        return parent::initContent();
    }

    /**
     * @desc display step 3
     */
    private function renderStep3($orders)
    {
        $this->template = 'invites_step3.tpl';

        $this->context->smarty->assign('orders_last', Tools::getValue('orders_last'));
        $this->context->smarty->assign('payments', Tools::getValue('payments'));
        $this->context->smarty->assign('retrieve_reviews', Tools::getValue('retrieve_reviews'));
        $this->context->smarty->assign('orders', $orders);
        $this->content = $this->renderView();

        return parent::initContent();
    }

    /**
     * @desc display step 4
     */
    private function renderStep4($orders)
    {
        $this->template = 'invites_step4.tpl';

        $this->context->smarty->assign('orders_last', Tools::getValue('orders_last'));
        $this->context->smarty->assign('payments', Tools::getValue('payments'));
        $this->context->smarty->assign('retrieve_reviews', Tools::getValue('retrieve_reviews'));
        $this->context->smarty->assign('invites', Tools::getValue('invites'));
        $this->context->smarty->assign('orders', $orders);
        $this->content = $this->renderView();

        return parent::initContent();
    }

    /**
     * @desc display step 5
     */
    private function renderStep5($orders)
    {
        $this->template = 'invites_step4.tpl';

        $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));
        $datas = array();
        $data = array();
        $key = 0;
        #$trigger_infos = TSID::getTriggerInfos($uuid, $id_shop, $id_lang);
        foreach ($orders as $order) {
            if (!in_array($order['id_order'], Tools::getValue('invites'))) {
                continue;
            }
            $newOrder = new Order($order['id_order']);

            if (Configuration::get('PS_SSL_ENABLED') || Tools::usingSecureMode()) {
                $protocol_link = 'https://';
            } else {
                $protocol_link = 'http://';
            }

            if ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED'))
                || Tools::usingSecureMode()) {
                $protocol_content = 'https://';
            } else {
                $protocol_content = 'http://';
            }

            $link = new Link($protocol_link, $protocol_content);

            $orderDate = explode(' ', $newOrder->date_add);
            $deliveryDate = explode(' ', $newOrder->delivery_date);

            $datas[$key]['template']['variant'] = 'DEFAULT_TEMPLATE';
            $datas[$key]['order']['orderReference'] = $newOrder->reference;
            $datas[$key]['order']['amount'] = $newOrder->total_paid;
            $datas[$key]['order']['currency'] = $this->getOrderCurrency($newOrder->id_currency);
            $datas[$key]['order']['paymentType'] = $newOrder->module;
            $datas[$key]['order']['orderDate'] = $orderDate[0];
            if ($deliveryDate[0] == "0000-00-00") {
                $datas[$key]['reminderDate'] = $orderDate[0];
                $datas[$key]['order']['estimatedDeliveryDate'] = $orderDate[0];
            } else {
                $datas[$key]['reminderDate'] = $deliveryDate[0];
                $datas[$key]['order']['estimatedDeliveryDate'] = $deliveryDate[0];
            }

            if (Tools::getValue('retrieve_reviews') == true) {
                $tsconfig2 = $this->getTSConfig();
                $orderProducts = $newOrder->getProducts();
                $cmpt = 0;
                foreach ($orderProducts as $product) {
                    $productObj = new Product($product['product_id'], false, $tsconfig->id_lang);
                    $imagePath = $link->getImageLink(
                        $productObj->link_rewrite,
                        $product['image']->id_image
                    );
                    $datas[$key]['order']['products'][$cmpt]['name'] = $product['product_name'];
                    $datas[$key]['order']['products'][$cmpt]['imageUrl'] = $imagePath;
                    if ($product['reference'] != false) {
                        $datas[$key]['order']['products'][$cmpt]['sku'] = $product['reference'];
                    } else {
                        $datas[$key]['order']['products'][$cmpt]['sku'] = $product['product_id'];
                    }
                    if ($this->getProductShoppingAttribute('mpn', $product, $tsconfig2) == false) {
                        $datas[$key]['order']['products'][$cmpt]['mpn'] = $product['product_upc'];
                    } else {
                        $datas[$key]['order']['products'][$cmpt]['mpn'] = $this->getProductShoppingAttribute(
                            'mpn',
                            $product,
                            $tsconfig2
                        );
                    }
                    $datas[$key]['order']['products'][$cmpt]['gtin'] = $product['product_ean13'];
                    $datas[$key]['order']['products'][$cmpt]['brand'] = Manufacturer::getNameById(
                        $product['id_manufacturer']
                    );
                    $datas[$key]['order']['products'][$cmpt]['url'] = $link->getProductLink(
                        (int)$product['product_id']
                    );
                    $cmpt++;
                }
            }
            $customer = new Customer($newOrder->id_customer);
            $datas[$key]['consumer']['contact']['email'] = $customer->email;
            $datas[$key]['consumer']['contact']['firstName'] = $customer->firstname;
            $datas[$key]['consumer']['contact']['lastName'] = $customer->lastname;
            $key++;
        }

        $data['reviewCollectorRequest']['reviewCollectorReviewRequests'] = $datas;
        $tsconfig2 = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));

        TrustedShopsIntegration::Log('==MANUAL INVITES==');
        TrustedShopsIntegration::Log($data);
        $credentials = Configuration::get('TRUSTEDSHOPS_MEMBER_CREDENTIALS');
        $client = new TSApiClient();
        $webservice = $client->getWrapper('reviewcollector')
                                    ->setCredentials($credentials)
                                    ->setTsId($tsconfig->id_trusted_shops)
                                    ->setInput($data);

        $client->call($webservice);
        TrustedShopsIntegration::Log('MANUAL INVITES ERRORS');
        TrustedShopsIntegration::Log($client->getResponse()->getErrors());
        TrustedShopsIntegration::Log('MANUAL INVITES CONTENT');
        TrustedShopsIntegration::Log($client->getResponse()->getContent());

        if ($client->getResponse()->isSuccess()) {
            $tsconfig->tick_first_reviews = 1;
            $tsconfig->save();
            Tools::RedirectAdmin(
                $this->context->link->getAdminLink('AdminTrustedshopsintegrationInvites').'&invites_step=thanks&count=' . count(Tools::getValue('invites'))
            );
        }
        $this->errors = $client->getResponse()->getErrors();
        $this->context->smarty->assign('orders_last', Tools::getValue('orders_last'));
        $this->context->smarty->assign('payments', Tools::getValue('payments'));
        $this->context->smarty->assign('invites', Tools::getValue('invites'));
        $this->context->smarty->assign('retrieve_reviews', Tools::getValue('retrieve_reviews'));
        $this->context->smarty->assign('orders', $orders);
        $this->content = $this->renderView();


        return parent::initContent();
    }



    /**
     * @desc Get orders by step
     */
    private function getTSConfig($be = false)
    {
         $tsconfig = new TSID(Configuration::get('TRUSTEDSHOPS_CURRENT_ID_CONFIG'));
        if ($be === false) {
            $query = new DbQuery();
            $query->select('*');
            $query->from('trustedshopsintegration');
            $where = 'id_shop = "'.(int)$this->context->shop->id.'" AND id_lang = "'.(int)$tsconfig->id_lang.'"';
        } else {
            $id_ts_config = pSQL(Tools::getValue('id_ts_config'));
            $query = new DbQuery();
            $query->select('*');
            $query->from('trustedshopsintegration');
            $where = 'id_ts_config = "'.pSQL($id_ts_config).'"';
        }
        if (Configuration::get('TRUSTEDSHOPS_MEMBER_UUID')) {
            $where .= ' AND uuid = "'.pSQL(Configuration::get('TRUSTEDSHOPS_MEMBER_UUID')).'"';
        }
        $query->where($where);

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query->build(), false);
        return $result;
    }

    private function getSelectedOrders($days, $orderStatus, $idTsConfig, $orderId = null)
    {
        $query = new DbQuery();
        $query->select(
            'c.email,
            c.firstname,
            c.lastname,
            o.id_order,
            o.reference,
            o.total_paid,
            o.delivery_date,
            osl.name,
            ts.id_ts_config,
            ts.id_trusted_shops,
            o.date_add,
            ts.id_lang'
        );
        $query->from('orders', 'o');
        $query->innerJoin('customer', 'c', 'c.id_customer = o.id_customer');
        $query->innerJoin('address', 'a', 'a.id_address = o.id_address_delivery');
        $query->innerJoin('trustedshopsintegration', 'ts', 'ts.id_shop = o.id_shop AND ts.id_lang = o.id_lang');
        $query->innerJoin('order_state_lang', 'osl', 'osl.id_order_state = o.current_state AND osl.id_lang = '.(int) $this->context->language->id);
        $where = 'o.date_add > DATE_SUB(CURRENT_DATE, INTERVAL '.(int) $days.' DAY)';
        $where .= ' AND o.current_state IN ('.pSQL($orderStatus).')';
        $where .= ' AND ts.id_ts_config = '.pSQL($idTsConfig);

        if ($orderId != null) {
            $where .= " AND o.id_order= " . (int) $orderId;
        }
        $query->where($where);
        $query->limit(1000);

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query->build());
    }

    private function getFeature($id_feature, $id_product)
    {
        $query = new DbQuery();
        $query->select('fvl.value');
        $query->from('feature_value_lang', 'fvl');
        $query->innerJoin('feature_product', 'fp', 'fvl.id_feature_value = fp.id_feature_value');
        $query->where('fp.id_feature = '.(int)$id_feature.'
                       AND fvl.id_lang = '.(int)$this->context->language->id.'
                       AND fp.id_product = '.(int)$id_product);

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query->build(), false);
    }

    private function getProductShoppingAttribute($type, $objProduct, $tsconfig = array())
    {
        if (!in_array($type, $this->productShoppingAttributes)) {
            return false;
        }
        $configValue = $tsconfig[$type.'_allocation'];

        // Nothing selected
        if ($configValue == 'none') {
            return '';
        }
        $getType = explode('_', $configValue);
        // Product property
        if ($getType[0] == 'product') {
            // for example: product_ean13
            // Add atribute
            $property = str_replace('product_', '', $configValue);
            if (is_array($objProduct)) {
                $result = $objProduct[$property];
            } else {
                $result = $objProduct->$property;
            }
        // Product feature
        } elseif ($getType[0] == 'feature') {
            // for example: feature_2, getType[1] is id_feature
            $id_feature = $getType[1];
            if (is_array($objProduct)) {
                $prod_id = $objProduct['product_id'];
            } else {
                $prod_id = $objProduct->id;
            }
            $result = $this->getFeature($id_feature, $prod_id);
        }

        if (isset($result)) {
            return $result;
        }

        return false;
    }


    /**
     *  @desc  Get Currency of orders
     */
    private function getOrderCurrency($id_currency)
    {
        $query = new DbQuery();
        $query->select('iso_code');
        $query->from('currency');
        $query->where('id_currency='.(int)$id_currency);

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query->build());
    }
}

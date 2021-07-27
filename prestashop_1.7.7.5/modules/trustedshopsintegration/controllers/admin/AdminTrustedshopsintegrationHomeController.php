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

class AdminTrustedshopsintegrationHomeController extends AdminTrustedshopsintegrationDefaultController
{

    public function __construct()
    {
        parent::__construct();
        $this->name = 'trustedshopsintegration';
        $this->currentPage = 'home';
        $this->bootstrap = true;
        $this->meta_title = $this->l('Home');

        $this->template = 'index.tpl';
    }

    public function initContent()
    {
        parent::init();

        $this->content = $this->renderView();

        return parent::initContent();
    }
}

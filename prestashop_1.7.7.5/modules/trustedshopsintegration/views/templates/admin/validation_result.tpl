{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2016-2021 Trusted Shops GmbH SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

<div class="bootstrap">
    {foreach from=$errors key=k item=i}
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {$i|escape:'htmlall':'UTF-8'}
        </div>
    {/foreach}
</div>

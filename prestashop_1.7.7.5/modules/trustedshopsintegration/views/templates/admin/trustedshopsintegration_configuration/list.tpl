{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

<div class="trustedshops-back">
  <div class="main-menu-wrapper clearfix">
    {include file="../_partials/menu.tpl"}
  </div>

  <div class="content-wrapper full-width">
    {block name="content"}
      <div class="alert alert-info">
        <p>
          {{l s='Before accessing the module, you need to associate your Trusted Shops IDs with the proper Prestashop shops and languages.' mod='trustedshopsintegration'}|totlreplace}<br>
          {{l s='If your Trusted Shops IDs were to change, we would prompt you to associate them again.' mod='trustedshopsintegration'}|totlreplace}
        </p>
        <p>{{l s='You can go back to this page anytime, by clicking the [b]configure my shops[/b] button.' mod='trustedshopsintegration'}|totlreplace}</p>
      </div>

      {$content|escape:'quotes':'UTF-8'}
    {/block}
  </div>
</div>

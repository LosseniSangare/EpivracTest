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
      <div class="panel">
        <div class="panel-heading">
          <i class="icon-gear"></i> {l s='Shops configuration' mod='trustedshopsintegration'}
        </div>

        <div class="alert alert-info">
          <p>{l s='Before using the module, you need to associate your Trusted Shops IDs with the relevant PrestaShop shops and languages.' mod='trustedshopsintegration'}<br>
          {l s='If your Trusted Shops IDs change, we would prompt you to associate them again.' mod='trustedshopsintegration'}<br>
          {l s='If you need an additional Trusted Shops ID for one of your shops or languages, please get in touch with us.' mod='trustedshopsintegration'}
          </p>
          <p>{{l s='You can go back to this page anytime by clicking on the [b]"Configure my shops"[/b] button.' mod='trustedshopsintegration'}|totlreplace}</p>
        </div>

        <form method="POST" class="form-horizontal">
          <div class="form-group clearfix">
            <label class="control-label col-lg-3">{l s='Trusted Shops ID' mod='trustedshopsintegration'}</label>
            <div class="col-lg-9">
              <span class="form-control-plaintext">
                {$tsconfig->id_trusted_shops|escape:'htmlall':'UTF-8'}
              </span>
            </div>
          </div>

          <div class="form-group clearfix">
            <label class="control-label col-lg-3">{l s='Trusted Shops URL' mod='trustedshopsintegration'}</label>
            <div class="col-lg-9">
              <span class="form-control-plaintext">
                {$tsconfig->api_url|escape:'htmlall':'UTF-8'}
              </span>
            </div>
          </div>

          <div class="form-group clearfix">
            <label class="control-label col-lg-3">{l s='Trusted Shops language' mod='trustedshopsintegration'}</label>
            <div class="col-lg-9">
              <span class="form-control-plaintext">
                {$tsconfig->api_lang|escape:'htmlall':'UTF-8'}
              </span>
            </div>
          </div>

          <div class="form-group clearfix">
            <label class="control-label col-lg-3">{l s='PrestaShop Shop / Language' mod='trustedshopsintegration'}</label>
            <div class="col-lg-9">
              <select name="shop_lang" class="fixed-width-lg">
                <option value="">{l s='unassociated' mod='trustedshopsintegration'}</option>
                {foreach from=$possibleShopsLangs item=possibleShopsLang}
                <option value="{$possibleShopsLang.id_shop|escape:'htmlall':'UTF-8'}_{$possibleShopsLang.id_lang|escape:'htmlall':'UTF-8'}"{if $possibleShopsLang.id_shop == $tsconfig->id_shop && $possibleShopsLang.id_lang == $tsconfig->id_lang} selected="selected"{/if}>{$possibleShopsLang.shop_name|escape:'htmlall':'UTF-8'} - {$possibleShopsLang.lang_name|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
              </select>
            </div>
          </div>

          <div class="panel-footer">
            <button type="submit" class="btn btn-default pull-right" name="submit" value="submit"><i class="process-icon-save"></i> {l s='Save' mod='trustedshopsintegration'}</button>
            <button type="submit" class="btn btn-default pull-right" name="submit_and_stay" value="submit"><i class="process-icon-save"></i> {l s='Save and stay' mod='trustedshopsintegration'}</button>
          </div>
        </form>
      </div>
    {/block}
  </div>
</div>

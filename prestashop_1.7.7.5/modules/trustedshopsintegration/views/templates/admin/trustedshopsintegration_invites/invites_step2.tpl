{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}


{extends file='../layout.tpl'}

{block name="content"}
  {include file="../_partials/breadcrumb.tpl" step=2}

  <div class="panel">
    <div class="panel-heading">
      <i class="icon-envelope"></i> {l s='Preview invite email' mod='trustedshopsintegration'}
    </div>

    <form method="POST">

      <div class="form-group clearfix">
        <div class="alert alert-info">
          {l s='If you wish to edit the invite template, e.g. by adding your logo, please go directly to your My Trusted Shops account. Your changes will be saved and visible here.' mod='trustedshopsintegration'}
        </div>
      </div>

      <div class="form-group clearfix">
        <label class="control-label col-lg-3">{l s='This is how your invite email will look like' mod='trustedshopsintegration'}</label>
        <div class="col-lg-9">
          {$emailContent|escape:'quotes':'UTF-8'}
        </div>
      </div>

      <input type="hidden" name="invites_step" value="step3" />
      <input type="hidden" name="retrieve_reviews" value="{$retrieve_reviews|escape:'htmlall':'UTF-8'}" />
      <input type="hidden" name="orders_last" value="{$orders_last|escape:'htmlall':'UTF-8'}" />
      {foreach from=$payments item=payment}
        <input type="hidden" name="payments[]" value="{$payment|escape:'htmlall':'UTF-8'}" />
      {/foreach}

      <div class="panel-footer">
        <a class="btn btn-default" data-history-back="step1"><i class="process-icon-next icon-rotate-180"></i> {l s='Previous' mod='trustedshopsintegration'}</a>
        <button type="submit" class="btn btn-primary pull-right" name="submit_step"><i class="process-icon-next"></i> {l s='Next' mod='trustedshopsintegration'}</button>
      </div>

    </form>
  </div>
{/block}

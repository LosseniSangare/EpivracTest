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
  {include file="../_partials/breadcrumb.tpl" step=3}

  <div class="panel">
    <div class="panel-heading">
      <i class="icon-check"></i> {l s='Verify customers and orders' mod='trustedshopsintegration'}
    </div>

    <p class="h3 mt3 mb3"><span data-invites-number>{$orders|count}</span>
        {if $orders|count > 1}
            {l s='invite emails are ready to be sent.' mod='trustedshopsintegration'}
        {else}
            {l s='invite email is ready to be sent.' mod='trustedshopsintegration'}
        {/if}
    </p>

    <form method="POST">
      <div class="form-group clearfix">
        <label class="control-label">{l s='Select the customers you wish to send an invite to' mod='trustedshopsintegration'}</label>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><input type="checkbox" name="order0" value=0 data-select-all checked="checked"></th>
              <th>{l s='Email address' mod='trustedshopsintegration'}</th>
              <th>{l s='Name' mod='trustedshopsintegration'}</th>
              <th>{l s='Order' mod='trustedshopsintegration'}</th>
              <th>{l s='Order amount' mod='trustedshopsintegration'}</th>
              <th>{l s='Status' mod='trustedshopsintegration'}</th>
              <th>{l s='Date of order' mod='trustedshopsintegration'}</th>
              <th class="text-right">{l s='Preview' mod='trustedshopsintegration'}</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$orders item=order}
              <tr>
                <td><input type="checkbox" name="invites[]" value="{$order.id_order|escape:'htmlall':'UTF-8'}" data-input-to-select data-invites checked="checked"></td>
                <td>{$order.email|escape:'htmlall':'UTF-8'}</td>
                <td>{$order.firstname|escape:'htmlall':'UTF-8'} {$order.lastname|escape:'htmlall':'UTF-8'}</td>
                <td>{$order.reference|escape:'htmlall':'UTF-8'}</td>
                <td>{displayPrice price=$order.total_paid|escape:'htmlall':'UTF-8'}</td>
                <td>{$order.name|escape:'htmlall':'UTF-8'}</td>
                <td>{dateFormat date=$order.date_add|escape:'htmlall':'UTF-8' full=false}</td>
                <td class="text-right">
                  <a
                    class="btn btn-default btn-sm btn-icon"
                    data-toggle="modal"
                    data-target="#mail-preview-modal"
                    data-iframe-src="{$adminTsUrl.invites|escape:'htmlall':'UTF-8'}&ajax=1&id_order={$order.id_order|escape:'htmlall':'UTF-8'}&invites_step=preview&orders_last={$orders_last|escape:'htmlall':'UTF-8'}{foreach from=$payments item=payment}&payments[]={$payment|escape:'htmlall':'UTF-8'}{/foreach}"
                  >
                    <i class="icon-search"></i>
                  </a>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>

      <input type="hidden" name="invites_step" value="step4" />
      <input type="hidden" name="retrieve_reviews" value="{$retrieve_reviews|escape:'htmlall':'UTF-8'}" />
      <input type="hidden" name="orders_last" value="{$orders_last|escape:'htmlall':'UTF-8'}" />
      {foreach from=$payments item=payment}
        <input type="hidden" name="payments[]" value="{$payment|escape:'htmlall':'UTF-8'}" />
      {/foreach}

      <div class="panel-footer">
        <a class="btn btn-default" data-history-back="step2"><i class="process-icon-next icon-rotate-180"></i> {l s='Previous' mod='trustedshopsintegration'}</a>
        <button type="submit" class="btn btn-primary pull-right" name="submit_step"><i class="process-icon-next"></i> {l s='Next' mod='trustedshopsintegration'}</button>
      </div>

    </form>
  </div>

  <div id="mail-preview-modal" class="modal fade" role="dialog" style="display: none;">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
          <h4 class="modal-title">{l s='Mail preview' mod='trustedshopsintegration'}</h4>
        </div>

        <div class="modal-body p0">
          <iframe src="" frameborder="0" data-preview-iframe></iframe>
          <div data-preview-block></div>
        </div>
      </div>
    </div>
  </div>
{/block}

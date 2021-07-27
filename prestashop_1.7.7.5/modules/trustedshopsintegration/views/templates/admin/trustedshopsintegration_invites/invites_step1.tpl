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
  {include file="../_partials/breadcrumb.tpl" step=1}

  <div class="panel">
    <div class="panel-heading">
      <i class="icon-envelope"></i> {l s='Select orders' mod='trustedshopsintegration'}
    </div>
    <form class="form-horizontal" method="POST" action="{$adminTsUrl.invites|escape:'htmlall':'UTF-8'}">
      <input type="hidden" name="invites_step" value="step2" />

      <div class="alert alert-info">
        {{l s='Sending invite emails is the fastest way to get your first reviews.[br]Once you have configured which customers you want to ask for a review, we’ll send them an invite to write a review.' mod='trustedshopsintegration'}|totlreplace}
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3">{l s='Send invite emails to customers who placed an order during the last' mod='trustedshopsintegration'}</label>
        <div class="col-lg-9">
          <select class="fixed-width-lg" name="orders_last">
            <option value="182"{if $orders_last == 182} selected{/if}>{l s='Last 6 months' mod='trustedshopsintegration'}</option>
            <option value="152"{if $orders_last == 152} selected{/if}>{l s='Last 5 months' mod='trustedshopsintegration'}</option>
            <option value="121"{if $orders_last == 121} selected{/if}>{l s='Last 4 months' mod='trustedshopsintegration'}</option>
            <option value="91"{if $orders_last == 91} selected{/if}>{l s='Last 3 months' mod='trustedshopsintegration'}</option>
            <option value="60"{if $orders_last == 60} selected{/if}>{l s='Last 2 months' mod='trustedshopsintegration'}</option>
            <option value="30"{if $orders_last == 30 || $orders_last == false} selected{/if}>{l s='Last month' mod='trustedshopsintegration'}</option>
            <option value="21"{if $orders_last == 21} selected{/if}>{l s='Last 3 weeks' mod='trustedshopsintegration'}</option>
            <option value="14"{if $orders_last == 14} selected{/if}>{l s='Last 2 weeks' mod='trustedshopsintegration'}</option>
            <option value="7"{if $orders_last == 7} selected{/if}>{l s='Last week' mod='trustedshopsintegration'}</option>
          </select>
        </div>
      </div>

      <div class="form-group clearfix">
        <label class="control-label col-lg-3">{l s='Include product reviews' mod='trustedshopsintegration'}</label>
        <div class="col-lg-9">
          {radio_slide name='retrieve_reviews' on="{l s='Yes' mod='trustedshopsintegration'}" off={l s='No' mod='trustedshopsintegration'} value="true"}
          <div class="help-block">
            {l s='By selecting this, you will ask customers to review the product they bought as well.' mod='trustedshopsintegration'}
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-9 col-lg-push-3">
          <div class="alert alert-warning">
            {l s='Please note that we will send an invite for each order status selected.' mod='trustedshopsintegration'}
          </div>
        </div>
      </div>

      <div class="form-group clearfix">
        <label class="control-label col-lg-3">{l s='Select orders that have one of the following states' mod='trustedshopsintegration'}</label>
        <div class="col-lg-9 table-container">
          <div class="css-table bordered striped">
            <div class="tr thead">
              <div class="th center fixed-width-xs"><input type="checkbox" name="payment0" id="payment0" value="0" data-select-all></div>
              <div class="th"><label for="payment0"><b>{l s='Select all' mod='trustedshopsintegration'}</b></label></div>
            </div>

            <div class="tbody">
              {foreach from=$availableOrderStatus item=status}
                <div class="tr">
                  <div class="td center fixed-width-xs"><input type="checkbox" name="payments[]" id="payments_{$status.id_order_state|escape:'htmlall':'UTF-8'}" value="{$status.id_order_state|escape:'htmlall':'UTF-8'}" data-input-to-select></div>
                  <div class="td"><label for="payments_{$status.id_order_state|escape:'htmlall':'UTF-8'}">{$status.name|escape:'htmlall':'UTF-8'}</label></div>
                </div>
              {/foreach}
            </div>
          </div>
        </div>
      </div>

      <div class="panel-footer">
        <a class="btn btn-default" href="{$adminTsUrl.invites|escape:'htmlall':'UTF-8'}"><i class="process-icon-cancel"></i> {l s='Cancel' mod='trustedshopsintegration'}</a>
        <button type="submit" class="btn btn-primary pull-right" name="submit_step"><i class="process-icon-next"></i> {l s='Next' mod='trustedshopsintegration'}</button>
      </div>

    </form>
  </div>
{/block}

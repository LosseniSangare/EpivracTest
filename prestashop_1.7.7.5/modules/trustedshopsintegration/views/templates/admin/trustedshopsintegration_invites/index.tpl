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
  {* Automated invites *}
  <div class="panel">
    <div class="panel-heading">
      {l s='Automated Invites according to PrestaShop status' mod='trustedshopsintegration'}
    </div>

    <div class="alert alert-info">
      {{l s='Trusted Shops sends invite emails automatically 7 days after a customer has placed an order. Activating [b]Automated invites[/b] according to PrestaShop status enables you to send invite emails based on the order status of PrestaShop that you specified here (eg: if you specified "delivered" as the order status, the email will be sent after the order has reached the "delivered" status).This enables you to send out your invite emails at the best time possible to maximize your changes of receiving a great review.' mod='trustedshopsintegration'}|totlreplace}
    </div>

    <form class="form-horizontal" action="" method="POST">

      <div class="form-group clearfix">
        <label class="control-label col-lg-3">{{l s='Use Prestashop order status[br]to trigger invite emails' mod='trustedshopsintegration'}|totlreplace}</label>
        <div class="col-lg-9">
          {radio_slide name='trigger_reviews_active' value=$tsconfig->trigger_reviews_active|default:false dataAttr='toggle="orderstatus"' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
          <div class="help-block">
            {{l s='Please note that in order for this option to work properly, you need to change the standard settings in your My Trusted Shops account. Log in to your My Trusted Shops account and go to Reviews > Settings > Collecting reviews and activate "Review Trigger API". [br][br] Legal Notice: Legal compliance requires obtaining valid consent from every customer in order to transmit their email address to Trusted Shops.' mod='trustedshopsintegration'}|totlreplace}
          </div>
        </div>
      </div>

      {* Sub form, visible when this feature is active *}
      <div class="sub-form" data-orderstatus {if $tsconfig->trigger_reviews_active == false} style="display:none"{/if}>
        <div class="form-group">
          <div class="col-lg-9 col-lg-push-3">
            <div class="alert alert-warning">
              {l s='For this option to work properly, please change your password in PrestaShop as well, if you change your password in your My Trusted Shops account.' mod='trustedshopsintegration'}
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-3">{{l s='Trigger invite email[br]when the order status changes to' mod='trustedshopsintegration'}|totlreplace}</label>
          <div class="col-lg-9">
            <select class="fixed-width-lg" name="trigger_reviews_step" id="payment">
              {foreach from=$availableOrderStatus item=status}
              <option value="{$status.id_order_state|escape:'htmlall':'UTF-8'}"{if $tsconfig->trigger_reviews_step|default:$trigger_reviews_step == $status.id_order_state} selected="selected"{/if}>{$status.name|escape:'htmlall':'UTF-8'}</option>
              {/foreach}
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-3">{l s='Specify email delay for each carrier' mod='trustedshopsintegration'}</label>
          <div class="col-lg-9">
              <table class="table table-bordered table-striped">
                  <thead>
                <tr>
                    <th>{l s='Carrier name' mod='trustedshopsintegration'}</th>
                    <th>{l s='Shipping time' mod='trustedshopsintegration'}</th>
                    <th>{l s='Sent after X days' mod='trustedshopsintegration'}</th>
                </tr></thead>
                {foreach from=$carriers item=carrier}
                <tr>
                    <td>{$carrier.name|escape:'htmlall':'UTF-8'}</td>
                    <td>{$carrier.delay|escape:'htmlall':'UTF-8'}</td>
                    <td><input type="text" name="trigger_reviews_carriers[{$carrier.id_reference|escape:'htmlall':'UTF-8'}]" value="{$trigger_reviews_carriers[$carrier.id_reference]|default:3|escape:'htmlall':'UTF-8'}"></td>
                </tr>
                {/foreach}
              </table>
          </div>
        </div>

      </div>

        <div class="panel-footer">
          <button type="submit" class="btn btn-default pull-right" name="submit" value="submit"><i class="process-icon-save"></i> {l s='Save' mod='trustedshopsintegration'}</button>
          <button type="submit" class="btn btn-default pull-right" name="submit_and_stay" value="submit"><i class="process-icon-save"></i> {l s='Save and stay' mod='trustedshopsintegration'}</button>
        </div>
    </form>

  </div>

  {* Manual invites *}
  <div class="panel">
    <div class="panel-heading">
      {l s='Manual invites' mod='trustedshopsintegration'}
    </div>

    <div class="alert alert-info">
      {{l s='The feature "[b]Manual invites[/b]" enables you to get reviews quickly when you start using the module. It makes it possible for you to send a batch of invite emails to customers who have recently placed an order from your shop (up to 1,000 invites).[br][br]Legal notice: Legal compliance requires obtaining valid consent from every customer in order to transmit their email address to Trusted Shops.' mod='trustedshopsintegration'}|totlreplace}
    </div>

    <div class="text-center mt4 mb2">
      <a href="{$adminTsUrl.invites|escape:'htmlall':'UTF-8'}&invites_step=step1" class="btn btn-primary">{l s='Send invite emails to customers who have already placed an order' mod='trustedshopsintegration'}</a>
    </div>
  </div>
{/block}

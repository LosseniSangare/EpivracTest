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
  {include file="../_partials/breadcrumb.tpl" step=4}

  <div class="panel">
    <div class="panel-heading">
      <i class="icon-send"></i> {l s='Send invite emails' mod='trustedshopsintegration'}
    </div>

    <p class="h3 mt3 mb3">{$invites|count}
        {if $invites|count > 1}
            {{l s='invites are ready to be sent.' mod='trustedshopsintegration'}|totlreplace}
        {else}
            {{l s='invite are ready to be sent.' mod='trustedshopsintegration'}|totlreplace}
        {/if}</p>

{if $invites|count > 1}
    <p>{{l s='By clicking on the "Send" button, we will process your [b][nb] invites[/b] based on the settings you have just configured and ask your past customers to write a review. Go back to the previous step to edit your settings or click on send.' mod='trustedshopsintegration'}|totlreplace:['[nb]' => $invites|count]}</p>
{else}
    <p>{{l s='By clicking on the "Send" button, we will process your [b]invite[/b] based on the settings you have just configured and ask your past customers to write a review. Go back to the previous step to edit your settings or click on send.' mod='trustedshopsintegration'}|totlreplace:['[nb]' => $invites|count]}</p>
{/if}
    <form method="POST">
      <input type="hidden" name="invites_step" value="step5" />
      <input type="hidden" name="retrieve_reviews" value="{$retrieve_reviews|escape:'htmlall':'UTF-8'}" />
      <input type="hidden" name="orders_last" value="{$orders_last|escape:'htmlall':'UTF-8'}" />
      {foreach from=$payments item=payment}
        <input type="hidden" name="payments[]" value="{$payment|escape:'htmlall':'UTF-8'}" />
      {/foreach}
      {foreach from=$invites item=invite}
        <input type="hidden" name="invites[]" value="{$invite|escape:'htmlall':'UTF-8'}" />
      {/foreach}

      <div class="panel-footer">
        <a class="btn btn-default" data-history-back="step3"><i class="process-icon-next icon-rotate-180"></i> {l s='Previous' mod='trustedshopsintegration'}</a>
        <button type="submit" class="btn btn-primary pull-right" name="submit_step"><i class="process-icon-send"></i> {l s='Send' mod='trustedshopsintegration'}</button>
      </div>

    </form>
  </div>
{/block}

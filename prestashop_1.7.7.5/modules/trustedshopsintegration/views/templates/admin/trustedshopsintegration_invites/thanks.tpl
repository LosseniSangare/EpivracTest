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
  <div class="panel trial-confirm">
    <div class="confirm-message">
      <i class="icon-check-circle mb4"></i>
      <p>
        {if $invitesCount > 1}
            {{l s='Your request is confirmed.[br]We will proceed to send your [b][nb][/b] invites.' mod='trustedshopsintegration'}|totlreplace:['[nb]' => $invitesCount|escape:'htmlall':'UTF-8']}
        {else}
           {{l s='Your request is confirmed.[br]We will proceed to send your invite.' mod='trustedshopsintegration'}|totlreplace:['[nb]' => $invitesCount|escape:'htmlall':'UTF-8']}
        {/if}

      </p>
    </div>

    {if $trial == 'TRIAL'}
      <div class="trial-footer clearfix">
        <div class="left">
          <i class="icon-home"></i>
          <p>{l s='Go back to the home page.' mod='trustedshopsintegration'}</p>
          <a href="{$adminTsUrl.home|escape:'htmlall':'UTF-8'}" class="btn btn-primary">{l s='home' mod='trustedshopsintegration'}</a>
        </div>
        <div class="right">
          <i class="icon-desktop"></i>
          <p>{{l s='Continue the journey[br]and configure your Service Reviews.' mod='trustedshopsintegration'}|totlreplace}</p>
          <a href="{$adminTsUrl.site|escape:'htmlall':'UTF-8'}" class="btn btn-primary">{l s='Service Reviews' mod='trustedshopsintegration'}</a>
        </div>
      </div>
    {else}
      <div class="panel-footer panel-footer-sm clearfix">
        <a href="{$adminTsUrl.home|escape:'htmlall':'UTF-8'}" class="btn btn-default pull-right">{l s='Close' mod='trustedshopsintegration'}</a>
      </div>
    {/if}
  </div>
{/block}

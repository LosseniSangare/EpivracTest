{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

<div class="trustedshops-back">
    <div class="main-menu-wrapper clearfix">
        {include file="$self/admin/_partials/menu.tpl"}
    </div>

    <div class="content-wrapper">
        {* Left column - main content *}
        <div class="left-column">
            {block name="content"}{/block}
        </div>

        {* Right column *}
        <div class="right-column">
              {* User block *}
              {include file="$self/admin/_partials/user-block.tpl"}

              {* Onboarding block *}
              {if $trial == 'TRIAL'}
                  {include file="$self/admin/_partials/onboarding-block.tpl"}
              {/if}

              {* Logo *}
              <div class="logo-block">
                  <img class="logo" src="{$ts_img_dir|escape:'htmlall':'UTF-8'}logo_trusted-shops.png"
                       alt="{l s='Trusted Shops logo' mod='trustedshopsintegration'}">
              </div>
        </div>
    </div>
</div>

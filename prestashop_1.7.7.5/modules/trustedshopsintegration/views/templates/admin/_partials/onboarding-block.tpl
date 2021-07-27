{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

{* @TODO it would be really better to have this logic in php *}
{* and have proper objects on which we could loop on. *}
{* eg: slides = [
  {
    type: 'onbarding'
    isActive: true,
    icon: 'check-icon',
    title: 'title',
    description: 'description'
    cta: null
  }, ...
] *}
{assign var="activeEl" value='reviews'}
{if $tsconfig->tick_first_reviews}{assign var="activeEl" value='trustbadge'}{/if}
{if $tsconfig->tick_first_reviews && $tsconfig->tick_configure_trustedbadge}{assign var="activeEl" value='requests'}{/if}

{if $tsconfig->tick_first_reviews && $tsconfig->display_trustbadge && $tsconfig->collect_reviews}
  {assign var="isFinished" value=true}
{else}
  {assign var="isFinished" value=false}
{/if}

<div class="onboarding-block block {if $isFinished}finished{/if}">
  <div id="achievementsCarousel" class="carousel slide">
    {if !$isFinished}
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#achievementsCarousel" data-slide-to="0" {if $activeEl == 'reviews'}class="active"{/if}></li>
        <li data-target="#achievementsCarousel" data-slide-to="1" {if $activeEl == 'trustbadge'}class="active"{/if}></li>
        <li data-target="#achievementsCarousel" data-slide-to="2" {if $activeEl == 'requests'}class="active"{/if}></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        {* Card *}
        <div class="item {if $activeEl == 'reviews'}active{/if}" data-toggle-wizard="invites">
          <i class="icon icon-envelope"></i>
          <p class="header">{l s='Send Invites' mod='trustedshopsintegration'}</p>
          <p class="description">{l s='Sending invites helps you get customer reviews quickly.' mod='trustedshopsintegration'}</p>

          {if $tsconfig->tick_first_reviews}
            <span class="progress-status text-success v-align"><span>{l s='Completed' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
          {else}
            <span class="progress-status text-danger v-align"><span>{l s='Incomplete' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
          {/if}
        </div>

        {* Card *}
        <div class="item {if $activeEl == 'trustbadge'}active{/if}" data-toggle-wizard="site">
          <i class="icon icon-trophy"></i>
          <p class="header">{l s='Display Trustbadge®' mod='trustedshopsintegration'}</p>
          <p class="description">{l s='Configure the widget to display your reviews. This helps you boost your conversion rate!' mod='trustedshopsintegration'}</p>

          {if $tsconfig->display_trustbadge}
            <span class="progress-status text-success v-align"><span>{l s='Completed' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
          {else}
            <span class="progress-status text-danger v-align"><span>{l s='Incomplete' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
          {/if}
        </div>

        {* Card *}
        <div class="item {if $activeEl == 'requests'}active{/if}" data-toggle-wizard="products">
          <i class="icon icon-group"></i>
          <p class="header">{l s='Use Product reviews' mod='trustedshopsintegration'}</p>
          <p class="description">{l s='Collect and display reviews of your products.' mod='trustedshopsintegration'}</p>

          {if $tsconfig->collect_reviews}
            <span class="progress-status text-success v-align"><span>{l s='Completed' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
          {else}
            <span class="progress-status text-danger v-align"><span>{l s='Incomplete' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
          {/if}
        </div>
      </div>
    {else}{* $isFinished == true *}
      {* Finished state upgrade card *}
      <div class="item">
        <i class="icon icon-check-circle"></i>
        <p class="header">{l s='You\'re good to start!'  mod='trustedshopsintegration'}</p>
        <p class="description">
          {l s='You have fully configured the module.' mod='trustedshopsintegration'}
        </p>
        <a href="{get_multilang_var varName='upgrade-link'}" target="_blank" class="btn btn-block btn-cta">{l s='Upgrade' mod='trustedshopsintegration'}</a>
      </div>
    {/if}
  </div>
</div>

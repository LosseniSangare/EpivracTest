{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

<div class="panel">
  <div class="breadcrumb-block">
    <div class="progress-bar"></div>

    <div class="item{if $step == 1} active{else} complete{/if}">
      <span class="number" data-content="1"></span>
      <span class="title">{l s='Select' mod='trustedshopsintegration'}</span>
    </div>

    <div class="item{if $step == 2} active{/if}{if $step > 2} complete{/if}">
      <span class="number" data-content="2"></span>
      <span class="title">{l s='Preview' mod='trustedshopsintegration'}</span>
    </div>

    <div class="item{if $step == 3} active{/if}{if $step > 3} complete{/if}">
      <span class="number" data-content="3"></span>
      <span class="title">{l s='Verify' mod='trustedshopsintegration'}</span>
    </div>

    <div class="item{if $step == 4} active{/if}{if $step > 4} complete{/if}">
      <span class="number" data-content="4"></span>
      <span class="title">{l s='Send' mod='trustedshopsintegration'}</span>
    </div>
  </div>
</div>

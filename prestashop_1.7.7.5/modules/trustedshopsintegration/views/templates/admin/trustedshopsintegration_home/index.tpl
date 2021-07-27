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
  <div class="panel">
    <div class="panel-heading">
      <i class="icon-home"></i> {l s='Home' mod='trustedshopsintegration'}
    </div>

    {if $trial == 'TRIAL'}
      {include file="../home/home_content_trial.tpl"}
    {else}
      {include file="../home/home_content.tpl"}
    {/if}
  </div>
{/block}

{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

{if !isset($currentPage) || empty($currentPage)}
  {assign var="currentPage" value=null}
{/if}

<!-- Toggle get grouped for better mobile display -->
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse"
        aria-expanded="false">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</button>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="main-menu-collapse" data-main-menu>
    <ul class="main-menu nav navbar-nav">
        <li {if $currentPage == 'home'}class="active"{/if}><a href="{$adminTsUrl.home|escape:'htmlall':'UTF-8'}"><i class="icon-home"></i> {l s='Home' mod='trustedshopsintegration'}</a></li>
        <li {if $currentPage == 'invites'}class="active"{/if} data-wizard="invites"><a href="{$adminTsUrl.invites|escape:'htmlall':'UTF-8'}"><i class="icon-envelope"></i> {l s='Invites' mod='trustedshopsintegration'}</a></li>
        <li {if $currentPage == 'site'}class="active"{/if} data-wizard="site"><a href="{$adminTsUrl.site|escape:'htmlall':'UTF-8'}"><i class="icon-desktop"></i> {l s='Service reviews' mod='trustedshopsintegration'}</a></li>
        <li {if $currentPage == 'products'}class="active"{/if} data-wizard="products"><a href="{$adminTsUrl.products|escape:'htmlall':'UTF-8'}"><i class="icon-star"></i> {l s='Product reviews' mod='trustedshopsintegration'}</a></li>
    </ul>
</div>

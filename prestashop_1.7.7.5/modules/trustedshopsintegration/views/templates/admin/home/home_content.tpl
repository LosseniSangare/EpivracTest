{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

<div class="home home-content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-xs-12 col-sm-8">
        <div class="home-left-block">
          <h1>{{l s='Welcome back' mod='trustedshopsintegration'}|totlreplace} {$employee->firstname|default:''|escape:'htmlall':'UTF-8'} {$employee->lastname|default:''|escape:'htmlall':'UTF-8'}</h1>
          <p>{{l s='This is an overview of your settings. You can always see which features of the module you have already configured on this page.' mod='trustedshopsintegration'}|totlreplace}</p>
          <p>{{l s='If you have any trouble configuring our module, feel free to call us at :' mod='trustedshopsintegration'}|totlreplace}</p>
          <a href="tel:{get_multilang_var varName='phone-number'}" class="support-phone v-align"><i class="icon-phone"></i> <span>{get_multilang_var varName='phone-number'}</span></a>
        </div>
      </div>

      <div class="col-xs-12 col-sm-4">
        <ul class="home-right-block">

          <li data-toggle-wizard="site">
            <p>{{l s='Display Trustbadge' mod='trustedshopsintegration'}|totlreplace}</p>
            {if $tsconfig->display_trustbadge}
              <span class="progress-status text-success v-align"><span>{l s='Enabled' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
            {else}
              <span class="progress-status v-align"><span>{l s='Disabled' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
            {/if}
          </li>

          <li data-toggle-wizard="invites">
            <p>{l s='Use order state' mod='trustedshopsintegration'}</p>
            {if $tsconfig->trigger_reviews_active}
              <span class="progress-status text-success v-align"><span>{l s='Enabled' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
            {else}
              <span class="progress-status v-align"><span>{l s='Disabled' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
            {/if}
          </li>

          <li data-toggle-wizard="products">
            <p>{l s='Collect product reviews' mod='trustedshopsintegration'}</p>
            {if $tsconfig->collect_reviews}
              <span class="progress-status text-success v-align"><span>{l s='Enabled' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
            {else}
              <span class="progress-status v-align"><span>{l s='Disabled' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
            {/if}
          </li>

          <li data-toggle-wizard="site">
            <p>{l s='Display reviews sticker' mod='trustedshopsintegration'}</p>
            {if $tsconfig->display_shop_reviews}
              <span class="progress-status text-success v-align"><span>{l s='Enabled' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
            {else}
              <span class="progress-status v-align"><span>{l s='Disabled' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
            {/if}
          </li>
        </ul>
      </div>

    </div>
  </div>
</div>

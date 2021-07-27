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
          <h1>{l s='Welcome' mod='trustedshopsintegration'} {$employee->firstname|default:''|escape:'htmlall':'UTF-8'} {$employee->lastname|default:''|escape:'htmlall':'UTF-8'}</h1>

          <p>{{l s='We will guide you step by step through the module configuration.' mod='trustedshopsintegration'}|totlreplace}</p>
          <p>{{l s='In order for you to receive and display your first reviews as quickly as possible, we recommend that you start sending manual invites to your customers.' mod='trustedshopsintegration'}|totlreplace}</p>
          <a class="btn btn-primary" href="{$adminTsUrl.invites}&invites_step=step1">{{l s='Start sending invites' mod='trustedshopsintegration'}|totlreplace}</a>

          <p>{{l s='Next, configure your Trustbadge® to collect service and/or product reviews automatically. Then, you\'re all set!' mod='trustedshopsintegration'}|totlreplace}</p>
          <p>{{l s='If you have any trouble configuring our module, feel free to call us at :' mod='trustedshopsintegration'}|totlreplace}</p>
          <a href="tel:{get_multilang_var varName='phone-number-test'}" class="support-phone v-align"><i class="icon-phone"></i> <span>{get_multilang_var varName='phone-number-test'}</span></a>
        </div>
      </div>

      <div class="col-xs-12 col-sm-4">
        <ul class="home-right-block">
          <li data-toggle-wizard="invites">
            <p>{{l s='Send Invites' mod='trustedshopsintegration'}|totlreplace}</p>
            {if $tsconfig->tick_first_reviews}
              <span class="progress-status text-success v-align"><span>{l s='Completed' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
            {else}
              <span class="progress-status text-danger v-align"><span>{l s='Incomplete' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
            {/if}
          </li>

          <li data-toggle-wizard="site">
            <p>{{l s='Display Trustbadge®' mod='trustedshopsintegration'}|totlreplace}</p>
            {if $tsconfig->display_trustbadge}
              <span class="progress-status text-success v-align"><span>{l s='Completed' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
            {else}
              <span class="progress-status text-danger v-align"><span>{l s='Incomplete' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
            {/if}
          </li>

          <li data-toggle-wizard="products">
            <p>{{l s='Activate Product Reviews' mod='trustedshopsintegration'}|totlreplace}</p>
            {if $tsconfig->collect_reviews}
              <span class="progress-status text-success v-align"><span>{l s='Completed' mod='trustedshopsintegration'}</span> <i class="icon-ok-sign"></i></span>
            {else}
              <span class="progress-status text-danger v-align"><span>{l s='Incomplete' mod='trustedshopsintegration'}</span> <i class="icon-remove"></i></span>
            {/if}
          </li>
        </ul>
      </div>

    </div>
  </div>
</div>

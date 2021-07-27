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
  <div class="errors">
    {if isset($errors) && $errors|@count > 0}
      {foreach from=$errors item=error}
        <span>{$error|escape:'htmlall':'UTF-8'}</span><br/>
      {/foreach}
    {/if}
  </div>

  <div class="panel panel-thank-you">
    <div class="clearfix">
      <div class="container text-center">
        <div class="confirm-message">
          <i class="icon-thumbs-up mb4"></i>
          <p>
            {l s='Thank you for signing up.' mod='trustedshopsintegration'}
          </p>
        </div>

        <div class="message">
          <p>
            {l s='Just one more step and you are ready to start.' mod='trustedshopsintegration'}
          </p>

          <p class="list">
            <i class="icon-check-circle"></i>
            {l s='We\'ve sent you an email.' mod='trustedshopsintegration'}
          </p>

          <p class="list">
            <i class="icon-envelope"></i>
            {l s='Please go to your mailbox and click on the *activation button* to activate your account.' mod='trustedshopsintegration'}
          </p>

          <p class="small">
            {{l s='Didn‘t get any email from us?[br]Please check your spam folder or contact us at' mod='trustedshopsintegration'}|replace:'[br]':'<br>'} {get_multilang_var varName='phone-number-test'}.
          </p>
        </div>
      </div>
    </div>

    <div class="panel-footer panel-footer-sm clearfix">
      <a href="{$adminTsUrl.home|escape:'htmlall':'UTF-8'}&ts_logout=true" class="btn btn-link">{l s='Log out' mod='trustedshopsintegration'}</a>
    </div>
  </div>
</div>

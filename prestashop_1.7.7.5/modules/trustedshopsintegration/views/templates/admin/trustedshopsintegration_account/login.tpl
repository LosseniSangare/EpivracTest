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
  <div class="panel panel-sign-in">
    {* Sign in *}
    <div class="sign-in clearfix" {if isset($ts_page) && ($ts_page == "create" || $ts_page == "expiredTrial")}style="display: none;"{/if} data-sign-in>
      {* Form *}
      <form method="POST">
        <img class="logo" src="{$ts_img_dir|escape:'htmlall':'UTF-8'}logo_trusted-shops.png" alt="Trusted Shops logo">

        <h2 class="text-center">{{l s='Create your account' mod='trustedshopsintegration'}|totlreplace}</h2>

        <a class="btn btn-block btn-cta mb4" href={{l s='https://business.trustedshops.com/en/pricing' mod='trustedshopsintegration'}|totlreplace} data-toggle-trial>{{l s='Sign up now' mod='trustedshopsintegration'}|totlreplace}</a>

        <hr class="or" data-text="{l s='Or' mod='trustedshopsintegration'}">

        <p class="small text-center mt3 mb3">
          {{l s='Do you already have an account?' mod='trustedshopsintegration'}|totlreplace}<br/>
          {{l s='Please insert your "My Trusted Shops" credentials:' mod='trustedshopsintegration'}|totlreplace}
        </p>

        <div class="form-group">
          <label class="label-control">{l s='Email address' mod='trustedshopsintegration'}</label>
          <input class="form-control" type="email" name="ts_login_email" value="" />
        </div>

        <div class="form-group mb3">
          <label class="label-control">{l s='Password' mod='trustedshopsintegration'}</label>
          <input class="form-control" type="password" name="ts_login_password" value="" />
          <div class="help-block text-center">
            <a href="{get_multilang_var varName='forgotten-password-link'}" target="_blank">{{l s='Forgot your password?' mod='trustedshopsintegration'}|totlreplace}</a>
          </div>
        </div>

        <input class="btn btn-primary btn-block" type="submit" name="submit_ts_infos" value="{{l s='Sign in' mod='trustedshopsintegration'}|totlreplace}" />
      </form>

      {* Aside image + contact *}
      <aside class="aside pos-a">
        <div class="pos-r">
          <img src="{$ts_img_dir|escape:'htmlall':'UTF-8'}{get_multilang_var varName='sign-in-image'}">

          <div class="bubble">
            <span>{{l s='Call us on:' mod='trustedshopsintegration'}|totlreplace}</span><br>
            <span><i class="icon icon-phone"></i>{get_multilang_var varName='phone-number-test'}</span>
          </div>

          <div class="info">
            <span class="title">
              {{l s='Trusted Shops Reviews' mod='trustedshopsintegration'}|totlreplace}
            </span>
            <span class="baseline">
              {{l s='The best way to display your customers reviews on the internet and in-store.' mod='trustedshopsintegration'}|totlreplace}
            </span>
          </div>
        </div>
      </aside>
    </div>
    
  </div>
</div>

{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}
<div class="user-block block">
    <div class="user-header">
        <div class="holder clearfix">
            <span><i class="icon-user"></i> <span>{$employee->firstname|default:''|escape:'htmlall':'UTF-8'} {$employee->lastname|default:''|escape:'htmlall':'UTF-8'}</span></span>
            <a href="{$adminTsUrl.account|escape:'htmlall':'UTF-8'}&ts_logout=true" class="logout" title="{l s='logout' mod='trustedshopsintegration'}"><i class="icon-signout"></i></a>
        </div>
    </div>

    <div class="user-content">
        <div class="holder">
            <label for="user-select">
                <span data-toggle="tooltip" title="{l s='Select the shop you want to configure. If you are missing one in the list, please go to \"Configure my shops\".' mod='trustedshopsintegration'}">
                    {l s='My shops' mod='trustedshopsintegration'} <i class="icon-info-sign"></i>
                </span>
            </label>
            <select name="id_ts_config" id="id_ts_config" class="custom-select">
                {foreach from=$TSIDs item=TSID}
                    <option value="{$TSID.id_ts_config|escape:'htmlall':'UTF-8'}"{if $TSID.id_ts_config == $tsconfig->id_ts_config|default:''} selected="selected"{/if}>{$TSID.shopname|escape:'htmlall':'UTF-8'} ({$TSID.langname|escape:'htmlall':'UTF-8'})</option>
                {/foreach}
            </select>
            <a href="{$adminTsUrl.configuration|escape:'htmlall':'UTF-8'}" class="btn btn-default btn-block btn-sm mb1">
                <i class="icon-gear"></i> <span>{l s='Configure my shops' mod='trustedshopsintegration'}</span>
            </a>
            <div class="link-wrapper">
                <a href="{get_multilang_var varName='seo-profile-link' langID=$tsconfig->id_lang|escape:'htmlall':'UTF-8' tsid=$tsconfig->id_trusted_shops|escape:'htmlall':'UTF-8'}" target="_blank">{l s='My SEO profile' mod='trustedshopsintegration'}</a>
            </div>
        </div>
    </div>

    <div class="user-footer">
        <div class="holder">
            {if $trial == 'TRIAL'}
                <p class="trial-title">{l s='Upgrade' mod='trustedshopsintegration'}</p>
            {/if}

            {if $trial == 'TRIAL'}
                {assign var='phoneType' value='phone-number-test'}
            {else}
                {assign var='phoneType' value='phone-number'}
            {/if}
            <a href="tel:{get_multilang_var varName=$phoneType}" class="trial-phone v-align"><i class="icon-phone"></i> <span>{get_multilang_var varName=$phoneType}</span></a>
        </div>
    </div>
</div>

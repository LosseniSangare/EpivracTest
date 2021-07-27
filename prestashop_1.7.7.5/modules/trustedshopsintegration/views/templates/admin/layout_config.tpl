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
                <span>{$error|escape:'htmlall':'UTF-8'}</span>
                <br/>
            {/foreach}
        {/if}
    </div>

    <div class="content-wrapper">
        {* Left column - main content *}
        <div class="left-column">
            {block name="content"}{/block}
        </div>
    </div>
</div>

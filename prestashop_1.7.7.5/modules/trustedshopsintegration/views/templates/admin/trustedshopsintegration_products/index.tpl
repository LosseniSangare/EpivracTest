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
      <i class="icon-star"></i> {l s='Product Reviews' mod='trustedshopsintegration'}
    </div>

    <form class="form-horizontal" method="POST">
      <div class="form-wrapper">
        <div class="alert alert-info">
            {l s='The Product Reviews option displays the product reviews (if you collect them) in a new tab into your product description.' mod='trustedshopsintegration'}<br>
            {l s='You can also display stars below the product title.' mod='trustedshopsintegration'}
        </div>
        <div class="form-group clearfix">
          <label class="control-label col-lg-3" for="myinput">{l s='Collect product reviews' mod='trustedshopsintegration'}</label>
          <div class="col-lg-9">
            {radio_slide name='collect_reviews' value=$tsconfig->collect_reviews|escape:'htmlall':'UTF-8' dataAttr='toggle="collect-reviews"' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
            <div class="help-block">
              {l s='Activate this setting in order to display any product review.' mod='trustedshopsintegration'}
            </div>
          </div>
        </div>

        <div data-collect-reviews {if !$tsconfig->collect_reviews}style="display: none;"{/if}>
          <hr>

          <div class="form-group clearfix">
            <label class="control-label col-lg-3" for="myinput">{l s='Display product reviews in an additional tab' mod='trustedshopsintegration'}</label>
            <div class="col-lg-9">
              {radio_slide name='show_reviews' value=$tsconfig->show_reviews|escape:'htmlall':'UTF-8' dataAttr='toggle="additional-tab"' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
            </div>
          </div>

          <div data-additional-tab {if !$tsconfig->show_reviews}style="display: none;"{/if}>
            <div class="form-group clearfix emphasis">
              <label class="control-label col-lg-3" for="myinput">{l s='Use advanced configuration' mod='trustedshopsintegration'}</label>
              <div class="col-lg-9">
                {radio_slide name='products_reviews_advanced_configuration' value=($tsconfig->products_reviews_advanced_configuration == 1) dataAttr='toggle-advanced="additional-tab"' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
              </div>
            </div>

            <div data-additional-tab-advanced="off" {if $tsconfig->products_reviews_advanced_configuration == 1}style="display: none;"{/if}>
              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="">{l s='Border color' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  {input_color name='review_tab_border_color' value={$tsconfig->review_tab_border_color|escape:'htmlall':'UTF-8'}}
                </div>
              </div>

              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="">{l s='Stars color' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  {input_color name='review_tab_star_color' value={$tsconfig->review_tab_star_color|escape:'htmlall':'UTF-8'}}
                </div>
              </div>

              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="">{l s='Background color' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  {input_color name='review_tab_background_color' value={$tsconfig->review_tab_background_color|escape:'htmlall':'UTF-8'}}
                </div>
              </div>
            </div>

            <div data-additional-tab-advanced="on"{if $tsconfig->products_reviews_advanced_configuration != 1} style="display: none;"{/if}>
              <div class="alert alert-warning">
                {{l s='You are in the advanced configuration mode. This option is for advanced users only.[br]It allows you to define a maximum height, place a custom intro text and more.[br]Learn more about the Product Reviews Sticker options [a]here[/a].' mod='trustedshopsintegration'}|totlreplace:['@href@' => {get_multilang_var varName='review-link'}]}
              </div>

              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="myinput">{l s='Product reviews configuration code' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  <textarea name="product_sticker_code" class="form-control code-input">{$tsconfig->product_sticker_code|prettyJSON|escape:'htmlall':'UTF-8'}</textarea>
                </div>
              </div>
            </div>

            <div class="form-group clearfix">
              <label class="control-label col-lg-3">{l s='Reviews tab name' mod='trustedshopsintegration'}</label>
              <div class="col-lg-9">
                <input class="form-control fixed-width-lg" type="text" name="review_tab_name" placeholder="{l s='Trusted Shops Reviews' mod='trustedshopsintegration'}" value="{$tsconfig->review_tab_name|escape:'htmlall':'UTF-8'}">
              </div>
            </div>
{*** Not possible due to Trustedshops javascript
            <div class="form-group clearfix">
              <label class="control-label col-lg-3" for="myinput">{l s='Hide sticker if empty' mod='trustedshopsintegration'}</label>
              <div class="col-lg-9">
                {radio_slide name='hide_empty_reviews' value=$tsconfig->hide_empty_reviews|escape:'htmlall':'UTF-8' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
                <div class="help-block">
                  {l s='If this setting is on, we hide the Product Reviews Sticker if there are no reviews to display.' mod='trustedshopsintegration'}
                </div>
              </div>
            </div>
**}
          </div>
          <hr>

          <div class="form-group clearfix">
            <label class="control-label col-lg-3" for="myinput">{l s='Display rating stars below product title' mod='trustedshopsintegration'}</label>
            <div class="col-lg-9">
              {radio_slide name='show_rating' value=$tsconfig->show_rating dataAttr='toggle="rating-stars"' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
            </div>
          </div>

          <div data-rating-stars{if !$tsconfig->show_rating} style="display: none;"{/if}>
            <div class="form-group clearfix emphasis">
              <label class="control-label col-lg-3" for="myinput">{l s='Use advanced configuration' mod='trustedshopsintegration'}</label>
              <div class="col-lg-9">
                {radio_slide name='rating_stars_advanced_configuration' value=($tsconfig->rating_stars_advanced_configuration == 1) dataAttr='toggle-advanced="rating-stars"' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
              </div>
            </div>

            <div data-rating-stars-advanced="off"{if $tsconfig->rating_stars_advanced_configuration == 1} style="display: none;"{/if}>
              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="">{l s='Stars color' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  {input_color name='rating_star_color' value={$tsconfig->rating_star_color|escape:'htmlall':'UTF-8'}}
                </div>
              </div>

              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="myinput2">{l s='Stars size' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  <div class="input-group fixed-width-lg">
                    <span class="input-group-addon">px</span>
                    <input class="form-control" id="myinput2" type="text" name="rating_star_size" value="{$tsconfig->rating_star_size|escape:'htmlall':'UTF-8'}">
                  </div>
                </div>
              </div>

              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="myinput2">{l s='Font size' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  <div class="input-group fixed-width-lg">
                    <span class="input-group-addon">px</span>
                    <input class="form-control" id="myinput2" type="text" name="rating_font_size" value="{$tsconfig->rating_font_size|escape:'htmlall':'UTF-8'}">
                  </div>
                </div>
              </div>
                <div class="form-group clearfix">
                  <label class="control-label col-lg-3" for="myinput">{l s='Hide sticker if empty' mod='trustedshopsintegration'}</label>
                  <div class="col-lg-9">
                    {radio_slide name='hide_empty_ratings' value=$tsconfig->hide_empty_ratings|escape:'htmlall':'UTF-8' on="{l s='Yes' mod='trustedshopsintegration'}" off="{l s='No' mod='trustedshopsintegration'}"}
                    <div class="help-block">
                      {l s='If this setting is on, we hide the stars block when there is no review do display.' mod='trustedshopsintegration'}
                    </div>
                  </div>
                </div>
            </div>

            <div data-rating-stars-advanced="on" {if $tsconfig->rating_stars_advanced_configuration != 1}style="display: none;"{/if}>
              <div class="alert alert-warning">
                {{l s='You are in the advanced configuration mode. This option is for advanced users only.[br]It allows you to define a [b]custom placeholder[/b] and more.[br]Learn more about the stars options [a]here[/a].' mod='trustedshopsintegration'}|totlreplace:['@href@' => {get_multilang_var varName='review-link'}]}
              </div>

              <div class="form-group clearfix">
                <label class="control-label col-lg-3" for="myinput">{l s='Rating stars configuration code' mod='trustedshopsintegration'}</label>
                <div class="col-lg-9">
                  <textarea name="product_widget_code" class="form-control code-input">{$tsconfig->product_widget_code|prettyJSON|escape:'htmlall':'UTF-8'}</textarea>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="form-group clearfix">
            <label class="control-label col-lg-3" for="myinput">{l s='MPN Prestashop field' mod='trustedshopsintegration'}</label>
            <div class="col-lg-9">
              <select class="form-control fixed-width-lg" name="mpn_allocation">
                <option value="product_upc" {if $tsconfig->mpn_allocation == 'product_upc'}selected{/if}>{l s='Product property: UPC' mod='trustedshopsintegration'}</option>
                {foreach from=$MPNProductFeatures item=feature}
                    {assign var="mpn_allocation" value="_"|explode:$tsconfig->mpn_allocation}
                    <option value="feature_{$feature.id_feature|escape:'htmlall':'UTF-8'}" {if isset($mpn_allocation.1) && $mpn_allocation.1 == {$feature.id_feature|escape:'htmlall':'UTF-8'}}selected{/if}>{l s='Feature:' mod='trustedshopsintegration'} {$feature.name|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
              </select>
              <div class="help-block">
                {{l s='By default, Prestashop does not have an MPN (Manufacturer Product Number) field. If you have it as a custom field in your shop, please select it here.[br]This MPN field is very useful for Google Shopping and will increase your data analysis possibilities.' mod='trustedshopsintegration'}|totlreplace}
              </div>
            </div>
          </div>
        </div>

        <div class="panel-footer text-center">
          <button type="submit" class="btn btn-default pull-right" name="submitOptionsimage_type"><i class="process-icon-save"></i> {l s='Save' mod='trustedshopsintegration'}</button>
          <button type="submit" class="btn btn-default pull-right" name="submitOptionsimage_type_stay"><i class="process-icon-save"></i> {l s='Save and stay' mod='trustedshopsintegration'}</button>
        </div>

      </div>
    </form>
  </div>
{/block}

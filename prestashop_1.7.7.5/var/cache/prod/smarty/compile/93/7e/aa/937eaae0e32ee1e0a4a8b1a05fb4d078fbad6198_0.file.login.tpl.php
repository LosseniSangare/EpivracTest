<?php
/* Smarty version 3.1.39, created on 2021-07-27 12:02:13
  from '/var/www/html/prestashop_1.7.7.5/modules/trustedshopsintegration/views/templates/admin/trustedshopsintegration_account/login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60ffd9a5c5c7a2_12638751',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '937eaae0e32ee1e0a4a8b1a05fb4d078fbad6198' => 
    array (
      0 => '/var/www/html/prestashop_1.7.7.5/modules/trustedshopsintegration/views/templates/admin/trustedshopsintegration_account/login.tpl',
      1 => 1627380122,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60ffd9a5c5c7a2_12638751 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/prestashop_1.7.7.5/modules/trustedshopsintegration/smarty/plugins/modifier.totlreplace.php','function'=>'smarty_modifier_totlreplace',),1=>array('file'=>'/var/www/html/prestashop_1.7.7.5/modules/trustedshopsintegration/smarty/plugins/function.get_multilang_var.php','function'=>'smarty_function_get_multilang_var',),));
?>

<div class="trustedshops-back">
  <div class="panel panel-sign-in">
        <div class="sign-in clearfix" <?php if ((isset($_smarty_tpl->tpl_vars['ts_page']->value)) && ($_smarty_tpl->tpl_vars['ts_page']->value == "create" || $_smarty_tpl->tpl_vars['ts_page']->value == "expiredTrial")) {?>style="display: none;"<?php }?> data-sign-in>
            <form method="POST">
        <img class="logo" src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ts_img_dir']->value,'htmlall','UTF-8' ));?>
logo_trusted-shops.png" alt="Trusted Shops logo">

        <h2 class="text-center"><?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Create your account','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable1 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable1);?>
</h2>

        <a class="btn btn-block btn-cta mb4" href=<?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'https://business.trustedshops.com/en/pricing','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable2 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable2);?>
 data-toggle-trial><?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sign up now','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable3 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable3);?>
</a>

        <hr class="or" data-text="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Or','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );?>
">

        <p class="small text-center mt3 mb3">
          <?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Do you already have an account?','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable4 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable4);?>
<br/>
          <?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please insert your "My Trusted Shops" credentials:','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable5 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable5);?>

        </p>

        <div class="form-group">
          <label class="label-control"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email address','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );?>
</label>
          <input class="form-control" type="email" name="ts_login_email" value="" />
        </div>

        <div class="form-group mb3">
          <label class="label-control"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Password','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );?>
</label>
          <input class="form-control" type="password" name="ts_login_password" value="" />
          <div class="help-block text-center">
            <a href="<?php echo smarty_function_get_multilang_var(array('varName'=>'forgotten-password-link'),$_smarty_tpl);?>
" target="_blank"><?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Forgot your password?','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable6 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable6);?>
</a>
          </div>
        </div>

        <input class="btn btn-primary btn-block" type="submit" name="submit_ts_infos" value="<?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sign in','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable7 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable7);?>
" />
      </form>

            <aside class="aside pos-a">
        <div class="pos-r">
          <img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ts_img_dir']->value,'htmlall','UTF-8' ));
echo smarty_function_get_multilang_var(array('varName'=>'sign-in-image'),$_smarty_tpl);?>
">

          <div class="bubble">
            <span><?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Call us on:','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable8 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable8);?>
</span><br>
            <span><i class="icon icon-phone"></i><?php echo smarty_function_get_multilang_var(array('varName'=>'phone-number-test'),$_smarty_tpl);?>
</span>
          </div>

          <div class="info">
            <span class="title">
              <?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Trusted Shops Reviews','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable9 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable9);?>

            </span>
            <span class="baseline">
              <?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The best way to display your customers reviews on the internet and in-store.','mod'=>'trustedshopsintegration'),$_smarty_tpl ) );
$_prefixVariable10 = ob_get_clean();
echo smarty_modifier_totlreplace($_prefixVariable10);?>

            </span>
          </div>
        </div>
      </aside>
    </div>
    
  </div>
</div>
<?php }
}

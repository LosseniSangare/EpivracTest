<?php
/* Smarty version 3.1.39, created on 2021-07-27 12:12:02
  from '/var/www/html/prestashop_1.7.7.5/themes/classic/templates/catalog/_partials/product-additional-info.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60ffdbf2591068_10701105',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3db75da845b95df7bf85ba908c3efca4cac96b6a' => 
    array (
      0 => '/var/www/html/prestashop_1.7.7.5/themes/classic/templates/catalog/_partials/product-additional-info.tpl',
      1 => 1627002966,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60ffdbf2591068_10701105 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="product-additional-info">
  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductAdditionalInfo','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl ) );?>

</div>
<?php }
}

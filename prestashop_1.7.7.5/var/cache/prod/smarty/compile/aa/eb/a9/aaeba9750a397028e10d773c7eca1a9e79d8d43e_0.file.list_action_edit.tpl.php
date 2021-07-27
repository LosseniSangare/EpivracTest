<?php
/* Smarty version 3.1.39, created on 2021-07-27 12:25:17
  from '/var/www/html/prestashop_1.7.7.5/admin534repnl2/themes/default/template/helpers/list/list_action_edit.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60ffdf0d734091_00414436',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aaeba9750a397028e10d773c7eca1a9e79d8d43e' => 
    array (
      0 => '/var/www/html/prestashop_1.7.7.5/admin534repnl2/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1627002964,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60ffdf0d734091_00414436 (Smarty_Internal_Template $_smarty_tpl) {
?><a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['href']->value,'html','UTF-8' ));?>
" title="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['action']->value,'html','UTF-8' ));?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['action']->value,'html','UTF-8' ));?>

</a>
<?php }
}

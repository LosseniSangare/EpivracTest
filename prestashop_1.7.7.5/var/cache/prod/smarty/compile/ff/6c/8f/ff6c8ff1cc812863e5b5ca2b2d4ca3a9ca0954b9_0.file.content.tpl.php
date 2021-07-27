<?php
/* Smarty version 3.1.39, created on 2021-07-27 12:02:46
  from '/var/www/html/prestashop_1.7.7.5/admin534repnl2/themes/default/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60ffd9c62d5e08_77963779',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff6c8ff1cc812863e5b5ca2b2d4ca3a9ca0954b9' => 
    array (
      0 => '/var/www/html/prestashop_1.7.7.5/admin534repnl2/themes/default/template/content.tpl',
      1 => 1627002964,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60ffd9c62d5e08_77963779 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="ajax_confirmation" class="alert alert-success hide"></div>
<div id="ajaxBox" style="display:none"></div>

<div class="row">
	<div class="col-lg-12">
		<?php if ((isset($_smarty_tpl->tpl_vars['content']->value))) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div>
<?php }
}

<?php
/* Smarty version 3.1.39, created on 2021-07-27 12:11:58
  from '/var/www/html/prestashop_1.7.7.5/themes/classic/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60ffdbee60aaf8_93413572',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46e7e3b0b2e065b9ab6e95aa2882af6a7802f4c3' => 
    array (
      0 => '/var/www/html/prestashop_1.7.7.5/themes/classic/templates/index.tpl',
      1 => 1627002966,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60ffdbee60aaf8_93413572 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11119446360ffdbee6098d8_68259580', 'page_content_container');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'page_content_top'} */
class Block_8550138160ffdbee609b61_92227101 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'hook_home'} */
class Block_50428537660ffdbee60a188_43814522 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>

          <?php
}
}
/* {/block 'hook_home'} */
/* {block 'page_content'} */
class Block_213669355860ffdbee609f55_20789078 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_50428537660ffdbee60a188_43814522', 'hook_home', $this->tplIndex);
?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_11119446360ffdbee6098d8_68259580 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content_container' => 
  array (
    0 => 'Block_11119446360ffdbee6098d8_68259580',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_8550138160ffdbee609b61_92227101',
  ),
  'page_content' => 
  array (
    0 => 'Block_213669355860ffdbee609f55_20789078',
  ),
  'hook_home' => 
  array (
    0 => 'Block_50428537660ffdbee60a188_43814522',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-home">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8550138160ffdbee609b61_92227101', 'page_content_top', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_213669355860ffdbee609f55_20789078', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
}

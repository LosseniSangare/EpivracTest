<?php
/* Smarty version 3.1.39, created on 2021-07-27 12:11:58
  from '/var/www/html/prestashop_1.7.7.5/themes/classic/templates/page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60ffdbee60e2d2_90269655',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a890eab7b1b8a3f10200f84fcf09801f583046b9' => 
    array (
      0 => '/var/www/html/prestashop_1.7.7.5/themes/classic/templates/page.tpl',
      1 => 1627002966,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60ffdbee60e2d2_90269655 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_151917407760ffdbee60c0f0_35022362', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value);
}
/* {block 'page_title'} */
class Block_20184132260ffdbee60c650_18452726 extends Smarty_Internal_Block
{
public $callsChild = 'true';
public $hide = 'true';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <header class="page-header">
          <h1><?php 
$_smarty_tpl->inheritance->callChild($_smarty_tpl, $this);
?>
</h1>
        </header>
      <?php
}
}
/* {/block 'page_title'} */
/* {block 'page_header_container'} */
class Block_152459715260ffdbee60c378_81251122 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20184132260ffdbee60c650_18452726', 'page_title', $this->tplIndex);
?>

    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content_top'} */
class Block_159051650260ffdbee60d1a2_27819363 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'page_content'} */
class Block_158526035560ffdbee60d4f0_60497713 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Page content -->
        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_87043210860ffdbee60cf67_38512640 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-content card card-block">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_159051650260ffdbee60d1a2_27819363', 'page_content_top', $this->tplIndex);
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_158526035560ffdbee60d4f0_60497713', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer'} */
class Block_22595420760ffdbee60dc56_05643256 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Footer content -->
        <?php
}
}
/* {/block 'page_footer'} */
/* {block 'page_footer_container'} */
class Block_24818457060ffdbee60da33_40400082 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <footer class="page-footer">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_22595420760ffdbee60dc56_05643256', 'page_footer', $this->tplIndex);
?>

      </footer>
    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_151917407760ffdbee60c0f0_35022362 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_151917407760ffdbee60c0f0_35022362',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_152459715260ffdbee60c378_81251122',
  ),
  'page_title' => 
  array (
    0 => 'Block_20184132260ffdbee60c650_18452726',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_87043210860ffdbee60cf67_38512640',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_159051650260ffdbee60d1a2_27819363',
  ),
  'page_content' => 
  array (
    0 => 'Block_158526035560ffdbee60d4f0_60497713',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_24818457060ffdbee60da33_40400082',
  ),
  'page_footer' => 
  array (
    0 => 'Block_22595420760ffdbee60dc56_05643256',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_152459715260ffdbee60c378_81251122', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_87043210860ffdbee60cf67_38512640', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_24818457060ffdbee60da33_40400082', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}

<?= render_form_header('item_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('functions','object_item_edit') ?>
    <?= render_form_input('auth_item_name',null,array(),true);?>
    <?= render_form_input('auth_item_desc',null,array(),true);?>
    <?=render_select_with_options('default_value',_v('auth_item_name'),true)?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
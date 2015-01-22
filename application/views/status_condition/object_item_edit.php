<?= render_form_header('item_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('status_condition','object_item_edit') ?>
    <?= render_input_with_options('auth_value',_v('auth_item_name'),null,true,false,null,false,true,false)?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
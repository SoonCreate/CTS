<?= render_form_header('auth_item_edit');?>
    <div class="container-fluid userd">
        <?= render_form_open('auth_object','item_edit') ?>
        <?= render_form_input('auth_item_name',false,array(),true);?>
        <?= render_form_input('auth_item_desc',false,array(),true);?>
        <?= render_select_add_options('default_value',render_options(_v('auth_item_name'),null,true),true)?>
        <?= render_form_hidden('id');?>
        <?= render_button_group();?>
        <?= render_form_close() ?>
    </div>

<?= render_form_header('auth_item_edit');?>
    <div class="container-fluid userd">
        <?= render_form_open('auth_object','item_edit') ?>
        <?= render_form_input('auth_item_name',false,true);?>
        <?= render_form_input('auth_item_desc',false,true);?>
        <?= render_input_with_options('default_value',_v('auth_item_name'),null,true,false,null,true,true)?>
        <?= render_form_hidden('id');?>
        <?= render_button_group();?>
        <?= render_form_close() ?>
    </div>

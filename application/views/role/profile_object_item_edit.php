<?= render_form_header('item_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('role','profile_object_item_edit') ?>
    <?= render_form_combobox('auth_value',$auth_data,TRUE,'value','label',true);?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
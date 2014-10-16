<?= render_form_open('role','profile_object_item_edit') ?>
<?= render_form_header('item_edit');?>
<?= render_form_input('auth_value',TRUE);?>
<?= render_form_hidden('id',v('id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
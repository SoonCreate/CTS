<?= render_form_open('role','edit') ?>
<?= render_form_header('role_edit');?>
<?= render_form_input('role_name',null,array(),TRUE);?>
<?= render_form_input('description',TRUE);?>
<?= render_form_hidden('id',v('id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>

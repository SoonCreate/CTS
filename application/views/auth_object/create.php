<?= render_form_header('auth_object_create');?>
<?= render_form_open('auth_object','create') ?>
<?= render_form_input('object_name',true);?>
<?= render_form_input('description',true);?>
<?= render_button_group();?>
<?= render_form_close() ?>
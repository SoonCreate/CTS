<?= render_form_open('functions','create') ?>
<?= render_form_header('function_create');?>
<?= render_form_input('function_name',true);?>
<?= render_form_input('controller',true);?>
<?= render_form_input('action',true);?>
<?= render_form_input('description',true);?>
<?= render_single_checkbox('display_flag',1);?>
<?= render_form_input('display_class');?>
<?= render_form_textarea('help');?>
<?= render_button_group();?>
<?= render_form_close() ?>



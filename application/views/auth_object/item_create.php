<?= render_form_header('auth_item_create');?>
<?= render_form_open('auth_object','item_create') ?>
<?= render_select_with_options('valuelist_id','vl_authobject')?>
<?= render_form_input('default_value',true);?>
<?= render_form_hidden('object_id');?>
<?= render_button_group();?>
<?= render_form_close() ?>
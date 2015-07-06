<?= render_form_input('description',true)?>
<?= render_select_with_options('group_id','vl_form_groups',true)?>
<?= render_select_with_options('table_name','vl_tables',true)?>
<?= render_form_textArea('help') ?>
<?= render_submit_button()?>
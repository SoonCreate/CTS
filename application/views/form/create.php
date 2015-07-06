<?= render_form_header('form_create');?>
<div class="container-fluid userd">
    <?= render_form_open('form','form_create') ?>
    <?= render_select_with_options('group_id','vl_form_groups',true)?>
    <?= render_select_with_options('table_name','vl_tables',true)?>
    <?= render_form_input('form_name',true)?>
    <?= render_form_input('description',true)?>
    <?= render_form_textArea('help') ?>
    <?= render_submit_button()?>
    <?= render_form_close() ?>
</div>
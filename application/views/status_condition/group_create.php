<?= render_form_header('status_condition_group_create') ?>
<div class="container-fluid userd">
    <?= render_form_open('status_condition','group_create') ?>
    <?= render_form_input('group_name',true) ?>
    <?= render_form_hidden('status_line_id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>

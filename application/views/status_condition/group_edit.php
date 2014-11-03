<?= render_form_header('status_condition_group_edit') ?>
<div class="container-fluid userd">
    <?= render_form_open('status','condition_group_edit') ?>
    <?= render_form_input('group_name',true) ?>
    <?= render_form_hidden('id',_v('id')) ?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>

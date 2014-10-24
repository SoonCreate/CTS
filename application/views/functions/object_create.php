<?= render_form_header('object_create');?>
<div class="container-fluid userd">
    <?= render_form_open('functions','object_create') ?>
    <?= render_select_with_options('object_id','vl_auth_object',true)?>
    <?= render_form_hidden('function_id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>

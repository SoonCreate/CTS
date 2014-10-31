<?= render_form_header('add_object');?>
<div class="container-fluid userd">
    <?= render_form_open('status','add_object') ?>
    <?= render_select_with_options('object_id','vl_authority_objects',true)?>
    <?= render_form_hidden('status_line_id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
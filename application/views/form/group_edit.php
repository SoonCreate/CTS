<?= render_form_header('form_group_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('form','form_group_edit') ?>
    <?= render_form_input('name',true,true)?>
    <?= render_form_input('description',true)?>
    <?= render_form_hidden('id')?>
    <?= render_submit_button()?>
    <?= render_form_close() ?>
</div>
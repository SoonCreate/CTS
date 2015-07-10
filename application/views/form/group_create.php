<?= render_form_header('form_group_create');?>
<div class="container-fluid userd">
    <?= render_form_open('form','form_group_create') ?>
    <?= render_form_input('name',true)?>
    <?= render_form_input('description',true)?>
    <?= render_submit_button()?>
    <?= render_form_close() ?>
</div>
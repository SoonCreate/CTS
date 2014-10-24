<?= render_form_header('status_edit') ?>
<div class="container-fluid userd">
    <?= render_form_open('status','create') ?>
    <?= render_form_input('status_code') ?>
    <?= render_form_input('description',true) ?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>

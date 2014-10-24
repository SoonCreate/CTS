<?= render_form_header('message_edit') ?>
<div class="container-fluid userd">
    <?= render_form_open('messages','edit') ?>
    <?= render_form_input('message_code',null,array(),TRUE);?>
    <?= render_form_input('content',TRUE);?>
    <?= render_form_input('language',TRUE);?>
    <?= render_form_textarea('help');?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>

<?= render_form_header('message_create')?>
<div class="container-fluid userd">
    <?= render_form_open('messages','create') ?>
    <?= render_form_input('message_code',TRUE) ?>
    <?= render_form_input('content',TRUE) ?>
    <?= render_form_textarea('help') ?>
    <?= render_form_hidden('class_id', v('class_id')) ?>
    <?= render_button_group() ?>
    <?= render_form_close() ?>
</div>
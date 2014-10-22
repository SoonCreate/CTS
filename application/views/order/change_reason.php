<?= render_form_open('order','change_reason','null','null','closeDialogAndRefresh') ?>
<?= render_form_textarea('reason',TRUE);?>
<?= render_form_hidden('change_hash',v('change_hash'));?>
<?= render_submit_button();?>
<?= render_form_close() ?>

